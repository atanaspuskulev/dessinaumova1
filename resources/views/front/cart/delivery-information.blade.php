@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Delivery Information</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-center mt-3 mb-4">
        <form method="post" action="{{ route('front.saveDeliveryInformation') }}">
            @csrf
            <fieldset>
                <legend>Delivery And Address Information</legend>

                <select name="country" class="form-select form-select-lg mb-3" aria-label=".form-select-lg">
                    <option value="">* Choose Your Country</option>
                    @foreach(\App\Helpers\CountriesHelper::getCountries() as $country)
                        <option
                            @selected(old('country') == $country['code'] || $deliveryInformation['country'] === $country['code'])
                            value="{{ $country['code'] }}">
                                {{ $country['name'] }}
                        </option>
                    @endforeach
                </select>
                @error('country')
                    <div class="alert-danger mb-3 p-1">
                        {{ $message }}
                    </div>
                @enderror

                <div class="form-floating mb-3">
                    <input
                        name="state"
                        type="text"
                        class="form-control"
                        id="state"
                        autocomplete="off"
                        value="{{ old('state', $deliveryInformation['state']) }}"
                    >
                    <label for="state">* State/County</label>
                    @error('state')
                        <div class="alert-danger mt-2 p-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input
                        name="city"
                        type="text"
                        class="form-control"
                        id="city"
                        autocomplete="off"
                        value="{{ old('city', $deliveryInformation['city']) }}"
                    >
                    <label for="city">* City/Residential</label>
                    @error('city')
                    <div class="alert-danger mt-2 p-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input
                        type="text"
                        name="zip"
                        class="form-control"
                        id="zip"
                        autocomplete="off"
                        value="{{ old('zip', $deliveryInformation['zip']) }}"
                    >
                    <label for="zip">* ZIP/Postal Code</label>
                    @error('zip')
                    <div class="alert-danger mt-2 p-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input
                        name="delivery_address"
                        type="text"
                        class="form-control"
                        id="delivery_address"
                        autocomplete="off"
                        value="{{ old('delivery_address', $deliveryInformation['delivery_address']) }}"
                    >
                    <label for="delivery_address">* Delivery Address</label>
                    @error('delivery_address')
                    <div class="alert-danger mt-2 p-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </fieldset>

            <fieldset class="mt-3">
                <legend>Contact Information</legend>

                <div class="form-floating mb-3">
                    <input
                        name="name"
                        type="text"
                        class="form-control"
                        id="name"
                        autocomplete="off"
                        value="{{ old('name', $deliveryInformation['name']) }}"
                    >
                    <label for="name">* Full Name</label>
                    @error('name')
                    <div class="alert-danger mt-2 p-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input
                        name="email"
                        type="email"
                        class="form-control"
                        id="email"
                        autocomplete="off"
                        value="{{ old('email', $deliveryInformation['email']) }}"
                    >
                    <label for="email">* E-Mail Address</label>
                    @error('email')
                    <div class="alert-danger mt-2 p-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input
                        name="phone"
                        type="tel"
                        class="form-control"
                        id="phone"
                        autocomplete="off"
                        value="{{ old('phone', $deliveryInformation['phone']) }}"
                    >
                    <label for="phone">Your Phone (Optional)</label>
                    @error('phone')
                    <div class="alert-danger mt-2 p-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="additional_information" class="form-label">Additional Information (Optional)</label>
                    <textarea
                        name="additional_information"
                        rows="5"
                        class="form-control form-floating"
                        id="additional_information"
                        autocomplete="off"
                    >{{ old('additional_information', $deliveryInformation['additional_information']) }}</textarea>
                </div>
            </fieldset>
            <button type="submit" class="btn btn-success">Continue</button>
        </form>
    </div>
@endsection
