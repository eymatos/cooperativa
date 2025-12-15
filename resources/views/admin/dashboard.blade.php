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

            <a href="{{ route('admin.prestamos.create') }}" class="btn btn-green">
                ➕ Crear Nuevo Préstamo
            </a>

            <a href="{{ route('admin.socios.index') }}" class="btn btn-indigo">
                👥 Directorio de Socios
            </a>
        </div>

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
