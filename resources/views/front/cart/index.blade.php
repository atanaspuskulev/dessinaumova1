@extends('layouts.front')

@section('head_js')
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
@endsection



@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1 class="display-6 text-center">{{ __('site.shopping_cart_lbl') }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center cart-list">
                @include('front.partials.cart-list')
            </div>
        </div>
    </div>
@endsection
