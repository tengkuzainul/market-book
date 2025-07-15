<x-layouts.frontend.master :pageName="$pageName ?? __('Produk Kami')">
    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12">
                    <h1 class="mb-5 display-3 text-primary">Koleksi Buku Kami</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">
                    <!-- Filter Section Start -->
                    <div class="bg-light p-4 rounded mb-4">
                        <h4 class="mb-4">Kategori</h4>
                        <div class="d-flex flex-column">
                            @foreach ($categories as $category)
                                <a href="{{ route('frontend.category', $category->slug) }}"
                                    class="mb-2 text-dark">{{ $category->nama_kategori }}</a>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-light p-4 rounded mb-4">
                        <h4 class="mb-4">Filter Harga</h4>
                        <form action="{{ route('frontend.products') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Minimum</label>
                                <input type="number" class="form-control" name="min_price"
                                    value="{{ request('min_price') }}" placeholder="Rp. Min">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Maximum</label>
                                <input type="number" class="form-control" name="max_price"
                                    value="{{ request('max_price') }}" placeholder="Rp. Max">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </form>
                    </div>
                    <!-- Filter Section End -->
                </div>
                <div class="col-lg-9">
                    <div class="row pb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-0">Menampilkan {{ $books->firstItem() ?? 0 }} -
                                        {{ $books->lastItem() ?? 0 }} dari {{ $books->total() ?? 0 }} produk</p>
                                </div>
                                <div class="d-flex">
                                    <select class="form-select" onchange="this.form.submit()" name="sort"
                                        form="sortForm">
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                            Terbaru</option>
                                        <option value="price_low"
                                            {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke
                                            Tinggi</option>
                                        <option value="price_high"
                                            {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke
                                            Rendah</option>
                                        <option value="title_asc"
                                            {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul: A-Z</option>
                                        <option value="title_desc"
                                            {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul: Z-A</option>
                                    </select>
                                    <form id="sortForm" action="{{ route('frontend.products') }}" method="GET">
                                        @if (request('min_price'))
                                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                        @endif
                                        @if (request('max_price'))
                                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        @forelse($books as $book)
                            <div class="col-md-6 col-lg-4">
                                <div class="border border-primary rounded position-relative vesitable-item">
                                    <div class="vesitable-img">
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#coverModal-{{ $book->id }}">
                                            <img src="{{ URL::asset($book->gambar_cover) }}"
                                                class="img-fluid w-100 rounded-top"
                                                style="height: 300px; object-fit: cover;" alt="{{ $book->judul }}">
                                            <div class="cover-overlay">
                                                <i class="fa fa-search-plus fa-2x text-white"></i>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Modal for Cover Image -->
                                    <div class="modal fade" id="coverModal-{{ $book->id }}" tabindex="-1"
                                        aria-labelledby="coverModalLabel-{{ $book->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="coverModalLabel-{{ $book->id }}">
                                                        {{ $book->judul }}</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-0">
                                                    <img src="{{ URL::asset($book->gambar_cover) }}"
                                                        class="img-fluid w-100" alt="{{ $book->judul }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="d-flex justify-content-between w-100">
                                                        <div>
                                                            <p class="mb-0"><strong>Penulis:</strong>
                                                                {{ $book->penulis }}</p>
                                                        </div>
                                                        <a href="{{ route('frontend.product.detail', $book->slug) }}"
                                                            class="btn btn-primary">Lihat Detail</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                                        style="top: 10px; right: 10px;">
                                        {{ $book->kategoriBuku->nama_kategori }}
                                    </div>
                                    <div class="p-4 rounded-bottom">
                                        <h5>{{ $book->judul }}</h5>
                                        <p class="text-muted mb-0">Penulis: {{ $book->penulis }}</p>
                                        <p class="text-muted">Penerbit: {{ $book->penerbit }}</p>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <p class="text-dark fs-5 fw-bold mb-0">Rp
                                                {{ number_format($book->harga, 0, ',', '.') }}</p>
                                            <div>
                                                <a href="{{ route('frontend.product.detail', $book->slug) }}"
                                                    class="btn border border-secondary rounded-pill px-3 text-primary me-1">
                                                    <i class="fa fa-eye text-primary"></i>
                                                </a>
                                                <a href="#"
                                                    class="btn border border-secondary rounded-pill px-3 text-primary">
                                                    <i class="fa fa-shopping-bag text-primary"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <h4>Tidak ada produk yang ditemukan</h4>
                                <p>Silakan coba dengan filter yang berbeda atau lihat semua produk kami.</p>
                                <a href="{{ route('frontend.products') }}"
                                    class="btn btn-primary rounded-pill px-4 py-2">Lihat Semua Produk</a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Start -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                {{ $books->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- Pagination End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
</x-layouts.frontend.master>
