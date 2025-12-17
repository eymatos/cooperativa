<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight italic">
            🏦 Reporte de Pasivos: Fondos de Socios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border-b-4 border-blue-600">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Deuda Total con Socios (Pasivos)</p>
                <h3 class="text-4xl font-black text-gray-900">RD$ {{ number_format($totalGeneralAhorros, 2) }}</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="font-bold text-gray-700 mb-4 uppercase text-sm">Distribución por Tipo de Fondo</h3>
                    <ul class="divide-y">
                        @foreach($distribucionAhorros as $ahorro)
                        <li class="py-3 flex justify-between items-center">
                            <span class="text-gray-600 font-medium">{{ $ahorro->tipo }}</span>
                            <span class="font-bold text-blue-600">RD$ {{ number_format($ahorro->total, 2) }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="font-bold text-gray-700 mb-4 uppercase text-sm">Top 10 Socios (Mayor Saldo)</h3>
                    <table class="min-w-full text-xs">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="pb-2">Socio</th>
                                <th class="pb-2 text-right">Balance Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topAhorrantes as $s)
                            <tr class="border-b last:border-0 hover:bg-gray-50">
                                <td class="py-2 text-gray-700">{{ $s->user->name }}</td>
                                <td class="py-2 text-right font-bold text-green-700">RD$ {{ number_format($s->cuentas_sum_balance, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
