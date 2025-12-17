<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">💰 Reporte de Utilidades e Intereses</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow border-b-4 border-green-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Intereses Cobrados (Este Mes)</p>
                    <h3 class="text-3xl font-black text-green-600">RD$ {{ number_format($interesesMesActual, 2) }}</h3>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-b-4 border-blue-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Intereses Cobrados (Mes Pasado)</p>
                    <h3 class="text-3xl font-black text-blue-600">RD$ {{ number_format($interesesMesPasado, 2) }}</h3>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold mb-4 text-gray-700 uppercase text-sm italic">Desglose de últimos intereses percibidos</h3>
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="text-left text-gray-400 uppercase text-[10px] tracking-widest">
                            <th class="pb-3">Fecha Pago</th>
                            <th class="pb-3">Socio</th>
                            <th class="pb-3 text-right">Interés Percibido</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                         @foreach($ultimosPagos as $pago)
                        <tr>
                            <td class="py-3 text-gray-500">
                                {{-- Cambiamos fecha_pago por updated_at --}}
                                {{ $pago->updated_at->format('d/m/Y') }}
                            </td>
                            <td class="py-3 font-bold">{{ $pago->prestamo->socio->user->name }}</td>
                            <td class="py-3 text-right font-bold text-green-600">RD$ {{ number_format($pago->interes, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
