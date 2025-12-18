<x-app-layout>
    {{-- BLOQUE DE CÁLCULO INICIAL (Motor de Datos del Socio) --}}
    @php
        // 1. Cálculo de compromisos de préstamos (cuota más cercana pendiente)
        $cuotasPrestamosSocio = $prestamosActivos->sum(function($p) {
            $cuota = $p->cuotas()->where('estado', 'pendiente')->orderBy('numero_cuota', 'asc')->first();
            return $cuota ? $cuota->monto_total : 0;
        });

        // 2. Ahorros desglosados
        $montoAportacion = $cuentaApo->recurring_amount ?? 0;
        $montoRetirable = $cuentaVol->recurring_amount ?? 0;
        $totalAhorrosMensuales = $montoAportacion + $montoRetirable;

        // 3. Total que se descontará en la siguiente nómina
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

            {{-- 1. INDICADORES DE INTELIGENCIA FINANCIERA --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-8 border-blue-600 relative overflow-hidden">
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

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-8 border-green-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 text-6xl font-black">💵</div>
                    <p class="text-[10px] uppercase font-black text-gray-400 tracking-[0.2em] mb-4">Margen de Descuento Libre</p>
                    <h3 class="text-3xl font-black text-green-700 font-mono">RD$ {{ number_format($capacidadDisponible, 2) }}</h3>
                    <p class="text-[9px] text-gray-400 mt-2 italic font-bold">Capacidad mensual disponible para nuevos créditos</p>
                </div>
            </div>

            {{-- 2. MATRIZ DE AHORROS MENSUAL --}}
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-tighter flex items-center gap-2 italic font-sans">
                        <span class="p-2 bg-blue-50 rounded-xl text-blue-600 text-sm">📅</span> Seguimiento Mensual de Ahorros
                    </h3>

                    <form action="{{ route('socio.dashboard') }}" method="GET" class="flex items-center gap-2">
                        <select name="anio_ahorro" onchange="this.form.submit()" class="text-xs font-black uppercase tracking-widest border-gray-200 rounded-xl focus:ring-blue-500 bg-gray-50 px-4 py-2">
                            @foreach($aniosDisponibles as $a)
                                <option value="{{ $a }}" {{ $anioSeleccionado == $a ? 'selected' : '' }}>Año {{ $a }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b font-mono">
                                <th class="pb-4 pr-4">Tipo de Ahorro</th>
                                @foreach(['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'] as $mes)
                                    <th class="pb-4 px-2 text-center">{{ $mes }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 font-mono">
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-6 pr-4">
                                    <span class="block text-xs font-black text-gray-700 uppercase italic leading-none">Aportación</span>
                                    <span class="text-[9px] text-gray-400 font-bold tracking-tighter italic font-sans">Ahorro Normal</span>
                                </td>
                                @foreach($matrizAportacion as $mes => $data)
                                    <td class="px-1 text-center">
                                        @if($data['aporte'] > 0)
                                            <div class="relative group/val inline-block">
                                                <div class="h-10 w-6 bg-blue-500 rounded-md mx-auto shadow-sm shadow-blue-200 hover:scale-110 transition-transform cursor-help"></div>
                                                <span class="absolute -top-6 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-[9px] font-bold px-2 py-1 rounded opacity-0 group-hover/val:opacity-100 transition-opacity whitespace-nowrap z-10 font-mono italic">
                                                    RD$ {{ number_format($data['aporte'], 0) }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="h-10 w-6 bg-gray-100 rounded-md mx-auto opacity-30"></div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-6 pr-4 border-t border-gray-50">
                                    <span class="block text-xs font-black text-orange-600 uppercase italic leading-none">Retirable</span>
                                    <span class="text-[9px] text-gray-400 font-bold tracking-tighter italic font-sans">Voluntario</span>
                                </td>
                                @foreach($matrizVoluntario as $mes => $data)
                                    <td class="px-1 text-center border-t border-gray-50">
                                        @if($data['aporte'] > 0)
                                            <div class="relative group/val inline-block">
                                                <div class="h-8 w-6 bg-orange-400 rounded-md mx-auto shadow-sm shadow-orange-100 hover:scale-110 transition-transform cursor-help"></div>
                                                <span class="absolute -top-6 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-[9px] font-bold px-2 py-1 rounded opacity-0 group-hover/val:opacity-100 transition-opacity whitespace-nowrap z-10 font-mono italic">
                                                    RD$ {{ number_format($data['aporte'], 0) }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="h-8 w-6 bg-gray-100 rounded-md mx-auto opacity-30"></div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 3. PRÓXIMO DESCUENTO (Estimado de Nómina) --}}
            <div class="bg-gray-900 text-white p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden border-b-8 border-orange-500">
                <div class="absolute top-0 right-0 p-6 opacity-10 text-8xl font-black">📊</div>
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                    <div>
                        <h3 class="text-xl font-black text-white uppercase tracking-wider flex items-center gap-2 italic">
                            <span class="w-2 h-8 bg-orange-500 rounded-full"></span>
                            Estimado de Próxima Nómina
                        </h3>
                        <p class="text-[11px] text-gray-500 font-bold uppercase mt-1 tracking-widest italic font-mono">Deducción total prevista</p>
                    </div>
                    <div class="text-right">
                        <span class="text-4xl font-black text-orange-400 font-mono italic">RD$ {{ number_format($totalDescuentoSocio, 2) }}</span>
                    </div>
                </div>

                {{-- DESGLOSE DE DEDUCCIONES --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-gray-800 pt-8 italic font-sans text-xs">

                    {{-- Cuotas de Préstamo --}}
                    <div class="bg-gray-800/40 p-4 rounded-2xl border border-gray-800 flex justify-between items-center group transition-all hover:bg-gray-800/60">
                        <div>
                            <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1 italic">Deducción Préstamos</p>
                            <p class="text-lg font-black font-mono text-white">RD$ {{ number_format($cuotasPrestamosSocio, 2) }}</p>
                        </div>
                        <span class="text-xl opacity-30 group-hover:opacity-100 transition-opacity">💳</span>
                    </div>

                    {{-- Ahorro Normal --}}
                    <div class="bg-blue-900/20 p-4 rounded-2xl border border-blue-900/30 flex justify-between items-center group transition-all hover:bg-blue-900/30">
                        <div>
                            <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest mb-1 italic">Ahorro Normal (Aport.)</p>
                            <p class="text-lg font-black font-mono text-blue-100">RD$ {{ number_format($montoAportacion, 2) }}</p>
                        </div>
                        <span class="text-xl opacity-30 group-hover:opacity-100 transition-opacity text-blue-400">🛡️</span>
                    </div>

                    {{-- Ahorro Retirable --}}
                    <div class="bg-orange-900/20 p-4 rounded-2xl border border-orange-900/30 flex justify-between items-center group transition-all hover:bg-orange-900/30">
                        <div>
                            <p class="text-[9px] font-black text-orange-400 uppercase tracking-widest mb-1 italic">Ahorro Retirable (Vol.)</p>
                            <p class="text-lg font-black font-mono text-orange-100">RD$ {{ number_format($montoRetirable, 2) }}</p>
                        </div>
                        <span class="text-xl opacity-30 group-hover:opacity-100 transition-opacity text-orange-400">💰</span>
                    </div>

                </div>
            </div>

            {{-- 4. MIS COMPROMISOS (PRÉSTAMOS) --}}
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-tighter flex items-center gap-2 italic">
                        <span class="p-2 bg-indigo-50 rounded-xl text-indigo-600 text-sm italic">📋</span> Mis Préstamos Vigentes
                    </h3>
                </div>

                @if($prestamosActivos->isEmpty())
                    <div class="flex flex-col items-center py-12 bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200 italic font-sans">
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

        </div>
    </div>
</x-app-layout>
