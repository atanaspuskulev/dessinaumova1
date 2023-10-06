@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5 px-0">
        <div class="row">
            <div class="col-md-6 px-0">
                <img style="width: 600px;" src="{{ asset('assets/images/DesiWEB.jpg') }}" class="img-fluid">
            </div>
            <div class="col-md-5 p-md-0 p-5">
                <h3 class="display-1">Dessi Naumova</h3>
                <hr />
                <br />
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
            </div>
        </div>
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
