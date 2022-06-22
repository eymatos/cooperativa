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
$query_sexo = sprintf("SELECT * FROM usuarios WHERE cedula = %s", GetSQLValueString($colname_sexo, "text"));
$sexo = mysqli_query($sgstec,$query_sexo) or die(mysqli_error());
$row_sexo = mysqli_fetch_assoc($sexo);
$totalRows_sexo = mysqli_num_rows($sexo);
$_SESSION['id'] = $row_sexo['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><!-- Global site tag (gtag.js) - Google Analytics --><script async src="https://www.googletagmanager.com/gtag/js?id=UA-60738677-4"></script><script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-60738677-4');</script><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<style>
form {width:250px;}
form>div>span {width:75px;display: inline-block;text-align:left;}
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
<?php
$resultado=mysqli_query($sgstec,$query_sexo);
$row = mysqli_fetch_assoc($resultado);
$cedula= $row['cedula'];
if ($cedula === '001-0078306-7' or $cedula === '001-1746512-0' or $cedula === '223-0119516-4' or $cedula === '001-1314990-0' ){?>
<h1>Sección de Administrador</h1>
<div>
<table>

<tr>
<td style="padding:10px;">
<img src="agregarusuario.png" title="Esta sección sirve para agregar nuevos usuarios" width="75" height="auto">
</td>
<td style="padding:10px;">
<img src="usuario.png" title="Ver todos los datos de todos los usuarios" width="75" height="auto">
</td>
<td style="padding:10px;">
<img src="eliminar_usuario.png" title="Eliminar usuarios existentes" width="75" height="auto">
</td>
<td style="padding:10px;">
<img src="user_admin.png" title="Opciones de usuarios" width="100" height="auto">
</td>
<td style="padding:10px;"><img src="publica.png" title="Crear una nueva publicación" width="75" height="auto"></td>
<td style="padding:10px;"><img src="files-png.png" title="Ver archivos en sistema" width="75" height="auto"></td>
<td style="padding:10px;"><img src="upload.png" title="Subir archivos al sistema" width="75" height="auto"></td>
<td style="padding:10px;"><img src="visita.png" title="Ver registro de visitas" width="75" height="auto"></td>
<td style="padding:10px;"><img src="aviso.png" title="Agregar aviso" width="75" height="auto"></td>
<td style="padding:10px;"><img src="eliminaraviso.png" title="Eliminar Aviso" width="75" height="auto"></td>
</tr>
<tr>
<td style="padding:10px;width:75px;text-align:center;">
<a href="crearusuario.php" title="Esta sección sirve para agregar nuevos usuarios" >Agregar usuarios</a>
</td>
<td style="padding:10px;width:75px;text-align:center;">
<a href="ver_socios.php" title="Ver todos los datos de todos los usuarios">Ver usuarios</a>
</td>
<td style="padding:10px;width:75px;text-align:center;">
<a href="borrarusuario.php" title="Eliminar usuarios existentes">Eliminar Usuario</a>
</td>
<td style="padding:10px;width:75px;text-align:center;">
<a href="seluser.php" title="Opciones de usuarios">Administrar usuarios</a>
</td>
<td style="padding:10px;width:75px;text-align:center;">
<a href="subir_archivos.php" title="Crear una nueva publicación">Publicar Noticia</a>
</td>
<td style="padding:10px;width:75px;text-align:center;">
<a href="/Zr6867TyPUiXLM8462KLQZADFXBGERTUIJKLMJKASDRTYasf5678" title="Ver archivos en sistema">Ver archivos</a>
</td>
<td style="padding:10px;width:75px;text-align:center;">
<a href="upload.php" title="Subir archivos al sistema">Subir Archivos</a>
</td>
<td style="padding:10px;width:75px;text-align:center;">
<a href="vervisitas.php" title="Ver registro de visitas">Registro de visitas</a>
</td>
<td style="padding:10px;width:75px;text-align:center;">
<a href="aviso.php" title="Agregar Aviso">Agregar aviso</a>
</td>
<td style="padding:10px;width:75px;text-align:center;">
<a href="eliminaraviso.php" title="Eliminar aviso">Eliminar aviso</a>
</td>
</tr>
</table>

</div>
<?php
} else {echo "<h2>No eres administrador, vuelve atras!!!</h2><br>";
echo "<img src='wrong.png' width='300'>";}
?>
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
<?php
mysqli_free_result($sexo);
?>