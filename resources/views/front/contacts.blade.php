@extends('layouts.front')

@section('content')
    <header class="py-5 align-content-start">
        <div class="container ">
            <div class="row">
                <div class="col">
                    <h1 class="display-6 text-center">{{ __('site.contact_me') }}</h1>
                    <hr />
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid mt-3 mb-4">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">{!! __('text.contact_page_info') !!}</div>
        </div>
    </div>
@endsection
