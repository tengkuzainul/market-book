<x-layouts.admin.dashboard :pageName="$pageName ?? 'Tambah Barang Masuk'" :currentPage="$currentPage ?? 'Barang Masuk'" :breadcrumbs="$breadcrumbs ?? []">
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

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Form Tambah Barang Masuk</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.barang-masuk.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="tanggal_masuk">Tanggal Masuk <span
                                                class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                            id="tanggal_masuk" name="tanggal_masuk"
                                            value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                                        @error('tanggal_masuk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="buku_id">Buku <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('buku_id') is-invalid @enderror"
                                            id="buku_id" name="buku_id" required>
                                            <option value="">-- Pilih Buku --</option>
                                            @foreach ($bukus as $buku)
                                                <option value="{{ $buku->id }}"
                                                    {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                                    {{ $buku->judul }} (Stok: {{ $buku->stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('buku_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="jumlah">Jumlah <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                            id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1"
                                            required>
                                        @error('jumlah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="harga_beli">Harga Beli per Unit <span
                                                class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control @error('harga_beli') is-invalid @enderror"
                                            id="harga_beli" name="harga_beli" value="{{ old('harga_beli') }}"
                                            min="0" step="0.01" required>
                                        @error('harga_beli')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="supplier">Supplier</label>
                                <input type="text" class="form-control @error('supplier') is-invalid @enderror"
                                    id="supplier" name="supplier" value="{{ old('supplier') }}"
                                    placeholder="Masukkan nama supplier">
                                @error('supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="catatan">Catatan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                                    placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('admin.barang-masuk.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin.dashboard>
