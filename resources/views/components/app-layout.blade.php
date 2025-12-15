<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('socio.dashboard') }}" class="font-bold text-2xl text-green-600">
                                    COOPROCON
                                </a>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                    Inicio
                                </a>

                                @if(Auth::user()->tipo == 0)
                                    <a href="{{ route('ahorros.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('ahorros.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                                        Mis Ahorros
                                    </a>
                                    <a href="{{ route('prestamos.mis_prestamos') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('prestamos.mis_prestamos') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                                        Mis Préstamos
                                    </a>
                                @endif

                                @if(Auth::user()->tipo == 2)
                                    <a href="{{ route('admin.prestamos.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.prestamos.*') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                                        🏢 Gestión Préstamos
                                    </a>
                                    @endif

                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative" x-data="{ open: false }">
                                <div>
                                    <button @click="open = ! open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ Auth::user()->cedula ?? 'Usuario' }}</div> <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </div>

                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5" style="display: none;">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
