<x-layouts.admin.dashboard :pageName="$pageName ?? 'Laporan Inventory'" :currentPage="$currentPage ?? 'Laporan Inventory'" :breadcrumbs="$breadcrumbs ?? []">
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


        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary rounded p-3">
                                    <i class="ti ti-book text-white display-6"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Total Jenis Buku</h6>
                                <h4 class="mb-0">{{ $totalJenisBuku }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success rounded p-3">
                                    <i class="ti ti-stack text-white display-6"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Total Stok</h6>
                                <h4 class="mb-0">{{ $totalStok }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-info rounded p-3">
                                    <i class="ti ti-file-import text-white display-6"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Barang Masuk (Bulan Ini)</h6>
                                <h4 class="mb-0">{{ $barangMasukBulanIni }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning rounded p-3">
                                    <i class="ti ti-file-export text-white display-6"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Barang Keluar (Bulan Ini)</h6>
                                <h4 class="mb-0">{{ $barangKeluarBulanIni }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Filter Laporan</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" id="filterForm">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="kategori_id" class="form-select">
                                            <option value="">Semua Kategori</option>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}"
                                                    {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Stok Minimal</label>
                                        <input type="number" name="stok_minimal" class="form-control"
                                            value="{{ request('stok_minimal') }}" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Stok Maksimal</label>
                                        <input type="number" name="stok_maksimal" class="form-control"
                                            value="{{ request('stok_maksimal') }}" placeholder="999">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Periode Dari</label>
                                        <input type="date" name="periode_dari" class="form-control"
                                            value="{{ request('periode_dari') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Periode Sampai</label>
                                        <input type="date" name="periode_sampai" class="form-control"
                                            value="{{ request('periode_sampai') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="{{ route('admin.laporan-inventory') }}"
                                                class="btn btn-secondary">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Table -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Laporan Stok Buku</h5>
                    </div>
                    <div class="card-body">
                        @if ($bukus->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped" id="inventoryTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori</th>
                                            <th>Judul Buku</th>
                                            <th>Penulis</th>
                                            <th>Harga</th>
                                            <th>Stok Saat Ini</th>
                                            <th>Total Masuk</th>
                                            <th>Total Keluar</th>
                                            <th>Nilai Stok</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bukus as $index => $buku)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $buku->kategoriBuku->nama }}</td>
                                                <td>{{ $buku->judul }}</td>
                                                <td>{{ $buku->penulis }}</td>
                                                <td>Rp {{ number_format($buku->harga, 0, ',', '.') }}</td>
                                                <td>{{ $buku->stok }}</td>
                                                <td>{{ $buku->total_masuk ?? 0 }}</td>
                                                <td>{{ $buku->total_keluar ?? 0 }}</td>
                                                <td>Rp {{ number_format($buku->stok * $buku->harga, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    @if ($buku->stok <= 5)
                                                        <span class="badge bg-danger">Stok Menipis</span>
                                                    @elseif($buku->stok <= 10)
                                                        <span class="badge bg-warning">Stok Rendah</span>
                                                    @else
                                                        <span class="badge bg-success">Stok Aman</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th colspan="5">TOTAL</th>
                                            <th>{{ $bukus->sum('stok') }}</th>
                                            <th>{{ $bukus->sum('total_masuk') ?? 0 }}</th>
                                            <th>{{ $bukus->sum('total_keluar') ?? 0 }}</th>
                                            <th>Rp
                                                {{ number_format($bukus->sum(function ($buku) {return $buku->stok * $buku->harga;}),0,',','.') }}
                                            </th>
                                            <th>-</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="ti ti-chart-line display-4 text-muted"></i>
                                <h5 class="mt-2">Tidak ada data</h5>
                                <p class="text-muted">Belum ada data sesuai filter yang dipilih</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        @if ($stokMenipis->count() > 0)
            <div class="row mt-4">
                <div class="col-sm-12">
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0"><i class="ti ti-alert-triangle me-2"></i>Peringatan Stok Menipis</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Buku</th>
                                            <th>Kategori</th>
                                            <th>Stok Tersisa</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stokMenipis as $buku)
                                            <tr>
                                                <td>{{ $buku->judul }}</td>
                                                <td>{{ $buku->kategoriBuku->nama_kategori }}</td>
                                                <td><span class="badge bg-danger">{{ $buku->stok }} unit</span></td>
                                                <td>
                                                    <a href="{{ route('admin.barang-masuk.create') }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="ti ti-plus"></i> Tambah Stok
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
</x-layouts.admin.dashboard>

@push('styles')
    <style>
        @media print {
            .card-header .btn-group {
                display: none !important;
            }

            .page-header {
                display: none !important;
            }

            .breadcrumb {
                display: none !important;
            }
        }
    </style>
@endpush
