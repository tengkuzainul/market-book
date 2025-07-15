<x-layouts.frontend.master :pageName="$pageName">
    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12">
                    <h1 class="mb-5 display-3 text-primary">Pesanan Saya</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pesanan Saya</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Orders Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            @if ($pesanan->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-shopping-bag fa-4x text-muted mb-4"></i>
                    <h3>Belum Ada Pesanan</h3>
                    <p>Anda belum memiliki pesanan. Mulai berbelanja sekarang!</p>
                    <a href="{{ route('frontend.products') }}" class="btn btn-primary mt-3">Jelajahi Buku</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col">Kode Pesanan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanan as $order)
                                <tr>
                                    <td>{{ $order->kode_pesanan }}</td>
                                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($order->status == 'diproses')
                                            <span class="badge bg-warning">Diproses</span>
                                        @elseif($order->status == 'disetujui')
                                            <span class="badge bg-info">Disetujui</span>
                                        @elseif($order->status == 'dikemas')
                                            <span class="badge bg-primary">Dikemas</span>
                                        @elseif($order->status == 'diantarkan')
                                            <span class="badge bg-primary">Diantarkan</span>
                                        @elseif($order->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($order->status == 'dibatalkan')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('customer.orders.show', $order->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fa fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <!-- Orders End -->
</x-layouts.frontend.master>
