<?php require_once('Connections/sgstec.php'); ?>
<?php
include('funciones/functions.php');
//initialize the session
mysqli_query("SET NAMES 'utf8'",$sgstec);
?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_sexo = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_sexo = $_SESSION['MM_Username'];
}
mysqli_select_db($sgstec,$database_sgstec);
$query_sexo = sprintf("SELECT id,nombre, apellido, sexo FROM usuarios WHERE cedula = %s", GetSQLValueString($colname_sexo, "text"));
$sexo = mysqli_query($sgstec,$query_sexo) or die(mysqli_error());
$row_sexo = mysqli_fetch_assoc($sexo);
$totalRows_sexo = mysqli_num_rows($sexo);
$_SESSION['id'] = $row_sexo['id'];
?>
<?php
if(isset($_POST['submit']) && !empty($_POST['submit'])) {
@$cedula=$_POST['cedula'];
@$nombre=$_POST['nombre'];
@$prestamo=$_POST['prestamo'];
@$cuota=$_POST['cuota'];
@$cantidad_cuotas=$_POST['cantidad_cuotas'];
@$mes=$_POST['mes'];
if (empty($mes)){
	$mes="________________";
}
@$ano=$_POST['ano'];
$fecha= date("d-m-Y");
if($cedula && $nombre)
{	
$to = "yuly.mercedes@proconsumidor.gob.do, alexander.german@proconsumidor.gob.do, suleika.baez@proconsumidor.gob.do, suleikabaezs8253@gmail.com";
$subject = "Autorización Prestamo $nombre";
$message = "<html><body><div style='text-align:center;width:70%;border:solid gray 1px;padding:20px;'>
<p><h2>Cooperativa de Ahorros, Créditos y Servicios Múltiples de los Empleados del
Instituto Nacional de Protección de los Derechos del Consumidor
COOPROCON</h2></p>
<p>RNC: 4-30-14783-4</p>

<p><h3>Autorización de descuento por préstamos</span></h3></p>

<p><b>Tipo de Préstamo:</b> $prestamo</p>

<p style=' text-align: justify;'>Yo <span style='text-decoration: underline;'>$nombre</span>, de cédula No. <span style='text-decoration: underline;'>$cedula</span>,
en mi calidad de socio de la Cooperativa
de Ahorros, Créditos y Servicios Múltiples de los empleados de Pro Consumidor,
(COOPROCON), informo que he adquirido un préstamo en dicha cooperativa, del tipo indicado al inicio, y autorizo formalmente a PROCONSUMIDOR, a descontar de mi salario y entregar a dicha cooperativa, según la siguiente descripción:</p>

<p style='text-align:left;'>Monto de las cuotas RD$: $cuota</p>
<p style='text-align:left;'>Cantidad de cuotas: $cantidad_cuotas</p>
<p style='text-align:left;'>A partir del mes de: $mes <span style='margin:0 5px;'> del año </span>$ano</p><br>
<p style='text-align:left;border:solid 1px black;padding:5px;'><b>NOTA:</b> Si al momento de mi desvinculación de la Institución queda algún compromiso de pago,
autorizo a PROCONSUMIDOR a descontarlo de mis prestaciones y entregar a la Cooperativa
dicho monto.</p>

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
}

?>
<html>
<head>

	<title>Autorizado</title>
</head>

<body>
<P><b>Proceso completado</p>
<p><a href="http://cooprocon.com/inicio.php">Regresar al menu principal</a></p>
</body>
</html>