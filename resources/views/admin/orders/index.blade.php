<x-layouts.admin.dashboard :pageName="$pageName ?? 'Manajemen Pesanan'" :currentPage="$currentPage ?? 'Pesanan'" :breadcrumbs="$breadcrumbs ?? []">
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
                                <h5>{{ $pageName ?? 'Manajemen Pesanan' }}</h5>
                                <p class="mb-0">Data Table List Pesanan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Bukti</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pesanan as $order)
                                <tr>
                                    <td>{{ $order->kode_pesanan }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if ($order->bukti_pembayaran)
                                            <span class="badge bg-success">Sudah Upload</span>
                                        @else
                                            <span class="badge bg-danger">Belum Upload</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->status == 'diproses')
                                            <span class="badge bg-warning">Diproses</span>
                                        @elseif($order->status == 'disetujui')
                                            <span class="badge bg-info">Disetujui</span>
                                        @elseif($order->status == 'dikemas')
                                            <span class="badge bg-primary">Dikemas</span>
                                        @elseif($order->status == 'diantarkan')
                                            <span class="badge bg-primary">Diantarkan</span>
                                        @elseif($order->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($order->status == 'dibatalkan')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="ti ti-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $pesanan->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    "paging": false,
                    "searching": true,
                    "ordering": true,
                    "info": false,
                });
            });
        </script>
    @endpush
</x-layouts.admin.dashboard>
