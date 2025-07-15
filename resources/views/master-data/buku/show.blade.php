<x-layouts.admin.dashboard :pageName="$pageName ?? 'No title'" :currentPage="$currentPage ?? 'Dashboard'" :breadcrumbs="$breadcrumbs ?? []">
    <div class="col-md-12 col-xl-12">
        @if (Session::has('success') || Session::has('error'))
            <div class="alert alert-{{ Session::has('success') ? 'success' : 'danger' }} alert-dismissible fade show mb-3"
                role="alert">
                <i class="ti ti-{{ Session::has('success') ? 'circle-check' : 'alert-circle' }} me-2"></i>
                <strong>{{ Session::has('success') ? 'Berhasil!' : 'Gagal!' }}</strong>
                {{ Session::get('success') ?? Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card profile-wave-card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="d-flex align-items-center">
                            <div class="ms-2">
                                <h5>{{ $pageName }}</h5>
                                <p class="mb-0">Detail informasi lengkap buku</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Cover Buku -->
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="book-cover-container d-flex justify-content-center align-items-center">
                            <div class="card shadow-sm">
                                <div class="card-body p-0">
                                    @if ($buku->gambar_cover)
                                        <img src="{{ URL::asset($buku->gambar_cover) }}" alt="{{ $buku->judul }}"
                                            class="img-fluid rounded book-cover"
                                            style="max-height: 350px; width: 100%; object-fit: cover;">
                                    @else
                                        <div class="no-cover d-flex justify-content-center align-items-center bg-light rounded"
                                            style="height: 350px; width: 100%;">
                                            <i class="ti ti-book fs-1 text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-outline-primary">
                                    <i class="ti ti-edit me-1"></i>Edit Buku
                                </a>
                                <a href="{{ route('buku.destroy', $buku->id) }}" data-confirm-delete="true"
                                    class="btn btn-outline-danger delete-btn">
                                    <i class="ti ti-trash me-1"></i>Hapus
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Buku -->
                    <div class="col-md-8">
                        <h4 class="mb-3 text-primary fw-bold">{{ $buku->judul }}</h4>

                        <div class="mb-3 d-flex gap-2">
                            <span class="badge bg-{{ $buku->status == 'published' ? 'success' : 'secondary' }} p-2">
                                <i class="ti ti-{{ $buku->status == 'published' ? 'check' : 'clock' }} me-1"></i>
                                {{ ucfirst($buku->status) }}
                            </span>

                            <span class="badge bg-info p-2">
                                <i class="ti ti-category me-1"></i>
                                {{ $buku->kategoriBuku->nama_kategori }}
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%" class="bg-light">Penulis</th>
                                        <td>{{ $buku->penulis }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Penerbit</th>
                                        <td>{{ $buku->penerbit }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Tahun Terbit</th>
                                        <td>{{ $buku->tahun_terbit }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Jumlah Halaman</th>
                                        <td>{{ $buku->jumlah_halaman ?? 'Tidak tersedia' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Harga</th>
                                        <td>Rp. {{ number_format($buku->harga, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Stok</th>
                                        <td>
                                            {{ $buku->stok }}
                                            @if ($buku->stok <= $buku->min_stok)
                                                <span class="badge bg-danger ms-2">Stok Menipis</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Minimal Stok</th>
                                        <td>{{ $buku->min_stok }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <h5 class="fw-bold">Deskripsi</h5>
                            <div class="p-3 bg-light rounded">
                                @if ($buku->deskripsi)
                                    <p class="mb-0">{{ $buku->deskripsi }}</p>
                                @else
                                    <p class="text-muted mb-0 fst-italic">Tidak ada deskripsi</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin.dashboard>
