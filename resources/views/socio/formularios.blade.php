<x-app-layout>
    @php
        $publico = $publico ?? false;

        // Definimos las rutas para cada ID de servicio
        // El ID 1 apunta a la vista del formulario de inscripción que creamos
        $rutas = [
            1 => route('socio.formularios.inscripcion'),
            2 => '#', // Próximamente: formulario digital de ahorro normal
            3 => '#', // Próximamente: formulario digital de inscripción ahorro retirable
            4 => '#',
            5 => '#',
            6 => '#',
            7 => '#',
            8 => '#',
        ];
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight italic uppercase tracking-tighter">
            {{ $publico ? '📑 Solicitud de Ingreso Digital' : '⚡ Centro de Servicios Digitales' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @php
                    $servicios = [
                        ['id' => 1, 'titulo' => 'Solicitud de Inscripción', 'desc' => 'Inicia tu proceso para formar parte de nuestra cooperativa.', 'icon' => 'fa-user-plus', 'color' => 'bg-green-600', 'publico' => true],
                        ['id' => 2, 'titulo' => 'Ahorro Normal', 'desc' => 'Modifica tu cuota o autoriza descuentos de aportación.', 'icon' => 'fa-piggy-bank', 'color' => 'bg-blue-500', 'publico' => false],
                        ['id' => 3, 'titulo' => 'Inscripción Ahorro Retirable', 'desc' => 'Abre tu cuenta de ahorro voluntario hoy mismo.', 'icon' => 'fa-wallet', 'color' => 'bg-orange-500', 'publico' => false],
                        ['id' => 4, 'titulo' => 'Gestión Ahorro Retirable', 'desc' => 'Aumenta o modifica tu descuento de ahorro voluntario.', 'icon' => 'fa-money-bill-transfer', 'color' => 'bg-orange-600', 'publico' => false],
                        ['id' => 5, 'titulo' => 'Solicitud de Préstamo', 'desc' => 'Aplica para un crédito personal de forma inmediata.', 'icon' => 'fa-hand-holding-dollar', 'color' => 'bg-indigo-600', 'publico' => false],
                        ['id' => 6, 'titulo' => 'Autorización de Préstamo', 'desc' => 'Firma digital de pagaré y autorización de nómina.', 'icon' => 'fa-file-signature', 'color' => 'bg-red-600', 'publico' => false],
                        ['id' => 7, 'titulo' => 'Pausa de Ahorro Retirable', 'desc' => 'Solicita la suspensión temporal de tus aportes voluntarios.', 'icon' => 'fa-circle-pause', 'color' => 'bg-gray-600', 'publico' => false],
                        ['id' => 8, 'titulo' => 'Retiro de Fondos', 'desc' => 'Solicita la entrega de tus ahorros retirables a tu cuenta.', 'icon' => 'fa-money-check-dollar', 'color' => 'bg-yellow-600', 'publico' => false],
                    ];

                    $filtrados = collect($servicios)->filter(fn($s) => $publico ? $s['publico'] : !$s['publico']);
                @endphp

                @foreach($filtrados as $s)
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 text-6xl">
                        <i class="fa-solid {{ $s['icon'] }}"></i>
                    </div>

                    <div class="inline-flex items-center justify-center w-14 h-14 {{ $s['color'] }} text-white rounded-2xl shadow-lg mb-6">
                        <i class="fa-solid {{ $s['icon'] }} text-xl"></i>
                    </div>

                    <h3 class="text-xl font-black text-gray-800 mb-2 uppercase tracking-tighter italic leading-tight">{{ $s['titulo'] }}</h3>
                    <p class="text-[11px] text-gray-500 font-medium mb-8 leading-relaxed italic">{{ $s['desc'] }}</p>

                    {{-- Vinculamos la ruta según el ID --}}
                    <a href="{{ $rutas[$s['id']] ?? '#' }}" class="inline-flex items-center justify-center gap-2 bg-gray-900 text-white px-6 py-3 rounded-xl font-black uppercase text-[10px] tracking-widest hover:bg-indigo-600 transition-all w-full">
                        Completar Solicitud <i class="fa-solid fa-chevron-right text-[8px]"></i>
                    </a>
                </div>
                @endforeach
            </div>

            @if($publico)
                <div class="mt-12 text-center">
                    <a href="{{ route('login') }}" class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] hover:text-indigo-800 underline decoration-2 underline-offset-8">
                        ← Volver al Portal
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
