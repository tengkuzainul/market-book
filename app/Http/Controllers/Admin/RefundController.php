<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MutasiBarang;
use App\Models\Pesanan;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RefundController extends Controller
{
          /**
           * Display a listing of the refunds
           */
          public function index()
          {
                    $refunds = Refund::with('pesanan', 'user')->latest()->paginate(10);
                    return view('admin.refund.index', compact('refunds'));
          }

          /**
           * Show the detail of a refund
           */
          public function show(Refund $refund)
          {
                    $refund->load('pesanan.items.buku', 'user');
                    return view('admin.refund.show', compact('refund'));
          }

          /**
           * Process a refund request
           */
          public function process(Request $request, Refund $refund)
          {
                    $request->validate([
                              'status' => 'required|in:selesai,ditolak',
                              'catatan_admin' => 'nullable|string|max:500',
                    ]);

                    DB::transaction(function () use ($request, $refund) {
                              // Update the refund status
                              $refund->status = $request->status;
                              $refund->catatan_admin = $request->catatan_admin;
                              $refund->save();

                              // If completed (selesai), update the order status and restore stock
                              if ($request->status == 'selesai') {
                                        $refund->pesanan->status = 'refunded';
                                        $refund->pesanan->save();

                                        // Restore stock for each item and record mutasi
                                        foreach ($refund->pesanan->items as $item) {
                                                  MutasiBarang::catatMutasi(
                                                            $item->buku_id,
                                                            'retur',
                                                            $item->jumlah,
                                                            'Refund pesanan ' . $refund->pesanan->kode_pesanan,
                                                            $refund,
                                                            Auth::id()
                                                  );
                                        }
                              } elseif ($request->status == 'ditolak') {
                                        // If rejected (ditolak), revert the order status to "dibatalkan" only
                                        $refund->pesanan->status = 'dibatalkan';
                                        $refund->pesanan->save();
                              }
                    });

                    $statusText = $request->status == 'selesai' ? 'disetujui dan selesai' : 'ditolak';
                    Alert::success('Berhasil', 'Refund telah ' . $statusText);
                    return redirect()->route('admin.refunds.index');
          }

          /**
           * Upload proof of refund
           */
          public function uploadProof(Request $request, Refund $refund)
          {
                    $request->validate([
                              'bukti_refund' => 'required|image|max:2048',
                    ]);

                    if ($request->hasFile('bukti_refund')) {
                              $file = $request->file('bukti_refund');
                              $fileName = time() . '.' . $file->getClientOriginalExtension();

                              // Move the file to the public directory
                              $file->move(public_path('image/bukti_refund'), $fileName);

                              // Update the refund record
                              $refund->bukti_refund = 'image/bukti_refund/' . $fileName;
                              $refund->status = 'selesai';
                              $refund->save();

                              // Update the order status
                              $refund->pesanan->status = 'refunded';
                              $refund->pesanan->save();

                              Alert::success('Success', 'Proof of refund has been uploaded');
                    }

                    return redirect()->route('admin.refunds.show', $refund);
          }
}
