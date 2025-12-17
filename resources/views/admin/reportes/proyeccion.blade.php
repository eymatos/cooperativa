<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proyección de Flujo de Efectivo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-purple-500">
                    <p class="text-xs uppercase font-bold text-gray-400">Recaudación estimada (Próximos 30 días)</p>
                    <h3 class="text-3xl font-black text-purple-700">RD$ {{ number_format($proxima30dias, 2) }}</h3>
                    <p class="text-xs mt-2 text-gray-500 italic text-right">Basado en cuotas por vencer</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-indigo-500">
                    <p class="text-xs uppercase font-bold text-gray-400">Recaudación estimada (Siguiente mes)</p>
                    <h3 class="text-3xl font-black text-indigo-700">RD$ {{ number_format($proxima60dias, 2) }}</h3>
                    <p class="text-xs mt-2 text-gray-500 italic text-right">Proyección de ingresos a 60 días</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-bold text-gray-700 mb-4 italic">Calendario Inmediato de Cobros</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-gray-400 text-left uppercase text-[10px] tracking-widest">
                                <th class="pb-3">Socio</th>
                                <th class="pb-3">Vencimiento</th>
                                <th class="pb-3 text-right">Monto a Recibir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($proximosCobros as $cobro)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 font-bold">{{ $cobro->prestamo->socio->user->name }}</td>
                                <td class="py-4">{{ \Carbon\Carbon::parse($cobro->fecha_vencimiento)->format('d/m/Y') }}</td>
                                <td class="py-4 text-right font-black text-purple-600">RD$ {{ number_format($cobro->capital + $cobro->interes, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
