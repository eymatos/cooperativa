<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle del Préstamo: ') . $prestamo->numero_prestamo }}
            </h2>
            <a href="{{ route('admin.socios.show', $prestamo->socio->id) }}" class="text-gray-600 hover:text-gray-900 font-bold">
                &larr; Volver al Perfil del Socio
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <h3 class="text-lg font-bold text-gray-700">Datos del Socio</h3>
                            <p class="text-gray-600">Nombre: <span class="font-bold">{{ $prestamo->socio->nombres }} {{ $prestamo->socio->apellidos }}</span></p>
                            <p class="text-gray-600">Cédula: {{ $prestamo->socio->user->cedula ?? 'N/A' }}</p>
                        </div>

                        <div class="text-right">
                            <h3 class="text-lg font-bold text-gray-700">Resumen Financiero</h3>

                            <div class="mb-2">
                                <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-2.5 py-0.5 rounded border border-indigo-400 uppercase">
                                    {{ $prestamo->tipoPrestamo->nombre ?? 'Préstamo Normal' }}
                                </span>
                            </div>

                            <p class="text-2xl font-bold text-green-600">RD$ {{ number_format($prestamo->monto, 2) }}</p>
                            <p class="text-sm text-gray-500">Tasa: {{ $prestamo->tasa_interes }}% | Plazo: {{ $prestamo->plazo }} meses</p>
                            <p class="text-sm font-bold text-blue-600 mt-2">Capital Pendiente: RD$ {{ number_format($prestamo->saldo_capital, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-bold text-lg mb-4">Tabla de Amortización Oficial</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vencimiento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cuota Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Abonado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Interés</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Capital</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Saldo Restante</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($prestamo->cuotas as $cuota)
                                <tr class="{{ $cuota->estado == 'pagado' ? 'bg-green-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cuota->numero_cuota }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">RD$ {{ number_format($cuota->monto_total, 2) }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">
                                        @if($cuota->abonado > 0)
                                            RD$ {{ number_format($cuota->abonado, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">{{ number_format($cuota->interes, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ number_format($cuota->capital, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($cuota->saldo_restante, 2) }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($cuota->estado == 'pagado')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Pagado
                                            </span>
                                        @elseif($cuota->abonado > 0)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Parcial
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
