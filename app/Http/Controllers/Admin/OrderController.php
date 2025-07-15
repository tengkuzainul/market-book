<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanan = Pesanan::with(['user', 'rekeningPembayaran'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.orders.index', [
            'pageName' => 'Manajemen Pesanan',
            'currentPage' => 'Pesanan',
            'pesanan' => $pesanan
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pesanan = Pesanan::with(['items', 'rekeningPembayaran', 'user'])
            ->findOrFail($id);

        return view('admin.orders.show', [
            'pageName' => 'Detail Pesanan',
            'currentPage' => 'Pesanan',
            'pesanan' => $pesanan
        ]);
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:diproses,disetujui,dikemas,diantarkan,selesai,dibatalkan',
            'catatan' => 'nullable|string',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        $oldStatus = $pesanan->status;
        $newStatus = $request->status;

        // Validate the status change
        if ($oldStatus === 'dibatalkan' || $oldStatus === 'selesai') {
            Alert::error('Gagal', 'Status pesanan yang dibatalkan atau selesai tidak dapat diubah');
            return redirect()->back();
        }

        // Check if bukti pembayaran exists if status is changed to disetujui
        if ($newStatus === 'disetujui' && !$pesanan->bukti_pembayaran) {
            Alert::error('Gagal', 'Bukti pembayaran belum diupload');
            return redirect()->back();
        }

        $pesanan->update([
            'status' => $newStatus,
            'catatan' => $request->catatan ?? $pesanan->catatan,
        ]);

        Alert::success('Berhasil', 'Status pesanan berhasil diperbarui');
        return redirect()->route('admin.orders.show', $id);
    }
}
