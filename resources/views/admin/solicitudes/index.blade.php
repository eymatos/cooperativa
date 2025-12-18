<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
                📥 Bandeja de Solicitudes Digitales
            </h2>

            {{-- SELECTOR DE MES Y AÑO --}}
            <form action="{{ route('admin.solicitudes.index') }}" method="GET" class="flex items-center gap-2 bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center px-3 border-r border-gray-100">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mr-2 italic">Filtrar:</span>
                    <select name="mes" onchange="this.form.submit()" class="border-none bg-transparent font-black text-xs uppercase tracking-widest text-indigo-600 focus:ring-0 cursor-pointer p-0">
                        @foreach($mesesFiltro as $num => $nombre)
                            <option value="{{ $num }}" {{ $mes == $num ? 'selected' : '' }}>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <select name="anio" onchange="this.form.submit()" class="border-none bg-transparent font-black text-xs uppercase tracking-widest text-gray-400 focus:ring-0 cursor-pointer px-3 py-0">
                    @for($a = date('Y'); $a >= 2024; $a--)
                        <option value="{{ $a }}" {{ $anio == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endfor
                </select>
                <button type="submit" class="hidden">Actualizar</button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- INDICADOR DE PERIODO ACTUAL --}}
            <div class="mb-6 flex items-center justify-between">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                    Registros de: <span class="text-indigo-600 italic">{{ \Carbon\Carbon::create()->month((int)$mes)->translatedFormat('F') }} {{ $anio }}</span>
                </p>
                <span class="text-[10px] font-black text-gray-300 uppercase bg-gray-50 px-3 py-1 rounded-full">
                    Total: {{ $solicitudes->count() }}
                </span>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-2xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">🎉</span>
                        <span class="text-xs font-black uppercase tracking-widest italic">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] border-b bg-gray-50/50">
                            <th class="p-6">Fecha</th>
                            <th class="p-6">Tipo</th>
                            <th class="p-6">Solicitante</th>
                            <th class="p-6">Estado</th>
                            <th class="p-6 text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 font-sans">
                        @forelse($solicitudes as $s)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="p-6 text-xs font-bold text-gray-500">
                                {{ $s->created_at->format('d/m/Y') }}
                                <span class="block text-[9px] opacity-40 uppercase">{{ $s->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="p-6">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-indigo-100">
                                    {{ str_replace('_', ' ', $s->tipo) }}
                                </span>
                            </td>
                            <td class="p-6">
                                <p class="text-sm font-black text-gray-800 uppercase italic">
                                    {{ $s->datos['nombres'] ?? ($s->datos['nombre_completo'] ?? 'N/A') }} {{ $s->datos['apellidos'] ?? '' }}
                                </p>
                                <p class="text-[10px] text-gray-400 font-mono italic">
                                    @php
                                        $c = str_replace('-', '', $s->datos['cedula'] ?? '');
                                        $cedulaFormateada = (strlen($c) === 11)
                                            ? substr($c, 0, 3) . '-' . substr($c, 3, 7) . '-' . substr($c, 10, 1)
                                            : ($s->datos['cedula'] ?? 'Sin Cédula');
                                    @endphp
                                    {{ $cedulaFormateada }}
                                </p>
                            </td>
                            <td class="p-6">
                                @php
                                    $color = match($s->estado) {
                                        'procesada' => 'text-green-600',
                                        'rechazada' => 'text-red-600',
                                        default => 'text-amber-600',
                                    };
                                @endphp
                                <span class="text-xs font-black italic uppercase {{ $color }}">
                                    {{ $s->estado }}
                                </span>
                            </td>
                            <td class="p-6 text-right">
                                <a href="{{ route('admin.solicitudes.show', $s->id) }}" class="inline-flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg shadow-gray-200">
                                    Revisar <i class="fa-solid fa-magnifying-glass text-[8px]"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-5xl mb-4">📂</span>
                                    <h4 class="text-gray-400 font-black uppercase text-xs tracking-widest">No hay solicitudes en este periodo</h4>
                                    <p class="text-gray-300 text-[10px] mt-2 italic font-bold uppercase">Intente cambiando el mes en el filtro superior</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
