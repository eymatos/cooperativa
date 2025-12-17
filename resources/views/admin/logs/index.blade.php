<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">🔍 Auditoría de Movimientos</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-100 uppercase text-xs font-bold">
                            <th class="px-4 py-3">Fecha</th>
                            <th class="px-4 py-3">Usuario</th>
                            <th class="px-4 py-3">Acción</th>
                            <th class="px-4 py-3">Modelo</th>
                            <th class="px-4 py-3">Cambios</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($logs as $log)
                        <tr>
                            <td class="px-4 py-4">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-4 font-bold">{{ $log->user->name ?? 'Sistema' }}</td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $log->action == 'editar_ahorro' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100' }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-gray-500">{{ $log->model }} (ID: {{ $log->model_id }})</td>
                            <td class="px-4 py-4">
                                <details class="cursor-pointer text-xs text-blue-600">
                                    <summary>Ver detalle</summary>
                                    <div class="bg-gray-50 p-2 rounded mt-2 text-[10px] font-mono">
                                        <strong>Antes:</strong> {{ $log->before }} <br>
                                        <strong>Después:</strong> {{ $log->after }}
                                    </div>
                                </details>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
