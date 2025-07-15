<x-layouts.frontend.master :pageName="$pageName ?? __('No Title')">
    <!-- Featurs Section Start -->
    <div class="container-fluid featurs py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-car-side fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Free Shipping</h5>
                            <p class="mb-0">Free on order over $300</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-user-shield fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Security Payment</h5>
                            <p class="mb-0">100% security payment</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-exchange-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>30 Day Return</h5>
                            <p class="mb-0">30 day money guarantee</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fa fa-phone-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>24/7 Support</h5>
                            <p class="mb-0">Support every time fast</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Featurs Section End -->

    <!-- Categories Section Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                <h1 class="display-4">Kategori Buku</h1>
                <p>Temukan koleksi buku favorit Anda dari berbagai kategori yang kami sediakan</p>
            </div>
            <div class="row g-4">
                @foreach ($categories as $category)
                    <div class="col-lg-3 col-md-6">
                        <div class="service-item bg-light text-center p-4 rounded">
                            <div class="service-icon d-flex align-items-center justify-content-center rounded mb-4">
                                <i class="fa fa-book fa-2x text-primary"></i>
                            </div>
                            <h4>{{ $category->nama_kategori }}</h4>
                            <p>Koleksi buku {{ $category->nama_kategori }} terlengkap dengan berbagai pilihan menarik
                            </p>
                            <a href="{{ route('frontend.category', $category->slug) }}"
                                class="btn btn-primary px-4 py-2 rounded-pill">Lihat Semua</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Categories Section End -->

    <!-- Banner Section Start-->
    <div class="container-fluid banner bg-secondary my-5">
        <div class="container py-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="py-4">
                        <h1 class="display-3 text-white">Koleksi Buku Terbaru</h1>
                        <p class="fw-normal display-3 text-dark mb-4">di Toko Kami</p>
                        <p class="mb-4 text-dark">Temukan koleksi buku terbaru dari berbagai kategori mulai dari novel,
                            pendidikan, bisnis hingga buku anak. Dapatkan diskon spesial untuk pembelian di bulan ini.
                        </p>
                        <a href="{{ route('frontend.products') }}"
                            class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">LIHAT
                            KOLEKSI</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="{{ URL::asset('frontend/img') }}/book-banner.svg" class="img-fluid w-100 rounded"
                            alt="Banner Buku">
                        <div class="d-flex align-items-center justify-content-center bg-white rounded-circle position-absolute"
                            style="width: 140px; height: 140px; top: 0; left: 0;">
                            <div class="d-flex flex-column text-center">
                                <span class="h2 mb-0">20%</span>
                                <span class="h4 text-muted mb-0">OFF</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Section End -->

    <!-- Fact Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="bg-light p-5 rounded">
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>Pelanggan Setia</h4>
                            <h1>2500+</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-book text-secondary"></i>
                            <h4>Judul Buku</h4>
                            <h1>5000+</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-award text-secondary"></i>
                            <h4>Penghargaan</h4>
                            <h1>15</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-building text-secondary"></i>
                            <h4>Tahun Pengalaman</h4>
                            <h1>10+</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->


    <!-- Testimonial Start -->
    <div class="container-fluid testimonial py-5">
        <div class="container py-5">
            <div class="testimonial-header text-center">
                <h4 class="text-primary">Testimoni Pelanggan</h4>
                <h1 class="display-5 mb-5 text-dark">Apa Kata Pembeli Kami</h1>
            </div>
            <div class="owl-carousel testimonial-carousel">
                <div class="testimonial-item img-border-radius bg-light rounded p-4">
                    <div class="position-relative">
                        <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                            style="bottom: 30px; right: 0;"></i>
                        <div class="mb-4 pb-4 border-bottom border-secondary">
                            <p class="mb-0">Pengiriman cepat dan buku dalam kondisi sempurna. Koleksi bukunya lengkap
                                dan harga sangat bersaing. Saya sudah belanja di sini lebih dari 5 kali dan selalu puas
                                dengan layanannya.
                            </p>
                        </div>
                        <div class="d-flex align-items-center flex-nowrap">
                            <div class="bg-secondary rounded">
                                <img src="{{ URL::asset('frontend/img') }}/testimonial-1.jpg" class="img-fluid rounded"
                                    style="width: 100px; height: 100px;" alt="">
                            </div>
                            <div class="ms-4 d-block">
                                <h4 class="text-dark">Anita Wijaya</h4>
                                <p class="m-0 pb-3">Guru Bahasa</p>
                                <div class="d-flex pe-5">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item img-border-radius bg-light rounded p-4">
                    <div class="position-relative">
                        <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                            style="bottom: 30px; right: 0;"></i>
                        <div class="mb-4 pb-4 border-bottom border-secondary">
                            <p class="mb-0">Sebagai mahasiswa, saya sangat terbantu dengan harga buku yang terjangkau
                                dan diskon yang sering diberikan. Proses pemesanan mudah dan customer service-nya sangat
                                responsif.
                            </p>
                        </div>
                        <div class="d-flex align-items-center flex-nowrap">
                            <div class="bg-secondary rounded">
                                <img src="{{ URL::asset('frontend/img') }}/testimonial-1.jpg"
                                    class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                            </div>
                            <div class="ms-4 d-block">
                                <h4 class="text-dark">Budi Santoso</h4>
                                <p class="m-0 pb-3">Mahasiswa</p>
                                <div class="d-flex pe-5">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item img-border-radius bg-light rounded p-4">
                    <div class="position-relative">
                        <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                            style="bottom: 30px; right: 0;"></i>
                        <div class="mb-4 pb-4 border-bottom border-secondary">
                            <p class="mb-0">Saya suka sekali dengan koleksi buku langka yang mereka miliki. Sulit
                                menemukan toko buku online yang menyediakan buku-buku klasik dengan edisi khusus seperti
                                di sini. Kemasan pengirimannya juga sangat aman.
                            </p>
                        </div>
                        <div class="d-flex align-items-center flex-nowrap">
                            <div class="bg-secondary rounded">
                                <img src="{{ URL::asset('frontend/img') }}/testimonial-1.jpg"
                                    class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                            </div>
                            <div class="ms-4 d-block">
                                <h4 class="text-dark">Diana Purnama</h4>
                                <p class="m-0 pb-3">Kolektor Buku</p>
                                <div class="d-flex pe-5">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
</x-layouts.frontend.master>
