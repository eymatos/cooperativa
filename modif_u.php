<?php require_once('Connections/sgstec.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "actualizar_u")) {
  $updateSQL = sprintf("UPDATE usuarios SET nombre=%s, apellido=%s, sexo=%s, email=%s=%s WHERE id=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['sexo'], "int"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['departamento'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysqli_select_db($sgstec,$database_sgstec);
  $Result1 = mysqli_query($updateSQL, $sgstec) or die(mysqli_error());

  $updateGoTo = "perfil_u.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

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
$query_sexo = sprintf("SELECT * FROM usuarios WHERE cedula = %s", GetSQLValueString($colname_sexo, "text"));
$sexo = mysqli_query($sgstec,$query_sexo) or die(mysqli_error());
$row_sexo = mysqli_fetch_assoc($sexo);
$totalRows_sexo = mysqli_num_rows($sexo);


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
<script>
window.onload=funtion(){
	cont_mensajes(<?php echo $row_sexo['id']; ?>);
}
</script>
</head>
<body onload="cargar_funciones(<?php echo $row_sexo['id']; ?>)">
<header>
	<div id="secondbox">
    	<a href="inicio.php"><div id="logo" class="fleft"></div></a>
        <?php encabezados();?>
<div class="fright">
  
        </div>
       <div id="bienvenida">Hola <?php echo p_nombre($row_sexo['nombre']); ?> <?php echo p_nombre($row_sexo['apellido']); ?></div>
        <div id="menu"><?php sidemenu();?></div>
		<section style="min-height:605px!important;">       
        <div id="contenido">
        	<form action="<?php echo $editFormAction; ?>" name="actualizar_u" method="POST" id="actualizar_u">
<table width="100%" border="0" cellspacing="5" cellpadding="5" id="perfil1">
  <tr>
    <td colspan="2" id="encabezado">Perfil de Usuario</td>
    </tr>
  <tr>
    <td style="font-weight: bold; padding-top: 20px;">Nombre :</td>
    <td style="padding-top: 20px;"><label for="nombre"></label>
      <input name="nombre" type="text" id="nombre" value="<?php echo $row_sexo['nombre']; ?>" />
      <input name="id" type="hidden" id="id" value="<?php echo $row_sexo['id']; ?>" /></td>
  </tr>
  <tr>
    <td style="font-weight: bold;">Apellido :</td>
    <td><span style="padding-top: 20px;">
      <input name="apellido" type="text" id="apellido" value="<?php echo $row_sexo['apellido']; ?>" />
    </span></td>
  </tr>
  <tr>
    <td style="font-weight: bold;">Sexo :</td>
    <td>
      <table width="200">
        <tr>
          <td><label>
            <input <?php if (!(strcmp($row_sexo['sexo'],"1"))) {echo "checked=\"checked\"";} ?> type="radio" name="sexo" value="1" id="Sexo_0" />
            Masculino</label></td>
        </tr>
        <tr>
          <td><label>
            <input <?php if (!(strcmp($row_sexo['sexo'],"0"))) {echo "checked=\"checked\"";} ?> type="radio" name="sexo" value="0" id="Sexo_1" />
            Femenino</label></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td style="font-weight: bold;">E-mail :</td>
    <td><span style="padding-top: 20px;">
    <input name="email" type="text" id="email" value="<?php echo $row_sexo['email']; ?>" size="40" />
    </span></td>
  </tr>
  <tr>
    <td style="font-weight: bold;">Cédula :</td>
    <td><span style="padding-top: 20px;">
    <input name="cedula" type="text" value="<?php echo $row_sexo['cedula']; ?>" readonly="readonly" />
    </span></td>
  </tr>
  
          </table>
          <div style="text-align: right; padding-right: 20px;"><input class="enviar" type="submit" value="Guardar" /></div>
          <input type="hidden" name="MM_update" value="actualizar_u" />
          </form>
</div>
        <div class="clearfix"></div>
    </div>
</section>
	<footer>
	<center style="background:#232f3e;color:white;font-weight:bold;">© 2021 COOPROCON<center>
<div id="footer"></div></footer>
</body>
</html>
<?php
mysqli_free_result($sexo);

mysqli_free_result($departamento);

mysqli_free_result($Recordset1);
?>
