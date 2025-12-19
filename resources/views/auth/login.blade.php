<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Sistema Cooperativa</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-600 rounded-4xl shadow-xl shadow-indigo-100 mb-4 transform -rotate-6">
                <span class="text-white text-4xl font-black italic font-sans">C</span>
            </div>
            <h1 class="text-2xl font-black text-gray-800 uppercase tracking-tighter">Sistema Cooperativa</h1>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mt-1 italic">Acceso Seguro • Gestión Financiera</p>
        </div>

        <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-2xl shadow-gray-200/50 rounded-[2.5rem] border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-linear-to-r from-indigo-500 via-purple-500 to-orange-500"></div>

            <h2 class="text-xl font-black text-gray-800 mb-8 uppercase tracking-tight text-center italic">Ingreso al Portal</h2>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                    <p class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-1 italic">Acceso Denegado</p>
                    <p class="text-sm text-red-700 font-medium">{{ $errors->first() }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf
{{-- Bloque de mensajes de éxito --}}
@if (session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm flex items-center gap-3">
        <span class="text-xl">✅</span>
        <div>
            <p class="text-[10px] font-black uppercase tracking-widest italic">¡Recibido!</p>
            <p class="text-xs font-bold">{{ session('success') }}</p>
        </div>
    </div>
@endif

{{-- Bloque de mensajes de error (por si algo falla) --}}
@if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
        <ul class="list-disc list-inside text-xs font-bold">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Cédula del Socio / Admin</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-300">
                            <i class="fa-solid fa-id-card text-lg"></i>
                        </span>
                        <input id="cedula" type="text" name="cedula" value="{{ old('cedula') }}" required autofocus
                            class="w-full pl-12 pr-4 py-4 bg-gray-50 border-none rounded-2xl font-black text-gray-700 focus:ring-4 focus:ring-indigo-100 transition-all text-sm outline-none"
                            placeholder="000-0000000-0">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Contraseña</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-300">
                            <i class="fa-solid fa-lock text-lg"></i>
                        </span>
                        <input id="password" type="password" name="password" required
                            class="w-full pl-12 pr-4 py-4 bg-gray-50 border-none rounded-2xl font-black text-gray-700 focus:ring-4 focus:ring-indigo-100 transition-all text-sm outline-none"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-5 bg-gray-900 text-white rounded-3xl font-black uppercase tracking-widest text-xs hover:bg-indigo-600 shadow-xl shadow-indigo-100 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 italic">
                        <i class="fa-solid fa-rocket mr-1"></i>
                        Entrar al Panel
                    </button>
                    <div class="mt-6 text-center">
                        <a href="{{ route('quienes-somos') }}" class="text-[10px] font-black text-indigo-500 uppercase tracking-widest hover:text-indigo-700 underline decoration-2 underline-offset-4">
                            Quienes somos?
                        </a>
                        <a href="{{ route('formularios.publicos') }}" class="block text-[10px] font-black text-indigo-500 uppercase tracking-widest hover:text-indigo-800 underline decoration-2 underline-offset-4 italic">
                            ¿Deseas ser Socio?
                        </a>
                    </div>
                </div>
            </form>

            <div class="mt-8 text-center border-t border-gray-50 pt-6">
                <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest italic">
                    © 2025 COOPERATIVA V.1.0 • SEGURIDAD DE NIVEL 4
                </p>
            </div>
        </div>
    </div>
</body>
</html>
