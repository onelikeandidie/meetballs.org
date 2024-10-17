<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @vite('resources/css/app.css')
</head>
<body class="antialiased">
<div class="relative flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8 flex flex-col items-center">
        <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
            <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
                &lt;@yield('code')/&gt;
            </div>

            <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                @yield('message')
            </div>
        </div>

        <a class="text-blue-500 hover:underline mt-4"
           href="/">
            Go Home
        </a>
    </div>
</div>
</body>
</html>
