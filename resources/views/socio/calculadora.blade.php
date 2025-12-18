<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight italic uppercase tracking-tighter">
            {{ __('Simulador de Préstamos Personal') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="calculadoraPrestamo()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-2 bg-indigo-600"></div>
                        <h3 class="text-xl font-black text-gray-800 mb-8 uppercase tracking-tighter italic">Parámetros</h3>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Monto a Solicitar (RD$)</label>
                                <input type="number" x-model="monto"
                                    class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl font-bold text-gray-700 focus:ring-4 focus:ring-indigo-100 transition-all outline-none text-lg">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Tasa de Interés Anual (%)</label>
                                <input type="number" x-model="tasa"
                                    class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl font-bold text-gray-700 focus:ring-4 focus:ring-indigo-100 transition-all outline-none">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Plazo (Meses)</label>
                                <select x-model="plazo" class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl font-bold text-gray-700 focus:ring-4 focus:ring-indigo-100 transition-all outline-none">
                                    <option value="6">6 Meses</option>
                                    <option value="12">12 Meses</option>
                                    <option value="18">18 Meses</option>
                                    <option value="24">24 Meses</option>
                                    <option value="36">36 Meses</option>
                                    <option value="48">48 Meses</option>
                                </select>
                            </div>

                            <button @click="calcular()" class="w-full bg-gray-900 text-white py-5 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-indigo-600 transition-all shadow-xl flex items-center justify-center gap-2">
                                🚀 Generar Simulación
                            </button>
                        </div>
                    </div>

                    <template x-if="cuotaMensual > 0">
                        <div class="mt-6 bg-indigo-700 p-8 rounded-[2.5rem] text-white shadow-xl transform animate-bounce-short">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-60 mb-2">Cuota Mensual Estimada</p>
                            <h4 class="text-4xl font-black font-mono" x-text="formatMoney(cuotaMensual)"></h4>
                            <div class="mt-4 pt-4 border-t border-indigo-500/50 flex justify-between text-[10px] font-bold uppercase italic">
                                <span>Total Interés:</span>
                                <span x-text="formatMoney(totalInteres)"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden min-h-[400px]">
                        <div class="p-8 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-lg font-black text-gray-800 uppercase tracking-tighter italic">Tabla de Amortización Proyectada</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] border-b">
                                        <th class="p-6">No.</th>
                                        <th class="p-6">Capital</th>
                                        <th class="p-6">Interés</th>
                                        <th class="p-6">Cuota Total</th>
                                        <th class="p-6 text-right">Balance</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 font-mono text-xs">
                                    <template x-for="fila in tabla" :key="fila.numero">
                                        <tr class="hover:bg-indigo-50/30 transition-colors">
                                            <td class="p-6 font-black text-gray-400" x-text="fila.numero"></td>
                                            <td class="p-6 font-bold text-gray-600" x-text="formatMoney(fila.capital)"></td>
                                            <td class="p-6 font-bold text-gray-600" x-text="formatMoney(fila.interes)"></td>
                                            <td class="p-6 font-black text-indigo-600" x-text="formatMoney(fila.cuota)"></td>
                                            <td class="p-6 text-right font-black text-gray-800" x-text="formatMoney(fila.balance)"></td>
                                        </tr>
                                    </template>
                                    <template x-if="tabla.length === 0">
                                        <tr>
                                            <td colspan="5" class="p-20 text-center text-gray-300 uppercase font-black text-[10px] tracking-[0.5em]">
                                                Esperando parámetros...
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function calculadoraPrestamo() {
            return {
                monto: 50000,
                tasa: 18,
                plazo: 12,
                tabla: [],
                cuotaMensual: 0,
                totalInteres: 0,

                calcular() {
                    this.tabla = [];
                    const p = parseFloat(this.monto);
                    const r = (parseFloat(this.tasa) / 100) / 12;
                    const n = parseInt(this.plazo);

                    // Fórmula de cuota fija (Francés)
                    const cuota = (p * r) / (1 - Math.pow(1 + r, -n));
                    this.cuotaMensual = cuota;

                    let balance = p;
                    let acumuladoInteres = 0;

                    for (let i = 1; i <= n; i++) {
                        let interes = balance * r;
                        let capital = cuota - interes;
                        balance -= capital;
                        acumuladoInteres += interes;

                        this.tabla.push({
                            numero: i,
                            capital: capital,
                            interes: interes,
                            cuota: cuota,
                            balance: Math.abs(balance) < 0.01 ? 0 : balance
                        });
                    }
                    this.totalInteres = acumuladoInteres;
                },

                formatMoney(amount) {
                    return new Intl.NumberFormat('es-DO', {
                        style: 'currency',
                        currency: 'DOP',
                    }).format(amount);
                }
            }
        }
    </script>

    <style>
        .animate-bounce-short {
            animation: bounce 1s ease-in-out 1;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</x-app-layout>
