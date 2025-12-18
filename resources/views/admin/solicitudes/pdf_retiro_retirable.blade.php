<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Retiro de Ahorro #{{ $solicitud->id }}</title>
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
        .data-underline { border-bottom: 1.5px solid #000; padding: 0 8px; font-weight: 800; text-transform: uppercase; display: inline-block; line-height: 1.2; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-[15px]">

    {{-- BARRA DE IMPRESIÓN --}}
    <div class="no-print sticky top-0 bg-gray-900 text-white p-4 z-50 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-3 ml-4">
            <span class="bg-green-600 px-2 py-0.5 rounded text-[9px] font-black uppercase italic">SOLICITUD DE DESEMBOLSO</span>
            <h1 class="text-xs font-bold text-gray-300 italic">#REQ-{{ $solicitud->id }}</h1>
        </div>
        <button onclick="window.print()" class="mr-4 bg-green-600 hover:bg-green-500 text-white px-5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">
            📥 IMPRIMIR / GUARDAR PDF
        </button>
    </div>

    <div class="print-container max-w-[800px] mx-auto bg-white p-16 my-8 shadow-xl border border-gray-200 relative min-h-[1050px]">

        <div class="text-center mb-10 border-b-2 border-gray-50 pb-8">
            <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tighter italic mb-1">COOPROCON</h2>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-1">Cooperativa de Ahorros, Créditos y Servicios Múltiples</p>
            <div class="mt-4 inline-block bg-green-100 text-green-800 px-6 py-1.5 rounded-full text-[11px] font-black uppercase tracking-widest border border-green-200">
                Solicitud Entrega de Ahorro Retirable
            </div>
        </div>

        <div class="italic leading-[2.5] text-justify text-gray-800">
            <p class="text-right font-bold uppercase text-[12px] mb-6">Fecha: {{ $solicitud->created_at->format('d/m/Y') }}</p>

            Yo, <span class="data-underline">{{ $solicitud->datos['nombres'] }}</span>,
            portador de la cédula No. <span class="data-underline">{{ $solicitud->datos['cedula'] }}</span>,
            por medio de la presente solicito se me haga entrega de la suma de:

            <div class="my-10 bg-gray-50 border-2 border-dashed border-gray-200 p-10 rounded-[3rem] text-center shadow-inner">
                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Monto Solicitado para Retiro</span>
                <span class="text-4xl font-black text-green-700 font-mono italic underline decoration-green-200 decoration-4">RD$ {{ number_format($solicitud->datos['monto_retiro'], 2) }}</span>
            </div>

            de mi <strong>AHORRO RETIRABLE</strong> de la <strong>Cooperativa de Ahorros, Crédito y Servicios Múltiples de los empleados de Pro Consumidor (COOPROCON)</strong>.

            <p class="mt-8 text-sm">
                Desembolso solicitado a través de <span class="font-bold underline">{{ $solicitud->datos['banco'] }}</span>
                a la cuenta No. <span class="font-bold underline">{{ $solicitud->datos['cuenta'] }}</span>.
            </p>
        </div>

        <div class="mt-32 grid grid-cols-2 gap-20">
            <div class="text-center border-t border-gray-800 pt-3">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-800">Firma del Socio</p>
                <p class="text-[8px] text-gray-400 italic">Identificación Validada</p>
            </div>
            <div class="text-center border-t border-gray-800 pt-3">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-800">Administración</p>
                <p class="text-[8px] text-gray-400 italic">Visto Bueno Gerencia</p>
            </div>
        </div>

        <div class="absolute bottom-10 left-0 right-0 px-16">
            <div class="flex justify-between items-end border-t border-gray-100 pt-4 text-[9px] font-mono text-gray-400">
                <div>CERTIFICACIÓN DIGITAL: #RET-{{ str_pad($solicitud->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div>FECHA DE GENERACIÓN: {{ date('d/m/Y h:i A') }}</div>
            </div>
        </div>
    </div>

</body>
</html>
