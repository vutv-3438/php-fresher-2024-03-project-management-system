<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Project Management') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    @if(isset($navigation))
        {{$navigation}}
    @else
        @include('layouts.navigation')
    @endif

    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="container">
            {{ $header }}
        </div>
    </header>

    <!-- Page Content -->
    <main class="{{$class}}">
        {{ $slot }}
    </main>

    @stack('scripts')
</div>
</body>
</html>
