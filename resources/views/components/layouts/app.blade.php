@props(['title'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if(isset($title))
    <title> {{ $title . ' | '}} {{ config('app.name', 'Laravel') }}</title>
    @else
    <title>@stack('title')</title>

    @endif
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @filamentStyles
    @livewireStyles
    @stack('styles')
    @vite('resources/css/app.css')
</head>

<body {{ $attributes->class(['antialiased font-aeonik']) }}>
    {{ $slot }}
    @livewireScripts
    @filamentScripts
    @stack('scripts')
    @vite('resources/js/app.js')
</body>

</html>