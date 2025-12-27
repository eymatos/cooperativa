<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Control de Vencimientos y Cierre de Préstamos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- SECCIÓN PRIORITARIA: SALDOS CERO ORGANIZADOS POR TIPO --}}
            <div class="mb-12">
                <h3 class="text-lg font-black text-red-600 mb-2 flex items-center uppercase tracking-tighter">
                    <span class="bg-red-600 w-3 h-3 rounded-full mr-2 animate-pulse"></span>
                    🚩 Préstamos por Cerrar (Saldo RD$ 0.00)
                </h3>
                <p class="text-xs text-gray-500 mb-6 italic">Identifique a estos socios por categoría para excluirlos de la nómina de Enero.</p>

                @if($prestamosPorCerrar->isEmpty())
                    <div class="bg-gray-50 border border-gray-200 text-gray-400 p-8 rounded-xl text-center italic text-sm">
                        No hay préstamos con saldo pendiente de cero en este momento.
                    </div>
                @else
                    @foreach($prestamosPorCerrar as $tipo => $lista)
                        <div class="mb-8">
                            <h4 class="text-sm font-black text-red-800 mb-3 uppercase tracking-widest flex items-center gap-2">
                                <span class="px-2 py-0.5 bg-red-100 rounded text-[10px]">{{ $lista->count() }}</span>
                                {{ $tipo }}
                            </h4>
                            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border-2 border-red-100">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-red-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-[10px] font-black text-red-800 uppercase">Socio</th>
                                            <th class="px-6 py-3 text-left text-[10px] font-black text-red-800 uppercase">No. Préstamo</th>
                                            <th class="px-6 py-3 text-right text-[10px] font-black text-red-800 uppercase">Saldo Actual</th>
                                            <th class="px-6 py-3 text-center text-[10px] font-black text-red-800 uppercase">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach($lista as $p)
                                            <tr class="hover:bg-red-50/30 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-black text-gray-900">{{ $p->socio->user->name }}</div>
                                                    <div class="text-[10px] text-gray-500 font-mono">{{ $p->socio->cedula }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-600">
                                                    {{ $p->numero_prestamo }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-black text-green-600">
                                                    RD$ {{ number_format($p->saldo_capital, 2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                                    {{-- Botón para ver tabla de amortización --}}
                                                    <a href="{{ route('admin.prestamos.show', $p->id) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-[10px] font-black uppercase border border-blue-200 px-2 py-1.5 rounded-lg hover:bg-blue-50 transition shadow-sm">
                                                        📊 Ver Tabla
                                                    </a>

                                                    <form action="{{ route('admin.prestamos.marcar-pagado', $p->id) }}" method="POST" class="inline-block form-pagar">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="bg-red-600 text-white hover:bg-red-700 px-4 py-1.5 rounded-lg text-[10px] font-black uppercase transition shadow-md">
                                                            Confirmar Pago Final
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <hr class="mb-10 border-gray-200">

            {{-- SECCIÓN: PRÓXIMOS VENCIMIENTOS CRONOLÓGICOS ORGANIZADOS POR TIPO --}}
            <h3 class="text-lg font-bold text-gray-700 mb-6 flex items-center uppercase tracking-tighter">
                <span class="bg-indigo-600 w-3 h-3 rounded-full mr-2"></span>
                Préstamos Próximos a Vencer (Calendario 45 días)
            </h3>

            @if($prestamosVenciendo->isEmpty())
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 shadow-md">
                    No hay más préstamos programados para finalizar en los próximos 45 días.
                </div>
            @else
                @foreach($prestamosVenciendo as $tipo => $lista)
                    <div class="mb-10">
                        <h4 class="text-sm font-black text-indigo-900 mb-4 uppercase tracking-widest flex items-center gap-2">
                            <span class="px-2 py-0.5 bg-indigo-100 rounded text-[10px]">{{ $lista->count() }}</span>
                            {{ $tipo }}
                        </h4>

                        <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase italic">Socio</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase italic">No. Préstamo</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase italic">Monto Original</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase italic">Fecha Final</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase italic">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($lista as $p)
                                        @php
                                            $fechaFinal = \Carbon\Carbon::parse($p->cuotas->last()->fecha_vencimiento);
                                            $diasRestantes = now()->diffInDays($fechaFinal, false);
                                            $colorClase = $diasRestantes <= 15 ? 'text-red-600 bg-red-50' : 'text-orange-600 bg-orange-50';
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $p->socio->user->name }}</div>
                                                <div class="text-xs text-gray-400">{{ $p->socio->cedula }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">
                                                {{ $p->numero_prestamo }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-700">
                                                RD$ {{ number_format($p->monto, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $colorClase }}">
                                                    {{ $fechaFinal->format('d/m/Y') }}
                                                    ({{ $diasRestantes }} días)
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                                {{-- Botón para ver tabla de amortización --}}
                                                <a href="{{ route('admin.prestamos.show', $p->id) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-[10px] font-black uppercase border border-blue-200 px-2 py-1 rounded hover:bg-blue-50 transition">
                                                    📊 Ver Tabla
                                                </a>
                                                <a href="{{ route('admin.prestamos.show', $p->id) }}" class="text-indigo-600 hover:text-indigo-900 text-[10px] font-black uppercase border border-indigo-200 px-2 py-1 rounded hover:bg-indigo-50 transition">📑 Detalle</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        document.querySelectorAll('.form-pagar').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('¿Confirmas que este préstamo está saldado? Se cerrará oficialmente y dejará de aparecer en activos.')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</x-app-layout>
