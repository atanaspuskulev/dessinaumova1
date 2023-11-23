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
            <div class="cart-dropdown">
                <i class="fas fa-shopping-cart" id="cart-icon" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="cart-badge" id="cart-items-num">{{ $cart_items['total_count'] }}</span>
                </i>
                <div class="dropdown-menu" aria-labelledby="cart-icon">
                    <div class="cart-items-list">
                        @foreach($cart_items['cart_products'] as $item)
                            <div class="cart-item row border-bottom py-2">
                                <div class="col-md-8 font-12">
                                    <span>{{ $item['title'] }}</span>
                                </div>
                                <div class="col-md-4">
                                    <img
                                        @if($item['thumbnail'])
                                            src="{{ displayImage($item['id'], $item['thumbnail']['path'], true) }}"
                                        @else
                                            src="{{ displayImage($item['id'], null, true) }}"
                                        @endif
                                        alt="{{ $item['title'] }}"
                                        class="img-thumbnail" style="max-width: 50px;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="" class="btn btn-primary">Checkout</a>
                </div>
            </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var cartIcon = document.getElementById('cart-icon');

        if (cartIcon) {
            cartIcon.addEventListener('click', function () {
                let cartDropdown = document.querySelector('.cart-dropdown .dropdown-menu');
                if (cartDropdown.style.display === 'block') {
                    cartDropdown.style.display = 'none';
                } else {
                    cartDropdown.style.display = 'block';
                }
            });
        }
    });
</script>
@yield('js_files')
</body>
</html>
