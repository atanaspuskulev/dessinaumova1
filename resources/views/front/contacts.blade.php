@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>{{ __('site.contact_me') }}</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-4">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">{!! __('text.contact_page_info') !!}</div>
        </div>
    </div>
@endsection
