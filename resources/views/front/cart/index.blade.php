@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Your shopping cart</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if($products->count())
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ displayImage($product->id, $product->thumbnail?->path, true) }}" width="50"/>
                                        <a target="_new" href="{{ route('front.product_view', ['category_slug' => $product->category->slug, 'product_slug' => $product->slug]) }}" class="text-black-50">
                                            {!! $product->title !!}
                                        </a>
                                    </td>
                                    <td>{!! $product->category->title !!}</td>
                                    <td>{!! $product->price !!}&euro;</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="text-end">Total: {{ $totalPrice }}&euro;</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    empty
                @endif
            </div>
        </div>
    </div>
@endsection
