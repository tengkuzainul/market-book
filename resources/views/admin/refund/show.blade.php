<x-layouts.admin.dashboard :pageName="$pageName ?? 'Refund Request Details'" :currentPage="$currentPage ?? 'Refund'" :breadcrumbs="$breadcrumbs ?? []">
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

        <div class="row mb-4">
            <div class="col-12">
                <div class="card profile-wave-card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Refund Request Details</h5>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.refunds.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="ti ti-arrow-left me-1"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Refund Details -->
            <div class="col-md-8">
                <div class="card profile-wave-card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Refund Information</h5>
                            </div>
                            <div class="col-auto">
                                <span
                                    class="badge @if ($refund->status == 'diproses') bg-warning text-dark @elseif($refund->status == 'selesai') bg-success @elseif($refund->status == 'ditolak') bg-danger @endif px-2 py-1">
                                    {{ ucfirst($refund->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl>
                                    <dt>Refund ID</dt>
                                    <dd>{{ $refund->id }}</dd>

                                    <dt>Order Number</dt>
                                    <dd>{{ $refund->pesanan->kode_pesanan }}</dd>

                                    <dt>Customer</dt>
                                    <dd>{{ $refund->user->name }} ({{ $refund->user->email }})</dd>

                                    <dt>Amount</dt>
                                    <dd>Rp. {{ number_format($refund->jumlah, 0, ',', '.') }}</dd>

                                    <dt>Date Requested</dt>
                                    <dd>{{ $refund->created_at->format('d M Y H:i') }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl>
                                    <dt>Refund Method</dt>
                                    <dd>{{ ucfirst(str_replace('_', ' ', $refund->metode_refund)) }}</dd>

                                    <dt>Bank Name</dt>
                                    <dd>{{ $refund->nama_bank }}</dd>

                                    <dt>Account Number</dt>
                                    <dd>{{ $refund->nomor_rekening }}</dd>

                                    <dt>Account Holder</dt>
                                    <dd>{{ $refund->nama_pemilik_rekening }}</dd>
                                </dl>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Reason for Cancellation</label>
                            <div class="p-3 bg-light">
                                {{ $refund->alasan_pembatalan }}
                            </div>
                        </div>

                        @if ($refund->status == 'diproses')
                            <div class="mt-4">
                                <form action="{{ route('admin.refunds.process', $refund) }}" method="POST"
                                    class="needs-validation" novalidate>
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label class="form-label">Admin Decision</label>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" id="status_approved"
                                                name="status" value="selesai" required>
                                            <label for="status_approved" class="form-check-label">Approve Refund</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="status_rejected"
                                                name="status" value="ditolak">
                                            <label for="status_rejected" class="form-check-label">Reject Refund</label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="catatan_admin">Admin Notes</label>
                                        <textarea name="catatan_admin" id="catatan_admin" rows="3" class="form-control"
                                            placeholder="Add notes for customer regarding this refund decision"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Process Refund</button>
                                </form>
                            </div>
                        @elseif($refund->status == 'selesai' && !$refund->bukti_refund)
                            <div class="mt-4">
                                <form action="{{ route('admin.refunds.upload-proof', $refund) }}" method="POST"
                                    enctype="multipart/form-data" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="bukti_refund">Upload Proof of Refund</label>
                                        <input type="file"
                                            class="form-control @error('bukti_refund') is-invalid @enderror"
                                            id="bukti_refund" name="bukti_refund" required>
                                        @error('bukti_refund')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        <small class="form-text text-muted">Upload proof of refund payment
                                            (screenshot/receipt). Max: 2MB.</small>
                                    </div>

                                    <button type="submit" class="btn btn-success">
                                        <i class="ti ti-upload me-1"></i> Upload Proof
                                    </button>
                                </form>
                            </div>
                        @endif

                        @if ($refund->catatan_admin)
                            <div class="mt-4">
                                <label class="form-label">Admin Notes</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $refund->catatan_admin }}
                                </div>
                            </div>
                        @endif

                        @if ($refund->bukti_refund)
                            <div class="mt-4">
                                <label class="form-label">Proof of Refund</label>
                                <div class="mt-2">
                                    <img src="{{ asset($refund->bukti_refund) }}" class="img-fluid border rounded"
                                        style="max-height: 400px;" alt="Proof of Refund">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="col-md-4">
                <div class="card profile-wave-card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Order Details</h5>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-info">{{ ucfirst($refund->pesanan->status) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl>
                            <dt>Order Date</dt>
                            <dd>{{ $refund->pesanan->created_at->format('d M Y H:i') }}</dd>

                            <dt>Total Amount</dt>
                            <dd>Rp. {{ number_format($refund->pesanan->total_harga, 0, ',', '.') }}</dd>
                        </dl>

                        <h5 class="mt-4">Order Items</h5>
                        <ul class="list-group">
                            @foreach ($refund->pesanan->items as $item)
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
</x-layouts.admin.dashboard>

@push('scripts')
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endpush
