<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://pagecdn.io/lib/font-awesome/5.10.0-11/css/all.min.css" integrity="sha256-p9TTWD+813MlLaxMXMbTA7wN/ArzGyW/L7c5+KkjOkM=" crossorigin="anonymous">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="https://js.stripe.com/v3/"></script>
    </head>
    <body class="antialiased">
        <div id="app">
            <div class="min-h-full">
                @if(auth()->user() && auth()->user()->isAdmin())
                    @include('vue-layouts.backend-nav')
                    @yield('content')
                @else
                    @include('vue-layouts.backend-nav')
                    @yield('content')
                @endif
                @include('vue-layouts.footer')
            </div>
        </div>
        <script>
        window.App = @json(\App\App::get());
    </script>
    <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>