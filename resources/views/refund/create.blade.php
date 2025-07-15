@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light p-3">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('orders.show', $pesanan) }}">Order
                                #{{ $pesanan->kode_pesanan }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Request Refund</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Request Refund for Order #{{ $pesanan->kode_pesanan }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('refunds.store', $pesanan) }}" method="POST">
                            @csrf

                            <div class="alert alert-info">
                                <h5>Refund Amount:</h5>
                                <h3>Rp. {{ number_format($pesanan->total_harga, 0, ',', '.') }}</h3>
                            </div>

                            <div class="form-group mb-3">
                                <label for="metode_refund">Refund Method</label>
                                <select class="form-control @error('metode_refund') is-invalid @enderror"
                                    name="metode_refund" id="metode_refund" required>
                                    <option value="">Select Refund Method</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                                @error('metode_refund')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="nama_bank">Bank Name</label>
                                <input type="text" class="form-control @error('nama_bank') is-invalid @enderror"
                                    id="nama_bank" name="nama_bank" value="{{ old('nama_bank') }}" required>
                                @error('nama_bank')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="nomor_rekening">Account Number</label>
                                <input type="text" class="form-control @error('nomor_rekening') is-invalid @enderror"
                                    id="nomor_rekening" name="nomor_rekening" value="{{ old('nomor_rekening') }}" required>
                                @error('nomor_rekening')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="nama_pemilik_rekening">Account Holder Name</label>
                                <input type="text"
                                    class="form-control @error('nama_pemilik_rekening') is-invalid @enderror"
                                    id="nama_pemilik_rekening" name="nama_pemilik_rekening"
                                    value="{{ old('nama_pemilik_rekening') }}" required>
                                @error('nama_pemilik_rekening')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="alasan_pembatalan">Reason for Cancellation</label>
                                <textarea class="form-control @error('alasan_pembatalan') is-invalid @enderror" id="alasan_pembatalan"
                                    name="alasan_pembatalan" rows="4" required>{{ old('alasan_pembatalan') }}</textarea>
                                @error('alasan_pembatalan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Submit Refund Request</button>
                                <a href="{{ route('orders.show', $pesanan) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Order Date:</strong> {{ $pesanan->created_at->format('d M Y H:i') }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($pesanan->status) }}</p>
                        <p><strong>Total Amount:</strong> Rp. {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>

                        <h6 class="mt-4">Items:</h6>
                        <ul class="list-group">
                            @foreach ($pesanan->items as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item->buku->judul }}
                                    <span class="badge bg-primary rounded-pill">{{ $item->jumlah }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
