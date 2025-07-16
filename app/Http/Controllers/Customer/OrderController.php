<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Keranjang;
use App\Models\MutasiBarang;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\RekeningPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanan = Pesanan::with('items')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.orders.index', [
            'pageName' => 'Pesanan Saya',
            'pesanan' => $pesanan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string|min:10',
            'rekening_pembayaran_id' => 'required|exists:rekening_pembayarans,id',
            'catatan' => 'nullable|string',
        ]);

        // Get cart items
        $cartItems = Keranjang::with('buku')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            Alert::error('Gagal', 'Keranjang Anda kosong');
            return redirect()->route('customer.cart.index');
        }

        // Check if all books are available
        foreach ($cartItems as $item) {
            if ($item->jumlah > $item->buku->stok) {
                Alert::error('Gagal', "Stok {$item->buku->judul} tidak mencukupi");
                return redirect()->route('customer.cart.index');
            }
        }

        // Start transaction
        DB::beginTransaction();

        try {
            // Calculate total
            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item->subtotal;
            }

            // Create order
            $pesanan = Pesanan::create([
                'kode_pesanan' => Pesanan::generateKodePesanan(),
                'user_id' => Auth::id(),
                'total_harga' => $total,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'rekening_pembayaran_id' => $request->rekening_pembayaran_id,
                'status' => 'diproses',
                'catatan' => $request->catatan,
            ]);

            // Create order items and record mutations
            foreach ($cartItems as $item) {
                $pesananItem = PesananItem::create([
                    'pesanan_id' => $pesanan->id,
                    'buku_id' => $item->buku_id,
                    'judul_buku' => $item->buku->judul,
                    'harga' => $item->buku->harga,
                    'jumlah' => $item->jumlah,
                    'subtotal' => $item->subtotal,
                ]);

                // Record mutasi barang (otomatis update stok)
                MutasiBarang::catatMutasi(
                    $item->buku_id,
                    'keluar',
                    $item->jumlah,
                    "Penjualan - {$pesanan->kode_pesanan}",
                    $pesanan,
                    Auth::id()
                );
            }

            // Empty the cart
            Keranjang::where('user_id', Auth::id())->delete();

            DB::commit();

            Alert::success('Berhasil', 'Pesanan berhasil dibuat, silakan upload bukti pembayaran');
            return redirect()->route('customer.orders.show', $pesanan->id);
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Gagal', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->route('customer.cart.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pesanan = Pesanan::with(['items', 'rekeningPembayaran'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customer.orders.show', [
            'pageName' => 'Detail Pesanan',
            'pesanan' => $pesanan
        ]);
    }

    /**
     * Upload bukti pembayaran for an order.
     */
    public function uploadBuktiPembayaran(Request $request, string $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pesanan = Pesanan::where('user_id', Auth::id())->findOrFail($id);

        if ($pesanan->status !== 'diproses') {
            Alert::error('Gagal', 'Bukti pembayaran hanya bisa diupload untuk pesanan dengan status diproses');
            return redirect()->back();
        }

        if ($request->hasFile('bukti_pembayaran')) {
            // Delete old file if exists
            if ($pesanan->bukti_pembayaran && file_exists(public_path($pesanan->bukti_pembayaran))) {
                unlink(public_path($pesanan->bukti_pembayaran));
            }

            // Generate file name
            $file = $request->file('bukti_pembayaran');
            $fileName = 'bukti_pembayaran_' . $pesanan->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Move file to public directory
            $file->move(public_path('image/bukti_pembayaran'), $fileName);

            // Path to save in database
            $filePath = 'image/bukti_pembayaran/' . $fileName;

            // Update order
            $pesanan->update([
                'bukti_pembayaran' => $filePath
            ]);

            Alert::success('Berhasil', 'Bukti pembayaran berhasil diupload');
        }

        return redirect()->route('customer.orders.show', $id);
    }

    /**
     * Cancel an order.
     */
    public function cancel(string $id)
    {
        $pesanan = Pesanan::where('user_id', Auth::id())->findOrFail($id);

        if ($pesanan->status !== 'diproses') {
            Alert::error('Gagal', 'Hanya pesanan dengan status diproses yang dapat dibatalkan');
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            // Restore stock with mutation record
            foreach ($pesanan->items as $item) {
                // Record mutasi barang untuk pengembalian stok
                MutasiBarang::catatMutasi(
                    $item->buku_id,
                    'retur',
                    $item->jumlah,
                    "Pembatalan pesanan - {$pesanan->kode_pesanan}",
                    $pesanan,
                    Auth::id()
                );
            }

            // Update order status
            $pesanan->update([
                'status' => 'dibatalkan'
            ]);

            DB::commit();
            Alert::success('Berhasil', 'Pesanan berhasil dibatalkan. Anda dapat mengajukan pengembalian dana.');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('customer.orders.show', $id);
    }

    /**
     * Confirm an order has been received by customer.
     */
    public function complete(string $id)
    {
        $pesanan = Pesanan::where('user_id', Auth::id())->findOrFail($id);

        if ($pesanan->status !== 'diantarkan') {
            Alert::error('Gagal', 'Hanya pesanan dengan status diantarkan yang dapat diselesaikan');
            return redirect()->back();
        }

        $pesanan->update([
            'status' => 'selesai'
        ]);

        Alert::success('Berhasil', 'Pesanan telah diselesaikan');
        return redirect()->route('customer.orders.index');
    }
}
