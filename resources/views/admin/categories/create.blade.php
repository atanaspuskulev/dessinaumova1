@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-12 text-gray-800">Create new category</h1>

    <div class="row mb-3">
        <div class="col-lg col-md">
            <div class="card shadow mb-12">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Category Information</h6>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {!! implode("<br>", $errors->all()) !!}
                        </div>
                    @endif
                    <form
                        method="post"
                        action="{{ route('categories.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="title"
                                        name="title"
                                        value="{{ old('title') }}">
                                </div>
                                <div class="form-group">
                                    <label for="slug">Category slug</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="slug"
                                        name="slug"
                                        value="{{ old('slug') }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea
                                        class="form-control"
                                        id="description"
                                        name="description"
                                        rows="6">{{ old('description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta description</label>
                                    <textarea
                                        class="form-control"
                                        id="meta_description"
                                        name="meta_description"
                                        rows="6">{{ old('meta_description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta keywords</label>
                                    <textarea
                                        class="form-control"
                                        id="meta_keywords"
                                        name="meta_keywords"
                                        rows="6">{{ old('meta_keywords') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="meta_title">Meta title</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="meta_title"
                                        name="meta_title"
                                        value="{{ old('meta_title') }}">
                                </div>
                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="position"
                                        name="position"
                                        value="{{ old('position') }}">
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        name="is_active"
                                        type="checkbox"
                                        value="1"
                                        id="is_active"
                                        @checked(old('is_active') == 1)>
                                    <label class="form-check-label" for="is_active">
                                        Is active
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pt-4 pb-3">
                                <hr>
                                <button type="submit" class="float-right btn btn-primary ml-3">Create</button>
                                <a  href="{{ route('categories.index') }}" class="float-right btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
