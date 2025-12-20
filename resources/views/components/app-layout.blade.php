<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Cooperativa') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
        {{-- Cargamos FontAwesome para los iconos del menú --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

        <style>
            body { font-family: 'Figtree', sans-serif; }
            /* Estilo para ocultar elementos en la impresión */
            @media print {
                .no-print { display: none !important; }
                nav, header { display: none !important; }
                body { background: white !important; }
                .max-w-7xl { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            <nav x-data="{ open: false }" class="bg-white border-b border-gray-100 no-print">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <a href="{{ Auth::check() ? (Auth::user()->tipo == 2 ? route('admin.dashboard') : route('socio.dashboard')) : route('login') }}" class="font-black text-2xl text-green-600 tracking-tighter italic">
                                    COOPROCON
                                </a>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                                {{-- Enlace Inicio (Solo si está logueado) --}}
                                @auth
                                    <a href="{{ Auth::user()->tipo == 2 ? route('admin.dashboard') : route('socio.dashboard') }}"
                                       class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('*.dashboard') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-bold leading-5 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out uppercase tracking-wider">
                                        Inicio
                                    </a>
                                @endauth

                                {{-- Enlace Quienes Somos (Siempre visible) --}}
                                <a href="{{ route('quienes-somos') }}"
                                   class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('quienes-somos') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-bold leading-5 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out uppercase tracking-wider">
                                    ¿Quiénes somos?
                                </a>

                                {{-- VISTA DE ADMINISTRADOR --}}
                                @auth
                                    @if(Auth::user()->tipo == 2)
                                        <a href="{{ route('admin.solicitudes.index') }}"
                                           class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.solicitudes.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-bold leading-5 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out uppercase tracking-wider">
                                            <i class="fa-solid fa-inbox mr-2 text-indigo-500"></i> Solicitudes
                                        </a>

                                        {{-- Enlace de Excedentes para Admin --}}
                                        <a href="{{ route('admin.excedentes.informe') }}"
                                           class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.excedentes.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-bold leading-5 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out uppercase tracking-wider ml-4">
                                            <i class="fa-solid fa-coins mr-2 text-yellow-500"></i> Excedentes
                                        </a>

                                        {{-- NUEVO: Enlace de Importación para Admin --}}
                                       <a href="{{ route('admin.importar.index') }}"
                                           class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.importar.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-bold leading-5 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out uppercase tracking-wider ml-4">
                                            <i class="fa-solid fa-file-import mr-2 text-green-500"></i> Importar Data
                                        </a>
                                       <a href="{{ route('admin.importar.historial') }}" class="...">
                                            <i class="fa-solid fa-clock-rotate-left mr-2"></i>
                                            <span>Migrar Historial</span>
                                        </a>
                                    @endif
                                @endauth

                                {{-- VISTA DE SOCIO --}}
                                @auth
                                    @if(Auth::user()->tipo == 0)
                                        <div class="inline-flex items-center px-1 pt-1 relative" x-data="{ openServicios: false }">
                                            <button @click="openServicios = !openServicios" @click.away="openServicios = false" class="flex items-center gap-1 text-sm font-bold text-gray-500 hover:text-gray-700 uppercase tracking-wider transition">
                                                Servicios
                                                <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="openServicios ? 'rotate-180' : ''"></i>
                                            </button>

                                            <div x-show="openServicios"
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 scale-95"
                                                 x-transition:enter-end="opacity-100 scale-100"
                                                 style="display: none;"
                                                 class="absolute top-full left-0 w-56 bg-white rounded-2xl shadow-2xl py-2 mt-2 border border-gray-100 z-50">

                                                <a href="{{ route('socio.calculadora') }}" class="block px-6 py-3 text-xs font-black text-gray-700 hover:bg-indigo-50 uppercase tracking-widest transition">
                                                    <i class="fa-solid fa-calculator mr-2 text-indigo-500"></i> Calculadora
                                                </a>

                                                <a href="{{ route('socio.formularios') }}" class="block px-6 py-3 text-xs font-black text-gray-700 hover:bg-indigo-50 uppercase tracking-widest transition border-t border-gray-50">
                                                    <i class="fa-solid fa-file-signature mr-2 text-indigo-500"></i> Formularios
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            @auth
                                <div class="ml-3 relative" x-data="{ openUser: false }">
                                    <div>
                                        <button @click="openUser = ! openUser" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            <div class="font-black italic uppercase tracking-tighter">{{ Auth::user()->name }}</div>
                                            <div class="ml-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </div>

                                    <div x-show="openUser" @click.away="openUser = false" class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50 overflow-hidden" style="display: none;">
                                        <div class="px-4 py-2 text-[10px] font-black text-gray-400 border-b mb-1 uppercase tracking-widest italic">ID: {{ Auth::user()->cedula }}</div>

                                        @if(Auth::user()->tipo == 0)
                                            <a href="{{ route('socio.perfil') }}" class="block w-full text-left px-4 py-3 text-xs text-gray-700 hover:bg-indigo-50 font-black uppercase tracking-widest transition">
                                                <i class="fa-solid fa-user-gear mr-2 opacity-50"></i> Mi Perfil
                                            </a>
                                        @endif

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-3 text-xs text-red-600 hover:bg-red-50 font-black uppercase tracking-widest transition border-t border-gray-50">
                                                <i class="fa-solid fa-power-off mr-2 opacity-50"></i> Cerrar Sesión
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="text-xs font-black text-indigo-600 uppercase tracking-widest italic hover:underline">Acceso Socios →</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            @if (isset($header))
                <header class="bg-white shadow-sm border-b border-gray-100 no-print">
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
