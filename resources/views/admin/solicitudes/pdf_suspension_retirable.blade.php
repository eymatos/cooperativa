<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Suspensión de Ahorro #{{ $solicitud->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page { size: letter; margin: 0; }
        @media print { .no-print { display: none !important; } .print-container { width: 100% !important; padding: 1.5cm !important; } }
        .data-underline { border-bottom: 1.5px solid #000; padding: 0 5px; font-weight: 800; text-transform: uppercase; display: inline-block; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-[14px]">
    {{-- Barra superior (Igual que las anteriores) --}}
    <div class="no-print bg-red-600 text-white p-4 flex justify-between items-center shadow-lg sticky top-0 z-50">
        <span class="font-black italic uppercase tracking-tighter">COOPROCON - Suspensión de Ahorro</span>
        <button onclick="window.print()" class="bg-white text-red-600 px-6 py-1 rounded-full font-black text-xs uppercase shadow-md">Imprimir Documento</button>
    </div>

    <div class="print-container max-w-[800px] mx-auto bg-white p-16 my-10 shadow-xl border relative min-h-[1050px]">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-black italic">COOPROCON</h2>
            <div class="mt-4 inline-block bg-red-100 text-red-700 px-6 py-1 rounded-full text-[10px] font-black uppercase border border-red-200">
                Notificación de Suspensión de Descuento
            </div>
        </div>

        <div class="space-y-8 italic leading-relaxed text-justify">
            <p class="text-right font-bold">Fecha: {{ $solicitud->created_at->format('d/m/Y') }}</p>

            <p>
                A los Directivos de la <strong>Cooperativa de Ahorros, Créditos y Servicios Múltiples de los Empleados de Pro Consumidor (COOPROCON)</strong>.
            </p>

            <p>
                Yo, <span class="data-underline">{{ $solicitud->datos['nombres'] }}</span>, portador de la cédula No. <span class="data-underline">{{ $solicitud->datos['cedula'] }}</span>, por medio de la presente solicito formalmente la suspensión del descuento mensual que se aplica a mi salario bajo el concepto de <strong>AHORRO RETIRABLE</strong>.
            </p>

            <p>
                Esta solicitud deberá hacerse efectiva a partir del mes de <span class="data-underline">{{ $solicitud->datos['mes_suspension'] }}</span> del año <span class="data-underline">{{ $solicitud->datos['anio_suspension'] }}</span>. Entiendo que los fondos acumulados hasta la fecha permanecerán en la institución sujetos a los reglamentos vigentes.
            </p>
        </div>

        <div class="mt-40 grid grid-cols-2 gap-20">
            <div class="border-t border-black pt-2 text-center font-bold uppercase text-[10px]">Firma del Socio</div>
            <div class="border-t border-black pt-2 text-center font-bold uppercase text-[10px]">Recibido COOPROCON</div>
        </div>

        <div class="absolute bottom-10 left-16 right-16 border-t pt-4 flex justify-between text-[10px] text-gray-400 font-mono italic font-bold">
            <span>VERIFICACIÓN: #SUSP-{{ $solicitud->id }}</span>
            <span>COOPROCON SISTEMA DIGITAL</span>
        </div>
    </div>
</body>
</html>
