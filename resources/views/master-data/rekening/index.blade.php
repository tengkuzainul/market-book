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
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                            data-bs-target="#rekeningCreate">
                            <i class="ti ti-plus me-1"></i>Tambah Data
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="rekeningCreate" tabindex="-1" aria-labelledby="rekeningCreateLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="rekeningCreateLabel">Form Tambah
                                            {{ $pageName }}
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('rekening.store') }}" method="POST" class="needs-validation"
                                        enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="nama_bank">
                                                            Nama Bank <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" id="nama_bank" name="nama_bank"
                                                            value="{{ old('nama_bank') }}" required
                                                            class="form-control @error('nama_bank') is-invalid @enderror"
                                                            placeholder="Masukkan nama bank..." autofocus>
                                                        @error('nama_bank')
                                                            <div class="invalid-feedback">
                                                                <span class="text-capitalize">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="nama_pemilik">
                                                            Nama Pemilik <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" id="nama_pemilik" name="nama_pemilik"
                                                            value="{{ old('nama_pemilik') }}" required
                                                            class="form-control @error('nama_pemilik') is-invalid @enderror"
                                                            placeholder="Masukkan nama pemilik rekening...">
                                                        @error('nama_pemilik')
                                                            <div class="invalid-feedback">
                                                                <span class="text-capitalize">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="nomor_rekening">
                                                            Nomor Rekening <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" id="nomor_rekening" name="nomor_rekening"
                                                            value="{{ old('nomor_rekening') }}" required
                                                            class="form-control @error('nomor_rekening') is-invalid @enderror"
                                                            placeholder="Masukkan nomor rekening...">
                                                        @error('nomor_rekening')
                                                            <div class="invalid-feedback">
                                                                <span class="text-capitalize">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="status">
                                                            Status <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="status" id="status"
                                                            class="form-select @error('status') is-invalid @enderror"
                                                            required>
                                                            <option value="" selected disabled>Pilih Status
                                                            </option>
                                                            <option value="aktif"
                                                                {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                                            </option>
                                                            <option value="non-aktif"
                                                                {{ old('status') == 'non-aktif' ? 'selected' : '' }}>
                                                                Non-Aktif</option>
                                                        </select>
                                                        @error('status')
                                                            <div class="invalid-feedback">
                                                                <span class="text-capitalize">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="logo">
                                                    Logo Bank
                                                </label>
                                                <input type="file" id="logo" name="logo"
                                                    class="form-control @error('logo') is-invalid @enderror"
                                                    accept="image/*">
                                                <small class="text-muted">Format: JPG, JPEG, PNG, GIF. Maks:
                                                    2MB</small>
                                                @error('logo')
                                                    <div class="invalid-feedback">
                                                        <span class="text-capitalize">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mt-2" id="previewCreate"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"
                                                class="btn btn-outline-secondary d-flex align-items-center"
                                                data-bs-dismiss="modal"><i
                                                    class="ti ti-x me-1"></i><span>Tutup</span></button>
                                            <button type="Submit"
                                                class="btn btn-success d-flex align-items-center"><i
                                                    class="ti ti-circle-check me-1"></i><span>Simpan
                                                    Data</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                                    <th class="text-uppercase">No</th>
                                    <th class="text-uppercase">Logo</th>
                                    <th class="text-uppercase">Nama Bank</th>
                                    <th class="text-uppercase">Nama Pemilik</th>
                                    <th class="text-uppercase">Nomor Rekening</th>
                                    <th class="text-uppercase">Status</th>
                                    <th class="text-end text-uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rekenings as $rekening)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($rekening->logo)
                                                <img src="{{ asset('image/logo_bank/' . $rekening->logo) }}"
                                                    alt="{{ $rekening->nama_bank }}" class="rounded"
                                                    style="max-height: 40px; max-width: 80px;">
                                            @else
                                                <span class="badge bg-light-secondary text-secondary">No Logo</span>
                                            @endif
                                        </td>
                                        <td>{{ $rekening->nama_bank }}</td>
                                        <td>{{ $rekening->nama_pemilik }}</td>
                                        <td>{{ $rekening->nomor_rekening }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $rekening->status == 'aktif' ? 'success' : 'danger' }}">
                                                {{ $rekening->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-dark rounded"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rekeningUpdate-{{ $rekening->id }}">
                                                    <i class="ti ti-edit me-1"></i>Edit
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="rekeningUpdate-{{ $rekening->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="rekeningUpdate-{{ $rekening->id }}-Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="rekeningUpdate-{{ $rekening->id }}-Label">
                                                                    Form
                                                                    Edit {{ $pageName }}</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route('rekening.update', $rekening->id) }}"
                                                                method="POST" class="needs-validation"
                                                                enctype="multipart/form-data" novalidate>
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group mb-3">
                                                                                <label class="form-label"
                                                                                    for="edit_nama_bank_{{ $rekening->id }}">
                                                                                    Nama Bank <span
                                                                                        class="text-danger">*</span>
                                                                                </label>
                                                                                <input type="text"
                                                                                    id="edit_nama_bank_{{ $rekening->id }}"
                                                                                    name="nama_bank"
                                                                                    value="{{ old('nama_bank', $rekening->nama_bank) }}"
                                                                                    required
                                                                                    class="form-control @error('nama_bank') is-invalid @enderror"
                                                                                    placeholder="Masukkan nama bank...">
                                                                                @error('nama_bank')
                                                                                    <div class="invalid-feedback">
                                                                                        <span
                                                                                            class="text-capitalize">{{ $message }}</span>
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group mb-3">
                                                                                <label class="form-label"
                                                                                    for="edit_nama_pemilik_{{ $rekening->id }}">
                                                                                    Nama Pemilik <span
                                                                                        class="text-danger">*</span>
                                                                                </label>
                                                                                <input type="text"
                                                                                    id="edit_nama_pemilik_{{ $rekening->id }}"
                                                                                    name="nama_pemilik"
                                                                                    value="{{ old('nama_pemilik', $rekening->nama_pemilik) }}"
                                                                                    required
                                                                                    class="form-control @error('nama_pemilik') is-invalid @enderror"
                                                                                    placeholder="Masukkan nama pemilik rekening...">
                                                                                @error('nama_pemilik')
                                                                                    <div class="invalid-feedback">
                                                                                        <span
                                                                                            class="text-capitalize">{{ $message }}</span>
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group mb-3">
                                                                                <label class="form-label"
                                                                                    for="edit_nomor_rekening_{{ $rekening->id }}">
                                                                                    Nomor Rekening <span
                                                                                        class="text-danger">*</span>
                                                                                </label>
                                                                                <input type="text"
                                                                                    id="edit_nomor_rekening_{{ $rekening->id }}"
                                                                                    name="nomor_rekening"
                                                                                    value="{{ old('nomor_rekening', $rekening->nomor_rekening) }}"
                                                                                    required
                                                                                    class="form-control @error('nomor_rekening') is-invalid @enderror"
                                                                                    placeholder="Masukkan nomor rekening...">
                                                                                @error('nomor_rekening')
                                                                                    <div class="invalid-feedback">
                                                                                        <span
                                                                                            class="text-capitalize">{{ $message }}</span>
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group mb-3">
                                                                                <label class="form-label"
                                                                                    for="edit_status_{{ $rekening->id }}">
                                                                                    Status <span
                                                                                        class="text-danger">*</span>
                                                                                </label>
                                                                                <select name="status"
                                                                                    id="edit_status_{{ $rekening->id }}"
                                                                                    class="form-select @error('status') is-invalid @enderror"
                                                                                    required>
                                                                                    <option value="" disabled>
                                                                                        Pilih Status</option>
                                                                                    <option value="aktif"
                                                                                        {{ old('status', $rekening->status) == 'aktif' ? 'selected' : '' }}>
                                                                                        Aktif</option>
                                                                                    <option value="non-aktif"
                                                                                        {{ old('status', $rekening->status) == 'non-aktif' ? 'selected' : '' }}>
                                                                                        Non-Aktif</option>
                                                                                </select>
                                                                                @error('status')
                                                                                    <div class="invalid-feedback">
                                                                                        <span
                                                                                            class="text-capitalize">{{ $message }}</span>
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label"
                                                                            for="edit_logo_{{ $rekening->id }}">
                                                                            Logo Bank
                                                                        </label>
                                                                        <input type="file"
                                                                            id="edit_logo_{{ $rekening->id }}"
                                                                            name="logo"
                                                                            class="form-control @error('logo') is-invalid @enderror"
                                                                            accept="image/*">
                                                                        <small class="text-muted">Format: JPG, JPEG,
                                                                            PNG, GIF. Maks: 2MB</small>
                                                                        @error('logo')
                                                                            <div class="invalid-feedback">
                                                                                <span
                                                                                    class="text-capitalize">{{ $message }}</span>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mt-3"
                                                                        id="previewEdit{{ $rekening->id }}">
                                                                        @if ($rekening->logo)
                                                                            <div class="mt-2">
                                                                                <strong>Logo Saat Ini:</strong><br>
                                                                                <img src="{{ asset('image/logo_bank/' . $rekening->logo) }}"
                                                                                    alt="{{ $rekening->nama_bank }}"
                                                                                    class="mt-2 img-thumbnail"
                                                                                    style="max-height: 100px;">
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-outline-secondary d-flex align-items-center"
                                                                        data-bs-dismiss="modal"><i
                                                                            class="ti ti-x me-1"></i><span>Tutup</span></button>
                                                                    <button type="Submit"
                                                                        class="btn btn-success d-flex align-items-center">
                                                                        <i class="ti ti-circle-check me-1"></i><span>Simpan
                                                                            Data</span></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="{{ route('rekening.destroy', $rekening->id) }}"
                                                    data-confirm-delete="true"
                                                    class="btn btn-sm btn-danger rounded delete-btn">
                                                    <i class="ti ti-trash me-1"></i>Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">Data tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk Preview Image -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preview untuk Create
            const logoInput = document.getElementById('logo');
            const previewCreate = document.getElementById('previewCreate');

            if (logoInput) {
                logoInput.addEventListener('change', function() {
                    previewCreate.innerHTML = '';
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewCreate.innerHTML = `
                                <div class="mt-2">
                                    <strong>Preview:</strong><br>
                                    <img src="${e.target.result}" class="mt-2 img-thumbnail" style="max-height: 100px;">
                                </div>
                            `;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Preview untuk Edit
            @foreach ($rekenings as $rekening)
                const editLogoInput{{ $rekening->id }} = document.getElementById('edit_logo_{{ $rekening->id }}');
                const previewEdit{{ $rekening->id }} = document.getElementById('previewEdit{{ $rekening->id }}');

                if (editLogoInput{{ $rekening->id }}) {
                    editLogoInput{{ $rekening->id }}.addEventListener('change', function() {
                        const currentPreview = previewEdit{{ $rekening->id }}.querySelector('div');
                        if (currentPreview) {
                            currentPreview.remove();
                        }

                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                previewEdit{{ $rekening->id }}.innerHTML = `
                                    <div class="mt-2">
                                        <strong>Preview:</strong><br>
                                        <img src="${e.target.result}" class="mt-2 img-thumbnail" style="max-height: 100px;">
                                    </div>
                                `;
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }
            @endforeach
        });
    </script>
</x-layouts.admin.dashboard>
