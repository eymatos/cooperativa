<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Perfil del Socio: {{ $socio->nombres }}
            </h2>
            <a href="{{ route('admin.socios.index') }}" class="text-gray-600 hover:text-gray-900 font-bold text-sm">
                &larr; Volver al Directorio
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-1">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex flex-col items-center">
                            <div class="h-24 w-24 bg-gray-200 rounded-full flex items-center justify-center text-3xl font-bold text-gray-500 mb-4">
                                {{ substr($socio->nombres, 0, 1) }}
                            </div>
                            <h3 class="text-lg font-bold">{{ $socio->nombres }} {{ $socio->apellidos }}</h3>
                            <p class="text-gray-500 text-sm">{{ $socio->email }}</p>
                        </div>
                        <hr class="my-4">
                        <div class="text-sm">
                            <p class="mb-2"><strong class="text-gray-700">Cédula:</strong> {{ $socio->cedula }}</p>
                            <p class="mb-2"><strong class="text-gray-700">Teléfono:</strong> {{ $socio->telefono ?? 'N/A' }}</p>
                            <p class="mb-2"><strong class="text-gray-700">Dirección:</strong> {{ $socio->direccion ?? 'N/A' }}</p>
                            <p class="mb-2"><strong class="text-gray-700">Miembro desde:</strong> {{ $socio->created_at->format('d/m/Y') }}</p>
                        </div>

                        <div class="mt-6">
                            <h4 class="font-bold text-gray-700 mb-2">Resumen Global</h4>
                            <div class="bg-red-50 p-3 rounded mb-2">
                                <span class="block text-xs text-red-600 uppercase font-bold">Deuda Actual</span>
                                <span class="block text-xl font-bold text-red-800">RD$ {{ number_format($totalDeuda, 2) }}</span>
                            </div>
                            <div class="bg-green-50 p-3 rounded">
                                <span class="block text-xs text-green-600 uppercase font-bold">Total Ahorrado</span>
                                <span class="block text-xl font-bold text-green-800">RD$ {{ number_format($totalAhorradoGlobal ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-6">

                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">📂 Préstamos Activos</h3>
                            <a href="{{ route('admin.prestamos.create') }}?user_id={{ $socio->id }}" class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 font-bold">
                                + Nuevo Préstamo
                            </a>
                        </div>

                        @if($prestamosActivos->isEmpty())
                            <div class="text-center py-4 bg-gray-50 rounded border border-gray-200">
                                <p class="text-gray-500 italic">El socio está al día. No tiene deudas activas.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-gray-600 font-bold uppercase text-xs">ID</th>
                                            <th class="px-4 py-2 text-left text-gray-600 font-bold uppercase text-xs">Fecha</th>
                                            <th class="px-4 py-2 text-left text-gray-600 font-bold uppercase text-xs">Tipo</th>
                                            <th class="px-4 py-2 text-left text-gray-600 font-bold uppercase text-xs">Monto</th>
                                            <th class="px-4 py-2 text-left text-gray-600 font-bold uppercase text-xs">Saldo</th>
                                            <th class="px-4 py-2 text-left text-gray-600 font-bold uppercase text-xs">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($prestamosActivos as $prestamo)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-gray-500">#{{ $prestamo->id }}</td>
                                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 rounded text-xs font-bold bg-indigo-100 text-indigo-700">
                                                    {{ $prestamo->tipoPrestamo->nombre ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 font-bold text-gray-800">RD$ {{ number_format($prestamo->monto, 2) }}</td>
                                            <td class="px-4 py-3 font-bold text-red-600">RD$ {{ number_format($prestamo->saldo_capital, 2) }}</td>
                                            <td class="px-4 py-3">
                                                <div class="flex gap-2">
                                                    <a href="{{ route('admin.prestamos.show', $prestamo->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-xs border border-blue-200 px-2 py-1 rounded">Ver Tabla</a>
                                                    <a href="{{ route('admin.pagos.create', $prestamo->id) }}" class="text-green-600 hover:text-green-800 font-semibold text-xs border border-green-200 px-2 py-1 rounded">Pagar</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @if($prestamosInactivos->isNotEmpty())
                            <div class="mt-6 border-t pt-4 text-center">
                                <button onclick="toggleHistorial()" class="text-gray-500 hover:text-gray-700 text-sm font-bold flex items-center justify-center gap-2 mx-auto focus:outline-none">
                                    <span>⬇ Ver Historial de Préstamos Pagados</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div id="historial-inactivo" class="bg-gray-100 shadow-inner rounded-lg p-6 hidden">
                        <h3 class="text-md font-bold text-gray-600 mb-3">Historial de Préstamos Pagados</h3>
                        <div class="overflow-x-auto bg-white rounded shadow-sm">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">ID</th>
                                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Fecha</th>
                                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Tipo</th>
                                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Monto</th>
                                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Estado</th>
                                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($prestamosInactivos as $prestamo)
                                    <tr class="opacity-75 hover:opacity-100 transition-opacity">
                                        <td class="px-4 py-3">#{{ $prestamo->id }}</td>
                                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">{{ $prestamo->tipoPrestamo->nombre ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">RD$ {{ number_format($prestamo->monto, 2) }}</td>
                                        <td class="px-4 py-3"><span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">Pagado</span></td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('admin.prestamos.show', $prestamo->id) }}" class="text-gray-500 hover:text-gray-900 text-xs underline font-bold">Consultar</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg p-6 mt-8" id="seccion-ahorros">

                        <div class="flex flex-col md:flex-row justify-between items-center mb-6 border-b pb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">💰 Histórico Anual de Ahorros</h3>
                                <p class="text-sm text-gray-500">
                                    Resumen mensual. <span class="text-blue-600 font-semibold cursor-help">Pasa el mouse sobre los montos</span> para ver detalles.
                                </p>
                            </div>

                            <form action="{{ route('admin.socios.show', $socio->id) }}#seccion-ahorros" method="GET" class="flex items-center gap-2 mt-4 md:mt-0">
                                <label class="font-bold text-gray-700">Año:</label>
                                <select name="anio_ahorro" onchange="this.form.submit()" class="border-gray-300 rounded shadow-sm py-1 font-bold text-gray-700 focus:ring-indigo-500 focus:border-indigo-500">
                                    @if(isset($aniosDisponibles) && $aniosDisponibles->isNotEmpty())
                                        @foreach($aniosDisponibles as $anio)
                                            <option value="{{ $anio }}" {{ (isset($anioSeleccionado) && $anioSeleccionado == $anio) ? 'selected' : '' }}>{{ $anio }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                    @endif
                                </select>
                            </form>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                            <div class="border rounded-lg bg-blue-50 overflow-hidden">
                                <div class="p-4 border-b bg-blue-100">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="font-bold text-blue-900">🔹 Aportaciones (Normal)</h4>
                                        <span class="text-lg font-bold text-blue-900">Total: RD$ {{ number_format($totalAportaciones ?? 0, 2) }}</span>
                                    </div>
                                    <div class="flex items-center justify-between bg-white px-3 py-2 rounded border border-blue-200">
                                        <span class="text-xs font-bold text-gray-500 uppercase">Cuota Mensual Definida:</span>
                                        <span class="text-sm font-bold text-blue-700">RD$ {{ number_format($cuentaAportacion->recurring_amount ?? 0, 2) }}</span>
                                    </div>
                                </div>
                                <div class="overflow-x-auto bg-white">
                                    <table class="min-w-full text-xs">
                                        <thead class="bg-gray-100 text-gray-600 uppercase border-b">
                                            <tr>
                                                <th class="px-4 py-2 text-left">Mes</th>
                                                <th class="px-4 py-2 text-right">Aporte</th>
                                                <th class="px-4 py-2 text-right">Retiro</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @if(isset($matrizAportacion))
                                                @foreach($matrizAportacion as $mesNum => $data)
                                                <tr class="hover:bg-gray-50 group">
                                                    <td class="px-4 py-2 font-bold text-gray-500 capitalize">{{ \Carbon\Carbon::create()->month($mesNum)->locale('es')->monthName }}</td>
                                                    <td class="px-4 py-2 text-right font-mono" title="{{ implode(', ', $data['comentarios']) }}">
                                                        @if($data['aporte'] > 0)
                                                            <span class="text-green-700 font-bold cursor-help border-b border-dotted border-green-400">{{ number_format($data['aporte'], 2) }}</span>
                                                            @if(count($data['comentarios']) > 0) <span class="text-[9px] align-top text-gray-400 ml-1">💬</span> @endif
                                                        @else <span class="text-gray-300">-</span> @endif
                                                    </td>
                                                    <td class="px-4 py-2 text-right font-mono text-red-600">
                                                        {{ $data['retiro'] > 0 ? number_format($data['retiro'], 2) : '-' }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else <tr><td colspan="3" class="p-4 text-center">No hay datos.</td></tr> @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="border rounded-lg bg-yellow-50 overflow-hidden">
                                <div class="p-4 border-b bg-yellow-100">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="font-bold text-yellow-900">🔸 Ahorro Retirable</h4>
                                        <span class="text-lg font-bold text-yellow-900">Total: RD$ {{ number_format($totalRetirable ?? 0, 2) }}</span>
                                    </div>
                                    <div class="flex items-center justify-between bg-white px-3 py-2 rounded border border-yellow-200">
                                        <span class="text-xs font-bold text-gray-500 uppercase">Cuota Mensual Definida:</span>
                                        <span class="text-sm font-bold text-yellow-700">RD$ {{ number_format($cuentaVoluntario->recurring_amount ?? 0, 2) }}</span>
                                    </div>
                                </div>
                                <div class="overflow-x-auto bg-white">
                                    <table class="min-w-full text-xs">
                                        <thead class="bg-gray-100 text-gray-600 uppercase border-b">
                                            <tr>
                                                <th class="px-4 py-2 text-left">Mes</th>
                                                <th class="px-4 py-2 text-right">Aporte</th>
                                                <th class="px-4 py-2 text-right">Retiro</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @if(isset($matrizVoluntario))
                                                @foreach($matrizVoluntario as $mesNum => $data)
                                                <tr class="hover:bg-gray-50 group">
                                                    <td class="px-4 py-2 font-bold text-gray-500 capitalize">{{ \Carbon\Carbon::create()->month($mesNum)->locale('es')->monthName }}</td>
                                                    <td class="px-4 py-2 text-right font-mono" title="{{ implode(', ', $data['comentarios']) }}">
                                                        @if($data['aporte'] > 0)
                                                            <span class="text-green-700 font-bold cursor-help border-b border-dotted border-green-400">{{ number_format($data['aporte'], 2) }}</span>
                                                            @if(count($data['comentarios']) > 0) <span class="text-[9px] align-top text-gray-400 ml-1">💬</span> @endif
                                                        @else <span class="text-gray-300">-</span> @endif
                                                    </td>
                                                    <td class="px-4 py-2 text-right font-mono text-red-600">
                                                        {{ $data['retiro'] > 0 ? number_format($data['retiro'], 2) : '-' }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else <tr><td colspan="3" class="p-4 text-center">No hay datos.</td></tr> @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleHistorial() {
            const historial = document.getElementById('historial-inactivo');
            if (historial.classList.contains('hidden')) {
                historial.classList.remove('hidden');
            } else {
                historial.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
