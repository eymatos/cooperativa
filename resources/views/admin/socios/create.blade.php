<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Registrar Nuevo Socio') }}
            </h2>
            <a href="{{ route('admin.socios.index') }}" class="text-gray-600 hover:text-gray-900 font-bold text-sm">
                &larr; Cancelar y Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded">
        <p class="font-bold">Por favor corrige los siguientes errores:</p>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <form method="POST" action="{{ route('admin.socios.store') }}" class="bg-white p-8 rounded-lg shadow-md border-t-4 border-blue-500">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="md:col-span-2 border-b pb-2 mb-2">
                        <h3 class="text-lg font-bold text-blue-600 flex items-center">
                            <span class="mr-2">🔑</span> Información de Cuenta
                        </h3>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Cédula (Se usará para el Login)</label>
                        <input type="text" name="cedula" value="{{ old('cedula') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        @error('cedula') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Correo Electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>



                    <div class="md:col-span-2 border-b pb-2 mt-4 mb-2">
                        <h3 class="text-lg font-bold text-blue-600 flex items-center">
                            <span class="mr-2">👤</span> Datos Personales y Laborales
                        </h3>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nombres</label>
                        <input type="text" name="nombres" value="{{ old('nombres') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Apellidos</label>
                        <input type="text" name="apellidos" value="{{ old('apellidos') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                    </div>


<div>
    <label class="block font-medium text-sm text-gray-700">Sueldo Mensual (RD$)</label>
    <input type="number" step="0.01" name="sueldo" value="{{ old('sueldo') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full font-bold text-green-700" required>
</div>

<div>
    <label class="block font-medium text-sm text-gray-700">Tipo de Contrato</label>
    <select name="tipo_contrato" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
        <option value="" disabled selected>Seleccione una opción</option>
        <option value="fijo" {{ old('tipo_contrato') == 'fijo' ? 'selected' : '' }}>Fijo</option>
        <option value="contratado" {{ old('tipo_contrato') == 'contratado' ? 'selected' : '' }}>Contratado</option>
    </select>
    @error('tipo_contrato') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>



                    <div class="md:col-span-2">
                        <label class="block font-medium text-sm text-gray-700">Empresa / Lugar de Trabajo</label>
                        <input type="text" name="lugar_trabajo" value="{{ old('lugar_trabajo') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-medium text-sm text-gray-700">Dirección Domiciliaria</label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 border-t pt-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                        {{ __('Registrar Socio Ahora') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
