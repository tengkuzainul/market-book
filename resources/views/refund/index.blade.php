@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light p-3">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Refund Requests</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">My Refund Requests</h5>
                    </div>
                    <div class="card-body">
                        @if ($refunds->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Refund Amount</th>
                                            <th>Date Requested</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($refunds as $refund)
                                            <tr>
                                                <td>{{ $refund->pesanan->kode_pesanan }}</td>
                                                <td>Rp. {{ number_format($refund->jumlah, 0, ',', '.') }}</td>
                                                <td>{{ $refund->created_at->format('d M Y H:i') }}</td>
                                                <td>
                                                    @if ($refund->status == 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @elseif($refund->status == 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif($refund->status == 'rejected')
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @elseif($refund->status == 'completed')
                                                        <span class="badge bg-primary">Completed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('refunds.show', $refund) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $refunds->links() }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                <p class="mb-0">You don't have any refund requests yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
