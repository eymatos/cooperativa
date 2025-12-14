<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💰 Registrar Pago
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600">Socio: <span class="font-bold">{{ $prestamo->socio->nombres }} {{ $prestamo->socio->apellidos }}</span></p>
                        <p class="text-sm text-gray-600">Préstamo ID: #{{ $prestamo->id }}</p>
                        <p class="text-lg font-bold text-red-600 mt-2">Saldo Actual: RD$ {{ number_format($prestamo->saldo_capital, 2) }}</p>
                    </div>

                    <form action="{{ route('pagos.store', $prestamo) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Monto a Pagar (RD$):</label>
                            <input type="number" step="0.01" name="monto" class="w-full border-gray-300 rounded-md shadow-sm text-lg font-bold text-green-700" placeholder="0.00" required autofocus>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Fecha:</label>
                                <input type="date" name="fecha_pago" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Método:</label>
                                <select name="metodo" class="w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="efectivo">Efectivo</option>
                                    <option value="transferencia">Transferencia</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Referencia (Opcional):</label>
                            <input type="text" name="referencia" placeholder="Ej: Recibo #1234" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nota:</label>
                            <textarea name="nota" class="w-full border-gray-300 rounded-md shadow-sm" rows="2"></textarea>
                        </div>

                        <div class="flex justify-between items-center mt-6">
                            <a href="{{ route('prestamos.show', $prestamo) }}" class="text-gray-600 hover:text-gray-900">Cancelar</a>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow-lg transform transition hover:scale-105">
                                ✅ Procesar Pago
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
