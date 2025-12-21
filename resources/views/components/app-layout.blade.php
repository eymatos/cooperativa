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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

        <style>
            body { font-family: 'Figtree', sans-serif; }
            [x-cloak] { display: none !important; }
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

            {{-- NAV PRINCIPAL --}}
            <nav x-data="{ open: false }" class="bg-white border-b border-gray-100 no-print">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            {{-- LOGO --}}
                            <div class="shrink-0 flex items-center">
                                <a href="{{ Auth::check() ? (Auth::user()->tipo == 2 ? route('admin.dashboard') : route('socio.dashboard')) : route('login') }}" class="flex items-center">
                                    <img src="{{ asset('assets/img/logo-coop.png') }}" alt="Logo COOPROCON" class="h-12 w-auto transition-transform hover:scale-105">
                                </a>
                            </div>

                            {{-- MENÚ ESCRITORIO (DESKTOP) --}}
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                @auth
                                    <a href="{{ Auth::user()->tipo == 2 ? route('admin.dashboard') : route('socio.dashboard') }}"
                                       class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('*.dashboard') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-bold leading-5 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out uppercase tracking-wider">
                                        Inicio
                                    </a>
                                @endauth

                                <a href="{{ route('quienes-somos') }}"
                                   class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('quienes-somos') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-bold leading-5 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out uppercase tracking-wider">
                                    ¿Quiénes somos?
                                </a>

                                @auth
                                    @if(Auth::user()->tipo == 2)
                                        {{-- OPCIONES ADMIN --}}
                                        <a href="{{ route('admin.solicitudes.index') }}"
                                           class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.solicitudes.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-bold uppercase tracking-wider">
                                            Solicitudes
                                        </a>

                                        <a href="{{ route('admin.excedentes.informe') }}"
                                           class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.excedentes.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-bold uppercase tracking-wider">
                                            Excedentes
                                        </a>

                                        <a href="{{ route('admin.importar.index') }}"
                                            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.importar.index') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-bold uppercase tracking-wider">
                                             Importar
                                        </a>

                                        {{-- DROPDOWN MIGRACIÓN DESKTOP --}}
                                        <div class="inline-flex items-center px-1 pt-1 relative" x-data="{ openMigrar: false }">
                                            <button @click="openMigrar = !openMigrar" @click.away="openMigrar = false"
                                                class="flex items-center gap-1 text-sm font-bold {{ request()->routeIs('admin.importar.historial') || request()->routeIs('admin.importar.prestamos') ? 'text-indigo-600' : 'text-gray-500' }} hover:text-gray-700 uppercase tracking-wider transition">
                                                Migración <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="openMigrar ? 'rotate-180' : ''"></i>
                                            </button>
                                            <div x-show="openMigrar" x-cloak class="absolute top-full left-0 w-64 bg-white rounded-2xl shadow-2xl py-2 mt-2 border border-gray-100 z-50">
                                                <a href="{{ route('admin.importar.historial') }}" class="block px-6 py-3 text-xs font-black text-gray-700 hover:bg-indigo-50 uppercase tracking-widest transition">Migrar Ahorros</a>
                                                <a href="{{ route('admin.importar.prestamos') }}" class="block px-6 py-3 text-xs font-black text-gray-700 hover:bg-teal-50 uppercase tracking-widest transition border-t border-gray-50">Migrar Préstamos</a>
                                            </div>
                                        </div>
                                    @endif

                                    @if(Auth::user()->tipo == 0)
                                        {{-- DROPDOWN SERVICIOS SOCIO DESKTOP --}}
                                        <div class="inline-flex items-center px-1 pt-1 relative" x-data="{ openServicios: false }">
                                            <button @click="openServicios = !openServicios" @click.away="openServicios = false" class="flex items-center gap-1 text-sm font-bold text-gray-500 hover:text-gray-700 uppercase tracking-wider transition">
                                                Servicios <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="openServicios ? 'rotate-180' : ''"></i>
                                            </button>
                                            <div x-show="openServicios" x-cloak class="absolute top-full left-0 w-56 bg-white rounded-2xl shadow-2xl py-2 mt-2 border border-gray-100 z-50">
                                                <a href="{{ route('socio.calculadora') }}" class="block px-6 py-3 text-xs font-black text-gray-700 hover:bg-indigo-50 uppercase tracking-widest transition">Calculadora</a>
                                                <a href="{{ route('socio.formularios') }}" class="block px-6 py-3 text-xs font-black text-gray-700 hover:bg-indigo-50 uppercase tracking-widest transition border-t border-gray-50">Formularios</a>
                                            </div>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>

                        {{-- USER DROPDOWN DESKTOP --}}
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            @auth
                                <div class="ml-3 relative" x-data="{ openUser: false }">
                                    <button @click="openUser = ! openUser" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-bold rounded-md text-gray-500 bg-white hover:text-gray-700 transition">
                                        <div class="font-black italic uppercase tracking-tighter">{{ Auth::user()->name }}</div>
                                        <div class="ml-1"><i class="fa-solid fa-chevron-down text-[10px]"></i></div>
                                    </button>

                                    <div x-show="openUser" @click.away="openUser = false" x-cloak class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50 overflow-hidden">
                                        <div class="px-4 py-2 text-[10px] font-black text-gray-400 border-b mb-1 uppercase tracking-widest italic">ID: {{ Auth::user()->cedula }}</div>
                                        @if(Auth::user()->tipo == 0)
                                            <a href="{{ route('socio.perfil') }}" class="block w-full text-left px-4 py-3 text-xs text-gray-700 hover:bg-indigo-50 font-black uppercase tracking-widest transition">Mi Perfil</a>
                                        @endif
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-3 text-xs text-red-600 hover:bg-red-50 font-black uppercase tracking-widest transition border-t border-gray-50">Cerrar Sesión</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="text-xs font-black text-indigo-600 uppercase tracking-widest italic hover:underline">Acceso Socios →</a>
                            @endauth
                        </div>

                        {{-- BOTÓN HAMBURGUESA MÓVIL (VISIBLE SOLO EN MÓVIL) --}}
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- MENÚ DESPLEGABLE MÓVIL (RESPONSIVE) --}}
                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100 overflow-hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        @auth
                            <a href="{{ Auth::user()->tipo == 2 ? route('admin.dashboard') : route('socio.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('*.dashboard') ? 'border-indigo-500 text-indigo-700 bg-indigo-50' : 'border-transparent text-gray-600' }} text-base font-black uppercase">Inicio</a>
                        @endauth

                        <a href="{{ route('quienes-somos') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('quienes-somos') ? 'border-indigo-500 text-indigo-700 bg-indigo-50' : 'border-transparent text-gray-600' }} text-base font-black uppercase">¿Quiénes somos?</a>

                        @auth
                            @if(Auth::user()->tipo == 2)
                                <a href="{{ route('admin.solicitudes.index') }}" class="block pl-3 pr-4 py-2 text-base font-bold text-gray-600 uppercase">Solicitudes</a>
                                <a href="{{ route('admin.excedentes.informe') }}" class="block pl-3 pr-4 py-2 text-base font-bold text-gray-600 uppercase">Excedentes</a>
                                <a href="{{ route('admin.importar.index') }}" class="block pl-3 pr-4 py-2 text-base font-bold text-gray-600 uppercase">Importar Socios</a>
                                <a href="{{ route('admin.importar.historial') }}" class="block pl-3 pr-4 py-2 text-base font-bold text-gray-600 uppercase border-t border-gray-50">Migrar Ahorros</a>
                                <a href="{{ route('admin.importar.prestamos') }}" class="block pl-3 pr-4 py-2 text-base font-bold text-gray-600 uppercase">Migrar Préstamos</a>
                            @endif

                            @if(Auth::user()->tipo == 0)
                                <a href="{{ route('socio.calculadora') }}" class="block pl-3 pr-4 py-2 text-base font-bold text-gray-600 uppercase">Calculadora</a>
                                <a href="{{ route('socio.formularios') }}" class="block pl-3 pr-4 py-2 text-base font-bold text-gray-600 uppercase">Formularios</a>
                                <a href="{{ route('socio.perfil') }}" class="block pl-3 pr-4 py-2 text-base font-bold text-gray-600 uppercase border-t border-gray-50">Mi Perfil</a>
                            @endif
                        @endauth
                    </div>

                    {{-- PERFIL Y CIERRE SESIÓN MÓVIL --}}
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        @auth
                            <div class="px-4">
                                <div class="font-black text-base text-gray-800 uppercase italic">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500 italic">Cédula: {{ Auth::user()->cedula }}</div>
                            </div>
                            <div class="mt-3 space-y-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 text-base font-black text-red-600 uppercase">Cerrar Sesión</button>
                                </form>
                            </div>
                        @else
                            <div class="px-4 py-2">
                                <a href="{{ route('login') }}" class="block w-full text-center py-3 bg-indigo-600 text-white font-black uppercase rounded-xl">Acceso Socios</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </nav>

            {{-- HEADER --}}
            @if (isset($header))
                <header class="bg-white shadow-sm border-b border-gray-100 no-print">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- CONTENIDO --}}
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
