<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->tipo == 2 ? route('admin.dashboard') : route('socio.dashboard') }}">

                        <span class="font-bold text-xl text-green-600">COOPROCON</span>

                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    <x-responsive-nav-link :href="Auth::user()->tipo == 2 ? route('admin.dashboard') : route('socio.dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    <x-nav-link :href="route('ahorros.index')" :active="request()->routeIs('ahorros.index')">
                        {{ __('Mis Ahorros') }}
                    </x-nav-link>

                    @if(Auth::user()->tipo == 2)

                        <x-nav-link :href="route('admin.prestamos.index')" :active="request()->routeIs('admin.prestamos.*')">
                            {{ __('Gestionar Préstamos') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.socios.index')" :active="request()->routeIs('admin.socios.*')">
                            {{ __('👥 Socios') }}
                        </x-nav-link>

                    @else
                        <x-nav-link :href="route('prestamos.mis_prestamos')" :active="request()->routeIs('prestamos.mis_prestamos')">
                            {{ __('Mis Préstamos') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-900 underline">
                        {{ __('Cerrar Sesión') }}
                    </button>
                </form>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('ahorros.index')" :active="request()->routeIs('ahorros.index')">
                {{ __('Mis Ahorros') }}
            </x-responsive-nav-link>

            @if(Auth::user()->tipo == 2)

                <x-responsive-nav-link :href="route('admin.prestamos.index')" :active="request()->routeIs('admin.prestamos.*')">
                    {{ __('Gestionar Préstamos') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.socios.index')" :active="request()->routeIs('admin.socios.*')">
                    {{ __('👥 Socios') }}
                </x-responsive-nav-link>

            @else
                <x-responsive-nav-link :href="route('prestamos.mis_prestamos')" :active="request()->routeIs('prestamos.mis_prestamos')">
                    {{ __('Mis Préstamos') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
