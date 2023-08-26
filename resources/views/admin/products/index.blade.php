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
                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-12 mb-3">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">{{ $product->title }}</h6>
                                </div>
                                <div class="card-body">
                                    <img src="{{ displayImage($product->id, $product->thumbnail->first()->path, true) }}" alt="Thumbnail" class="mb-2">
                                    {{ $product->short_description }}
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
