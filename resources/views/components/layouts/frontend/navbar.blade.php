<div class="container-fluid fixed-top">
    <div class="container topbar bg-dark d-none d-lg-block">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3 text-white"><i class="fas fa-smile me-2"></i> Hallo Guys! Selamat Datang Di Toko
                    Kami</small>
                <small class="me-3 text-white"><i class="fas fa-shopping-cart me-2"></i><a
                        href="{{ route('frontend.home') }}" class="text-white">Shop's Books</a></small>
            </div>
            <div class="top-link pe-2">
                @auth
                    <a href="#" class="text-white" data-bs-toggle="modal" data-bs-target="#profileModal"><small
                            class="text-white mx-2">Profile</small>|</a>
                    <a href="#" class="text-white" data-bs-toggle="modal" data-bs-target="#passwordModal"><small
                            class="text-white mx-2">Ganti Password</small></a>
                @endauth
            </div>
        </div>
    </div>
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="{{ url('/') }}" class="navbar-brand">
                <h1 class="text-warning display-6">Shop's Books</h1>
            </a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="{{ route('frontend.home') }}"
                        class="nav-item nav-link {{ request()->routeIs('frontend.home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('frontend.products') }}"
                        class="nav-item nav-link {{ request()->routeIs('frontend.products') || request()->routeIs('frontend.category') || request()->routeIs('frontend.product.detail') ? 'active' : '' }}">Produk
                        Kami</a>
                    <a href="{{ route('frontend.contact') }}"
                        class="nav-item nav-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}">Hubungi
                        Kami</a>
                </div>
                <div class="d-flex m-3 me-0">
                    @auth
                        <a href="{{ route('customer.orders.index') }}"
                            class="position-relative me-4 my-auto {{ request()->routeIs('customer.orders.*') ? 'text-primary' : '' }}">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                        </a>
                        <a href="{{ route('refunds.index') }}"
                            class="position-relative me-4 my-auto {{ request()->routeIs('refunds.*') ? 'text-primary' : '' }}">
                            <i class="fa fa-money-bill fa-2x"></i>
                        </a>
                        <a href="{{ route('customer.cart.index') }}"
                            class="position-relative me-4 my-auto {{ request()->routeIs('customer.cart.*') ? 'text-primary' : '' }}">
                            <i class="fa fa-shopping-cart fa-2x"></i>
                            @if (auth()->check() && auth()->user()->keranjang->count() > 0)
                                <span
                                    class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                    style="top: -5px; left: 15px; height: 20px; min-width: 20px;">{{ auth()->user()->keranjang->count() }}</span>
                            @endif
                        </a>
                        <a href="#" class="my-auto d-flex align-items-center gap-2" data-bs-toggle="modal"
                            data-bs-target="#profileModal">
                            <i class="fas fa-user fa-2x"></i>
                            <span class="text-sm">{{ Auth::user()->name }}</span>
                        </a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit()"
                            class="my-auto ms-4" title="Logout">
                            <i class="fas fa-sign-out-alt fa-2x"></i>
                        </a>

                        <form action="{{ route('logout') }}" id="logout-form" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary px-4 my-auto">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-secondary px-4 my-auto ms-2">Daftar</a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>
</div>

@auth
    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="profileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ Auth::user()->name }}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ Auth::user()->email }}" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="passwordModalLabel">Ganti Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update.password') }}" id="passwordForm">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password"
                                class="form-control @error('current_password', 'passwordUpdate') is-invalid @enderror"
                                id="current_password" name="current_password" required>
                            @error('current_password', 'passwordUpdate')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Password Baru</label>
                            <input type="password"
                                class="form-control @error('newPassword', 'passwordUpdate') is-invalid @enderror"
                                id="newPassword" name="newPassword" required>
                            @error('newPassword', 'passwordUpdate')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="newPassword_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password"
                                class="form-control @error('newPassword_confirmation', 'passwordUpdate') is-invalid @enderror"
                                id="newPassword_confirmation" name="newPassword_confirmation" required>
                            @error('newPassword_confirmation', 'passwordUpdate')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Password Baru</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check for profile errors and success messages
            @if ($errors->any() || session('success'))
                @if (
                    $errors->has('name') ||
                        $errors->has('email') ||
                        (session('success') && strpos(session('success'), 'Profile') !== false))
                    var profileModal = new bootstrap.Modal(document.getElementById('profileModal'));
                    profileModal.show();
                @endif

                @if (
                    $errors->getBag('passwordUpdate')->any() ||
                        (session('success') && strpos(session('success'), 'Password') !== false))
                    var passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
                    passwordModal.show();
                @endif
            @endif
        });
    </script>
@endauth
