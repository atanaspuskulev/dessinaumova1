@extends('layouts.front')

@section('content')
    @php
        $product = $categoryData?->products?->first();
    @endphp
    <div class="container-fluid mt-5 mb-5">
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-0">
                @if($product->gallery->count())
                    <div id="slider" class="flexslider">
                        <ul class="slides">
                            @foreach($product->gallery as $mainImage)
                                <li>
                                    <img class="img-fluid" src="{{ displayImage($product?->id, $mainImage->path) }}" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div id="carousel" class="flexslider">
                        <ul class="slides">
                            @foreach($product->gallery as $mainImage)
                                <li>
                                    <img class="img-fluid" src="{{ displayImage($product?->id, $mainImage->path, true) }}" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <img class="img-fluid" src="{{ asset('assets/images/default-image.png') }}" />
                @endif
            </div>
            <div class="col-md-6 col-sm-12 mt-5 mt-md-0">
                <h1>{{ $product?->title }}</h1>
                <hr>
                <p>{!! $product?->description !!}</p>
                @if($product?->price)
                    <h2 class="mt-3 mb-3">Price: {{ $product->price }}&euro;</h2>
                @endif
                <p><b>Material:</b> {{ $product?->material }}</p>
                @if($product?->dimentions1)
                    <p><b>Size information:</b> {{ $product->dimentions1 }}</p>
                @endif
                @if($product?->dimentions2)
                    <p><b>Size information (more):</b> {{ $product->dimentions2 }}</p>
                @endif
                @if($product?->dimentions3)
                    <p><b>Size information (other):</b> {{ $product->dimentions3 }}</p>
                @endif
                @if($product?->delivery)
                    <p><b>Delivery information:</b> {{ $product->delivery }}</p>
                @endif
                @if($product?->sold)
                    <h3 class="p-3 bg-warning">This product is sold.</h3>
                @endif
            </div>
        </div>
    </div>
@endsection
