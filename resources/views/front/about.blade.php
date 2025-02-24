@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5 mb-3">
        <div class="row">
            <div class="col-md-5 pl-0">
                <img src="{{ asset('assets/images/desi-naumova.jpg') }}" class="img-fluid" alt="{{ config('app.name') }}">
            </div>
            <div class="col-md-7">
                <h3 class="display-1 custom-font">Деси Наумова</h3>
                <hr />
                <div class="row mb-4">
                    <div class="col-md-12 col-sm-12 view-product">
                        <p>
                            Като художник и писател, винаги съм била вдъхновена от природата,
                            въображението и силата на думите. Творя с акварел, гваш, акрил и
                            смесена техника, за да пресъздам магията на света чрез причудливи илюстрации,
                            абстрактни форми, цветя и живописни пейзажи.
                        </p>
                        <p>
                            Освен визуалното изкуство, създавам и вдъхновяващи стихове и мотивационни послания – думи,
                            които докосват сърцето и пробуждат мечти. Всяко мое произведение носи емоция,
                            дълбочина и уникална история, която очаква да бъде споделена.
                        </p>
                        <p>
                            Добре дошли в моя свят – свят на цветове, вълшебства и вдъхновение!
                        </p>
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
