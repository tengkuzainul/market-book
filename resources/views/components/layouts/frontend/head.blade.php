<head>
    <meta charset="utf-8">
    <title>Book's Shop &mdash; {{ $pageName }}</title>
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="{{ URL::asset('frontend/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ URL::asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="{{ URL::asset('frontend/css/style.css') }}" rel="stylesheet">

    <!-- Custom CSS for Book Cover Effects -->
    <style>
        .vesitable-img {
            position: relative;
            overflow: hidden;
        }

        .cover-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }

        .vesitable-img:hover .cover-overlay {
            opacity: 1;
        }

        .cover-detail-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 0.25rem;
        }

        .product-img:hover .cover-detail-overlay {
            opacity: 1;
        }

        .modal-xl {
            max-width: 1000px;
        }

        .modal-lg {
            max-width: 800px;
        }

        .modal-body img {
            max-height: 80vh;
            object-fit: contain;
        }

        .book-item {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .book-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Image zoom effect for product detail */
        .zoom-container {
            overflow: hidden;
            position: relative;
            height: 500px;
            width: 100%;
            border-radius: 0.25rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product-img {
            height: 100%;
            width: 100%;
        }

        .product-img img {
            transition: transform 0.3s ease;
            width: 100%;
            height: 100%;
            object-fit: contain;
            cursor: zoom-in;
        }

        .product-img img.zoom-effect {
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100%;
            transition: background-size 0.3s ease;
        }

        .product-img:hover img.zoom-effect {
            background-size: 150%;
            opacity: 1;
        }
    </style>
</head>
