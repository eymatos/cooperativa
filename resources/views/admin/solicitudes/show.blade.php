<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
                🔍 Detalle de Solicitud #{{ $solicitud->id }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('admin.solicitudes.descargar', $solicitud->id) }}" target="_blank" class="bg-blue-600 text-white px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg hover:bg-blue-700 transition-all flex items-center gap-2">
                    🖨️ Generar PDF Oficial
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Card de Datos --}}
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-5 text-8xl italic font-black">
                    {{ substr($solicitud->tipo, 0, 1) }}
                </div>

                <h3 class="text-xs font-black text-indigo-600 uppercase tracking-[0.3em] mb-8 border-b pb-4 italic">Datos del Formulario Digital</h3>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                    @foreach($solicitud->datos as $campo => $valor)
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic mb-1">
                                {{ str_replace(['_', 'ben_'], [' ', 'Beneficiario: '], $campo) }}
                            </p>
                            <p class="text-sm font-bold text-gray-700 uppercase">{{ is_array($valor) ? implode(', ', $valor) : $valor }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
{{-- Aviso Especial si es Autorización de Ahorro --}}
            @if($solicitud->tipo == 'autorizacion_ahorro')
                <div class="bg-indigo-50 border-2 border-indigo-100 p-6 rounded-4xl flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Monto a descontar solicitado:</p>
                        <p class="text-3xl font-black text-indigo-600 italic">RD$ {{ number_format($solicitud->datos['monto_ahorro'], 2) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">A partir de:</p>
                        <p class="text-lg font-bold text-indigo-800 uppercase">{{ $solicitud->datos['mes_inicio'] }} {{ $solicitud->datos['anio_inicio'] }}</p>
                    </div>
                </div>
            @endif
            {{-- Panel de Decisiones --}}
            <div class="bg-gray-900 p-8 rounded-[2.5rem] shadow-xl text-white">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xs font-black uppercase tracking-[0.3em] text-gray-400 italic">Acciones Administrativas</h3>
                    <span class="px-4 py-1 rounded-full bg-white/10 text-[10px] font-black uppercase italic text-orange-400">Estado: {{ $solicitud->estado }}</span>
                </div>

                <div class="flex flex-wrap gap-4">
                    {{-- Formulario para Aprobar --}}
                    <form action="{{ route('admin.solicitudes.estado', $solicitud->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="estado" value="procesada">
                        <button type="submit" class="bg-green-600 px-8 py-3 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-green-700 transition-all shadow-lg shadow-green-900/20">
                            Aprobar y Registrar
                        </button>
                    </form>

                    {{-- Formulario para Rechazar --}}
                    <form action="{{ route('admin.solicitudes.estado', $solicitud->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="estado" value="rechazada">
                        <button type="submit" class="bg-red-600 px-8 py-3 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-red-700 transition-all shadow-lg shadow-red-900/20">
                            Rechazar Solicitud
                        </button>
                    </form>

                    <a href="{{ route('admin.solicitudes.index') }}" class="bg-white/5 px-8 py-3 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-white/10 transition-all border border-white/10">
                        Volver a la bandeja
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
