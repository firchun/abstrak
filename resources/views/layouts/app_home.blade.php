<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Home' }} - {{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="description" content="This is meta description">
    <meta name="author" content="Themefisher">
    <link rel="shortcut icon" href="{{ asset('/img/musamus.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('/img/musamus.png') }}" type="image/x-icon">


    <!-- # Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- # CSS Plugins -->
    <link rel="stylesheet" href="{{ asset('/frontend_theme') }}/plugins/slick/slick.css">
    <link rel="stylesheet" href="{{ asset('/frontend_theme') }}/plugins/font-awesome/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('/frontend_theme') }}/plugins/font-awesome/brands.css">
    <link rel="stylesheet" href="{{ asset('/frontend_theme') }}/plugins/font-awesome/solid.css">

    <!-- # Main Style Sheet -->
    <link rel="stylesheet" href="{{ asset('/frontend_theme') }}/css/style.css">
</head>

<body>


    <!-- navigation -->
    <header class="navigation bg-tertiary">
        <nav class="navbar navbar-expand-xl navbar-light text-center py-3">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    <img loading="prelaod" decoding="async" class="img-fluid" width="80"
                        src="{{ asset('img/musamus.png') }}" alt="Wallet">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="#syarat">Syarat Pengajuan</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="#alur">Alur Pengajuan</a>
                        </li>
                    </ul>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Log In</a>
                        <a href="{{ route('register') }}" class="btn btn-primary ms-2 ms-lg-3">Sign Up</a>
                    @else
                        <a href="{{ url('/home') }}" class="btn btn-primary ms-2 ms-lg-3">Dashboard</a>
                    @endguest
                </div>
            </div>
        </nav>
    </header>
    <!-- /navigation -->


    @yield('content')


    <!-- footer Start -->

    <footer class="section-sm bg-tertiary">
        <div class="container">

            <div class="row align-items-center mt-5 text-center text-md-start">
                <div class="col-lg-4">
                    <a href="index.html">
                        <img loading="prelaod" decoding="async" class="img-fluid" width="50"
                            src="{{ asset('img/musamus.png') }}" alt="Wallet">
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">

                </div>
                <div class="col-lg-4 col-md-6 text-md-end mt-4 mt-md-0">
                    <ul class="list-unstyled list-inline mb-0 social-icons">
                        <li class="list-inline-item me-3"><a title="Explorer Facebook Profile" class="text-black"
                                href="https://facebook.com/"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li class="list-inline-item me-3"><a title="Explorer Twitter Profile" class="text-black"
                                href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item me-3"><a title="Explorer Instagram Profile" class="text-black"
                                href="https://instagram.com/"><i class="fab fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>



    <!-- # JS Plugins -->
    <script src="{{ asset('/frontend_theme') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('/frontend_theme') }}/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="{{ asset('/frontend_theme') }}/plugins/slick/slick.min.js"></script>
    <script src="{{ asset('/frontend_theme') }}/plugins/scrollmenu/scrollmenu.min.js"></script>

    <!-- Main Script -->
    <script src="{{ asset('/frontend_theme') }}/js/script.js"></script>
</body>

</html>
