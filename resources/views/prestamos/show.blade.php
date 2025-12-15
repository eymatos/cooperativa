<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle del Préstamo') }} #{{ $prestamo->id }}
            </h2>

            {{-- EL BOTÓN DE PAGAR SOLO LO VE EL ADMIN (TIPO 1) --}}
            @if(Auth::user()->tipo == 1 && $prestamo->estado != 'pagado')
                <a href="{{ route('admin.pagos.create', $prestamo) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                    💰 Registrar Pago
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
                    <div>
                        <p class="text-gray-500 text-xs">Socio</p>
                        <p class="font-bold text-lg">{{ $prestamo->socio->nombres }} {{ $prestamo->socio->apellidos }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Monto Prestado</p>
                        <p class="font-bold text-lg text-blue-600">RD$ {{ number_format($prestamo->monto, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Saldo Actual</p>
                        <p class="font-bold text-lg text-red-600">RD$ {{ number_format($prestamo->saldo_capital, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Progreso</p>
                        <p class="font-bold">{{ $prestamo->cuotas->where('estado', 'pagada')->count() }} / {{ $prestamo->plazo }} Cuotas</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-4">Tabla de Amortización</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">#</th>
                                    <th class="px-6 py-3">Vencimiento</th>
                                    <th class="px-6 py-3">Cuota Total</th>
                                    <th class="px-6 py-3">Capital</th>
                                    <th class="px-6 py-3">Interés</th>
                                    <th class="px-6 py-3">Pagado</th>
                                    <th class="px-6 py-3">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prestamo->cuotas as $cuota)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $cuota->numero_cuota }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 font-bold">RD$ {{ number_format($cuota->monto_total, 2) }}</td>
                                    <td class="px-6 py-4 text-gray-400">RD$ {{ number_format($cuota->capital, 2) }}</td>
                                    <td class="px-6 py-4 text-gray-400">RD$ {{ number_format($cuota->interes, 2) }}</td>
                                    <td class="px-6 py-4">RD$ {{ number_format($cuota->pagado, 2) }}</td>
                                    <td class="px-6 py-4">
                                        @if($cuota->estado == 'pendiente')
                                            <span class="text-red-500 font-bold">Pendiente</span>
                                        @elseif($cuota->estado == 'pagada')
                                            <span class="text-green-500 font-bold">Pagada</span>
                                        @else
                                            <span class="text-yellow-500 font-bold">Parcial</span>
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
