<?php 
require_once('Connections/sgstec.php');
include('funciones/functions.php');
//initialize the session
mysqli_query("SET NAMES 'utf8'",$sgstec);

if(isset($_POST['submit']) && !empty($_POST['submit'])) {
@$cedula_garante='';
@$nombre_garante='';
@$departamento_garante='';
@$celular_garante='';
@$sueldo_garante='';
@$cantidad_garante='';
@$cedula=$_POST['cedula'];
@$nombre=$_POST['nombre'];
@$departamento=$_POST['departamento'];
@$celular=$_POST['celular'];
@$sueldo=$_POST['sueldo'];
@$cantidad=$_POST['cantidad'];
@$destino=$_POST['destino'];
@$cedula_garante=$_POST['cedula_garante'];
@$nombre_garante=$_POST['nombre_garante'];
@$departamento_garante=$_POST['departamento_garante'];
@$celular_garante=$_POST['celular_garante'];
@$sueldo_garante=$_POST['sueldo_garante'];
@$cantidad_garante=$_POST['cantidad_garante'];
@$anterior=$_POST['anterior'];
@$prestamo=$_POST['prestamo'];
$fecha = date ('d-m-Y');
if ($prestamo==='Préstamo Normal'){$normal='X';}
if ($prestamo==='Préstamo Educativo'){$educativo='X';}
if ($prestamo==='Préstamo útiles escolares'){$utiles='X';}
if ($prestamo==='Préstamo vacacional'){$vacacional='X';}
if ($prestamo==='Préstamo especial'){$especial='X';}
if ($prestamo==='Préstamo gerencial'){$gerencial='X';}
if($cedula && $nombre && $fecha)
{	
$to = "yuly.mercedes@proconsumidor.gob.do, alexander.german@proconsumidor.gob.do, suleika.baez@proconsumidor.gob.do, suleikabaezs8253@gmail.com";
//$to = "esleidinmatos@gmail.com";
$subject = "SOLICITUD DE PRÉSTAMO $nombre";
$message = "<html><body>
<div style='text-align:center;width:720px;height:960px;border:solid gray 1px;padding:20px;    display: inline-block;font-size:12px;'>
	<p><h3>Cooperativa de Ahorros, Créditos y Servicios Múltiples de los Empleados del
	Instituto Nacional de Protección de los Derechos del Consumidor
	COOPROCON</h3></p>
	<p>RNC: 4-30-14783-4</p>
	<p><h4>SOLICITUD DE PRÉSTAMO</h4></p>
	<table style='width:100%;text-align:left;'><tr><td>Número______________</td><td>Fecha:<span style='text-decoration: underline;'>$fecha</span></td></tr></table>
	<p style='width:100%;padding:5px;'><h3>Datos del solicitante</h3></p>
	<table style='width:100%;border:solid 1px gray;padding:5px;text-align:left;' border='1'>
	<tr><td><b>Nombre completo:</b></td><td>$nombre</td><td><b>Cédula:</b></td><td>$cedula</td></tr>
	<tr><td><b>Departamento:</b></td><td>$departamento</td><td><b>Celular:</b></td><td>$celular</td></tr>
	<tr><td><b>Sueldo RD$:</b></td><td>$sueldo</td><td><b>Cantidad solicitada  RD$:</b></td><td>$cantidad</td></tr>
	<tr><td><b>Destino del préstamo:</b></td><td>$destino</td><td><b>Préstamo anterior:</b></td><td>$anterior</td></tr>
	</table>
	<p style='text-align:right:'>Firma: <span style='text-decoration: underline;'>$nombre</span></p>
	<p style='width:100%;padding:5px;'><h3>Datos del garante</h3></p>
	<table style='width:100%;border:solid 1px gray;text-align:left;' border='1'>

	<tr><td style='width:20%;'><b>Nombre completo:</b></td><td style='width:30%;'>$nombre_garante</td><td style='width:20%;'><b>Cédula:</b></td><td style='width:30%;'>$cedula_garante</td></tr>
	<tr><td style='width:20%;'><b>Departamento:</b></td><td style='width:30%;'>$departamento_garante</td><td style='width:20%;'><b>Celular:</b></td><td style='width:30%;'>$celular_garante</td></tr>
	<tr><td style='width:20%;'><b>Sueldo RD$:</b></td><td style='width:30%;'>$sueldo_garante</td><td><b style='width:20%;'>Cantidad en garantía  RD$:</b></td><td style='width:30%;'>$cantidad_garante</td></tr>
	</table>
	<p style='text-align:right:'>Firma: <span style='text-decoration: underline;'>$nombre_garante</span></p><br>

	<div style='text-align:center;background:#d9d6d6;border:solid gray 1px;'>Para ser llenado por la administración de la Cooperativa</div>

	<div style='width:100%;text-align:left;'>
	<table style='width:100%;border:solid 1px gray;' border='1'>
	<tr style='heigth:5px;><td style='width:20%;'><b>Tipo de préstamo</b></td><td style='width:20%;border:none;'></td><td style='width:25%;'>Ahorro acumulado</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Normal</td><td style='width:20%;text-align:center;'><b>$normal</b></td><td style='width:25%;'>Ahorro mensual</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Gerencial</td><td style='width:20%;text-align:center;'><b>$gerencial</b></td><td style='width:25%;'>Saldo anterior RD$</td style='width:35%;'><td></td></tr>
	<tr><td style='width:20%;'>Vacacional</td><td style='width:20%;text-align:center;'><b>$vacacional</b></td><td style='width:25%;'>Capital</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Educativo</td><td style='width:20%;text-align:center;'><b>$educativo</b></td><td style='width:25%;'>Interés</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Útiles Escolares</td><td style='width:20%;text-align:center;'><b>$utiles</b></td><td style='width:25%;'>Gasto administrativo</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Especial</td><td style='width:20%;text-align:center;'><b>$especial</b></td><td style='width:25%;'>Total a saldar</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;border:none;'></td><td style='width:20%;border:none;'></td><td style='width:25%;'>Cantidad cuotas</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;text-align:center;'><b>Comité de crédito</b></td><td style='width:20%;border:none;'></td><td style='width:25%;'>Monto cuotas</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Firma</td><td style='width:20%;'></td><td style='width:25%;'>Fecha primera cuota</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Fecha de aprobación</td><td style='width:20%;'></td><td style='width:25%;'>Monto entregado</td><td style='width:35%;'></td></tr>
	</table>
	</div>
</div></body></html>";
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "Bcc: alexandermercedes@gmail.com" . "\r\n"; // esto sería copia oculta
//mail($to, $subject, $message, $headers);
?>
<script>
alert('Estimado socio, tu solicitud ha sido enviada con éxito. Un personal de la cooperativa se pondrá en contacto contigo para completar el proceso. Sera direccionado al Formulario de Autorización de Descuento de Préstamo, Gracias por ser parte de nuestra familia COOPROCON.');
</script>
<?php
}
}
?>