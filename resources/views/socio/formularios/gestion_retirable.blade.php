<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
            ⚙️ Gestión de Ahorro Retirable
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-4xl border border-gray-100 p-8 md:p-12">

                <div class="mb-8 border-b pb-6 text-center">
                    <h3 class="text-2xl font-black text-gray-900 uppercase italic">Autorización de Descuento</h3>
                    <p class="text-xs font-bold text-gray-400 mt-2 uppercase tracking-widest">COOPROCON - Ahorro Retirable Individual</p>
                </div>

                <form action="{{ route('solicitudes.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <input type="hidden" name="tipo" value="gestion_ahorro_retirable">

                    {{-- Datos Automáticos --}}
                    <input type="hidden" name="datos[nombres]" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="datos[cedula]" value="{{ auth()->user()->cedula }}">

                    <div class="text-gray-700 leading-relaxed text-lg italic font-medium">
                        Yo, <span class="font-black text-orange-600 uppercase">{{ auth()->user()->name }}</span>,
                        portador de la cédula No. <span class="font-black text-orange-600">{{ auth()->user()->cedula }}</span>,
                        en mi calidad de socio de **COOPROCON**, autorizo formalmente a **PROCONSUMIDOR**, a descontar de mi salario la suma mensual de:

                        <div class="my-6 p-6 bg-orange-50 rounded-2xl border-2 border-orange-100 flex items-center gap-4">
                            <span class="text-2xl font-black text-orange-400">RD$</span>
                            <input type="number" step="0.01" name="datos[monto_retirable]" required placeholder="0.00"
                                class="w-full border-0 bg-transparent text-3xl font-black text-orange-600 focus:ring-0 placeholder-orange-200"
                            >
                        </div>

                        por concepto de **AHORRO RETIRABLE**, para ser incorporado a mi cuenta individual, a partir del mes de
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
                        <button type="submit" class="w-full bg-gray-900 text-white font-black uppercase tracking-[0.2em] py-5 rounded-2xl shadow-2xl hover:bg-orange-600 hover:-translate-y-1 transition-all duration-300 italic">
                            Autorizar Descuento Digital
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
