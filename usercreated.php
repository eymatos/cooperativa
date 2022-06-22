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
$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_sgstec, $sgstec);
$query_usuario = sprintf("SELECT id, sexo, nombre, apellido, cedula, cedula FROM usuarios WHERE cedula = %s", GetSQLValueString($colname_usuario, "text"));
$cedula = mysql_query($query_usuario, $sgstec) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($cedula);
$totalRows_usuario = mysql_num_rows($cedula);

mysql_select_db($database_sgstec, $sgstec);
$query_Usuarios = "SELECT id, nombre, apellido FROM usuarios WHERE departamento = ".$row_usuario['departamento']." ORDER BY nombre ASC";
$Usuarios = mysql_query($query_Usuarios, $sgstec) or die(mysql_error());
$row_Usuarios = mysql_fetch_assoc($Usuarios);
$totalRows_Usuarios = mysql_num_rows($Usuarios);

$colname_Usuario = "-1";
if (isset($_GET['user'])) {
  $colname_Usuario = $_GET['user'];
}
mysql_select_db($database_sgstec, $sgstec);
$query_Usuario = sprintf("SELECT nombre, apellido, sexo, email, cedula, clave, tipo_usuario FROM usuarios WHERE cedula = %s", GetSQLValueString($colname_Usuario, "text"));
$Usuario = mysql_query($query_Usuario, $sgstec) or die(mysql_error());
$row_Usuario = mysql_fetch_assoc($Usuario);
$totalRows_Usuario = mysql_num_rows($Usuario);

mysql_select_db($database_sgstec, $sgstec);
$query_departamento = "SELECT localidad FROM departamentos WHERE id = ' ".$row_Usuario['departamento']."'";
$departamento = mysql_query($query_departamento, $sgstec) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);
$totalRows_departamento = mysql_num_rows($departamento);

$cedula = $row_usuario['id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><!-- Global site tag (gtag.js) - Google Analytics --><script async src="https://www.googletagmanager.com/gtag/js?id=UA-60738677-4"></script><script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-60738677-4');</script><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: Sistema de Gestión de Servicios Técnicos ::</title>

<link href="css/estilos1.css" rel="stylesheet" type="text/css" />
<script src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/libreria.js" type="text/javascript"></script>
<script>
window.onload=funtion(){
	cont_mensajes(<?php echo $row_sexo['id']; ?>);
}
</script>
</head>
<body>
	<div id="secondbox">
    	<div id="logo" class="fleft">
        	&nbsp;
        </div>
        <?php encabezados();?>
<div class="fright">
        	<?php menu();?>
        </div>
        <div class="clearfix"></div>
        <?php sidemenu();?>
        <div id="cpanel1">
<div id="formulario">
   	  <div class="encabezado_azul">Usuario Creado</div>
       <ul id="nuvousuario">
       		<li><span>Nombre:</span><?php echo $row_Usuario['nombre']; ?></li>
            <li><span>Apellido:</span><?php echo $row_Usuario['apellido']; ?></li>
            <li><span>Sexo:</span><?php echo sexo($row_Usuario['sexo']); ?></li>
            <li><span>E-mail:</span><?php echo $row_Usuario['email']; ?></li>
            <li><span>Usuario:</span><?php echo $row_Usuario['cedula']; ?></li>
            <li><span>Departamento:</span><?php echo htmlentities($row_departamento['departamento'])." - ". $row_departamento['localidad']; ?></li>
            <li><span>Tipo de Usuario:</span><?php echo tipousuario3($row_Usuario['tipo_usuario']); ?></li>
       </ul>     
</div>
</div>
        <div class="clearfix"></div>
         <?php bienvenida($row_usuario['sexo'],$row_usuario['nombre'],$row_usuario['apellido']);?>
    </div>
    
</body>
</html>
<?php
//mysql_free_result($cedula);

mysql_free_result($Usuarios);

mysql_free_result($Usuario);

mysql_free_result($departamento);
?>
