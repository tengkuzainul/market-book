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
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#userCreate">
                            <i class="ti ti-plus me-1"></i>Tambah Data
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="userCreate" tabindex="-1" aria-labelledby="userCreateLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="userCreateLabel">Form Tambah Pengguna</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('pengguna.store') }}" method="POST" class="needs-validation"
                                        novalidate>
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="nama">Nama Lengkap</label>
                                                <input type="text" id="nama" name="nama"
                                                    value="{{ old('nama') }}" required
                                                    class="form-control @error('nama') is-invalid @enderror"
                                                    placeholder="Masukkan nama pengguna..." autofocus
                                                    autocomplete="name">
                                                @error('nama')
                                                    <div class="invalid-feedback">
                                                        <span class="text-capitalize">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="email">Alamat Email</label>
                                                <input type="email" id="email" name="email"
                                                    value="{{ old('email') }}" required
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="Masukkan email pengguna..." autofocus
                                                    autocomplete="email">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        <span class="text-capitalize">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="password">Password</label>
                                                <input type="password" id="password" name="password"
                                                    value="{{ old('password') }}" required
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Masukkan password pengguna..." autofocus
                                                    autocomplete="password">
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        <span class="text-capitalize">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="role">Role</label>
                                                <select class="form-select @error('role') is-invalid @enderror"
                                                    id="role" name="role" aria-label="Default select example">
                                                    <option selected disabled>Pilih Role Pengguna</option>
                                                    <option value="Administrator"
                                                        {{ old('role') == 'Administrator' ? 'selected' : '' }}>
                                                        Administrator</option>
                                                    <option value="Customer"
                                                        {{ old('role') == 'Customer' ? 'selected' : '' }}>Customer
                                                    </option>
                                                </select>
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        <span class="text-capitalize">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"
                                                class="btn btn-outline-secondary d-flex align-items-center"
                                                data-bs-dismiss="modal"><i
                                                    class="ti ti-x me-1"></i><span>Tutup</span></button>
                                            <button type="Submit" class="btn btn-success d-flex align-items-center"><i
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
                                    <th class="text-uppercase">Nama</th>
                                    <th class="text-uppercase">Email</th>
                                    <th class="text-uppercase">Role</th>
                                    <th class="text-end text-uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="d-flex align-items-center gap-1">
                                            <img src="{{ 'https://ui-avatars.com/api/?name=' . Auth::user()->name . '&rounded=true&color=fff&background=178fff' }}"
                                                class="rounded-circle" style="width: 40px;" alt="Avatar" />
                                            <span>{{ $user->name }}</span>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $user->role == 'Customer' ? 'primary' : 'warning' }} mx-2 my-1 rounded">{{ $user->role }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-dark rounded"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#userEdit-{{ $user->id }}-">
                                                    <i class="ti ti-edit me-1"></i>Edit
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="userEdit-{{ $user->id }}-"
                                                    tabindex="-1"
                                                    aria-labelledby="userEdit-{{ $user->id }}-Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="userEdit-{{ $user->id }}-Label">Form
                                                                    Edit Pengguna</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('pengguna.update', $user->id) }}"
                                                                method="POST" class="needs-validation" novalidate>
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label" for="nama">Nama
                                                                            Lengkap</label>
                                                                        <input type="text" id="nama"
                                                                            name="nama"
                                                                            value="{{ old('nama', $user->name) }}"
                                                                            required
                                                                            class="form-control @error('nama') is-invalid @enderror"
                                                                            placeholder="Masukkan nama pengguna..."
                                                                            autofocus autocomplete="name">
                                                                        @error('nama')
                                                                            <div class="invalid-feedback">
                                                                                <span
                                                                                    class="text-capitalize">{{ $message }}</span>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label"
                                                                            for="email">Alamat
                                                                            Email</label>
                                                                        <input type="email" id="email"
                                                                            name="email"
                                                                            value="{{ old('email', $user->email) }}"
                                                                            required
                                                                            class="form-control @error('email') is-invalid @enderror"
                                                                            placeholder="Masukkan email pengguna..."
                                                                            autofocus autocomplete="email">
                                                                        @error('email')
                                                                            <div class="invalid-feedback">
                                                                                <span
                                                                                    class="text-capitalize">{{ $message }}</span>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label"
                                                                            for="role">Role</label>
                                                                        <select
                                                                            class="form-select @error('role') is-invalid @enderror"
                                                                            id="role" name="role"
                                                                            aria-label="Default select example">
                                                                            <option selected disabled>Pilih Role
                                                                                Pengguna</option>
                                                                            <option value="Administrator"
                                                                                {{ old('role', $user->role) == 'Administrator' ? 'selected' : '' }}>
                                                                                Administrator</option>
                                                                            <option value="Customer"
                                                                                {{ old('role', $user->role) == 'Customer' ? 'selected' : '' }}>
                                                                                Customer</option>
                                                                        </select>
                                                                        @error('role')
                                                                            <div class="invalid-feedback">
                                                                                <span
                                                                                    class="text-capitalize">{{ $message }}</span>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label"
                                                                            for="password">Password
                                                                            (Kosongkan jika
                                                                            tidak ingin mengganti)
                                                                        </label>
                                                                        <input type="password" id="password"
                                                                            name="password"
                                                                            value="{{ old('password') }}"
                                                                            class="form-control @error('password') is-invalid @enderror"
                                                                            placeholder="Masukkan password pengguna..."
                                                                            autocomplete="password">
                                                                        @error('password')
                                                                            <div class="invalid-feedback">
                                                                                <span
                                                                                    class="text-capitalize">{{ $message }}</span>
                                                                            </div>
                                                                        @enderror
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

                                                <a href="{{ route('pengguna.destroy', $user->id) }}"
                                                    data-confirm-delete="true"
                                                    class="btn btn-sm btn-danger rounded delete-btn">
                                                    <i class="ti ti-trash me-1"></i>Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="5">Data tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin.dashboard>
