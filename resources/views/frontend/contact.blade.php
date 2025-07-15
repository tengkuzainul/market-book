<x-layouts.frontend.master :pageName="$pageName ?? __('Hubungi Kami')">
    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12">
                    <h1 class="mb-5 display-3 text-primary">Hubungi Kami</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Contact Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="text-center mx-auto" style="max-width: 700px;">
                            <h1 class="text-primary">Hubungi Kami Kapan Saja</h1>
                            <p class="mb-4">Jika Anda memiliki pertanyaan atau ingin mendapatkan informasi lebih
                                lanjut, jangan ragu untuk menghubungi kami. Tim kami siap membantu Anda.</p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <form action="#" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Nama Lengkap">
                                        <label for="nama">Nama Lengkap</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" name="subject"
                                            placeholder="Subject">
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="pesan" name="pesan" placeholder="Pesan" style="height: 150px"></textarea>
                                        <label for="pesan">Pesan</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Kirim Pesan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-5">
                        <div class="h-100 rounded">
                            <iframe class="rounded w-100 h-100"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.858597975437!2d107.6349859751227!3d-6.9053636677232595!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e7c381e3c323%3A0x5f5160f6c9796e4b!2sMall%20Bandung%20Indah%20Plaza!5e0!3m2!1sen!2sid!4v1683522787116!5m2!1sen!2sid"
                                style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-4 mt-5">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fa fa-map-marker-alt text-white fs-5"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">Alamat</h5>
                                        <p class="mb-0">Jl. Merdeka No. 123, Bandung</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fa fa-phone-alt text-white fs-5"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">Telepon</h5>
                                        <p class="mb-0">+62 123 4567 8910</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fa fa-envelope text-white fs-5"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">Email</h5>
                                        <p class="mb-0">info@booksshop.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
</x-layouts.frontend.master>
