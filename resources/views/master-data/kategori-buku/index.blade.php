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
                                <p class="mb-0">Data Table List {{ $pageName }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                            data-bs-target="#kategoriBukuCreate">
                            <i class="ti ti-plus me-1"></i>Tambah Data
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="kategoriBukuCreate" tabindex="-1"
                            aria-labelledby="kategoriBukuCreateLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="kategoriBukuCreateLabel">Form Tambah
                                            {{ $pageName }}
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('kategori-buku.store') }}" method="POST"
                                        class="needs-validation" novalidate>
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="namaKategori">Nama Kategori
                                                    Lengkap</label>
                                                <input type="text" id="namaKategori" name="namaKategori"
                                                    value="{{ old('namaKategori') }}" required
                                                    class="form-control @error('namaKategori') is-invalid @enderror"
                                                    placeholder="Masukkan nama kategori..." autofocus
                                                    autocomplete="name">
                                                @error('namaKategori')
                                                    <div class="invalid-feedback">
                                                        <span class="text-capitalize">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"
                                                class="btn btn-outline-secondary d-flex align-items-center"
                                                data-bs-dismiss="modal"><i
                                                    class="ti ti-x me-1"></i><span>Tutup</span></button>
                                            <button type="Submit" class="btn btn-success d-flex align-items-center"><i
                                                    class="ti ti-circle-check me-1"></i><span>Simpan
                                                    Data</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card tbl-card">
            <div class="card-header">
                <h5 class="mb-3">{{ $pageName }}</h5>
            </div>
            <div class="card-body">
                <div class="col-md-12 col-xl-12">

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase">No</th>
                                    <th class="text-uppercase">Nama Kategori Buku</th>
                                    <th class="text-uppercase">Slug URL</th>
                                    <th class="text-end text-uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kategoriBukus as $kategoriBuku)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kategoriBuku->nama_kategori }}</td>
                                        <td>{{ $kategoriBuku->slug }}</td>
                                        <td>
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-dark rounded"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#kategoriBukuUpdate-{{ $kategoriBuku->id }}">
                                                    <i class="ti ti-edit me-1"></i>Edit
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="kategoriBukuUpdate-{{ $kategoriBuku->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="kategoriBukuUpdate-{{ $kategoriBuku->id }}-Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="kategoriBukuUpdate-{{ $kategoriBuku->id }}-Label">
                                                                    Form
                                                                    Edit {{ $pageName }}</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route('kategori-buku.update', $kategoriBuku->id) }}"
                                                                method="POST" class="needs-validation" novalidate>
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label" for="namaKategori">
                                                                            Nama Kategori Buku
                                                                        </label>
                                                                        <input type="text" id="namaKategori"
                                                                            name="namaKategori"
                                                                            value="{{ old('namaKategori', $kategoriBuku->nama_kategori) }}"
                                                                            required
                                                                            class="form-control @error('namaKategori') is-invalid @enderror"
                                                                            placeholder="Masukkan nama kategori..."
                                                                            autofocus autocomplete="name">
                                                                        @error('namaKategori')
                                                                            <div class="invalid-feedback">
                                                                                <span
                                                                                    class="text-capitalize">{{ $message }}</span>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-outline-secondary d-flex align-items-center"
                                                                        data-bs-dismiss="modal"><i
                                                                            class="ti ti-x me-1"></i><span>Tutup</span></button>
                                                                    <button type="Submit"
                                                                        class="btn btn-success d-flex align-items-center">
                                                                        <i class="ti ti-circle-check me-1"></i><span>Simpan
                                                                            Data</span></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="{{ route('kategori-buku.destroy', $kategoriBuku->id) }}"
                                                    data-confirm-delete="true"
                                                    class="btn btn-sm btn-danger rounded delete-btn">
                                                    <i class="ti ti-trash me-1"></i>Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="3">Data tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin.dashboard>
