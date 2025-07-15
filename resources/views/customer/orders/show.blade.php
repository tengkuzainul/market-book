<x-layouts.frontend.master :pageName="$pageName">
    <style>
        /* Timeline CSS */
        .timeline-progress-container {
            position: relative;
            padding: 20px 10px;
            margin-bottom: 20px;
        }

        .timeline-progress-bar {
            position: relative;
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            margin: 30px 0;
        }

        .timeline-progress {
            position: absolute;
            height: 100%;
            background-color: #4e73df;
            border-radius: 3px;
            transition: width 0.5s ease;
        }

        .timeline-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-top: -53px;
            /* Adjust to place steps on the timeline */
        }

        .timeline-step {
            text-align: center;
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .timeline-step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f8f9fa;
            border: 3px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            color: #adb5bd;
            transition: all 0.3s ease;
        }

        .timeline-step.active .timeline-step-icon {
            background-color: #4e73df;
            border-color: #3a57d0;
            color: white;
            box-shadow: 0 0 10px rgba(78, 115, 223, 0.5);
        }

        .timeline-step-label {
            font-size: 12px;
            font-weight: 500;
            margin-top: 5px;
            color: #6c757d;
        }

        .timeline-step.active .timeline-step-label {
            color: #4e73df;
            font-weight: 600;
        }

        .timeline-special-status {
            position: relative;
            z-index: 2;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .timeline-step-icon {
                width: 30px;
                height: 30px;
                font-size: 12px;
            }

            .timeline-step-label {
                font-size: 10px;
            }

            .timeline-steps {
                margin-top: -43px;
            }
        }

        @media (max-width: 576px) {
            .timeline-steps {
                margin-top: -38px;
            }

            .timeline-step-icon {
                width: 24px;
                height: 24px;
                font-size: 10px;
                border-width: 2px;
            }

            .timeline-step-label {
                font-size: 8px;
            }
        }
    </style>
    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12">
                    <h1 class="mb-5 display-3 text-primary">Detail Pesanan</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.orders.index') }}">Pesanan Saya</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pesanan->kode_pesanan }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Order Detail Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 rounded shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Pesanan #{{ $pesanan->kode_pesanan }}</h5>
                                <div>
                                    @if ($pesanan->status == 'diproses')
                                        <span class="badge bg-warning">Diproses</span>
                                    @elseif($pesanan->status == 'disetujui')
                                        <span class="badge bg-info">Disetujui</span>
                                    @elseif($pesanan->status == 'dikemas')
                                        <span class="badge bg-primary">Dikemas</span>
                                    @elseif($pesanan->status == 'diantarkan')
                                        <span class="badge bg-primary">Diantarkan</span>
                                    @elseif($pesanan->status == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($pesanan->status == 'dibatalkan')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @elseif($pesanan->status == 'refunded')
                                        <span class="badge bg-secondary">Refunded</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Timeline Status Pesanan -->
                            <div class="mb-4">
                                <h6 class="text-muted mb-3">Progress Pesanan:</h6>
                                <div class="position-relative mb-4">
                                    <div class="timeline-progress-container">
                                        <div class="timeline-progress-bar">
                                            @php
                                                $statusOrder = [
                                                    'diproses',
                                                    'disetujui',
                                                    'dikemas',
                                                    'diantarkan',
                                                    'selesai',
                                                ];
                                                $currentStatus = $pesanan->status;

                                                // Definisi ikon status menggunakan Font Awesome
                                                $statusIcons = [
                                                    'diproses' => 'fa fa-file-invoice',
                                                    'disetujui' => 'fa fa-check-circle',
                                                    'dikemas' => 'fa fa-box',
                                                    'diantarkan' => 'fa fa-truck',
                                                    'selesai' => 'fa fa-flag-checkered',
                                                    'dibatalkan' => 'fa fa-times-circle',
                                                    'refunded' => 'fa fa-undo',
                                                ];

                                                // Handle special cases
                                                if (in_array($currentStatus, ['dibatalkan', 'refunded'])) {
                                                    $progressPercent = 0;
                                                    $specialStatus = true;
                                                } else {
                                                    $statusIndex = array_search($currentStatus, $statusOrder);
                                                    $progressPercent =
                                                        $statusIndex !== false ? ($statusIndex + 1) * 25 : 0;
                                                    if ($progressPercent > 100) {
                                                        $progressPercent = 100;
                                                    }
                                                    $specialStatus = false;
                                                }
                                            @endphp
                                            <div class="timeline-progress" style="width: {{ $progressPercent }}%"></div>
                                        </div>
                                        <div class="timeline-steps">
                                            <div
                                                class="timeline-step {{ $currentStatus == 'diproses' || array_search($currentStatus, $statusOrder) >= 0 ? 'active' : '' }}">
                                                <div class="timeline-step-icon">
                                                    <i class="fa fa-file-invoice"></i>
                                                </div>
                                                <div class="timeline-step-label">Diproses</div>
                                            </div>
                                            <div
                                                class="timeline-step {{ $currentStatus == 'disetujui' || array_search($currentStatus, $statusOrder) >= 1 ? 'active' : '' }}">
                                                <div class="timeline-step-icon">
                                                    <i class="fa fa-check-circle"></i>
                                                </div>
                                                <div class="timeline-step-label">Disetujui</div>
                                            </div>
                                            <div
                                                class="timeline-step {{ $currentStatus == 'dikemas' || array_search($currentStatus, $statusOrder) >= 2 ? 'active' : '' }}">
                                                <div class="timeline-step-icon">
                                                    <i class="fa fa-box"></i>
                                                </div>
                                                <div class="timeline-step-label">Dikemas</div>
                                            </div>
                                            <div
                                                class="timeline-step {{ $currentStatus == 'diantarkan' || array_search($currentStatus, $statusOrder) >= 3 ? 'active' : '' }}">
                                                <div class="timeline-step-icon">
                                                    <i class="fa fa-truck"></i>
                                                </div>
                                                <div class="timeline-step-label">Diantarkan</div>
                                            </div>
                                            <div
                                                class="timeline-step {{ $currentStatus == 'selesai' || array_search($currentStatus, $statusOrder) >= 4 ? 'active' : '' }}">
                                                <div class="timeline-step-icon">
                                                    <i class="fa fa-flag-checkered"></i>
                                                </div>
                                                <div class="timeline-step-label">Selesai</div>
                                            </div>
                                        </div>

                                        @if (in_array($currentStatus, ['dibatalkan', 'refunded']))
                                            <div class="timeline-special-status mt-3 text-center">
                                                @if ($currentStatus == 'dibatalkan')
                                                    <div class="badge bg-danger p-2">
                                                        <i class="fa fa-times-circle me-1"></i> Pesanan Dibatalkan
                                                    </div>
                                                @elseif($currentStatus == 'refunded')
                                                    <div class="badge bg-secondary p-2">
                                                        <i class="fa fa-undo me-1"></i> Dana Dikembalikan
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Detail Pesanan:</h6>
                                    <p class="mb-1"><strong>Tanggal Pemesanan:</strong>
                                        {{ $pesanan->created_at->format('d M Y H:i') }}</p>
                                    <p class="mb-1"><strong>Status:</strong> {{ ucfirst($pesanan->status) }}</p>
                                    <p class="mb-1"><strong>Total:</strong> Rp
                                        {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Alamat Pengiriman:</h6>
                                    <p>{{ $pesanan->alamat_pengiriman }}</p>
                                </div>
                            </div>

                            @if ($pesanan->catatan)
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Catatan:</h6>
                                    <p>{{ $pesanan->catatan }}</p>
                                </div>
                            @endif

                            <h6 class="text-muted mb-3">Item Pesanan:</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pesanan->items as $item)
                                            <tr>
                                                <td>{{ $item->judul_buku }}</td>
                                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                                <td>{{ $item->jumlah }}</td>
                                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                                            <td><strong>Rp
                                                    {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="mt-4">
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary">
                                        <i class="fa fa-arrow-left me-2"></i> Kembali ke Pesanan
                                    </a>

                                    @if ($pesanan->status == 'diproses')
                                        <form action="{{ route('customer.orders.cancel', $pesanan->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-times me-2"></i> Batalkan Pesanan
                                            </button>
                                        </form>
                                    @endif

                                    @if ($pesanan->status == 'diantarkan')
                                        <form action="{{ route('customer.orders.complete', $pesanan->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda sudah menerima pesanan ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-check me-2"></i> Pesanan Diterima
                                            </button>
                                        </form>
                                    @endif

                                    @if ($pesanan->status == 'dibatalkan' && !$pesanan->refund)
                                        <a href="{{ route('refunds.create', $pesanan->id) }}"
                                            class="btn btn-warning">
                                            <i class="fa fa-money-bill me-2"></i> Ajukan Pengembalian Dana
                                        </a>
                                    @endif

                                    @if ($pesanan->refund)
                                        <a href="{{ route('refunds.show', $pesanan->refund->id) }}"
                                            class="btn btn-info">
                                            <i class="fa fa-eye me-2"></i> Lihat Status Refund
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Payment Information -->
                    <div class="card border-0 rounded shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0">Informasi Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="text-muted mb-3">Detail Bank:</h6>
                            @if ($pesanan->rekeningPembayaran)
                                <div class="d-flex align-items-center mb-3">
                                    @if ($pesanan->rekeningPembayaran->logo)
                                        <img src="{{ asset('image/logo_bank/' . $pesanan->rekeningPembayaran->logo) }}"
                                            alt="{{ $pesanan->rekeningPembayaran->nama_bank }}" height="40"
                                            class="me-3">
                                    @endif
                                    <div>
                                        <p class="mb-0">
                                            <strong>{{ $pesanan->rekeningPembayaran->nama_bank }}</strong>
                                        </p>
                                        <p class="mb-0">{{ $pesanan->rekeningPembayaran->nomor_rekening }}</p>
                                        <p class="mb-0">a.n {{ $pesanan->rekeningPembayaran->nama_pemilik }}</p>
                                    </div>
                                </div>

                                <div class="alert alert-info small mb-4">
                                    <strong>Petunjuk Pembayaran:</strong>
                                    <ol class="ps-3 mb-0">
                                        <li>Transfer sejumlah <strong>Rp
                                                {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong> ke
                                            rekening di atas</li>
                                        <li>Screenshot/foto bukti pembayaran</li>
                                        <li>Upload bukti pembayaran melalui form di bawah</li>
                                        <li>Tunggu konfirmasi dari admin</li>
                                    </ol>
                                </div>
                            @else
                                <p>Informasi rekening tidak tersedia.</p>
                            @endif

                            @if ($pesanan->status == 'diproses')
                                <div class="upload-section mt-4">
                                    <h6 class="text-muted mb-3">Upload Bukti Pembayaran:</h6>
                                    <form action="{{ route('customer.orders.upload', $pesanan->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <input class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                                                type="file" name="bukti_pembayaran" accept="image/*" required>
                                            @error('bukti_pembayaran')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa fa-upload me-2"></i> Upload Bukti
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if ($pesanan->bukti_pembayaran)
                                <div class="mt-4">
                                    <h6 class="text-muted mb-3">Bukti Pembayaran:</h6>
                                    <div class="text-center">
                                        <img src="{{ asset($pesanan->bukti_pembayaran) }}" alt="Bukti Pembayaran"
                                            class="img-fluid rounded border">
                                        <p class="text-muted small mt-2">Diunggah pada:
                                            {{ $pesanan->updated_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Detail End -->
</x-layouts.frontend.master>
