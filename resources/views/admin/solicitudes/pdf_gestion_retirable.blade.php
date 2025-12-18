<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>COOPROCON - Gestión Retirable #{{ $solicitud->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page { size: letter; margin: 0; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; margin: 0; padding: 0; }
            .print-container { box-shadow: none !important; border: none !important; margin: 0 !important; width: 100% !important; height: 100vh; padding: 1.5cm !important; }
        }
        .data-underline { border-bottom: 1.5px solid #1f2937; padding: 0 8px; font-weight: 800; text-transform: uppercase; display: inline-block; line-height: 1; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="no-print sticky top-0 bg-gray-900 text-white p-4 z-50 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-3 ml-4">
            <span class="bg-orange-600 px-2 py-0.5 rounded text-[9px] font-black uppercase italic">MODIFICACIÓN DE CUOTA</span>
            <h1 class="text-xs font-bold text-gray-300 italic">SOLICITUD #{{ $solicitud->id }}</h1>
        </div>
        <div class="flex gap-3 mr-4">
            <button onclick="window.print()" class="bg-green-600 hover:bg-green-500 text-white px-5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2">
                📥 IMPRIMIR PDF
            </button>
            <button onclick="window.close()" class="bg-gray-700 text-white px-5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest">CERRAR</button>
        </div>
    </div>

    <div class="print-container max-w-[800px] mx-auto bg-white p-12 my-6 shadow-xl border border-gray-200 relative min-h-[1050px]">

        <div class="text-center mb-8 border-b-2 border-gray-50 pb-6">
            <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tighter italic mb-1">COOPROCON</h2>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-1">Cooperativa de Ahorros, Créditos y Servicios Múltiples</p>
            <div class="mt-4 inline-block bg-orange-100 text-orange-800 px-6 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-orange-200">
                Autorización de Descuento (Ahorro Retirable)
            </div>
        </div>

        <div class="text-gray-800 leading-[2.3] text-justify text-[15px] italic mb-10">
            <p class="mb-4 text-right font-bold uppercase text-[12px]">Fecha: {{ $solicitud->created_at->format('d/m/Y') }}</p>

            Yo, <span class="data-underline">{{ $solicitud->datos['nombres'] }}</span>,
            portador de la cédula No. <span class="data-underline">{{ $solicitud->datos['cedula'] }}</span>,
            en mi calidad de socio de **COOPROCON**, autorizo formalmente a **PRO CONSUMIDOR**, a descontar de mi salario la suma mensual de:

            <div class="my-8 bg-orange-50 border-2 border-dashed border-orange-200 p-8 rounded-4xl text-center shadow-inner">
                <span class="block text-[10px] font-black text-orange-400 uppercase tracking-widest mb-1 leading-none">Cuota Mensual Autorizada</span>
                <span class="text-4xl font-black text-orange-700 font-mono italic">RD$ {{ number_format($solicitud->datos['monto_retirable'], 2) }}</span>
            </div>

            Bajo el concepto de **AHORRO RETIRABLE**, a partir del mes de <span class="data-underline">{{ $solicitud->datos['mes_inicio'] }}</span> del año <span class="data-underline">{{ $solicitud->datos['anio_inicio'] }}</span>.
        </div>

        <div class="mt-20 grid grid-cols-2 gap-16 px-10">
            <div class="text-center border-t border-gray-800 pt-3">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-800">Firma del Socio</p>
            </div>
            <div class="text-center border-t border-gray-800 pt-3">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-800">Administración</p>
            </div>
        </div>

        <div class="absolute bottom-10 left-0 right-0 px-12">
            <div class="flex justify-between items-end border-t border-gray-100 pt-4 text-[9px] font-mono text-gray-400 italic">
                <div>ID: #REQ-{{ str_pad($solicitud->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div>GENERADO: {{ date('d/m/Y h:i A') }}</div>
            </div>
        </div>
    </div>
</body>
</html>
