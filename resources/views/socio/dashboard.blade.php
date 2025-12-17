<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mi Resumen Financiero') }}
            </h2>
            <span class="text-sm font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                Socio: {{ $socio->nombres }} {{ $socio->apellidos }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-md border-l-8 border-blue-600">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs uppercase font-bold text-gray-400 tracking-wider">Ahorro de Aportación</p>
                        <span class="text-blue-600 bg-blue-50 p-2 rounded-lg text-xl">🏦</span>
                    </div>
                    <h3 class="text-3xl font-black text-gray-800">RD$ {{ number_format($cuentaApo->balance ?? 0, 2) }}</h3>
                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-[10px] text-gray-500 font-bold uppercase">Cuota Mensual Programada:</span>
                        <span class="text-sm font-black text-blue-700">RD$ {{ number_format($cuentaApo->recurring_amount ?? 0, 2) }}</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md border-l-8 border-orange-500">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs uppercase font-bold text-gray-400 tracking-wider">Ahorro Voluntario (Retirable)</p>
                        <span class="text-orange-500 bg-orange-50 p-2 rounded-lg text-xl">💰</span>
                    </div>
                    <h3 class="text-3xl font-black text-gray-800">RD$ {{ number_format($cuentaVol->balance ?? 0, 2) }}</h3>
                    <div class="mt-4 pt-4 border-t border-gray-100 italic">
                        <span class="text-[10px] text-gray-400 font-semibold uppercase">Fondo de libre disponibilidad para emergencias.</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-700 flex items-center">
                        <span class="mr-2 text-2xl">💳</span> Mis Compromisos de Pago
                    </h3>
                </div>

                @if($prestamosActivos->isEmpty())
                    <div class="flex flex-col items-center py-10">
                        <span class="text-5xl mb-4">🎉</span>
                        <p class="text-gray-500 font-medium italic">Actualmente no tienes deudas pendientes.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-[10px] text-gray-400 uppercase tracking-widest border-b">
                                    <th class="pb-3">Referencia</th>
                                    <th class="pb-3">Tipo de Crédito</th>
                                    <th class="pb-3 text-right">Monto Prestado</th>
                                    <th class="pb-3 text-right text-red-600">Saldo por Pagar</th>
                                    <th class="pb-3 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($prestamosActivos as $p)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="py-4 font-bold text-gray-700">{{ $p->numero_prestamo }}</td>
                                        <td class="py-4 text-gray-500">{{ $p->tipoPrestamo->nombre ?? 'Crédito' }}</td>
                                        <td class="py-4 text-right">RD$ {{ number_format($p->monto, 2) }}</td>
