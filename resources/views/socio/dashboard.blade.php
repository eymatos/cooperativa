<x-app-layout>
    {{-- BLOQUE DE CÁLCULO INICIAL --}}
    @php
        $cuotasPrestamosSocio = $prestamosActivos->sum(function($p) {
            $cuota = $p->cuotas()->where('estado', 'pendiente')->orderBy('numero_cuota', 'asc')->first();
            return $cuota ? $cuota->monto_total : 0;
        });

        $montoAportacion = $cuentaApo->recurring_amount ?? 0;
        $montoRetirable = $cuentaVol->recurring_amount ?? 0;
        $totalAhorrosMensuales = $montoAportacion + $montoRetirable;
        $totalDescuentoSocio = $cuotasPrestamosSocio + $totalAhorrosMensuales;
    @endphp

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👤 Mi Perfil 360: <span class="text-blue-600 font-black italic">{{ Auth::user()->name }}</span>
            </h2>
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Estatus:</span>
                <span class="text-xs font-bold {{ $socio->activo ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-3 py-1 rounded-full border border-current">
                    {{ $socio->activo ? '● SOCIO ACTIVO' : '● INACTIVO' }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 1. INDICADORES --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 text-6xl font-black">🏦</div>
                    <p class="text-[10px] uppercase font-black text-gray-400 tracking-[0.2em] mb-4">Ahorro Acumulado Total</p>
                    <h3 class="text-3xl font-black text-gray-800 font-mono">RD$ {{ number_format($totalAhorradoGlobal, 2) }}</h3>
                    <p class="text-[9px] text-gray-400 mt-2 italic font-bold">Saldo disponible en todas tus cuentas</p>
                </div>

                <div class="bg-indigo-700 p-6 rounded-2xl shadow-xl border-l-8 border-indigo-400 relative overflow-hidden text-white">
                    <div class="absolute bottom-0 right-0 p-2 opacity-10 text-8xl font-black">📈</div>
                    <p class="text-[10px] uppercase font-black text-indigo-200 tracking-[0.2em] mb-4">Capacidad de Crédito (1.5x)</p>
                    <h3 class="text-3xl font-black text-white font-mono">RD$ {{ number_format($maximoCredito, 2) }}</h3>
                    <p class="text-[9px] text-indigo-300 mt-2 italic uppercase font-black">Basado en el balance de tus ahorros</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 text-6xl font-black">💵</div>
                    <p class="text-[10px] uppercase font-black text-gray-400 tracking-[0.2em] mb-4">Margen de Descuento Libre</p>
                    <h3 class="text-3xl font-black text-green-700 font-mono">RD$ {{ number_format($capacidadDisponible, 2) }}</h3>
                    <p class="text-[9px] text-gray-400 mt-2 italic font-bold">Capacidad disponible para nuevos créditos</p>
                </div>
            </div>

            {{-- 2. CONTROL DE AHORROS CON RESUMEN ANUAL --}}
            <div class="bg-white shadow-sm rounded-2xl p-6 border border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 border-b border-gray-50 pb-4">
                    <h3 class="text-lg font-black text-gray-800 flex items-center gap-2 uppercase tracking-wide italic">
                        <span class="p-1 bg-yellow-100 rounded text-xs text-yellow-600">🏦</span> Seguimiento de mis Ahorros
                    </h3>
                    <form action="{{ route('socio.dashboard') }}" method="GET" class="flex items-center gap-3 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-200">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Ver Historial:</label>
                        <select name="anio_ahorro" onchange="this.form.submit()" class="border-none bg-transparent rounded py-0 font-black text-indigo-600 text-sm focus:ring-0 cursor-pointer">
                            @foreach($aniosDisponibles as $anio)
                                <option value="{{ $anio }}" {{ ($anioSeleccionado == $anio) ? 'selected' : '' }}>{{ $anio }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                {{-- TARJETAS DE RESUMEN ANUAL DINÁMICO --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    {{-- Resumen Aportaciones --}}
                    <div class="bg-blue-600 p-5 rounded-3xl text-white shadow-lg relative overflow-hidden">
                        <div class="absolute -right-2 -top-2 opacity-10 text-6xl italic font-black">A</div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-100 mb-3 italic">Balance Aportación {{ $anioSeleccionado }}</p>
                        <div class="flex justify-between items-end">
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-green-300 flex items-center gap-1 font-mono">
                                    + RD$ {{ number_format($totalesAnuales['aportacion']['ingresos'], 2) }}
                                </p>
                                <p class="text-[10px] font-bold text-red-200 flex items-center gap-1 font-mono">
                                    - RD$ {{ number_format($totalesAnuales['aportacion']['egresos'], 2) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] font-black uppercase text-blue-200 tracking-tighter italic leading-none">Resultado Neto</p>
                                <p class="text-2xl font-black font-mono">RD$ {{ number_format($totalesAnuales['aportacion']['ingresos'] - $totalesAnuales['aportacion']['egresos'], 2) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Resumen Retirables --}}
                    <div class="bg-gray-800 p-5 rounded-3xl text-white shadow-lg relative overflow-hidden border-b-4 border-yellow-500">
                        <div class="absolute -right-2 -top-2 opacity-10 text-6xl italic font-black">V</div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 italic">Balance Retirable {{ $anioSeleccionado }}</p>
                        <div class="flex justify-between items-end">
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-green-400 flex items-center gap-1 font-mono">
                                    + RD$ {{ number_format($totalesAnuales['voluntario']['ingresos'], 2) }}
                                </p>
                                <p class="text-[10px] font-bold text-red-300 flex items-center gap-1 font-mono">
                                    - RD$ {{ number_format($totalesAnuales['voluntario']['egresos'], 2) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] font-black uppercase text-yellow-500 tracking-tighter italic leading-none">Resultado Neto</p>
                                <p class="text-2xl font-black font-mono">RD$ {{ number_format($totalesAnuales['voluntario']['ingresos'] - $totalesAnuales['voluntario']['egresos'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- TABLA APORTACIÓN --}}
                    <div class="border border-blue-100 rounded-2xl bg-blue-50/30 overflow-hidden shadow-sm">
                        <div class="p-4 border-b border-blue-100 bg-blue-50 flex justify-between items-center">
                            <h4 class="font-black text-blue-900 text-xs uppercase tracking-widest italic">Ahorro Aportación</h4>
                            <span class="text-[10px] font-black text-blue-700 bg-white px-2 py-1 rounded-lg border border-blue-200 font-mono">Cuota: RD$ {{ number_format($cuentaApo->recurring_amount ?? 0, 0) }}</span>
                        </div>
                        <div class="bg-white">
                            <table class="min-w-full text-xs">
                                <thead class="bg-gray-50 border-b border-gray-100 font-black text-[9px] text-gray-400 uppercase">
                                    <tr>
                                        <th class="px-4 py-2 text-left tracking-tighter">Mes</th>
                                        <th class="px-4 py-2 text-right">Aporte</th>
                                        <th class="px-4 py-2 text-right text-red-400 italic">Retiro</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($matrizAportacion as $mesNum => $data)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-4 py-2 font-black text-gray-400 uppercase text-[10px]">{{ \Carbon\Carbon::create()->month($mesNum)->locale('es')->monthName }}</td>
                                        <td class="px-4 py-2 text-right font-black text-green-700 font-mono">
                                            <span>{{ $data['aporte'] > 0 ? number_format($data['aporte'], 2) : '-' }}</span>
                                        </td>
                                        <td class="px-4 py-2 text-right font-bold text-red-400 font-mono">
                                            <span>{{ $data['retiro'] > 0 ? number_format($data['retiro'], 2) : '-' }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- TABLA RETIRABLE --}}
                    <div class="border border-yellow-100 rounded-2xl bg-yellow-50/30 overflow-hidden shadow-sm">
                        <div class="p-4 border-b border-yellow-100 bg-yellow-50 flex justify-between items-center">
                            <h4 class="font-black text-yellow-900 text-xs uppercase tracking-widest italic">Ahorro Retirable</h4>
                            <span class="text-[10px] font-black text-yellow-700 bg-white px-2 py-1 rounded-lg border border-yellow-200 font-mono">Cuota: RD$ {{ number_format($cuentaVol->recurring_amount ?? 0, 0) }}</span>
                        </div>
                        <div class="bg-white">
                            <table class="min-w-full text-xs">
                                <thead class="bg-gray-50 border-b border-gray-100 font-black text-[9px] text-gray-400 uppercase">
                                    <tr>
                                        <th class="px-4 py-2 text-left tracking-tighter">Mes</th>
                                        <th class="px-4 py-2 text-right">Aporte</th>
                                        <th class="px-4 py-2 text-right text-red-400 italic">Retiro</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($matrizVoluntario as $mesNum => $data)
                                    <tr class="hover:bg-yellow-50 transition">
                                        <td class="px-4 py-2 font-black text-gray-400 uppercase text-[10px]">{{ \Carbon\Carbon::create()->month($mesNum)->locale('es')->monthName }}</td>
                                        <td class="px-4 py-2 text-right font-black text-green-700 font-mono">
                                            <span>{{ $data['aporte'] > 0 ? number_format($data['aporte'], 2) : '-' }}</span>
                                        </td>
                                        <td class="px-4 py-2 text-right font-bold text-red-400 font-mono">
                                            <span>{{ $data['retiro'] > 0 ? number_format($data['retiro'], 2) : '-' }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. PRÓXIMO DESCUENTO --}}
            <div class="bg-gray-900 text-white p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden border-b-8 border-orange-500">
                <div class="absolute top-0 right-0 p-6 opacity-10 text-8xl font-black">📊</div>
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                    <div>
                        <h3 class="text-xl font-black text-white uppercase tracking-wider italic flex items-center gap-2">
                            <span class="w-2 h-8 bg-orange-500 rounded-full"></span> Estimado de Próxima Nómina
                        </h3>
                        <p class="text-[11px] text-gray-500 font-bold uppercase mt-1 tracking-widest italic font-mono">Deducción total prevista</p>
                    </div>
                    <div class="text-right">
                        <span class="text-4xl font-black text-orange-400 font-mono italic">RD$ {{ number_format($totalDescuentoSocio, 2) }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-gray-800 pt-8 italic font-sans text-xs">
                    <div class="bg-gray-800/40 p-4 rounded-2xl border border-gray-800 flex justify-between items-center group transition-all hover:bg-gray-800/60">
                        <div>
                            <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1 italic">Deducción Préstamos</p>
                            <p class="text-lg font-black font-mono text-white">RD$ {{ number_format($cuotasPrestamosSocio, 2) }}</p>
                        </div>
                        <span class="text-xl opacity-30 group-hover:opacity-100 transition-opacity">💳</span>
                    </div>

                    <div class="bg-blue-900/20 p-4 rounded-2xl border border-blue-900/30 flex justify-between items-center group transition-all hover:bg-blue-900/30">
                        <div>
                            <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest mb-1 italic">Ahorro Normal (Aport.)</p>
                            <p class="text-lg font-black font-mono text-blue-100">RD$ {{ number_format($montoAportacion, 2) }}</p>
                        </div>
                        <span class="text-xl opacity-30 group-hover:opacity-100 transition-opacity text-blue-400">🛡️</span>
                    </div>

                    <div class="bg-orange-900/20 p-4 rounded-2xl border border-orange-900/30 flex justify-between items-center group transition-all hover:bg-orange-900/30">
                        <div>
                            <p class="text-[9px] font-black text-orange-400 uppercase tracking-widest mb-1 italic">Ahorro Retirable (Vol.)</p>
                            <p class="text-lg font-black font-mono text-orange-100">RD$ {{ number_format($montoRetirable, 2) }}</p>
                        </div>
                        <span class="text-xl opacity-30 group-hover:opacity-100 transition-opacity text-orange-400">💰</span>
                    </div>
                </div>
            </div>

            {{-- 4. MIS COMPROMISOS (PRÉSTAMOS VIGENTES) --}}
            <div class="bg-white p-8 rounded-4xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-tighter flex items-center gap-2 italic">
                        <span class="p-2 bg-indigo-50 rounded-xl text-indigo-600 text-sm italic">📋</span> Mis Préstamos Vigentes
                    </h3>
                </div>

                @if($prestamosActivos->isEmpty())
                    <div class="flex flex-col items-center py-12 bg-gray-50 rounded-4xl border-2 border-dashed border-gray-200 italic font-sans">
                        <span class="text-5xl mb-4 opacity-50">✨</span>
                        <p class="text-gray-400 font-black uppercase text-[10px] tracking-[0.3em]">No posees deudas vigentes</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($prestamosActivos as $p)
                            @php
                                $pagado = $p->monto - $p->saldo_capital;
                                $porcentaje = $p->monto > 0 ? ($pagado / $p->monto) * 100 : 0;
                            @endphp
                            <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100 group hover:bg-white hover:shadow-xl hover:shadow-gray-200/40 transition-all duration-300 italic">
                                <div class="flex flex-col md:flex-row justify-between mb-4 gap-4">
                                    <div>
                                        <span class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] italic">#{{ $p->numero_prestamo }}</span>
                                        <h4 class="text-lg font-black text-gray-800 italic uppercase tracking-tighter">{{ $p->tipoPrestamo->nombre ?? 'Crédito' }}</h4>
                                    </div>
                                    <div class="flex gap-8">
                                        <div class="text-right">
                                            <p class="text-[9px] font-black text-gray-400 uppercase">Monto Concedido</p>
                                            <p class="font-bold text-gray-600 font-mono">RD$ {{ number_format($p->monto, 2) }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[9px] font-black text-red-400 uppercase tracking-widest italic">Capital Adeudado</p>
                                            <p class="font-black text-red-600 text-lg font-mono italic">RD$ {{ number_format($p->saldo_capital, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                        <span class="text-[10px] font-black uppercase rounded-full text-indigo-600 italic tracking-tighter">Estado de Amortización</span>
                                        <span class="text-xs font-black text-indigo-600 font-mono italic">{{ round($porcentaje) }}%</span>
                                    </div>
                                    <div class="overflow-hidden h-2.5 mb-4 flex rounded-full bg-gray-200 border border-white shadow-inner">
                                        <div style="width:{{ $porcentaje }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500 transition-all duration-1000"></div>
                                    </div>
                                </div>
                                <div class="flex justify-end mt-4 italic font-sans">
                                    <a href="{{ route('socio.prestamos.show_socio', $p->id) }}" class="text-[10px] font-black uppercase tracking-widest text-indigo-500 hover:text-indigo-800 underline decoration-2 underline-offset-4 flex items-center gap-1 transition-all">
                                        Detalle de Cuotas <span class="text-sm">→</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- 5. HISTORIAL DE PRÉSTAMOS FINALIZADOS (NUEVA SECCIÓN) --}}
            <div class="bg-white p-8 rounded-4xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-black text-gray-400 uppercase tracking-tighter flex items-center gap-2 italic">
                        <span class="p-2 bg-gray-50 rounded-xl text-gray-400 text-sm italic">✓</span> Historial de Préstamos Pagados
                    </h3>
                </div>

                @if($prestamosInactivos->isEmpty())
                    <p class="text-center py-6 text-gray-400 text-xs italic uppercase font-bold tracking-widest">No tienes préstamos finalizados en tu historial.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left italic border-separate border-spacing-y-2">
                            <thead>
                                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    <th class="px-4 py-2">Tipo / Número</th>
                                    <th class="px-4 py-2">Monto Original</th>
                                    <th class="px-4 py-2">Fecha Inicio</th>
                                    <th class="px-4 py-2 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prestamosInactivos as $pi)
                                    <tr class="bg-gray-50/50 hover:bg-white hover:shadow-md transition-all group">
                                        <td class="px-4 py-4 rounded-l-2xl">
                                            <p class="text-xs font-black text-gray-700 uppercase">{{ $pi->tipoPrestamo->nombre ?? 'Crédito' }}</p>
                                            <p class="text-[9px] font-bold text-gray-400 italic tracking-widest">#{{ $pi->numero_prestamo }}</p>
                                        </td>
                                        <td class="px-4 py-4 font-mono font-bold text-gray-600 text-xs">
                                            RD$ {{ number_format($pi->monto, 2) }}
                                        </td>
                                        <td class="px-4 py-4 text-xs font-bold text-gray-500 uppercase italic">
                                            {{ $pi->fecha_inicio ? \Carbon\Carbon::parse($pi->fecha_inicio)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td class="px-4 py-4 text-right rounded-r-2xl">
                                            <a href="{{ route('socio.prestamos.show_socio', $pi->id) }}" class="text-[10px] font-black text-indigo-400 group-hover:text-indigo-600 uppercase transition-colors">
                                                Ver Detalle →
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
