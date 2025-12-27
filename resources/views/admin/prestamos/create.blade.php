<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Préstamo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('admin.prestamos.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            {{-- SECCIÓN DE IDENTIFICACIÓN --}}
                            <div class="space-y-4">
                                <div>
                                    <label class="block font-bold text-gray-700 mb-2">Socio Solicitante</label>
                                    <select name="user_id" class="w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">-- Seleccione Socio --</option>
                                        @foreach($socios as $usuario)
                                            <option value="{{ $usuario->id }}"
                                                {{ (isset($socioPreseleccionado) && $socioPreseleccionado == $usuario->id) ? 'selected' : '' }}>
                                                {{ $usuario->socio->nombres ?? $usuario->name }} {{ $usuario->socio->apellidos ?? '' }} ({{ $usuario->cedula }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- CAMPO PARA NÚMERO DE PRÉSTAMO MANUAL --}}
                                <div class="bg-gray-50 p-3 rounded-md border border-gray-200">
                                    <label class="block font-black text-sm text-gray-800 mb-1 uppercase tracking-tighter">Número de Préstamo (Manual)</label>
                                    <input type="text" name="numero_prestamo" id="numero_prestamo"
                                           class="w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm font-mono text-lg text-red-600 font-bold"
                                           placeholder="Ej: 2026-001" required value="{{ old('numero_prestamo') }}">
                                    <p class="text-[10px] text-gray-500 mt-1 font-bold italic">* Ingrese el código correlativo correspondiente al año.</p>
                                    @error('numero_prestamo')
                                        <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700 mb-1">Tipo de Préstamo</label>
                                    <select name="tipo_prestamo_id" id="tipo_prestamo"
                                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            required onchange="actualizarValores()">
                                        <option value="">-- Seleccione Tipo --</option>
                                        @foreach($tiposPrestamo as $tipo)
                                            <option value="{{ $tipo->id }}"
                                                    data-tasa="{{ $tipo->tasa_interes }}"
                                                    data-plazo="{{ $tipo->plazo_defecto }}">
                                                {{ $tipo->nombre }} ({{ $tipo->tasa_interes }}% Anual)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="bg-blue-50 p-3 rounded-md border border-blue-100">
                                    <label class="block font-bold text-sm text-blue-700 mb-1">Fecha del Primer Pago</label>
                                    <input type="date" name="fecha_primer_pago" id="fecha_primer_pago"
                                           class="w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                    <p class="text-[10px] text-blue-500 mt-1 font-bold italic">* Opcional. Úselo para diferir el cobro (ej: de Diciembre a Febrero).</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Fecha Inicio (Desembolso)</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio"
                                       value="{{ date('Y-m-d') }}"
                                       class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Monto del Préstamo (RD$)</label>
                                <input type="number" name="monto" id="monto" step="0.01" min="100"
                                       class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                       placeholder="Ej: 10000" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Tasa de Interés ANUAL (%)</label>
                                <input type="number" name="tasa_interes" id="tasa_interes" step="0.01"
                                       class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-50 font-bold"
                                       placeholder="Se llena automático..." required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Plazo (Meses)</label>
                                <input type="number" name="plazo" id="plazo" min="1" step="1"
                                       class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-50 font-bold"
                                       placeholder="Se llena automático..." required>
                            </div>
                        </div>

                        <div class="mt-8 flex gap-4">
                            <button type="button" onclick="simularPrestamo()" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-black text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition shadow-md">
                                🔄 Calcular Tabla
                            </button>

                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-black text-xs text-white uppercase tracking-widest hover:bg-green-700 transition shadow-md">
                                💾 Guardar Préstamo
                            </button>
                        </div>
                    </form>

                    <hr class="my-8 border-gray-200">

                    <div id="resultado-simulacion" class="hidden">
                        <h3 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2 uppercase italic tracking-tighter">
                            <span class="p-1 bg-blue-100 rounded text-xs text-blue-600">📊</span> Tabla de Amortización Preliminar
                        </h3>
                        <div class="overflow-x-auto border rounded-2xl shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest italic"># Cuota</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest italic">Fecha Pago</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest italic">Monto Total</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest italic">Interés</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest italic">Capital</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest italic">Saldo Restante</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-body" class="bg-white divide-y divide-gray-100 font-mono text-sm"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function actualizarValores() {
            const select = document.getElementById('tipo_prestamo');
            const opcion = select.options[select.selectedIndex];
            const inputTasa = document.getElementById('tasa_interes');
            const inputPlazo = document.getElementById('plazo');

            const tasa = opcion.getAttribute('data-tasa');
            const plazo = opcion.getAttribute('data-plazo');

            if (tasa) inputTasa.value = tasa;
            if (plazo) inputPlazo.value = plazo;
        }

        async function simularPrestamo() {
            const monto = document.getElementById('monto').value;
            const tasa = document.getElementById('tasa_interes').value;
            const plazo = document.getElementById('plazo').value;
            const fecha = document.getElementById('fecha_inicio').value;
            const fecha_pago = document.getElementById('fecha_primer_pago').value;

            if (!monto || !tasa || !plazo) {
                alert("Completa monto, tasa y plazo para calcular.");
                return;
            }

            const datos = {
                monto: monto,
                tasa_interes: tasa,
                plazo: plazo,
                fecha_inicio: fecha,
                fecha_primer_pago: fecha_pago
            };

            try {
                // CORRECCIÓN AQUÍ: Se cambió admin.prestamos.simular por admin.admin.prestamos.simular
                // o simplemente prestamos.simular segun este en tu web.php
                const response = await fetch("{{ route('admin.prestamos.simular') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(datos)
                });

                const tabla = await response.json();
                const tbody = document.getElementById('tabla-body');
                tbody.innerHTML = "";

                tabla.forEach(fila => {
                    const tr = document.createElement('tr');
                    tr.className = "hover:bg-gray-50 transition-colors";
                    tr.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-bold">${fila.numero_cuota}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs font-black text-blue-600">${fila.fecha_vencimiento}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs font-black text-gray-900 text-right">RD$ ${parseFloat(fila.monto_total).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-red-500 text-right">RD$ ${parseFloat(fila.interes).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-green-600 text-right">RD$ ${parseFloat(fila.capital).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400 text-right">RD$ ${parseFloat(fila.saldo_restante).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                    `;
                    tbody.appendChild(tr);
                });

                document.getElementById('resultado-simulacion').classList.remove('hidden');

            } catch (error) {
                console.error(error);
                alert("Error al simular. Verifique los datos ingresados.");
            }
        }
    </script>
</x-app-layout>
