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

                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Socio Solicitante</label>
                                <select name="user_id" id="user_id" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">-- Seleccione un Socio --</option>
                                    @foreach($socios as $socio)
                                        <option value="{{ $socio->id }}"
                                            {{ (isset($socioPreseleccionado) && $socioPreseleccionado == $socio->id) ? 'selected' : '' }}>

                                            {{ $socio->nombres ?? $socio->name }} (Cédula: {{ $socio->cedula }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

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
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio"
                                       value="{{ date('Y-m-d') }}"
                                       class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Monto del Préstamo</label>
                                <input type="number" name="monto" id="monto" step="0.01" min="100"
                                       class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                       placeholder="Ej: 10000" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Tasa de Interés ANUAL (%)</label>
                                <input type="number" name="tasa_interes" id="tasa_interes" step="0.01"
                                       class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-50"
                                       placeholder="Se llena automático..." required>
                                <p class="text-xs text-gray-500 mt-1">* Se auto-completa según el tipo, pero es editable.</p>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Plazo (Meses)</label>
                                <input type="number" name="plazo" id="plazo" min="1" step="1"
                                       class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-50"
                                       placeholder="Se llena automático..." required>
                            </div>
                        </div>

                        <div class="mt-8 flex gap-4">
                            <button type="button" onclick="simularPrestamo()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition ease-in-out duration-150">
                                🔄 Calcular Tabla
                            </button>

                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring ring-green-300 transition ease-in-out duration-150">
                                💾 Guardar Préstamo
                            </button>
                        </div>
                    </form>

                    <hr class="my-8 border-gray-200">

                    <div id="resultado-simulacion" class="hidden">
                        <h3 class="text-lg font-bold mb-4 text-gray-800">Tabla de Amortización Preliminar</h3>
                        <div class="overflow-x-auto border rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cuota</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Interés</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capital</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-body" class="bg-white divide-y divide-gray-200"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. FUNCIÓN PARA AUTO-COMPLETAR TASA Y PLAZO
        function actualizarValores() {
            const select = document.getElementById('tipo_prestamo');
            const opcion = select.options[select.selectedIndex];

            const inputTasa = document.getElementById('tasa_interes');
            const inputPlazo = document.getElementById('plazo');

            // Leer atributos data
            const tasa = opcion.getAttribute('data-tasa');
            const plazo = opcion.getAttribute('data-plazo');

            if (tasa) inputTasa.value = tasa;
            else inputTasa.value = '';

            if (plazo) inputPlazo.value = plazo;
            else inputPlazo.value = ''; // Si es abierto (null), lo limpia para escribir manual
        }

        // 2. FUNCIÓN PARA SIMULAR TABLA (AJAX)
        async function simularPrestamo() {
            const monto = document.getElementById('monto').value;
            const tasa = document.getElementById('tasa_interes').value;
            const plazo = document.getElementById('plazo').value;
            const fecha = document.getElementById('fecha_inicio').value;

            if (!monto || !tasa || !plazo) {
                alert("Completa todos los campos para calcular.");
                return;
            }

            const datos = {
                monto: monto,
                tasa_interes: tasa,
                plazo: plazo,
                fecha_inicio: fecha
            };

            try {
                const response = await fetch("{{ route('prestamos.simular') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(datos)
                });

                if (!response.ok) throw new Error("Error en cálculo");

                const tabla = await response.json();
                const tbody = document.getElementById('tabla-body');
                tbody.innerHTML = "";

                tabla.forEach(fila => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">${fila.numero_cuota}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${fila.fecha_vencimiento}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">${fila.monto_total}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">${fila.interes}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">${fila.capital}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${fila.saldo_restante}</td>
                    `;
                    tbody.appendChild(tr);
                });

                document.getElementById('resultado-simulacion').classList.remove('hidden');

            } catch (error) {
                console.error(error);
                alert("Error al simular. Revisa la consola.");
            }
        }
    </script>
</x-app-layout>
