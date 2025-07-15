<x-layouts.frontend.master :pageName="'Ajukan Refund'">
    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12">
                    <h1 class="mb-5 display-3 text-primary">Ajukan Refund</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Bera nda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.orders.index') }}">Pesanan Saya</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.orders.show', $pesanan) }}">Pesanan
                                    #{{ $pesanan->kode_pesanan }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ajukan Refund</li>
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
                            <h5 class="mb-0">Ajukan Refund untuk Pesanan #{{ $pesanan->kode_pesanan }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('refunds.store', $pesanan) }}" method="POST">
                                @csrf

                                <div class="alert alert-info">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fa fa-info-circle fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">Jumlah Refund:</h5>
                                            <h3 class="mb-0">Rp
                                                {{ number_format($pesanan->total_harga, 0, ',', '.') }}</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="metode_refund" class="form-label">Metode Refund</label>
                                    <select class="form-select @error('metode_refund') is-invalid @enderror"
                                        name="metode_refund" id="metode_refund" required>
                                        <option value="">Pilih Metode Refund</option>
                                        <option value="bank_transfer">Transfer Bank</option>
                                    </select>
                                    @error('metode_refund')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama_bank" class="form-label">Nama Bank</label>
                                    <input type="text" class="form-control @error('nama_bank') is-invalid @enderror"
                                        id="nama_bank" name="nama_bank" value="{{ old('nama_bank') }}" required>
                                    @error('nama_bank')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                                    <input type="text"
                                        class="form-control @error('nomor_rekening') is-invalid @enderror"
                                        id="nomor_rekening" name="nomor_rekening" value="{{ old('nomor_rekening') }}"
                                        required>
                                    @error('nomor_rekening')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama_pemilik_rekening" class="form-label">Nama Pemilik Rekening</label>
                                    <input type="text"
                                        class="form-control @error('nama_pemilik_rekening') is-invalid @enderror"
                                        id="nama_pemilik_rekening" name="nama_pemilik_rekening"
                                        value="{{ old('nama_pemilik_rekening') }}" required>
                                    @error('nama_pemilik_rekening')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="alasan_pembatalan" class="form-label">Alasan Pembatalan</label>
                                    <textarea class="form-control @error('alasan_pembatalan') is-invalid @enderror" id="alasan_pembatalan"
                                        name="alasan_pembatalan" rows="4" required>{{ old('alasan_pembatalan') }}</textarea>
                                    @error('alasan_pembatalan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-paper-plane me-2"></i> Ajukan Refund
                                    </button>
                                    <a href="{{ route('customer.orders.show', $pesanan) }}"
                                        class="btn btn-outline-secondary">
                                        <i class="fa fa-times me-2"></i> Batal
                                    </a>
                                </div>
                            </form>
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
                                {{ $pesanan->created_at->format('d M Y H:i') }}</p>
                            <p class="mb-2"><strong>Status:</strong> {{ ucfirst($pesanan->status) }}</p>
                            <p class="mb-3"><strong>Total:</strong> Rp
                                {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>

                            <h6 class="text-muted mb-3">Produk:</h6>
                            <ul class="list-group list-group-flush">
                                @foreach ($pesanan->items as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <span class="text-truncate d-inline-block"
                                                style="max-width: 180px;">{{ $item->judul_buku }}</span>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">{{ $item->jumlah }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.frontend.master>
