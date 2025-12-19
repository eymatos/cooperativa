<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center no-print">
            <h2 class="font-black text-xl text-gray-800 uppercase italic tracking-tighter">
                📊 Estado de Excedentes y Distribución {{ $anio }}
            </h2>
            <div class="flex gap-3">
                {{-- ENLACE CORREGIDO --}}
                <a href="{{ route('admin.excedentes.gastos.index') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-xl text-[10px] font-black uppercase italic shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Registrar Gastos
                </a>
                <button onclick="window.print()" class="bg-gray-900 text-white px-6 py-2 rounded-xl text-[10px] font-black uppercase italic shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-print"></i> Imprimir Informe
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-4 max-w-7xl mx-auto space-y-8">

        {{-- FILTRO POR AÑO --}}
        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-100 no-print flex justify-center">
            <form action="{{ route('admin.excedentes.informe') }}" method="GET" class="inline-flex items-center gap-4">
                <input type="number" name="anio" value="{{ $anio }}" class="border-gray-100 bg-gray-50 rounded-2xl font-black text-indigo-600 w-32 text-center">
                <button type="submit" class="bg-gray-800 text-white font-black uppercase italic px-8 py-3 rounded-2xl text-[10px] tracking-widest hover:bg-black transition-all">
                    Consultar Periodo
                </button>
            </form>
        </div>

        {{-- GRÁFICO DE BALANCE MENSUAL --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6 italic text-center">Comparativa Mensual: Ingresos vs Gastos</p>
            <div class="h-64">
                <canvas id="chartMensual"></canvas>
            </div>
        </div>

        {{-- RESUMEN CONTABLE --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 italic">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Balance Operativo</p>
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-bold text-gray-600 text-xs">(+) Ingresos (Intereses):</span>
                        <span class="font-black text-green-600">RD$ {{ number_format($ingresosBrutos, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-bold text-gray-600 text-xs">(-) Gastos Administrativos:</span>
                        <span class="font-black text-red-500 underline decoration-red-200">RD$ {{ number_format($gastosTotales, 2) }}</span>
                    </div>
                    <div class="pt-3 border-t border-dashed border-gray-200 flex justify-between items-center">
                        <span class="font-black text-gray-900 uppercase text-[10px]">Excedente Bruto:</span>
                        <span class="font-black text-gray-900">RD$ {{ number_format($ingresosBrutos - $gastosTotales, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-8 rounded-[2.5rem] border border-gray-200">
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-4">Retenciones Legales</p>
                <div class="space-y-3 text-[11px]">
                    <div class="flex justify-between">
                        <span class="font-bold text-gray-500 uppercase">Educativa (5%):</span>
                        <span class="font-black text-gray-700">RD$ {{ number_format($ret_educacion, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-bold text-gray-500 uppercase">Reserva Legal (10%):</span>
                        <span class="font-black text-gray-700">RD$ {{ number_format($ret_legal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-bold text-gray-500 uppercase">Incobrables (1%):</span>
                        <span class="font-black text-gray-700">RD$ {{ number_format($ret_incobrables, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-indigo-700 p-8 rounded-[2.5rem] shadow-xl text-white relative">
                <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mb-4">Fondo Neto Repartible</p>
                <h3 class="text-4xl font-black tracking-tighter mb-2">RD$ {{ number_format($excedenteNetoADistribuir, 2) }}</h3>
                <p class="text-[9px] font-bold opacity-70 uppercase tracking-widest leading-tight mb-6">Monto neto final tras gastos y reservas.</p>

                {{-- BOTÓN DE CIERRE OFICIAL --}}
                <form action="{{ route('admin.excedentes.store') }}" method="POST" onsubmit="return confirm('¿Confirmas el cierre oficial del año {{ $anio }}? Esta acción guardará los montos de forma permanente.')">
                    @csrf
                    <input type="hidden" name="anio" value="{{ $anio }}">
                    <button type="submit" class="w-full bg-white text-indigo-700 font-black uppercase italic py-2 rounded-xl text-[9px] tracking-widest hover:bg-indigo-50 transition-all no-print">
                        <i class="fa-solid fa-lock mr-1"></i> Cerrar Año Fiscal {{ $anio }}
                    </button>
                </form>
            </div>
        </div>

        {{-- TABLA DE DISTRIBUCIÓN --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left italic">
                <thead class="bg-gray-800 text-white">
                    <tr class="text-[10px] font-black uppercase tracking-widest">
                        <th class="px-8 py-4">Socio Participante</th>
                        <th class="px-8 py-4 text-right">Intereses Pagados</th>
                        <th class="px-8 py-4 text-right bg-indigo-600">Retorno Sugerido</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($reporte as $linea)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-4">
                                <p class="text-xs font-black text-gray-800 uppercase">{{ $linea['nombre'] }}</p>
                                <p class="text-[9px] font-bold text-gray-400 mt-1 uppercase">CÉDULA: {{ $linea['cedula'] }}</p>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <span class="text-xs font-bold text-gray-600 italic">RD$ {{ number_format($linea['base_intereses'], 2) }}</span>
                            </td>
                            <td class="px-8 py-4 text-right bg-indigo-50/20">
                                <span class="text-sm font-black text-indigo-700 italic">RD$ {{ number_format($linea['monto_pat'], 2) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-8 py-10 text-center text-gray-400 text-xs italic">Sin registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- LIBRERÍA DE GRÁFICOS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartMensual').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [
                    {
                        label: 'Ingresos (Intereses)',
                        data: @json($mensual_ingresos),
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 2,
                        borderRadius: 8,
                    },
                    {
                        label: 'Gastos Administrativos',
                        data: @json($mensual_gastos),
                        backgroundColor: 'rgba(239, 68, 68, 0.2)',
                        borderColor: 'rgb(239, 68, 68)',
                        borderWidth: 2,
                        borderRadius: 8,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { weight: 'bold', family: 'Inter' } } }
                },
                scales: {
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>

    <style>
        @media print {
            .no-print { display: none !important; }
            nav, header { display: none !important; }
            .py-12 { padding: 0 !important; }
            .shadow-sm, .shadow-xl { box-shadow: none !important; border: 1px solid #eee !important; }
            .bg-indigo-700 { background-color: #eee !important; color: black !important; }
            .text-white { color: black !important; }
            .rounded-[2.5rem] { border-radius: 1rem !important; }
            canvas { max-height: 250px !important; }
        }
    </style>
</x-app-layout>
