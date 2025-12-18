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

            {{-- SECCIÓN SUPERIOR: MOTOR DE RIESGO Y REGLAS DE ORO --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Salario Mensual</span>
                    <p class="text-xl font-black text-gray-800 font-mono">RD$ {{ number_format($salario, 2) }}</p>
                </div>

                @php
                    $sobreEndeudado = $totalDeuda > $maximoCredito;
                @endphp
                <div class="bg-white p-4 rounded-lg shadow border-l-4 {{ $sobreEndeudado ? 'border-red-600 bg-red-50' : 'border-indigo-500' }}">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Límite Crédito (1.5x Ahorros)</span>
                    <p class="text-xl font-black {{ $sobreEndeudado ? 'text-red-700' : 'text-indigo-700' }} font-mono">RD$ {{ number_format($maximoCredito, 2) }}</p>
                    <p class="text-[9px] {{ $sobreEndeudado ? 'text-red-500 font-bold animate-pulse' : 'text-gray-400' }}">
                        {{ $sobreEndeudado ? '⚠️ EXCEDE LÍMITE GARANTÍA' : 'Cupo total por ahorros' }}
                    </p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-purple-500">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Límite Descuento (40%)</span>
                    <p class="text-xl font-black text-purple-700 font-mono">RD$ {{ number_format($limiteMensual, 2) }}</p>
                    <p class="text-[9px] text-gray-400">Máximo deducible mensual</p>
                </div>

                @php
                    $porcentajeUso = $limiteMensual > 0 ? ($compromisosActuales / $limiteMensual) * 100 : 0;
                    $colorSemaforo = 'text-green-600';
                    $borderSemaforo = 'border-green-500';
                    $bgBarra = 'bg-green-500';

                    if($porcentajeUso >= 100) {
                        $colorSemaforo = 'text-red-700';
                        $borderSemaforo = 'border-red-700';
                        $bgBarra = 'bg-red-700';
                    } elseif($porcentajeUso >= 80) {
                        $colorSemaforo = 'text-red-500';
                        $borderSemaforo = 'border-red-500';
                        $bgBarra = 'bg-red-500';
                    } elseif($porcentajeUso >= 50) {
                        $colorSemaforo = 'text-yellow-600';
                        $borderSemaforo = 'border-yellow-500';
                        $bgBarra = 'bg-yellow-500';
                    }
                @endphp
                <div class="bg-white p-4 rounded-lg shadow border-l-4 {{ $borderSemaforo }}">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Disponible en Nómina</span>
                    <p class="text-xl font-black {{ $colorSemaforo }} font-mono">RD$ {{ number_format($capacidadDisponible, 2) }}</p>
                    <div class="mt-2 flex items-center gap-2">
                        <div class="w-full bg-gray-100 rounded-full h-1.5 border border-gray-200">
                            <div class="h-1.5 rounded-full {{ $bgBarra }} transition-all duration-700" style="width: {{ min($porcentajeUso, 100) }}%"></div>
                        </div>
                        <span class="text-[10px] font-bold text-gray-500">{{ round($porcentajeUso) }}%</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- COLUMNA IZQUIERDA: INFORMACIÓN BÁSICA --}}
                <div class="md:col-span-1">
                    <div class="bg-white shadow rounded-lg p-6 border border-gray-100 text-center md:text-left">
                        <div class="flex flex-col items-center">
                            <div class="h-24 w-24 bg-indigo-100 rounded-full flex items-center justify-center text-3xl font-bold text-indigo-600 mb-4 border-2 border-indigo-200">
                                {{ substr($socio->nombres, 0, 1) }}
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $socio->nombres }} {{ $socio->apellidos }}</h3>
                            <p class="text-gray-500 text-sm italic">{{ $socio->user->email ?? 'Sin correo' }}</p>
                        </div>
                        <hr class="my-4 border-gray-100">
                        <div class="text-sm space-y-3">
                            <div class="flex justify-between border-b border-gray-50 pb-1">
                                <span class="text-gray-500 font-medium italic">Cédula:</span>
                                <span class="text-gray-800 font-bold">{{ $socio->cedula }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-50 pb-1">
                                <span class="text-gray-500 font-medium italic">Teléfono:</span>
                                <span class="text-gray-800 font-bold">{{ $socio->telefono ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-50 pb-1">
                                <span class="text-gray-500 font-medium italic">Tipo Contrato:</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] bg-blue-100 text-blue-700 font-black uppercase">{{ $socio->tipo_contrato }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-gray-500 font-medium italic">Dirección:</span>
                                <span class="text-gray-800 font-bold leading-tight">{{ $socio->direccion ?? 'No registrada' }}</span>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <h4 class="font-black text-gray-400 mb-4 border-b pb-1 uppercase text-[10px] tracking-widest text-center">Balances Globales</h4>
                            <div class="bg-red-50 p-4 rounded-xl mb-3 border border-red-100 shadow-sm shadow-red-50">
                                <span class="block text-[10px] text-red-600 uppercase font-black tracking-widest mb-1 text-center">Préstamos Pendientes</span>
                                <span class="block text-2xl font-black text-red-800 font-mono text-center leading-none">RD$ {{ number_format($totalDeuda, 2) }}</span>
                            </div>
                            <div class="bg-green-50 p-4 rounded-xl border border-green-100 shadow-sm shadow-green-50">
                                <span class="block text-[10px] text-green-600 uppercase font-black tracking-widest mb-1 text-center">Patrimonio Ahorrado</span>
                                <span class="block text-2xl font-black text-green-800 font-mono text-center leading-none">RD$ {{ number_format($totalAhorradoGlobal ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- COLUMNA DERECHA: DESGLOSE DE DESCUENTOS Y OPERACIONES --}}
                <div class="md:col-span-2 space-y-6">

                    {{-- DETALLE DE DESCUENTOS DE NÓMINA (CORREGIDO Y DESGLOSADO) --}}
                    <div class="bg-gray-900 text-white p-6 rounded-2xl shadow-xl overflow-hidden relative">
                        <div class="absolute top-0 right-0 p-4 opacity-10 text-6xl">📝</div>

                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                            <div>
                                <h3 class="text-lg font-black text-white flex items-center gap-2 uppercase tracking-wide">
                                    <span class="p-1 bg-orange-500 rounded text-xs">📊</span> Proyección de Descuentos
                                </h3>
                                <p class="text-[11px] text-gray-400 italic">Desglose detallado de deducciones automáticas.</p>
                            </div>
                            <div class="text-right mt-3 md:mt-0">
                                <span class="text-3xl font-black text-orange-400 font-mono">RD$ {{ number_format($compromisosActuales, 2) }}</span>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-tighter">Total a Descontar</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-gray-800 pt-4">

                            {{-- Bloque: Ahorro Normal --}}
                            <div class="bg-gray-800/50 p-3 rounded-lg border border-gray-700">
                                <span class="block text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1 italic">Ahorro Normal</span>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-lg font-bold text-white font-mono">RD$ {{ number_format($cuentaAportacion->recurring_amount, 2) }}</span>
                                </div>
                                <p class="text-[9px] text-green-500 font-bold uppercase mt-1">Patrimonio (AP)</p>
                            </div>

                            {{-- Bloque: Ahorro Retirable --}}
                            <div class="bg-gray-800/50 p-3 rounded-lg border border-gray-700 {{ $cuentaVoluntario->recurring_amount <= 0 ? 'opacity-40' : '' }}">
                                <span class="block text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1 italic">Ahorro Retirable</span>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-lg font-bold text-white font-mono">RD$ {{ number_format($cuentaVoluntario->recurring_amount, 2) }}</span>
                                </div>
                                <p class="text-[9px] text-yellow-500 font-bold uppercase mt-1">Disponible (RT)</p>
                            </div>

                            {{-- Bloque: Préstamos --}}
                            @php
                                $cuotasPrestamosCalculadas = $compromisosActuales - ($cuentaAportacion->recurring_amount + $cuentaVoluntario->recurring_amount);
                            @endphp
                            <div class="bg-gray-800/50 p-3 rounded-lg border border-gray-700">
                                <span class="block text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1 italic">Cuotas Préstamos</span>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-lg font-bold text-red-400 font-mono">RD$ {{ number_format($cuotasPrestamosCalculadas, 2) }}</span>
                                </div>
                                <p class="text-[9px] text-red-500/70 font-bold uppercase mt-1">Amortización</p>
                            </div>
                        </div>

                        @if($porcentajeUso > 100)
                        <div class="mt-4 bg-red-900/50 border border-red-700 p-3 rounded-lg flex items-center gap-3">
                            <span class="text-2xl animate-bounce">🚨</span>
                            <p class="text-xs font-bold text-red-200 uppercase tracking-tighter">
                                ¡Peligro! El socio ha superado el límite del 40% de descuento.
                            </p>
                        </div>
                        @endif
                    </div>

                    {{-- TABLA DE PRÉSTAMOS ACTIVOS --}}
                    <div class="bg-white shadow-sm rounded-2xl p-6 border border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-black text-gray-800 flex items-center gap-2">
                                <span class="p-1 bg-blue-100 rounded text-xs text-blue-600">📂</span> Préstamos Vigentes
                            </h3>
                            <a href="{{ route('admin.prestamos.create') }}?user_id={{ $socio->user_id }}" class="text-xs bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 font-black shadow-lg shadow-indigo-100 transition-all uppercase tracking-widest">
                                + Nuevo Crédito
                            </a>
                        </div>

                        @if($prestamosActivos->isEmpty())
                            <div class="text-center py-10 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                                <div class="text-4xl mb-2">✅</div>
                                <p class="text-gray-500 font-bold uppercase text-xs tracking-widest">Sin Deudas Pendientes</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead>
                                        <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                            <th class="px-4 py-3 text-left">Referencia</th>
                                            <th class="px-4 py-3 text-left">F. Inicio</th>
                                            <th class="px-4 py-3 text-left">Tipo</th>
                                            <th class="px-4 py-3 text-right">Monto</th>
                                            <th class="px-4 py-3 text-right">Saldo Restante</th>
                                            <th class="px-4 py-3 text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($prestamosActivos as $prestamo)
                                        <tr class="hover:bg-indigo-50/30 transition group">
                                            <td class="px-4 py-4">
                                                <span class="font-black text-gray-700 block text-xs">#{{ $prestamo->numero_prestamo }}</span>
                                            </td>
                                            <td class="px-4 py-4 text-xs font-bold text-gray-500">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-4">
                                                <span class="px-2 py-1 rounded-lg text-[9px] font-black bg-gray-100 text-gray-600 uppercase tracking-tighter">
                                                    {{ $prestamo->tipoPrestamo->nombre ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 text-right font-black text-gray-700 text-xs font-mono">RD$ {{ number_format($prestamo->monto, 2) }}</td>
                                            <td class="px-4 py-4 text-right font-black text-red-600 text-xs font-mono">RD$ {{ number_format($prestamo->saldo_capital, 2) }}</td>
                                            <td class="px-4 py-4">
                                                <div class="flex justify-center gap-1">
                                                    <a href="{{ route('admin.prestamos.show', $prestamo->id) }}" class="p-1.5 bg-white border border-gray-200 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm" title="Ver Amortización">📑</a>
                                                    <a href="{{ route('admin.pagos.create', $prestamo->id) }}" class="p-1.5 bg-white border border-gray-200 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition shadow-sm" title="Registrar Pago">💵</a>
                                                    <a href="{{ route('admin.prestamos.edit', $prestamo->id) }}" class="p-1.5 bg-white border border-gray-200 text-yellow-600 rounded-lg hover:bg-yellow-600 hover:text-white transition shadow-sm" title="Editar">✏️</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @if($prestamosInactivos->isNotEmpty())
                            <div class="mt-6 border-t border-gray-50 pt-4">
                                <a href="{{ route('admin.socios.historial.prestamos', $socio->id) }}" class="flex items-center justify-center gap-2 w-full text-[11px] font-black text-gray-400 hover:text-indigo-600 transition uppercase tracking-widest">
                                    🔍 Historial de Créditos Pagados ({{ $prestamosInactivos->count() }})
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- HISTÓRICO DE AHORROS --}}
                    <div class="bg-white shadow-sm rounded-2xl p-6 border border-gray-100" id="seccion-ahorros">
                        <div class="flex flex-col md:flex-row justify-between items-center mb-8 border-b border-gray-50 pb-4">
                            <div>
                                <h3 class="text-lg font-black text-gray-800 flex items-center gap-2 uppercase tracking-wide">
                                    <span class="p-1 bg-yellow-100 rounded text-xs text-yellow-600">🏦</span> Control de Ahorros
                                </h3>
                            </div>
                            <form action="{{ route('admin.socios.show', $socio->id) }}#seccion-ahorros" method="GET" class="flex items-center gap-3 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-200">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Ver Año:</label>
                                <select name="anio_ahorro" onchange="this.form.submit()" class="border-none bg-transparent rounded py-0 font-black text-indigo-600 text-sm focus:ring-0 cursor-pointer">
                                    @foreach($aniosDisponibles as $anio)
                                        <option value="{{ $anio }}" {{ ($anioSeleccionado == $anio) ? 'selected' : '' }}>{{ $anio }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            {{-- APORTACIÓN --}}
                            <div class="border border-blue-100 rounded-2xl bg-blue-50/30 overflow-hidden shadow-sm">
                                <div class="p-4 border-b border-blue-100 bg-blue-50 flex justify-between items-center">
                                    <h4 class="font-black text-blue-900 text-xs uppercase tracking-widest">Aportación</h4>
                                    <div class="flex items-center gap-3">
                                        <span class="text-[10px] font-black text-blue-700 bg-white px-2 py-1 rounded-lg border border-blue-200 font-mono italic">Cuota: RD$ {{ number_format($cuentaAportacion->recurring_amount, 0) }}</span>
                                        <button onclick="abrirModalCuota('{{ $cuentaAportacion->id }}', '{{ $cuentaAportacion->recurring_amount }}', 'Aportación')" class="text-blue-500 hover:scale-125 transition">✏️</button>
                                    </div>
                                </div>
                                <div class="bg-white">
                                    <table class="min-w-full text-xs">
                                        <thead class="bg-gray-50 border-b border-gray-100 font-black text-[9px] text-gray-400 uppercase">
                                            <tr><th class="px-4 py-2 text-left tracking-tighter">Mes</th><th class="px-4 py-2 text-right">Aporte</th><th class="px-4 py-2 text-right text-red-400 italic">Retiro</th></tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            @foreach($matrizAportacion as $mesNum => $data)
                                            <tr class="hover:bg-blue-50 transition">
                                                <td class="px-4 py-2 font-black text-gray-400 uppercase text-[10px]">{{ \Carbon\Carbon::create()->month($mesNum)->locale('es')->monthName }}</td>
                                                <td class="px-4 py-2 text-right">
                                                    <button onclick='gestionarMes(@json($data["transacciones"]), "{{ $cuentaAportacion->id }}", "{{ $anioSeleccionado }}", "{{ $mesNum }}", "deposit")' class="w-full text-right font-black text-green-700 font-mono hover:underline">
                                                        {{ $data['aporte'] > 0 ? number_format($data['aporte'], 2) : '-' }}
                                                    </button>
                                                </td>
                                                <td class="px-4 py-2 text-right font-bold text-red-400 font-mono">
                                                    <button onclick='gestionarMes(@json($data["transacciones"]), "{{ $cuentaAportacion->id }}", "{{ $anioSeleccionado }}", "{{ $mesNum }}", "withdrawal")' class="w-full text-right hover:underline italic opacity-50 hover:opacity-100 transition">
                                                        {{ $data['retiro'] > 0 ? number_format($data['retiro'], 2) : '-' }}
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- RETIRABLE --}}
                            <div class="border border-yellow-100 rounded-2xl bg-yellow-50/30 overflow-hidden shadow-sm">
                                <div class="p-4 border-b border-yellow-100 bg-yellow-50 flex justify-between items-center">
                                    <h4 class="font-black text-yellow-900 text-xs uppercase tracking-widest">Retirable</h4>
                                    <div class="flex items-center gap-3">
                                        <span class="text-[10px] font-black text-yellow-700 bg-white px-2 py-1 rounded-lg border border-yellow-200 font-mono italic">Cuota: RD$ {{ number_format($cuentaVoluntario->recurring_amount, 0) }}</span>
                                        <button onclick="abrirModalCuota('{{ $cuentaVoluntario->id }}', '{{ $cuentaVoluntario->recurring_amount }}', 'Retirable')" class="text-yellow-600 hover:scale-125 transition">✏️</button>
                                    </div>
                                </div>
                                <div class="bg-white">
                                    <table class="min-w-full text-xs">
                                        <thead class="bg-gray-50 border-b border-gray-100 font-black text-[9px] text-gray-400 uppercase">
                                            <tr><th class="px-4 py-2 text-left tracking-tighter">Mes</th><th class="px-4 py-2 text-right">Aporte</th><th class="px-4 py-2 text-right text-red-400 italic">Retiro</th></tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            @foreach($matrizVoluntario as $mesNum => $data)
                                            <tr class="hover:bg-yellow-50 transition">
                                                <td class="px-4 py-2 font-black text-gray-400 uppercase text-[10px]">{{ \Carbon\Carbon::create()->month($mesNum)->locale('es')->monthName }}</td>
                                                <td class="px-4 py-2 text-right">
                                                    <button onclick='gestionarMes(@json($data["transacciones"]), "{{ $cuentaVoluntario->id }}", "{{ $anioSeleccionado }}", "{{ $mesNum }}", "deposit")' class="w-full text-right font-black text-green-700 font-mono hover:underline">
                                                        {{ $data['aporte'] > 0 ? number_format($data['aporte'], 2) : '-' }}
                                                    </button>
                                                </td>
                                                <td class="px-4 py-2 text-right font-bold text-red-400 font-mono">
                                                    <button onclick='gestionarMes(@json($data["transacciones"]), "{{ $cuentaVoluntario->id }}", "{{ $anioSeleccionado }}", "{{ $mesNum }}", "withdrawal")' class="w-full text-right hover:underline italic opacity-50 hover:opacity-100 transition">
                                                        {{ $data['retiro'] > 0 ? number_format($data['retiro'], 2) : '-' }}
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
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

    {{-- MODALES Y SCRIPTS (IGUAL QUE TU ARCHIVO ORIGINAL) --}}
    <div id="modal-cuota" class="fixed inset-0 bg-gray-900 bg-opacity-80 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl w-96 p-8">
            <h3 class="text-xl font-black text-gray-800 mb-6 flex items-center gap-2 uppercase tracking-wide border-b pb-3" id="modal-titulo-texto">Editar Cuota</h3>
            <form id="form-cuota" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-8">
                    <label class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-3 italic">Monto de Descuento Mensual:</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-gray-400">RD$</span>
                        <input type="number" step="0.01" name="recurring_amount" id="modal-input-monto" class="w-full pl-12 pr-4 py-4 bg-gray-50 border-none rounded-2xl font-black text-xl text-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all outline-none" placeholder="0.00">
                    </div>
                </div>
                <div class="flex flex-col gap-3 font-black uppercase tracking-widest text-xs">
                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all transform hover:-translate-y-1 active:scale-95">💾 Guardar Cambios</button>
                    <button type="button" onclick="cerrarModalCuota()" class="w-full py-4 bg-gray-50 text-gray-400 rounded-2xl hover:bg-gray-100 transition-all">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-gestor" class="fixed inset-0 bg-gray-900 bg-opacity-80 hidden z-50 flex items-center justify-center backdrop-blur-md">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl p-8 mx-4 overflow-hidden relative border border-gray-100">
            <div class="flex justify-between items-center mb-8 border-b border-gray-50 pb-4">
                <div>
                    <h3 class="text-2xl font-black text-gray-800 uppercase tracking-tighter">Gestión de Movimientos</h3>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Edición de registros históricos</p>
                </div>
                <button onclick="cerrarGestor()" class="w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-400 hover:text-red-500 rounded-2xl hover:bg-red-50 transition-all text-2xl font-black">&times;</button>
            </div>
            <div id="lista-transacciones" class="mb-8 space-y-4 max-h-56 overflow-y-auto pr-2 custom-scrollbar border-b border-dashed border-gray-100 pb-6"></div>
            <div class="bg-indigo-50/50 p-6 rounded-[2rem] border border-indigo-100 shadow-inner">
                <h4 class="text-[11px] font-black text-indigo-400 mb-4 uppercase tracking-[0.2em] italic" id="form-titulo">➕ Registrar Nueva Transacción</h4>
                <form id="form-transaccion" method="POST" action="{{ route('admin.ahorros.transaction.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    <input type="hidden" name="savings_account_id" id="input-account-id">
                    <input type="hidden" name="type" id="input-type">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Fecha Valor</label>
                            <input type="date" name="date" id="input-date" required class="w-full bg-white border-none rounded-xl py-3 px-4 font-black text-gray-700 shadow-sm focus:ring-4 focus:ring-indigo-100 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Importe RD$</label>
                            <input type="number" step="0.01" name="amount" id="input-amount" required class="w-full bg-white border-none rounded-xl py-3 px-4 font-black text-green-700 shadow-sm focus:ring-4 focus:ring-green-100 outline-none transition text-lg" placeholder="0.00">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Descripción del Movimiento</label>
                            <input type="text" name="description" id="input-desc" placeholder="Ej: Pago de nómina extra..." class="w-full bg-white border-none rounded-xl py-3 px-4 font-bold text-gray-700 shadow-sm focus:ring-4 focus:ring-indigo-100 outline-none transition">
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-8 font-black uppercase text-[10px] tracking-widest">
                        <button type="button" onclick="resetFormulario()" id="btn-cancelar-edit" class="hidden px-6 py-4 bg-gray-100 text-gray-400 rounded-2xl hover:bg-gray-200 transition">Cancelar Edición</button>
                        <button type="submit" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all transform hover:-translate-y-1">💾 Procesar Movimiento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentAccountId = null, currentYear = null, currentMonth = null, currentType = null;
        const socioId = '{{ $socio->id }}';

        function abrirModalCuota(id, monto, nombre) {
            document.getElementById('modal-titulo-texto').innerText = 'Editar: ' + nombre;
            document.getElementById('modal-input-monto').value = monto;
            document.getElementById('form-cuota').action = "/admin/cuentas/update-cuota/" + id;
            document.getElementById('modal-cuota').classList.remove('hidden');
        }
        function cerrarModalCuota() { document.getElementById('modal-cuota').classList.add('hidden'); }

        function gestionarMes(transacciones, accountId, year, month, type) {
            currentAccountId = accountId; currentYear = year; currentMonth = month.toString().padStart(2, '0'); currentType = type;
            const lista = document.getElementById('lista-transacciones'); lista.innerHTML = '';
            const filteredTx = transacciones.filter(tx => (type === 'deposit' ? (tx.type === 'deposit' || tx.type === 'interest') : tx.type === 'withdrawal'));

            if (filteredTx.length === 0) {
                lista.innerHTML = '<div class="text-center py-6 border-2 border-dashed border-gray-50 rounded-2xl"><p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">Sin movimientos</p></div>';
            } else {
                filteredTx.forEach(tx => {
                    const item = document.createElement('div');
                    item.className = 'flex justify-between items-center bg-gray-50 p-4 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-gray-100 transition-all group';
                    item.innerHTML = `<div><p class="font-black text-gray-800 text-lg font-mono">RD$ ${parseFloat(tx.amount).toFixed(2)}</p><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">${tx.date.split('T')[0]} • ${tx.description || 'SIN DETALLE'}</p></div>
                                      <div class="flex gap-2">
                                        <button onclick='editarTx(${JSON.stringify(tx)})' class="w-8 h-8 flex items-center justify-center bg-white border border-gray-200 text-blue-500 rounded-xl hover:bg-blue-500 hover:text-white transition">✏️</button>
                                        <form action="/admin/ahorros/transaccion/${tx.id}?socio_id=${socioId}&anio_ahorro=${currentYear}" method="POST" onsubmit="return confirm('¿Eliminar registro permanente?')">@csrf @method('DELETE')<button type="submit" class="w-8 h-8 flex items-center justify-center bg-white border border-gray-200 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition">&times;</button></form>
                                      </div>`;
                    lista.appendChild(item);
                });
            }
            resetFormulario();
            document.getElementById('modal-gestor').classList.remove('hidden');
        }

        function editarTx(tx) {
            document.getElementById('form-titulo').innerText = '✏️ Editando Registro Existente';
            document.getElementById('form-titulo').className = 'text-[11px] font-black text-orange-500 mb-4 uppercase tracking-[0.2em] italic';
            document.getElementById('input-date').value = tx.date.split('T')[0];
            document.getElementById('input-amount').value = tx.amount;
            document.getElementById('input-desc').value = tx.description;
            document.getElementById('form-transaccion').action = `/admin/ahorros/transaccion/${tx.id}?socio_id=${socioId}&anio_ahorro=${currentYear}#seccion-ahorros`;
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('btn-cancelar-edit').classList.remove('hidden');
        }

        function resetFormulario() {
            document.getElementById('form-titulo').innerText = '➕ Registrar Nueva Transacción';
            document.getElementById('form-titulo').className = 'text-[11px] font-black text-indigo-400 mb-4 uppercase tracking-[0.2em] italic';
            document.getElementById('input-amount').value = '';
            document.getElementById('input-desc').value = '';
            document.getElementById('input-date').value = `${currentYear}-${currentMonth}-15`;
            document.getElementById('input-account-id').value = currentAccountId;
            document.getElementById('input-type').value = currentType;
            document.getElementById('form-transaccion').action = `{{ route('admin.ahorros.transaction.store') }}?socio_id=${socioId}&anio_ahorro=${currentYear}#seccion-ahorros`;
            document.getElementById('form-method').value = 'POST';
            document.getElementById('btn-cancelar-edit').classList.add('hidden');
        }

        function cerrarGestor() { document.getElementById('modal-gestor').classList.add('hidden'); }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 20px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e0; }
        input[type="number"]::-webkit-inner-spin-button, input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</x-app-layout>
