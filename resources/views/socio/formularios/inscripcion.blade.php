<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
            📝 Formulario de Inscripción COOPROCON
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('solicitudes.store') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="tipo" value="inscripcion">

                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Tipo de Ingreso</label>
                            <select name="datos[tipo_ingreso]" class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl font-bold text-gray-700 focus:ring-4 focus:ring-green-100 transition-all outline-none" required>
                                <option value="nuevo">Nuevo Socio</option>
                                <option value="reingreso">Reingreso</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Fecha de Solicitud</label>
                            <input type="date" name="datos[fecha]" value="{{ date('Y-m-d') }}" class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl font-bold text-gray-700 outline-none" readonly>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <h3 class="text-lg font-black text-gray-800 mb-6 uppercase tracking-tighter italic">Datos Personales y Laborales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <input type="text" name="datos[nombres]" placeholder="Nombres" class="form-input-360" required>
                        <input type="text" name="datos[apellidos]" placeholder="Apellidos" class="form-input-360" required>
                        <input type="text" name="datos[cedula]" placeholder="Cédula" class="form-input-360" required>
                        <input type="text" name="datos[telefono]" placeholder="Teléfono" class="form-input-360" required>
                        <input type="email" name="datos[correo]" placeholder="Correo Electrónico" class="form-input-360" required>
                        <select name="datos[tipo_contrato]" class="form-input-360" required>
                            <option value="">Tipo de Contrato</option>
                            <option value="fijo">Fijo</option>
                            <option value="contratado">Contratado</option>
                        </select>
                        <div class="md:col-span-2">
                            <input type="text" name="datos[direccion]" placeholder="Dirección Residencial Completa" class="form-input-360" required>
                        </div>
                        <input type="text" name="datos[lugar_trabajo]" placeholder="Departamento / Lugar de Trabajo" class="form-input-360" required>
                        <input type="number" name="datos[sueldo]" placeholder="Sueldo Bruto Mensual (RD$)" class="form-input-360" required>
                    </div>
                </div>

                <div class="bg-indigo-900 p-8 rounded-[2.5rem] shadow-xl text-white">
                    <h3 class="text-lg font-black mb-6 uppercase tracking-tighter italic">Configuración Mensual de Ahorros</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[9px] uppercase font-black text-indigo-300 tracking-widest italic">Ahorro Normal (Aportación)</label>
                            <input type="number" name="datos[monto_ahorro_normal]" placeholder="RD$" class="w-full bg-white/10 border-none rounded-xl py-4 font-bold mt-1" required>
                        </div>
                        <div>
                            <label class="text-[9px] uppercase font-black text-indigo-300 tracking-widest italic">Ahorro Retirable (Opcional)</label>
                            <input type="number" name="datos[monto_ahorro_retirable]" placeholder="RD$" class="w-full bg-white/10 border-none rounded-xl py-4 font-bold mt-1">
                        </div>
                    </div>
                    <p class="text-[10px] mt-4 opacity-70 italic font-medium">
                        * Se autoriza el descuento único de RD$200 de inscripción y RD$250 de aporte inicial.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <h3 class="text-lg font-black text-gray-800 mb-6 uppercase tracking-tighter italic">En caso de Fallecimiento (Beneficiario)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" name="datos[beneficiario_nombre]" placeholder="Nombre Completo" class="form-input-360 col-span-1">
                        <input type="text" name="datos[beneficiario_cedula]" placeholder="Cédula" class="form-input-360">
                        <input type="text" name="datos[beneficiario_parentesco]" placeholder="Parentesco" class="form-input-360">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-green-600 text-white py-5 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-gray-900 transition-all shadow-xl">
                        Enviar Solicitud y Generar PDF Oficial
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<style>
    .form-input-360 {
        @apply w-full px-5 py-4 bg-gray-50 border-none rounded-2xl font-bold text-gray-700 focus:ring-4 focus:ring-green-100 transition-all outline-none;
    }
</style>
