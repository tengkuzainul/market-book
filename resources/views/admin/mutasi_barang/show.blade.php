<x-layouts.admin.dashboard :pageName="$pageName ?? 'Detail Mutasi Barang'" :currentPage="$currentPage ?? 'Mutasi Barang'" :breadcrumbs="$breadcrumbs ?? []">
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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Informasi Mutasi Barang</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>ID Mutasi:</strong></div>
                            <div class="col-sm-8">#{{ $mutasiBarang->id }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Tanggal & Waktu:</strong></div>
                            <div class="col-sm-8">{{ $mutasiBarang->created_at->format('d F Y, H:i:s') }} WIB</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Buku:</strong></div>
                            <div class="col-sm-8">{{ $mutasiBarang->buku->judul }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Kategori Buku:</strong></div>
                            <div class="col-sm-8">{{ $mutasiBarang->buku->kategoriBuku->nama }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Jenis Mutasi:</strong></div>
                            <div class="col-sm-8">
                                @if ($mutasiBarang->jenis_mutasi == 'masuk')
                                    <span class="badge bg-success fs-6">Masuk</span>
                                @else
                                    <span class="badge bg-danger fs-6">Keluar</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Jumlah:</strong></div>
                            <div class="col-sm-8">{{ $mutasiBarang->jumlah }} unit</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Kategori Mutasi:</strong></div>
                            <div class="col-sm-8">
                                @if ($mutasiBarang->referensi_tipe == 'App\Models\BarangMasuk')
                                    <span class="badge bg-info">Barang Masuk</span>
                                @elseif($mutasiBarang->referensi_tipe == 'App\Models\Pesanan')
                                    <span class="badge bg-primary">Penjualan</span>
                                @elseif($mutasiBarang->referensi_tipe == 'App\Models\Refund')
                                    <span class="badge bg-warning">Refund</span>
                                @else
                                    <span class="badge bg-secondary">Manual</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Keterangan:</strong></div>
                            <div class="col-sm-8">{{ $mutasiBarang->keterangan }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Stok Sebelum:</strong></div>
                            <div class="col-sm-8">{{ $mutasiBarang->stok_sebelum }} unit</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Stok Sesudah:</strong></div>
                            <div class="col-sm-8">{{ $mutasiBarang->stok_sesudah }} unit</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Sumber Mutasi:</strong></div>
                            <div class="col-sm-8">{{ $mutasiBarang->referensi_tipe ?? 'Manual' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Aksi</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.mutasi-barang.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Source Information Card -->
                @if ($mutasiBarang->referensi_tipe && $mutasiBarang->referensi_id)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Sumber Mutasi</h5>
                        </div>
                        <div class="card-body">
                            @if ($mutasiBarang->referensi_tipe == 'App\Models\BarangMasuk')
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti ti-package-import me-2 text-info"></i>
                                    <span><strong>Barang Masuk</strong></span>
                                </div>
                                @if ($mutasiBarang->referensi)
                                    <small class="text-muted">Kode:
                                        {{ $mutasiBarang->referensi->kode_barang_masuk }}</small><br>
                                    <small class="text-muted">Tanggal:
                                        {{ $mutasiBarang->referensi->tanggal_masuk->format('d/m/Y') }}</small>
                                    <div class="mt-2">
                                        <a href="{{ route('admin.barang-masuk.show', $mutasiBarang->referensi->id) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="ti ti-eye"></i> Lihat Detail
                                        </a>
                                    </div>
                                @endif
                            @elseif($mutasiBarang->referensi_tipe == 'App\Models\Pesanan')
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti ti-shopping-cart me-2 text-primary"></i>
                                    <span><strong>Pesanan</strong></span>
                                </div>
                                @if ($mutasiBarang->referensi)
                                    <small class="text-muted">Kode:
                                        {{ $mutasiBarang->referensi->kode_pesanan }}</small><br>
                                    <small class="text-muted">Tanggal:
                                        {{ $mutasiBarang->referensi->created_at->format('d/m/Y') }}</small>
                                    <div class="mt-2">
                                        <a href="{{ route('admin.orders.show', $mutasiBarang->referensi->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="ti ti-eye"></i> Lihat Detail
                                        </a>
                                    </div>
                                @endif
                            @elseif($mutasiBarang->referensi_tipe == 'App\Models\Refund')
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti ti-cash-banknote-off me-2 text-warning"></i>
                                    <span><strong>Refund</strong></span>
                                </div>
                                @if ($mutasiBarang->referensi)
                                    <small class="text-muted">Pesanan:
                                        {{ $mutasiBarang->referensi->pesanan->kode_pesanan }}</small><br>
                                    <small class="text-muted">Tanggal:
                                        {{ $mutasiBarang->referensi->created_at->format('d/m/Y') }}</small>
                                    <div class="mt-2">
                                        <a href="{{ route('admin.refunds.show', $mutasiBarang->referensi->id) }}"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="ti ti-eye"></i> Lihat Detail
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Book Information Card -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Informasi Buku</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @if ($mutasiBarang->buku->cover)
                                <img src="{{ asset($mutasiBarang->buku->cover) }}" alt="Cover"
                                    class="img-fluid rounded" style="max-height: 150px;">
                            @else
                                <div class="bg-light rounded p-3"
                                    style="height: 150px; display: flex; align-items: center; justify-content: center;">
                                    <i class="ti ti-book display-4 text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="small">
                            <strong>Judul:</strong> {{ $mutasiBarang->buku->judul }}<br>
                            <strong>Penulis:</strong> {{ $mutasiBarang->buku->penulis }}<br>
                            <strong>Kategori:</strong> {{ $mutasiBarang->buku->kategoriBuku->nama }}<br>
                            <strong>Harga:</strong> Rp {{ number_format($mutasiBarang->buku->harga, 0, ',', '.') }}<br>
                            <strong>Stok Saat Ini:</strong> {{ $mutasiBarang->buku->stok }} unit
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('buku.show', $mutasiBarang->buku->id) }}"
                                class="btn btn-sm btn-outline-secondary w-100">
                                <i class="ti ti-book"></i> Lihat Detail Buku
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-layouts.admin.dashboard>
