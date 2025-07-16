<x-layouts.admin.dashboard :pageName="$pageName ?? 'Barang Masuk'" :currentPage="$currentPage ?? 'Barang Masuk'" :breadcrumbs="$breadcrumbs ?? []">
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
                                <h5>Data Barang Masuk</h5>
                                <p class="mb-0">Manajemen barang masuk dan persetujuan stok</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.barang-masuk.create') }}" class="btn btn-dark">
                            <i class="ti ti-plus me-1"></i>Tambah Barang Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @if ($barangMasuks->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Buku</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Diinput Oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangMasuks as $barangMasuk)
                                    <tr>
                                        <td>{{ $barangMasuk->kode_barang_masuk }}</td>
                                        <td>{{ $barangMasuk->tanggal_masuk->format('d/m/Y') }}</td>
                                        <td>{{ $barangMasuk->buku->judul }}</td>
                                        <td>{{ $barangMasuk->jumlah }}</td>
                                        <td>
                                            @if ($barangMasuk->status == 'pending')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($barangMasuk->status == 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ $barangMasuk->user->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.barang-masuk.show', $barangMasuk->id) }}"
                                                class="btn btn-icon btn-secondary btn-sm">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            @if ($barangMasuk->status == 'pending')
                                                <a href="{{ route('admin.barang-masuk.edit', $barangMasuk->id) }}"
                                                    class="btn btn-icon btn-primary btn-sm">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <form
                                                    action="{{ route('admin.barang-masuk.destroy', $barangMasuk->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-danger btn-sm"
                                                        onclick="return confirm('Yakin hapus data ini?')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ti ti-package-import display-4 text-muted"></i>
                        <h5 class="mt-2">Belum ada data barang masuk</h5>
                        <p class="text-muted">Tambahkan barang masuk pertama Anda</p>
                        <a href="{{ route('admin.barang-masuk.create') }}" class="btn btn-primary">Tambah Barang
                            Masuk</a>
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
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
        });
    </script>
@endpush
