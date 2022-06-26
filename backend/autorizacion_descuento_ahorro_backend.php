<?php require_once('Connections/sgstec.php');
include('funciones/functions.php');
retornoadmin();
@$cedula=$_POST['cedula'];
@$nombre=$_POST['nombre'];
@$prestamo=$_POST['ahorro'];
@$cuota=$_POST['cuota'];
@$mes=$_POST['mes'];
@$ano=$_POST['ano'];
$fecha= date("d-m-Y");
if($cedula && $nombre)
{	
$to = "esleidinmatos@gmail.com";
$subject = "AUTORIZACIÓN DE DESCUENTO AHORRO $nombre";
$message = "<html><body><div style='text-align:center;width:70%;border:solid gray 1px;padding:20px;'>
<p><h2>Cooperativa de Ahorros, Créditos y Servicios Múltiples de los Empleados del
Instituto Nacional de Protección de los Derechos del Consumidor
COOPROCON</h2></p>
<p>RNC: 4-30-14783-4</p>

<p><h3>AUTORIZACIÓN DE DESCUENTO AHORRO</span></h3></p>

<p><b>Tipo de ahorro:</b> $prestamo</p>

<p style=' text-align: justify;'>Yo <span style='text-decoration: underline;'>$nombre</span>, de cédula No. <span style='text-decoration: underline;'>$cedula</span>,
en mi calidad
de socio de la Cooperativa de Ahorros, Créditos y Servicios Múltiples de los empleados de
Pro Consumidor, (COOPROCON), autorizo formalmente a PROCONSUMIDOR, a descontar
de mi salario la suma de RD$ $cuota a partir del mes de $mes, del
año $ano por concepto de AHORRO, del tipo indicado al inicio, y entregarlo a dicha
cooperativa para ser incorporado a mi cuenta de ahorro individual.</p>

<p style='text-align:center;'><b>Firma -</b><b> Fecha</b></p><br>
<p style='text-align:center;'><span style='text-decoration: underline;'>$nombre</span><br><span style='text-decoration: underline;'>$fecha</span></p>
</div></body></html>";
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
//mail($to, $subject, $message, $headers);
?>
<script>
alert('Estimado socio, tu solicitud ha sido enviada con éxito. Un personal de la cooperativa se pondrá en contacto contigo para completar el proceso. Gracias por ser parte de nuestra familia COOPROCON.');
</script>
<?php
}
?>
