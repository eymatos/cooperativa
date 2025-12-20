<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
            {{ __('Migración Histórica de Ahorros (2011-2025)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100">
                {{-- Banner Informativo --}}
                <div class="bg-linear-to-br from-indigo-700 via-purple-700 to-pink-600 p-10 text-white relative">
                    <div class="relative z-10">
                        <h3 class="text-3xl font-black uppercase italic leading-none mb-2">Carga de Movimientos</h3>
                        <p class="text-indigo-100 text-sm font-bold opacity-80">El sistema convertirá cada mes del CSV en una transacción individual en el historial del socio.</p>
                    </div>
                    <div class="absolute right-0 bottom-0 p-4 opacity-10 text-9xl">📅</div>
                </div>

                <div class="p-12">
                    @if(session('success'))
                        <div class="mb-8 p-5 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-r-2xl flex items-center shadow-sm">
                            <i class="fa-solid fa-circle-check text-2xl mr-4 text-green-500"></i>
                            <span class="font-black uppercase text-xs tracking-widest">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-8 p-5 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-2xl flex items-center shadow-sm">
                            <i class="fa-solid fa-triangle-exclamation text-2xl mr-4 text-red-500"></i>
                            <span class="font-black uppercase text-xs tracking-widest">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('admin.importar.historial.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Selector de Año --}}
                            <div>
                                <label class="block text-[10px] font-black uppercase text-gray-400 mb-3 tracking-[0.2em] italic">1. Seleccionar Año Fiscal</label>
                                <select name="anio" required class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 font-black text-indigo-600 focus:ring-4 focus:ring-indigo-100 transition shadow-inner appearance-none">
                                    @for($i = 2011; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" {{ $i == 2011 ? 'selected' : '' }}>Año {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            {{-- Selector de Tipo --}}
                            <div>
                                <label class="block text-[10px] font-black uppercase text-gray-400 mb-3 tracking-[0.2em] italic">2. Tipo de Ahorro</label>
                                <select name="saving_type_id" required class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 font-black text-indigo-600 focus:ring-4 focus:ring-indigo-100 transition shadow-inner appearance-none">
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ strtoupper($tipo->name) }} ({{ $tipo->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Área de Carga --}}
                        <div class="relative group">
                            <label class="block text-[10px] font-black uppercase text-gray-400 mb-3 tracking-[0.2em] italic">3. Archivo CSV</label>
                            <div class="border-2 border-dashed border-gray-200 rounded-4xl p-16 text-center hover:bg-gray-50 transition cursor-pointer relative group-hover:border-indigo-300">
                                <input type="file" name="archivo_csv" accept=".csv" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName(this)">

                                <div id="placeholder-file">
                                    <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-file-csv text-3xl"></i>
                                    </div>
                                    <p class="text-gray-400 font-bold text-xs uppercase tracking-widest">Arrastra el archivo aquí o haz clic</p>
                                </div>

                                <div id="info-file" class="hidden">
                                    <div class="w-16 h-16 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fa-solid fa-check-double text-3xl"></i>
                                    </div>
                                    <p id="file-name" class="text-indigo-600 font-black text-lg italic"></p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Listo para procesar</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-6 rounded-3xl font-black uppercase tracking-[0.3em] text-sm shadow-xl shadow-indigo-100 transition-all transform hover:-translate-y-1 active:scale-95">
                            ⚡ Iniciar Migración Masiva
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            if (input.files && input.files[0]) {
                document.getElementById('placeholder-file').classList.add('hidden');
                document.getElementById('info-file').classList.remove('hidden');
                document.getElementById('file-name').innerText = input.files[0].name;
            }
        }
    </script>
</x-app-layout>
