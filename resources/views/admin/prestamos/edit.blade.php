<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Préstamo #{{ $prestamo->numero_prestamo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <p class="text-sm text-yellow-700">
                        ⚠️ <strong>Advertencia:</strong> Al editar este préstamo, se borrarán las cuotas actuales y se generará una nueva tabla de amortización.
                    </p>
                </div>

                <form action="{{ route('admin.prestamos.update', $prestamo->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="col-span-2">
                            <label class="block font-bold text-gray-700 mb-1">Socio</label>
                            <input type="text" value="{{ $prestamo->socio->user->name }}" disabled
                                   class="w-full bg-gray-200 border-gray-300 rounded cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Tipo de Préstamo</label>
                            <select name="tipo_prestamo_id" class="w-full border-gray-300 rounded shadow-sm">
                                @foreach($tiposPrestamo as $tipo)
                                    <option value="{{ $tipo->id }}" {{ $prestamo->tipo_prestamo_id == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nombre }} ({{ $tipo->tasa_interes }}%)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Fecha de Inicio (Desembolso)</label>
                            <input type="date" name="fecha_inicio" value="{{ substr($prestamo->fecha_inicio, 0, 10) }}"
                                   class="w-full border-gray-300 rounded shadow-sm">
                        </div>

                        <div class="bg-blue-50 p-2 rounded-md border border-blue-100">
                            <label class="block font-bold text-sm text-blue-700 mb-1">Fecha del Primer Pago</label>
                            <input type="date" name="fecha_primer_pago"
                                   value="{{ $prestamo->fecha_primer_pago ? substr($prestamo->fecha_primer_pago, 0, 10) : '' }}"
                                   class="w-full border-blue-300 focus:border-blue-500 rounded-md shadow-sm">
                            <p class="text-[10px] text-blue-500 mt-1">Cambie esto para mover el calendario de cobro.</p>
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Monto (RD$)</label>
                            <input type="number" name="monto" step="0.01" value="{{ $prestamo->monto }}"
                                   class="w-full border-gray-300 rounded shadow-sm">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Tasa de Interés ANUAL (%)</label>
                            <input type="number" name="tasa_interes" step="0.01" value="{{ $prestamo->tasa_interes }}"
                                   class="w-full border-gray-300 rounded shadow-sm">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Plazo (Meses)</label>
                            <input type="number" name="plazo" value="{{ $prestamo->plazo }}"
                                   class="w-full border-gray-300 rounded shadow-sm">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('admin.socios.show', $prestamo->socio_id) }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-bold rounded hover:bg-blue-700">
                            Actualizar y Recalcular
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
