<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight italic">
            {{ __('Mi Perfil de Socio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-2 bg-green-500"></div>
                        <div class="text-center mb-6">
                            <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto flex items-center justify-center text-3xl mb-4 border-4 border-white shadow-lg">
                                👤
                            </div>
                            <h3 class="text-lg font-black text-gray-800 uppercase tracking-tighter">{{ $socio->nombres }}</h3>
                            <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest italic">Socio No. {{ str_pad($socio->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>

                        <div class="space-y-4 border-t pt-6">
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Cédula</p>
                                <p class="text-sm font-bold text-gray-700 font-mono">{{ $user->cedula }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Teléfono</p>
                                <p class="text-sm font-bold text-gray-700">{{ $socio->telefono ?? 'No registrado' }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Cargo / Lugar</p>
                                <p class="text-sm font-bold text-gray-700">{{ $socio->lugar_trabajo }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-2 bg-indigo-600"></div>
                        <h3 class="text-xl font-black text-gray-800 uppercase tracking-tighter mb-8 italic">Configuración de Acceso</h3>

                        @if(session('success'))
                            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm font-bold rounded-r-xl">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('socio.perfil.update') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Correo Electrónico</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl font-bold text-gray-700 focus:ring-4 focus:ring-indigo-100 transition-all outline-none">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Nueva Contraseña (Opcional)</label>
                                    <input type="password" name="password"
                                        class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl font-bold text-gray-700 focus:ring-4 focus:ring-indigo-100 transition-all outline-none" placeholder="••••••••">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Confirmar Nueva Contraseña</label>
                                    <input type="password" name="password_confirmation"
                                        class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl font-bold text-gray-700 focus:ring-4 focus:ring-indigo-100 transition-all outline-none" placeholder="••••••••">
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="bg-gray-900 text-white px-8 py-4 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-gray-200">
                                    Actualizar Mis Datos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
