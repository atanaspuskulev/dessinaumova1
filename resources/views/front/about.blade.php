@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5 mb-3">
        <div class="row">
            <div class="col-md-5 pl-0">
                <img src="{{ asset('assets/images/desi-naumova.jpg') }}" class="img-fluid" alt="DesiWEB">
            </div>
            <div class="col-md-7">
                <h3 class="display-1">Desi Naumova</h3>
                <hr />
                <div class="row mb-4">
                    <div class="col-md-12 col-sm-12">
                        Desi Naumova is an artist from Bulgaria whose brush creates enchanting
                        fairytale worlds filled with wonder and adventure,
                        inspired by nature and working
                        with watercolor, acrylic, and mixed media, her paintings and illustrations
                        transport viewers to fantastical realms, alive with vibrant colors and
                        intricate details.<br /><br />Desi transforms each painting into a portal
                        to dreams, proving that magic exists for those who believe. Her art brings warmth
                        and charm to any home. You have the opportunity to purchase both
                        original paintings and art prints.<br /><br />

                        Enjoy this magical, nostalgic, and earthy art.<br />
                        Thank you!
                    </div>
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
