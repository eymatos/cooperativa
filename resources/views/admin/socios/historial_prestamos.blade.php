<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Historial de Préstamos Saldados: {{ $socio->nombres }} {{ $socio->apellidos }}
            </h2>
            <a href="{{ route('admin.socios.show', $socio->id) }}" class="text-gray-600 hover:text-gray-900 font-bold text-sm">
                &larr; Volver al Perfil
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                @if($prestamosPagados->isEmpty())
                    <div class="text-center py-8 bg-gray-50 rounded border border-gray-200">
                        <p class="text-gray-500 italic text-lg">Este socio no tiene préstamos pagados en el historial.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase">Tipo de Préstamo</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase">Monto Inicial</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase">Fecha Inicio</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase">Plazo</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($prestamosPagados as $prestamo)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-500">
                                        <span class="font-bold text-gray-700">#{{ $prestamo->numero_prestamo ?? $prestamo->id }}</span>
                                    </td>
                                    <td class="px-4 py-3">{{ $prestamo->tipoPrestamo->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-800">RD$ {{ number_format($prestamo->monto, 2) }}</td>
                                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">{{ $prestamo->plazo }} Meses</td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.prestamos.show', $prestamo->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-xs border border-blue-200 px-2 py-1 rounded">Ver Detalles</a>
                                        </div>
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
</x-app-layout>
