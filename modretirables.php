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
<?php retornoadmin();
@$sitio=$_GET['sitio'];?>
<h1>Administrar retirables</h1>
<form action="modretirables.php?sitio=<?php echo $sitio; ?>" method="POST">
<input type="text" name="sitio" value="<?php echo $sitio?>" style="display:none;">
<span><b>Seleccionar Año:</b></span>
<select style="width:100%;margin:auto;text-align:center;" name="sitio2">
<option value="retirable_2021">2021</option>
<option value="retirable_2020">2020</option>
<option value="retirable_2019">2019</option>
<option value="retirable_2018">2018</option>
<option value="retirable_2017">2017</option>
<option value="retirable_2016">2016</option>
<option value="retirable_2015">2015</option>
</select>
<span><b>Seleccionar aporte o retiro y mes:</b></span>
<select style="width:100%;margin:auto;text-align:center;" name="sitio3">
<option value="aporte_diciembre">Aporte Diciembre</option>
<option value="aporte_noviembre">Aporte Noviembre</option>
<option value="aporte_octubre">Aporte Octubre</option>
<option value="aporte_septiembre">Aporte Septiembre</option>
<option value="aporte_agosto">Aporte Agosto</option>
<option value="aporte_julio">Aporte Julio</option>
<option value="aporte_junio">Aporte Junio</option>
<option value="aporte_mayo">Aporte Mayo</option>
<option value="aporte_abril">Aporte Abril</option>
<option value="aporte_marzo">Aporte Marzo</option>
<option value="aporte_febrero">Aporte Febrero</option>
<option value="aporte_enero">Aporte Enero</option>
<option value="retiros_diciembre">Retiros Diciembre</option>
<option value="retiros_noviembre">Retiros Noviembre</option>
<option value="retiros_octubre">Retiros Octubre</option>
<option value="retiros_septiembre">Retiros Septiembre</option>
<option value="retiros_agosto">Retiros Agosto</option>
<option value="retiros_julio">Retiros Julio</option>
<option value="retiros_junio">Retiros Junio</option>
<option value="retiros_mayo">Retiros Mayo</option>
<option value="retiros_abril">Retiros Abril</option>
<option value="retiros_marzo">Retiros Marzo</option>
<option value="retiros_febrero">Retiros Febrero</option>
<option value="retiros_enero">Retiros Enero</option>
</select>

<span><b>Monto nuevo:</b>(Usar formato sin coma en los miles)</span>
<span style="margin-bottom:15px;"><input type="text" name="monto"  maxlength=9 style="margin-bottom:15px;"></span><br>
<input class="enviar" type="submit" value="Agregar monto nuevo">
</form>
<?php @$cedula=$_POST['sitio'];
@$sitio2=$_POST['sitio2'];
@$sitio3=$_POST['sitio3'];
$monto=$_POST["monto"];
$query30=sprintf("SELECT * FROM usuarios WHERE cedula LIKE '$sitio'");
$resultado30=mysql_query($query30);
$row30 = mysql_fetch_assoc($resultado30);
$nombre=$row30['nombre'];
$apellido=$row30['apellido'];
echo "Usted ha seleccionado a $nombre $apellido de cédula $sitio";
if($cedula && $sitio2 && $sitio3 && $monto)
{	

mysql_query("UPDATE $sitio2 SET $sitio3='$monto' WHERE cedula='$cedula'") or die(mysql_error());
	
echo "El nuevo monto ahorrado para ".$cedula." es ".$monto." Aplicado en la seccion del mes ".$sitio3." de la tabla de año ".$sitio2;

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
<?php
mysql_free_result($sexo);
?>