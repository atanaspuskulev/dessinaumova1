@extends('layouts.front')

@section('head_js')
    <script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency={{ $paypalCurrency }}&components=buttons,card-fields">
    </script>
    <script>
        let paypalBrandName = '{!! $paypalBrandName !!}';
        let paypalSuccessUrl = '{{ route("front.payment.order.success") }}';
        let paypalCancelUrl = '{{ route("front.payment.order.cancel") }}';
        let orderCreateUrl = '{{ route("front.payment.api.order.create") }}';
        let orderUpdateUrl = '{{ route("front.payment.api.order.update") }}';
        let apiCancelUrl = '{{ route("front.payment.api.order.cancel") }}';
        let orderInfo = JSON.parse('{!! $order !!}');
        let paypalDefaultLocale = '{{ $paypalLocale }}';
    </script>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/js/payment.js') }}"></script>

    <link href="{{ asset('assets/css/front/pp.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div id="overlay" class="d-flex justify-content-center align-items-center d-none">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>{{ __('cart.cart_payment_title') }}</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-4">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">{!! __('text.payment_page_content') !!}</div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-4">
                <div id="paypal-button-container" class="paypal-button-container"></div>
                <div id="paymentResponse" class="b-none"></div>
            </div>
        </div>
    </div>
@endsection
