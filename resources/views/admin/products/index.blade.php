@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-12 text-gray-800">List Products</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List of all products</h6>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                    @forelse($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-12 mb-3">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">{{ $product->title }}</h6>
                                </div>
                                <div class="card-body" style="height:445px; max-height: 445px; overflow-y: scroll;">
                                    <img
                                        src="{{ displayImage($product->id, $product->thumbnail->first()?->path, true) }}"
                                        alt=""
                                        class="mb-2 img-fluid">
                                    <p>
                                        <b>Category: </b><br />
                                        {{ $product->category->title }}
                                    </p>
                                    <p>
                                        <b>Short Description: </b><br />
                                        {{ $product->short_description }}
                                    </p>
                                    <p>
                                        <b>Price: </b><br />
                                        ${{ $product->price }}
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('products.edit', ['product' => $product]) }}" class="btn btn-sm btn-info mr-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        There're no products currently available.
                        Start here and <a href="{{ route('products.create') }}" class="ml-1">add new product</a>.
                    @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
