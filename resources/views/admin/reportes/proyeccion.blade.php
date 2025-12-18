<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
            📊 Cartera Total de Cobros Pendientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- RESUMEN GLOBAL --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-indigo-900 p-8 rounded-[2rem] text-white shadow-xl relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10 text-6xl">💰</div>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-indigo-300 italic">Total por Cobrar (Pendiente)</span>
                    <p class="text-4xl font-black font-mono mt-2 text-white">
                        RD$ {{ number_format($proxima30dias, 2) }}
                    </p>
                    <p class="text-[10px] mt-2 opacity-60 italic">Suma de todas las cuotas pendientes en el sistema</p>
                </div>

                <div class="bg-green-600 p-8 rounded-[2rem] text-white shadow-xl relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10 text-6xl">✅</div>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-green-200 italic">Histórico Recaudado</span>
                    <p class="text-4xl font-black font-mono mt-2 text-white">
                        RD$ {{ number_format($proxima60dias, 2) }}
                    </p>
                    <p class="text-[10px] mt-2 opacity-60">Total de cuotas marcadas como pagadas</p>
                </div>
            </div>

            {{-- TABLA DE DETALLE --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <h3 class="font-black text-gray-400 uppercase text-[10px] tracking-widest mb-6 italic border-b pb-4">Listado General de Cuentas por Cobrar</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b">
                                <th class="py-4">Vencimiento</th>
                                <th class="py-4">Socio</th>
                                <th class="py-4">Préstamo</th>
                                <th class="py-4 text-right">Monto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($proximosCobros as $cuota)
                            <tr class="hover:bg-gray-50 transition-all group">
                                <td class="py-4">
                                    <span class="font-mono font-bold {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->isPast() ? 'text-red-500' : 'text-gray-600' }} text-xs">
                                        {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="py-4">
                                    <span class="font-black text-gray-800 uppercase text-xs block">
                                        {{ optional($cuota->prestamo->socio)->nombres ?? 'Socio no vinculado' }}
                                    </span>
                                </td>
                                <td class="py-4">
                                    <span class="text-[10px] font-bold text-gray-500 uppercase">#{{ optional($cuota->prestamo)->numero_prestamo }}</span>
                                </td>
                                <td class="py-4 text-right font-black text-gray-800 font-mono italic">
                                    RD$ {{ number_format($cuota->monto_total, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-400 font-black uppercase text-[10px] tracking-[0.3em]">
                                    🎉 No hay ninguna cuota pendiente en todo el sistema
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
