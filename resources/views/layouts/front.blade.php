<!DOCTYPE html>
<html lang="en">
<head>
    <title>Desi Naumova</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('assets/bootstrap-5.0.2/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine|Handlee|Gochi+Hand|Kalam"/>
    <link href="{{ asset('assets/css/custom.css') }}" type="text/css" rel="stylesheet"/>
    @yield('css_files')
    @yield('head_js')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="navbar-logo">
            <a class="navbar-brand" href="{{ route('front.index') }}">Desi Naumova</a>
        </div>

        <div class="navbar-cart">
            <i class="fas fa-shopping-cart">
                <span class="cart-badge" id="cart-items-num">0</span>
            </i>
        </div>

        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <!-- Right part with menu -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('front.index') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            @if(isset($products_categories) && $products_categories->count())
                @foreach($products_categories as $slug => $title)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.to_category', ['category' => $slug]) }}">{{ $title }}</a>
                    </li>
                @endforeach
            @endif
            <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
            </li>
        </ul>
    </div>
</nav>

@yield('content')
<footer class="bg-dark text-light text-center py-3 bottom-0">
    <div class="container">
        <p>&copy; {{ date('Y') }} Desi Naumova. All rights reserved.</p>
    </div>
</footer>
<script src="{{ asset('assets/bootstrap-5.0.2/js/bootstrap.bundle.js') }}"></script>
@yield('js_files')
</body>
</html>
