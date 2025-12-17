<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">💰 Resumen de Cobro Próxima Nómina</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-green-500">
                <h3 class="text-center text-gray-500 uppercase tracking-widest font-bold">Proyección para {{ $mes }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <div class="p-4 bg-blue-50 rounded-lg text-center">
                        <span class="block text-blue-600 text-sm font-bold uppercase">Total Ahorros</span>
                        <span class="text-2xl font-black text-blue-800 font-mono">RD$ {{ number_format($ahorros, 2) }}</span>
                    </div>

                    <div class="p-4 bg-orange-50 rounded-lg text-center">
                        <span class="block text-orange-600 text-sm font-bold uppercase">Total Préstamos</span>
                        <span class="text-2xl font-black text-orange-800 font-mono">RD$ {{ number_format($prestamos, 2) }}</span>
                    </div>
                </div>

                <div class="mt-10 p-6 bg-green-600 rounded-2xl text-center shadow-xl">
                    <span class="block text-white text-lg font-bold uppercase opacity-80">Total General a Descontar</span>
                    <span class="text-4xl font-black text-white font-mono italic">RD$ {{ number_format($total, 2) }}</span>
                </div>

                <p class="mt-6 text-center text-xs text-gray-400 italic">
                    * Este monto puede variar si se registran nuevos préstamos o cambios de ahorros antes del cierre.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
