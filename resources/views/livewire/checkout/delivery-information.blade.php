@extends('layouts.front')

@section('content')
    <div>
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col">
                    <h1>Delivery Information</h1>
                    <hr>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-3 mb-4">
                  <form>
                      <fieldset>
                          <legend>Delivery And Address Information</legend>

                          <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg">
                              <option selected>* Choose Your Country</option>
                              @foreach(\App\Helpers\CountriesHelper::getCountries() as $country)
                                  <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                              @endforeach
                          </select>

                          <div class="form-floating mb-3">
                              <input type="text" class="form-control" id="state" autocomplete="off">
                              <label for="state">* State/County</label>
                          </div>

                          <div class="form-floating mb-3">
                              <input type="text" class="form-control" id="city" autocomplete="off">
                              <label for="city">* City/Residential</label>
                          </div>

                          <div class="form-floating mb-3">
                              <input type="text" class="form-control" id="zip" autocomplete="off">
                              <label for="zip">* ZIP/Postal Code</label>
                          </div>

                          <div class="form-floating mb-3">
                              <input type="text" class="form-control" id="delivery_address" autocomplete="off">
                              <label for="delivery_address">* Delivery Address</label>
                          </div>
                      </fieldset>

                      <fieldset class="mt-3">
                          <legend>Contact Information</legend>

                          <div class="form-floating mb-3">
                              <input type="text" class="form-control" id="name" autocomplete="off">
                              <label for="name">* Full Name</label>
                          </div>

                          <div class="form-floating mb-3">
                              <input type="email" class="form-control" id="email" autocomplete="off">
                              <label for="email">* E-Mail Address</label>
                          </div>

                          <div class="form-floating mb-3">
                              <input type="phone" class="form-control" id="phone" autocomplete="off">
                              <label for="phone">Your Phone</label>
                          </div>

                          <div class="mb-3">
                              <label for="additional_information" class="form-label">Additional Information (Optional)</label>
                              <textarea rows="5" name=additional_information" class="form-control form-floating" id="additional_information" autocomplete="off"></textarea>
                          </div>
                      </fieldset>
                  </form>
            </div>
        </div>
    </div>
@endsection
