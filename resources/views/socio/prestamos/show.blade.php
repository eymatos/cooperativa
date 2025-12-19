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

            {{-- Resumen de Crédito --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-b-4 border-indigo-500">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 leading-none">Monto Original</p>
                    <p class="text-xl font-black text-gray-800 font-mono italic">RD$ {{ number_format($prestamo->monto, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-b-4 border-red-500">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 italic leading-none">Saldo Pendiente</p>
                    <p class="text-xl font-black text-red-600 font-mono italic">RD$ {{ number_format($prestamo->saldo_capital, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-b-4 border-blue-500">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 italic leading-none">Tipo de Préstamo</p>
                    <p class="text-lg font-black text-blue-600 uppercase italic leading-tight">{{ $prestamo->tipoPrestamo->nombre }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-b-4 border-green-500">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 italic leading-none">Interés Mensual</p>
                    <p class="text-xl font-black text-green-600 font-mono italic">{{ number_format($prestamo->tasa_interes, 2) }}%</p>
                </div>
            </div>

            {{-- Tabla de Cuotas --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                    <h3 class="font-black text-gray-800 uppercase italic tracking-tighter text-lg leading-none">📅 Calendario de Cuotas y Pagos</h3>
                    <div class="flex gap-2">
                         <span class="px-4 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase italic border border-green-200">
                            {{ $prestamo->cuotas->where('estado', 'pagada')->count() }} Pagadas
                        </span>
                        <span class="px-4 py-1 bg-indigo-100 text-indigo-600 rounded-full text-[10px] font-black uppercase italic border border-indigo-200">
                            {{ $prestamo->cuotas->where('estado', 'pendiente')->count() }} Pendientes
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto font-sans">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-900 text-white text-[10px] uppercase tracking-[0.2em]">
                                <th class="py-4 px-6 italic font-medium">Cuota</th>
                                <th class="py-4 px-6 italic font-medium">Fecha Vencimiento</th>
                                <th class="py-4 px-6 italic font-medium text-right">Capital</th>
                                <th class="py-4 px-6 italic font-medium text-right">Interés</th>
                                <th class="py-4 px-6 italic font-medium text-right">Total Cuota</th>
                                <th class="py-4 px-6 text-center italic font-medium">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 font-mono text-sm">
                            @foreach($prestamo->cuotas as $cuota)
                                <tr class="{{ $cuota->estado == 'pagada' ? 'bg-green-50/20' : 'hover:bg-gray-50' }} transition-colors">
                                    <td class="py-4 px-6 font-black text-gray-400 italic">#{{ $cuota->numero_cuota }}</td>
                                    <td class="py-4 px-6 text-xs font-bold text-gray-600 uppercase italic">
                                        {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-4 px-6 text-right font-bold text-gray-700">RD$ {{ number_format($cuota->capital, 2) }}</td>
                                    <td class="py-4 px-6 text-right font-bold text-gray-400">RD$ {{ number_format($cuota->interes, 2) }}</td>
                                    <td class="py-4 px-6 text-right font-black text-indigo-600 italic">RD$ {{ number_format($cuota->monto_total, 2) }}</td>
                                    <td class="py-4 px-6 text-center">
                                        @if($cuota->estado == 'pagada')
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Footer con aviso --}}
            <div class="bg-gray-900 text-white p-8 rounded-3xl flex flex-col md:flex-row items-center justify-between shadow-xl gap-6 border-b-8 border-indigo-600">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-white/10 rounded-2xl text-2xl">🛡️</div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-indigo-400">Certificación de Datos</p>
                        <p class="text-sm italic font-medium text-gray-300">Este calendario de pagos es generado automáticamente. Las deducciones se procesan vía nómina según las políticas de COOPROCON.</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[9px] font-black text-gray-500 uppercase italic mb-1 leading-none">Generado para:</p>
                    <p class="text-lg font-black text-white italic leading-tight uppercase">{{ Auth::user()->name }}</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
