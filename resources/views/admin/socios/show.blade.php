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

                    {{-- INICIO: TARJETA DE PRÉSTAMOS ACTIVOS --}}
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">📂 Préstamos Activos</h3>
                            <a href="{{ route('admin.prestamos.create') }}?user_id={{ $socio->user_id }}" class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 font-bold">
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
                                            <td class="px-4 py-3 text-gray-500">
                                                <span class="font-bold text-gray-700">{{ $prestamo->numero_prestamo }}</span>
                                                <span class="text-xs text-gray-400">(ID: {{ $prestamo->id }})</span>
                                            </td>
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
                                                    <a href="{{ route('admin.prestamos.edit', $prestamo->id) }}" class="text-yellow-600 hover:text-yellow-900 font-bold text-xs border border-yellow-300 px-2 py-1 rounded ml-1">Editar</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        {{-- BOTÓN DE HISTORIAL PAGADO (Nueva Página) --}}
                        @if($prestamosInactivos->isNotEmpty())
                            <div class="mt-6 border-t pt-4 text-center">
                                <a href="{{ route('admin.socios.historial.prestamos', $socio->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-bold rounded-md shadow-sm text-gray-600 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    📊 Ver Historial de Préstamos Pagados ({{ $prestamosInactivos->count() }})
                                </a>
                            </div>
                        @endif
                    </div>
                    {{-- FIN: TARJETA DE PRÉSTAMOS ACTIVOS --}}

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
                                    @foreach($aniosDisponibles as $anio)
                                        <option value="{{ $anio }}" {{ (isset($anioSeleccionado) && (string)$anioSeleccionado == (string)$anio) ? 'selected' : '' }}>
                                            {{ $anio }}
                                        </option>
                                    @endforeach
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
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-blue-700">RD$ {{ number_format($cuentaAportacion->recurring_amount ?? 0, 2) }}</span>
                                            <button onclick="abrirModalCuota('{{ $cuentaAportacion->id }}', '{{ $cuentaAportacion->recurring_amount }}', 'Aportación Normal')"
                                                     class="text-blue-500 hover:bg-blue-100 p-1 rounded transition" title="Editar Cuota">✏️</button>
                                        </div>
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
                                                <tr class="hover:bg-gray-50 group transition">
                                                    <td class="px-4 py-2 font-bold text-gray-500 capitalize">
                                                        {{ \Carbon\Carbon::create()->month($mesNum)->locale('es')->monthName }}
                                                    </td>

                                                    <td class="px-4 py-2 text-right">
                                                        <button onclick='gestionarMes(@json($data["transacciones"]), "{{ $cuentaAportacion->id }}", "{{ $anioSeleccionado }}", "{{ $mesNum }}", "deposit")'
                                                                class="hover:bg-blue-100 px-2 py-1 rounded text-right w-full focus:outline-none transition">
                                                            @if($data['aporte'] > 0)
                                                                <span class="text-green-700 font-bold font-mono">{{ number_format($data['aporte'], 2) }}</span>
                                                            @else
                                                                <span class="text-gray-300">-</span>
                                                            @endif
                                                        </button>
                                                    </td>

                                                    <td class="px-4 py-2 text-right">
                                                        <button onclick='gestionarMes(@json($data["transacciones"]), "{{ $cuentaAportacion->id }}", "{{ $anioSeleccionado }}", "{{ $mesNum }}", "withdrawal")'
                                                                class="hover:bg-red-50 px-2 py-1 rounded text-right w-full focus:outline-none transition">
                                                            @if($data['retiro'] > 0)
                                                                <span class="text-red-600 font-bold font-mono">{{ number_format($data['retiro'], 2) }}</span>
                                                            @else
                                                                <span class="text-gray-300">-</span>
                                                            @endif
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
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
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-yellow-700">RD$ {{ number_format($cuentaVoluntario->recurring_amount ?? 0, 2) }}</span>
                                            <button onclick="abrirModalCuota('{{ $cuentaVoluntario->id }}', '{{ $cuentaVoluntario->recurring_amount }}', 'Ahorro Retirable')"
                                                     class="text-yellow-600 hover:bg-yellow-100 p-1 rounded transition" title="Editar Cuota">✏️</button>
                                        </div>
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
                                                <tr class="hover:bg-gray-50 group transition">
                                                    <td class="px-4 py-2 font-bold text-gray-500 capitalize">
                                                        {{ \Carbon\Carbon::create()->month($mesNum)->locale('es')->monthName }}
                                                    </td>

                                                    <td class="px-4 py-2 text-right">
                                                        <button onclick='gestionarMes(@json($data["transacciones"]), "{{ $cuentaVoluntario->id }}", "{{ $anioSeleccionado }}", "{{ $mesNum }}", "deposit")'
                                                                class="hover:bg-yellow-100 px-2 py-1 rounded text-right w-full focus:outline-none transition">
                                                            @if($data['aporte'] > 0)
                                                                <span class="text-green-700 font-bold font-mono">{{ number_format($data['aporte'], 2) }}</span>
                                                            @else
                                                                <span class="text-gray-300">-</span>
                                                            @endif
                                                        </button>
                                                    </td>

                                                    <td class="px-4 py-2 text-right">
                                                        <button onclick='gestionarMes(@json($data["transacciones"]), "{{ $cuentaVoluntario->id }}", "{{ $anioSeleccionado }}", "{{ $mesNum }}", "withdrawal")'
                                                                class="hover:bg-red-50 px-2 py-1 rounded text-right w-full focus:outline-none transition">
                                                            @if($data['retiro'] > 0)
                                                                <span class="text-red-600 font-bold font-mono">{{ number_format($data['retiro'], 2) }}</span>
                                                            @else
                                                                <span class="text-gray-300">-</span>
                                                            @endif
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
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

    {{-- MODAL CUOTA --}}
    <div id="modal-cuota" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4" id="modal-titulo-texto">Editar Cuota</h3>
            <form id="form-cuota" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nuevo Monto Mensual:</label>
                    <input type="number" step="0.01" name="recurring_amount" id="modal-input-monto"
                           class="w-full border rounded py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="cerrarModalCuota()" class="px-4 py-2 bg-gray-300 rounded text-gray-800">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded font-bold hover:bg-blue-700">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL GESTOR DE TRANSACCIONES --}}
    <div id="modal-gestor" class="fixed inset-0 bg-gray-900 bg-opacity-60 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl p-6 mx-4">

            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="text-xl font-bold text-gray-800">Gestionar Movimientos</h3>
                <button onclick="cerrarGestor()" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
            </div>

            <div id="lista-transacciones" class="mb-6 space-y-3">
            </div>

            <hr class="border-gray-200 my-4">

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h4 class="text-sm font-bold text-gray-700 mb-3 uppercase" id="form-titulo">➕ Agregar Nuevo Movimiento</h4>

                <form id="form-transaccion" method="POST" action="{{ route('admin.ahorros.transaction.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    <input type="hidden" name="savings_account_id" id="input-account-id">
                    <input type="hidden" name="type" id="input-type">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Fecha</label>
                            <input type="date" name="date" id="input-date" required class="w-full text-sm border-gray-300 rounded shadow-sm focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Monto (RD$)</label>
                            <input type="number" step="0.01" name="amount" id="input-amount" required class="w-full text-sm border-gray-300 rounded shadow-sm focus:ring-blue-500 font-bold text-green-700">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-gray-500 mb-1">Comentario / Descripción</label>
                            <input type="text" name="description" id="input-desc" placeholder="Ej: Depósito Extra Marzo" class="w-full text-sm border-gray-300 rounded shadow-sm focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" onclick="resetFormulario()" id="btn-cancelar-edit" class="hidden px-3 py-1 bg-gray-300 rounded text-sm font-bold">Cancelar Edición</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-bold hover:bg-blue-700 shadow">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Variables globales para recordar el contexto
        let currentAccountId = null;
        let currentYear = null;
        let currentMonth = null;
        let currentType = null; // 'deposit' o 'withdrawal'
        const socioId = '{{ $socio->id }}'; // ID del socio para las redirecciones

        function abrirModalCuota(id, monto, nombre) {
            document.getElementById('modal-titulo-texto').innerText = 'Editar: ' + nombre;
            document.getElementById('modal-input-monto').value = monto;
            document.getElementById('form-cuota').action = "/admin/cuentas/update-cuota/" + id;
            document.getElementById('modal-cuota').classList.remove('hidden');
        }
        function cerrarModalCuota() {
            document.getElementById('modal-cuota').classList.add('hidden');
        }

        function gestionarMes(transacciones, accountId, year, month, type) {
            currentAccountId = accountId;
            currentYear = year;
            currentMonth = month.toString().padStart(2, '0'); // Asegurar "03" en vez de "3"
            currentType = type;

            const lista = document.getElementById('lista-transacciones');
            lista.innerHTML = '';
            resetFormulario();

            const filteredTx = transacciones.filter(tx => {
                if (type === 'deposit') return (tx.type === 'deposit' || tx.type === 'interest');
                if (type === 'withdrawal') return tx.type === 'withdrawal';
                return false;
            });

            if (filteredTx.length === 0) {
                lista.innerHTML = '<p class="text-sm text-gray-400 italic text-center">No hay movimientos registrados en este mes.</p>';
            } else {
                filteredTx.forEach(tx => {
                    const item = document.createElement('div');
                    item.className = 'flex justify-between items-center bg-white p-3 rounded border border-gray-100 shadow-sm hover:shadow-md transition';

                    const fecha = new Date(tx.date).toLocaleDateString('es-DO', { year: 'numeric', month: '2-digit', day: '2-digit' });

                    item.innerHTML = `
                        <div>
                            <p class="font-bold text-gray-800">RD$ ${parseFloat(tx.amount).toFixed(2)}</p>
                            <p class="text-xs text-gray-500">${fecha} - ${tx.description || 'Sin comentario'}</p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick='editarTx(${JSON.stringify(tx)})' class="text-blue-600 hover:text-blue-800 text-xs font-bold border border-blue-200 px-2 py-1 rounded">Editar</button>

                            <form action="/admin/ahorros/transaccion/${tx.id}?socio_id=${socioId}&anio_ahorro=${currentYear}#seccion-ahorros" method="POST" onsubmit="return confirm('¿Eliminar este registro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-bold border border-red-200 px-2 py-1 rounded">X</button>
                            </form>
                        </div>
                    `;
                    lista.appendChild(item);
                });
            }

            resetFormulario();
            document.getElementById('modal-gestor').classList.remove('hidden');
        }

        function editarTx(tx) {
            document.getElementById('form-titulo').innerText = '✏️ Editar Movimiento Existente';
            document.getElementById('form-titulo').className = 'text-sm font-bold text-blue-600 mb-3 uppercase';

            document.getElementById('input-date').value = tx.date.split('T')[0];
            document.getElementById('input-amount').value = tx.amount;
            document.getElementById('input-desc').value = tx.description;

            const form = document.getElementById('form-transaccion');

            const txDate = new Date(tx.date);
            const txYear = txDate.getFullYear();

            form.action = `/admin/ahorros/transaccion/${tx.id}?socio_id=${socioId}&anio_ahorro=${txYear}#seccion-ahorros`;
            document.getElementById('form-method').value = 'PUT';

            document.getElementById('btn-cancelar-edit').classList.remove('hidden');
        }

        function resetFormulario() {
            document.getElementById('form-titulo').innerText = '➕ Agregar Nuevo Movimiento';
            document.getElementById('form-titulo').className = 'text-sm font-bold text-gray-700 mb-3 uppercase';

            document.getElementById('input-amount').value = '';
            document.getElementById('input-desc').value = '';

            const defaultDate = `${currentYear}-${currentMonth}-15`;
            document.getElementById('input-date').value = defaultDate;

            document.getElementById('input-account-id').value = currentAccountId;
            document.getElementById('input-type').value = currentType;

            const form = document.getElementById('form-transaccion');

            const storeUrl = `{{ route('admin.ahorros.transaction.store') }}?socio_id=${socioId}&anio_ahorro=${currentYear}#seccion-ahorros`;
            form.action = storeUrl;

            document.getElementById('form-method').value = 'POST';

            document.getElementById('btn-cancelar-edit').classList.add('hidden');
        }

        function cerrarGestor() {
            document.getElementById('modal-gestor').classList.add('hidden');
        }
    </script>
</x-app-layout>
