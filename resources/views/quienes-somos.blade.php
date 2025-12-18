<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiénes Somos | COOPROCON</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-600 rounded-[2rem] shadow-xl mb-6 transform -rotate-6">
                <span class="text-white text-4xl font-black italic">C</span>
            </div>
            <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tighter italic">COOPROCON</h1>
            <p class="text-gray-500 font-bold mt-2 uppercase tracking-widest text-xs italic">Solidaridad y Ahorro</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl p-10 border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-500 to-indigo-600"></div>

            <section class="mb-10">
                <h2 class="text-2xl font-black mb-4 flex items-center gap-3 text-indigo-600 italic">
                    <i class="fa-solid fa-users text-xl"></i> ¿Quiénes somos?
                </h2>
                <p class="text-gray-600 leading-relaxed font-medium text-lg">
                    La Cooperativa de Ahorros, Créditos y Servicios Múltiples de los Empleados del Instituto Nacional de los Derechos del Consumidor, <span class="font-black text-gray-800">COOPROCON</span>, es una entidad que surge con el objetivo de promover y fortalecer el ejercicio de la solidaridad entre los socios y sus familias, así como también fomentar una cultura de ahorro y colaborar para que los asociados, empleados de Pro Consumidor, puedan atender necesidades individuales o familiares de carácter financiero, al tipo de interés más razonable posible.
                </p>
            </section>

            <div class="grid md:grid-cols-2 gap-8">
                <section>
                    <h2 class="text-xl font-black mb-4 flex items-center gap-3 text-indigo-600 italic">
                        <i class="fa-solid fa-file-invoice"></i> Documentación
                    </h2>
                    <ul class="space-y-3 font-bold text-sm">
                        <li>
                            <a href="#" class="group flex items-center gap-2 text-blue-600 hover:text-indigo-800 transition-colors">
                                <span class="p-2 bg-blue-50 rounded-lg group-hover:bg-blue-100">📄</span>
                                Estatutos Sociales
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group flex items-center gap-2 text-blue-600 hover:text-indigo-800 transition-colors">
                                <span class="p-2 bg-blue-50 rounded-lg group-hover:bg-blue-100">👥</span>
                                Directivos de la Cooperativa
                            </a>
                        </li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-black mb-4 flex items-center gap-3 text-indigo-600 italic">
                        <i class="fa-solid fa-circle-info"></i> Información Fiscal
                    </h2>
                    <div class="bg-gray-50 p-6 rounded-2xl border-l-4 border-indigo-500 space-y-4">
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">RNC Institucional</p>
                            <p class="text-sm font-black text-gray-700 font-mono tracking-tighter">4-30-14783-4</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">Entidad Bancaria</p>
                            <p class="text-sm font-black text-gray-700">BANRESERVAS</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">Cuenta Corriente</p>
                            <p class="text-sm font-black text-indigo-600 font-mono italic">162-003358-2</p>
                        </div>
                    </div>
                </section>
            </div>

            <div class="mt-12 text-center border-t border-gray-50 pt-8">
                @auth
                    {{-- Si el usuario está conectado --}}
                    <a href="{{ Auth::user()->tipo == 2 ? route('admin.dashboard') : route('socio.dashboard') }}"
                       class="inline-flex items-center gap-3 bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100">
                        <i class="fa-solid fa-house"></i> Volver a mi Panel
                    </a>
                @else
                    {{-- Si es un visitante externo --}}
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-3 bg-gray-900 text-white px-8 py-4 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-green-600 transition-all shadow-xl shadow-gray-200">
                        <i class="fa-solid fa-arrow-left"></i> Ir al Acceso
                    </a>
                @endauth
            </div>
        </div>

        <p class="text-center mt-8 text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">
            © 2025 COOPROCON • Sistema de Gestión de Derechos Reservados
        </p>
    </div>
</body>
</html>
