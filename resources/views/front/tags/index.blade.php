@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Categories</h1>
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
