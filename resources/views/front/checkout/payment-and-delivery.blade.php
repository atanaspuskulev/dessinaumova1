@extends('layouts.front')
@section('head_additional_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('head_js')
    <script>
        $(document).ready(function() {
           $('input[name=order_by]').on('click', function() {
               $("input[name=delivery_method]").val($(this).val());
               $('.payment-next').attr('disabled', false);
           });

           $('.payment-next').on('click', function() {
               $('.payment-next-step').submit();
           })
        });
    </script>
@endsection

@section('content')
    <header class="py-5 align-content-start">
        <div class="container ">
            <div class="row">
                <div class="col">
                    <h1 class="display-6 text-center">{{ __('cart.delivery_and_payment') }}</h1>
                    <hr />
                </div>
            </div>
            <div class="text-white">
                <h1 class="display-6 fw-bolder"></h1>
            </div>
        </div>
    </header>
    <section>
        <div class="container">
            <div class="row justify-content-center pb-5">
                <div class="col-md-9">
                    <h5>{{ __('cart.delivery_data') }}</h5>
                    <hr />
                    <div>
                        @foreach($addressArray as $key => $value)
                            <div><strong>{{ $key }}:</strong> {!! $value !!}</div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row justify-content-center pb-5">
                <div class="col-md-9">
                    <h5>{{ __('cart.delivery_provider_choose') }}</h5>
                    <hr />
                </div>
            </div>
            <form
                method="post"
                action=""
                class="row justify-content-center g-4 payment-next-step"
            >
                @csrf
                <input type="hidden" name="delivery_method" value="">
                <div class="col-12 col-md-3">
                    <input
                        type="radio"
                        name="order_by"
                        id="speedy"
                        value="speedy"
                        class="d-none"
                        @checked($deliveryMethod === 'speedy')
                    />
                    <label for="speedy" class="radio-image card text-center p-2">
                        <img src="{{ asset('assets/images/speedy.png') }}" width=160 height="50" alt="Speedy" />
                    </label>
                </div>

                <div class="col-12 col-md-3">
                    <input
                        type="radio"
                        name="order_by"
                        id="econt"
                        value="econt"
                        class="d-none"
                        @checked($deliveryMethod === 'econt')
                    />
                    <label for="econt" class="radio-image card text-center p-2">
                        <img src="{{ asset('assets/images/econt.png') }}" width=160 height=50 alt="Speedy" />
                    </label>
                </div>
            </form>
            <hr />
            <div class="d-flex justify-content-center col-12 mb-3">
                <a href="{{ route('front.delivery_form') }}" class="btn btn-warning">{{ __('nav.front.back_to_delivery') }}</a>

                <button
                    disabled
                    style="margin-left:10px;"
                    type="submit"
                    class="btn btn-danger payment-next rounded-0">{{ __('nav.front.to_payment') }}</button>
            </div>
        </div>
    </section>
@endsection
