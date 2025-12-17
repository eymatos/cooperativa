<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - Cooperativa</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 5px; }

        /* Menú de Botones */
        .menu { margin-top: 25px; display: flex; gap: 10px; flex-wrap: wrap; }
        .btn { padding: 12px 20px; text-decoration: none; color: white; border-radius: 5px; font-weight: bold; display: inline-flex; align-items: center; gap: 5px; transition: 0.3s; }

        /* Colores de botones */
        .btn-blue { background: #007bff; }
        .btn-blue:hover { background: #0056b3; }

        .btn-green { background: #28a745; }
        .btn-green:hover { background: #218838; }

        /* NUEVO: Color Morado para Socios */
        .btn-indigo { background: #6610f2; }
        .btn-indigo:hover { background: #520dc2; }

        .btn-red { background: #dc3545; border: none; cursor: pointer; font-size: 16px;}
        .btn-red:hover { background: #c82333; }

        .card { border: 1px solid #ddd; padding: 20px; margin-top: 25px; border-radius: 5px; background: #fafafa; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Bienvenido, {{ Auth::user()->name }}</h1>
        <p style="color: #666; margin-top:0;">Panel de Administración Principal</p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

        <div class="menu">
            <a href="{{ route('admin.prestamos.index') }}" class="btn btn-blue">
                📋 Ver Lista de Préstamos
            </a>

            <a href="{{ route('admin.socios.index') }}" class="btn btn-indigo">
                👥 Directorio de Socios
            </a>
            <a href="{{ route('admin.socios.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
                <span class="mr-2">+</span> Registrar Nuevo Socio
            </a>
            <a href="{{ route('admin.prestamos.vencimientos') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-orange-600 active:bg-orange-700 transition">
                <span class="mr-2">⏰</span> Préstamos a Vencer
            </a>
            <a href="{{ route('admin.reportes.visitas') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 transition shadow-sm">
                <span class="mr-2">📊</span> Ver Estadísticas de Visitas
            </a>
            <a href="{{ route('admin.reportes.morosidad') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition shadow-md">
                <span class="mr-2">⚠️</span> Morosidad
            </a>
            <a href="{{ route('admin.reportes.auditoria') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition shadow-lg">
                <span class="mr-2">🔍</span> Auditoría de Logs
            </a>
            <a href="{{ route('admin.reportes.utilidades') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition shadow-lg">
                <span class="mr-2">💰</span> Intereses cobrados
            </a>
            <a href="{{ route('admin.reportes.proyeccion') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-purple-700 transition shadow-lg">
                <span class="mr-2">📅</span> Proyección de Cobros
            </a>
            <a href="{{ route('admin.reportes.concentracion') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg">
                <span class="mr-2">📈</span> Concentración Cartera
            </a>
            <a href="{{ route('admin.reportes.ahorros') }}" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-900 transition shadow-lg">
                <span class="mr-2">🏦</span> Reporte de Pasivos
            </a>
        </div>
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h3 class="text-lg font-bold text-gray-700 mb-4 text-center">Tendencia Financiera Semestral</h3>
    <div style="position: relative; height:350px; width:100%">
        <canvas id="graficoFinanciero"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('graficoFinanciero').getContext('2d');

        // Convertimos los datos de PHP a arreglos puros de JS
        const labels = @json(array_values($meses));
        const dataAhorros = @json(array_values($ahorros));
        const dataPrestamos = @json(array_values($prestamos));

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Entrada de Ahorros (RD$)',
                    data: dataAhorros,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Desembolso Préstamos (RD$)',
                    data: dataPrestamos,
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return 'RD$ ' + value.toLocaleString(); }
                        }
                    }
                }
            }
        });
    });
</script>
        <div class="card">
            <h3 style="margin-top: 0;">Estadísticas Rápidas</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center mt-4">

                <div class="bg-white p-4 rounded border shadow-sm">
                    <span class="block text-gray-500 text-sm font-bold uppercase">Préstamos Activos</span>
                    <span class="block text-3xl font-bold text-blue-600">
                        {{ \App\Models\Prestamo::where('estado', '!=', 'pagado')->count() }}
                    </span>
                </div>

                <div class="bg-white p-4 rounded border shadow-sm">
                    <span class="block text-gray-500 text-sm font-bold uppercase">Total Socios</span>
                    <span class="block text-3xl font-bold text-indigo-600">
                        {{ \App\Models\User::where('tipo', 0)->count() }}
                    </span>
                </div>

                <div class="bg-white p-4 rounded border shadow-sm">
                    <span class="block text-gray-500 text-sm font-bold uppercase">Capital en la Calle</span>
                    <span class="block text-xl font-bold text-green-600">
                        RD$ {{ number_format(\App\Models\Prestamo::sum('saldo_capital'), 0) }}
                    </span>
                </div>

            </div>
        </div>

        <div style="margin-top: 30px; text-align: right;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-red">Cerrar Sesión</button>
            </form>
        </div>
    </div>

</body>
</html>
