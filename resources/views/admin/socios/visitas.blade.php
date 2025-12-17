<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estadísticas y Control de Visitas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-4 text-gray-700">Socios Más Activos</h3>
                    <ul class="divide-y divide-gray-200">
                        @foreach($topVisitantes as $visita)
                            <li class="py-3 flex justify-between">
                                <span class="text-sm text-gray-600">{{ $visita->user->name }}</span>
                                <span class="font-bold text-blue-600">{{ $visita->total }} entradas</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-4 text-gray-700">Visitas por Mes ({{ date('Y') }})</h3>
                    <div class="space-y-4">
                        @foreach($visitasEsteAnio as $v)
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200">
                                        Mes {{ $v->mes }}
                                    </span>
                                    <span class="text-xs font-semibold inline-block text-blue-600">
                                        {{ $v->total }}
                                    </span>
                                </div>
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                                    <div style="width:{{ min($v->total, 100) }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
