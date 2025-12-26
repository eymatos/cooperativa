<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Préstamos Próximos a Vencer (45 días)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if($prestamosVenciendo->isEmpty())
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 shadow-md">
                    No hay préstamos programados para finalizar en los próximos 45 días.
                </div>
            @else
                @foreach($prestamosVenciendo as $tipo => $lista)
                    <div class="mb-10">
                        <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center">
                            <span class="bg-indigo-600 w-3 h-3 rounded-full mr-2"></span>
                            {{ $tipo }} ({{ $lista->count() }})
                        </h3>

                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Socio</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Préstamo</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Monto Original</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Fecha Final</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($lista as $p)
                                        @php
                                            $fechaFinal = \Carbon\Carbon::parse($p->cuotas->last()->fecha_vencimiento);
                                            $diasRestantes = now()->diffInDays($fechaFinal, false);
                                            $colorClase = $diasRestantes <= 15 ? 'text-red-600 bg-red-50' : 'text-orange-600 bg-orange-50';
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $p->socio->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $p->socio->cedula }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $p->numero_prestamo }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-700">
                                                RD$ {{ number_format($p->monto, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colorClase }}">
                                                    {{ $fechaFinal->format('d/m/Y') }}
                                                    ({{ $diasRestantes }} días)
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                                <a href="{{ route('admin.prestamos.show', $p->id) }}" class="text-indigo-600 hover:text-indigo-900 text-xs font-bold uppercase mr-2"> Ver Detalle</a>

                                                <form action="{{ route('admin.prestamos.marcar-pagado', $p->id) }}" method="POST" class="inline-block form-pagar">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1 rounded text-xs font-bold uppercase transition">
                                                        Marcar Pagado
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        document.querySelectorAll('.form-pagar').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('¿Está seguro de marcar este préstamo como PAGADO? Esto pondrá el saldo en cero y lo quitará de la lista de préstamos activos.')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</x-app-layout>
