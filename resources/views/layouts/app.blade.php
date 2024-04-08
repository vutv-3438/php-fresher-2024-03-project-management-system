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
    <!-- Page Header -->
    @include('layouts.header', ['wFull' => $wFull])

    <!-- Page Navigation -->
    <div class="bg-white shadow border-top border-top-secondary">
        <div class="{{ $wFull ? 'container-fluid': 'container' }}">
            @if(isset($navigation))
                @include('layouts.navigation')
            @endif
        </div>
    </div>

    <!-- Page Content -->
    <main class="{{$class}} {{ $wFull ? 'container-fluid': 'container' }} mt-5">
        {{ $slot }}
    </main>
</div>
@stack('scripts')
</body>
</html>
