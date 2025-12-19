<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
            ✍️ Autorización de Descuento Ahorro
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-4xl border border-gray-100 p-8 md:p-12">

                <div class="mb-8 border-b pb-6 text-center">
                    <h3 class="text-2xl font-black text-gray-900 uppercase italic">Formulario de Autorización</h3>
                    <p class="text-xs font-bold text-gray-400 mt-2 uppercase tracking-widest">Cooperativa de Ahorros, Créditos y Servicios Múltiples (COOPROCON)</p>
                </div>

                <form action="{{ route('solicitudes.store') }}" method="POST" class="space-y-8">
                    @csrf
                    {{-- Definimos el tipo de solicitud para el controlador --}}
                    <input type="hidden" name="tipo" value="autorizacion_ahorro">

                    <div class="text-gray-700 leading-relaxed text-lg italic font-medium">
                        Yo,
                        <input type="text" name="datos[nombres]"
                            value="{{ auth()->user()->name }}"
                            readonly
                            class="border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-indigo-500 font-black uppercase text-indigo-600 bg-gray-50 rounded-lg px-4 py-1 inline-block w-full md:w-auto mb-2"
                        >
                        portador de la cédula No.
                        <input type="text" name="datos[cedula]"
                            value="{{ auth()->user()->cedula }}"
                            readonly
                            class="border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-indigo-500 font-black text-indigo-600 bg-gray-50 rounded-lg px-4 py-1 inline-block w-full md:w-48 mb-2"
                        >,
                        en mi calidad de socio de **COOPROCON**, autorizo formalmente a **PROCONSUMIDOR**, a descontar de mi salario la suma mensual de:

                        <div class="my-6 p-6 bg-indigo-50 rounded-2xl border-2 border-indigo-100 flex items-center gap-4">
                            <span class="text-2xl font-black text-indigo-400">RD$</span>
                            <input type="number" step="0.01" name="datos[monto_ahorro]" required placeholder="0.00"
                                class="w-full border-0 bg-transparent text-3xl font-black text-indigo-600 focus:ring-0 placeholder-indigo-200"
                            >
                        </div>

                        a partir del mes de
                        <select name="datos[mes_inicio]" required class="border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-indigo-500 font-black uppercase text-gray-800 rounded-lg">
                            @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $m)
                                <option value="{{ $m }}" {{ now()->translatedFormat('F') == strtolower($m) ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                        del año
                        <input type="number" name="datos[anio_inicio]" value="{{ date('Y') }}" required
                            class="border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-indigo-500 font-black text-gray-800 rounded-lg w-24"
                        >
                        por concepto de **AHORRO NORMAL** para ser incorporado a mi cuenta individual.
                    </div>

                    <div class="pt-8">
                        <button type="submit" class="w-full bg-gray-900 text-white font-black uppercase tracking-[0.2em] py-5 rounded-2xl shadow-2xl hover:bg-indigo-600 hover:-translate-y-1 transition-all duration-300 italic">
                            Enviar Autorización Digital
                        </button>
                        <p class="text-[10px] text-center text-gray-400 mt-4 uppercase font-bold tracking-tighter">
                            Al enviar este formulario, usted acepta que esta firma digital tiene validez legal para el descuento de nómina.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
