<x-app-layout>
    {{-- Definimos el slot del header si tu componente lo usa --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Importador Maestro de Socios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">
                {{-- Encabezado con Identidad Corporativa --}}
                <div class="bg-linear-to-r from-green-600 to-indigo-800 p-8">
                    <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">Sincronización de Datos</h2>
                    <p class="text-indigo-100 text-sm opacity-80 font-medium">Carga masiva desde el sistema anterior (CSV).</p>
                </div>

                <div class="p-10">
                    {{-- Mensajes de Feedback --}}
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl flex items-center shadow-sm">
                            <i class="fa-solid fa-circle-check text-xl mr-3"></i>
                            <span class="font-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl flex items-center shadow-sm">
                            <i class="fa-solid fa-triangle-exclamation text-xl mr-3"></i>
                            <span class="font-bold">{{ session('error') }}</span>
                        </div>
                    @endif

                    {{-- Formulario de Carga --}}
                    <form action="{{ route('admin.importar.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div class="relative group border-2 border-dashed border-gray-200 rounded-2xl p-12 text-center hover:border-green-400 transition-all cursor-pointer bg-gray-50 hover:bg-white">
                                <input type="file" name="archivo_csv" id="archivo_csv" accept=".csv" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateInfo(this)">

                                <div id="upload-placeholder">
                                    <i class="fa-solid fa-file-csv text-6xl text-green-300 group-hover:text-green-500 transition-colors mb-4"></i>
                                    <p class="text-gray-600 font-bold text-lg">Selecciona el archivo <span class="text-green-600 font-black italic">usuarios.csv</span></p>
                                    <p class="text-gray-400 text-xs mt-1 uppercase tracking-widest font-black italic">Separador: Punto y Coma (;)</p>
                                </div>

                                <div id="file-info" class="hidden">
                                    <i class="fa-solid fa-file-circle-check text-6xl text-green-500 mb-4"></i>
                                    <p id="file-name-display" class="text-gray-800 font-black text-xl italic"></p>
                                    <button type="button" onclick="resetFile()" class="mt-4 text-xs text-red-500 font-bold uppercase hover:underline">Cambiar archivo</button>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-5 rounded-2xl shadow-xl transition-all flex items-center justify-center uppercase tracking-widest text-sm">
                                <i class="fa-solid fa-bolt mr-2"></i> Iniciar Importación de 304 Registros
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Resumen de Mapeo para seguridad del usuario --}}
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-4">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Seguridad</p>
                        <p class="text-xs font-bold text-gray-700">Contraseña base: coo123perativa</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center">
                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mr-4">
                        <i class="fa-solid fa-piggy-bank"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Ahorros</p>
                        <p class="text-xs font-bold text-gray-700">Se cargarán Guía y Guía Retirable</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function updateInfo(input) {
        if(input.files && input.files[0]) {
            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('file-info').classList.remove('hidden');
            document.getElementById('file-name-display').innerText = input.files[0].name;
        }
    }
    function resetFile() {
        document.getElementById('archivo_csv').value = '';
        document.getElementById('upload-placeholder').classList.remove('hidden');
        document.getElementById('file-info').classList.add('hidden');
    }
    </script>
</x-app-layout>
