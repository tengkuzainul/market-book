<x-layouts.admin.dashboard :pageName="$pageName ?? 'Mutasi Barang'" :currentPage="$currentPage ?? 'Mutasi Barang'" :breadcrumbs="$breadcrumbs ?? []">
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


        <!-- Filter Card -->
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Filter Data</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" id="filterForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Buku</label>
                                        <select name="buku_id" class="form-select">
                                            <option value="">Semua Buku</option>
                                            @foreach ($bukus as $buku)
                                                <option value="{{ $buku->id }}"
                                                    {{ request('buku_id') == $buku->id ? 'selected' : '' }}>
                                                    {{ $buku->judul }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis</label>
                                        <select name="jenis" class="form-select">
                                            <option value="">Semua</option>
                                            <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>
                                                Masuk</option>
                                            <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>
                                                Keluar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Sumber</label>
                                        <select name="referensi_tipe" class="form-select">
                                            <option value="">Semua</option>
                                            <option value="App\Models\BarangMasuk"
                                                {{ request('referensi_tipe') == 'App\Models\BarangMasuk' ? 'selected' : '' }}>
                                                Barang Masuk</option>
                                            <option value="App\Models\Pesanan"
                                                {{ request('referensi_tipe') == 'App\Models\Pesanan' ? 'selected' : '' }}>
                                                Penjualan</option>
                                            <option value="App\Models\Refund"
                                                {{ request('referensi_tipe') == 'App\Models\Refund' ? 'selected' : '' }}>
                                                Refund</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Dari Tanggal</label>
                                        <input type="date" name="dari_tanggal" class="form-control"
                                            value="{{ request('dari_tanggal') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Sampai Tanggal</label>
                                        <input type="date" name="sampai_tanggal" class="form-control"
                                            value="{{ request('sampai_tanggal') }}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Card -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Data Mutasi Barang</h5>
                        <div>
                            <a href="{{ route('admin.laporan-inventory') }}" class="btn btn-success me-2">
                                <i class="ti ti-file-export"></i> Export Laporan
                            </a>
                            <a href="{{ route('admin.mutasi-barang.index') }}" class="btn btn-secondary"
                                onclick="resetFilter()">
                                <i class="ti ti-refresh"></i> Reset Filter
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($mutasiBarangs && $mutasiBarangs->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped" id="pc-dt-simple">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Buku</th>
                                            <th>Jenis</th>
                                            <th>Jumlah</th>
                                            <th>Sumber</th>
                                            <th>Keterangan</th>
                                            <th>Stok Akhir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mutasiBarangs as $mutasi)
                                            <tr>
                                                <td>{{ $mutasi->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $mutasi->buku->judul }}</td>
                                                <td>
                                                    @if ($mutasi->jenis_mutasi == 'masuk')
                                                        <span class="badge bg-success">Masuk</span>
                                                    @else
                                                        <span class="badge bg-danger">Keluar</span>
                                                    @endif
                                                </td>
                                                <td>{{ $mutasi->jumlah }}</td>
                                                <td>
                                                    @if ($mutasi->referensi_tipe == 'App\Models\BarangMasuk')
                                                        <span class="badge bg-info">Barang Masuk</span>
                                                    @elseif($mutasi->referensi_tipe == 'App\Models\Pesanan')
                                                        <span class="badge bg-primary">Penjualan</span>
                                                    @elseif($mutasi->referensi_tipe == 'App\Models\Refund')
                                                        <span class="badge bg-warning">Refund</span>
                                                    @else
                                                        <span class="badge bg-secondary">Manual</span>
                                                    @endif
                                                </td>
                                                <td>{{ $mutasi->keterangan }}</td>
                                                <td>{{ $mutasi->stok_sesudah }}</td>
                                                <td>
                                                    <a href="{{ route('admin.mutasi-barang.show', $mutasi->id) }}"
                                                        class="btn btn-icon btn-secondary btn-sm">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    Menampilkan {{ $mutasiBarangs->firstItem() ?? 0 }} sampai
                                    {{ $mutasiBarangs->lastItem() ?? 0 }}
                                    dari {{ $mutasiBarangs->total() ?? 0 }} data
                                </div>
                                @if ($mutasiBarangs)
                                    {{ $mutasiBarangs->appends(request()->query())->links() }}
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="ti ti-file-analytics display-4 text-muted"></i>
                                <h5 class="mt-2">Belum ada data mutasi barang</h5>
                                <p class="text-muted">Data mutasi akan muncul setelah ada transaksi</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
</x-layouts.admin.dashboard>

@push('scripts')
    <script>
        $('#pc-dt-simple').DataTable({
            "paging": false,
            "searching": false,
            "info": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
        });
    </script>
@endpush
