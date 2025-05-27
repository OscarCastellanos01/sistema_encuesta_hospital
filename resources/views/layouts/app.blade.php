<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('titulo')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- @livewireScripts  --}}
        <wireui:scripts />
        {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

        @stack('css')

        @stack('js')
        
    </head>
    <body class="h-full bg-gradient-to-tr from-[#e8f1f5] to-[#dfe9ef] bg-fixed">
        <x-drawer />

        <main>
            @yield('contenido')
        </main>

    </body>
</html>
