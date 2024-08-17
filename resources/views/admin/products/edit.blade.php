@extends('layouts.admin')

@section('head_content')
    <link href="{{ asset('/assets/js/tagify/dist/tagify.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('/assets/js/tagify/dist/tagify.js') }}"></script>
@endsection
@section('content')
    <h1 class="h3 mb-12 text-gray-800">Edit product "{{ $product->title }}"</h1>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="row mb-3">
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
                    <form method="post" action="{{ route('products.update', ['product' => $product]) }}"
                          enctype="multipart/form-data">
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
                                            <option
                                                value="{{$category->id}}" @selected(old('category_id', $product->category_id) == $category->id)>{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{ old('title', $product->title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="slug">URL</label>
                                    <input
                                        type="text"
                                        class="form-control" id="slug" name="slug"
                                        value="{{ old('slug', $product->slug) }}">
                                </div>
                                <div class="form-group">
                                    <label for="short_description">Short description</label>
                                    <textarea class="form-control" name="short_description" id="short_description"
                                              rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description"
                                              rows="6">{{ old('description', $product->description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="material">Material description</label>
                                    <input type="text" class="form-control" id="material" name="material"
                                           value="{{ old('material', $product->material) }}">
                                </div>
                                <div class="form-group">
                                    <label for="dimentions1">Size description</label>
                                    <input type="text" class="form-control" name="dimentions1" id="dimentions1"
                                           value="{{ old('dimentions1', $product->dimentions1) }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" class="form-control" id="price"
                                           value="{{ old('price', $product->price) }}">
                                </div>
                                <div class="form-group">
                                    <label for="delivery">Delivery information</label>
                                    <input type="text" class="form-control" id="delivery" name="delivery"
                                           placeholder="Delivery information"
                                           value="{{ old('delivery', $product->delivery) }}">
                                </div>
                                <div class="form-group">
                                    <label for="delivery">Product Tags</label>
                                    <input
                                        class="form-control ml-0"
                                        id="tagcontent"
                                        name="tags"
                                        value=""
                                        placeholder="Write/select your tags"
                                    >
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        name="sold" type="checkbox"
                                        value="1"
                                        id="sold" @checked(old('sold', $product->sold) == 1)
                                    >
                                    <label class="form-check-label" for="sold">
                                        Sold
                                    </label>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input name="meta_title" type="text" class="form-control" id="meta_title"
                                           value="{{ old('meta_title', $product->meta_title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input name="meta_keywords" type="text" class="form-control" id="meta_keywords"
                                           value="{{ old('meta_keywords', $product->meta_keywords) }}">
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" id="meta_description"
                                              rows="3">{{ old('meta_description', $product->meta_description) }}</textarea>
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
                                <a  href="{{ route('products.index') }}" class="float-right btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg col-md">
            <div class="card shadow mb-12">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Product Gallery</h6>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center sortable-container">
                        @if($product->gallery->count())
                            <div class="col-md-12 col-sm-12 alert mb-3 alert-primary" role="alert">
                                <i>Use drag and drop to reorder the images.</i>
                            </div>
                        @endif
                        @forelse($product->gallery as $image)
                            <div id="{{ $image->id }}" class="col col-md-3 p-2 col-sm-12 mb-4 ml-3 gallery-shadow sortable-item">
                                <div class="row">
                                    <div class="col d-flex justify-content-center align-items-center">
                                        <a href="{{ displayImage($product->id, $image->path) }}" rel="gallery" class="gallery_images">
                                            <img
                                                src="{{ displayImage($product->id, $image->path, true) }}"
                                                alt="Gallery Image"
                                                class="img-fluid">
                                        </a>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col text-end">
                                        <a href="javascript:void(0);" onclick="deleteImage('{{ route('products.images.destroy', ['product' => $product, 'image' => $image]) }}')" class="btn btn-danger fa-pull-right btn-sm m-2">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12 col-sm-12 alert alert-warning" role="alert">
                                No gallery images has been uploaded yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteImage" tabindex="-1" role="dialog" aria-labelledby="deleteImage"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteImage">Delete Image?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to delete this gallery image?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a onclick="destoryImageAction()" class="btn btn-danger" href="javascript:void(0);">Delete</a>
                </div>
            </div>
        </div>
    </div>
@endsection
