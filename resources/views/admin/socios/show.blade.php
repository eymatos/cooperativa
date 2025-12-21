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

    {{-- Iniciamos x-data con la variable openEdit --}}
    <div class="py-12" x-data="{ openEdit: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SECCIÓN SUPERIOR: MOTOR DE RIESGO (7 CASILLAS UNIFICADAS) --}}
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-7 gap-3 mb-8">

                {{-- 1. BASE: SALARIO --}}
                <div class="bg-white p-3 rounded-lg shadow border-l-4 border-blue-600">
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Salario Mensual</span>
                    <p class="text-base font-black text-gray-800 font-mono">RD$ {{ number_format($salario, 2) }}</p>
                    <p class="text-[8px] text-blue-500 font-bold uppercase italic">Sueldo Bruto</p>
                </div>

                {{-- REGLAMENTO 1: GARANTÍA (AHORROS x 1.5) --}}
                <div class="bg-white p-3 rounded-lg shadow border-l-4 border-gray-400">
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Límite 1.5x</span>
                    <p class="text-base font-black text-gray-600 font-mono">RD$ {{ number_format($limiteGarantiaTotal, 2) }}</p>
                    <p class="text-[8px] text-gray-400 uppercase">Potencial Máximo</p>
                </div>

                <div class="bg-white p-3 rounded-lg shadow border-l-4 border-red-500">
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Garantía Uso</span>
                    <p class="text-base font-black text-red-600 font-mono">RD$ {{ number_format($totalDeuda, 2) }}</p>
                    <p class="text-[8px] text-red-400 font-bold uppercase">Deuda Actual</p>
                </div>

                @php $criticoG = $cupoGarantiaDisponible <= 0; @endphp
                <div class="bg-white p-3 rounded-lg shadow border-l-4 {{ $criticoG ? 'border-orange-600 bg-orange-50' : 'border-indigo-500' }}">
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Cupo Préstamo</span>
                    <p class="text-base font-black {{ $criticoG ? 'text-orange-700' : 'text-indigo-700' }} font-mono">RD$ {{ number_format($cupoGarantiaDisponible, 2) }}</p>
                    <p class="text-[8px] {{ $criticoG ? 'text-orange-600 font-bold animate-pulse' : 'text-gray-400 uppercase' }}">
                        {{ $criticoG ? '⚠️ SIN CUPO' : 'Garantía Libre' }}
                    </p>
                </div>

                {{-- REGLAMENTO 2: CAPACIDAD DE PAGO (40% SALARIO) --}}
                <div class="bg-white p-3 rounded-lg shadow border-l-4 border-purple-500">
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Límite 40%</span>
                    <p class="text-base font-black text-purple-700 font-mono">RD$ {{ number_format($limiteMensual, 2) }}</p>
                    <p class="text-[8px] text-gray-400 uppercase">Deducción Máx.</p>
                </div>

                <div class="bg-white p-3 rounded-lg shadow border-l-4 border-blue-400">
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Dcto. Actual</span>
                    <p class="text-base font-black text-blue-600 font-mono">RD$ {{ number_format($compromisosActuales, 2) }}</p>
                    <p class="text-[8px] text-blue-400 font-bold uppercase">Nómina Hoy</p>
                </div>

                @php
                    $porcentajeUso = $limiteMensual > 0 ? ($compromisosActuales / $limiteMensual) * 100 : 0;
                    $criticoN = $capacidadDisponible <= 0;
                    $bgBarra = $porcentajeUso >= 100 ? 'bg-red-700' : ($porcentajeUso >= 80 ? 'bg-red-500' : ($porcentajeUso >= 50 ? 'bg-yellow-500' : 'bg-green-500'));
                @endphp
                <div class="bg-white p-3 rounded-lg shadow border-l-4 {{ $criticoN ? 'border-red-600 bg-red-50' : 'border-green-500' }}">
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Libre Nómina</span>
                    <p class="text-base font-black {{ $criticoN ? 'text-red-700' : 'text-green-700' }} font-mono">RD$ {{ number_format($capacidadDisponible, 2) }}</p>
                    <div class="mt-1 flex items-center gap-1">
                        <div class="w-full bg-gray-100 rounded-full h-1 border border-gray-200 overflow-hidden">
                            <div class="h-1 rounded-full {{ $bgBarra }} transition-all duration-700" style="width: {{ min($porcentajeUso, 100) }}%"></div>
                        </div>
                        <span class="text-[8px] font-bold text-gray-500">{{ round($porcentajeUso) }}%</span>
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
                            <p class="text-gray-500 text-sm italic mb-2">{{ $socio->user->email ?? 'Sin correo' }}</p>

                            {{-- BOTÓN EDITAR PERFIL --}}
                            <button @click="openEdit = true" class="text-[10px] bg-indigo-50 text-indigo-600 px-4 py-1.5 rounded-full font-black uppercase hover:bg-indigo-600 hover:text-white transition-all tracking-widest shadow-sm border border-indigo-100">
                                <i class="fa-solid fa-user-pen mr-1"></i> Editar Perfil / Salario
                            </button>
                        </div>
                        <hr class="my-4 border-gray-100">
                        <div class="text-sm space-y-3">
                            <div class="flex justify-between border-b border-gray-50 pb-1">
                                <span class="text-gray-500 font-medium italic">Cédula:</span>
                                <span class="text-gray-800 font-bold">{{ $socio->user->cedula }}</span>
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
                            <div class="bg-red-50 p-4 rounded-xl mb-3 border border-red-100 shadow-sm shadow-red-50 text-center">
                                <span class="block text-[10px] text-red-600 uppercase font-black tracking-widest mb-1">Préstamos Pendientes</span>
                                <span class="block text-2xl font-black text-red-800 font-mono leading-none">RD$ {{ number_format($totalDeuda, 2) }}</span>
                            </div>
                            <div class="bg-green-50 p-4 rounded-xl border border-green-100 shadow-sm shadow-green-50 text-center">
                                <span class="block text-[10px] text-green-600 uppercase font-black tracking-widest mb-1">Patrimonio Ahorrado</span>
                                <span class="block text-2xl font-black text-green-800 font-mono leading-none">RD$ {{ number_format($totalAportaciones + $totalRetirable, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- COLUMNA DERECHA: DESGLOSE DE DESCUENTOS Y OPERACIONES --}}
                <div class="md:col-span-2 space-y-6">

                    {{-- DETALLE DE DESCUENTOS DE NÓMINA --}}
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
                            <div class="bg-gray-800/50 p-3 rounded-lg border border-gray-700 text-center">
                                <span class="block text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1 italic">Ahorro Normal</span>
                                <span class="text-lg font-bold text-white font-mono">RD$ {{ number_format($socio->cuentas->firstWhere('saving_type_id', 1)->recurring_amount ?? 0, 2) }}</span>
                            </div>

                            <div class="bg-gray-800/50 p-3 rounded-lg border border-gray-700 text-center {{ $cuentaVoluntario->recurring_amount <= 0 ? 'opacity-40' : '' }}">
                                <span class="block text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1 italic">Ahorro Retirable</span>
                                <span class="text-lg font-bold text-white font-mono">RD$ {{ number_format($socio->cuentas->firstWhere('saving_type_id', 2)->recurring_amount ?? 0, 2) }}</span>
                            </div>

                            @php
                                $cuotasPrestamosCalculadas = $compromisosActuales - ($cuentaAportacion->recurring_amount + $cuentaVoluntario->recurring_amount);
                            @endphp
                            <div class="bg-gray-800/50 p-3 rounded-lg border border-gray-700 text-center">
                                <span class="block text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1 italic">Cuotas Préstamos</span>
                                <span class="text-lg font-bold text-red-400 font-mono">RD$ {{ number_format($cuotasPrestamosCalculadas, 2) }}</span>
                            </div>
                        </div>
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
                                            <td class="px-4 py-4 text-right font-black text-gray-700 text-xs font-mono">RD$ {{ number_format($prestamo->monto, 2) }}</td>
                                            <td class="px-4 py-4 text-right font-black text-red-600 text-xs font-mono">RD$ {{ number_format($prestamo->saldo_capital, 2) }}</td>
                                            <td class="px-4 py-4 text-center">
                                                <div class="flex justify-center gap-1">
                                                    <a href="{{ route('admin.prestamos.show', $prestamo->id) }}" class="p-1.5 bg-white border border-gray-200 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm" title="Ver Amortización">📑</a>
                                                    <a href="{{ route('admin.pagos.create', $prestamo->id) }}" class="p-1.5 bg-white border border-gray-200 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition shadow-sm" title="Registrar Pago">💵</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    {{-- BLOQUE NUEVO: HISTORIAL DE PRÉSTAMOS (REENGANCHES Y PAGADOS) --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-black text-gray-400 uppercase tracking-tighter flex items-center gap-2 italic">
                                <span class="p-1 bg-gray-50 rounded text-xs text-gray-400">✓</span> Historial de Préstamos
                            </h3>
                        </div>

                        @if($prestamosInactivos->isEmpty())
                            <p class="text-center py-6 text-gray-400 text-[10px] italic uppercase font-bold tracking-widest border-2 border-dashed border-gray-50 rounded-2xl">No hay registros de préstamos anteriores.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left italic border-separate border-spacing-y-2">
                                    <thead>
                                        <tr class="text-[9px] font-black text-gray-400 uppercase tracking-widest">
                                            <th class="px-4 py-2">Tipo / Referencia</th>
                                            <th class="px-4 py-2 text-right">Monto Original</th>
                                            <th class="px-4 py-2 text-center">Estado</th>
                                            <th class="px-4 py-2 text-right">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($prestamosInactivos as $pi)
                                            <tr class="bg-gray-50/50 hover:bg-white transition-all">
                                                <td class="px-4 py-3 rounded-l-xl">
                                                    <p class="text-[11px] font-black text-gray-700 uppercase leading-none mb-1">{{ $pi->tipoPrestamo->nombre ?? 'Crédito' }}</p>
                                                    <p class="text-[9px] font-bold text-gray-400 font-mono italic">#{{ $pi->numero_prestamo }}</p>
                                                </td>
                                                <td class="px-4 py-3 text-right font-mono font-bold text-gray-600 text-[11px]">
                                                    RD$ {{ number_format($pi->monto, 2) }}
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="text-[8px] font-black bg-green-100 text-green-600 px-2 py-0.5 rounded-full border border-green-200 uppercase">Saldado</span>
                                                </td>
                                                <td class="px-4 py-3 text-right rounded-r-xl">
                                                    <a href="{{ route('admin.prestamos.show', $pi->id) }}" class="inline-flex items-center p-1.5 bg-white border border-gray-200 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition shadow-sm" title="Ver Detalle">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    {{-- HISTÓRICO DE AHORROS --}}
                    <div class="bg-white shadow-sm rounded-2xl p-6 border border-gray-100" id="seccion-ahorros">
                        <div class="flex flex-col md:flex-row justify-between items-center mb-8 border-b border-gray-50 pb-4">
                            <h3 class="text-lg font-black text-gray-800 flex items-center gap-2 uppercase tracking-wide">
                                <span class="p-1 bg-yellow-100 rounded text-xs text-yellow-600">🏦</span> Control de Ahorros
                            </h3>
                            <form action="{{ route('admin.socios.show', $socio->id) }}#seccion-ahorros" method="GET" class="flex items-center gap-3 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-200">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Ver Año:</label>
                                <select name="anio_ahorro" onchange="this.form.submit()" class="border-none bg-transparent rounded py-0 font-black text-indigo-600 text-sm focus:ring-0 cursor-pointer">
                                    @foreach($aniosDisponibles as $anio)
                                        <option value="{{ $anio }}" {{ ($anioSeleccionado == $anio) ? 'selected' : '' }}>{{ $anio }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        {{-- TARJETAS DE RESUMEN ANUAL DINÁMICO --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="bg-blue-600 p-5 rounded-3xl text-white shadow-lg relative overflow-hidden text-center">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-100 mb-3 italic">Aportación {{ $anioSeleccionado }}</p>
                                <div class="flex justify-between items-end font-mono">
                                    <div class="text-left text-[10px]">
                                        <p class="text-green-300">+ RD$ {{ number_format($totalesAnuales['aportacion']['ingresos'], 2) }}</p>
                                        <p class="text-red-200">- RD$ {{ number_format($totalesAnuales['aportacion']['egresos'], 2) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[9px] uppercase text-blue-200">Neto Año</p>
                                        <p class="text-2xl font-black">RD$ {{ number_format($totalesAnuales['aportacion']['ingresos'] - $totalesAnuales['aportacion']['egresos'], 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-800 p-5 rounded-3xl text-white shadow-lg relative overflow-hidden border-b-4 border-yellow-500 text-center">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 italic">Retirable {{ $anioSeleccionado }}</p>
                                <div class="flex justify-between items-end font-mono">
                                    <div class="text-left text-[10px]">
                                        <p class="text-green-400">+ RD$ {{ number_format($totalesAnuales['voluntario']['ingresos'], 2) }}</p>
                                        <p class="text-red-300">- RD$ {{ number_format($totalesAnuales['voluntario']['egresos'], 2) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[9px] uppercase text-yellow-500">Neto Año</p>
                                        <p class="text-2xl font-black">RD$ {{ number_format($totalesAnuales['voluntario']['ingresos'] - $totalesAnuales['voluntario']['egresos'], 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            {{-- TABLA APORTACIÓN --}}
                            <div class="border border-blue-100 rounded-2xl bg-blue-50/10 overflow-hidden">
                                <div class="p-3 bg-blue-50 flex justify-between items-center"><h4 class="font-black text-blue-900 text-xs uppercase italic">Aportación</h4><button onclick="abrirModalCuota('{{ $cuentaAportacion->id }}', '{{ $cuentaAportacion->recurring_amount }}', 'Aportación')" class="text-blue-500 hover:scale-125 transition">✏️</button></div>
                                <table class="min-w-full text-xs">
                                    <thead class="bg-gray-50 border-b border-gray-100 font-black text-[9px] text-gray-400 uppercase">
                                        <tr><th class="px-4 py-2 text-left">Mes</th><th class="px-4 py-2 text-right">Aporte</th><th class="px-4 py-2 text-right text-red-400">Retiro</th></tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50 font-mono">
                                        @foreach($matrizAportacion as $mesNum => $data)
                                        <tr class="hover:bg-blue-50 transition">
                                            <td class="px-4 py-2 font-black text-gray-400 uppercase text-[10px]">{{ \Carbon\Carbon::create()->month($mesNum)->locale('es')->monthName }}</td>
                                            <td class="px-4 py-2 text-right text-green-700 font-bold"><button onclick='gestionarMes(@json($data["transacciones"]), "{{ $cuentaAportacion->id }}", "{{ $anioSeleccionado }}", "{{ $mesNum }}", "deposit")'>{{ $data['aporte'] > 0 ? number_format($data['aporte'], 2) : '-' }}</button></td>
                                            <td class="px-4 py-2 text-right text-red-400"><button onclick='gestionarMes(@json($data["transacciones"]), "{{ $cuentaAportacion->id }}", "{{ $anioSeleccionado }}", "{{ $mesNum }}", "withdrawal")'>{{ $data['retiro'] > 0 ? number_format($data['retiro'], 2) : '-' }}</button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- TABLA RETIRABLE --}}
                            <div class="border border-yellow-100 rounded-2xl bg-yellow-50/10 overflow-hidden">
                                <div class="p-3 bg-yellow-50 flex justify-between items-center"><h4 class="font-black text-yellow-900 text-xs uppercase italic">Retirable</h4><button onclick="abrirModalCuota('{{ $cuentaVoluntario->id }}', '{{ $cuentaVoluntario->recurring_amount }}', 'Retirable')" class="text-yellow-600 hover:scale-125 transition">✏️</button></div>
                                <table class="min-w-full text-xs">
                                    <thead class="bg-gray-50 border-b border-gray-100 font-black text-[9px] text-gray-400 uppercase">
                                        <tr><th class="px-4 py-2 text-left">Mes</th><th class="px-4 py-2 text-right">Aporte</th><th class="px-4 py-2 text-right text-red-400">Retiro</th></tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50 font-mono">
                                        @foreach($matrizVoluntario as $mesNum => $data)
                                        <tr class="hover:bg-yellow-50 transition">
                                            <td class="px-4 py-2 font-black text-gray-400 uppercase text-[10px]">{{ \Carbon\Carbon::create()->month($mesNum)->locale('es')->monthName }}</td>
                                            <td class="px-4 py-2 text-right text-green-700 font-bold"><button onclick='gestionarMes(@json($data["transacciones"]), "{{ $cuentaVoluntario->id }}", "{{ $anioSeleccionado }}", "{{ $mesNum }}", "deposit")'>{{ $data['aporte'] > 0 ? number_format($data['aporte'], 2) : '-' }}</button></td>
                                            <td class="px-4 py-2 text-right text-red-400"><button onclick='gestionarMes(@json($data["transacciones"]), "{{ $cuentaVoluntario->id }}", "{{ $anioSeleccionado }}", "{{ $mesNum }}", "withdrawal")'>{{ $data['retiro'] > 0 ? number_format($data['retiro'], 2) : '-' }}</button></td>
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

        {{-- MODAL DE EDICIÓN DE PERFIL Y SALARIO --}}
        <div x-show="openEdit" class="fixed inset-0 z-60 flex items-center justify-center bg-gray-900/90 backdrop-blur-sm p-4" x-cloak style="display: none;">
            <div class="bg-white rounded-4xl shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100" @click.away="openEdit = false">
                <div class="bg-indigo-600 p-6 text-white flex justify-between items-center">
                    <h3 class="font-black italic uppercase tracking-tighter text-xl">Editar Datos del Socio</h3>
                    <button @click="openEdit = false" class="text-2xl font-black">&times;</button>
                </div>
                <form action="{{ route('admin.socios.update', $socio->id) }}" method="POST" class="p-8 space-y-5">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-[10px] font-black uppercase text-gray-400 mb-2 italic">Nombres</label><input type="text" name="nombres" value="{{ $socio->nombres }}" required class="w-full bg-gray-50 border-none rounded-xl py-3 px-4 font-bold text-gray-700"></div>
                        <div><label class="block text-[10px] font-black uppercase text-gray-400 mb-2 italic">Apellidos</label><input type="text" name="apellidos" value="{{ $socio->apellidos }}" required class="w-full bg-gray-50 border-none rounded-xl py-3 px-4 font-bold text-gray-700"></div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 italic">Salario Real Mensual (RD$)</label>
                        <input type="number" step="0.01" name="salario" value="{{ $socio->salario }}" required class="w-full pl-4 pr-4 py-4 bg-gray-50 border-none rounded-2xl font-black text-2xl text-indigo-600 focus:ring-4 focus:ring-indigo-100 transition">
                    </div>
                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-xl">💾 Guardar Cambios</button>
                </form>
            </div>
        </div>

        {{-- MODAL DE CUOTA --}}
        <div id="modal-cuota" class="fixed inset-0 bg-gray-900 bg-opacity-80 hidden z-50 items-center justify-center backdrop-blur-sm">
            <div class="bg-white rounded-3xl shadow-2xl w-96 p-8">
                <h3 class="text-xl font-black text-gray-800 mb-6 uppercase border-b pb-3" id="modal-titulo-texto">Editar Cuota</h3>
                <form id="form-cuota" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-8 text-center">
                        <label class="block text-gray-400 text-[10px] font-black uppercase mb-3 italic">Monto Mensual:</label>
                        <input type="number" step="0.01" name="recurring_amount" id="modal-input-monto" class="w-full py-4 bg-gray-50 border-none rounded-2xl font-black text-xl text-indigo-600 text-center">
                    </div>
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs shadow-xl">💾 Guardar</button>
                        <button type="button" onclick="cerrarModalCuota()" class="w-full py-4 bg-gray-50 text-gray-400 rounded-2xl font-black uppercase text-xs">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL GESTOR --}}
        <div id="modal-gestor" class="fixed inset-0 bg-gray-900 bg-opacity-80 hidden z-50 items-center justify-center backdrop-blur-md">
            <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl p-8 mx-4 border border-gray-100 relative">
                <div class="flex justify-between items-center mb-8 border-b pb-4">
                    <h3 class="text-2xl font-black text-gray-800 uppercase tracking-tighter italic">Gestión de Movimientos</h3>
                    <button onclick="cerrarGestor()" class="text-red-500 text-2xl font-black">&times;</button>
                </div>
                <div id="lista-transacciones" class="mb-8 space-y-4 max-h-56 overflow-y-auto pr-2 custom-scrollbar border-b pb-6"></div>
                <div class="bg-indigo-50/50 p-6 rounded-4xl border border-indigo-100">
                    <h4 class="text-[11px] font-black text-indigo-400 mb-4 uppercase italic" id="form-titulo">➕ Registrar Nueva Transacción</h4>
                    <form id="form-transaccion" method="POST" action="{{ route('admin.ahorros.transaction.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="savings_account_id" id="input-account-id">
                        <input type="hidden" name="type" id="input-type">
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-[10px] font-black text-gray-400 italic mb-2 uppercase">Fecha</label><input type="date" name="date" id="input-date" required class="w-full rounded-xl border-none font-black text-gray-700"></div>
                            <div><label class="block text-[10px] font-black text-gray-400 italic mb-2 uppercase">Importe RD$</label><input type="number" step="0.01" name="amount" id="input-amount" required class="w-full rounded-xl border-none font-black text-green-700"></div>
                            <div class="col-span-2"><label class="block text-[10px] font-black text-gray-400 italic mb-2 uppercase">Descripción</label><input type="text" name="description" id="input-desc" class="w-full rounded-xl border-none font-bold text-gray-700"></div>
                        </div>
                        <div class="flex justify-end gap-3 mt-8">
                            <button type="button" onclick="resetFormulario()" id="btn-cancelar-edit" class="hidden px-6 py-4 bg-gray-100 text-gray-400 rounded-2xl font-black uppercase text-[10px]">Cancelar Edición</button>
                            <button type="submit" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs shadow-xl">💾 Procesar Movimiento</button>
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
                const filteredTx = transacciones.filter(tx => (type === 'deposit' ? (tx.type === 'deposit' || tx.type === 'interest' || tx.type === 'deposito') : tx.type === 'withdrawal'));

                if (filteredTx.length === 0) {
                    lista.innerHTML = '<p class="text-center text-gray-300 italic py-4">Sin movimientos</p>';
                } else {
                    filteredTx.forEach(tx => {
                        const item = document.createElement('div');
                        item.className = 'flex justify-between items-center bg-gray-50 p-4 rounded-2xl border border-gray-100 hover:bg-white transition-all';
                        item.innerHTML = `<div><p class="font-black text-gray-800">RD$ ${parseFloat(tx.amount).toFixed(2)}</p><p class="text-[9px] font-black text-gray-400 uppercase">${tx.date.split('T')[0]} • ${tx.description || 'SIN DETALLE'}</p></div>
                                          <div class="flex gap-2"><button onclick='editarTx(${JSON.stringify(tx)})' class="p-1.5 text-blue-500 bg-white border border-gray-100 rounded-lg hover:bg-blue-500 hover:text-white transition">✏️</button>
                                          <form action="/admin/ahorros/transaccion/${tx.id}?socio_id=${socioId}&anio_ahorro=${currentYear}" method="POST" onsubmit="return confirm('¿Eliminar?')">@csrf @method('DELETE')<button type="submit" class="p-1.5 text-red-500 bg-white border border-gray-100 rounded-lg hover:bg-red-500 hover:text-white transition">&times;</button></form></div>`;
                        lista.appendChild(item);
                    });
                }
                resetFormulario();
                document.getElementById('modal-gestor').classList.remove('hidden');
            }

            function editarTx(tx) {
                document.getElementById('form-titulo').innerText = '✏️ Editando Registro';
                document.getElementById('input-date').value = tx.date.split('T')[0];
                document.getElementById('input-amount').value = tx.amount;
                document.getElementById('input-desc').value = tx.description;
                document.getElementById('form-transaccion').action = `/admin/ahorros/transaccion/${tx.id}?socio_id=${socioId}&anio_ahorro=${currentYear}#seccion-ahorros`;
                document.getElementById('form-method').value = 'PUT';
                document.getElementById('btn-cancelar-edit').classList.remove('hidden');
            }

            function resetFormulario() {
                document.getElementById('form-titulo').innerText = '➕ Registrar Nueva Transacción';
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
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 20px; }
        input[type="number"]::-webkit-inner-spin-button, input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</x-app-layout>
