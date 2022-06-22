<?php require_once('Connections/sgstec.php'); ?>
<?php
include('funciones/functions.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
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
$query_sexo = sprintf("SELECT * FROM usuarios WHERE cedula = %s", GetSQLValueString($colname_sexo, "text"));
$sexo = mysql_query($query_sexo, $sgstec) or die(mysql_error());
$row_sexo = mysql_fetch_assoc($sexo);
$totalRows_sexo = mysql_num_rows($sexo);
$_SESSION['id'] = $row_sexo['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><!-- Global site tag (gtag.js) - Google Analytics --><script async src="https://www.googletagmanager.com/gtag/js?id=UA-60738677-4"></script><script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-60738677-4');</script><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<style>
form {width:250px;}
form>div>span {width:100px;display: inline-block;text-align:left;}
form input {background-color: #f5f5f5;
    border: 1px solid #ddd;
    box-shadow: 0 0 5px #ddd inset;
    color: #727171;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 14px;
    font-size: 1.4rem;
    padding: 5px;
    padding: 0.5rem;
    text-align: right;}
form>div {text-align:center;}
</style>
<script LANGUAGE="JavaScript">
function abreSitio(){
var URL = "http://";
var web = document.form1.sitio.options[document.form1.sitio.selectedIndex].value;
window.open(URL+web, '_self', '');
}
</script>
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
<script>
function cargar_funciones(mensajes){
	cont_mensajes(mensajes);
	cont_equipostaller(1);
}
</script>
<body onload="cargar_funciones(<?php echo $row_sexo['id']; ?>)">
<header>
	<div id="secondbox">
    	<a href="inicio.php"><div id="logo" class="fleft"></div></a>
        <?php encabezados();?>
<div class="fright">
  
        </div>
       <div id="bienvenida">Hola <?php echo p_nombre($row_sexo['nombre']); ?> <?php echo p_nombre($row_sexo['apellido']); ?></div>
	   
        
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
<h1>Crear Usuario</h1>
<form style="width:75%;" action="crearusuario.php" method="POST" style="margin-top: 10px;">
	<div class="formulario2">
		<span style="width:100%;"><b>Cédula</b> : En formato (000-0000000-0)</span>
		<span style="width:100%;"><input type="text" name="cedula" maxlength=13></span>
	</div>
	<br><br>
	<div class="formulario2">
		<span style="width:100%;"><b>Nombre</b> :</span>
		<span style="width:100%;"><input type="text" name="nombre"></span>
	</div>
	<br><br>
	<div class="formulario2">
		<span style="width:100%;"><b>Apellido</b> :</span>
		<span style="width:100%;"><input type="text" name="apellido"></span>
	</div>
    <br><br>
	<div class="formulario2">
		<span style="width:100%;"><b>Sexo</b> : (1 para masculino y 0 para femenino)</span>
		<span style="width:100%;"><input type="text" name="sexo"></span>
	</div>
	<br><br>
	<div class="formulario2">
		<span style="width:100%;"><b>Email</b> :</span>
		<span style="width:100%;"><input type="text" name="email"></span>
	</div>
	<br><br>
	<div class="formulario2">
		<span style="width:100%;"><b>Fecha de inscripción</b> : (D/M/A)</span>
		<span style="width:100%;"><input type="text" name="fecha_inscripcion"></span>
	</div>
	<br><br>
	<div class="formulario2">
		<span style="width:100%;"><b>Monto de pago de inscripción</b> :</span>
		<span style="width:100%;"><input type="text" name="inscripcion"></span>
	</div>
	<br><br>
	<div class="formulario2">
		<span style="width:100%;"><b>Aporte a capital</b> </span>
		<span style="width:100%;"><input type="text" name="aporte_capital"></span>
	</div>
	<br><br>
	<div class="formulario2">
		<span style="width:100%;"><b>Ahorro retirable acumulado</b> : (Sino tiene poner 0)</span>
		<span style="width:100%;"><input type="text" name="ahorro_retirable"></span>
	</div>
	<br><br>
	<div class="formulario2">
		<span style="width:100%;"><b>Aporte mensual</b> :</span>
		<span style="width:100%;"><input type="text" name="guia"></span>
	</div>
		<br><br>
			<div class="formulario2">
		<span style="width:100%;"><b>Aporte mensual retirable</b> :</span>
		<span style="width:100%;"><input type="text" name="guia"></span>
	</div>
		<br><br>
			<div class="formulario2">
		<span style="width:100%;"><b>Tipo de contrato</b> :</span>
		<span style="width:100%;"><select name="contrato"><option value="F">Fijo</option><option value="C">Contratado</option><option value="P">Proceso de pensión</option></select></span>
	</div>
		<br><br><br>
	<div>
		<p><input class="enviar" type="submit" value="CREAR SOCIO"></p>
	</div>
</form>

<?php
@$cedula=$_POST['cedula'];
@$nombre=$_POST['nombre'];
@$apellido=$_POST['apellido'];
@$sexo=$_POST['sexo'];
@$email=$_POST['email'];
@$fecha_inscripcion=$_POST['fecha_inscripcion'];
@$inscripcion=$_POST['inscripcion'];
@$aporte_capital=$_POST['aporte_capital'];
@$ahorro_retirable=$_POST['ahorro_retirable'];
@$guia=$_POST['guia'];
@$guia_reti=$_POST['guia_reti'];
@$contrato=$_POST['contrato'];
$query30=sprintf("SELECT * FROM usuarios WHERE cedula LIKE '$sitio'");
$resultado30=mysql_query($query30);
$row30 = mysql_fetch_assoc($resultado30);
$nombre=$row30['nombre'];
$apellido=$row30['apellido'];
echo "Usted ha seleccionado a $nombre $apellido de cédula $sitio";
if($cedula && $nombre && $apellido)
{	

mysql_query("INSERT INTO usuarios (cedula, nombre, apellido, sexo, email, clave, fecha_inscripcion, inscripcion, aporte_capital, ahorro_retirable, guia, guia_reti,contrato) VALUES ('".$cedula."', '".$nombre."', '".$apellido."', '".$sexo."', '".$email."','221a80702357fde0038a276221330754', '".$fecha_inscripcion."', '".$inscripcion."', '".$aporte_capital."', '".$ahorro_retirable."', '".$guia."', '".$guia_reti."', '".$contrato."')");
mysql_query("INSERT INTO ahorros_2017 (cedula, aporte_enero,comentarios_enero, aporte_febrero,comentarios_febrero, aporte_marzo,comentarios_marzo, aporte_abril,comentarios_abril, aporte_mayo,comentarios_mayo, aporte_junio,comentarios_junio, aporte_julio,comentarios_julio, aporte_agosto,comentarios_agosto, aporte_septiembre,comentarios_septiembre, aporte_octubre,comentarios_octubre, aporte_noviembre,comentarios_noviembre, aporte_diciembre,comentarios_diciembre) VALUES ('".$cedula."','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '')");
mysql_query("INSERT INTO ahorros_2020 (cedula, aporte_enero,comentarios_enero, aporte_febrero,comentarios_febrero, aporte_marzo,comentarios_marzo, aporte_abril,comentarios_abril, aporte_mayo,comentarios_mayo, aporte_junio,comentarios_junio, aporte_julio,comentarios_julio, aporte_agosto,comentarios_agosto, aporte_septiembre,comentarios_septiembre, aporte_octubre,comentarios_octubre, aporte_noviembre,comentarios_noviembre, aporte_diciembre,comentarios_diciembre) VALUES ('".$cedula."','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '')");
mysql_query("INSERT INTO retirable_2020 (cedula, aporte_enero,retiros_enero, aporte_febrero,retiros_febrero, aporte_marzo,retiros_marzo, aporte_abril,retiros_abril, aporte_mayo,retiros_mayo, aporte_junio,retiros_junio, aporte_julio,retiros_julio, aporte_agosto,retiros_agosto, aporte_septiembre,retiros_septiembre, aporte_octubre,retiros_octubre, aporte_noviembre,retiros_noviembre, aporte_diciembre,retiros_diciembre) VALUES ('".$cedula."','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0')");
mysql_query("INSERT INTO ahorros_2021 (cedula, aporte_enero,comentarios_enero, aporte_febrero,comentarios_febrero, aporte_marzo,comentarios_marzo, aporte_abril,comentarios_abril, aporte_mayo,comentarios_mayo, aporte_junio,comentarios_junio, aporte_julio,comentarios_julio, aporte_agosto,comentarios_agosto, aporte_septiembre,comentarios_septiembre, aporte_octubre,comentarios_octubre, aporte_noviembre,comentarios_noviembre, aporte_diciembre,comentarios_diciembre) VALUES ('".$cedula."','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '')");
mysql_query("INSERT INTO retirable_2021 (cedula, aporte_enero,retiros_enero, aporte_febrero,retiros_febrero, aporte_marzo,retiros_marzo, aporte_abril,retiros_abril, aporte_mayo,retiros_mayo, aporte_junio,retiros_junio, aporte_julio,retiros_julio, aporte_agosto,retiros_agosto, aporte_septiembre,retiros_septiembre, aporte_octubre,retiros_octubre, aporte_noviembre,retiros_noviembre, aporte_diciembre,retiros_diciembre) VALUES ('".$cedula."','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0')");

mysql_query("INSERT INTO ahorros_2019 (cedula, aporte_enero,comentarios_enero, aporte_febrero,comentarios_febrero, aporte_marzo,comentarios_marzo, aporte_abril,comentarios_abril, aporte_mayo,comentarios_mayo, aporte_junio,comentarios_junio, aporte_julio,comentarios_julio, aporte_agosto,comentarios_agosto, aporte_septiembre,comentarios_septiembre, aporte_octubre,comentarios_octubre, aporte_noviembre,comentarios_noviembre, aporte_diciembre,comentarios_diciembre) VALUES ('".$cedula."','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '')");
mysql_query("INSERT INTO retirable_2019 (cedula, aporte_enero,retiros_enero, aporte_febrero,retiros_febrero, aporte_marzo,retiros_marzo, aporte_abril,retiros_abril, aporte_mayo,retiros_mayo, aporte_junio,retiros_junio, aporte_julio,retiros_julio, aporte_agosto,retiros_agosto, aporte_septiembre,retiros_septiembre, aporte_octubre,retiros_octubre, aporte_noviembre,retiros_noviembre, aporte_diciembre,retiros_diciembre) VALUES ('".$cedula."','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0')");
mysql_query("INSERT INTO ahorros_2018 (cedula, aporte_enero,comentarios_enero, aporte_febrero,comentarios_febrero, aporte_marzo,comentarios_marzo, aporte_abril,comentarios_abril, aporte_mayo,comentarios_mayo, aporte_junio,comentarios_junio, aporte_julio,comentarios_julio, aporte_agosto,comentarios_agosto, aporte_septiembre,comentarios_septiembre, aporte_octubre,comentarios_octubre, aporte_noviembre,comentarios_noviembre, aporte_diciembre,comentarios_diciembre) VALUES ('".$cedula."','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '','0', '')");
mysql_query("INSERT INTO retirable_2018 (cedula, aporte_enero,retiros_enero, aporte_febrero,retiros_febrero, aporte_marzo,retiros_marzo, aporte_abril,retiros_abril, aporte_mayo,retiros_mayo, aporte_junio,retiros_junio, aporte_julio,retiros_julio, aporte_agosto,retiros_agosto, aporte_septiembre,retiros_septiembre, aporte_octubre,retiros_octubre, aporte_noviembre,retiros_noviembre, aporte_diciembre,retiros_diciembre) VALUES ('".$cedula."','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0')");
mysql_query("INSERT INTO retirable_2017 (cedula, aporte_enero,retiros_enero, aporte_febrero,retiros_febrero, aporte_marzo,retiros_marzo, aporte_abril,retiros_abril, aporte_mayo,retiros_mayo, aporte_junio,retiros_junio, aporte_julio,retiros_julio, aporte_agosto,retiros_agosto, aporte_septiembre,retiros_septiembre, aporte_octubre,retiros_octubre, aporte_noviembre,retiros_noviembre, aporte_diciembre,retiros_diciembre) VALUES ('".$cedula."','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0')");
mysql_query("INSERT INTO retirable_2016 (cedula, aporte_enero,retiros_enero, aporte_febrero,retiros_febrero, aporte_marzo,retiros_marzo, aporte_abril,retiros_abril, aporte_mayo,retiros_mayo, aporte_junio,retiros_junio, aporte_julio,retiros_julio, aporte_agosto,retiros_agosto, aporte_septiembre,retiros_septiembre, aporte_octubre,retiros_octubre, aporte_noviembre,retiros_noviembre, aporte_diciembre,retiros_diciembre) VALUES ('".$cedula."','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0')");
mysql_query("INSERT INTO retirable_2015 (cedula, aporte_enero,retiros_enero, aporte_febrero,retiros_febrero, aporte_marzo,retiros_marzo, aporte_abril,retiros_abril, aporte_mayo,retiros_mayo, aporte_junio,retiros_junio, aporte_julio,retiros_julio, aporte_agosto,retiros_agosto, aporte_septiembre,retiros_septiembre, aporte_octubre,retiros_octubre, aporte_noviembre,retiros_noviembre, aporte_diciembre,retiros_diciembre) VALUES ('".$cedula."','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0','0', '0')");
mysql_query("INSERT INTO aviso (nombre, apellido, cedula, estatus) VALUES ('".$nombre."','".$apellido."','".$cedula."','0')");

echo "El usuario de cedula: ".$cedula." ha sido creado visite la lista de usuarios para verificar";


}
?>


</div>
</div>

</div>
</div>
</div>
</section>
	<footer>
	<center style="background:#232f3e;color:white;font-weight:bold;">© 2021 COOPROCON<center>
<div id="footer"></div></footer>
</body>

</html>
