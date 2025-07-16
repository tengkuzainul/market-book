<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use App\Models\Buku;
use App\Models\MutasiBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangMasuks = BarangMasuk::with(['buku', 'user', 'approver'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.barang_masuk.index', [
            'pageName' => 'Manajemen Barang Masuk',
            'currentPage' => 'Barang Masuk',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'route' => route('dashboard')],
                ['name' => 'Barang Masuk', 'route' => route('admin.barang-masuk.index')]
            ],
            'barangMasuks' => $barangMasuks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bukus = Buku::where('status', 'published')->orderBy('judul')->get();

        return view('admin.barang_masuk.create', [
            'pageName' => 'Tambah Barang Masuk',
            'currentPage' => 'Barang Masuk',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'route' => route('dashboard')],
                ['name' => 'Barang Masuk', 'route' => route('admin.barang-masuk.index')],
                ['name' => 'Tambah Barang Masuk', 'route' => route('admin.barang-masuk.create')]
            ],
            'bukus' => $bukus
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_masuk' => 'required|date'
        ]);

        $totalHarga = $request->jumlah * $request->harga_beli;

        $barangMasuk = BarangMasuk::create([
            'kode_barang_masuk' => BarangMasuk::generateKodeBarangMasuk(),
            'buku_id' => $request->buku_id,
            'jumlah' => $request->jumlah,
            'harga_beli' => $request->harga_beli,
            'total_harga' => $totalHarga,
            'supplier' => $request->supplier,
            'keterangan' => $request->keterangan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'user_id' => Auth::id()
        ]);

        Alert::success('Berhasil', 'Data barang masuk berhasil ditambahkan');
        return redirect()->route('admin.barang-masuk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangMasuk $barangMasuk)
    {
        $barangMasuk->load(['buku', 'user', 'approver', 'mutasiBarangs']);

        return view('admin.barang_masuk.show', [
            'pageName' => 'Detail Barang Masuk',
            'currentPage' => 'Barang Masuk',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'route' => route('dashboard')],
                ['name' => 'Barang Masuk', 'route' => route('admin.barang-masuk.index')],
                ['name' => 'Detail', 'route' => route('admin.barang-masuk.show', $barangMasuk)]
            ],
            'barangMasuk' => $barangMasuk
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangMasuk $barangMasuk)
    {
        // Hanya bisa edit jika status masih pending
        if ($barangMasuk->status !== 'pending') {
            Alert::error('Gagal', 'Hanya barang masuk dengan status pending yang dapat diedit');
            return redirect()->route('admin.barang-masuk.index');
        }

        $bukus = Buku::where('status', 'published')->orderBy('judul')->get();

        return view('admin.barang_masuk.edit', [
            'pageName' => 'Edit Barang Masuk',
            'currentPage' => 'Barang Masuk',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'route' => route('dashboard')],
                ['name' => 'Barang Masuk', 'route' => route('admin.barang-masuk.index')],
                ['name' => 'Edit', 'route' => route('admin.barang-masuk.edit', $barangMasuk)]
            ],
            'barangMasuk' => $barangMasuk,
            'bukus' => $bukus
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        // Hanya bisa update jika status masih pending
        if ($barangMasuk->status !== 'pending') {
            Alert::error('Gagal', 'Hanya barang masuk dengan status pending yang dapat diedit');
            return redirect()->route('admin.barang-masuk.index');
        }

        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_masuk' => 'required|date'
        ]);

        $totalHarga = $request->jumlah * $request->harga_beli;

        $barangMasuk->update([
            'buku_id' => $request->buku_id,
            'jumlah' => $request->jumlah,
            'harga_beli' => $request->harga_beli,
            'total_harga' => $totalHarga,
            'supplier' => $request->supplier,
            'keterangan' => $request->keterangan,
            'tanggal_masuk' => $request->tanggal_masuk
        ]);

        Alert::success('Berhasil', 'Data barang masuk berhasil diperbarui');
        return redirect()->route('admin.barang-masuk.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangMasuk $barangMasuk)
    {
        // Hanya bisa hapus jika status pending atau rejected
        if (!in_array($barangMasuk->status, ['pending', 'rejected'])) {
            Alert::error('Gagal', 'Hanya barang masuk dengan status pending atau rejected yang dapat dihapus');
            return redirect()->route('admin.barang-masuk.index');
        }

        $barangMasuk->delete();

        Alert::success('Berhasil', 'Data barang masuk berhasil dihapus');
        return redirect()->route('admin.barang-masuk.index');
    }

    /**
     * Approve barang masuk
     */
    public function approve(Request $request, BarangMasuk $barangMasuk)
    {
        if ($barangMasuk->status !== 'pending') {
            Alert::error('Gagal', 'Hanya barang masuk dengan status pending yang dapat disetujui');
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            // Update status barang masuk
            $barangMasuk->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id()
            ]);

            // Catat mutasi barang (otomatis update stok)
            MutasiBarang::catatMutasi(
                $barangMasuk->buku_id,
                'masuk',
                $barangMasuk->jumlah,
                "Barang masuk disetujui - {$barangMasuk->kode_barang_masuk}",
                $barangMasuk,
                Auth::id()
            );

            DB::commit();

            Alert::success('Berhasil', 'Barang masuk berhasil disetujui dan stok telah diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    /**
     * Reject barang masuk
     */
    public function reject(Request $request, BarangMasuk $barangMasuk)
    {
        if ($barangMasuk->status !== 'pending') {
            Alert::error('Gagal', 'Hanya barang masuk dengan status pending yang dapat ditolak');
            return redirect()->back();
        }

        $barangMasuk->update([
            'status' => 'rejected',
            'approved_by' => Auth::id()
        ]);

        Alert::success('Berhasil', 'Barang masuk berhasil ditolak');
        return redirect()->back();
    }
}
