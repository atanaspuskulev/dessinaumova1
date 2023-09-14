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
                                    <div class="card shadow @if($product->trashed()) bg-gray-200 @endif">
                                        <div style="max-height:70px;height:70px;" class="card-header py-3 @if($product->trashed()) bg-warning @endif">
                                            <h6 class="m-0 font-weight-bold text-primary">{{ mb_strimwidth($product->title, 0, 45, '...') }}</h6>
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
                                                <a data-toggle="tooltip" title="Edit product" href="{{ route('products.edit', ['product' => $product]) }}" class="btn btn-sm btn-info mr-2">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($product->trashed())
                                                    <a data-toggle="tooltip" title="Restore product" href="javascript:void(0);" onclick="restoreProduct('{{ route('products.restore', ['product' => $product]) }}');" class="btn btn-sm btn-secondary mr-2">
                                                        <i class="fas fa-folder-plus"></i>
                                                    </a>
                                                    <a data-toggle="tooltip" title="Permanently delete product" onclick="destroyProduct('{{ route('products.force-delete', ['product' => $product]) }}')" href="javascript:void(0);" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @else
                                                    <a data-toggle="tooltip" title="Archive this product" onclick="trashProduct('{{ route('products.destroy', ['product' => $product]) }}')" href="javascript:void(0);" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-folder-minus"></i>
                                                    </a>
                                                @endif
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
    @include('admin/partials/product_modals')
@endsection
