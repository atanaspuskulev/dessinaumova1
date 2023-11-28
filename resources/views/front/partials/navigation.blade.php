<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="navbar-logo">
            <a class="navbar-brand" href="{{ route('front.index') }}">Desi Naumova</a>
        </div>

        <div class="navbar-cart">
            <div class="cart-dropdown">
                <i class="fas fa-shopping-cart" id="cart-icon" data-bs-toggle="dropdown" role="button"
                   aria-expanded="false">
                    <span class="cart-badge" id="cart-items-num">{{ $cart_items['total_count'] }}</span>
                </i>
                @if($cart_items['total_count'])
                    <ul class="dropdown-menu dropdown-cart" role="menu">
                        @foreach($cart_items['cart_products'] as $item)
                            <li>
                                  <span class="item">
                                    <span class="item-left">
                                        <img style="width:150px;" src="{{ displayImage($item['id'], $item['thumbnail']?->path, true) }}" alt=""/>
                                        <span class="item-info">
                                            <span>{!! $item['title'] !!}</span>
                                            <span>23$</span>
                                        </span>
                                    </span>
                                    <span class="item-right">
                                        <button class="btn btn-xs btn-danger pull-right">x</button>
                                    </span>
                                </span>
                            </li>
                        @endforeach
                        <li class="divider"></li>
                        <li><a class="text-center" href="">View Cart</a></li>
                    </ul>
                @endif
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
                        <a class="nav-link"
                           href="{{ route('front.to_category', ['category' => $slug]) }}">{{ $title }}</a>
                    </li>
                @endforeach
            @endif
            <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
            </li>
        </ul>
    </div>
</nav>
