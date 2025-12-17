<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Directorio de Socios Activos') }}
            </h2>
            <a href="{{ route('admin.socios.create') }}" class="bg-green-600 text-white px-4 py-2 rounded font-bold text-sm hover:bg-green-700">
                + Nuevo Socio
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('admin.socios.index') }}" method="GET" class="mb-6 flex gap-2">
                    <input type="text" name="buscar" placeholder="Buscar por Nombre o Cédula..."
                           class="w-full border-gray-300 rounded shadow-sm" value="{{ request('buscar') }}">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-bold">Buscar</button>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase">
                                <th class="px-4 py-3 text-left">Datos del Socio</th>
                                <th class="px-4 py-3 text-left">Inscripción</th>
                                <th class="px-2 py-3 text-right text-blue-600">Ahorro Normal</th>
                                <th class="px-2 py-3 text-right text-orange-600">Ahorro Retirable</th>
                                <th class="px-4 py-3 text-center">Estado</th>
                                <th class="px-4 py-3 text-center">Acción</th>

                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($socios as $u)
                           @php
                                // Buscamos la cuenta de Aportaciones (Acepta 'APO' o 'aportacion')
                                $cAportacion = $u->socio->cuentas->first(function($c) {
                                    $codigo = trim(strtolower($c->type->code));
                                    return $codigo === 'aportacion' || $codigo === 'apo';
                                });

                                // Buscamos la cuenta Voluntaria/Retirable (Acepta 'RET' o 'voluntario')
                                $cVoluntario = $u->socio->cuentas->first(function($c) {
                                    $codigo = trim(strtolower($c->type->code));
                                    return $codigo === 'voluntario' || $codigo === 'ret';
                                });
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4">
                                    <div class="font-bold text-gray-900">{{ $u->socio->nombres ?? $u->name }} {{ $u->socio->apellidos ?? '' }}</div>
                                    <div class="text-gray-500 italic">ID: {{ $u->cedula }}</div>
                                </td>

                                <td class="px-4 py-4 text-gray-600">
                                    {{ $u->created_at->format('d/m/Y') }}
                                </td>

                                <td class="px-2 py-4 text-right">
                                    <div class="font-bold text-blue-700">RD$ {{ number_format($cAportacion->balance ?? 0, 2) }}</div>
                                    <div class="text-[10px] text-gray-400 font-semibold uppercase">Mensual: RD$ {{ number_format($cAportacion->recurring_amount ?? 0, 2) }}</div>
                                </td>

                                <td class="px-2 py-4 text-right">
                                    <div class="font-bold text-orange-700">RD$ {{ number_format($cVoluntario->balance ?? 0, 2) }}</div>
                                    <div class="text-[10px] text-gray-400 font-semibold uppercase">Mensual: RD$ {{ number_format($cVoluntario->recurring_amount ?? 0, 2) }}</div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <form action="{{ route('admin.socios.toggle_status', $u->socio->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1 rounded-full text-[10px] font-bold {{ $u->socio->activo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $u->socio->activo ? 'ACTIVO' : 'INACTIVO' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($u->socio)
                                        <a href="{{ route('admin.socios.show', $u->socio->id) }}"
                                           class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full hover:bg-indigo-200 text-[11px] font-extrabold transition">
                                            PERFIL 360°
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $socios->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
