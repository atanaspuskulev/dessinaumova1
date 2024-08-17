@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                <h2>Welcome to Desi Naumova webstore.</h2>
                <p>
                    Discover my curated collection of hand-crafted paintings,
                    aromatic candles, and exquisite wooden articles.
                    Each piece is made with love and care, designed to bring
                    warmth and beauty into your home.
                    Explore our latest arrivals and find something special today.
                </p>
            </div>
        </div>
        <div class="row equal-height">
            @php
                $columnClass = match($products->count()) {
                    1 => 'col-md-12',
                    2 => 'col-md-6',
                    default => 'col-md-4'
                };
            @endphp
            @forelse($products as $product)
                <div class="{{ $columnClass }} mb-5">
                    <div class="card mb-4 rounded-5 card-box-shadow">
                        <img src="{{ displayImage($product->id, $product->thumbnail?->path, true) }}"
                             class="card-img-top" alt="{{ $product->title }}">
                        <div class="card-body">
                            <h3 class="card-title">{{ $product->title }}</h3>
                            <p class="card-text">{!! $product->short_description !!}</p>
                            <h3>Price: {{ $product->price }}&euro;</h3>
                            <br>
                            <p>
                                In <a href="{{ route('front.to_category', ['category' => $product->category->slug]) }}"
                                      class="common-link">
                                    {{ $product->category->title }}
                                </a>
                            </p>
                            <a href="{{ route('front.product_view', ['category_slug' => $product->category->slug, 'product_slug' => $product->slug]) }}"
                               class="product-button mb-3 position-absolute bottom-0 end-0 me-3">View More</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-6">
                    There are no products to show.
                </div>
            @endforelse
        </div>
    </div>
@endsection
