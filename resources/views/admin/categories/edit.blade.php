@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-12 text-gray-800">{{ __('form.edit_category') }} "{{ $category->title }}"</h1>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="row mb-3">
        <div class="col-lg col-md">
            <div class="card shadow mb-12">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('form.edit_information') }}</h6>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {!! implode("<br>", $errors->all()) !!}
                        </div>
                    @endif
                    <form
                        enctype="multipart/form-data"
                        method="post"
                        action="{{ route('categories.update', compact('category')) }}">
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="title">{{ __('form.title') }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="title"
                                        name="title"
                                        value="{{ old('title', $category->title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="slug">{{ __('form.slug') }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="slug"
                                        name="slug"
                                        value="{{ old('slug', $category->slug) }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">{{ __('form.description') }}</label>
                                    <textarea
                                        class="form-control"
                                        id="description"
                                        name="description"
                                        rows="6">{{ old('description', $category->description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">{{ __('form.meta_description') }}</label>
                                    <textarea
                                        class="form-control"
                                        id="meta_description"
                                        name="meta_description"
                                        rows="6">{{ old('meta_description', $category->meta_description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">{{ __('form.meta_keywords') }}</label>
                                    <textarea
                                        class="form-control"
                                        id="meta_keywords"
                                        name="meta_keywords"
                                        rows="6">{{ old('meta_keywords', $category->meta_keywords) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="meta_title">{{ __('form.meta_title') }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="meta_title"
                                        name="meta_title"
                                        value="{{ old('meta_title', $category->meta_title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="position">{{ __('form.position') }}</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="position"
                                        name="position"
                                        value="{{ old('position', $category->position) }}">
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        name="is_active"
                                        type="checkbox"
                                        value="1"
                                        id="is_active"
                                        @checked(old('is_active', $category->is_active ) == 1)>
                                    <label class="form-check-label" for="is_active">
                                        {{ __('form.is_active') }}
                                    </label>
                                </div>
                                <div class="form-group">
                                    <hr>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="image">
                                        <label class="custom-file-label" for="image">{{ __('form.choose_image') }}</label>
                                    </div>
                                    <br /><br />
                                    @if($category->thumbnail)
                                        <img src="{!! displayImage($category->id, $category->thumbnail->path, isThumbnail: true, uploadPath: 'categories') !!}" />
                                    @else
                                        {{ __('form.no_image') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pt-4 pb-3">
                                <hr>
                                <button type="submit" class="float-right btn btn-primary ml-3">{{ __('form.update') }}</button>
                                <a href="{{ route('categories.index') }}" class="float-right btn btn-danger">{{ __('form.cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
