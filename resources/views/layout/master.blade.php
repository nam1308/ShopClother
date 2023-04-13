<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MultiShop - Online Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href={{ asset('lib/animate/animate.min.css" rel="stylesheet') }}>
    <link href={{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }} rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href={{ asset('css/style.css') }} rel="stylesheet">
    @stack('css')
    <style>
        /* .container-spin {
            position: fixed;
            display: inline-block;
            box-sizing: border-box;
            padding: 30px;
            width: 25%;
            height: 140px;
            z-index: 10;
            top: 50%;
            left: 50%;
            transform: translate(-23%, -28%)
        }


        .circle {
            box-sizing: border-box;
            width: 5rem;
            height: 5rem;
            border-radius: 100%;
            border: 10px solid rgba(133, 130, 128, .3);
            border-top-color: yellow;
            animation: spin 1s infinite linear;
        }

        .circleloader {
            position: absolute;
            box-sizing: border-box;
            top: 50%;
            margin-top: -10px;
            border-radius: 16px;
            width: 80px;
            height: 20px;
            padding: 4px;
            background: rgba(255, 255, 255, 0.4);
        }

        .circleloader:before {
            content: '';
            position: absolute;
            border-radius: 16px;
            width: 20px;
            height: 12px;
            left: 0;
            background: #fff;
            animation: push 1s infinite linear;
        }


        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        } */

        #preloder {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999999;
            background: #000;
        }

        .loader {
            width: 40px;
            height: 40px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -13px;
            margin-left: -13px;
            border-radius: 60px;
            animation: loader 0.8s linear infinite;
            -webkit-animation: loader 0.8s linear infinite;
        }

        @keyframes loader {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
                border: 4px solid yellow;
                border-left-color: transparent;
            }

            50% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
                border: 4px solid yellow;
                border-left-color: transparent;
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
                border: 4px solid yellow;
                border-left-color: transparent;
            }
        }

        @-webkit-keyframes loader {
            0% {
                -webkit-transform: rotate(0deg);
                border: 4px solid yellow;
                border-left-color: transparent;
            }

            50% {
                -webkit-transform: rotate(180deg);
                border: 4px solid yellow;
                border-left-color: transparent;
            }

            100% {
                -webkit-transform: rotate(360deg);
                border: 4px solid yellow;
                border-left-color: transparent;
            }
        }
    </style>
</head>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>
    {{-- <div class="container-spin">
        <div class="circle"></div>
    </div> --}}
    <!-- Topbar Start -->
    @include('layout.topbar')
    <!-- Topbar End -->


    <!-- Navbar Start -->
    @include('layout.navbar')
    <!-- Navbar End -->


    @yield('content')
    <!-- Footer Start -->
    @include('layout.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    @yield('modal')
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src={{ asset('lib/easing/easing.min.js') }}></script>
    <script src={{ asset('lib/owlcarousel/owl.carousel.min.js') }}></script>

    <!-- Contact Javascript File -->
    <script src={{ asset('mail/jqBootstrapValidation.min.js') }}></script>
    <script src={{ asset('mail/contact.js') }}></script>

    <!-- Template Javascript -->
    <script src={{ asset('js/main.js') }}></script>
    @stack('js')
    <script>
        // $(window).on("load", function() {
        //     $(".container-spin").fadeOut("fast");
        // });
        $(window).on('load', function() {
            // $(".container-spin").fadeOut();
            // $(".circle").delay(10).fadeOut("slow");
            $(".loader").fadeOut();
            $("#preloder").delay(200).fadeOut("slow");
            // /*------------------
            //     Gallery filter
            // --------------------*/
            // $('.filter__controls li').on('click', function() {
            //     $('.filter__controls li').removeClass('active');
            //     $(this).addClass('active');
            // });
            // if ($('.product__filter').length > 0) {
            //     var containerEl = document.querySelector('.product__filter');
            //     var mixer = mixitup(containerEl);
            // }
        });
    </script>
</body>

</html>
