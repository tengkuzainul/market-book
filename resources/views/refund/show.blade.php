<x-layouts.frontend.master :pageName="'Detail Refund'">
    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12">
                    <h1 class="mb-5 display-3 text-primary">Detail Refund</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.orders.index') }}">Pesanan Saya</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('refunds.index') }}">Permintaan Refund</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Refund</li>
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
                <div class="col-md-8">
                    <div class="card border-0 rounded shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Permintaan Refund untuk Pesanan #{{ $refund->pesanan->kode_pesanan }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Informasi Refund</h6>
                                    <p class="mb-2"><strong>Tanggal Permintaan:</strong>
                                        {{ $refund->created_at->format('d M Y H:i') }}</p>
                                    <p class="mb-2"><strong>Jumlah:</strong> Rp
                                        {{ number_format($refund->jumlah, 0, ',', '.') }}</p>
                                    <p class="mb-2">
                                        <strong>Status:</strong>
                                        @if ($refund->status == 'diproses')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($refund->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($refund->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Metode Refund</h6>
                                    <p class="mb-2"><strong>Metode:</strong>
                                        {{ ucfirst(str_replace('_', ' ', $refund->metode_refund)) }}</p>
                                    <p class="mb-2"><strong>Bank:</strong> {{ $refund->nama_bank }}</p>
                                    <p class="mb-2"><strong>Nomor Rekening:</strong> {{ $refund->nomor_rekening }}</p>
                                    <p class="mb-2"><strong>Nama Pemilik Rekening:</strong>
                                        {{ $refund->nama_pemilik_rekening }}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-3">Alasan Pembatalan</h6>
                                <div class="p-3 bg-light rounded">
                                    {{ $refund->alasan_pembatalan }}
                                </div>
                            </div>

                            @if ($refund->catatan_admin)
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Catatan Admin</h6>
                                    <div class="p-3 bg-light rounded">
                                        {{ $refund->catatan_admin }}
                                    </div>
                                </div>
                            @endif

                            @if ($refund->bukti_refund)
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Bukti Refund</h6>
                                    <div class="mt-2 text-center">
                                        <img src="{{ asset($refund->bukti_refund) }}" class="img-fluid border rounded"
                                            style="max-height: 400px;" alt="Bukti Refund">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 rounded shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Tanggal Pesanan:</strong>
                                {{ $refund->pesanan->created_at->format('d M Y H:i') }}</p>
                            <p class="mb-2"><strong>Status:</strong> {{ ucfirst($refund->pesanan->status) }}</p>
                            <p class="mb-3"><strong>Total:</strong> Rp
                                {{ number_format($refund->pesanan->total_harga, 0, ',', '.') }}</p>

                            <h6 class="text-muted mb-3">Produk:</h6>
                            <ul class="list-group list-group-flush">
                                @foreach ($refund->pesanan->items as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <span class="text-truncate d-inline-block"
                                                style="max-width: 180px;">{{ $item->judul_buku }}</span>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">{{ $item->jumlah }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-4">
                                <a href="{{ route('customer.orders.show', $refund->pesanan) }}"
                                    class="btn btn-secondary btn-sm">
                                    <i class="fa fa-eye"></i> Lihat Detail Pesanan
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('refunds.index') }}" class="btn btn-outline-secondary">
                            <i class="fa fa-arrow-left me-2"></i> Kembali ke Daftar Refund
                        </a>
                    </div>
                </div>
            </div>
        </div>
</x-layouts.frontend.master>
