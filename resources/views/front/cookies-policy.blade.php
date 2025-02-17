@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Политика за бисквитки</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-4">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                Тази Политика за бисквитки обяснява как сайтът на Деси Наумова („ние“, „нас“, „наши“) използва бисквитки и други подобни
                технологии, които да ви разпознават, когато посещавате нашия уебсайт на адрес {{ config('app.url') }} ("Уебсайт").
                Тук е обяснено какви са тези технологии, защо ги използваме и правата ви да контролирате използването им от наша страна.            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                <ol>
                    <li><a href="#introduction">Въведение</a></li>
                    <li><a href="#what-are-cookies">Какво представляват бисквитките?</a>
                    <li><a href="#types-of-cookies">Видове бисквитки, които използваме</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 border-bottom pb-3">
                <h3 id="introduction">1. Въведение</h3>
                Използвайки нашия уебсайт, вие се съгласявате с използването на бисквитки в съответствие с тази Политика за бисквитки.            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 border-bottom pb-3">
                <h3 id="what-are-cookies">2. Какво представляват бисквитките?</h3>
                Бисквитките са малки файлове с данни, които се поставят на вашия компютър или мобилно устройство, когато посещавате уебсайт.
                Бисквитките се използват широко от собствениците на уебсайтове, за да направят уебсайтовете си работещи или да работят по-ефективно,
                както и да предоставя отчетна информация.
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 pb-3">
                <h3 id="types-of-cookies">3. Видове бисквитки, които използваме</h3>
                Обичайните категории бисквитки, които използваме, включват:
                <ul>
                    <li>Плащания</li>
                    <li>Съхранение на продукти от количката</li>
                    <li>Проследяване на добавени продукти в количката</li>
                    <li>Административни цели</li>
                    <li>Външна трета страна, като (но не само) Google Analytics</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
