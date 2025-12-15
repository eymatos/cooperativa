<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historial de {{ $cuenta->type->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Balance Actual</p>
                        <p class="text-4xl font-bold {{ $cuenta->type->code == 'APO' ? 'text-green-600' : 'text-blue-600' }}">
                            RD$ {{ number_format($cuenta->balance, 2) }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('ahorros.index') }}" class="text-gray-500 hover:text-gray-700">
                            ← Volver a mis cuentas
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-4">Últimos Movimientos</h3>

                    @if($cuenta->transactions->isEmpty())
                        <p class="text-gray-500 text-center py-4">No hay movimientos registrados en esta cuenta.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3">Fecha</th>
                                        <th class="px-6 py-3">Descripción</th>
                                        <th class="px-6 py-3">Tipo</th>
                                        <th class="px-6 py-3 text-right">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cuenta->transactions as $tx)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $tx->description ?? 'Sin detalle' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($tx->type == 'deposit')
                                                <span class="text-green-600 font-bold">Depósito</span>
                                            @elseif($tx->type == 'withdrawal')
                                                <span class="text-red-600 font-bold">Retiro</span>
                                            @else
                                                <span class="text-blue-600 font-bold">Interés</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold {{ $tx->type == 'withdrawal' ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $tx->type == 'withdrawal' ? '-' : '+' }} RD$ {{ number_format($tx->amount, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
