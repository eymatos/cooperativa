<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter text-green-600">
            💸 Solicitud de Entrega de Ahorro Retirable
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-[2rem] border border-gray-100 p-8 md:p-12 relative">

                <div class="mb-8 border-b pb-6 text-center">
                    <h3 class="text-2xl font-black text-gray-900 uppercase italic leading-none">Entrega de Fondos</h3>
                    <p class="text-[10px] font-bold text-gray-400 mt-2 uppercase tracking-[0.2em]">COOPROCON - Patrimonio del Socio</p>
                </div>

                <form action="{{ route('solicitudes.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <input type="hidden" name="tipo" value="retiro_ahorro_retirable">

                    {{-- Datos Automáticos del Sistema --}}
                    <input type="hidden" name="datos[nombres]" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="datos[cedula]" value="{{ auth()->user()->cedula }}">

                    <div class="text-gray-700 leading-relaxed text-lg italic font-medium">
                        Yo, <span class="font-black text-gray-900 uppercase border-b-2 border-gray-100">{{ auth()->user()->name }}</span>,
                        portador de la cédula No. <span class="font-black text-gray-900 border-b-2 border-gray-100">{{ auth()->user()->cedula }}</span>,
                        solicito formalmente que se me haga entrega de la suma de:

                        <div class="my-8 p-8 bg-green-50 rounded-[2.5rem] border-2 border-dashed border-green-200 flex items-center gap-6 shadow-inner">
                            <div class="bg-green-600 text-white w-12 h-12 rounded-2xl flex items-center justify-center font-black italic shadow-lg">RD$</div>
                            <input type="number" step="0.01" name="datos[monto_retiro]" required placeholder="0.00"
                                class="w-full border-0 bg-transparent text-4xl font-black text-green-700 focus:ring-0 placeholder-green-200">
                        </div>

                        de mi <span class="text-green-600 font-black uppercase">Ahorro Retirable</span> de la
                        <strong>Cooperativa de Ahorros, Créditos y Servicios Múltiples de los empleados de Pro Consumidor (COOPROCON)</strong>.
                    </div>

                    {{-- Detalles Adicionales para la Administración --}}
                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 italic space-y-4">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Información de Desembolso</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="datos[banco]" required placeholder="Banco de destino" class="border-gray-200 rounded-xl text-sm font-bold uppercase focus:ring-green-500">
                            <input type="text" name="datos[cuenta]" required placeholder="Número de Cuenta" class="border-gray-200 rounded-xl text-sm font-bold uppercase focus:ring-green-500">
                        </div>
                    </div>

                    <div class="pt-8">
                        <button type="submit" class="w-full bg-gray-900 text-white font-black uppercase tracking-[0.2em] py-5 rounded-2xl shadow-2xl hover:bg-green-600 hover:-translate-y-1 transition-all duration-300 italic">
                            Autorizar Entrega de Fondos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
