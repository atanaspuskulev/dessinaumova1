@extends('layouts.front')

@section('content')
    <header class="bg-heading py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder desi-title">{{ __('text.shop_greeting') }}</h1>
                <p class="lead fw-normal mb-0">{{ __('text.index_lead') }}</p>
            </div>
        </div>
    </header>
    <section class="py-5">
        <div class="container-fluid mt-5">
        <div class="row equal-height">
            @forelse($products as $product)
                @include('front.partials.product-item', ['columnClass' => 'col-md-4', 'productItem' => $product])
            @empty
                <div class="col-md-6">{{ __('site.no_products') }}</div>
            @endforelse
        </div>
    </div>
    </section>
@endsection
