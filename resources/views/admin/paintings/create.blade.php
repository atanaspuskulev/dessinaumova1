@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-12 text-gray-800">Add new painting</h1>

    <div class="row">
        <div class="col-lg col-md">
            <div class="card shadow mb-12 ">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Painting Information</h6>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title">
                                </div>
                                <div class="form-group">
                                    <label for="short_description">Short description</label>
                                    <textarea class="form-control" name="short_description" id="short_description" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="6"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="material">Material description</label>
                                    <input type="text" class="form-control" id="material" name="material">
                                </div>
                                <div class="form-group">
                                    <label for="dimentions1">Size description</label>
                                    <input type="text" class="form-control" name="dimentions1" id="dimentions1">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" class="form-control" id="price">
                                </div>
                                <div class="form-group">
                                    <label for="delivery">Delivery information</label>
                                    <input type="text" class="form-control" id="delivery" name="delivery" placeholder="Delivery information">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="sold" type="checkbox" value="1" id="sold">
                                    <label class="form-check-label" for="sold">
                                        Sold
                                    </label>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input name="meta_title" type="text" class="form-control" id="meta_title">
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input name="meta_keywords" type="text" class="form-control" id="meta_keywords">
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" id="meta_description" rows="3"></textarea>
                                </div>
                                <hr>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose files</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
