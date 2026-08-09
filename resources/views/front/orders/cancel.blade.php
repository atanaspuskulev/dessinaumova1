@extends('layouts.front')

@section('content')
    <header class="py-5 align-content-start">
        <div class="container ">
            <div class="row">
                <div class="col">
                    <h1 class="display-6 text-center">Отказано плащане/поръчка</h1>
                    <hr />
                </div>
            </div>
        </div>
    </header>

    <div class="d-flex align-items-center justify-content-center mt-3 mb-4 p-5">
        Вашата поръчка е анулирана поради отказ от Ваша страна или възникнал проблем при обработката на плащането чрез PayPal. Ако смятате, че от Ваша страна няма проблем, не се колебайте да ми изпратите имейл. Ще се постарая да разреша проблема възможно най-скоро.<br /><br />
Междувременно можете да продължите да разглеждате моите произведения.<br /><br />
Благодаря Ви!
    </div>
@endsection
