<x-layouts.frontend.master :pageName="$pageName">
    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12">
                    <h1 class="mb-5 display-3 text-primary">Keranjang Belanja</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            @if ($cartItems->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                    <h3>Keranjang Belanja Anda Kosong</h3>
                    <p>Silakan tambahkan beberapa buku ke keranjang Anda.</p>
                    <a href="{{ route('frontend.products') }}" class="btn btn-primary mt-3">Jelajahi Buku</a>
                </div>
            @else
                <div class="table-responsive mb-5">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0">Buku</th>
                                <th scope="col" class="border-0">Harga</th>
                                <th scope="col" class="border-0">Jumlah</th>
                                <th scope="col" class="border-0">Subtotal</th>
                                <th scope="col" class="border-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($item->buku->gambar_cover) }}"
                                                style="width: 80px; height: 100px; object-fit: cover;"
                                                class="rounded me-3" alt="{{ $item->buku->judul }}">
                                            <div>
                                                <h6 class="mb-1">{{ $item->buku->judul }}</h6>
                                                <small class="text-muted">{{ $item->buku->penulis }}</small>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="align-middle">
                                        <p class="mb-0">Rp {{ number_format($item->buku->harga, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('customer.cart.update', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group quantity" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-sm btn-primary btn-minus"
                                                        onclick="decrementQuantity(this)">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="number" name="jumlah"
                                                    class="form-control form-control-sm text-center quantity-input"
                                                    value="{{ $item->jumlah }}" min="1"
                                                    max="{{ $item->buku->stok }}">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-sm btn-primary btn-plus"
                                                        onclick="incrementQuantity(this, {{ $item->buku->stok }})">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-success mt-2 update-cart-btn"
                                                style="display: none;">
                                                <i class="fa fa-sync-alt"></i> Update
                                            </button>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        <p class="mb-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('customer.cart.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm rounded-circle bg-light border"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                                <i class="fa fa-times text-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row g-4 justify-content-end">
                    <div class="col-lg-6">
                        <a href="{{ route('frontend.products') }}" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left me-2"></i> Lanjutkan Belanja
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-light rounded p-4">
                            <h4 class="mb-4">Ringkasan Keranjang</h4>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Total:</h5>
                                <p class="mb-0 fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('customer.checkout') }}" class="btn btn-primary w-100 py-3">
                                Lanjutkan ke Checkout <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Cart Page End -->

    @push('scripts')
        <script>
            function incrementQuantity(element, maxStock) {
                const inputElement = element.closest('.quantity').querySelector('.quantity-input');
                const currentValue = parseInt(inputElement.value);
                if (currentValue < maxStock) {
                    inputElement.value = currentValue + 1;
                    showUpdateButton(element);
                } else {
                    alert('Stok tidak mencukupi');
                }
            }

            function decrementQuantity(element) {
                const inputElement = element.closest('.quantity').querySelector('.quantity-input');
                const currentValue = parseInt(inputElement.value);
                if (currentValue > 1) {
                    inputElement.value = currentValue - 1;
                    showUpdateButton(element);
                }
            }

            function showUpdateButton(element) {
                const updateBtn = element.closest('form').querySelector('.update-cart-btn');
                updateBtn.style.display = 'inline-block';
            }

            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    showUpdateButton(this);
                });
            });
        </script>
    @endpush
</x-layouts.frontend.master>
