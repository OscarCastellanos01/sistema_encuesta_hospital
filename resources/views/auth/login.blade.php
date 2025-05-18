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
    <wireui:scripts />
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

    @stack('css')

    @stack('js')
</head>

<body class="h-full bg-gradient-to-tr from-[#e8f1f5] to-[#dfe9ef] bg-fixed">
    <div class="w-full min-h-screen flex items-center justify-center bg-gray-200 dark:bg-gray-900">
        <div class="w-full max-w-md p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl ">
            <div class="text-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-35 mx-auto mb-4">
            </div>
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Iniciar Sesión</h1>
            </div>
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <x-input
                    label="Correo Electrónico"
                    name="email"
                    type="email"
                    placeholder="ejemplo@correo.com"
                    class="mb-4"
                    icon="envelope"
                    required
                />
                <x-input
                    label="Contraseña"
                    name="password"
                    type="password"
                    class="mb-4"
                    icon="lock-closed"
                    required
                />
                @if (session()->has('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        {{ session('error') }}
                    </div>
                @endif
                <x-button
                    type="submit"
                    primary label="Ingresar"
                    class="w-full"
                />
            </form>
        </div>
    </div>
    </main>
</body>

</html>
