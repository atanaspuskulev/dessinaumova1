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
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" placeholder="Enter title">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" placeholder="Enter price">
                        </div>
                        <div class="form-group">
                            <label for="short_description">Short description</label>
                            <textarea class="form-control" id="short_description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" rows="6"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="material">Material</label>
                            <input type="text" class="form-control" id="material" placeholder="Material description">
                        </div>
                        <div class="form-group">
                            <label for="dimentions1">Size</label>
                            <input type="text" class="form-control" id="dimentions1" placeholder="Size description">
                        </div>
                        <div class="form-group">
                            <label for="delivery">Delivery information</label>
                            <input type="text" class="form-control" id="delivery" placeholder="Delivery information">
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
