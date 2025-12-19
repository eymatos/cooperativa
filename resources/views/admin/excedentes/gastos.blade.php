<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-gray-800 uppercase italic tracking-tighter">
                💸 Registro de Gastos Operativos {{ $anio }}
            </h2>
            <a href="{{ route('admin.excedentes.informe') }}" class="bg-gray-800 text-white px-6 py-2 rounded-xl text-[10px] font-black uppercase italic shadow-lg flex items-center gap-2">
                <i class="fa-solid fa-chart-line"></i> Volver al Informe
            </a>
        </div>
    </x-slot>

    <div class="py-12 px-4 max-w-7xl mx-auto space-y-8">

        {{-- FORMULARIO DE REGISTRO RÁPIDO --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <h3 class="text-xs font-black text-gray-400 uppercase mb-6 italic tracking-widest text-center">Registrar Nuevo Movimiento de Gasto</h3>

            <form action="{{ route('admin.excedentes.gastos.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @csrf
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-2">Fecha</label>
                    <input type="date" name="fecha" required class="w-full border-gray-100 bg-gray-50 rounded-2xl font-black text-gray-700">
                </div>

                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-2">Categoría</label>
                    <select name="categoria" required class="w-full border-gray-100 bg-gray-50 rounded-2xl font-black text-gray-700 uppercase italic text-xs">
                        @foreach($categorias as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-2">Descripción</label>
                    <input type="text" name="descripcion" placeholder="Ej: Pago Hosting" required class="w-full border-gray-100 bg-gray-50 rounded-2xl font-black text-gray-700">
                </div>

                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-2">Monto (RD$)</label>
                    <input type="number" step="0.01" name="monto" placeholder="0.00" required class="w-full border-gray-100 bg-gray-50 rounded-2xl font-black text-indigo-600">
                </div>

                <div class="md:col-span-4 mt-2">
                    <button type="submit" class="w-full bg-indigo-600 text-white font-black uppercase italic py-4 rounded-2xl tracking-[0.2em] shadow-lg hover:bg-indigo-700 transition-all">
                        Registrar Gasto Administrativo
                    </button>
                </div>
            </form>
        </div>

        {{-- LISTADO DE GASTOS DEL AÑO --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-black text-gray-800 uppercase italic text-sm tracking-widest">Historial de Gastos {{ $anio }}</h3>
                <form action="{{ route('admin.excedentes.gastos.index') }}" method="GET">
                    <input type="number" name="anio" value="{{ $anio }}" class="border-gray-200 bg-white rounded-xl font-black text-xs w-24 text-center" onchange="this.form.submit()">
                </form>
            </div>

            <table class="w-full text-left">
                <thead class="bg-gray-100 text-gray-400 italic">
                    <tr class="text-[10px] font-black uppercase tracking-widest">
                        <th class="px-8 py-4">Fecha</th>
                        <th class="px-8 py-4">Categoría</th>
                        <th class="px-8 py-4">Descripción</th>
                        <th class="px-8 py-4 text-right">Monto</th>
                        <th class="px-8 py-4 text-center no-print">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 italic">
                    @forelse($gastos as $gasto)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-4 text-xs font-bold text-gray-500">
                                {{ $gasto->fecha->format('d/m/Y') }}
                            </td>
                            <td class="px-8 py-4">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[9px] font-black uppercase">
                                    {{ $categorias[$gasto->categoria] ?? $gasto->categoria }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-xs font-black text-gray-800 uppercase">
                                {{ $gasto->descripcion }}
                            </td>
                            <td class="px-8 py-4 text-right">
                                <span class="font-black text-gray-900">RD$ {{ number_format($gasto->monto, 2) }}</span>
                            </td>
                            <td class="px-8 py-4 text-center no-print">
                                <form action="{{ route('admin.excedentes.gastos.destroy', $gasto) }}" method="POST" onsubmit="return confirm('¿Eliminar este gasto?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600 transition-colors">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-10 text-center text-gray-400 text-xs italic">
                                No se han registrado gastos para el año {{ $anio }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($gastos->count() > 0)
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-8 py-4 text-right font-black text-[10px] uppercase text-gray-400">Total Gastos Acumulados:</td>
                        <td class="px-8 py-4 text-right font-black text-red-500 text-sm">RD$ {{ number_format($gastos->sum('monto'), 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</x-app-layout>
