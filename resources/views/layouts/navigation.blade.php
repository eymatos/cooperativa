<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>

    <x-nav-link :href="route('prestamos.index')" :active="request()->routeIs('prestamos.*')">
        {{ __('Préstamos') }}
    </x-nav-link>

    </div>
<div class="pt-2 pb-3 space-y-1">
    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('prestamos.index')" :active="request()->routeIs('prestamos.*')">
        {{ __('Préstamos') }}
    </x-responsive-nav-link>
</div>
