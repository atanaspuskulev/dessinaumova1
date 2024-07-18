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

        .payment-option {
            margin-bottom: 20px;
        }

        .payment-option h5 {
            margin-top: 10px;
            font-weight: bold;
        }

        .payment-option p {
            margin-bottom: 10px;
        }

        .payment-option ul {
            list-style-type: none;
            padding: 0;
        }

        .payment-option li {
            margin-bottom: 5px;
        }

        #paypal-button-container {
            margin-top: 20px;
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
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                <h3>Payment Options</h3>
                <p>We offer secure and convenient payment options through PayPal. Choose the method that best suits you:</p>
                <div class="payment-option">
                    <h5>PayPal Fast Payment</h5>
                    <p>Quickly and securely make payments using your PayPal account. Simply click the PayPal button to proceed with your payment.</p>
                </div>
                <div class="payment-option">
                    <h5>Use Your Credit or Debit Card</h5>
                    <p>Don't have a PayPal account? No problem! You can still use your credit or debit card to make payments. Just select the PayPal option and follow the instructions to pay with your card. PayPal ensures that your card details are kept safe and secure.</p>
                </div>
                <div class="payment-option">
                    <h5>Benefits of Using PayPal</h5>
                    <ul>
                        <li><strong>Security:</strong> PayPal uses advanced encryption and fraud prevention tools to keep your financial information secure.</li>
                        <li><strong>Speed:</strong> Make payments quickly without the need to enter your card details each time.</li>
                        <li><strong>Flexibility:</strong> PayPal accepts a wide range of payment methods, including credit cards, debit cards, and bank transfers.</li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-4">
                <div id="paypal-button-container" class="paypal-button-container"></div>
                <div id="paymentResponse" class="b-none"></div>
            </div>
        </div>
    </div>
@endsection
