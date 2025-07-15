<x-layouts.admin.dashboard :pageName="$pageName ?? 'Refund Requests Management'" :currentPage="$currentPage ?? 'Refund'" :breadcrumbs="$breadcrumbs ?? []">
    <div class="col-md-12 col-xl-12">
        @if (Session::has('success') || Session::has('error'))
            <div class="alert alert-{{ Session::has('success') ? 'success' : 'danger' }} alert-dismissible fade show mb-3"
                role="alert">
                <i class="ti ti-{{ Session::has('success') ? 'circle-check' : 'alert-circle' }} me-2"></i>
                <strong>{{ Session::has('success') ? 'Berhasil!' : 'Gagal!' }}</strong>
                {{ Session::get('success') ?? Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card profile-wave-card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="d-flex align-items-center">
                            <div class="ms-2">
                                <h5>{{ $pageName ?? 'Refund Requests Management' }}</h5>
                                <p class="mb-0">Data Table List Permintaan Refund</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Date Requested</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($refunds as $refund)
                                <tr>
                                    <td>{{ $refund->id }}</td>
                                    <td>{{ $refund->pesanan->kode_pesanan }}</td>
                                    <td>{{ $refund->user->name }}</td>
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
                                        <a href="{{ route('admin.refunds.show', $refund) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="ti ti-eye me-1"></i> Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No refund requests found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $refunds->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</x-layouts.admin.dashboard>
