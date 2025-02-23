@extends('layouts.front')

@section('head_js')
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".image-wrapper").hover(
                function () {
                    $(this).find("img").css("transform", "scale(1.1)");
                },
                function () {
                    $(this).find("img").css("transform", "scale(1)");
                }
            );
        });
    </script>
@endsection

@section('content')
    <header class="bg-heading py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-5 fw-bolder desi-title">{{ __('text.shop_greeting') }}</h1>
                <p class="lead fw-normal mb-0">{{ __('text.index_lead') }}</p>
            </div>
        </div>
    </header>
    <section class="py-5">
        <div class="container-fluid mt-5">
            <div class="row equal-height">
                @if(isset($maincategory))
                    <div class="col-md-7 col-sm-12 image-wrapper">
                        <a class="image-link" href="{{ route('front.to_category', ['category' => $maincategory->slug]) }}">
                            <img class="img-fluid" src="{!! displayImage($maincategory->id, $maincategory->thumbnail->path, isThumbnail: false, uploadPath: 'categories') !!}" />
                            <div class="overlay">
                                <h4 class="title">{{ $maincategory->title }}</h4>
                                <p class="description">{!! $maincategory->description  !!}</p>
                            </div>
                        </a>
                    </div>
                @endif
                <div class="col-md-5">
                    <div class="row">
                        @forelse($items as $item)
                            <div class="col-md-12 col-sm-12 mb-3  d-flex flex-column align-self-start image-wrapper">
                                <a class="image-link" href="{{ route('front.to_category', ['category' => $item->slug]) }}">
                                    <img class="img-fluid right-image" src="{!! displayImage($item->id, $item->thumbnail->path, isThumbnail: false, uploadPath: 'categories') !!}" />
                                    <div class="overlay">
                                        <h4 class="title">{{ $item->title }}</h4>
                                        <p class="description">{!! $item->description  !!}</p>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-md-6">{{ __('site.no_products') }}</div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
