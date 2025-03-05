@extends('layouts.front')

@section('content')
    <header class="py-5 align-content-start">
        <div class="container ">
            <div class="row">
                <div class="col">
                    <h1 class="display-6 text-center">{{ $categoryData?->title }}</h1>
                    <p class="fw-normal text-dark text-center mb-0">
                        {!! $categoryData->description !!}
                    </p>
                    <hr />
                </div>
            </div>
            <div class="text-white">
                <h1 class="display-6 fw-bolder"></h1>

            </div>
        </div>
    </header>
    <section class="py-5">
        <div class="container">
        <div class="row equal-height">
            @forelse($products as $product)
                @include('front.partials.product-item', ['productItem' => $product])
            @empty
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">{{ __('messages.no_products') }}</div>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="row mb-4">
            <div class="col text-center">
                <nav>
                    <ul class="pagination justify-content-center">
                        {{ $products->links() }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    </section>
@endsection
