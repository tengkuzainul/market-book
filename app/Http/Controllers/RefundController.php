<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RefundController extends Controller
{
          /**
           * Show the refund request form
           */
          public function create(Pesanan $pesanan)
          {
                    // Check if the order belongs to the authenticated user
                    if ($pesanan->user_id !== Auth::id()) {
                              Alert::error('Error', 'You are not authorized to view this page');
                              return redirect()->route('home');
                    }

                    // Check if the order is in a valid state for refund
                    if (!in_array($pesanan->status, ['dibatalkan'])) {
                              Alert::error('Error', 'Pesanan ini tidak dapat di-refund');
                              return redirect()->route('customer.orders.show', $pesanan);
                    }

                    // Check if a refund request already exists
                    if ($pesanan->refund) {
                              Alert::info('Info', 'A refund request already exists for this order');
                              return redirect()->route('refunds.show', $pesanan->refund);
                    }

                    return view('refund.create', compact('pesanan'));
          }

          /**
           * Store a new refund request
           */
          public function store(Request $request, Pesanan $pesanan)
          {
                    // Check if the order belongs to the authenticated user
                    if ($pesanan->user_id !== Auth::id()) {
                              Alert::error('Error', 'You are not authorized to perform this action');
                              return redirect()->route('home');
                    }

                    // Validate the request
                    $request->validate([
                              'metode_refund' => 'required|string|in:bank_transfer',
                              'nama_bank' => 'required|string|max:255',
                              'nomor_rekening' => 'required|string|max:255',
                              'nama_pemilik_rekening' => 'required|string|max:255',
                              'alasan_pembatalan' => 'required|string|max:500',
                    ]);

                    // Create a new refund request
                    $refund = new Refund([
                              'user_id' => Auth::id(),
                              'pesanan_id' => $pesanan->id,
                              'jumlah' => $pesanan->total_harga,
                              'metode_refund' => $request->metode_refund,
                              'nomor_rekening' => $request->nomor_rekening,
                              'nama_pemilik_rekening' => $request->nama_pemilik_rekening,
                              'nama_bank' => $request->nama_bank,
                              'status' => 'diproses', // Menggunakan 'diproses' sesuai definisi enum
                              'alasan_pembatalan' => $request->alasan_pembatalan,
                    ]);

                    $refund->save();

                    Alert::success('Berhasil', 'Permintaan refund berhasil diajukan');
                    return redirect()->route('refunds.show', $refund);
          }

          /**
           * Show the refund details
           */
          public function show(Refund $refund)
          {
                    // Check if the refund belongs to the authenticated user
                    if ($refund->user_id !== Auth::id()) {
                              Alert::error('Error', 'You are not authorized to view this page');
                              return redirect()->route('home');
                    }

                    $refund->load('pesanan.items.buku');
                    return view('refund.show', compact('refund'));
          }

          /**
           * List all refunds for the authenticated user
           */
          public function index()
          {
                    $refunds = Refund::where('user_id', Auth::id())
                              ->with('pesanan')
                              ->latest()
                              ->paginate(10);

                    return view('refund.index', compact('refunds'));
          }
}
