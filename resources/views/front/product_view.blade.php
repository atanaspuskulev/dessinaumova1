@extends('layouts.front')

@section('css_files')
    <link rel="stylesheet" href="{{ asset('assets/mp/magnific-popup.css') }}">
@endsection

@section('js_files')
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="{{ asset('assets/mp/jquery.magnific-popup.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.lightbox').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        });
    </script>
@endsection

@section('head_js')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        let cart_add_url = "{{ route('api.add_to_cart') }}";
    </script>
@endsection

@section('content')
    @php
        $product = $categoryData?->products?->first();
    @endphp
    <div class="container-fluid mt-5 mb-5">
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-0  order-xxl-1 order-2">
                @if($product->gallery->count())
                    @foreach($product->gallery as $mainImage)
                        <div class="row">
                            <div class="col mb-3">
                                <a class="lightbox" href="{{ displayImage($product?->id, $mainImage->path) }}">
                                    <img class="img-fluid" src="{{ displayImage($product?->id, $mainImage->path, true) }}" />
                                </a>
                            </div>
                        </div>

                    @endforeach
                @else
                    <img  class="img-fluid" src="{{ asset('assets/images/default-image.png') }}" />
                @endif
            </div>
            <div class="col-md-6 col-sm-12 mt-5 mt-md-0 order-xxl-2 order-1l up">
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

                @if(!$product?->sold && !in_array($product?->id, session()->get('cart', [])))
                    <p class="small">
                        <i>
                            <b>Note:</b> This is the price without a tax applied.<br />The tax
                            is 15% and is applied at the total of the order.
                        </i>
                    </p>
                    <form
                        onsubmit="return false"
                        method="post"
                        action="{{ route('front.cart.store') }}"
                        class="mt-4 mb-sm-4"
                        id="__PRODUCT__"
                    >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                        <button type="submit" class="buy-button" id="buy-button">Buy this item</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
