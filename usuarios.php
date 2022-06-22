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

$colname_sexo = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_sexo = $_SESSION['MM_Username'];
}
mysqli_select_db($sgstec,$database_sgstec);
$query_sexo = sprintf("SELECT nombre, apellido, sexo FROM usuarios WHERE cedula = %s", GetSQLValueString($colname_sexo, "text"));
$sexo = mysqli_query($sgstec,$query_sexo) or die(mysqli_error());
$row_sexo = mysqli_fetch_assoc($sexo);
$totalRows_sexo = mysqli_num_rows($sexo);
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
        	<table width="422" cellspacing="5">
            	<tr>
                	<td align="center" valign="middle"><a class="icon" href="perfil_u.php"><img src="images/icons/perfil_<?php if($row_sexo['sexo']==1){?>m<?php }else{?>f<?php } ?>.jpg" width="50" height="50" /></a></td>
                    <td align="center" valign="middle"><a class="icon" href="ident_usr_solicitud.php"><img src="images/icons/s_servicio.jpg" width="50" height="50" /></a></td>
                    <td align="center" valign="middle"><a class="icon" href="solicitud_e.php"><img src="images/icons/s_equipo.jpg" width="50" height="50" /></a></td>
                </tr>
                <tr>
                	<td align="center" valign="middle"><a class="enlace" href="perfil_u.php">Mi Usuario</a></td>
                    <td align="center" valign="middle"><a class="enlace" href="ident_usr_solicitud.php">Solicitar Servicio</a></td>
                    <td align="center" valign="middle"><a class="enlace" href="solicitud_e.php">Solicitar Equipo</a></td>
                </tr>
                <tr>
                	<td align="center" valign="middle"><a class="icon" href="ident_usr_solicitud2.php"><img src="images/icons/solicitud_<?php if($row_sexo['sexo']==1){?>m<?php }else{?>f<?php } ?>.jpg" width="50" height="50" /></a></td>
                    <td align="center" valign="middle"><a class="icon" href="<?php echo $logoutAction ?>"><img src="images/icons/<?php if($row_sexo['sexo']==1){?>m<?php }else{?>f<?php } ?>_logout.jpg" width="50" height="50" /></a></td>
                    <td align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                	<td align="center" valign="middle"><a class="enlace" href="ident_usr_solicitud2.php">Ver Solicitudes</a></td>
                    <td align="center" valign="middle"><a href="<?php echo $logoutAction ?>" class="enlace">Cerrar Sesi&oacute;n</a></td>
                    <td align="center" valign="middle">&nbsp;</td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
        <div id="bienvenida">Bienvenid<?php if($row_sexo['sexo']==1){?>o<?php }else{?>a<?php } ?> <?php echo p_nombre($row_sexo['nombre']); ?> <?php echo p_nombre($row_sexo['apellido']); ?></div>
    </div>
</body>
</html>
<?php
mysqli_free_result($sexo);
?>
