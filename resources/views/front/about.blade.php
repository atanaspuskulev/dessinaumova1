@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5 mb-3">
        <div class="row">
            <div class="col-md-5 pl-0">
                <img src="{{ asset('assets/images/desi-naumova.jpg') }}" class="img-fluid" alt="{{ config('app.name') }}">
            </div>
            <div class="col-md-7">
                <h3 class="display-1">{{ config('app.name') }}</h3>
                <hr />
                <div class="row mb-4">
                    <div class="col-md-12 col-sm-12 view-product">{!! __('text.about_page_info') !!}</div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 mt-2 pt-1">

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <img class="img-fluid mb-3" src="{{ asset('assets/images/foxygirl.jpg') }}" alt="" />
                            </div>
                            <div class="col-md-6 col-sm-12 ">
                                <img class="img-fluid" src="{{ asset('assets/images/wintertale.jpg') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
