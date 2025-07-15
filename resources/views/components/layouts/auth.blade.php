<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->
@include('components.layouts.admin.head', ['pageName' => $pageName ?? __('No Title')])
<!-- [Head] end -->

<!-- [Body] Start -->

<body>
    @include('sweetalert::alert')

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <div class="auth-main">
        <div class="auth-wrapper v3">
            <div class="auth-form">
                <div class="auth-header">
                    <a href="{{ url('/') }}" class=""><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                </div>
                <div class="card my-5">
                    <div class="card-body">

                        {{ $slot }}

                        <div class="saprator mt-3">
                            <span>Selamat Datang Kembali 😊</span>
                        </div>
                    </div>
                </div>
                <div class="auth-footer row">
                    <!-- <div class=""> -->
                    <div class="col my-1">
                        <p class="m-0">Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}"
                                target="_blank">Book
                                Shop</a> | All Rights Reserved</p>
                    </div>
                    <div class="col-auto my-1">
                        <ul class="list-inline footer-link mb-0">
                            <li class="list-inline-item"><a href="{{ url('/') }}">Home Page</a></li>
                        </ul>
                    </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Required Js -->
    <script src="{{ URL::asset('assets') }}/js/plugins/popper.min.js"></script>
    <script src="{{ URL::asset('assets') }}/js/plugins/simplebar.min.js"></script>
    <script src="{{ URL::asset('assets') }}/js/plugins/bootstrap.min.js"></script>
    <script src="{{ URL::asset('assets') }}/js/fonts/custom-font.js"></script>
    <script src="{{ URL::asset('assets') }}/js/pcoded.js"></script>
    <script src="{{ URL::asset('assets') }}/js/plugins/feather.min.js"></script>
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
</body>
<!-- [Body] end -->

</html>
