<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ isset($page_title) ? $page_title . ' | Desi Naumova' : config('seo.default_title') }}</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="description" content="{{ $meta_description ?? config('seo.default_description') }}" />
        <meta name="keywords" content="{{ $meta_keywords ?? config('seo.default_keywords') }}" />

        <link href="{{ asset('assets/bootstrap-5.0.2/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine|Handlee|Gochi+Hand|Kalam|Grey+Qo"/>
        <link href="{{ asset('assets/css/custom.css') }}" type="text/css" rel="stylesheet"/>
        @yield('css_files')
        @yield('head_js')
    </head>
    <body>

    @include('front.partials.navigation')

    @yield('content')

    <script src="{{ asset('assets/bootstrap-5.0.2/js/bootstrap.bundle.js') }}"></script>
        @yield('js_files')
    </body>
    <footer class="bg-dark text-white py-4 footer">
        <div class="container">
            <div class="row">
                <!-- Footer Links -->
                <div class="col-md-2 text-start">
                    <h4>About</h4>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('front.terms_of_use') }}" class="text-white">Terms of Use</a></li>
                        <li><a href="{{ route('front.privacy_policy') }}" class="text-white">Privacy Policy</a></li>
                        <li><a href="{{ route('front.cookies_policy') }}" class="text-white">Cookies Policy</a></li>
                        <li><a href="{{ route('front.about') }}" class="text-white">About</a></li>
                        <li><a href="{{ route('front.contact') }}" class="text-white">Contact</a></li>
                    </ul>
                </div>

                <div class="col-md-2 text-start">
                    <h4>Categories</h4>
                    <ul class="list-unstyled">
                        @if(isset($products_categories) && $products_categories->count())
                            @foreach($products_categories as $slug => $title)
                                <li>
                                    <a class="text-white" href="{{ route('front.to_category', ['category' => $slug]) }}">{{ $title }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <!-- Social Media Links (Optional) -->
                <div class="col-md-3 text-md-end">
                    <span>Follow me:</span>
                    <a href="https://facebook.com" class="text-white me-2">Facebook</a>
                    <a href="https://twitter.com" class="text-white me-2">Instagram</i></a>
                    <a href="https://instagram.com" class="text-white">TikTok</i></a>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} Desi Naumova. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

</html>
