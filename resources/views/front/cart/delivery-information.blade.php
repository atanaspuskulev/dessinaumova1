@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1 class="display-6 text-center">Информация за доставка</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="col col-md-d-flex align-items-center justify-content-center mt-3 mb-4">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <form method="post" action="{{ route('front.order_create') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="payer_country" class="form-label">* Държава</label>
                        <select id="payer_country" name="payer_country" class="form-control rounded-0">
                            <option value="">Избери</option>
                            @foreach(config('countries') as $country)
                                <option value="{{ $country['short_name'] }}" @selected(old('payer_country') == $country['short_name'])>{{ $country['name'] }}</option>
                            @endforeach
                        </select>
                        @error('payer_country')
                        <div class="alert alert-danger mt-2 p-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="payer_city" class="form-label">* Населено място</label>
                        <input
                            name="payer_city"
                            type="text"
                            class="form-control rounded-0"
                            id="payer_city"
                            autocomplete="off"
                            value="{{ old('payer_city') }}"
                        >
                        @error('payer_city')
                        <div class="alert alert-danger mt-2 p-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payer_zip">* Пощенски код</label>
                        <input
                            name="payer_zip"
                            type="text"
                            class="form-control rounded-0"
                            id="payer_zip"
                            autocomplete="off"
                            value="{{ old('payer_zip') }}"
                        >

                        @error('payer_zip')
                        <div class="alert alert-danger mt-2 p-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payer_address">* Адрес</label>
                        <input
                            type="text"
                            name="payer_address"
                            class="form-control rounded-0"
                            id="payer_address"
                            autocomplete="off"
                            value="{{ old('payer_address') }}"
                        >
                        @error('payer_address')
                        <div class="alert alert-danger mt-2 p-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payer_name">* Вашите имена</label>
                        <input
                            name="payer_name"
                            type="text"
                            class="form-control rounded-0"
                            id="payer_name"
                            autocomplete="off"
                            value="{{ old('payer_name') }}"
                        >
                        @error('payer_name')
                        <div class="alert alert-danger mt-2 p-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payer_email">* E-mail адрес</label>
                        <input
                            name="payer_email"
                            type="email"
                            class="form-control rounded-0"
                            id="payer_email"
                            autocomplete="off"
                            value="{{ old('payer_email') }}"
                        >
                        @error('payer_email')
                        <div class="alert alert-danger mt-2 p-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone">* Телефон за връзка</label>
                        <input
                            name="payer_phone"
                            type="tel"
                            class="form-control rounded-0"
                            id="phone"
                            autocomplete="off"
                            value="{{ old('payer_phone') }}"
                        >
                        @error('payer_phone')
                        <div class="alert alert-danger mt-2 p-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="additional_information" class="form-label">Допълнителна информация</label>
                        <textarea
                            name="additional_information"
                            rows="5"
                            class="form-control form-floating rounded-0"
                            id="additional_information"
                            autocomplete="off"
                        >{{ old('additional_information', $deliveryInformation['additional_information'] ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-danger rounded-0">Плащане</button>
                </form>
            </div>
        </div>
    </div>
@endsection
