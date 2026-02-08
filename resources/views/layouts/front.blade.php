
<!DOCTYPE html>
<html lang="bg">
<head>
    <title>{{ isset($page_title) ? $page_title . ' | ' . config('app.name') : config('seo.default_title') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="{{ $meta_description ?? config('seo.default_description') }}" />
    <meta name="keywords" content="{{ $meta_keywords ?? config('seo.default_keywords') }}" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine|Handlee|Gochi+Hand|Kalam|Grey+Qo"/>
    <link href="{{ asset('assets/css/front/style.css') }}" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.2-web/css/all.min.css') }}"/>
    <link href="{{ asset('assets/css/custom.css') }}" type="text/css" rel="stylesheet"/>
    @yield('head_additional_js')
    @yield('css_files')
    @yield('head_js')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Q5CM57ECZD"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-Q5CM57ECZD');
    </script>
</head>
<body>
    @include('front.partials.navigation')

    <main>
        @yield('content')
    </main>

    <footer class="py-5 bg-dark">
        <div class="container">
            <div class="row">
                <!-- Footer Links -->
                <div class="col-md text-start">
                    <h4>{{ __('site.about') }}</h4>
                    <hr />
                    <ul class="list-unstyled">
                        <li><a href="{{ route('front.terms_of_use') }}" class="text-white">{{ __('site.tos') }}</a></li>
                        <li><a href="{{ route('front.privacy_policy') }}" class="text-white">{{ __('site.privacy_policy') }}</a></li>
                        <li><a href="{{ route('front.cookies_policy') }}" class="text-white">{{ __('site.cookies_policy') }}</a></li>
                        <li><a href="{{ route('front.about') }}" class="text-white">{{ __('site.about') }}</a></li>
                        <li><a href="{{ route('front.contact') }}" class="text-white">{{ __('site.contact_me') }}</a></li>
                    </ul>
                </div>

                <div class="col-md text-start">
                    <h4>{{ __('site.categories') }}</h4>
                    <hr />
                    <ul class="list-unstyled">
                        @if(isset($products_categories) && $products_categories->count())
                            @foreach($products_categories as $slug => $title)
                                <li>
                                    <a
                                        class="text-white"
                                        href="{{ route('front.to_category', [
                                            'category' => $slug
                                        ]) }}"
                                    >
                                        {{ $title }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div class="col-md text-start">
                    <h4>{{ __('site.follow_me') }}</h4>
                    <hr />
                    <a target="_blank" href="https://www.facebook.com/DesiNaumovaArtworks" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                    <a target="_blank" href="https://www.instagram.com/desislava.naumova/" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ __('site.reserved') }}</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('assets/bootstrap-5.0.2/js/bootstrap.bundle.js') }}"></script>
    @yield('js_files')
</body>
</html>
