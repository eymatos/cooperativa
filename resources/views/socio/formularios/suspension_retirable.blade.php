<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl leading-tight uppercase italic tracking-tighter text-red-600">
            🚫 Suspensión de Ahorro Retirable
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-4xl border border-gray-100 p-8 md:p-12 relative">

                <div class="mb-8 border-b pb-6 text-center">
                    <h3 class="text-2xl font-black text-gray-900 uppercase italic">Solicitud de Suspensión</h3>
                    <p class="text-xs font-bold text-gray-400 mt-2 uppercase tracking-widest leading-none">Cese de Descuento Voluntario - COOPROCON</p>
                </div>

                <form action="{{ route('solicitudes.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <input type="hidden" name="tipo" value="suspension_ahorro_retirable">

                    {{-- Datos Automáticos --}}
                    <input type="hidden" name="datos[nombres]" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="datos[cedula]" value="{{ auth()->user()->cedula }}">

                    <div class="text-gray-700 leading-relaxed text-lg italic font-medium">
                        Yo, <span class="font-black text-gray-900 uppercase">{{ auth()->user()->name }}</span>,
                        portador de la cédula No. <span class="font-black text-gray-900">{{ auth()->user()->cedula }}</span>,
                        en mi calidad de socio de **COOPROCON**, por medio de la presente solicito formalmente la
                        <span class="text-red-600 font-black uppercase underline">suspensión definitiva</span>
                        del descuento mensual que se me realiza por concepto de **AHORRO RETIRABLE**.

                        <p class="mt-6">
                            Solicito que dicha suspensión se haga efectiva a partir del mes de:
                        </p>

                        <div class="my-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Mes de Cese</label>
                                <select name="datos[mes_suspension]" required class="w-full border-none bg-transparent font-black text-gray-800 focus:ring-0 uppercase">
                                    @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $m)
                                        <option value="{{ $m }}" {{ now()->translatedFormat('F') == strtolower($m) ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Año</label>
                                <input type="number" name="datos[anio_suspension]" value="{{ date('Y') }}" required
                                    class="w-full border-none bg-transparent font-black text-gray-800 focus:ring-0">
                            </div>
                        </div>

                        <p class="text-sm text-gray-500 bg-red-50 p-4 rounded-xl border border-red-100">
                            <strong>Nota:</strong> Entiendo que al suspender este ahorro, mi acumulado retirable dejará de crecer mediante nómina, pero los fondos existentes permanecerán en mi cuenta según las políticas de la cooperativa.
                        </p>
                    </div>

                    <div class="pt-8 text-center">
                        <button type="submit" class="w-full bg-red-600 text-white font-black uppercase tracking-[0.2em] py-5 rounded-2xl shadow-xl hover:bg-red-700 hover:-translate-y-1 transition-all duration-300 italic">
                            Confirmar Suspensión de Descuento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
