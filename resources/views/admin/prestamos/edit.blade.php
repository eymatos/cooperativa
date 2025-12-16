<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Préstamo #{{ $prestamo->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                ⚠️ <strong>Advertencia:</strong> Al editar este préstamo,
                                <span class="font-bold underline">se borrarán las cuotas actuales y se generará una nueva tabla de amortización</span>
                                basada en los nuevos valores.
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.prestamos.update', $prestamo->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="col-span-2">
                            <label class="block font-bold text-gray-700 mb-1">Socio</label>
                            <input type="text" value="{{ $prestamo->socio->nombres }} {{ $prestamo->socio->apellidos }}" disabled
                                   class="w-full bg-gray-200 border-gray-300 rounded cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Tipo de Préstamo</label>
                            <select name="tipo_prestamo_id" class="w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($tiposPrestamo as $tipo)
                                    <option value="{{ $tipo->id }}" {{ $prestamo->tipo_prestamo_id == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nombre }} ({{ $tipo->tasa_interes }}%)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" value="{{ substr($prestamo->fecha_inicio, 0, 10) }}"
                                   class="w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Monto (RD$)</label>
                            <input type="number" name="monto" step="0.01" value="{{ $prestamo->monto }}"
                                   class="w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Tasa de Interés Mensual (%)</label>
                            <input type="number" name="tasa_interes" step="0.01" value="{{ $prestamo->tasa_interes }}"
                                   class="w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Plazo (Meses)</label>
                            <input type="number" name="plazo" value="{{ $prestamo->plazo }}"
                                   class="w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
