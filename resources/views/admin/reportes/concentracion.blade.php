<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">📊 Distribución de Cartera (Riesgo)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-1 bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-sm font-bold text-gray-500 uppercase mb-4">Composición por Tipo</h3>
                    <div style="height: 300px;">
                        <canvas id="chartConcentracion"></canvas>
                    </div>
                </div>

                <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-sm font-bold text-gray-500 uppercase mb-4">Desglose de Capital en Calle</h3>
                    <table class="min-w-full text-sm">
                        <thead class="border-b">
                            <tr class="text-left text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="pb-3">Tipo de Préstamo</th>
                                <th class="pb-3 text-right">Saldo Total</th>
                                <th class="pb-3 text-right">% de Cartera</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @php $totalGlobal = $valores->sum(); @endphp
                            @foreach($datosCartera as $dato)
                            <tr>
                                <td class="py-4 font-bold text-gray-700">{{ $dato->tipo }}</td>
                                <td class="py-4 text-right font-mono">RD$ {{ number_format($dato->total, 2) }}</td>
                                <td class="py-4 text-right font-bold text-indigo-600">
                                    {{ number_format(($dato->total / ($totalGlobal > 0 ? $totalGlobal : 1)) * 100, 1) }}%
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr class="font-black">
                                <td class="py-3 px-2 uppercase text-xs">Total Cartera Activa</td>
                                <td class="py-3 text-right">RD$ {{ number_format($totalGlobal, 2) }}</td>
                                <td class="py-3 text-right">100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('chartConcentracion').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        data: @json($valores),
                        backgroundColor: ['#4F46E5', '#EF4444', '#10B981', '#F59E0B', '#6366F1', '#EC4899'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        });
    </script>
</x-app-layout>
