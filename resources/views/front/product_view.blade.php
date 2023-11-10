@extends('layouts.front')

@section('css_files')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <link rel="stylesheet" href="{{ asset('assets/mp/magnific-popup.css') }}">
@endsection

@section('js_files')
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script src="{{ asset('assets/mp/jquery.magnific-popup.js') }}"></script>

    <script>
        $(document).ready(function() {
            // $('.bxslider').bxSlider({
            //     pagerCustom: '#bx-pager',
            //     onSliderLoad: function() {
            //         $('.lightbox').magnificPopup({
            //             type: 'image',
            //             gallery: {
            //                 enabled: true
            //             }
            //         });
            //     }
            // });
            $('.lightbox').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });


        });


    </script>
@endsection

@section('content')
    @php
        $product = $categoryData?->products?->first();
    @endphp
    <div class="container-fluid mt-5 mb-5">
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-0">
                @if($product->gallery->count())
                    @foreach($product->gallery as $mainImage)
                        <div class="row">
                            <div class="col mb-3">
                                <a class="lightbox" href="{{ displayImage($product?->id, $mainImage->path) }}">
                                    <img class="img-fluid" src="{{ displayImage($product?->id, $mainImage->path) }}" />
                                </a>
                            </div>
                        </div>

                    @endforeach
                @else
                    <img  class="img-fluid" src="{{ asset('assets/images/default-image.png') }}" />
                @endif
            </div>
            <div class="col-md-6 col-sm-12 mt-5 mt-md-0">
                <h1>{{ $product?->title }} {{ $product->id }}</h1>
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
