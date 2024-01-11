@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Contact Me</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-center mt-3 mb-4">
        <form method="post  ">
            <div class="row mb-3">
                <div class="col">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 col-sm-12">
                    <label for="names" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="names" name="names" placeholder="">
                </div>
                <div class="col-md-6 col-sm-12">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="">
                </div>
            </div>

            <div class="row mb-3">
                <label for="message" class="form-label">Message</label>
                <div class="col">
                    <textarea class="form-control" name="message" id="message" rows="4" placeholder=""></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
