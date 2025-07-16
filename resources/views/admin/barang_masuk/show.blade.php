<x-layouts.admin.dashboard :pageName="$pageName ?? 'Detail Barang Masuk'" :currentPage="$currentPage ?? 'Barang Masuk'" :breadcrumbs="$breadcrumbs ?? []">
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
                        <h5>Informasi Barang Masuk</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Kode Barang Masuk:</strong></div>
                            <div class="col-sm-8">{{ $barangMasuk->kode_barang_masuk }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Tanggal Masuk:</strong></div>
                            <div class="col-sm-8">{{ $barangMasuk->tanggal_masuk->format('d F Y') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Buku:</strong></div>
                            <div class="col-sm-8">{{ $barangMasuk->buku->judul }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Kategori:</strong></div>
                            <div class="col-sm-8">{{ $barangMasuk->buku->kategoriBuku->nama }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Jumlah:</strong></div>
                            <div class="col-sm-8">{{ $barangMasuk->jumlah }} unit</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Harga Beli per Unit:</strong></div>
                            <div class="col-sm-8">Rp {{ number_format($barangMasuk->harga_beli, 0, ',', '.') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Total Harga Beli:</strong></div>
                            <div class="col-sm-8">Rp {{ number_format($barangMasuk->total_harga_beli, 0, ',', '.') }}
                            </div>
                        </div>
                        @if ($barangMasuk->supplier)
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Supplier:</strong></div>
                                <div class="col-sm-8">{{ $barangMasuk->supplier }}</div>
                            </div>
                        @endif
                        @if ($barangMasuk->catatan)
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Catatan:</strong></div>
                                <div class="col-sm-8">{{ $barangMasuk->catatan }}</div>
                            </div>
                        @endif
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Status:</strong></div>
                            <div class="col-sm-8">
                                @if ($barangMasuk->status == 'pending')
                                    <span class="badge bg-warning">Menunggu Persetujuan</span>
                                @elseif($barangMasuk->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Diinput Oleh:</strong></div>
                            <div class="col-sm-8">{{ $barangMasuk->user->name }}</div>
                        </div>
                        @if ($barangMasuk->approved_by)
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Disetujui/Ditolak Oleh:</strong></div>
                                <div class="col-sm-8">
                                    {{ $barangMasuk->approver ? $barangMasuk->approver->name : 'User tidak ditemukan' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Tanggal Persetujuan:</strong></div>
                                <div class="col-sm-8">
                                    {{ $barangMasuk->approved_at ? $barangMasuk->approved_at->format('d F Y H:i') : '-' }}
                                </div>
                            </div>
                        @endif
                        @if ($barangMasuk->catatan_persetujuan)
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Catatan Persetujuan:</strong></div>
                                <div class="col-sm-8">{{ $barangMasuk->catatan_persetujuan }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Aksi</h5>
                    </div>
                    <div class="card-body">
                        @if ($barangMasuk->status == 'pending')
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#approveModal">
                                    <i class="ti ti-check"></i> Setujui
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#rejectModal">
                                    <i class="ti ti-x"></i> Tolak
                                </button>
                                <a href="{{ route('admin.barang-masuk.edit', $barangMasuk->id) }}"
                                    class="btn btn-warning">
                                    <i class="ti ti-edit"></i> Edit
                                </a>
                            </div>
                        @endif
                        <hr>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.barang-masuk.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                @if ($barangMasuk->status == 'approved' && $barangMasuk->mutasiBarangs->count() > 0)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Mutasi Terkait</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($barangMasuk->mutasiBarangs as $mutasi)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <small
                                            class="text-muted">{{ $mutasi->created_at->format('d/m/Y H:i') }}</small>
                                        <br>
                                        <span class="badge bg-success">{{ $mutasi->jenis }}</span>
                                        {{ $mutasi->jumlah }} unit
                                    </div>
                                    <a href="{{ route('admin.mutasi-barang.show', $mutasi->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Approve Modal -->
        <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.barang-masuk.approve', $barangMasuk->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="approveModalLabel">Setujui Barang Masuk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Yakin ingin menyetujui barang masuk ini? Stok buku akan bertambah sebanyak
                                <strong>{{ $barangMasuk->jumlah }} unit</strong>.
                            </p>
                            <div class="mb-3">
                                <label for="catatan_persetujuan" class="form-label">Catatan Persetujuan
                                    (Opsional)</label>
                                <textarea class="form-control" id="catatan_persetujuan" name="catatan_persetujuan" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Setujui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.barang-masuk.reject', $barangMasuk->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel">Tolak Barang Masuk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Yakin ingin menolak barang masuk ini?</p>
                            <div class="mb-3">
                                <label for="catatan_penolakan" class="form-label">Alasan Penolakan <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="catatan_penolakan" name="catatan_persetujuan" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-layouts.admin.dashboard>
