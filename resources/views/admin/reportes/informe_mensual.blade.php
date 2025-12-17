<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto bg-white p-10 shadow-lg rounded-sm border border-gray-200" id="printable">

            <div class="flex justify-between items-center border-b-2 border-gray-800 pb-4 mb-8">
                <div>
                    <h1 class="text-2xl font-black uppercase text-gray-800">COOPROCON</h1>
                    <p class="text-sm text-gray-600">Informe de Gestión Mensual</p>
                </div>
                <div class="text-right">
                    <p class="font-bold">Período: {{ $inicioMes->translatedFormat('F Y') }}</p>
                    <p class="text-xs text-gray-500">Generado el: {{ now()->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mb-10">
                <div class="border p-4 rounded">
                    <h3 class="font-bold text-indigo-700 uppercase text-xs mb-3">Crecimiento de Socios</h3>
                    <div class="flex justify-between border-b py-2">
                        <span class="text-sm">Nuevos Socios Registrados</span>
                        <span class="font-bold text-lg text-indigo-600">{{ $totalNuevosSocios }}</span>
                    </div>
                </div>

                <div class="border p-4 rounded bg-gray-50">
                    <h3 class="font-bold text-green-700 uppercase text-xs mb-3">Colocación de Créditos</h3>
                    <p class="text-2xl font-black">RD$ {{ number_format($totalDesembolsado, 2) }}</p>
                    <p class="text-[10px] text-gray-500 mt-1 uppercase">Monto total desembolsado en el período</p>
                </div>
            </div>

            <h3 class="font-bold text-gray-800 uppercase text-xs mb-3">Resumen de Recaudación (Caja)</h3>
            <table class="w-full border-collapse border border-gray-300 text-sm mb-10">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 p-2 text-left">Concepto</th>
                        <th class="border border-gray-300 p-2 text-right">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 p-2">Recuperación de Capital</td>
                        <td class="border border-gray-300 p-2 text-right text-gray-700 font-medium">RD$ {{ number_format($recaudacion->capital ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-2 italic text-gray-600">Intereses Percibidos (Ganancia)</td>
                        <td class="border border-gray-300 p-2 text-right text-green-600 font-black">RD$ {{ number_format($recaudacion->interes ?? 0, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot class="bg-gray-800 text-white font-bold">
                    <tr>
                        <td class="p-2">TOTAL RECAUDADO EN EL MES</td>
                        <td class="p-2 text-right">RD$ {{ number_format(($recaudacion->capital ?? 0) + ($recaudacion->interes ?? 0), 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-20 grid grid-cols-2 gap-20 text-center">
                <div class="border-t border-gray-400 pt-2">
                    <p class="text-xs font-bold uppercase">Preparado por</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->name }}</p>
                </div>
                <div class="border-t border-gray-400 pt-2">
                    <p class="text-xs font-bold uppercase">Recibido por (Directiva)</p>
                </div>
            </div>

            <div class="mt-10 text-center print:hidden">
                <button onclick="window.print()" class="bg-indigo-600 text-white px-8 py-2 rounded-full font-bold shadow-md hover:bg-indigo-700 transition">
                    🖨️ Descargar / Imprimir Informe
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
