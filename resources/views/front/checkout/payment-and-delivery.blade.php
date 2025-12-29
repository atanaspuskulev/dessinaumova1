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
                    Адрес за доставка: {{$addressArray}}
                </div>
            </div>
            <div class="row justify-content-center pb-5">
                <div class="col-md-9">
                    Доставка със:
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-9 alert alert-warning rounded-1">
                    <div class="row">
                        <div class="col-2 col-sm-4 col-md-1 d-flex align-items-center">
                            <input type="radio" name="deliver_by" value="speedy "/>
                        </div>
                        <div class="col">
                            <img src="{{ asset('assets/images/speedy.png') }}" width=160 height="50" alt="Speedy" />
                        </div>
                    </div>
                </div>
                <div class="col-md-9 alert alert-warning rounded-1">
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
    </section>
@endsection
