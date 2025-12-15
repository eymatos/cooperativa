<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Pago') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-6 bg-blue-50 p-4 rounded border border-blue-200">
                        <h3 class="font-bold text-lg text-blue-800">Préstamo #{{ $prestamo->id }}</h3>
                        <p class="text-blue-600">Socio: {{ $prestamo->socio->nombres }} {{ $prestamo->socio->apellidos }}</p>

                        @if($siguienteCuota)
                            <div class="mt-2 pt-2 border-t border-blue-200">
                                <p class="text-sm font-bold">Siguiente Cuota a Pagar (#{{ $siguienteCuota->numero_cuota }})</p>
                                <p>Vence: {{ \Carbon\Carbon::parse($siguienteCuota->fecha_vencimiento)->format('d/m/Y') }}</p>
                                <p class="text-xl font-bold text-green-700">Monto: RD$ {{ number_format($siguienteCuota->monto_total, 2) }}</p>
                            </div>
                        @else
                            <p class="text-green-600 font-bold mt-2">¡Este préstamo está al día o pagado!</p>
                        @endif
                    </div>

                    <form action="{{ route('admin.pagos.store', $prestamo->id) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block font-bold mb-1">Fecha del Pago</label>
                            <input type="date" name="fecha_pago" value="{{ date('Y-m-d') }}"
                                   class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="mb-6">
                            <label class="block font-bold mb-1">Monto a Pagar (RD$)</label>
                            <input type="number" name="monto" step="0.01"
                                   value="{{ $siguienteCuota ? $siguienteCuota->monto_total : '' }}"
                                   class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-lg font-bold">
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin.prestamos.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-gray-800">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-green-600 rounded hover:bg-green-700 text-white font-bold">
                                💵 Confirmar Pago
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
