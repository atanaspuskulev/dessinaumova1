@extends('layouts.front')

@section('css_files')
    <link rel="stylesheet" href="{{ asset('assets/mp/magnific-popup.css') }}">

    <style>
        .badge-link {
            text-decoration: none;
        }
    </style>
@endsection

@section('js_files')
    <script>
        let labels = {
            'continue_browsing': "{!! __('cart.continue_browsing') !!}",
            'view_cart': "{!! __('cart.view_cart') !!}",
            'cancel': "{!! __('strings.cancel') !!}",
            'cart_updated': "{!! __('cart.cart_updated') !!}",
            'cart_info': "{!! __('cart.cart_info') !!}",
            'error_update': "{!! __('cart.error_updating_cart') !!}",
            'ок': "{!! __('cart.ok') !!}",
            'remove_from_cart': "{!! __('cart.remove_from_cart') !!}",
            'warning': "{!! __('cart.remove_warning') !!}",
            'remove': "{!! __('cart.remove') !!}",
            'remove_err': "{!! __('cart.err_msg_request') !!}"
        };
    </script>
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
            <div class="col-md-6 col-sm-12 mb-0 order-xxl-1 order-2 view-sm-gallery">
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
            <div class="col-md-6 col-sm-12 mt-sm-2 mt-md-0 order-xxl-2 order-1l up view-product">
                <p class="card-title">{{ $product?->title }}</p>
                <hr>
                <p>{!! $product?->description !!}</p>
                @if($product->tags->count())
                    <div class="mb-3 ">{{ __('site.in_category_lc') }}:
                    @foreach($product->tags as $tag)
                        <a
                            href="{{ route('front.by_tag', ['tag' => $tag->slug]) }}"
                            class="badge-link"
                        >
                            <span class="badge bg-tag-custom">
                                {{ $tag->name }}
                            </span>
                        </a>
                    @endforeach
                    </div>
                @endif
                <p><b>{{ __('site.material') }}:</b> {{ $product?->material }}</p>
                @if($product?->dimentions1)
                    <p><b>{{ __('site.size_info') }}:</b> {{ $product->dimentions1 }}</p>
                @endif
                @if($product?->dimentions2)
                    <p><b>{{ __('site.size_info_more') }}:</b> {{ $product->dimentions2 }}</p>
                @endif
                @if($product?->dimentions3)
                    <p><b>{{ __('site.size_info_other') }}:</b> {{ $product->dimentions3 }}</p>
                @endif
                @if($product?->delivery)
                    <p><b>{{ __('site.delivery_info') }}:</b> {{ $product->delivery }}</p>
                @endif
                @if($product?->sold)
                    <h3 class="p-3 bg-warning">{{ __('site.product_is_sold') }}</h3>
                @endif
                @if(!$product?->sold)
                    @if($product?->price)
                        <h5 class="mt-3 mb-3 ">{{ __('site.price') }}: @price($product->price, $product->currency)</h5>
                    @endif

                    <p>
                        <b>{{ __('site.shipping_cost_label') }}: </b>
                        @shipping_cost($product->shipping_cost)
                    </p>
                @endif

                @if(!$product?->sold && !in_array($product?->id, session()->get('cart', [])))
                    <p class="small">
                        <i>
                            <b>{{ __('site.note_lbl') }}:</b>
                            {!! __('messages.tax_info') !!}
                        </i>
                    </p>
                    <form
                        onsubmit="return false"
                        method="post"
                        action="{{ route('api.add_to_cart') }}"
                        class="mt-4 mb-sm-4"
                        id="__PRODUCT__"
                    >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                        <button
                            type="submit"
                            class="btn btn-outline-dark flex-shrink-0"
                            id="buy-button"
                        >
                            <i class="bi-cart-fill me-1"></i> {{ __('site.buy_item') }}</button>
                    </form>
                @elseif(!$product?->sold && in_array($product?->id, $cartItems, true))
                    @include('front.partials.item-in-cart')
                @endif
            </div>
        </div>
    </div>
@endsection
