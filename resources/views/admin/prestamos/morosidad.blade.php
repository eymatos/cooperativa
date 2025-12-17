<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reporte de Morosidad (Cuotas Vencidas)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($cuotasVencidas->isEmpty())
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-md">
                    ¡Excelente! No hay cuotas vencidas pendientes de pago en este momento.
                </div>
            @else
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-red-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase">Socio</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase">No. Préstamo</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-red-700 uppercase">Fecha Vencida</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-red-700 uppercase">Capital</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-red-700 uppercase">Interés</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-red-700 uppercase">Total Cuota</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-red-700 uppercase">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cuotasVencidas as $cuota)
                                @php
                                    $diasAtraso = now()->diffInDays($cuota->fecha_vencimiento);
                                @endphp
                                <tr class="hover:bg-red-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $cuota->prestamo->socio->user->name }}</div>
                                        <div class="text-xs text-red-600 font-semibold">{{ $diasAtraso }} días de atraso</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $cuota->prestamo->numero_prestamo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        {{ number_format($cuota->capital, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        {{ number_format($cuota->interes, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-black text-red-700">
                                        RD$ {{ number_format($cuota->total_cuota, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('admin.prestamos.show', $cuota->prestamo->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase underline">
                                            Ir a Cobrar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
