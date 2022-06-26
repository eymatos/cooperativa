<?php require_once('Connections/sgstec.php'); ?>
<?php
include('funciones/functions.php');
//initialize the session

@$cedula=$_POST['cedula'];
@$nombre=$_POST['nombre'];
@$cuota=$_POST['cuota'];
$fecha= date("d-m-Y");
if($cedula && $nombre)
{	
$to = "yuly.mercedes@proconsumidor.gob.do, alexander.german@proconsumidor.gob.do, suleika.baez@proconsumidor.gob.do, suleikabaezs8253@gmail.com";
$subject = "SOLICITUD ENTREGA DE AHORRO RETIRABLE $nombre";
$message = "<html><body><div style='text-align:center;width:70%;border:solid gray 1px;padding:20px;'>
<p><h2>Cooperativa de Ahorros, Créditos y Servicios Múltiples de los Empleados del
Instituto Nacional de Protección de los Derechos del Consumidor
COOPROCON</h2></p>
<p>RNC: 4-30-14783-4</p>

<p><h3>SOLICITUD ENTREGA DE AHORRO RETIRABLE</span></h3></p>

<p style=' text-align: justify;'>Yo <span style='text-decoration: underline;'>$nombre</span>, de cédula No. <span style='text-decoration: underline;'>$cedula</span>,
solicito se me haga
entrega de la suma de RD$ $cuota de mi AHORRO RETIRABLE de la
Cooperativa de Ahorros, Crédito y Servicios Múltiples de los empleados de Pro Consumidor,
(COOPROCON).</p>

<p style='text-align:center;'><b>Firma -</b><b> Fecha</b></p><br>
<p style='text-align:center;'><span style='text-decoration: underline;'>$nombre</span><br><span style='text-decoration: underline;'>$fecha</span></p>
</div></body></html>";
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "Bcc: alexandermercedes@gmail.com" . "\r\n"; // esto sería copia oculta
mail($to, $subject, $message, $headers);
?>
<script>
alert('Estimado socio, tu solicitud ha sido enviada con éxito. Un personal de la cooperativa se pondrá en contacto contigo para completar el proceso. Gracias por ser parte de nuestra familia COOPROCON.');
</script>
<?php
}




?>