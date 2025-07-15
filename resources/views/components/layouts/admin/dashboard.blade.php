<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- [Head] start -->
@include('components.layouts.admin.head', ['pageName' => $pageName ?? 'No Title'])
<!-- [Head] end -->

<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    @include('sweetalert::alert')

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Sidebar Menu ] start -->
    <x-layouts.admin.sidebar />
    <!-- [ Sidebar Menu ] end -->

    <!-- [ Header Topbar ] start -->
    <x-layouts.admin.header />
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <x-layouts.admin.breadcrumbs :breadcrumbs="$breadcrumbs ?? []" :currentPage="$currentPage ?? ''" />
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                {{ $slot }}
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col-sm my-1">
                    <p class="m-0">Copyright &copy; {{ date('Y') }} <a href="{{ route('dashboard') }}"
                            target="_blank">Book
                            Shop</a> &mdash; All Rights Reserved</p>
                </div>
                <div class="col-auto my-1">
                    <ul class="list-inline footer-link mb-0">
                        <li class="list-inline-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="list-inline-item"><a href="{{ route('profile.edit') }}">Profile</a></li>
                        <li class="list-inline-item"><a href="{{ route('profile.password') }}">Reset Password</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- [Page Specific JS] start -->
    {{-- <script src="{{ URL::asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard-default.js') }}"></script> --}}
    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <script src="{{ URL::asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins/feather.min.js') }}"></script>
    <script>
        layout_change('light');
    </script>
    <script>
        change_box_container('false');
    </script>
    <script>
        layout_rtl_change('false');
    </script>
    <script>
        preset_change("preset-1");
    </script>
    <script>
        font_change("Public-Sans");
    </script>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all forms with the needs-validation class
            const forms = document.querySelectorAll('form.needs-validation');

            forms.forEach(form => {
                const submitButton = form.querySelector('button[type="submit"]');

                if (submitButton) {
                    form.addEventListener('submit', function() {
                        // Store original button content
                        const originalContent = submitButton.innerHTML;

                        // Disable button and show loading spinner
                        submitButton.disabled = true;
                        submitButton.innerHTML =
                            `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...`;

                        // Allow form to submit normally
                    });
                }
            });
        });
    </script>
</body>
<!-- [Body] end -->

</html>
