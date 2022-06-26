<?php require_once('Connections/sgstec.php');
include('funciones/functions.php');
retornoadmin();

@$cedula=$_POST['cedula'];
@$nombre=$_POST['nombre'];
@$nombre=$_POST['nombre'];
@$mes=$_POST['mes'];
@$ano=$_POST['ano'];
$fecha=date('d-m-Y');
if($cedula && $nombre && $mes && $ano)
{	
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "Bcc: wendy.acevedo@proconsumidor.gob.do" . "\r\n"; // esto sería copia oculta
$to = "yuly.mercedes@proconsumidor.gob.do,alexandermercedes@gmail.com";
$subject = "Autorización suspensión ahorro retirable $nombre";
$message = "<html><body><div style='text-align:center;width:70%;border:solid gray 1px;padding:20px;'>
<p><h2>Cooperativa de Ahorros, Créditos y Servicios Múltiples de los Empleados del
Instituto Nacional de Protección de los Derechos del Consumidor
COOPROCON</h2></p>
<p>RNC: 4-30-14783-4</p>

<p><h3>AUTORIZACIÓN SUSPENSIÓN AHORRO RETIRABLE</h3></p>

<p style=' text-align: justify;'>Yo <span style='text-decoration: underline;'>$nombre</span>, de cédula No. <span style='text-decoration: underline;'>$cedula</span>,
en mi calidad de socio de la Cooperativa
de Ahorros, Créditos y Servicios Múltiples de los empleados de Pro Consumidor,
(COOPROCON), solicito la SUSPENSIÓN DEL DESCUENTO POR CONCEPTO DE
AHORRO RETIRABLE, con efectividad a partir del mes de $mes <span style='margin-right:3px;'> del año </span> $ano.</p>
<br><br>
<p style='text-align:center;'><b>Firma -</b><b> Fecha</b></p><br>
<p style='text-align:center;'><span style='text-decoration: underline;'>$nombre</span><br>
<span style='text-decoration: underline;'>$fecha</span></p>
</div></body></html>";

//mail($to, $subject, $message, $headers);
?>
<script>
alert('Estimado socio, tu solicitud ha sido enviada con éxito. Un personal de la cooperativa se pondrá en contacto contigo para completar el proceso. Gracias por ser parte de nuestra familia COOPROCON.');
</script>
<?php
}
?>

