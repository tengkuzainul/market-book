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
                                <p class="mb-0">Data Table List {{ $pageName }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('buku.create') }}" class="btn btn-dark">
                            <i class="ti ti-plus me-1"></i>Tambah Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card tbl-card">
            <div class="card-header">
                <h5 class="mb-3">{{ $pageName }}</h5>
            </div>
            <div class="card-body">
                <div class="col-md-12 col-xl-12">

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase">Buku</th>
                                    <th class="text-uppercase">Penulis</th>
                                    <th class="text-uppercase">Penerbit</th>
                                    <th class="text-uppercase">Harga</th>
                                    <th class="text-uppercase">Stok</th>
                                    <th class="text-uppercase">Status</th>
                                    <th class="text-end text-uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bukus as $buku)
                                    <tr class="{{ $buku->stok <= $buku->min_stok ? 'bg-danger bg-opacity-10' : '' }}">
                                        <td class="d-flex align-items-center gap-2">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $buku->id }}">
                                            @empty($buku->gambar_cover)
                                                <img src="{{ URL::asset('assets/images/image-null.png') }}"
                                                    alt="{{ $buku->judul }}" class="img-fluid rounded" width="50"
                                                    style="cursor:pointer;">
                                            @else
                                                <img src="{{ URL::asset($buku->gambar_cover) }}"
                                                    alt="{{ $buku->judul }}" class="img-fluid rounded" width="50"
                                                    style="cursor:pointer;">
                                            @endempty
                                        </a>
                                        <div class="d-flex flex-column gap-0">
                                            <p class="mb-1 fw-bold">{{ $buku->judul }}</p>
                                            <span class="small">Kategori:
                                                {{ $buku->kategoriBuku->nama_kategori }}</span>
                                            <span class="small">Tahun: {{ $buku->tahun_terbit }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $buku->penulis }}</td>
                                    <td>{{ $buku->penerbit }}</td>
                                    <td>Rp. {{ number_format($buku->harga, 0, ',', '.') }}</td>
                                    <td>{{ $buku->stok }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $buku->status == 'published' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($buku->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                            <a href="{{ route('buku.edit', $buku->id) }}"
                                                class="btn btn-sm btn-outline-dark rounded">
                                                <i class="ti ti-edit me-1"></i>Edit
                                            </a>
                                            <a href="{{ route('buku.show', $buku->id) }}"
                                                class="btn btn-sm btn-secondary rounded">
                                                <i class="ti ti-eye me-1"></i>Detail
                                            </a>
                                            <a href="{{ route('buku.destroy', $buku->id) }}"
                                                data-confirm-delete="true"
                                                class="btn btn-sm btn-danger rounded delete-btn">
                                                <i class="ti ti-trash me-1"></i>Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Detail Buku -->
                                <div class="modal fade" id="detailModal{{ $buku->id }}" tabindex="-1"
                                    aria-labelledby="detailModalLabel{{ $buku->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $buku->id }}">
                                                    Preview Cover Buku</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center mb-3">
                                                @empty($buku->gambar_cover)
                                                    <img src="{{ URL::asset('assets/images/image-null.png') }}"
                                                        alt="{{ $buku->judul }}" class="img-fluid rounded"
                                                        style="max-height: 350px; width: 100%; object-fit: cover;">
                                                @else
                                                    <img src="{{ URL::asset($buku->gambar_cover) }}"
                                                        alt="{{ $buku->judul }}" class="img-fluid rounded"
                                                        style="max-height: 350px; width: 100%; object-fit: cover;">
                                                @endempty
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td class="text-center" colspan="8">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-alert-circle me-2"></i>
                            <small>Baris dengan latar merah menandakan buku dengan stok kurang dari atau sama
                                dengan minimal stok.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</x-layouts.admin.dashboard>
