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
                                <p class="mb-0">Edit Data Buku</p>
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
            <form action="{{ route('buku.update', $buku->id) }}" method="POST" class="needs-validation" novalidate
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h5>Form Edit {{ $pageName }}</h5>
                            <hr class="mb-4">
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="judul">Judul</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    name="judul" id="judul" placeholder="Masukkan judul buku..."
                                    value="{{ old('judul', $buku->judul) }}" autofocus>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="kategoriBuku">Kategori Buku</label>
                                <select class="form-select @error('kategoriBuku') is-invalid @enderror"
                                    id="kategoriBuku" name="kategoriBuku">
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    @foreach ($kategoriBukus as $kategori)
                                        <option value="{{ $kategori->id }}"
                                            {{ old('kategoriBuku', $buku->kategori_buku_id) == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategoriBuku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="penulis">Penulis</label>
                                <input type="text" class="form-control @error('penulis') is-invalid @enderror"
                                    name="penulis" id="penulis" placeholder="Masukkan nama penulis..."
                                    value="{{ old('penulis', $buku->penulis) }}">
                                @error('penulis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="penerbit">Penerbit</label>
                                <input type="text" class="form-control @error('penerbit') is-invalid @enderror"
                                    name="penerbit" id="penerbit" placeholder="Masukkan nama penerbit..."
                                    value="{{ old('penerbit', $buku->penerbit) }}">
                                @error('penerbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="tahunTerbit">Tahun Terbit</label>
                                <select class="form-select @error('tahunTerbit') is-invalid @enderror" id="tahunTerbit"
                                    name="tahunTerbit">
                                    <option value="" selected disabled>-- Pilih Tahun --</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}"
                                            {{ old('tahunTerbit', $buku->tahun_terbit) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tahunTerbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="jumlahHalaman">Jumlah Halaman</label>
                                <input type="number" class="form-control @error('jumlahHalaman') is-invalid @enderror"
                                    name="jumlahHalaman" id="jumlahHalaman" placeholder="Masukkan jumlah halaman..."
                                    value="{{ old('jumlahHalaman', $buku->jumlah_halaman) }}">
                                @error('jumlahHalaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 mt-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="harga">Harga (Rp)</label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                    name="harga" id="harga" placeholder="Masukkan harga buku..."
                                    value="{{ old('harga', $buku->harga) }}">
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 mt-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="stok">Stok</label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                    name="stok" id="stok" placeholder="Masukkan stok buku..."
                                    value="{{ old('stok', $buku->stok) }}">
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 mt-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="minStok">Minimal Stok</label>
                                <input type="number" class="form-control @error('minStok') is-invalid @enderror"
                                    name="minStok" id="minStok" placeholder="Masukkan minimal stok..."
                                    value="{{ old('minStok', $buku->min_stok) }}">
                                @error('minStok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 mt-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="status">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="published"
                                        {{ old('status', $buku->status) == 'published' ? 'selected' : '' }}>Published
                                    </option>
                                    <option value="draft"
                                        {{ old('status', $buku->status) == 'draft' ? 'selected' : '' }}>Draft
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mt-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi"
                                    rows="4" placeholder="Masukkan deskripsi buku...">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mt-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="cover">Cover Buku</label>
                                <input type="file" class="form-control @error('cover') is-invalid @enderror"
                                    name="cover" id="cover" accept="image/*" onchange="previewImage(this)">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah cover</small>
                                @error('cover')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="my-2 position-relative border-2 rounded border-muted" style="height: 200px;">
                                @if ($buku->gambar_cover)
                                    <img src="{{ URL::asset($buku->gambar_cover) }}" alt="Preview"
                                        id="preview-image" class="img-fluid rounded"
                                        style="max-height: 100%; max-width: 100%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                    <span id="preview-text"
                                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: none;">
                                        <i class="ti ti-photo-plus fs-1 text-muted"></i>
                                    </span>
                                @else
                                    <img src="" alt="Preview" id="preview-image" class="img-fluid rounded"
                                        style="max-height: 100%; max-width: 100%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: none;">
                                    <span id="preview-text"
                                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                        <i class="ti ti-photo-plus fs-1 text-muted"></i>
                                    </span>
                                @endif
                                <button type="button"
                                    class="btn btn-sm btn-danger position-absolute bottom-0 end-0 m-2"
                                    id="delete-image" onclick="deleteImage()"
                                    style="{{ $buku->gambar_cover ? 'display: block;' : 'display: none;' }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end btn-page">
                    <button type="submit" class="btn btn-primary">Perbarui</button>
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
