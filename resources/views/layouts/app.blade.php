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

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{--    User defined --}}
    @stack('links')
    @stack('styles')
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation', ['wFull' => $wFull])

    <!-- Page Heading -->
    @if(isset($header))
        <header class="bg-white shadow">
            <div class="{{ $wFull ? 'container-fluid': 'container' }}">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main class="{{$class}} {{ $wFull ? 'container-fluid': 'container' }} mt-5">
        {{ $slot }}
    </main>

</div>
@stack('scripts')
</body>
</html>
