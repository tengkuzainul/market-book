<x-layouts.frontend.master :pageName="$pageName ?? 'Permintaan Refund'">
    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12">
                    <h1 class="mb-5 display-3 text-primary">Permintaan Refund</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.orders.index') }}">Pesanan Saya</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Permintaan Refund</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->



    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Permintaan Refund Saya</h5>
                        </div>
                        <div class="card-body">
                            @if ($refunds->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Kode Pesanan</th>
                                                <th>Jumlah Refund</th>
                                                <th>Tanggal Permintaan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($refunds as $refund)
                                                <tr>
                                                    <td>{{ $refund->pesanan->kode_pesanan }}</td>
                                                    <td>Rp {{ number_format($refund->jumlah, 0, ',', '.') }}</td>
                                                    <td>{{ $refund->created_at->format('d M Y H:i') }}</td>
                                                    <td>
                                                        @if ($refund->status == 'diproses')
                                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                                        @elseif($refund->status == 'selesai')
                                                            <span class="badge bg-success">Selesai</span>
                                                        @elseif($refund->status == 'ditolak')
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('refunds.show', $refund) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fa fa-eye"></i> Detail
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
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="fa fa-info-circle fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0">Anda belum memiliki permintaan refund saat ini.</p>
                                            <small>Jika Anda ingin mengajukan refund, silakan buka halaman detail
                                                pesanan yang ingin di-refund.</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-light">
                            <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left me-2"></i> Kembali ke Daftar Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.frontend.master>
