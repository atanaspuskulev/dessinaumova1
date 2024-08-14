<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Desi Naumova</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="description" content="" />
        <meta name="keywords" content="" />

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
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Desi Naumova. All rights reserved.</p>
        </div>
    </footer>
</html>
