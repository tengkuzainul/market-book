<x-layouts.frontend.master :pageName="$pageName ?? $book->judul">
    <style>
        /* Custom styling for quantity input */
        .quantity-wrapper {
            position: relative;
        }

        .quantity .form-control:focus {
            box-shadow: none;
            border-color: #28a745;
        }

        .quantity .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 45px;
            width: 45px;
            padding: 0;
        }

        .quantity .btn-minus {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .quantity .btn-plus {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        /* Hide number input arrows */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('frontend.products') }}">Produk</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('frontend.category', $book->kategoriBuku->slug) }}">{{ $book->kategoriBuku->nama_kategori }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $book->judul }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Product Detail Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="zoom-container mb-3">
                        <div class="product-img position-relative h-100">
                            <!-- Image with zoom effect -->
                            <img src="{{ asset($book->gambar_cover) }}" class="zoom-effect rounded"
                                alt="{{ $book->judul }}"
                                style="background-image: url('{{ asset($book->gambar_cover) }}');">

                            <!-- Overlay with icon -->
                            <div class="cover-detail-overlay">
                                <i class="fa fa-search-plus fa-3x text-white"></i>
                                <p class="text-white mt-2">Klik untuk memperbesar</p>
                            </div>

                            <!-- Invisible link for modal trigger -->
                            <a href="#" data-bs-toggle="modal" data-bs-target="#coverDetailModal"
                                class="position-absolute top-0 start-0 w-100 h-100"></a>
                        </div>
                    </div>

                    <p class="text-center text-muted small mb-4">
                        <i class="fas fa-mouse-pointer me-1"></i> Gerakkan mouse untuk zoom atau klik untuk memperbesar
                    </p>

                    <!-- Modal for Cover Image Detail -->
                    <div class="modal fade" id="coverDetailModal" tabindex="-1" aria-labelledby="coverDetailModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="coverDetailModalLabel">{{ $book->judul }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <img src="{{ asset($book->gambar_cover) }}" class="img-fluid w-100"
                                        alt="{{ $book->judul }}">
                                </div>
                                <div class="modal-footer">
                                    <div>
                                        <p class="mb-0"><strong>Penulis:</strong> {{ $book->penulis }} |
                                            <strong>Penerbit:</strong> {{ $book->penerbit }} | <strong>Tahun
                                                Terbit:</strong> {{ $book->tahun_terbit }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <h1 class="h2 mb-3">{{ $book->judul }}</h1>
                    <div class="d-flex mb-3">
                        <p class="mb-0 me-5"><strong>Kategori:</strong> {{ $book->kategoriBuku->nama_kategori }}</p>
                        <p class="mb-0"><strong>Stok:</strong>
                            {{ $book->stok > 0 ? 'Tersedia (' . $book->stok . ')' : 'Habis' }}</p>
                    </div>
                    <p class="mb-4"><strong>Penulis:</strong> {{ $book->penulis }}</p>
                    <p class="mb-4"><strong>Penerbit:</strong> {{ $book->penerbit }}</p>
                    <p class="mb-4"><strong>Tahun Terbit:</strong> {{ $book->tahun_terbit }}</p>
                    <p class="mb-4"><strong>Jumlah Halaman:</strong> {{ $book->jumlah_halaman }} Halaman</p>

                    <h2 class="text-primary mb-4">Rp {{ number_format($book->harga, 0, ',', '.') }}</h2>

                    <form action="{{ route('customer.cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="buku_id" value="{{ $book->id }}">
                        <div class="d-flex flex-wrap align-items-center mb-5 gap-3">
                            <div class="quantity-wrapper">
                                <label class="form-label fw-bold mb-2">Jumlah</label>
                                <div class="input-group quantity" style="width: 150px;">
                                    <button type="button" class="btn btn-primary btn-minus" onclick="decrementQty()">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <input type="number" name="jumlah"
                                        class="form-control bg-light fw-bold fs-5 text-center border-primary"
                                        value="1" min="1" max="{{ $book->stok }}" id="qty-input"
                                        style="height: 45px;">
                                    <button type="button" class="btn btn-primary btn-plus"
                                        onclick="incrementQty({{ $book->stok }})">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-1">Stok tersedia: {{ $book->stok }}</small>
                            </div>

                            <div class="mt-3 mt-sm-0">
                                <button type="submit" class="btn btn-primary btn-lg px-4 py-3"
                                    {{ $book->stok <= 0 ? 'disabled' : '' }}>
                                    <i class="fa fa-shopping-bag me-2"></i> Tambahkan ke Keranjang
                                </button>
                                @if ($book->stok <= 0)
                                    <div class="text-danger mt-2"><i class="fas fa-exclamation-circle"></i> Stok habis
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="bg-light p-4 rounded">
                        <h4 class="mb-4">Deskripsi Buku</h4>
                        <div class="book-description">
                            {!! $book->deskripsi !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products Start -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">Buku Terkait</h3>
                    <div class="row g-4">
                        @foreach ($related_books as $related)
                            <div class="col-md-6 col-lg-3">
                                <div class="border border-primary rounded position-relative vesitable-item book-item">
                                    <div class="vesitable-img">
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#coverModal-{{ $related->id }}">
                                            <img src="{{ asset($related->gambar_cover) }}"
                                                class="img-fluid w-100 rounded-top"
                                                style="height: 250px; object-fit: cover;"
                                                alt="{{ $related->judul }}">
                                            <div class="cover-overlay">
                                                <i class="fa fa-search-plus fa-2x text-white"></i>
                                                <p class="text-white mt-2 small">Lihat Cover</p>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Modal for Related Cover Image -->
                                    <div class="modal fade" id="coverModal-{{ $related->id }}" tabindex="-1"
                                        aria-labelledby="coverModalLabel-{{ $related->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="coverModalLabel-{{ $related->id }}">
                                                        {{ $related->judul }}</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-0">
                                                    <img src="{{ asset($related->gambar_cover) }}"
                                                        class="img-fluid w-100" alt="{{ $related->judul }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="d-flex justify-content-between w-100">
                                                        <div>
                                                            <p class="mb-0"><strong>Penulis:</strong>
                                                                {{ $related->penulis }}</p>
                                                        </div>
                                                        <a href="{{ route('frontend.product.detail', $related->slug) }}"
                                                            class="btn btn-primary">Lihat Detail</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                                        style="top: 10px; right: 10px;">
                                        {{ $related->kategoriBuku->nama_kategori }}
                                    </div>
                                    <div class="p-4 rounded-bottom">
                                        <h5>{{ Str::limit($related->judul, 30) }}</h5>
                                        <p class="text-muted mb-2">Penulis: {{ Str::limit($related->penulis, 20) }}
                                        </p>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <p class="text-primary fs-5 fw-bold mb-0">Rp
                                                {{ number_format($related->harga, 0, ',', '.') }}</p>
                                            <div>
                                                <a href="{{ route('frontend.product.detail', $related->slug) }}"
                                                    class="btn border border-primary rounded-pill px-3 text-primary me-1"
                                                    data-bs-toggle="tooltip" title="Lihat Detail">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="#"
                                                    class="btn border border-primary rounded-pill px-3 text-primary"
                                                    data-bs-toggle="tooltip" title="Tambahkan ke Keranjang">
                                                    <i class="fa fa-shopping-bag"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Related Products End -->
        </div>
    </div>
    <!-- Product Detail End -->

    @push('scripts')
        <script>
            function decrementQty() {
                const input = document.getElementById('qty-input');
                const currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                }
            }

            function incrementQty(maxStock) {
                const input = document.getElementById('qty-input');
                const currentValue = parseInt(input.value);
                if (currentValue < maxStock) {
                    input.value = currentValue + 1;
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Stok Terbatas',
                        text: 'Stok buku tidak mencukupi untuk menambah jumlah lagi.',
                        confirmButtonColor: '#28a745'
                    });
                }
            }

            // Ensure the input value doesn't exceed max stock on manual input
            document.getElementById('qty-input').addEventListener('change', function() {
                    const maxStock = parseInt(this.getAttribute('max'));
                    const currentValue = parseInt(this.value);

                    if (isNaN(currentValue) || currentValue < 1) {
                        this.value = 1;
                    } else if (currentValue > maxStock) {
                        this.value = maxStock;
                        Swal.fire({
                            icon: 'warning',
                            title: 'Stok Terbatas',
                            text: 'Jumlah telah disesuaikan dengan stok yang tersedia.',
                            confirmButtonColor: '#28a745'
                        });
                    }
                } else {
                    alert('Stok tidak mencukupi!');
                }
            }
        </script>
    @endpush
</x-layouts.frontend.master>
