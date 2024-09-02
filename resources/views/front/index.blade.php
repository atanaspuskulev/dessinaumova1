@extends('layouts.front')

@section('content')
    <header class="bg-heading py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder desi-title">Welcome to Desi Naumova webstore.</h1>
                <p class="lead fw-normal text-white-50 mb-0">
                    Discover my curated collection of paintings, art-prints, bookmarks
                    universe candles.
                    Everything is made with love and care, designed to bring
                    warmth and beauty into your home.

                </p>
            </div>
        </div>
    </header>
    <section class="py-5">
        <div class="container-fluid mt-5">
        <div class="row equal-height">
            @php
                $columnClass = listColumnClass($products);
            @endphp
            @forelse($products as $product)
                @include('front.partials.product-item', ['columnClass' => $columnClass, 'productItem' => $product])
            @empty
                <div class="col-md-6">
                    There are no products to show.
                </div>
            @endforelse
        </div>
    </div>
    </section>
@endsection
