@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>{{ $categoryData?->title }}</h1>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-5">
        <div class="row  equal-height">
            @forelse($products as $product)
                <div class="col-md-6 mb-5">
                    <div class="card mb-4 rounded-5 card-box-shadow">
                        <img src="{{ displayImage($product->id, $product->thumbnail?->path, true) }}" class="card-img-top" alt="Product 1">
                        <div class="card-body">
                            <h3 class="card-title">{{ $product->title }}</h3>
                            <p class="card-text">{!! $product->short_description !!}</p>
                            <h3>Price: ${{ $product->price }}</h3>
                            <a href="#" class="product-button mb-3 position-absolute bottom-0 end-0 me-3">View More</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-6">
                    <!-- Product 2 -->
                    <div class="card mb-4">
                        <img src="product2.jpg" class="card-img-top" alt="Product 2">
                        <div class="card-body">
                            <h5 class="card-title">Product 2</h5>
                            <p class="card-text">Description of Product 2.</p>
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
