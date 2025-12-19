<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
            💰 Inscripción Ahorro Retirable
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-4xl border border-gray-100 p-8 md:p-12">

                <div class="mb-8 border-b pb-6 text-center">
                    <h3 class="text-2xl font-black text-gray-900 uppercase italic">Solicitud de Ahorros Retirables</h3>
                    <p class="text-xs font-bold text-gray-400 mt-2 uppercase tracking-widest">COOPROCON - Gestión de Ahorro Voluntario</p>
                </div>

                <form action="{{ route('solicitudes.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <input type="hidden" name="tipo" value="inscripcion_ahorro_retirable">

                    {{-- CAMPOS OCULTOS PARA ASEGURAR QUE LLEGUEN AL ADMINISTRADOR --}}
                    <input type="hidden" name="datos[nombres]" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="datos[cedula]" value="{{ auth()->user()->cedula }}">
                    <input type="hidden" name="datos[correo]" value="{{ auth()->user()->email }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Tipo de Solicitud</label>
                            <select name="datos[tipo_tramite]" required class="w-full border-none bg-transparent font-bold text-indigo-600 focus:ring-0">
                                <option value="Nuevo">Nuevo Registro (Apertura)</option>
                                <option value="Reingreso">Reingreso al Servicio</option>
                            </select>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Fecha de Solicitud</label>
                            <input type="text" value="{{ now()->format('d/m/Y') }}" readonly class="w-full border-none bg-transparent font-bold text-gray-500 focus:ring-0">
                        </div>
                    </div>

                    <div class="text-gray-700 leading-relaxed text-lg italic font-medium">
                        A los Directivos de **COOPROCON**, yo <span class="font-black text-indigo-600 uppercase">{{ auth()->user()->name }}</span>,
                        portador de la cédula No. <span class="font-black text-indigo-600">{{ auth()->user()->cedula }}</span>,
                        solicito formalmente que se empiece a descontar de mi salario la suma mensual de:

                        <div class="my-6 p-6 bg-orange-50 rounded-2xl border-2 border-orange-100 flex items-center gap-4">
                            <span class="text-2xl font-black text-orange-400">RD$</span>
                            <input type="number" step="0.01" name="datos[monto_retirable]" required placeholder="0.00"
                                class="w-full border-0 bg-transparent text-3xl font-black text-orange-600 focus:ring-0 placeholder-orange-200"
                            >
                        </div>

                        como **Ahorros Retirables**, acogiendo como buenas y válidas las decisiones aprobadas por la Asamblea General,
                        esto a partir del mes de
                        <select name="datos[mes_inicio]" required class="border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-orange-500 font-black uppercase text-gray-800 bg-transparent">
                            @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $m)
                                <option value="{{ $m }}" {{ now()->translatedFormat('F') == strtolower($m) ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                        del año
                        <input type="number" name="datos[anio_inicio]" value="{{ date('Y') }}" required
                            class="border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-orange-500 font-black text-gray-800 bg-transparent w-24"
                        >.
                    </div>

                    <div class="pt-8">
                        <button type="submit" class="w-full bg-orange-600 text-white font-black uppercase tracking-[0.2em] py-5 rounded-2xl shadow-xl hover:bg-orange-700 hover:-translate-y-1 transition-all duration-300 italic">
                            Confirmar Inscripción al Servicio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
