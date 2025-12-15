<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💰 Mis Ahorros
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($cuentas->isEmpty())
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Aviso</p>
                    <p>Aún no tienes cuentas de ahorro activas o migradas.</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($cuentas as $cuenta)
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 {{ $cuenta->type->code == 'APO' ? 'border-green-500' : 'border-blue-500' }}">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-gray-700">{{ $cuenta->type->name }}</h3>
                                <span class="text-xs font-semibold px-2 py-1 rounded {{ $cuenta->type->allow_withdrawals ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $cuenta->type->allow_withdrawals ? 'Retirable' : 'Fijo' }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-500">Saldo Disponible</p>
                            <p class="text-3xl font-bold text-gray-900 mb-6">
                                RD$ {{ number_format($cuenta->balance, 2) }}
                            </p>

                            <div class="border-t pt-4 flex justify-between items-center">
                                <span class="text-xs text-gray-400">Código: {{ $cuenta->type->code }}</span>
                                <a href="{{ route('ahorros.show', $cuenta->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold">
                                    Ver Movimientos →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
