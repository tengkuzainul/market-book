<x-layouts.frontend.master :pageName="$pageName">
    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12">
                    <h1 class="mb-5 display-3 text-primary">Checkout</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.cart.index') }}">Keranjang</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Checkout Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <form action="{{ route('customer.orders.store') }}" method="POST">
                @csrf
                <div class="row g-5">
                    <div class="col-lg-7">
                        <div class="row g-3">
                            <div class="col-12">
                                <h5 class="mb-3">Detail Pengiriman</h5>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name"
                                        value="{{ auth()->user()->name }}" readonly>
                                    <label for="name">Nama Lengkap</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email"
                                        value="{{ auth()->user()->email }}" readonly>
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="alamat" name="alamat_pengiriman" placeholder="Masukkan alamat lengkap"
                                        style="height: 100px" required>{{ old('alamat_pengiriman') }}</textarea>
                                    <label for="alamat">Alamat Pengiriman</label>
                                </div>
                                @error('alamat_pengiriman')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <h5 class="mb-3 mt-4">Metode Pembayaran</h5>
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Pilih Rekening Bank</h6>
                                    @foreach ($rekening as $bank)
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="rekening_pembayaran_id"
                                                id="bank{{ $bank->id }}" value="{{ $bank->id }}" required
                                                {{ old('rekening_pembayaran_id') == $bank->id ? 'checked' : '' }}>
                                            <label class="form-check-label d-flex align-items-center"
                                                for="bank{{ $bank->id }}">
                                                @if ($bank->logo)
                                                    <img src="{{ URL::asset('image/logo_bank/' . $bank->logo) }}"
                                                        alt="{{ $bank->nama_bank }}" height="30" class="me-2">
                                                @endif
                                                <div>
                                                    <strong>{{ $bank->nama_bank }}</strong><br>
                                                    <small class="text-muted">{{ $bank->nomor_rekening }}
                                                        ({{ $bank->nama_pemilik }})
                                                    </small>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                    @error('rekening_pembayaran_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="catatan" name="catatan" placeholder="Catatan untuk pesanan (opsional)"
                                        style="height: 100px">{{ old('catatan') }}</textarea>
                                    <label for="catatan">Catatan (Opsional)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="bg-light rounded p-4">
                            <h4 class="mb-4">Ringkasan Pesanan</h4>
                            <div class="d-flex justify-content-between mb-4 pt-2">
                                <h5 class="mb-0">Item</h5>
                                <h5 class="mb-0">Subtotal</h5>
                            </div>
                            <hr class="my-3">
                            @foreach ($cartItems as $item)
                                <div class="d-flex justify-content-between mb-3">
                                    <p class="mb-0">{{ $item->buku->judul }} × {{ $item->jumlah }}</p>
                                    <p class="mb-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                            <hr class="my-3">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0">Total</h5>
                                <h5 class="mb-0">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                            </div>
                            <hr class="my-3">
                            <div class="py-3">
                                <div class="alert alert-info" role="alert">
                                    <strong>Info Pembayaran</strong>
                                    <p class="mb-0 small">Setelah melakukan pemesanan, silakan lakukan pembayaran dan
                                        upload bukti pembayaran pada halaman detail pesanan.</p>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">
                                <i class="fa fa-check me-2"></i> Buat Pesanan
                            </button>
                            <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-secondary py-3 w-100">
                                <i class="fa fa-arrow-left me-2"></i> Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Checkout End -->
</x-layouts.frontend.master>
