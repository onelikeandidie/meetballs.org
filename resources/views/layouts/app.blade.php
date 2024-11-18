<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>

    <title>@section('title'){{ config('app.name') }}@show</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @yield('meta')

    @vite('resources/css/app.css')
</head>

<body class="antialiased @yield('body-class')">
@section('nav')
    <nav class="bg-neutral-800 text-neutral-400 p-4">
        <div class="flex items-center justify-start gap-2 container mx-auto">
            <a href="/" class="">
                <x-heroicon-o-home class="w-6 h-6 inline-block"/>
            </a>
        </div>
    </nav>
@show

@yield('content')

@section('footer')
    <footer class="bg-neutral-800 text-neutral-400 p-4">
        <div class="flex flex-col items-start justify-start gap-2 container mx-auto">
            <a href="https://discord.gg/XdCJctvybK" class="hover:text-neutral-200 align-middle">
                <x-tabler-brand-discord class="w-6 h-6 inline-block"/>
                Join the GeekSessions Discord
            </a>
            <p>
                Source available on
                <a href="https://github.com/onelikeandidie/meetballs.org" class="hover:text-neutral-200">
                    <x-tabler-brand-github class="w-6 h-6 inline-block"/>
                    GitHub
                </a>
            </p>
        </div>
    </footer>
@show
</body>
@vite('resources/js/app.js')
</body>
</html>
