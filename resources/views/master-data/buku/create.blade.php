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
                        <a href="{{ route('buku.create') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <form action="{{ route('buku.store') }}" method="POST" class="needs-validation" novalidate
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h5>Form {{ $pageName }}</h5>
                            <hr class="mb-4">
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="judul">Judul</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    value="{{ old('judul') }}" id="judul" name="judul"
                                    placeholder="Masukkan judul buku..." autofocus>
                                @error('judul')
                                    <div class="invalid-feedback">
                                        <span class="text-capitalize">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="penulis">Penulis</label>
                                <input type="text" class="form-control @error('penulis') is-invalid @enderror"
                                    value="{{ old('penulis') }}" id="penulis" name="penulis"
                                    placeholder="Masukkan penulis buku...">
                                @error('penulis')
                                    <div class="invalid-feedback">
                                        <span class="text-capitalize">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="penerbit">Penerbit</label>
                                <input type="text" class="form-control @error('penerbit') is-invalid @enderror"
                                    value="{{ old('penerbit') }}" id="penerbit" name="penerbit"
                                    placeholder="Masukkan penerbit buku...">
                                @error('penerbit')
                                    <div class="invalid-feedback">
                                        <span class="text-capitalize">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="jumlahHalaman">Jumlah Halaman</label>
                                <input type="number" class="form-control @error('jumlahHalaman') is-invalid @enderror"
                                    value="{{ old('jumlahHalaman') }}" id="jumlahHalaman" name="jumlahHalaman"
                                    placeholder="Masukkan jumlah halaman buku...">
                                @error('jumlahHalaman')
                                    <div class="invalid-feedback">
                                        <span class="text-capitalize">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="kategoriBuku">Kategori Buku</label>
                                <select class="form-select @error('kategoriBuku') is-invalid @enderror"
                                    id="kategoriBuku" name="kategoriBuku" aria-label="Default select example">
                                    <option selected disabled>Pilih Kategori Buku</option>
                                    @forelse ($kategoriBukus as $kategoriBuku)
                                        <option value="{{ $kategoriBuku->id }}"
                                            {{ old('kategoriBuku') == $kategoriBuku->id ? 'selected' : '' }}>
                                            {{ $kategoriBuku->nama_kategori }}</option>
                                    @empty
                                        <option value="" disabled>Tidak Ada Kategori Buku</option>
                                    @endforelse
                                </select>
                                @error('kategoriBuku')
                                    <div class="invalid-feedback">
                                        <span class="text-capitalize">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="tahunTerbit">Tahun Terbit Buku</label>
                                <select class="form-select @error('tahunTerbit') is-invalid @enderror" id="tahunTerbit"
                                    name="tahunTerbit" aria-label="Default select example">
                                    <option selected disabled>Pilih Tahun Terbit Buku</option>
                                    @forelse ($years as $year)
                                        <option value="{{ $year }}"
                                            {{ old('tahunTerbit') == $year ? 'selected' : '' }}>
                                            {{ $year }}</option>
                                    @empty
                                        <option value="" disabled>Tidak Ada Kategori Buku</option>
                                    @endforelse
                                </select>
                                @error('tahunTerbit')
                                    <div class="invalid-feedback">
                                        <span class="text-capitalize">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 mt-3">
                            <div class="form-group">
                                <label class="form-label" for="harga">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Rp</span>
                                    <input type="number" value="{{ old('harga') }}" id="harga" name="harga"
                                        placeholder="Masukkan harga buku..."
                                        class="form-control @error('harga') is-invalid @enderror"
                                        placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                @error('harga')
                                    <div class="invalid-feedback">
                                        <span class="text-capitalize">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 mt-3">
                            <div class="form-group">
                                <label class="form-label" for="stok">Stok Awal</label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold" id="basic-addon1"><i
                                            class="ti ti-box"></i></span>
                                    <input type="number" value="{{ old('stok') }}" id="stok" name="stok"
                                        placeholder="Masukkan stok buku..."
                                        class="form-control @error('stok') is-invalid @enderror"
                                        placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                @error('stok')
                                    <div class="invalid-feedback">
                                        <span class="text-capitalize">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 mt-3">
                            <div class="form-group">
                                <label class="form-label" for="minStok">Minimal Stok</label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold" id="basic-addon1"><i
                                            class="ti ti-circle-minus"></i></span>
                                    <input type="number" value="{{ old('minStok') }}" id="minStok"
                                        name="minStok" placeholder="Masukkan min stok buku..."
                                        class="form-control @error('minStok') is-invalid @enderror"
                                        placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                @error('minStok')
                                    <div class="invalid-feedback">
                                        <span class="text-capitalize">{{ $message }}</span>
                                    </div>
                                @else
                                    <span class="small text-primary">* Data untuk mengetahui stok sudah menipis.</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 mt-3">
                            <div class="form-group">
                                <label class="form-label" for="status">Status Buku</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" aria-label="Default select example">
                                    <option selected disabled>Pilih Status Buku</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                        Published</option>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        <span class="text-capitalize">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mt-3">
                            <div class="form-group">
                                <label class="form-label" for="deskripsi">Deskripsi Buku</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                    placeholder="Masukkan deskripsi buku..." rows="5">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">
                                        <span class="text-capitalize">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mt-3">
                            <div class="form-group">
                                <label class="form-label" for="cover">Upload Cover Buku
                                    (jpeg,png,jpg,gif,svg)</label>
                                <input class="form-control @error('cover') is-invalid @enderror" type="file"
                                    name="cover" id="cover" onchange="previewImage(this)">
                                @error('cover')
                                    <div class="invalid-feedback">
                                        <span class="text-capitalize">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="my-2 position-relative border border-2 rounded border-muted"
                                style="border-style: dashed !important;">
                                <div id="preview-container" class="d-flex justify-content-center p-2">
                                    <h3 class="text-muted" id="preview-text">Preview Image</h3>
                                    <img id="preview-image" src="" alt="Cover Preview"
                                        style="max-height: 200px; display: none;">
                                </div>
                                <button type="button" id="delete-image"
                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                    style="display: none;" onclick="deleteImage()">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-footer text-end btn-page">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewImage(input) {
                const previewImage = document.getElementById('preview-image');
                const previewText = document.getElementById('preview-text');
                const deleteBtn = document.getElementById('delete-image');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                        previewText.style.display = 'none';
                        deleteBtn.style.display = 'block';
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            function deleteImage() {
                const coverInput = document.getElementById('cover');
                const previewImage = document.getElementById('preview-image');
                const previewText = document.getElementById('preview-text');
                const deleteBtn = document.getElementById('delete-image');

                coverInput.value = '';
                previewImage.src = '';
                previewImage.style.display = 'none';
                previewText.style.display = 'block';
                deleteBtn.style.display = 'none';
            }
        </script>
    @endpush
</x-layouts.admin.dashboard>
