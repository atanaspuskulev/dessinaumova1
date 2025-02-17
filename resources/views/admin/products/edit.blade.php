@extends('layouts.admin')

@section('head_content')
    <script>
        var available_tags ={!! json_encode($tags) !!};
    </script>

    <link href="{{ asset('/assets/js/tagify/dist/tagify.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('/assets/js/tagify/dist/tagify.js') }}"></script>
@endsection
@section('content')
    <h1 class="h3 mb-12 text-gray-800">{{ __('form.edit_product') }} "{{ $product->title }}"</h1>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="row mb-3">
        <div class="col-lg col-md">
            <div class="card shadow mb-12">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('form.information') }}</h6>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {!! implode("<br>", $errors->all()) !!}
                        </div>
                    @endif
                    <form
                        method="post"
                        action="{{ route('products.update', ['product' => $product]) }}"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="category_id">{{ __('strings.category') }}</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">{{ __('form.choose') }}</option>
                                        @foreach($categories as $category)
                                            <option
                                                value="{{$category->id}}" @selected(old('category_id', $product->category_id) == $category->id)>{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">{{ __('form.title') }}</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{ old('title', $product->title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="slug">{{ __('form.slug') }}</label>
                                    <input
                                        type="text"
                                        class="form-control" id="slug" name="slug"
                                        value="{{ old('slug', $product->slug) }}">
                                </div>
                                <div class="form-group">
                                    <label for="short_description">{{ __('strings.short_description') }}</label>
                                    <textarea class="form-control" name="short_description" id="short_description"
                                              rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description">{{ __('form.description') }}</label>
                                    <textarea class="form-control" id="description" name="description"
                                              rows="6">{{ old('description', $product->description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="material">{{ __('form.material_description') }}</label>
                                    <input type="text" class="form-control" id="material" name="material"
                                           value="{{ old('material', $product->material) }}">
                                </div>
                                <div class="form-group">
                                    <label for="dimentions1">{{ __('form.size_description') }}</label>
                                    <input type="text" class="form-control" name="dimentions1" id="dimentions1"
                                           value="{{ old('dimentions1', $product->dimentions1) }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="price">{{ __('strings.price') }}</label>
                                    <input
                                        type="text" name="price"
                                        class="form-control"
                                        id="price"
                                        value="{{ old('price', $product->price) }}">
                                </div>
                                <div class="form-group">
                                    <label for="currency">{{ __('strings.currency') }}</label>
                                    <select name="currency" id="currency" class="form-control">
                                        <option value="">{{ __('form.choose') }}</option>
                                        @foreach(['EUR', 'BGN'] as $currency)
                                            <option  @selected(old('currency', $product->currency ?? $currency) == $currency) value="{{ $currency }}">{{ $currency }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="shipping_cost">{{ __('strings.shipping_cost') }}</label>
                                    <input
                                        type="text"
                                        name="shipping_cost"
                                        class="form-control"
                                        id="shipping_cost"
                                        value="{{ old('shipping_cost', $product->shipping_cost) }}">
                                </div>
                                <div class="form-group">
                                    <label for="delivery">{{ __('strings.delivery_information') }}</label>
                                    <input type="text" class="form-control" id="delivery" name="delivery"
                                           placeholder="Delivery information"
                                           value="{{ old('delivery', $product->delivery) }}">
                                </div>
                                <div class="form-group">
                                    <label for="delivery">{{ __('strings.tags') }}</label>
                                    <input
                                        class="form-control ml-0"
                                        id="tagcontent"
                                        name="tags"
                                        value="{{ implode(', ', $product->tags->pluck('name')->toArray()) }}"
                                        placeholder="{{ __('form.tags_placeholder') }}"
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
                                        {{ __('form.sold') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        name="has_qty" type="checkbox"
                                        value="1"
                                        id="has_qty" @checked(old('has_qty', $product->has_qty) == 1)
                                    >
                                    <label class="form-check-label" for="has_qty">
                                        {{ __('form.has_qty') }}
                                    </label>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="meta_title">{{ __('form.meta_title') }}</label>
                                    <input name="meta_title" type="text" class="form-control" id="meta_title"
                                           value="{{ old('meta_title', $product->meta_title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">{{ __('form.meta_keywords') }}</label>
                                    <input name="meta_keywords" type="text" class="form-control" id="meta_keywords"
                                           value="{{ old('meta_keywords', $product->meta_keywords) }}">
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">{{ __('form.meta_description') }}</label>
                                    <textarea name="meta_description" class="form-control" id="meta_description"
                                              rows="3">{{ old('meta_description', $product->meta_description) }}</textarea>
                                </div>
                                <hr>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" multiple name="images[]" id="images">
                                    <label class="custom-file-label" for="images">{{ __('form.choose_files') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pt-4 pb-3">
                                <hr>
                                <button type="submit" class="float-right btn btn-primary ml-3">{{ __('form.update') }}</button>
                                <a  href="{{ route('products.index') }}" class="float-right btn btn-danger">{{ __('form.cancel') }}</a>
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
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('strings.gallery') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center sortable-container">
                        @if($product->gallery->count())
                            <div class="col-md-12 col-sm-12 alert mb-3 alert-primary" role="alert">
                                <i>Можете да пренаредите картинките с влачене</i>
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
                                Няма качени снимки към продукта.
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
                    <h5 class="modal-title" id="deleteImage">{{ __('strings.delete_image_title') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">{{ __('strings.delete_image_question') }}</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('strings.cancel') }}</button>
                    <a onclick="destoryImageAction()" class="btn btn-danger" href="javascript:void(0);">{{ __('strings.delete') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
