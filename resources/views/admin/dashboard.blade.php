<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
            {{ __('Panel Administrativo - Cooperativa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- TARJETAS SUPERIORES --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center group hover:shadow-lg transition-all">
                    <div class="p-3 bg-blue-100 rounded-full mr-4">
                        <span class="text-2xl">📋</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs font-black uppercase tracking-wider">Préstamos Activos</span>
                        <span class="block text-2xl font-bold text-blue-600">{{ \App\Models\Prestamo::where('estado', '!=', 'pagado')->count() }}</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center group hover:shadow-lg transition-all">
                    <div class="p-3 bg-indigo-100 rounded-full mr-4">
                        <span class="text-2xl">👥</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs font-black uppercase tracking-wider">Total Socios</span>
                        <span class="block text-2xl font-bold text-indigo-600">{{ \App\Models\User::where('tipo', 0)->count() }}</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center group hover:shadow-lg transition-all">
                    <div class="p-3 bg-green-100 rounded-full mr-4">
                        <span class="text-2xl">💰</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs font-black uppercase tracking-wider">Capital en la Calle</span>
                        <span class="block text-xl font-bold text-green-600 font-mono">RD$ {{ number_format(\App\Models\Prestamo::where('estado', 'activo')->sum('saldo_capital'), 0) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-8 border border-gray-100">
                <h3 class="text-gray-400 text-sm font-bold uppercase tracking-widest mb-6 border-b pb-2">Gestión de Operaciones</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-2">
                        <p class="text-xs font-bold text-gray-400 uppercase">Socios</p>
                        <a href="{{ route('admin.socios.index') }}" class="flex items-center p-3 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition font-bold text-sm">
                            👥 Directorio General
                        </a>
                        <a href="{{ route('admin.socios.create') }}" class="flex items-center p-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition font-bold text-sm">
                            <span>+</span> &nbsp; Registrar Nuevo
                        </a>
                    </div>

                    <div class="space-y-2">
                        <p class="text-xs font-bold text-gray-400 uppercase">Préstamos</p>
                        <a href="{{ route('admin.prestamos.index') }}" class="flex items-center p-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-bold text-sm">
                            📋 Ver Listado Completo
                        </a>
                        <a href="{{ route('admin.prestamos.vencimientos') }}" class="flex items-center p-3 bg-orange-50 text-orange-700 rounded-lg hover:bg-orange-100 transition font-bold text-sm">
                            ⏰ Alertas de Vencimiento
                        </a>
                    </div>

                    <div class="space-y-2 lg:col-span-2">
                        <p class="text-xs font-bold text-gray-400 uppercase">Reportes e Inteligencia</p>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.reportes.visitas') }}" class="p-2 border rounded hover:bg-gray-50 text-xs font-semibold text-gray-600">📊 Visitas</a>
                            <a href="{{ route('admin.reportes.morosidad') }}" class="p-2 border rounded hover:bg-gray-50 text-xs font-semibold text-gray-600">⚠️ Morosidad</a>
                            <a href="{{ route('admin.reportes.utilidades') }}" class="p-2 border rounded hover:bg-gray-50 text-xs font-semibold text-gray-600">💰 Intereses</a>
                            <a href="{{ route('admin.reportes.variacion') }}" class="p-2 border rounded hover:bg-gray-50 text-xs font-semibold text-gray-600">💵 Proyección Cobro</a>
                            <a href="{{ route('admin.reportes.proyeccion') }}" class="p-2 border rounded hover:bg-gray-50 text-xs font-semibold text-gray-600">📅 Proyección Meses</a>
                            <a href="{{ route('admin.reportes.concentracion') }}" class="p-2 border rounded hover:bg-gray-50 text-xs font-semibold text-gray-600">📈 Cartera</a>
                            <a href="{{ route('admin.reportes.ahorros') }}" class="p-2 border rounded hover:bg-gray-50 text-xs font-semibold text-gray-600">🏦 Pasivos</a>
                            <a href="{{ route('admin.logs.index') }}" class="p-2 border rounded hover:bg-gray-50 text-xs font-semibold text-gray-600">🔍 Auditoría de Logs</a>

                            <a href="{{ route('admin.reportes.mensual') }}" class="p-2 border rounded hover:bg-gray-50 text-xs font-bold text-gray-700 lg:col-span-2 text-center">
                                📄 Informe de Gestión Mensual
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-dashed">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="mr-2">📥</span> Nómina para Descuento
                    </h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('admin.reportes.nomina', 'fijo') }}" class="bg-green-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-green-700 shadow-lg shadow-green-200 transition">
                            Excel Empleados FIJOS
                        </a>
                        <a href="{{ route('admin.reportes.nomina', 'contratado') }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                            Excel CONTRATADOS
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-[0.3em] mb-6 text-center italic">Tendencia Financiera Anual (Ahorros vs Préstamos)</h3>
                <div class="h-[350px] w-full">
                    <canvas id="graficoFinanciero"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('graficoFinanciero').getContext('2d');

            const labels = @json($meses);
            const dataAhorros = @json($ahorros);
            const dataPrestamos = @json($prestamos);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Entrada de Ahorros (RD$)',
                        data: dataAhorros,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.05)',
                        borderWidth: 4,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }, {
                        label: 'Desembolso Préstamos (RD$)',
                        data: dataPrestamos,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.05)',
                        borderWidth: 4,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { size: 11, weight: 'bold' },
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 14, weight: 'bold' },
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': RD$ ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 9, weight: 'bold' },
                                color: '#94a3b8',
                                maxRotation: 45,
                                minRotation: 0
                            }
                        },
                        y: {
                            beginAtZero: true,
                            border: { dash: [5, 5] },
                            ticks: {
                                font: { size: 10, weight: 'bold' },
                                color: '#94a3b8',
                                callback: function(value) {
                                    return 'RD$ ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
