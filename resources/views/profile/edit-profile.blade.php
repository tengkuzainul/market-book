<x-layouts.admin.dashboard :title="$title ?? 'No title'" :currentPage="$currentPage ?? 'Dashboard'" :breadcrumbs="$breadcrumbs ?? []">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body position-relative">
                        <div class="text-center">
                            <div class="chat-avtar d-inline-flex mx-auto">
                                <img class="rounded-circle img-fluid wid-120" src="../assets/images/user/avatar-5.jpg"
                                    alt="User image">
                            </div>
                            <h5 class="mt-3">{{ $user->name }}</h5>
                            <p class="text-muted">{{ $user->role }}</p>
                            <div class="row g-3 my-4">
                                <div class="col-6">
                                    <h5 class="mb-0">Email</h5>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-0">Verified</h5>
                                    <small class="badge bg-success"><i
                                            class="ti ti-circle-check me-2"></i>Verified</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-circle-check me-2"></i><strong>Berhasil!</strong> Profile anda berhasil di
                        update.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="tab-content" id="user-set-tabContent">
                    <div class="tab-pane fade show active" id="user-cont-1" role="tabpanel">
                        @if (request()->routeIs('profile.edit'))
                            <div class="card">
                                <form action="{{ route('profile.update') }}" method="POST" class="needs-validation"
                                    novalidate>
                                    @csrf
                                    @method('PATCH')
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5>Informasi Data Akun</h5>
                                                <hr class="mb-4">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="name">Nama</label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ $user->name }}" id="name" name="name">
                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            <span class="text-capitalize">{{ $message }}</span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="email">Alamat Email</label>
                                                    <input type="email" name="email" id="email"
                                                        class="form-control" value="{{ $user->email }}">
                                                </div>
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        <span class="text-capitalize">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end btn-page">
                                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Batal &
                                            Kembali</a>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="card">
                                <form action="{{ route('profile.update.password') }}" method="POST"
                                    class="needs-validation" novalidate>
                                    @csrf
                                    @method('PATCH')
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5>Reset Password</h5>
                                                <hr class="mb-4">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="current_password">Password
                                                        Sekarang</label>
                                                    <input type="password"
                                                        class="form-control @error('current_password', 'passwordUpdate') is-invalid @enderror"
                                                        value="{{ old('current_password') }}" id="current_password"
                                                        name="current_password">
                                                    @error('current_password', 'passwordUpdate')
                                                        <div class="invalid-feedback">
                                                            <span class="text-capitalize">{{ $message }}</span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="newPassword">Password Baru</label>
                                                    <input type="password"
                                                        class="form-control @error('newPassword', 'passwordUpdate') is-invalid @enderror"
                                                        value="{{ old('newPassword') }}" id="newPassword"
                                                        name="newPassword">
                                                    @error('newPassword', 'passwordUpdate')
                                                        <div class="invalid-feedback">
                                                            <span class="text-capitalize">{{ $message }}</span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="newPassword_confirmation">Konfirmasi
                                                        Password
                                                        Baru</label>
                                                    <input type="password"
                                                        class="form-control @error('newPassword_confirmation', 'passwordUpdate') is-invalid @enderror"
                                                        value="{{ old('newPassword_confirmation') }}"
                                                        id="newPassword_confirmation" name="newPassword_confirmation">
                                                    @error('newPassword_confirmation', 'passwordUpdate')
                                                        <div class="invalid-feedback">
                                                            <span class="text-capitalize">{{ $message }}</span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end btn-page">
                                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Batal &
                                            Kembali</a>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin.dashboard>
