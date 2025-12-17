<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Administrativo - Cooperativa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full mr-4">
                        <span class="text-2xl">📋</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs font-bold uppercase tracking-wider">Préstamos Activos</span>
                        <span class="block text-2xl font-bold text-blue-600">{{ \App\Models\Prestamo::where('estado', '!=', 'pagado')->count() }}</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-indigo-100 rounded-full mr-4">
                        <span class="text-2xl">👥</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs font-bold uppercase tracking-wider">Total Socios</span>
                        <span class="block text-2xl font-bold text-indigo-600">{{ \App\Models\User::where('tipo', 0)->count() }}</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-green-100 rounded-full mr-4">
                        <span class="text-2xl">💰</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs font-bold uppercase tracking-wider">Capital en la Calle</span>
                        <span class="block text-xl font-bold text-green-600 font-mono">RD$ {{ number_format(\App\Models\Prestamo::sum('saldo_capital'), 0) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-8 border border-gray-100">
                <h3 class="text-gray-400 text-sm font-bold uppercase tracking-widest mb-6 border-b pb-2">Gestión de Operaciones</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-2">
                        <p class="text-xs font-bold text-gray-400">SOCIOS</p>
                        <a href="{{ route('admin.socios.index') }}" class="flex items-center p-3 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition font-bold text-sm">
                            👥 Directorio General
                        </a>
                        <a href="{{ route('admin.socios.create') }}" class="flex items-center p-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition font-bold text-sm">
                            <span>+</span> &nbsp; Registrar Nuevo
                        </a>
                    </div>

                    <div class="space-y-2">
                        <p class="text-xs font-bold text-gray-400">PRÉSTAMOS</p>
                        <a href="{{ route('admin.prestamos.index') }}" class="flex items-center p-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-bold text-sm">
                            📋 Ver Listado Completo
                        </a>
                        <a href="{{ route('admin.prestamos.vencimientos') }}" class="flex items-center p-3 bg-orange-50 text-orange-700 rounded-lg hover:bg-orange-100 transition font-bold text-sm">
                            ⏰ Alertas de Vencimiento
                        </a>
                    </div>

                    <div class="space-y-2 lg:col-span-2">
                        <p class="text-xs font-bold text-gray-400">REPORTES E INTELIGENCIA</p>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.reportes.visitas') }}" class="p-2 border rounded hover:bg-gray-50 text-xs font-semibold text-gray-600">📊 Visitas</a>
                            <a href="{{ route('admin.reportes.morosidad') }}" class="p-2 border rounded hover:bg-red-50 text-xs font-semibold text-red-600">⚠️ Morosidad</a>
                            <a href="{{ route('admin.reportes.utilidades') }}" class="p-2 border rounded hover:bg-green-50 text-xs font-semibold text-green-600">💰 Intereses</a>
                            <a href="{{ route('admin.reportes.proyeccion') }}" class="p-2 border rounded hover:bg-purple-50 text-xs font-semibold text-purple-600">📅 Proyección</a>
                            <a href="{{ route('admin.reportes.concentracion') }}" class="p-2 border rounded hover:bg-indigo-50 text-xs font-semibold text-indigo-600">📈 Cartera</a>
                            <a href="{{ route('admin.reportes.ahorros') }}" class="p-2 border rounded hover:bg-blue-50 text-xs font-semibold text-blue-600">🏦 Pasivos</a>
                            <a href="{{ route('admin.reportes.auditoria') }}" class="p-2 border rounded hover:bg-gray-100 text-xs font-semibold text-gray-700">🔍 Auditoría</a>
                            <a href="{{ route('admin.reportes.mensual') }}" class="p-2 border rounded hover:bg-slate-100 text-xs font-semibold text-slate-700 font-bold">📄 Informe Gestión</a>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-dashed">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="mr-2">📥</span> Nómina para Descuento
                    </h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('admin.reportes.nomina', 'fijo') }}" class="bg-green-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-green-700 shadow-lg shadow-green-200 transition flex items-center">
                            Excel Empleados FIJOS
                        </a>
                        <a href="{{ route('admin.reportes.nomina', 'contratado') }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition flex items-center">
                            Excel CONTRATADOS
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-700 mb-6 text-center">Tendencia Financiera Semestral</h3>
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
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json(array_values($meses)),
                    datasets: [{
                        label: 'Entrada de Ahorros (RD$)',
                        data: @json(array_values($ahorros)),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.05)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }, {
                        label: 'Desembolso Préstamos (RD$)',
                        data: @json(array_values($prestamos)),
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.05)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { callback: function(value) { return 'RD$ ' + value.toLocaleString(); } }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
