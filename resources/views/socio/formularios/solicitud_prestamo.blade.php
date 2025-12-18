<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
            🏦 Solicitud de Préstamo Institucional
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-[2.5rem] border border-gray-100 p-8 md:p-12 relative">

                {{-- Encabezado --}}
                <div class="mb-10 border-b pb-6 flex justify-between items-end">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 uppercase italic leading-none">Nueva Solicitud</h3>
                        <p class="text-[10px] font-bold text-gray-400 mt-2 uppercase tracking-[0.2em]">Crédito y Financiamiento COOPROCON</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">PASO ÚNICO</span>
                    </div>
                </div>

                <form action="{{ route('solicitudes.store') }}" method="POST" class="space-y-10">
                    @csrf
                    <input type="hidden" name="tipo" value="solicitud_prestamo">

                    {{-- Datos Ocultos Automáticos --}}
                    <input type="hidden" name="datos[nombre_completo]" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="datos[cedula]" value="{{ auth()->user()->cedula }}">

                    {{-- SECCIÓN 1: ESPECIFICACIONES DEL PRÉSTAMO --}}
                    <section>
                        <div class="flex items-center gap-2 mb-6">
                            <span class="w-8 h-8 bg-gray-900 text-white rounded-lg flex items-center justify-center font-black italic">01</span>
                            <h4 class="font-black text-gray-800 uppercase italic tracking-tight">Detalles del Crédito</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase ml-2 italic">Tipo de Préstamo</label>
                                <select name="datos[tipo_prestamo]" required class="w-full border-gray-100 bg-gray-50 rounded-2xl focus:ring-indigo-500 font-bold text-gray-700">
                                    <option value="Préstamo Normal">Préstamo Normal</option>
                                    <option value="Préstamo Educativo">Préstamo Educativo</option>
                                    <option value="Préstamo Vacacional">Préstamo Vacacional</option>
                                    <option value="Préstamo Express">Préstamo Express</option>
                                    <option value="Préstamo Útiles Escolares">Préstamo Útiles Escolares</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase ml-2 italic">Monto Solicitado RD$</label>
                                <input type="number" step="0.01" name="datos[monto_solicitado]" required placeholder="0.00"
                                    class="w-full border-gray-100 bg-gray-50 rounded-2xl focus:ring-indigo-500 font-black text-indigo-600">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase ml-2 italic">Destino del Préstamo</label>
                                <input type="text" name="datos[destino]" required placeholder="Ej. Gastos Médicos, Consumo..."
                                    class="w-full border-gray-100 bg-gray-50 rounded-2xl focus:ring-indigo-500 font-bold">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase ml-2 italic">Cant. Cuotas Deseadas</label>
                                <input type="number" name="datos[cantidad_cuotas]" required placeholder="Ej. 12, 24..."
                                    class="w-full border-gray-100 bg-gray-50 rounded-2xl focus:ring-indigo-500 font-bold">
                            </div>
                        </div>
                    </section>

                    {{-- SECCIÓN 2: DATOS DEL GARANTE (Opcional) --}}
                    <section class="bg-gray-50 p-6 rounded-[2rem] border border-gray-100">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="w-8 h-8 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-black italic">02</span>
                            <h4 class="font-black text-gray-800 uppercase italic tracking-tight">Información del Garante</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="datos[nombre_garante]" placeholder="Nombre completo del Garante" class="border-gray-200 rounded-xl text-sm italic">
                            <input type="text" name="datos[cedula_garante]" placeholder="Cédula del Garante" class="border-gray-200 rounded-xl text-sm italic">
                            <input type="text" name="datos[celular_garante]" placeholder="Celular" class="border-gray-200 rounded-xl text-sm italic">
                            <input type="number" step="0.01" name="datos[sueldo_garante]" placeholder="Sueldo del Garante RD$" class="border-gray-200 rounded-xl text-sm italic">
                        </div>
                    </section>

                    {{-- SECCIÓN 3: CLÁUSULA DE AUTORIZACIÓN --}}
                    <section>
                        <div class="flex items-center gap-2 mb-6">
                            <span class="w-8 h-8 bg-green-500 text-white rounded-lg flex items-center justify-center font-black italic text-xs">OK</span>
                            <h4 class="font-black text-gray-800 uppercase italic tracking-tight">Autorización Legal</h4>
                        </div>

                        <div class="p-6 bg-gray-900 rounded-[2rem] text-gray-300 text-xs leading-relaxed italic border-b-4 border-indigo-500">
                            <p class="mb-4">
                                Yo, <strong>{{ auth()->user()->name }}</strong>, autorizo formalmente a <strong>PROCONSUMIDOR</strong> a descontar de mi salario mensual la cuota resultante de este préstamo una vez sea aprobado.
                            </p>
                            <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                                <p><strong>NOTA IMPORTANTE:</strong> Si al momento de mi desvinculación de la Institución queda algún compromiso de pago, autorizo a descontarlo de mis prestaciones laborales.</p>
                            </div>
                        </div>
                    </section>

                    <button type="submit" class="w-full bg-indigo-600 text-white font-black uppercase tracking-[0.2em] py-5 rounded-2xl shadow-xl hover:bg-indigo-700 hover:-translate-y-1 transition-all duration-300 italic">
                        Enviar Solicitud de Préstamo
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
