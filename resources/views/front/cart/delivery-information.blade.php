@extends('layouts.front')

@section('head_additional_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('head_js')
<script>
    $(document).ready(function() {
        $('#payer_country').on('change', function () {
            const countryIso = $(this).val();
            console.log(countryIso);
            if (!countryIso) {
                $('#phone_code').val('');
                return;
            }

            const $option = $('#phone_code option[data-id="' + countryIso + '"]');

            if ($option.length) {
                $('#phone_code').val($option.val());
            } else {
                $('#phone_code').val('');
            }
        });
    })
</script>
@endsection

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1 class="display-6 text-center">{{ __('cart.delivery_information') }}</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="col col-md-d-flex align-items-center justify-content-center mt-3 mb-4">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <form method="post" action="{{ route('front.order_create') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <select
                            class="form-select rounded-0" id="payer_country"
                            name="payer_country"
                        >
                            <option value="">{{ __('form.choose') }}</option>
                            @foreach($countries as $country)
                                <option
                                    value="{{ $country['short_name'] }}"
                                    @selected(old('payer_country') == $country['short_name'])
                                >{{ $country['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">* {{ __('form.country') }}</label>
                        @error('payer_country')
                            <div class="alert alert-danger mt-2 p-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input
                            name="payer_city"
                            type="text"
                            class="form-control rounded-0"
                            id="payer_city"
                            autocomplete="off"
                            value="{{ old('payer_city') }}"
                        >
                        <label for="payer_city" class="form-label">* {{ __('form.residence') }}</label>
                        @error('payer_city')
                            <div class="alert alert-danger mt-2 p-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input
                            name="payer_zip"
                            type="text"
                            class="form-control rounded-0"
                            id="payer_zip"
                            autocomplete="off"
                            value="{{ old('payer_zip') }}"
                        >
                        <label for="payer_zip">* {{ __('form.zip') }}</label>
                        @error('payer_zip')
                            <div class="alert alert-danger mt-2 p-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            name="payer_address"
                            class="form-control rounded-0"
                            id="payer_address"
                            autocomplete="off"
                            value="{{ old('payer_address') }}"
                        >
                        <label for="payer_address">* {{ __('form.address') }}</label>
                        @error('payer_address')
                            <div class="alert alert-danger mt-2 p-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input
                            name="payer_name"
                            type="text"
                            class="form-control rounded-0"
                            id="payer_name"
                            autocomplete="off"
                            value="{{ old('payer_name') }}"
                        >
                        <label for="payer_name">* {{ __('form.your_name') }}</label>
                        @error('payer_name')
                            <div class="alert alert-danger mt-2 p-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input
                            name="payer_email"
                            type="email"
                            class="form-control rounded-0"
                            id="payer_email"
                            autocomplete="off"
                            value="{{ old('payer_email') }}"
                        >
                        <label for="payer_email">* {{ __('form.e_mail') }}</label>
                        @error('payer_email')
                            <div class="alert alert-danger mt-2 p-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-3 col-sm-5 col-md-3">
                            <div class="form-floating">
                                <select
                                    style="pointer-events: none; background-color: #e9ecef;"
                                    class="form-select rounded-0"
                                    id="phone_code"
                                    name="phone_code"
                                >
                                    <option value="">* {{ __('form.choose') }}</option>
                                    @foreach($countries as $country)
                                        <option
                                            @selected(old('phone_code') == $country['country_code'])
                                            data-id="{{$country['short_name']}}"
                                            value="{{ $country['country_code'] }}">{{ $country['country_code'] }}</option>
                                    @endforeach
                                </select>
                                <label for="phone_code">{{ __('form.phone_code') }}</label>
                            </div>
                        </div>

                        <div class="col-9 col-sm-7 col-md-9">
                            <div class="form-floating">
                                <input
                                    name="payer_phone"
                                    type="number"
                                    class="form-control rounded-0"
                                    id="payer_phone"
                                    autocomplete="off"
                                    value="{{ old('payer_phone') }}"
                                >
                                <label for="payer_phone">* {{ __('form.phone') }}</label>
                            </div>
                        </div>
                        @error('payer_phone')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger mt-2 p-1">{{ $message }}</div>
                            </div>
                        </div>

                        @enderror
                    </div>

                    <div class="mb-3 form-floating">
                        <textarea
                            name="additional_information"
                            rows="5"
                            class="form-control form-floating rounded-0"
                            id="additional_information"
                            autocomplete="off"
                        >{{ old('additional_information', $deliveryInformation['additional_information'] ?? '') }}</textarea>
                        <label for="additional_information" class="form-label">{{ __('form.additional_info') }}</label>
                    </div>
                    <hr />
                    <div class="d-flex justify-content-center col-12">
                        <a href="#" class="btn btn-warning">{{ __('nav.front.back_to_cart') }}</a>
                        <button
                            style="margin-left:10px;"
                            type="submit"
                            class="btn btn-danger rounded-0">{{ __('nav.front.to_payment') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
