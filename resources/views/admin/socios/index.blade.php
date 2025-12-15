<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Directorio de Socios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('admin.socios.index') }}" method="GET" class="mb-6 flex gap-2">
                    <input type="text" name="buscar" placeholder="Buscar por Nombre o Cédula..."
                           class="w-full border-gray-300 rounded shadow-sm" value="{{ request('buscar') }}">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-bold">Buscar</button>
                </form>

                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Nombre</th>
                            <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Cédula</th>
                            <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Correo</th>
                            <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($socios as $socio)
                        <tr>
                            <td class="px-5 py-5 border-b bg-white text-sm font-bold">
                                {{ $socio->socio->nombres ?? $socio->name }} {{ $socio->socio->apellidos ?? '' }}
                            </td>

                            <td class="px-5 py-5 border-b bg-white text-sm">
                                {{ $socio->socio->cedula ?? 'N/A' }}
                            </td>

                            <td class="px-5 py-5 border-b bg-white text-sm">{{ $socio->email }}</td>

                            <td class="px-5 py-5 border-b bg-white text-sm">

                                @if($socio->socio)
                                    <a href="{{ route('admin.socios.show', $socio->socio->id) }}"
                                       class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 text-xs font-bold inline-block relative z-10">
                                        👤 Ver Perfil Completo
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs italic">Perfil incompleto</span>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $socios->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
