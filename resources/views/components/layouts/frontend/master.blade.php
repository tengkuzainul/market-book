<!DOCTYPE html>
<html lang="en">

@include('components.layouts.frontend.head', ['pageName' => $pageName ?? __('No Title')])

<body>
    @include('sweetalert::alert')

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-border text-warning" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar start -->
    <x-layouts.frontend.navbar />
    <!-- Navbar End -->

    {{ $slot }}


    <x-layouts.frontend.footer />

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="{{ URL::asset('frontend/lib/easing/easing.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/lib/easing/easing.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <!-- Template Javascript -->
    <script src="{{ URL::asset('frontend/js/main.js') }}"></script>

    <!-- Custom Javascript for Book Cover Effects -->
    <script>
        $(document).ready(function() {
            // Initialize modals
            var coverModals = document.querySelectorAll('.modal');
            coverModals.forEach(function(modal) {
                new bootstrap.Modal(modal);
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover'
                });
            });

            // Image zoom effect for product detail
            $('.product-img img.zoom-effect').each(function() {
                var $this = $(this);
                var imgSrc = $this.attr('style').match(/url\(['"]?([^'")]+)['"]?\)/)[1];
                $this.css('background-image', 'url(' + imgSrc + ')');
            });

            $('.product-img img.zoom-effect').on('mousemove', function(e) {
                if ($(window).width() > 768) {
                    var zoomer = e.currentTarget;
                    var offsetX = e.offsetX ? e.offsetX : e.touches[0].pageX;
                    var offsetY = e.offsetY ? e.offsetY : e.touches[0].pageY;
                    var x = offsetX / zoomer.offsetWidth * 100;
                    var y = offsetY / zoomer.offsetHeight * 100;
                    zoomer.style.backgroundPosition = x + '% ' + y + '%';
                }
            });

            // Remove zoom effect when mouse leaves
            $('.product-img img.zoom-effect').on('mouseleave', function() {
                $(this).css('background-position', 'center');
            });

            // Quantity buttons in product detail
            $('.btn-minus').on('click', function() {
                var inputVal = parseInt($(this).closest('.quantity').find('input').val());
                if (inputVal > 1) {
                    $(this).closest('.quantity').find('input').val(inputVal - 1);
                }
            });

            $('.btn-plus').on('click', function() {
                var inputVal = parseInt($(this).closest('.quantity').find('input').val());
                $(this).closest('.quantity').find('input').val(inputVal + 1);
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
