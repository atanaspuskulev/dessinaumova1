@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-5 pl-0">
                <img src="{{ asset('assets/images/desi-naumova.jpg') }}" class="img-fluid" alt="DesiWEB">
            </div>
            <div class="col-md-7">
                <h3 class="display-1">Desi Naumova</h3>
                <hr />
                <p>
                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humor and the like).
                </p>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <hr />
            </div>
        </div>
    </div>

    <div class="container-fluid mt-5">
        <div class="row  equal-height">
            @php
                $colClass = match($productsCount) {
                    1 => 'col-md-12',
                    2 => 'col-md-6',
                    default => 'col-md-3'
                };
            @endphp
            @forelse($products as $product)
                <div class="{{ $colClass }} mb-5">
                    <div class="card mb-4 rounded-5 card-box-shadow">
                        <img src="{{ displayImage($product->id, $product->thumbnail?->path, true) }}" class="card-img-top" alt="{{ $product->title }}">
                        <div class="card-body">
                            <h3 class="card-title">{{ $product->title }}</h3>
                            <p class="card-text">{!! $product->short_description !!}</p>
                            <h3>Price: {{ $product->price }}&euro;</h3>
                            <br>
                            <p>
                                In <a href="{{ route('front.to_category', ['category' => $product->category->slug]) }}" class="common-link">
                                    {{ $product->category->title }}
                                </a>
                            </p>
                            <a href="{{ route('front.product_view', ['category_slug' => $product->category->slug, 'product_slug' => $product->slug]) }}" class="product-button mb-3 position-absolute bottom-0 end-0 me-3">View More</a>
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
