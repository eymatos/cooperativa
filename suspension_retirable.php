<?php require_once('Connections/sgstec.php'); ?>
<?php
include('funciones/functions.php');
//initialize the session

?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
mysql_select_db($database_sgstec, $sgstec);
$query_sexo = sprintf("SELECT id,nombre, apellido, sexo FROM usuarios WHERE cedula = %s", GetSQLValueString($colname_sexo, "text"));
$sexo = mysql_query($query_sexo, $sgstec) or die(mysql_error());
$row_sexo = mysql_fetch_assoc($sexo);
$totalRows_sexo = mysql_num_rows($sexo);
$_SESSION['id'] = $row_sexo['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><!-- Global site tag (gtag.js) - Google Analytics --><script async src="https://www.googletagmanager.com/gtag/js?id=UA-60738677-4"></script><script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-60738677-4');</script><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>COOPROCON</title>

<link href="css/estilos1.css" rel="stylesheet" type="text/css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/libreria.js" type="text/javascript"></script>

</head>

<body onload="cargar_funciones(<?php echo $row_sexo['id']; ?>)">
<header>
	<div id="secondbox">
    	<a href="index.php"><div id="logo" class="fleft"></div></a>
        <?php encabezados();?>
<div class="fright">
  
        </div>
    
		</header>
<section> 
<div id="menu"><?php sidemenu();?></div>      
<div id="contenido">
<div id="ahorros2" style="
    width: 100%;
    clear: both;
    margin-top: 20px;
    padding: 10px;
    background: white;
	border-radius: 10px;
">
<?php retornoadmin();?>
<h1>AUTORIZACIÓN SUSPENSIÓN AHORRO RETIRABLE</h1>
<br>
<form style="width:75%;" action="suspension_retirable.php" method="POST" style="margin-top: 10px;">
	<div class="formulario2">
<span style="width:100%;">Yo <input type="text" name="nombre" > de cédula No. <input type="text" name="cedula" maxlength=13 >,
en mi calidad de socio de la Cooperativa
de Ahorros, Créditos y Servicios Múltiples de los empleados de Pro Consumidor,
(COOPROCON), solicito la SUSPENSIÓN DEL DESCUENTO POR CONCEPTO DE
AHORRO RETIRABLE, con efectividad a partir del mes de <input type="text" name="mes" > del año <input type="text" name="ano" ></span> 
<br><br>

	</div>

		<br><br><br>
	<div>
		<p><input class="enviar" type="submit" value="Autorizar"></p>
	</div>
</form>

<?php
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

mail($to, $subject, $message, $headers);
?>
<script>
alert('Estimado socio, tu solicitud ha sido enviada con éxito. Un personal de la cooperativa se pondrá en contacto contigo para completar el proceso. Gracias por ser parte de nuestra familia COOPROCON.');
</script>
<?php
}




?>


</div>
</div>
</section>
<footer>
<center style="background:#232F3E;color:white;font-weight:bold;">© 2021 COOPROCON</center>
<div id="footer"></div></footer> 
</body>
</html>

