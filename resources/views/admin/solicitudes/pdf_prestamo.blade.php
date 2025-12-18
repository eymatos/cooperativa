<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COOPROCON - Solicitud de Préstamo #{{ $solicitud->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page { size: letter; margin: 0; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; margin: 0; padding: 0; }
            .print-container {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                width: 100% !important;
                height: 100vh;
                padding: 1.5cm !important;
            }
        }
        .data-underline {
            border-bottom: 1.5px solid #000;
            padding: 0 8px;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-block;
            line-height: 1;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- BARRA DE HERRAMIENTAS (No se imprime) --}}
    <div class="no-print sticky top-0 bg-gray-900 text-white p-4 z-50 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-3 ml-4">
            <span class="bg-indigo-600 px-2 py-0.5 rounded text-[9px] font-black uppercase italic">SOLICITUD DE CRÉDITO</span>
            <h1 class="text-xs font-bold text-gray-300 italic">ID #{{ $solicitud->id }} - {{ $solicitud->datos['nombre_completo'] }}</h1>
        </div>
        <div class="flex gap-3 mr-4">
            <button onclick="window.print()" class="bg-green-600 hover:bg-green-500 text-white px-5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2 shadow-lg">
                📥 DESCARGAR / IMPRIMIR PDF
            </button>
            <button onclick="window.close()" class="bg-gray-700 text-white px-5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest">
                CERRAR
            </button>
        </div>
    </div>

    {{-- HOJA DE SOLICITUD --}}
    <div class="print-container max-w-[850px] mx-auto bg-white p-12 my-6 shadow-xl border border-gray-200 relative min-h-[1050px]">

        {{-- ENCABEZADO --}}
        <div class="text-center mb-8 border-b-2 border-gray-100 pb-6">
            <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tighter italic mb-1">COOPROCON</h2>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-1">Cooperativa de Ahorros, Créditos y Servicios Múltiples</p>
            <div class="mt-4 inline-block bg-indigo-100 text-indigo-800 px-8 py-2 rounded-full text-[11px] font-black uppercase tracking-widest border border-indigo-200 italic">
                Formulario Unificado de Solicitud y Autorización de Préstamo
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-8">
            <div class="text-[10px] font-bold text-gray-400 uppercase italic">
                Fecha de Emisión: <span class="text-gray-800">{{ $solicitud->created_at->format('d/m/Y h:i A') }}</span>
            </div>
            <div class="text-right text-[10px] font-bold text-gray-400 uppercase italic">
                Tipo de Préstamo: <span class="text-indigo-600 font-black">{{ $solicitud->datos['tipo_prestamo'] }}</span>
            </div>
        </div>

        {{-- SECCIÓN 1: DATOS PERSONALES --}}
        <div class="space-y-6 text-[14px] leading-relaxed italic">
            <h3 class="font-black text-gray-900 uppercase border-l-4 border-indigo-600 pl-3 tracking-tighter">I. Información del Solicitante</h3>
            <p>
                Yo, <span class="data-underline">{{ $solicitud->datos['nombre_completo'] }}</span>,
                portador de la cédula No. <span class="data-underline">{{ $solicitud->datos['cedula'] }}</span>,
                en mi calidad de socio de **COOPROCON**, solicito formalmente la aprobación de un crédito por la suma de:
            </p>

            <div class="bg-gray-50 border-2 border-dashed border-gray-200 p-6 rounded-3xl text-center">
                <span class="text-3xl font-black text-indigo-700 font-mono">RD$ {{ number_format($solicitud->datos['monto_solicitado'], 2) }}</span>
                <p class="text-[9px] font-black text-gray-400 uppercase mt-1 tracking-widest">Monto Principal Solicitado</p>
            </div>

            <p>
                Para ser amortizado en un plazo de <span class="data-underline">{{ $solicitud->datos['cantidad_cuotas'] }}</span> cuotas mensuales,
                destinando dichos fondos para: <span class="data-underline">{{ $solicitud->datos['destino'] }}</span>.
            </p>
        </div>

        {{-- SECCIÓN 2: GARANTE (Si existe) --}}
        @if(!empty($solicitud->datos['nombre_garante']))
        <div class="mt-10 space-y-4 text-[13px] bg-gray-50 p-6 rounded-3xl border border-gray-100 italic">
            <h3 class="font-black text-gray-800 uppercase tracking-tighter">II. Información del Garante</h3>
            <p>Nombre: <span class="font-bold uppercase">{{ $solicitud->datos['nombre_garante'] }}</span></p>
            <p>Cédula: <span class="font-bold">{{ $solicitud->datos['cedula_garante'] }}</span> | Tel: <span class="font-bold">{{ $solicitud->datos['celular_garante'] }}</span></p>
        </div>
        @endif

        {{-- SECCIÓN 3: AUTORIZACIÓN LEGAL --}}
        <div class="mt-10 space-y-4 text-[13px] leading-relaxed text-justify italic">
            <h3 class="font-black text-gray-900 uppercase border-l-4 border-indigo-600 pl-3 tracking-tighter">III. Autorización de Descuento</h3>
            <p>
                Por medio de la presente, autorizo formalmente a la institución **PRO CONSUMIDOR** a realizar los descuentos mensuales de mi salario para el pago de las cuotas del préstamo solicitado.
                <strong>Párrafo:</strong> En caso de que se produzca mi desvinculación de la institución por cualquier causa, autorizo irrevocablemente a que el saldo pendiente de este préstamo sea descontado de mis prestaciones laborales y entregado a la Cooperativa.
            </p>
        </div>

        {{-- FIRMAS --}}
        <div class="mt-24 grid grid-cols-2 gap-20 px-10">
            <div class="text-center border-t border-gray-800 pt-3">
                <p class="text-[10px] font-black uppercase tracking-widest">Firma del Socio</p>
                <p class="text-[8px] text-gray-400 mt-1">Validación Digital Bio-ID</p>
            </div>
            <div class="text-center border-t border-gray-800 pt-3">
                <p class="text-[10px] font-black uppercase tracking-widest">Garante / Sello Cooprocon</p>
                <p class="text-[8px] text-gray-400 mt-1">Recibido para Evaluación</p>
            </div>
        </div>

        {{-- PIE DE PÁGINA --}}
        <div class="absolute bottom-10 left-0 right-0 px-12">
            <div class="flex justify-between items-end border-t border-gray-100 pt-4 text-[9px] font-mono text-gray-400">
                <div>SOLICITUD DIGITAL: #REQ-PR-{{ str_pad($solicitud->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div>AUTENTICADO: {{ Auth::user()->email }}</div>
            </div>
        </div>
    </div>
</body>
</html>
