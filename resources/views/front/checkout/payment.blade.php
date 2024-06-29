@extends('layouts.front')

@section('head_js')
    <script
        src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency={{ $paypalCurrency }}&components=buttons,card-fields">
    </script>
    <script>
        let paypalBrandName = '{!! $paypalBrandName !!}';
        let paypalSuccessUrl = '{{ route("front.payment.order.success") }}';
        let paypalCancelUrl = '{{ route('front.payment.order.cancel") }}';
        let orderCreateUrl = '{{ route("front.payment.api.order.create") }}';
        let orderUpdateUrl = '{{ route("front.payment.api.order.update") }}';
        let apiCancelUrl = '{{ route("front.payment.api.order.cancel") }}';
        let orderInfo = JSON.parse('{!! $order !!}');
        let paypalDefaultLocale = '{{ $paypalLocale }}';
        let paypalCCCapturePaymentUrl = '{{ route("payment.api.payment.pp-cc-payment-capture") }}';
    </script>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/js/payment.js') }}"></script>
@endsection

@section('content')
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
                <div class="row justify-content-center text-left mb-4 pp-fastpay">
                    <div class="col-md-6">
                        <h3>PayPal Fast Pay</h3>
                        <p class="mb-4">Use your PayPal account to make quick and easy payments. Simply click the PayPal Fast Pay button, log in to your PayPal account, and complete your purchase with just a few clicks.</p>
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
                <div class="row justify-content-center text-center show-cc-payment">
                    <div class="col-md-6">
                        <a href="javascript:showCardForm();">
                            Pay with Credit/Debit Card
                        </a>
                    </div>
                </div>
                <div class="row justify-content-center text-left d-none pp-ccpay">
                    <div class="col-md-6">
                        <h3>PayPal Credit Card</h3>
                        <p>Don't have a PayPal account? No problem! You can still use your credit or debit card through PayPal. Select the PayPal Credit Card button, and you will be guided through the process to enter your card details securely.</p>
                        <form id="credit-card-form">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="cardholder-name" placeholder="Cardholder Name" required>
                                <label for="cardholder-name">Cardholder Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="text" class="form-control" id="card-number" placeholder="Card Number" required>
                                <label for="card-number">Card Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="expiry-date" placeholder="MM/YY" required>
                                <label for="expiry-date">Expiry Date (MM/YY)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="text" class="form-control" id="cvv" placeholder="CVV" required>
                                <label for="cvv">CVV</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input autocomplete="off" value="{{ $deliveryInformation ? $deliveryInformation['delivery_address'] : '' }}" type="text" class="form-control" id="billing-address" placeholder="Billing Address" required>
                                <label for="billing-address">Billing Address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input autocomplete="off" value="{{ $deliveryInformation ? $deliveryInformation['city'] : '' }}" type="text" class="form-control" id="billing-city" placeholder="City" required>
                                <label for="billing-city">City</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input autocomplete="off" value="{{ $deliveryInformation ? $deliveryInformation['state'] : '' }}" type="text" class="form-control" id="billing-state" placeholder="State" required>
                                <label for="billing-state">State</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input autocomplete="off" value="{{ $deliveryInformation ? $deliveryInformation['zip'] : '' }}" type="text" class="form-control" id="billing-zip" placeholder="ZIP Code" required>
                                <label for="billing-zip">ZIP Code</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input autocomplete="off" value="{{ $deliveryInformation ? $deliveryInformation['country'] : '' }}" type="text" class="form-control" id="billing-country" placeholder="Country" required>
                                <label for="billing-country">Country</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Make PayPal Payment</button>
                            <br>
                            <a href="javascript:showFastPay();">Switch to PayPal FastPay</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

        </div>
    </div>
@endsection
