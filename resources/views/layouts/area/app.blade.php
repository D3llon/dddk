<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', ''){{ config('app.name', 'Laravel') }}</title>

    @include('layouts.head')
</head>
<body>
<div id="app">

    @include('layouts.components.UserBar')
    @include('layouts.components.TopNavbarPublic')

    <main>

        @include('layouts.messages')
        @yield('content')

    </main>

    @include('layouts.components.Footer')
    @include('layouts.scripts')
</div>
</body>
</html>
