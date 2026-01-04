@extends('layouts.front')

@section('content')
    <header class="py-5 align-content-start">
        <div class="container ">
            <div class="row">
                <div class="col">
                    <h1 class="display-6 text-center">Доставка и плащане</h1>
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
                    <h5>Изберете начин на доставка</h5>
                    <hr />
                </div>
            </div>
            <form class="row justify-content-center g-4">
                <div class="col-12 col-md-3">
                    <input type="radio" name="order_by" id="speedy" class="d-none">
                    <label for="speedy" class="radio-image card text-center p-2">
                        <img src="{{ asset('assets/images/speedy.png') }}" width=160 height="50" alt="Speedy" />
                    </label>
                </div>

                <!-- Option 2 -->
                <div class="col-12 col-md-3">
                    <input type="radio" name="order_by" id="econt" class="d-none">
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
                    class="btn btn-danger rounded-0">{{ __('nav.front.to_payment') }}</button>
            </div>
        </div>
    </section>
@endsection
