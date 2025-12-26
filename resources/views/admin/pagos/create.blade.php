<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Pago o Abono') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b border-gray-200">
                <div class="p-6">

                    <div class="mb-6 bg-indigo-50 p-4 rounded-lg border border-indigo-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg text-indigo-800">Préstamo #{{ $prestamo->id }}</h3>
                                <p class="text-indigo-600">Socio: {{ $prestamo->socio->user->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 uppercase font-bold">Saldo Capital</p>
                                <p class="text-xl font-black text-indigo-700">RD$ {{ number_format($prestamo->saldo_capital, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.pagos.store', $prestamo->id) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Fecha del Movimiento</label>
                            <input type="date" name="fecha_pago" value="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Monto (RD$)</label>
                            <input type="number" name="monto" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-lg font-bold" required>
                        </div>

                        <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-3 text-center uppercase">Tipo de Aplicación</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer border bg-white p-3 rounded-lg flex flex-col items-center">
                                    <input type="radio" name="tipo_pago" value="cascada" checked onclick="toggleOpciones(false)">
                                    <span class="text-sm font-medium mt-1">Pago Normal</span>
                                </label>
                                <label class="cursor-pointer border bg-white p-3 rounded-lg flex flex-col items-center">
                                    <input type="radio" name="tipo_pago" value="capital" onclick="toggleOpciones(true)">
                                    <span class="text-sm font-bold text-green-700 mt-1">Abono a Capital</span>
                                </label>
                            </div>
                        </div>

                        <div id="section_reestructuracion" class="hidden mb-6 p-4 bg-green-50 rounded-lg border border-green-200">
                            <span class="block font-bold text-green-800 mb-2">Preferencia del Socio:</span>
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="radio" name="opcion_capital" value="cuota" checked>
                                    <span class="ml-2 text-sm text-green-700">Reducir Cuota (Mismo Plazo)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="opcion_capital" value="plazo">
                                    <span class="ml-2 text-sm text-green-700">Reducir Plazo (Misma Cuota)</span>
                                </label>
                            </div>
                            <div class="mt-4 p-2 bg-blue-50 border-l-4 border-blue-400 text-[11px] text-blue-800">
                                <strong>Info:</strong> La tabla se recalculará. El interés de las cuotas bajará proporcionalmente al nuevo capital.
                            </div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.prestamos.show', $prestamo->id) }}" class="px-4 py-2 bg-gray-100 rounded-md text-xs uppercase tracking-widest">Cancelar</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md font-bold text-xs uppercase tracking-widest">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleOpciones(show) {
            document.getElementById('section_reestructuracion').classList.toggle('hidden', !show);
        }
    </script>
</x-app-layout>
