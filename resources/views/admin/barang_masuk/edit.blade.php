<x-layouts.admin.dashboard :pageName="$pageName ?? 'Edit Barang Masuk'" :currentPage="$currentPage ?? 'Barang Masuk'" :breadcrumbs="$breadcrumbs ?? []">
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
                        <h5>Form Edit Barang Masuk</h5>
                    </div>
                    <div class="card-body">
                        @if ($barangMasuk->status != 'pending')
                            <div class="alert alert-warning">
                                <i class="ti ti-alert-triangle"></i>
                                Data ini sudah {{ $barangMasuk->status == 'approved' ? 'disetujui' : 'ditolak' }} dan
                                tidak dapat diubah.
                            </div>
                        @endif

                        <form action="{{ route('admin.barang-masuk.update', $barangMasuk->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="tanggal_masuk">Tanggal Masuk <span
                                                class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                            id="tanggal_masuk" name="tanggal_masuk"
                                            value="{{ old('tanggal_masuk', $barangMasuk->tanggal_masuk->format('Y-m-d')) }}"
                                            required {{ $barangMasuk->status != 'pending' ? 'disabled' : '' }}>
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
                                            id="buku_id" name="buku_id" required
                                            {{ $barangMasuk->status != 'pending' ? 'disabled' : '' }}>
                                            <option value="">-- Pilih Buku --</option>
                                            @foreach ($bukus as $buku)
                                                <option value="{{ $buku->id }}"
                                                    {{ old('buku_id', $barangMasuk->buku_id) == $buku->id ? 'selected' : '' }}>
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
                                            id="jumlah" name="jumlah"
                                            value="{{ old('jumlah', $barangMasuk->jumlah) }}" min="1" required
                                            {{ $barangMasuk->status != 'pending' ? 'disabled' : '' }}>
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
                                            id="harga_beli" name="harga_beli"
                                            value="{{ old('harga_beli', $barangMasuk->harga_beli) }}" min="0"
                                            step="0.01" required
                                            {{ $barangMasuk->status != 'pending' ? 'disabled' : '' }}>
                                        @error('harga_beli')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="supplier">Supplier</label>
                                <input type="text" class="form-control @error('supplier') is-invalid @enderror"
                                    id="supplier" name="supplier"
                                    value="{{ old('supplier', $barangMasuk->supplier) }}"
                                    placeholder="Masukkan nama supplier"
                                    {{ $barangMasuk->status != 'pending' ? 'disabled' : '' }}>
                                @error('supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="catatan">Catatan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                                    placeholder="Catatan tambahan (opsional)" {{ $barangMasuk->status != 'pending' ? 'disabled' : '' }}>{{ old('catatan', $barangMasuk->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                @if ($barangMasuk->status == 'pending')
                                    <button type="submit" class="btn btn-primary">Update</button>
                                @endif
                                <a href="{{ route('admin.barang-masuk.show', $barangMasuk->id) }}"
                                    class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin.dashboard>
