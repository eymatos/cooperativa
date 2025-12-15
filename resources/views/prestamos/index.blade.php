<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Listado de Préstamos') }}
            </h2>

            {{-- Botón visible SOLO para Administradores --}}
            @if(Auth::user()->tipo == 1)
            <a href="{{ route('admin.prestamos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                + Nuevo Préstamo
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Mensaje si no hay préstamos --}}
                    @if($prestamos->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            No hay préstamos registrados para mostrar.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Socio</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plazo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($prestamos as $prestamo)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $prestamo->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-700">
                                            {{ $prestamo->socio->nombres }} {{ $prestamo->socio->apellidos }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-green-600 font-bold">
                                            RD$ {{ number_format($prestamo->monto, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $prestamo->plazo }} meses</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $color = match($prestamo->estado) {
                                                    'activo' => 'bg-green-100 text-green-800',
                                                    'pagado' => 'bg-blue-100 text-blue-800',
                                                    'mora' => 'bg-red-100 text-red-800',
                                                    'pendiente' => 'bg-yellow-100 text-yellow-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                                {{ ucfirst($prestamo->estado) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if(Auth::user()->tipo == 1)
                                                {{-- Enlace para ADMIN --}}
                                                <a href="{{ route('admin.prestamos.show', $prestamo) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Administrar</a>
                                            @else
                                                {{-- Enlace para SOCIO --}}
                                                <a href="{{ route('prestamos.show_socio', $prestamo) }}" class="text-blue-600 hover:text-blue-900 font-bold">Ver Tabla</a>
                                            @endif
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
    </div>
</x-app-layout>
