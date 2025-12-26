<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
                📊 Detalle de mi Préstamo #{{ $prestamo->numero_prestamo }}
            </h2>
            <a href="{{ route('socio.dashboard') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-200 transition-all flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Resumen del Préstamo --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-b-4">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Monto Original</p>
                    <p class="text-xl font-black text-gray-800 font-mono italic">RD$ {{ number_format($prestamo->monto, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-b-4">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">Saldo Pendiente</p>
                    <p class="text-xl font-black text-red-600 font-mono italic">RD$ {{ number_format($prestamo->saldo_capital, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-b-4">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">Tipo de Crédito</p>
                    <p class="text-lg font-black text-blue-600 uppercase italic">{{ $prestamo->tipoPrestamo->nombre }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-b-4">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">Tasa de Interés</p>
                    <p class="text-xl font-black text-green-600 font-mono italic">{{ $prestamo->tasa_interes }}% <span class="text-[10px]">Anual</span></p>
                </div>
            </div>

            {{-- Tabla de Cuotas --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                    <h3 class="font-black text-gray-800 uppercase italic tracking-tighter text-lg">📅 Calendario de Pagos</h3>
                    <div class="flex gap-2">
                        <span class="px-4 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase italic border border-green-200">
                            {{ $prestamo->cuotas->where('estado', 'pagado')->count() }} Pagadas
                        </span>
                        <span class="px-4 py-1 bg-indigo-100 text-indigo-600 rounded-full text-[10px] font-black uppercase italic border border-indigo-200">
                            {{ $prestamo->cuotas->where('estado', 'pendiente')->count() }} Pendientes
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left font-mono">
                        <thead>
                            <tr class="bg-gray-900 text-white text-[10px] uppercase tracking-[0.2em]">
                                <th class="py-4 px-6 italic">No.</th>
                                <th class="py-4 px-6 italic">Vencimiento</th>
                                <th class="py-4 px-6 italic text-right">Capital</th>
                                <th class="py-4 px-6 italic text-right">Interés</th>
                                <th class="py-4 px-6 italic text-right">Total Cuota</th>
                                <th class="py-4 px-6 text-center italic">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($prestamo->cuotas as $cuota)
                                {{-- Lógica para filas de Abono a Capital (Cuota 0) --}}
                                @if($cuota->numero_cuota == 0)
                                    <tr class="bg-blue-50/50 hover:bg-blue-50 transition-colors border-l-4 border-blue-400">
                                        <td class="py-4 px-6 font-black text-blue-600 italic">ABONO</td>
                                        <td class="py-4 px-6 text-xs font-bold text-blue-800 uppercase italic">
                                            {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="py-4 px-6 text-right font-bold text-green-700">RD$ {{ number_format($cuota->capital, 2) }}</td>
                                        <td class="py-4 px-6 text-right font-bold text-gray-400">RD$ 0.00</td>
                                        <td class="py-4 px-6 text-right font-black text-blue-700 italic">RD$ {{ number_format($cuota->monto_total, 2) }}</td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="inline-flex items-center gap-1 text-[9px] font-black text-blue-600 uppercase bg-blue-100 px-2 py-1 rounded-md border border-blue-200 shadow-sm">
                                                💎 Abono Directo
                                            </span>
                                        </td>
                                    </tr>
                                @else
                                    <tr class="{{ $cuota->estado == 'pagado' ? 'bg-green-50/20' : '' }} hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-6 font-black text-gray-400 italic">#{{ $cuota->numero_cuota }}</td>
                                        <td class="py-4 px-6 text-xs font-bold text-gray-600 uppercase italic">
                                            {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="py-4 px-6 text-right font-bold text-gray-700">RD$ {{ number_format($cuota->capital, 2) }}</td>
                                        <td class="py-4 px-6 text-right font-bold {{ $cuota->interes == 0 ? 'text-green-500 font-black' : 'text-gray-400' }}">
                                            RD$ {{ number_format($cuota->interes, 2) }}
                                        </td>
                                        <td class="py-4 px-6 text-right font-black text-indigo-600 italic">RD$ {{ number_format($cuota->monto_total, 2) }}</td>
                                        <td class="py-4 px-6 text-center">
                                            @if($cuota->estado == 'pagado')
                                                <span class="inline-flex items-center gap-1 text-[9px] font-black text-green-600 uppercase bg-green-50 px-2 py-1 rounded-md border border-green-200">
                                                    ✓ Pagada
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-[9px] font-black text-orange-600 uppercase bg-orange-50 px-2 py-1 rounded-md border border-orange-200">
                                                    ● Pendiente
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Footer Informativo --}}
            <div class="bg-indigo-900 text-white p-6 rounded-3xl flex items-center justify-between shadow-xl">
                <div class="flex items-center gap-4">
                    <span class="text-3xl italic">🛡️</span>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-indigo-300">Información de Tabla</p>
                        <p class="text-sm italic font-medium">Al realizar abonos directos al capital, su cuota e intereses mensuales se reducen automáticamente.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
