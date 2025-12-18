<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COOPROCON - Autorización #{{ $solicitud->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: letter;
            margin: 0;
        }
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
            border-bottom: 1.5px solid #1f2937;
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
            <span class="bg-indigo-600 px-2 py-0.5 rounded text-[9px] font-black uppercase italic">VISTA OFICIAL</span>
            <h1 class="text-xs font-bold text-gray-300 italic">SOLICITUD #{{ $solicitud->id }}</h1>
        </div>
        <div class="flex gap-3 mr-4">
            <button onclick="window.print()" class="bg-green-600 hover:bg-green-500 text-white px-5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2">
                📥 IMPRIMIR / GUARDAR PDF
            </button>
            <button onclick="window.close()" class="bg-gray-700 text-white px-5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest">
                CERRAR
            </button>
        </div>
    </div>

    {{-- HOJA TIPO CARTA --}}
    <div class="print-container max-w-[800px] mx-auto bg-white p-12 my-6 shadow-xl border border-gray-200 relative min-h-[1050px]">

        {{-- ENCABEZADO COMPACTO --}}
        <div class="text-center mb-8 border-b-2 border-gray-50 pb-6">
            <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tighter italic leading-none mb-1">COOPROCON</h2>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-1">Cooperativa de Ahorros, Créditos y Servicios Múltiples</p>
            <p class="text-[9px] font-medium text-gray-400 uppercase italic">De los empleados de Pro Consumidor</p>
            <div class="mt-4 inline-block bg-gray-100 text-gray-800 px-6 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-gray-200">
                Autorización de Descuento de Ahorros
            </div>
        </div>

        {{-- CUERPO DEL DOCUMENTO --}}
        <div class="text-gray-800 leading-[2.2] text-justify text-[15px] italic mb-10">
            Yo, <span class="data-underline">{{ $solicitud->datos['nombres'] }} {{ $solicitud->datos['apellidos'] ?? '' }}</span>,
            dominicano, mayor de edad, portador de la cédula de identidad y electoral No.
            <span class="data-underline">{{ $solicitud->datos['cedula'] }}</span>, en mi calidad de socio de la
            <strong>Cooperativa de Ahorros, Créditos y Servicios Múltiples de los Empleados de Pro Consumidor (COOPROCON)</strong>,
            por medio de la presente autorizo formalmente a la institución
            <strong>PRO CONSUMIDOR</strong>, a realizar el descuento mensual de mi salario por la suma de:

            <div class="my-6 bg-gray-50 border border-gray-200 p-6 rounded-3xl text-center shadow-inner">
                <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 leading-none">Monto Mensual Autorizado</span>
                <span class="text-3xl font-black text-indigo-700 font-mono italic">RD$ {{ number_format($solicitud->datos['monto_ahorro'], 2) }}</span>
            </div>

            Dicho descuento se hará efectivo a partir del mes de <span class="data-underline">{{ $solicitud->datos['mes_inicio'] }}</span>
            del año <span class="data-underline">{{ $solicitud->datos['anio_inicio'] }}</span>, bajo el concepto de
            <strong>AHORRO NORMAL</strong>. Estos fondos deberán ser entregados a la cooperativa para ser incorporados
            a mi cuenta de ahorro individual.
        </div>

        {{-- SECCIÓN DE FIRMAS --}}
        <div class="mt-20 grid grid-cols-2 gap-16 px-10">
            <div class="text-center border-t border-gray-800 pt-3">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-800">Firma del Socio</p>
                <p class="text-[9px] text-gray-400 italic">Validado mediante Formulario Digital</p>
            </div>
            <div class="text-center border-t border-gray-800 pt-3">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-800">Administración</p>
                <p class="text-[9px] text-gray-400 italic">Sello COOPROCON</p>
            </div>
        </div>

        {{-- PIE DE PÁGINA ABSOLUTO --}}
        <div class="absolute bottom-10 left-0 right-0 px-12">
            <div class="flex justify-between items-end border-t border-gray-100 pt-4">
                <div>
                    <p class="text-[8px] font-black text-gray-300 uppercase tracking-widest">ID VERIFICACIÓN</p>
                    <p class="text-[9px] font-mono text-gray-400 font-bold italic">#REQ-{{ str_pad($solicitud->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[8px] font-black text-gray-300 uppercase tracking-widest">EMISIÓN</p>
                    <p class="text-[9px] font-mono text-gray-400 font-bold">{{ date('d/m/Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
