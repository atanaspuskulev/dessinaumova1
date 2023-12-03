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
            <div class="col-md-12 text-center">
                @if($products->count())
                    <table class="table text-start">
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
                            <tr>
                                <td colspan="4" class="text-end">
                                    <button class="btn btn-success">Proceed To Checkout</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <p>
                        Your cart is currently empty. You do not have added products yet.
                    </p>
                    <p>
                        You can browse my beautiful artwork from
                        @foreach($categories as $category)
                            <a href="{{ route('front.to_category', ['category' => $category->slug]) }}">{!! $category->title !!}</a>
                            @if($loop->remaining > 1)
                                ,
                            @elseif($loop->remaining === 1)
                                or
                            @endif
                        @endforeach
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
