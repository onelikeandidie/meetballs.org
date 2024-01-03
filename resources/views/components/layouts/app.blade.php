<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __(config('app.name')) }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono|inter:400,600&display=swap" rel="stylesheet"/>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="antialiased">
{{ $slot }}
<footer class="bg-neutral-800 text-neutral-400 p-4">
    <div class="flex flex-col items-start justify-start gap-2 container mx-auto">
        <a href="https://discord.gg/XdCJctvybK" class="hover:text-neutral-200">
            <x-icon.fontawesome.discord class="inline-block w-5 h-5"/>
            Join the GeekSessions Discord
        </a>
        <p>
            Source available on
            <a href="https://github.com/onelikeandidie/meetballs.org" class="hover:text-neutral-200">
                <x-icon.fontawesome.github class="inline-block w-5 h-5"/>
                GitHub
            </a>
        </p>
    </div>
</footer>
</body>
</html>
