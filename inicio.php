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
$query_sexo = sprintf("SELECT id,cedula,nombre, apellido, sexo, clave FROM usuarios WHERE cedula = %s", GetSQLValueString($colname_sexo, "text"));
$sexo = mysqli_query($sgstec,$query_sexo) or die(mysqli_error());
$row_sexo = mysqli_fetch_assoc($sexo);
$totalRows_sexo = mysqli_num_rows($sexo);
$_SESSION['id'] = $row_sexo['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><!-- Global site tag (gtag.js) - Google Analytics --><script async src="https://www.googletagmanager.com/gtag/js?id=UA-60738677-4"></script><script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-60738677-4');</script><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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

<?php
$nombron=p_nombre($row_sexo['nombre']);
$apellidon=p_nombre($row_sexo['apellido']);
$cedulon=p_nombre($row_sexo['cedula']);
$fechon= date('d-m-Y H:i:s');
if ($cedulon != '001-0078306-7' and $cedulon != '001-1746512-0' and $cedulon != '223-0119516-4' and $cedulon != '402-2292241-7' and $cedulon != '001-1314990-0'){
$sqlregistro = ("INSERT INTO registro (id, cedula, nombre, apellido, fecha) VALUES ('', '".$cedulon."', '".$nombron."', '".$apellidon."', CURRENT_TIMESTAMP)");
$registro = mysqli_query($sqlregistro, $sgstec) or die(mysqli_error());
}
$clave=p_nombre($row_sexo['clave']);
if ($clave==="e3b26fab2dbc855b1a5d84544ed6b601"){?><script language="javascript">
      alert('Por favor, por tu seguridad visita nuestra sección MI USUARIO y cambia tu contraseña');
    </script><?php }?>
        
		</header>
<section> 
<div id="menu"><?php sidemenu();?></div>      
<div id="contenido">
<p style="border: 1px double #232F3E;    margin-bottom: 10px!important;text-align:left;padding:3px;"><img src="ahorro.jpg" width="350" height="auto" style="float: left;margin-right: 10px;">La Cooperativa de Ahorros, Créditos y Servicios Múltiples de los Empleados del Instituto Nacional de los Derechos del Consumidor, COOPROCON, es una entidad que surge con el objetivo de promover y fortalecer el ejercicio de la solidaridad entre los socios y sus familias, así como también fomentar una cultura de ahorro y colaborar para que los asociados, empleados de Pro Consumidor, puedan atender necesidades individuales o familiares de carácter financiero, al tipo de interés más razonable posible. 
</p>

<?php
mysqli_query("SET NAMES 'utf8'");
$query3="SELECT * FROM archivos ORDER BY id DESC limit 2";
$resultado3=mysqli_query($sgstec,$query3);
while ($row3 = mysqli_fetch_array($resultado3)):;
$ruta=$row3[3];
echo "<div style='width: 100%;height:auto;border: 1px double #232F3E;margin-bottom: 3px;text-align:left;padding:10px; display:inline-block;
    margin-left:auto;
    margin-right:auto;
    '><div style='    float: left;'><img src='fotos/$ruta' width='200' height='auto' style='float: left;margin-right: 10px;'></div><div><p><h2>".$row3[1]."</h2></p><p><h5>".$row3[6]."</h5></p><p>".$row3[2]."</p></div></div>";
 ?>
  <?php endwhile; ?>
</div>
</section>
<footer>
<center style="background:#232F3E;color:white;font-weight:bold;">© 2021 COOPROCON</center>
<div id="footer"></div></footer> 
</body>
</html>
<?php
mysqli_free_result($sexo);
?>
