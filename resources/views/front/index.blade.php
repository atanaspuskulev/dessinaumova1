@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5 px-0">
        <img src="{{ asset('assets/images/desinaumovashop1.jpg') }}" alt="Image" class="img-fluid">
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Product 1 -->
                <div class="card mb-4">
                    <img src="product1.jpg" class="card-img-top" alt="Product 1">
                    <div class="card-body">
                        <h5 class="card-title">Product 1</h5>
                        <p class="card-text">Description of Product 1.</p>
                        <a href="#" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Product 2 -->
                <div class="card mb-4">
                    <img src="product2.jpg" class="card-img-top" alt="Product 2">
                    <div class="card-body">
                        <h5 class="card-title">Product 2</h5>
                        <p class="card-text">Description of Product 2.</p>
                        <a href="#" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <!-- Repeat this structure for additional products -->
        </div>
    </div>
@endsection
