<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase italic tracking-tighter">
            ⚖️ Gestión de Excedentes (Ley 127-64)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Formulario de Cálculo --}}
            <div class="bg-white p-10 rounded-[3rem] shadow-xl border border-gray-100">
                <form action="{{ route('admin.excedentes.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase italic mb-2">Año Fiscal</label>
                        <input type="number" name="anio" value="{{ date('Y')-1 }}" class="w-full border-gray-100 bg-gray-50 rounded-2xl font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase italic mb-2">Excedente Bruto (RD$)</label>
                        <input type="number" step="0.01" name="excedente_bruto" id="ebru" class="w-full border-gray-100 bg-gray-50 rounded-2xl font-bold text-indigo-600" oninput="recalcular()">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase italic mb-2">% Capitalización (Ahorros)</label>
                        <input type="number" step="0.1" name="pct_capitalizacion" class="w-full border-gray-100 bg-gray-50 rounded-2xl font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase italic mb-2">% Patrocinio (Intereses)</label>
                        <input type="number" step="0.1" name="pct_patrocinio" class="w-full border-gray-100 bg-gray-50 rounded-2xl font-bold">
                    </div>
                    <div class="md:col-span-4 border-t pt-6 flex justify-between items-center">
                        <div class="text-sm font-medium italic text-gray-500">
                            Reserva Legal (10%): <span id="r_legal" class="font-black text-gray-800">RD$ 0.00</span> |
                            Educación (5%): <span id="r_edu" class="font-black text-gray-800">RD$ 0.00</span>
                        </div>
                        <button type="submit" class="bg-gray-900 text-white px-10 py-4 rounded-2xl font-black uppercase italic text-xs tracking-widest hover:bg-indigo-600 transition-all shadow-xl">
                            Procesar Reparto Anual
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function recalcular() {
            let bruto = document.getElementById('ebru').value;
            document.getElementById('r_legal').innerText = "RD$ " + (bruto * 0.10).toLocaleString();
            document.getElementById('r_edu').innerText = "RD$ " + (bruto * 0.05).toLocaleString();
        }
    </script>
</x-app-layout>
