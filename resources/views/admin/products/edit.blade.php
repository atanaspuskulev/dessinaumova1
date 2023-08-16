@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-12 text-gray-800">Edit product "{{ $product->title }}"</h1>

    <div class="row">
        <div class="col-lg col-md">
            <div class="card shadow mb-12">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Product Information</h6>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {!! implode("<br>", $errors->all()) !!}
                        </div>
                    @endif
                    <form method="post" action="{{ route('products.update', ['product' => $product]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Choose</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" @selected(old('category_id', $product->category_id) == $category->id)>{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $product->title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="short_description">Short description</label>
                                    <textarea class="form-control" name="short_description" id="short_description" rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="6">{{ old('description', $product->description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="material">Material description</label>
                                    <input type="text" class="form-control" id="material" name="material" value="{{ old('material', $product->material) }}">
                                </div>
                                <div class="form-group">
                                    <label for="dimentions1">Size description</label>
                                    <input type="text" class="form-control" name="dimentions1" id="dimentions1" value="{{ old('dimentions1', $product->dimentions1) }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" class="form-control" id="price" value="{{ old('price', $product->price) }}">
                                </div>
                                <div class="form-group">
                                    <label for="delivery">Delivery information</label>
                                    <input type="text" class="form-control" id="delivery" name="delivery" placeholder="Delivery information" value="{{ old('delivery', $product->delivery) }}">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="sold" type="checkbox" value="1" id="sold" @checked(old('sold', $product->sold) == 1)>
                                    <label class="form-check-label" for="sold">
                                        Sold
                                    </label>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input name="meta_title" type="text" class="form-control" id="meta_title" value="{{ old('meta_title', $product->meta_title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input name="meta_keywords" type="text" class="form-control" id="meta_keywords" value="{{ old('meta_keywords', $product->meta_keywords) }}">
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" id="meta_description" rows="3">{{ old('meta_description', $product->meta_description) }}</textarea>
                                </div>
                                <hr>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" multiple name="images[]" id="images">
                                    <label class="custom-file-label" for="images">Choose files</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pt-4 pb-3">
                                <hr>
                                <button type="submit" class="float-right btn btn-primary ml-3">Update</button>
                                <button type="button" class="float-right btn btn-danger">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
