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
    <style>
        .paypal-button {
            background-color: #FFC439;
            color: #111;
            font-family: Arial, sans-serif;
            font-size: 16px;
            font-weight: 600;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }

        .paypal-button:hover {
            background-color: #FFA31A;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 1050;
            display: none;
        }
    </style>
@endsection

@section('content')
    <div id="overlay" class="d-flex justify-content-center align-items-center d-none">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Cart Payment</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-4">
        <div class="row mb-3">
            <div class="col-md-6 text-left">
                <h3>Payment Options</h3>
                <p>You can use the secure and convenient payment options through PayPal. Choose the method that best suits you:</p>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col">
                        <div id="paypal-button-container" class="paypal-button-container"></div>
                        <div id="paymentResponse" class="b-none"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div id="checkout-form">
                            <!-- Containers for Card Fields hosted by PayPal -->
                            <div id="card-name-field-container"></div>
                            <div id="card-number-field-container"></div>
                            <div id="card-expiry-field-container"></div>
                            <div id="card-cvv-field-container"></div>
                            <button id="card-field-submit-button" type="button">
                                Pay Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

        </div>
    </div>
@endsection
