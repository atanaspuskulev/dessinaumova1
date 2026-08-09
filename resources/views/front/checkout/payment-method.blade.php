@extends('layouts.front')
@section('head_additional_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('head_js')
    <script>
        $(document).ready(function() {
           $('input[name=payment_method]').on('click', function() {
               $('.payment-method-next').attr('disabled', false);
           });
        });
    </script>
@endsection

@section('content')
    <header class="py-5 align-content-start">
        <div class="container ">
            <div class="row">
                <div class="col">
                    <h1 class="display-6 text-center">{{ __('cart.payment_method_choose') }}</h1>
                    <hr />
                </div>
            </div>
        </div>
    </header>
    <section>
        <div class="container">
            <form
                method="post"
                action="{{ route('front.payment_method_choose') }}"
                class="row justify-content-center g-4"
            >
                @csrf
                <div class="col-12 col-md-3">
                    <input
                        type="radio"
                        name="payment_method"
                        id="cod"
                        value="cod"
                        class="d-none"
                        @checked($paymentMethod === 'cod')
                    />
                    <label for="cod" class="radio-image card text-center p-4">
                        {{ __('cart.cash_on_delivery') }}
                    </label>
                </div>

                <div class="col-12 col-md-3">
                    <input
                        type="radio"
                        name="payment_method"
                        id="paypal"
                        value="paypal"
                        class="d-none"
                        @checked($paymentMethod === 'paypal')
                    />
                    <label for="paypal" class="radio-image card text-center p-4">
                        {{ __('cart.pay_with_paypal') }}
                    </label>
                </div>
                <hr />
                <div class="d-flex justify-content-center col-12 mb-3">
                    <a href="{{ route('front.payment_and_delivery') }}" class="btn btn-warning">{{ __('nav.front.back_to_delivery_method') }}</a>

                    <button
                        @disabled(!$paymentMethod)
                        style="margin-left:10px;"
                        type="submit"
                        class="btn btn-danger payment-method-next rounded-0">{{ __('nav.front.to_payment') }}</button>
                </div>
            </form>
        </div>
    </section>
@endsection
