@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Начин на плащане и доставка</h1>
                <hr>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-9 alert alert-secondary rounded-1">
                <div class="row">
                    <div class="col-2 col-sm-4 col-md-1 d-flex align-items-center">
                        <input type="radio" name="deliver_by" value="speedy "/>
                    </div>
                    <div class="col">
                        <img src="{{ asset('assets/images/speedy.png') }}" width=160 height="50" alt="Speedy" />
                    </div>
                </div>
            </div>
            <div class="col-md-9 alert alert-secondary rounded-1">
                <div class="row">
                    <div class="col-2 col-sm-4 col-md-1 d-flex align-items-center">
                        <input type="radio" name="deliver_by" value="ekont "/>
                    </div>
                    <div class="col">
                        <img src="{{ asset('assets/images/econt.png') }}" width=160 height=50 alt="Speedy" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
