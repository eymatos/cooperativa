<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight italic">
            🔍 Historial de Auditoría y Movimientos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border-t-4 border-gray-800">

                <div class="mb-6">
                    <p class="text-sm text-gray-600">Este registro muestra todas las acciones críticas realizadas por los administradores sobre los préstamos.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Fecha/Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Usuario</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Acción</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Módulo</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">ID Ref.</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">IP</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($logs as $log)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 font-mono">
                                    {{ $log->created_at->format('d/m/Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="font-bold text-gray-900">{{ $log->user->name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $color = match($log->action) {
                                            'crear' => 'bg-green-100 text-green-700',
                                            'editar' => 'bg-blue-100 text-blue-700',
                                            'eliminar' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-700'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $color }}">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $log->model }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">
                                    #{{ $log->model_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400 font-mono">
                                    {{ $log->ip_address }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 text-gray-500">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
