<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    @php
        use Jenssegers\Agent\Agent;
        $agent = new Agent();
        $isMobile = $agent->isMobile();
    @endphp
    <body class="font-sans text-gray-900 antialiased">
        @if ($isMobile)
            @include('partials.landing_mobile')
        @else
            @include('partials.landing_desktop')
        @endif
        @vite('resources/js/LandingPage.js')
    </body>
</html>
