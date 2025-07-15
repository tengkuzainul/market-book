<x-layouts.auth :pageName="$pageName ?? 'Register'">
    <form action="{{ route('register') }}" method="POST" class="need" novalidate>
        @csrf
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h3 class="mb-0"><b>Register</b></h3>
            <a href="{{ route('login') }}" class="link-primary">Sudah memiliki Akun?</a>
        </div>
        <div class="form-group mb-3">
            <label class="form-label" for="name">Nama Anda</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama anda..." autofocus
                autocomplete="name">
            @error('name')
                <div class="invalid-feedback">
                    <span class="text-capitalize">{{ $message }}</span>
                </div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label class="form-label" for="email">Alamat Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan alamat email anda..."
                autofocus autocomplete="email">
            @error('email')
                <div class="invalid-feedback">
                    <span class="text-capitalize">{{ $message }}</span>
                </div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" value="{{ old('password') }}" required
                class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password anda..."
                autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">
                    <span class="text-capitalize">{{ $message }}</span>
                </div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="Konfirmasi password anda..." autocomplete="new-password">
            @error('password_confirmation')
                <div class="invalid-feedback">
                    <span class="text-capitalize">{{ $message }}</span>
                </div>
            @enderror
        </div>
        <div class="d-flex mt-1 justify-content-start">
            <div class="form-check">
                <input class="form-check-input input-primary" type="checkbox" id="showHide">
                <label class="form-check-label text-muted" for="showHide">Lihat Password</label>
            </div>
        </div>
        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary" id="loginButton">
                <span class="spinner-border spinner-border-sm d-none me-2" id="loginSpinner" role="status"
                    aria-hidden="true"></span>
                Daftarkan Akun
            </button>
        </div>
    </form>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Password visibility toggle
                const passwordInput = document.getElementById('password');
                const showHideCheckbox = document.getElementById('showHide');

                showHideCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        passwordInput.type = 'text';
                    } else {
                        passwordInput.type = 'password';
                    }
                });

                // Loading indicator for form submission
                const form = document.querySelector('form.need');
                const loginButton = document.getElementById('loginButton');
                const loginSpinner = document.getElementById('loginSpinner');

                form.addEventListener('submit', function() {
                    loginButton.disabled = true;
                    loginSpinner.classList.remove('d-none');
                    loginButton.innerHTML =
                        `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...`;

                    // Form will still submit normally
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Password visibility toggle for both password fields
                const passwordInput = document.getElementById('password');
                const passwordConfirmationInput = document.getElementById('password_confirmation');
                const showHideCheckbox = document.getElementById('showHide');

                showHideCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        passwordInput.type = 'text';
                        passwordConfirmationInput.type = 'text';
                    } else {
                        passwordInput.type = 'password';
                        passwordConfirmationInput.type = 'password';
                    }
                });

                // Loading indicator for form submission
                const form = document.querySelector('form.need');
                const loginButton = document.getElementById('loginButton');
                const loginSpinner = document.getElementById('loginSpinner');

                form.addEventListener('submit', function() {
                    loginButton.disabled = true;
                    loginSpinner.classList.remove('d-none');
                    loginButton.innerHTML =
                        `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...`;
                });
            });
        </script>
    @endpush
</x-layouts.auth>
