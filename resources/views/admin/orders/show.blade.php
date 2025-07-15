<x-layouts.admin.dashboard :pageName="$pageName ?? 'Detail Pesanan'" :currentPage="$currentPage ?? 'Pesanan'" :breadcrumbs="$breadcrumbs ?? []">
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

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card profile-wave-card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Detail Pesanan</h5>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar Pesanan
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <h5 class="font-weight-bold mb-3">Informasi Pesanan</h5>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="180">Kode Pesanan</td>
                                        <td>: <strong>{{ $pesanan->kode_pesanan }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Pesanan</td>
                                        <td>: {{ $pesanan->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Harga</td>
                                        <td>: <strong>Rp
                                                {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>:
                                            @if ($pesanan->status == 'diproses')
                                                <span class="badge bg-warning text-dark">Diproses</span>
                                            @elseif($pesanan->status == 'disetujui')
                                                <span class="badge bg-info">Disetujui</span>
                                            @elseif($pesanan->status == 'dikemas')
                                                <span class="badge bg-primary">Dikemas</span>
                                            @elseif($pesanan->status == 'diantarkan')
                                                <span class="badge bg-primary">Diantarkan</span>
                                            @elseif($pesanan->status == 'selesai')
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($pesanan->status == 'dibatalkan')
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($pesanan->catatan)
                                        <tr>
                                            <td>Catatan</td>
                                            <td>: {{ $pesanan->catatan }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <h5 class="font-weight-bold mb-3">Informasi Pelanggan</h5>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="180">Nama</td>
                                        <td>: {{ $pesanan->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>: {{ $pesanan->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Pengiriman</td>
                                        <td>: {{ $pesanan->alamat_pengiriman }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="table-responsive">
                                    <h5 class="font-weight-bold mb-3">Item Pesanan</h5>
                                    <table class="table table-bordered table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Produk</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pesanan->items as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->judul_buku }}</td>
                                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                                    <td>{{ $item->jumlah }}</td>
                                                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-light font-weight-bold">
                                            <tr>
                                                <td colspan="4" class="text-end">Total</td>
                                                <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="m-0 font-weight-bold">Update Status Pesanan</h6>
                                    </div>
                                    <div class="card-body">
                                        @if ($pesanan->status == 'dibatalkan' || $pesanan->status == 'selesai')
                                            <div class="alert alert-info">
                                                Status pesanan ini sudah final dan tidak dapat diubah.
                                            </div>
                                        @else
                                            <form action="{{ route('admin.orders.updateStatus', $pesanan->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status Pesanan</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="diproses"
                                                            {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>
                                                            Diproses
                                                        </option>
                                                        <option value="disetujui"
                                                            {{ $pesanan->status == 'disetujui' ? 'selected' : '' }}>
                                                            Disetujui</option>
                                                        <option value="dikemas"
                                                            {{ $pesanan->status == 'dikemas' ? 'selected' : '' }}>
                                                            Dikemas
                                                        </option>
                                                        <option value="diantarkan"
                                                            {{ $pesanan->status == 'diantarkan' ? 'selected' : '' }}>
                                                            Diantarkan</option>
                                                        <option value="selesai"
                                                            {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>
                                                            Selesai
                                                        </option>
                                                        <option value="dibatalkan"
                                                            {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>
                                                            Dibatalkan</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="catatan" class="form-label">Catatan Admin
                                                        (Opsional)</label>
                                                    <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ $pesanan->catatan }}</textarea>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Update Status</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                @if ($pesanan->bukti_pembayaran)
                                    <div class="card shadow-sm mt-4">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="m-0 font-weight-bold">Bukti Pembayaran</h6>
                                        </div>
                                        <div class="card-body text-center">
                                            <img src="{{ asset($pesanan->bukti_pembayaran) }}" alt="Bukti Pembayaran"
                                                class="img-fluid mb-2">
                                            <p class="small text-muted">Diunggah pada:
                                                {{ $pesanan->updated_at->format('d M Y H:i') }}</p>
                                            <a href="{{ asset($pesanan->bukti_pembayaran) }}"
                                                class="btn btn-sm btn-primary" target="_blank">
                                                <i class="fas fa-search-plus"></i> Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="card shadow-sm mt-4">
                                        <div class="card-header bg-warning text-dark">
                                            <h6 class="m-0 font-weight-bold">Bukti Pembayaran</h6>
                                        </div>
                                        <div class="card-body text-center py-4">
                                            <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                                            <p>Pelanggan belum mengupload bukti pembayaran</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-layouts.admin.dashboard>
