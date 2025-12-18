<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Inscripción - {{ $solicitud->datos['nombres'] ?? '' }}</title>
    <style>
        /* Optimización de página completa */
        @page { size: letter; margin: 0.5cm; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #1a1a1a;
            font-size: 11px;
            line-height: 1.3;
        }

        /* Cabecera compacta */
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #16a34a; padding-bottom: 10px; }
        .logo-placeholder { font-size: 20px; font-weight: 900; color: #16a34a; letter-spacing: -1px; margin: 0; }
        .title { font-size: 11px; font-weight: bold; text-transform: uppercase; margin: 0; color: #4b5563; }
        .subtitle { font-size: 16px; font-weight: 900; color: #000; margin: 2px 0; text-transform: uppercase; }

        /* Secciones en rejilla de dos columnas */
        .section-title {
            background: #f3f4f6;
            padding: 5px 10px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 15px;
            border-left: 4px solid #16a34a;
        }

        .grid-container { display: table; width: 100%; margin-top: 5px; }
        .grid-row { display: table-row; }
        .grid-col { display: table-cell; width: 50%; padding: 5px 10px; border-bottom: 1px solid #f3f4f6; }

        .label { font-size: 9px; font-weight: bold; color: #6b7280; text-transform: uppercase; display: block; }
        .value { font-size: 11px; font-weight: bold; color: #000; text-transform: uppercase; }

        /* Bloque de términos y condiciones (Compacto) */
        .legal-text {
            font-size: 9px;
            text-align: justify;
            color: #4b5563;
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background-color: #fafafa;
        }

        /* Área de Firmas */
        .signature-wrapper { margin-top: 40px; width: 100%; }
        .signature-box { display: inline-block; width: 45%; text-align: center; }
        .signature-line { border-top: 1px solid #000; margin: 0 20px; padding-top: 5px; font-weight: bold; font-size: 9px; text-transform: uppercase; }

        .footer { position: absolute; bottom: 20px; width: 100%; text-align: center; font-size: 8px; color: #9ca3af; }

        /* Utilidades para la web */
        .no-print {
            background: #111827; color: #fff; padding: 15px; text-align: center;
            margin-bottom: 20px; border-radius: 12px; font-weight: bold;
        }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" style="cursor:pointer; background:#16a34a; color:white; border:none; padding:8px 20px; border-radius:6px; font-weight:bold; font-size:12px;">
            🖨️ CONFIRMAR E IMPRIMIR DOCUMENTO
        </button>
        <p style="font-size: 10px; margin-top: 10px; opacity: 0.8;">Asegúrese de que el destino sea "Guardar como PDF" o su impresora instalada.</p>
    </div>

    <div class="header">
        <p class="logo-placeholder">COOPROCON</p>
        <p class="title">Cooperativa de Ahorros, Créditos y Servicios Múltiples de los Empleados de Pro Consumidor</p>
        <p class="subtitle">Solicitud de Inscripción y Autorización</p>
        <p style="font-size: 10px; font-weight: bold;">ID Solicitud Digital: #{{ $solicitud->id }} | Fecha: {{ $solicitud->created_at->format('d/m/Y') }}</p>
    </div>

    {{-- DATOS PERSONALES --}}
    <div class="section-title">1. Datos Personales y Laborales</div>
    <div class="grid-container">
        <div class="grid-row">
            <div class="grid-col"><span class="label">Nombres</span><span class="value">{{ $solicitud->datos['nombres'] ?? '' }}</span></div>
            <div class="grid-col"><span class="label">Apellidos</span><span class="value">{{ $solicitud->datos['apellidos'] ?? '' }}</span></div>
        </div>
        <div class="grid-row">
            <div class="grid-col"><span class="label">Cédula de Identidad</span><span class="value">{{ $solicitud->datos['cedula'] ?? '' }}</span></div>
            <div class="grid-col"><span class="label">Teléfono de Contacto</span><span class="value">{{ $solicitud->datos['telefono'] ?? '' }}</span></div>
        </div>
    </div>

    {{-- CONFIGURACIÓN FINANCIERA --}}
    <div class="section-title">2. Compromiso de Ahorro y Aportes</div>
    <div class="grid-container">
        <div class="grid-row">
            <div class="grid-col"><span class="label">Monto Ahorro Normal</span><span class="value">RD$ {{ number_format($solicitud->datos['ahorro_normal'] ?? 0, 2) }}</span></div>
            <div class="grid-col"><span class="label">Monto Ahorro Retirable</span><span class="value">RD$ {{ number_format($solicitud->datos['ahorro_retirable'] ?? 0, 2) }}</span></div>
        </div>
    </div>

    {{-- BENEFICIARIOS --}}
    <div class="section-title">3. Designación de Beneficiarios (En caso de fallecimiento)</div>
    <div class="grid-container">
        <div class="grid-row">
            <div class="grid-col"><span class="label">Nombre del Beneficiario</span><span class="value">{{ $solicitud->datos['beneficiario_nombre'] ?? 'N/A' }}</span></div>
            <div class="grid-col"><span class="label">Parentesco / Relación</span><span class="value">{{ $solicitud->datos['beneficiario_parentesco'] ?? 'N/A' }}</span></div>
        </div>
    </div>

    {{-- TEXTO LEGAL --}}
    <div class="legal-text">
        Yo, el abajo firmante, solicito formalmente mi ingreso a <strong>COOPROCON</strong>. Conozco y acepto los estatutos sociales de la cooperativa. En consecuencia, autorizo a <strong>PRO CONSUMIDOR</strong> a descontar de mi salario mensual la suma de <strong>RD$ 200.00</strong> por concepto de inscripción (no reembolsable) y <strong>RD$ 250.00</strong> como aporte de capital inicial, además de las cuotas de ahorro aquí expresadas.
    </div>

    {{-- FIRMAS --}}
    <div class="signature-wrapper">
        <div class="signature-box">
            <div style="height: 40px;"></div>
            <div class="signature-line">Firma del Solicitante</div>
        </div>
        <div class="signature-box" style="float: right;">
            <div style="height: 40px;"></div>
            <div class="signature-line">Sello y Firma COOPROCON</div>
        </div>
    </div>

    <div class="footer">
        Documento generado electrónicamente. La validez de este formulario está sujeta a la aprobación del Consejo de Administración.
    </div>
</body>
</html>
