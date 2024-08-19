@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Explore All Tags</h1>
                <p>Welcome to our Tags Overview page. Here, you can explore all the product tags available at Desi Naumova.
                    Whether you're looking for hand-crafted paintings, aromatic candles, or exquisite wooden articles, you'll find them organized by tags for easy browsing.</p>
                <hr>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-4">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                @forelse($tags as $tag)
                    <div class="row">
                        <div class="col-md-2 mb-2 p-2 border rounded-2">
                            <a href="{{ route('front.by_tag', ['tag' => $tag->slug]) }}">{{ $tag->name }} ({{ $tag->products_count }})</a>
                        </div>
                    </div>
                @empty
                    <h5>There are no in-categories currently defined</h5>
                @endforelse
            </div>
        </div>
    </div>
@endsection
