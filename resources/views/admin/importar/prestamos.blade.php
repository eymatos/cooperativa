<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
            {{ __('Migración Histórica de Préstamos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100">
                {{-- Banner Informativo --}}
                <div class="bg-linear-to-br from-emerald-600 via-teal-700 to-cyan-600 p-10 text-white relative">
                    <div class="relative z-10">
                        <h3 class="text-3xl font-black uppercase italic leading-none mb-2">Carga de Préstamos</h3>
                        <p class="text-emerald-100 text-sm font-bold opacity-80">El sistema generará el préstamo, su tabla de amortización y aplicará pagos automáticos hasta Diciembre 2025.</p>
                    </div>
                    <div class="absolute right-0 bottom-0 p-4 opacity-10 text-9xl">💰</div>
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

                    <form action="{{ route('admin.importar.prestamos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 gap-8">
                            {{-- Selector de Tipo de Préstamo --}}
                            <div>
                                <label class="block text-[10px] font-black uppercase text-gray-400 mb-3 tracking-[0.2em] italic">1. Tipo de Préstamo a Importar</label>
                                <select name="tipo_prestamo_id" required class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 font-black text-teal-600 focus:ring-4 focus:ring-teal-100 transition shadow-inner appearance-none">
                                    <option value="">Seleccione el tipo...</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ strtoupper($tipo->nombre) }} (Tasa: {{ $tipo->tasa_interes }}%)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Área de Carga --}}
                        <div class="relative group">
                            <label class="block text-[10px] font-black uppercase text-gray-400 mb-3 tracking-[0.2em] italic">2. Archivo CSV (Préstamos)</label>
                            <div class="border-2 border-dashed border-gray-200 rounded-4xl p-16 text-center hover:bg-gray-50 transition cursor-pointer relative group-hover:border-teal-300">
                                <input type="file" name="archivo_csv" accept=".csv" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName(input = this)">

                                <div id="placeholder-file">
                                    <div class="w-16 h-16 bg-teal-50 text-teal-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-file-invoice-dollar text-3xl"></i>
                                    </div>
                                    <p class="text-gray-400 font-bold text-xs uppercase tracking-widest">Arrastra el archivo aquí o haz clic</p>
                                </div>

                                <div id="info-file" class="hidden">
                                    <div class="w-16 h-16 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fa-solid fa-check-double text-3xl"></i>
                                    </div>
                                    <p id="file-name" class="text-teal-600 font-black text-lg italic"></p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Archivo de préstamos listo</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white py-6 rounded-3xl font-black uppercase tracking-[0.3em] text-sm shadow-xl shadow-teal-100 transition-all transform hover:-translate-y-1 active:scale-95">
                            🚀 Importar Cartera de Préstamos
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
