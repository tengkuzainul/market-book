@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light p-3">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('refunds.index') }}">Refund Requests</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Refund Details</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Refund Request for Order #{{ $refund->pesanan->kode_pesanan }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Refund Information</h6>
                                <p><strong>Request Date:</strong> {{ $refund->created_at->format('d M Y H:i') }}</p>
                                <p><strong>Amount:</strong> Rp. {{ number_format($refund->jumlah, 0, ',', '.') }}</p>
                                <p>
                                    <strong>Status:</strong>
                                    @if ($refund->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($refund->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($refund->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @elseif($refund->status == 'completed')
                                        <span class="badge bg-primary">Completed</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Refund Method</h6>
                                <p><strong>Method:</strong> {{ ucfirst(str_replace('_', ' ', $refund->metode_refund)) }}</p>
                                <p><strong>Bank:</strong> {{ $refund->nama_bank }}</p>
                                <p><strong>Account Number:</strong> {{ $refund->nomor_rekening }}</p>
                                <p><strong>Account Holder:</strong> {{ $refund->nama_pemilik_rekening }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6>Reason for Cancellation</h6>
                            <div class="p-3 bg-light rounded">
                                {{ $refund->alasan_pembatalan }}
                            </div>
                        </div>

                        @if ($refund->catatan_admin)
                            <div class="mb-4">
                                <h6>Admin Notes</h6>
                                <div class="p-3 bg-light rounded">
                                    {{ $refund->catatan_admin }}
                                </div>
                            </div>
                        @endif

                        @if ($refund->bukti_refund)
                            <div class="mb-4">
                                <h6>Refund Proof</h6>
                                <div class="mt-2">
                                    <img src="{{ asset($refund->bukti_refund) }}" class="img-fluid border"
                                        style="max-height: 400px;" alt="Proof of Refund">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Order Date:</strong> {{ $refund->pesanan->created_at->format('d M Y H:i') }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($refund->pesanan->status) }}</p>
                        <p><strong>Total Amount:</strong> Rp.
                            {{ number_format($refund->pesanan->total_harga, 0, ',', '.') }}</p>

                        <h6 class="mt-4">Items:</h6>
                        <ul class="list-group">
                            @foreach ($refund->pesanan->items as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item->buku->judul }}
                                    <span class="badge bg-primary rounded-pill">{{ $item->jumlah }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-4">
                            <a href="{{ route('orders.show', $refund->pesanan) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i> View Original Order
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
