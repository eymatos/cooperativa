<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmar Liquidación de Préstamo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-amber-500">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">Resumen de Pago para Saldo Total</h3>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="text-gray-600">Socio:</div>
                            <div class="font-bold text-right">{{ $prestamo->socio->user->name }}</div>

                            <div class="text-gray-600">Préstamo:</div>
                            <div class="font-bold text-right">{{ $prestamo->numero_prestamo }}</div>

                            <div class="border-t border-gray-200 col-span-2 my-2"></div>

                            <div class="text-gray-600">Capital Pendiente (Total):</div>
                            <div class="font-bold text-right text-gray-900 text-lg">RD$ {{ number_format($datosLiquidacion['capital_pendiente'], 2) }}</div>

                            <div class="text-gray-500 italic">Intereses (Vigentes y Futuros):</div>
                            <div class="font-bold text-right text-green-600">RD$ 0.00 (Anulados)</div>

                            <div class="border-t-2 border-gray-300 col-span-2 my-2"></div>

                            <div class="text-lg font-bold text-gray-800">Monto Total a Pagar:</div>
                            <div class="text-2xl font-black text-right text-indigo-700">RD$ {{ number_format($datosLiquidacion['total_a_pagar'], 2) }}</div>
                        </div>
                    </div>

                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6">
                        <div class="flex">
                            <div class="shrink-0">
                                <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-amber-700">
                                    Al procesar esta liquidación, se marcarán las <strong>{{ $datosLiquidacion['cuotas_count'] }} cuotas</strong> restantes como pagadas. Según la política de saldo anticipado, el socio solo paga el capital adeudado y se ahorra el 100% de los intereses restantes.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.prestamos.show', $prestamo->id) }}" class="text-sm text-gray-600 hover:underline">
                            Cancelar y volver
                        </a>

                        <form action="{{ route('admin.prestamos.liquidar.procesar', $prestamo->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150">
                                Procesar Liquidación Total
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
