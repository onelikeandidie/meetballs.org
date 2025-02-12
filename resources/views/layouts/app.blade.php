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
    @vite('resources/js/app.js')
</head>

<body class="antialiased @yield('body-class')">
@section('nav')
    <nav
        class="flex items-center justify-around h-12 md:h-16 bg-white text-gray-900 sticky left-0 top-0 right-0 transition-[height] duration-500">
        <div class="flex gap-2">
            {{-- Probably put some links in here --}}
        </div>
        <a class="text-center flex-1 relative"
           href="{{ route('home') }}">
            <h1 class="text-2xl md:text-2xl font-display duration-750">
                <span class="text-amber-800">&lt;</span>Meetballs<span class="text-amber-800">/&gt;</span>
            </h1>
        </a>
        <div class="flex gap-2 justify-end">
            {{-- Probably put some links in here --}}
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
</html>
