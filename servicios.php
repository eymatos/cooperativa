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
       
		</div>
		</header>
		<section> 
<div id="menu"><?php sidemenu();?></div>		
        <div id="contenido" style="background: #e6e6e6;">
<div id="ahorros2" style="
    width: 100%;
    clear: both;
    margin-top: 20px;
    padding: 10px;
    background: white;
	border-radius: 10px;
	display: inline-block;
">
<div>
<?php retornoadminb();
$sitio=$_POST['sitio'];?>
<br>
<br>
</div>
<div>
<div id="ahorross">
<?php
@$sitio20=$_POST['sitio20'];
//$cedula=$_POST['cedula'];
?>
<?php
$query30=sprintf("SELECT * FROM usuarios WHERE cedula LIKE '$sitio'");
$resultado30=mysqli_query($sgstec,$query30);
$row30 = mysqli_fetch_assoc($resultado30);
$nombre=$row30['nombre'];
$apellido=$row30['apellido'];
$guia=$row30 ['guia'];
$guia_reti=$row30 ['guia_reti'];
$sumadeahorros=$guia+$guia_reti;
$guia=number_format($guia, 2, '.', ',');
$guia_reti=number_format($guia_reti, 2, '.', ',');

$retirables2021=sprintf("SELECT * FROM retirable_2021 WHERE cedula LIKE '$sitio'");
$resultable2021=mysqli_query($sgstec,$retirables2021);
$rowresult2021 = mysqli_fetch_assoc($resultable2021);
$deposito_enero2021=$rowresult2021['aporte_enero'];
$retirable_enero2021=$rowresult2021['retiros_enero'];
$deposito_febrero2021=$rowresult2021['aporte_febrero'];
$retirable_febrero2021=$rowresult2021['retiros_febrero'];
$deposito_marzo2021=$rowresult2021['aporte_marzo'];
$retirable_marzo2021=$rowresult2021['retiros_marzo'];
$deposito_abril2021=$rowresult2021['aporte_abril'];
$retirable_abril2021=$rowresult2021['retiros_abril'];
$deposito_mayo2021=$rowresult2021['aporte_mayo'];
$retirable_mayo2021=$rowresult2021['retiros_mayo'];
$deposito_junio2021=$rowresult2021['aporte_junio'];
$retirable_junio2021=$rowresult2021['retiros_junio'];
$deposito_julio2021=$rowresult2021['aporte_julio'];
$retirable_julio2021=$rowresult2021['retiros_julio'];
$deposito_agosto2021=$rowresult2021['aporte_agosto'];
$retirable_agosto2021=$rowresult2021['retiros_agosto'];
$deposito_septiembre2021=$rowresult2021['aporte_septiembre'];
$retirable_septiembre2021=$rowresult2021['retiros_septiembre'];
$deposito_octubre2021=$rowresult2021['aporte_octubre'];
$retirable_octubre2021=$rowresult2021['retiros_octubre'];
$deposito_noviembre2021=$rowresult2021['aporte_noviembre'];
$retirable_noviembre2021=$rowresult2021['retiros_noviembre'];
$deposito_diciembre2021=$rowresult2021['aporte_diciembre'];
$retirable_diciembre2021=$rowresult2021['retiros_diciembre'];

$retirables2020=sprintf("SELECT * FROM retirable_2020 WHERE cedula LIKE '$sitio'");
$resultable2020=mysqli_query($sgstec,$retirables2020);
$rowresult2020 = mysqli_fetch_assoc($resultable2020);
$deposito_enero2020=$rowresult2020['aporte_enero'];
$retirable_enero2020=$rowresult2020['retiros_enero'];
$deposito_febrero2020=$rowresult2020['aporte_febrero'];
$retirable_febrero2020=$rowresult2020['retiros_febrero'];
$deposito_marzo2020=$rowresult2020['aporte_marzo'];
$retirable_marzo2020=$rowresult2020['retiros_marzo'];
$deposito_abril2020=$rowresult2020['aporte_abril'];
$retirable_abril2020=$rowresult2020['retiros_abril'];
$deposito_mayo2020=$rowresult2020['aporte_mayo'];
$retirable_mayo2020=$rowresult2020['retiros_mayo'];
$deposito_junio2020=$rowresult2020['aporte_junio'];
$retirable_junio2020=$rowresult2020['retiros_junio'];
$deposito_julio2020=$rowresult2020['aporte_julio'];
$retirable_julio2020=$rowresult2020['retiros_julio'];
$deposito_agosto2020=$rowresult2020['aporte_agosto'];
$retirable_agosto2020=$rowresult2020['retiros_agosto'];
$deposito_septiembre2020=$rowresult2020['aporte_septiembre'];
$retirable_septiembre2020=$rowresult2020['retiros_septiembre'];
$deposito_octubre2020=$rowresult2020['aporte_octubre'];
$retirable_octubre2020=$rowresult2020['retiros_octubre'];
$deposito_noviembre2020=$rowresult2020['aporte_noviembre'];
$retirable_noviembre2020=$rowresult2020['retiros_noviembre'];
$deposito_diciembre2020=$rowresult2020['aporte_diciembre'];
$retirable_diciembre2020=$rowresult2020['retiros_diciembre'];

$retirables2019=sprintf("SELECT * FROM retirable_2019 WHERE cedula LIKE '$sitio'");
$resultable2019=mysqli_query($sgstec,$retirables2019);
$rowresult2019 = mysqli_fetch_assoc($resultable2019);
$deposito_enero2019=$rowresult2019['aporte_enero'];
$retirable_enero2019=$rowresult2019['retiros_enero'];
$deposito_febrero2019=$rowresult2019['aporte_febrero'];
$retirable_febrero2019=$rowresult2019['retiros_febrero'];
$deposito_marzo2019=$rowresult2019['aporte_marzo'];
$retirable_marzo2019=$rowresult2019['retiros_marzo'];
$deposito_abril2019=$rowresult2019['aporte_abril'];
$retirable_abril2019=$rowresult2019['retiros_abril'];
$deposito_mayo2019=$rowresult2019['aporte_mayo'];
$retirable_mayo2019=$rowresult2019['retiros_mayo'];
$deposito_junio2019=$rowresult2019['aporte_junio'];
$retirable_junio2019=$rowresult2019['retiros_junio'];
$deposito_julio2019=$rowresult2019['aporte_julio'];
$retirable_julio2019=$rowresult2019['retiros_julio'];
$deposito_agosto2019=$rowresult2019['aporte_agosto'];
$retirable_agosto2019=$rowresult2019['retiros_agosto'];
$deposito_septiembre2019=$rowresult2019['aporte_septiembre'];
$retirable_septiembre2019=$rowresult2019['retiros_septiembre'];
$deposito_octubre2019=$rowresult2019['aporte_octubre'];
$retirable_octubre2019=$rowresult2019['retiros_octubre'];
$deposito_noviembre2019=$rowresult2019['aporte_noviembre'];
$retirable_noviembre2019=$rowresult2019['retiros_noviembre'];
$deposito_diciembre2019=$rowresult2019['aporte_diciembre'];
$retirable_diciembre2019=$rowresult2019['retiros_diciembre'];
$retirables2018=sprintf("SELECT * FROM retirable_2018 WHERE cedula LIKE '$sitio'");
$resultable2018=mysqli_query($sgstec,$retirables2018);
$rowresult2018 = mysqli_fetch_assoc($resultable2018);
$deposito_enero2018=$rowresult2018['aporte_enero'];
$retirable_enero2018=$rowresult2018['retiros_enero'];
$deposito_febrero2018=$rowresult2018['aporte_febrero'];
$retirable_febrero2018=$rowresult2018['retiros_febrero'];
$deposito_marzo2018=$rowresult2018['aporte_marzo'];
$retirable_marzo2018=$rowresult2018['retiros_marzo'];
$deposito_abril2018=$rowresult2018['aporte_abril'];
$retirable_abril2018=$rowresult2018['retiros_abril'];
$deposito_mayo2018=$rowresult2018['aporte_mayo'];
$retirable_mayo2018=$rowresult2018['retiros_mayo'];
$deposito_junio2018=$rowresult2018['aporte_junio'];
$retirable_junio2018=$rowresult2018['retiros_junio'];
$deposito_julio2018=$rowresult2018['aporte_julio'];
$retirable_julio2018=$rowresult2018['retiros_julio'];
$deposito_agosto2018=$rowresult2018['aporte_agosto'];
$retirable_agosto2018=$rowresult2018['retiros_agosto'];
$deposito_septiembre2018=$rowresult2018['aporte_septiembre'];
$retirable_septiembre2018=$rowresult2018['retiros_septiembre'];
$deposito_octubre2018=$rowresult2018['aporte_octubre'];
$retirable_octubre2018=$rowresult2018['retiros_octubre'];
$deposito_noviembre2018=$rowresult2018['aporte_noviembre'];
$retirable_noviembre2018=$rowresult2018['retiros_noviembre'];
$deposito_diciembre2018=$rowresult2018['aporte_diciembre'];
$retirable_diciembre2018=$rowresult2018['retiros_diciembre'];
$retirables2017=sprintf("SELECT * FROM retirable_2017 WHERE cedula LIKE '$sitio'");
$resultable2017=mysqli_query($sgstec,$retirables2017);
$rowresult2017 = mysqli_fetch_assoc($resultable2017);
$deposito_enero2017=$rowresult2017['aporte_enero'];
$retirable_enero2017=$rowresult2017['retiros_enero'];
$deposito_febrero2017=$rowresult2017['aporte_febrero'];
$retirable_febrero2017=$rowresult2017['retiros_febrero'];
$deposito_marzo2017=$rowresult2017['aporte_marzo'];
$retirable_marzo2017=$rowresult2017['retiros_marzo'];
$deposito_abril2017=$rowresult2017['aporte_abril'];
$retirable_abril2017=$rowresult2017['retiros_abril'];
$deposito_mayo2017=$rowresult2017['aporte_mayo'];
$retirable_mayo2017=$rowresult2017['retiros_mayo'];
$deposito_junio2017=$rowresult2017['aporte_junio'];
$retirable_junio2017=$rowresult2017['retiros_junio'];
$deposito_julio2017=$rowresult2017['aporte_julio'];
$retirable_julio2017=$rowresult2017['retiros_julio'];
$deposito_agosto2017=$rowresult2017['aporte_agosto'];
$retirable_agosto2017=$rowresult2017['retiros_agosto'];
$deposito_septiembre2017=$rowresult2017['aporte_septiembre'];
$retirable_septiembre2017=$rowresult2017['retiros_septiembre'];
$deposito_octubre2017=$rowresult2017['aporte_octubre'];
$retirable_octubre2017=$rowresult2017['retiros_octubre'];
$deposito_noviembre2017=$rowresult2017['aporte_noviembre'];
$retirable_noviembre2017=$rowresult2017['retiros_noviembre'];
$deposito_diciembre2017=$rowresult2017['aporte_diciembre'];
$retirable_diciembre2017=$rowresult2017['retiros_diciembre'];
$retirables2016=sprintf("SELECT * FROM retirable_2016 WHERE cedula LIKE '$sitio'");
$resultable2016=mysqli_query($sgstec,$retirables2016);
$rowresult2016 = mysqli_fetch_assoc($resultable2016);
$deposito_enero2016=$rowresult2016['aporte_enero'];
$retirable_enero2016=$rowresult2016['retiros_enero'];
$deposito_febrero2016=$rowresult2016['aporte_febrero'];
$retirable_febrero2016=$rowresult2016['retiros_febrero'];
$deposito_marzo2016=$rowresult2016['aporte_marzo'];
$retirable_marzo2016=$rowresult2016['retiros_marzo'];
$deposito_abril2016=$rowresult2016['aporte_abril'];
$retirable_abril2016=$rowresult2016['retiros_abril'];
$deposito_mayo2016=$rowresult2016['aporte_mayo'];
$retirable_mayo2016=$rowresult2016['retiros_mayo'];
$deposito_junio2016=$rowresult2016['aporte_junio'];
$retirable_junio2016=$rowresult2016['retiros_junio'];
$deposito_julio2016=$rowresult2016['aporte_julio'];
$retirable_julio2016=$rowresult2016['retiros_julio'];
$deposito_agosto2016=$rowresult2016['aporte_agosto'];
$retirable_agosto2016=$rowresult2016['retiros_agosto'];
$deposito_septiembre2016=$rowresult2016['aporte_septiembre'];
$retirable_septiembre2016=$rowresult2016['retiros_septiembre'];
$deposito_octubre2016=$rowresult2016['aporte_octubre'];
$retirable_octubre2016=$rowresult2016['retiros_octubre'];
$deposito_noviembre2016=$rowresult2016['aporte_noviembre'];
$retirable_noviembre2016=$rowresult2016['retiros_noviembre'];
$deposito_diciembre2016=$rowresult2016['aporte_diciembre'];
$retirable_diciembre2016=$rowresult2016['retiros_diciembre'];
$retirables2015=sprintf("SELECT * FROM retirable_2015 WHERE cedula LIKE '$sitio'");
$resultable2015=mysqli_query($sgstec,$retirables2015);
$rowresult2015 = mysqli_fetch_assoc($resultable2015);
$deposito_enero2015=$rowresult2015['aporte_enero'];
$retirable_enero2015=$rowresult2015['retiros_enero'];
$deposito_febrero2015=$rowresult2015['aporte_febrero'];
$retirable_febrero2015=$rowresult2015['retiros_febrero'];
$deposito_marzo2015=$rowresult2015['aporte_marzo'];
$retirable_marzo2015=$rowresult2015['retiros_marzo'];
$deposito_abril2015=$rowresult2015['aporte_abril'];
$retirable_abril2015=$rowresult2015['retiros_abril'];
$deposito_mayo2015=$rowresult2015['aporte_mayo'];
$retirable_mayo2015=$rowresult2015['retiros_mayo'];
$deposito_junio2015=$rowresult2015['aporte_junio'];
$retirable_junio2015=$rowresult2015['retiros_junio'];
$deposito_julio2015=$rowresult2015['aporte_julio'];
$retirable_julio2015=$rowresult2015['retiros_julio'];
$deposito_agosto2015=$rowresult2015['aporte_agosto'];
$retirable_agosto2015=$rowresult2015['retiros_agosto'];
$deposito_septiembre2015=$rowresult2015['aporte_septiembre'];
$retirable_septiembre2015=$rowresult2015['retiros_septiembre'];
$deposito_octubre2015=$rowresult2015['aporte_octubre'];
$retirable_octubre2015=$rowresult2015['retiros_octubre'];
$deposito_noviembre2015=$rowresult2015['aporte_noviembre'];
$retirable_noviembre2015=$rowresult2015['retiros_noviembre'];
$deposito_diciembre2015=$rowresult2015['aporte_diciembre'];
$retirable_diciembre2015=$rowresult2015['retiros_diciembre'];

$query2021=sprintf("SELECT * FROM ahorros_2021 WHERE cedula LIKE '$sitio'");
$resultado2021=mysqli_query($sgstec,$query2021);
$row2021 = mysqli_fetch_assoc($resultado2021);
$aporte_enero2021=$row2021['aporte_enero'];
@$retiros_enero2021=$row2021['retiros_enero'];
$aporte_febrero2021=$row2021['aporte_febrero'];
@$retiros_febrero2021=$row2021['retiros_febrero'];
$aporte_marzo2021=$row2021['aporte_marzo'];
@$retiros_marzo2021=$row2021['retiros_marzo'];
$aporte_abril2021=$row2021['aporte_abril'];
@$retiros_abril2021=$row2021['retiros_abril'];
$aporte_mayo2021=$row2021['aporte_mayo'];
@$retiros_mayo2021=$row2021['retiros_mayo'];
$aporte_junio2021=$row2021['aporte_junio'];
@$retiros_junio2021=$row2021['retiros_junio'];
$aporte_julio2021=$row2021['aporte_julio'];
@$retiros_julio2021=$row2021['retiros_julio'];
$aporte_agosto2021=$row2021['aporte_agosto'];
@$retiros_agosto2021=$row2021['retiros_agosto'];
$aporte_septiembre2021=$row2021['aporte_septiembre'];
@$retiros_septiembre2021=$row2021['retiros_septiembre'];
$aporte_octubre2021=$row2021['aporte_octubre'];
@$retiros_octubre2021=$row2021['retiros_octubre'];
$aporte_noviembre2021=$row2021['aporte_noviembre'];
@$retiros_noviembre2021=$row2021['retiros_noviembre'];
$aporte_diciembre2021=$row2021['aporte_diciembre'];
@$retiros_diciembre2021=$row2021['retiros_diciembre'];

$query2020=sprintf("SELECT * FROM ahorros_2020 WHERE cedula LIKE '$sitio'");
$resultado2020=mysqli_query($sgstec,$query2020);
$row2020 = mysqli_fetch_assoc($resultado2020);
$aporte_enero2020=$row2020['aporte_enero'];
@$retiros_enero2020=$row2020['retiros_enero'];
$aporte_febrero2020=$row2020['aporte_febrero'];
@$retiros_febrero2020=$row2020['retiros_febrero'];
$aporte_marzo2020=$row2020['aporte_marzo'];
@$retiros_marzo2020=$row2020['retiros_marzo'];
$aporte_abril2020=$row2020['aporte_abril'];
@$retiros_abril2020=$row2020['retiros_abril'];
$aporte_mayo2020=$row2020['aporte_mayo'];
@$retiros_mayo2020=$row2020['retiros_mayo'];
$aporte_junio2020=$row2020['aporte_junio'];
@$retiros_junio2020=$row2020['retiros_junio'];
$aporte_julio2020=$row2020['aporte_julio'];
@$retiros_julio2020=$row2020['retiros_julio'];
$aporte_agosto2020=$row2020['aporte_agosto'];
@$retiros_agosto2020=$row2020['retiros_agosto'];
$aporte_septiembre2020=$row2020['aporte_septiembre'];
@$retiros_septiembre2020=$row2020['retiros_septiembre'];
$aporte_octubre2020=$row2020['aporte_octubre'];
@$retiros_octubre2020=$row2020['retiros_octubre'];
$aporte_noviembre2020=$row2020['aporte_noviembre'];
@$retiros_noviembre2020=$row2020['retiros_noviembre'];
$aporte_diciembre2020=$row2020['aporte_diciembre'];
@$retiros_diciembre2020=$row2020['retiros_diciembre'];

$query2019=sprintf("SELECT * FROM ahorros_2019 WHERE cedula LIKE '$sitio'");
$resultado2019=mysqli_query($sgstec,$query2019);
$row2019 = mysqli_fetch_assoc($resultado2019);
$aporte_enero2019=$row2019['aporte_enero'];
@$retiros_enero2019=$row2019['retiros_enero'];
$aporte_febrero2019=$row2019['aporte_febrero'];
@$retiros_febrero2019=$row2019['retiros_febrero'];
$aporte_marzo2019=$row2019['aporte_marzo'];
@$retiros_marzo2019=$row2019['retiros_marzo'];
$aporte_abril2019=$row2019['aporte_abril'];
@$retiros_abril2019=$row2019['retiros_abril'];
$aporte_mayo2019=$row2019['aporte_mayo'];
@$retiros_mayo2019=$row2019['retiros_mayo'];
$aporte_junio2019=$row2019['aporte_junio'];
@$retiros_junio2019=$row2019['retiros_junio'];
$aporte_julio2019=$row2019['aporte_julio'];
@$retiros_julio2019=$row2019['retiros_julio'];
$aporte_agosto2019=$row2019['aporte_agosto'];
@$retiros_agosto2019=$row2019['retiros_agosto'];
$aporte_septiembre2019=$row2019['aporte_septiembre'];
@$retiros_septiembre2019=$row2019['retiros_septiembre'];
$aporte_octubre2019=$row2019['aporte_octubre'];
@$retiros_octubre2019=$row2019['retiros_octubre'];
$aporte_noviembre2019=$row2019['aporte_noviembre'];
@$retiros_noviembre2019=$row2019['retiros_noviembre'];
$aporte_diciembre2019=$row2019['aporte_diciembre'];
@$retiros_diciembre2019=$row2019['retiros_diciembre'];

$query2018=sprintf("SELECT * FROM ahorros_2018 WHERE cedula LIKE '$sitio'");
$resultado2018=mysqli_query($sgstec,$query2018);
$row2018 = mysqli_fetch_assoc($resultado2018);
$aporte_enero2018=$row2018['aporte_enero'];
@$retiros_enero2018=$row2018['retiros_enero'];
$aporte_febrero2018=$row2018['aporte_febrero'];
@$retiros_febrero2018=$row2018['retiros_febrero'];
$aporte_marzo2018=$row2018['aporte_marzo'];
@$retiros_marzo2018=$row2018['retiros_marzo'];
$aporte_abril2018=$row2018['aporte_abril'];
@$retiros_abril2018=$row2018['retiros_abril'];
$aporte_mayo2018=$row2018['aporte_mayo'];
@$retiros_mayo2018=$row2018['retiros_mayo'];
$aporte_junio2018=$row2018['aporte_junio'];
@$retiros_junio2018=$row2018['retiros_junio'];
$aporte_julio2018=$row2018['aporte_julio'];
@$retiros_julio2018=$row2018['retiros_julio'];
$aporte_agosto2018=$row2018['aporte_agosto'];
@$retiros_agosto2018=$row2018['retiros_agosto'];
$aporte_septiembre2018=$row2018['aporte_septiembre'];
@$retiros_septiembre2018=$row2018['retiros_septiembre'];
$aporte_octubre2018=$row2018['aporte_octubre'];
@$retiros_octubre2018=$row2018['retiros_octubre'];
$aporte_noviembre2018=$row2018['aporte_noviembre'];
@$retiros_noviembre2018=$row2018['retiros_noviembre'];
$aporte_diciembre2018=$row2018['aporte_diciembre'];
@$retiros_diciembre2018=$row2018['retiros_diciembre'];
$query2017=sprintf("SELECT * FROM ahorros_2017 WHERE cedula LIKE '$sitio'");
$resultado2017=mysqli_query($sgstec,$query2017);
$row2017 = mysqli_fetch_assoc($resultado2017);
$aporte_enero2017=$row2017['aporte_enero'];
@$retiros_enero2017=$row2017['retiros_enero'];
$aporte_febrero2017=$row2017['aporte_febrero'];
@$retiros_febrero2017=$row2017['retiros_febrero'];
$aporte_marzo2017=$row2017['aporte_marzo'];
@$retiros_marzo2017=$row2017['retiros_marzo'];
$aporte_abril2017=$row2017['aporte_abril'];
@$retiros_abril2017=$row2017['retiros_abril'];
$aporte_mayo2017=$row2017['aporte_mayo'];
@$retiros_mayo2017=$row2017['retiros_mayo'];
$aporte_junio2017=$row2017['aporte_junio'];
@$retiros_junio2017=$row2017['retiros_junio'];
$aporte_julio2017=$row2017['aporte_julio'];
@$retiros_julio2017=$row2017['retiros_julio'];
$aporte_agosto2017=$row2017['aporte_agosto'];
@$retiros_agosto2017=$row2017['retiros_agosto'];
$aporte_septiembre2017=$row2017['aporte_septiembre'];
@$retiros_septiembre2017=$row2017['retiros_septiembre'];
$aporte_octubre2017=$row2017['aporte_octubre'];
@$retiros_octubre2017=$row2017['retiros_octubre'];
$aporte_noviembre2017=$row2017['aporte_noviembre'];
@$retiros_noviembre2017=$row2017['retiros_noviembre'];
$aporte_diciembre2017=$row2017['aporte_diciembre'];
@$retiros_diciembre2017=$row2017['retiros_diciembre'];
$query2016=sprintf("SELECT * FROM ahorros_2016 WHERE cedula LIKE '$sitio'");
$resultado2016=mysqli_query($sgstec,$query2016);
$row2016 = mysqli_fetch_assoc($resultado2016);
$aporte_enero2016=$row2016['aporte_enero'];
@$retiros_enero2016=$row2016['retiros_enero'];
$aporte_febrero2016=$row2016['aporte_febrero'];
@$retiros_febrero2016=$row2016['retiros_febrero'];
$aporte_marzo2016=$row2016['aporte_marzo'];
@$retiros_marzo2016=$row2016['retiros_marzo'];
$aporte_abril2016=$row2016['aporte_abril'];
@$retiros_abril2016=$row2016['retiros_abril'];
$aporte_mayo2016=$row2016['aporte_mayo'];
@$retiros_mayo2016=$row2016['retiros_mayo'];
$aporte_junio2016=$row2016['aporte_junio'];
@$retiros_junio2016=$row2016['retiros_junio'];
$aporte_julio2016=$row2016['aporte_julio'];
@$retiros_julio2016=$row2016['retiros_julio'];
$aporte_agosto2016=$row2016['aporte_agosto'];
@$retiros_agosto2016=$row2016['retiros_agosto'];
$aporte_septiembre2016=$row2016['aporte_septiembre'];
@$retiros_septiembre2016=$row2016['retiros_septiembre'];
$aporte_octubre2016=$row2016['aporte_octubre'];
@$retiros_octubre2016=$row2016['retiros_octubre'];
$aporte_noviembre2016=$row2016['aporte_noviembre'];
@$retiros_noviembre2016=$row2016['retiros_noviembre'];
$aporte_diciembre2016=$row2016['aporte_diciembre'];
@$retiros_diciembre2016=$row2016['retiros_diciembre'];
$query2015=sprintf("SELECT * FROM ahorros_2015 WHERE cedula LIKE '$sitio'");
$resultado2015=mysqli_query($sgstec,$query2015);
$row2015 = mysqli_fetch_assoc($resultado2015);
$aporte_enero2015=$row2015['aporte_enero'];
@$retiros_enero2015=$row2015['retiros_enero'];
$aporte_febrero2015=$row2015['aporte_febrero'];
@$retiros_febrero2015=$row2015['retiros_febrero'];
$aporte_marzo2015=$row2015['aporte_marzo'];
@$retiros_marzo2015=$row2015['retiros_marzo'];
$aporte_abril2015=$row2015['aporte_abril'];
@$retiros_abril2015=$row2015['retiros_abril'];
$aporte_mayo2015=$row2015['aporte_mayo'];
@$retiros_mayo2015=$row2015['retiros_mayo'];
$aporte_junio2015=$row2015['aporte_junio'];
@$retiros_junio2015=$row2015['retiros_junio'];
$aporte_julio2015=$row2015['aporte_julio'];
@$retiros_julio2015=$row2015['retiros_julio'];
$aporte_agosto2015=$row2015['aporte_agosto'];
@$retiros_agosto2015=$row2015['retiros_agosto'];
$aporte_septiembre2015=$row2015['aporte_septiembre'];
@$retiros_septiembre2015=$row2015['retiros_septiembre'];
$aporte_octubre2015=$row2015['aporte_octubre'];
@$retiros_octubre2015=$row2015['retiros_octubre'];
$aporte_noviembre2015=$row2015['aporte_noviembre'];
@$retiros_noviembre2015=$row2015['retiros_noviembre'];
$aporte_diciembre2015=$row2015['aporte_diciembre'];
$query2014=sprintf("SELECT * FROM ahorros_2014 WHERE cedula LIKE '$sitio'");
$resultado2014=mysqli_query($sgstec,$query2014);
$row2014 = mysqli_fetch_assoc($resultado2014);
$aporte_enero2014=$row2014['aporte_enero'];
@$retiros_enero2014=$row2014['retiros_enero'];
$aporte_febrero2014=$row2014['aporte_febrero'];
@$retiros_febrero2014=$row2014['retiros_febrero'];
$aporte_marzo2014=$row2014['aporte_marzo'];
@$retiros_marzo2014=$row2014['retiros_marzo'];
$aporte_abril2014=$row2014['aporte_abril'];
@$retiros_abril2014=$row2014['retiros_abril'];
$aporte_mayo2014=$row2014['aporte_mayo'];
@$retiros_mayo2014=$row2014['retiros_mayo'];
$aporte_junio2014=$row2014['aporte_junio'];
@$retiros_junio2014=$row2014['retiros_junio'];
$aporte_julio2014=$row2014['aporte_julio'];
@$retiros_julio2014=$row2014['retiros_julio'];
$aporte_agosto2014=$row2014['aporte_agosto'];
@$retiros_agosto2014=$row2014['retiros_agosto'];
$aporte_septiembre2014=$row2014['aporte_septiembre'];
@$retiros_septiembre2014=$row2014['retiros_septiembre'];
$aporte_octubre2014=$row2014['aporte_octubre'];
@$retiros_octubre2014=$row2014['retiros_octubre'];
$aporte_noviembre2014=$row2014['aporte_noviembre'];
@$retiros_noviembre2014=$row2014['retiros_noviembre'];
$aporte_diciembre2014=$row2014['aporte_diciembre'];
@$retiros_diciembre2014=$row2014['retiros_diciembre'];
$query2013=sprintf("SELECT * FROM ahorros_2013 WHERE cedula LIKE '$sitio'");
$resultado2013=mysqli_query($sgstec,$query2013);
$row2013 = mysqli_fetch_assoc($resultado2013);
$aporte_enero2013=$row2013['aporte_enero'];
@$retiros_enero2013=$row2013['retiros_enero'];
$aporte_febrero2013=$row2013['aporte_febrero'];
@$retiros_febrero2013=$row2013['retiros_febrero'];
$aporte_marzo2013=$row2013['aporte_marzo'];
@$retiros_marzo2013=$row2013['retiros_marzo'];
$aporte_abril2013=$row2013['aporte_abril'];
@$retiros_abril2013=$row2013['retiros_abril'];
$aporte_mayo2013=$row2013['aporte_mayo'];
@$retiros_mayo2013=$row2013['retiros_mayo'];
$aporte_junio2013=$row2013['aporte_junio'];
@$retiros_junio2013=$row2013['retiros_junio'];
$aporte_julio2013=$row2013['aporte_julio'];
@$retiros_julio2013=$row2013['retiros_julio'];
$aporte_agosto2013=$row2013['aporte_agosto'];
@$retiros_agosto2013=$row2013['retiros_agosto'];
$aporte_septiembre2013=$row2013['aporte_septiembre'];
@$retiros_septiembre2013=$row2013['retiros_septiembre'];
$aporte_octubre2013=$row2013['aporte_octubre'];
@$retiros_octubre2013=$row2013['retiros_octubre'];
$aporte_noviembre2013=$row2013['aporte_noviembre'];
@$retiros_noviembre2013=$row2013['retiros_noviembre'];
$aporte_diciembre2013=$row2013['aporte_diciembre'];
@$retiros_diciembre2013=$row2013['retiros_diciembre'];
$query2012=sprintf("SELECT * FROM ahorros_2012 WHERE cedula LIKE '$sitio'");
$resultado2012=mysqli_query($sgstec,$query2012);
$row2012 = mysqli_fetch_assoc($resultado2012);
$aporte_enero2012=$row2012['aporte_enero'];
@$retiros_enero2012=$row2012['retiros_enero'];
$aporte_febrero2012=$row2012['aporte_febrero'];
@$retiros_febrero2012=$row2012['retiros_febrero'];
$aporte_marzo2012=$row2012['aporte_marzo'];
@$retiros_marzo2012=$row2012['retiros_marzo'];
$aporte_abril2012=$row2012['aporte_abril'];
@$retiros_abril2012=$row2012['retiros_abril'];
$aporte_mayo2012=$row2012['aporte_mayo'];
@$retiros_mayo2012=$row2012['retiros_mayo'];
$aporte_junio2012=$row2012['aporte_junio'];
@$retiros_junio2012=$row2012['retiros_junio'];
$aporte_julio2012=$row2012['aporte_julio'];
@$retiros_julio2012=$row2012['retiros_julio'];
$aporte_agosto2012=$row2012['aporte_agosto'];
@$retiros_agosto2012=$row2012['retiros_agosto'];
$aporte_septiembre2012=$row2012['aporte_septiembre'];
@$retiros_septiembre2012=$row2012['retiros_septiembre'];
$aporte_octubre2012=$row2012['aporte_octubre'];
@$retiros_octubre2012=$row2012['retiros_octubre'];
$aporte_noviembre2012=$row2012['aporte_noviembre'];
@$retiros_noviembre2012=$row2012['retiros_noviembre'];
$aporte_diciembre2012=$row2012['aporte_diciembre'];
@$retiros_diciembre2012=$row2012['retiros_diciembre'];
$query2011=sprintf("SELECT * FROM ahorros_2011 WHERE cedula LIKE '$sitio'");
$resultado2011=mysqli_query($sgstec,$query2011);
$row2011 = mysqli_fetch_assoc($resultado2011);
$aporte_enero2011=$row2011['aporte_enero'];
@$retiros_enero2011=$row2011['retiros_enero'];
$aporte_febrero2011=$row2011['aporte_febrero'];
@$retiros_febrero2011=$row2011['retiros_febrero'];
$aporte_marzo2011=$row2011['aporte_marzo'];
@$retiros_marzo2011=$row2011['retiros_marzo'];
$aporte_abril2011=$row2011['aporte_abril'];
@$retiros_abril2011=$row2011['retiros_abril'];
$aporte_mayo2011=$row2011['aporte_mayo'];
@$retiros_mayo2011=$row2011['retiros_mayo'];
$aporte_junio2011=$row2011['aporte_junio'];
@$retiros_junio2011=$row2011['retiros_junio'];
$aporte_julio2011=$row2011['aporte_julio'];
@$retiros_julio2011=$row2011['retiros_julio'];
$aporte_agosto2011=$row2011['aporte_agosto'];
@$retiros_agosto2011=$row2011['retiros_agosto'];
$aporte_septiembre2011=$row2011['aporte_septiembre'];
@$retiros_septiembre2011=$row2011['retiros_septiembre'];
$aporte_octubre2011=$row2011['aporte_octubre'];
@$retiros_octubre2011=$row2011['retiros_octubre'];
$aporte_noviembre2011=$row2011['aporte_noviembre'];
@$retiros_noviembre2011=$row2011['retiros_noviembre'];
$aporte_diciembre2011=$row2011['aporte_diciembre'];
@$retiros_diciembre2011=$row2011['retiros_diciembre'];

$ahorro2011=$aporte_enero2011+$aporte_febrero2011+$aporte_marzo2011+$aporte_abril2011+$aporte_mayo2011+$aporte_junio2011+$aporte_julio2011+$aporte_agosto2011+$aporte_septiembre2011+$aporte_octubre2011+$aporte_noviembre2011+$aporte_diciembre2011;
@$retiros2011=@$retiros_enero2011+@$retiros_febrero2011+@$retiros_marzo2011+@$retiros_abril2011+@$retiros_mayo2011+@$retiros_junio2011+@$retiros_julio2011+@$retiros_agosto2011+@$retiros_septiembre2011+@$retiros_octubre2011+@$retiros_noviembre2011+@$retiros_diciembre2011;
$total2011=$ahorro2011-@$retiros2011;

$ahorro2012=$aporte_enero2012+$aporte_febrero2012+$aporte_marzo2012+$aporte_abril2012+$aporte_mayo2012+$aporte_junio2012+$aporte_julio2012+$aporte_agosto2012+$aporte_septiembre2012+$aporte_octubre2012+$aporte_noviembre2012+$aporte_diciembre2012;
@$retiros2012=@$retiros_enero2012+@$retiros_febrero2012+@$retiros_marzo2012+@$retiros_abril2012+@$retiros_mayo2012+@$retiros_junio2012+@$retiros_julio2012+@$retiros_agosto2012+@$retiros_septiembre2012+@$retiros_octubre2012+@$retiros_noviembre2012+@$retiros_diciembre2012;
$total2012=$ahorro2012-@$retiros2012;

$ahorro2013=$aporte_enero2013+$aporte_febrero2013+$aporte_marzo2013+$aporte_abril2013+$aporte_mayo2013+$aporte_junio2013+$aporte_julio2013+$aporte_agosto2013+$aporte_septiembre2013+$aporte_octubre2013+$aporte_noviembre2013+$aporte_diciembre2013;
$total2013=$ahorro2013;

$ahorro2014=$aporte_enero2014+$aporte_febrero2014+$aporte_marzo2014+$aporte_abril2014+$aporte_mayo2014+$aporte_junio2014+$aporte_julio2014+$aporte_agosto2014+$aporte_septiembre2014+$aporte_octubre2014+$aporte_noviembre2014+$aporte_diciembre2014;
$total2014=$ahorro2014;

$ahorro2015=$aporte_enero2015+$aporte_febrero2015+$aporte_marzo2015+$aporte_abril2015+$aporte_mayo2015+$aporte_junio2015+$aporte_julio2015+$aporte_agosto2015+$aporte_septiembre2015+$aporte_octubre2015+$aporte_noviembre2015+$aporte_diciembre2015;
$total2015=$ahorro2015;

$ahorro2016=$aporte_enero2016+$aporte_febrero2016+$aporte_marzo2016+$aporte_abril2016+$aporte_mayo2016+$aporte_junio2016+$aporte_julio2016+$aporte_agosto2016+$aporte_septiembre2016+$aporte_octubre2016+$aporte_noviembre2016+$aporte_diciembre2016;
$total2016=$ahorro2016;

$ahorro2017=$aporte_enero2017+$aporte_febrero2017+$aporte_marzo2017+$aporte_abril2017+$aporte_mayo2017+$aporte_junio2017+$aporte_julio2017+$aporte_agosto2017+$aporte_septiembre2017+$aporte_octubre2017+$aporte_noviembre2017+$aporte_diciembre2017;
$total2017=$ahorro2017;

$ahorro2018=$aporte_enero2018+$aporte_febrero2018+$aporte_marzo2018+$aporte_abril2018+$aporte_mayo2018+$aporte_junio2018+$aporte_julio2018+$aporte_agosto2018+$aporte_septiembre2018+$aporte_octubre2018+$aporte_noviembre2018+$aporte_diciembre2018;
$total2018=$ahorro2018;

$ahorro2019=$aporte_enero2019+$aporte_febrero2019+$aporte_marzo2019+$aporte_abril2019+$aporte_mayo2019+$aporte_junio2019+$aporte_julio2019+$aporte_agosto2019+$aporte_septiembre2019+$aporte_octubre2019+$aporte_noviembre2019+$aporte_diciembre2019;
$total2019=$ahorro2019;

$ahorro2020=$aporte_enero2020+$aporte_febrero2020+$aporte_marzo2020+$aporte_abril2020+$aporte_mayo2020+$aporte_junio2020+$aporte_julio2020+$aporte_agosto2020+$aporte_septiembre2020+$aporte_octubre2020+$aporte_noviembre2020+$aporte_diciembre2020;
$total2020=$ahorro2020;

$ahorro2021=$aporte_enero2021+$aporte_febrero2021+$aporte_marzo2021+$aporte_abril2021+$aporte_mayo2021+$aporte_junio2021+$aporte_julio2021+$aporte_agosto2021+$aporte_septiembre2021+$aporte_octubre2021+$aporte_noviembre2021+$aporte_diciembre2021;
$total2021=$ahorro2021;

$total_general=$ahorro2021+$ahorro2020+$ahorro2019+$ahorro2018+$ahorro2017+$ahorro2016+$ahorro2015+$ahorro2014+$ahorro2013+$ahorro2012+$ahorro2011-@$retiros2012-@$retiros2011;
$ahorro_retirable2015=$deposito_enero2015+$deposito_febrero2015+$deposito_marzo2015+$deposito_abril2015+$deposito_mayo2015+$deposito_junio2015+$deposito_julio2015+$deposito_agosto2015+$deposito_septiembre2015+$deposito_octubre2015+$deposito_noviembre2015+$deposito_diciembre2015-$retirable_enero2015-$retirable_febrero2015-$retirable_marzo2015-$retirable_abril2015-$retirable_mayo2015-$retirable_junio2015-$retirable_julio2015-$retirable_agosto2015-$retirable_septiembre2015-$retirable_octubre2015-$retirable_noviembre2015-$retirable_diciembre2015;
$totalretirable2015=$ahorro_retirable2015;

$ahorro_retirable2016=$deposito_enero2016+$deposito_febrero2016+$deposito_marzo2016+$deposito_abril2016+$deposito_mayo2016+$deposito_junio2016+$deposito_julio2016+$deposito_agosto2016+$deposito_septiembre2016+$deposito_octubre2016+$deposito_noviembre2016+$deposito_diciembre2016-$retirable_enero2016-$retirable_febrero2016-$retirable_marzo2016-$retirable_abril2016-$retirable_mayo2016-$retirable_junio2016-$retirable_julio2016-$retirable_agosto2016-$retirable_septiembre2016-$retirable_octubre2016-$retirable_noviembre2016-$retirable_diciembre2016;
$totalretirable2016=$ahorro_retirable2016;

$ahorro_retirable2017=$deposito_enero2017+$deposito_febrero2017+$deposito_marzo2017+$deposito_abril2017+$deposito_mayo2017+$deposito_junio2017+$deposito_julio2017+$deposito_agosto2017+$deposito_septiembre2017+$deposito_octubre2017+$deposito_noviembre2017+$deposito_diciembre2017-$retirable_enero2017-$retirable_febrero2017-$retirable_marzo2017-$retirable_abril2017-$retirable_mayo2017-$retirable_junio2017-$retirable_julio2017-$retirable_agosto2017-$retirable_septiembre2017-$retirable_octubre2017-$retirable_noviembre2017-$retirable_diciembre2017;
$totalretirable2017=$ahorro_retirable2017;

$ahorro_retirable2018=$deposito_enero2018+$deposito_febrero2018+$deposito_marzo2018+$deposito_abril2018+$deposito_mayo2018+$deposito_junio2018+$deposito_julio2018+$deposito_agosto2018+$deposito_septiembre2018+$deposito_octubre2018+$deposito_noviembre2018+$deposito_diciembre2018-$retirable_enero2018-$retirable_febrero2018-$retirable_marzo2018-$retirable_abril2018-$retirable_mayo2018-$retirable_junio2018-$retirable_julio2018-$retirable_agosto2018-$retirable_septiembre2018-$retirable_octubre2018-$retirable_noviembre2018-$retirable_diciembre2018;
$totalretirable2018=$ahorro_retirable2018;

$ahorro_retirable2019=$deposito_enero2019+$deposito_febrero2019+$deposito_marzo2019+$deposito_abril2019+$deposito_mayo2019+$deposito_junio2019+$deposito_julio2019+$deposito_agosto2019+$deposito_septiembre2019+$deposito_octubre2019+$deposito_noviembre2019+$deposito_diciembre2019-$retirable_enero2019-$retirable_febrero2019-$retirable_marzo2019-$retirable_abril2019-$retirable_mayo2019-$retirable_junio2019-$retirable_julio2019-$retirable_agosto2019-$retirable_septiembre2019-$retirable_octubre2019-$retirable_noviembre2019-$retirable_diciembre2019;
$totalretirable2019=$ahorro_retirable2019;

$ahorro_retirable2020=$deposito_enero2020+$deposito_febrero2020+$deposito_marzo2020+$deposito_abril2020+$deposito_mayo2020+$deposito_junio2020+$deposito_julio2020+$deposito_agosto2020+$deposito_septiembre2020+$deposito_octubre2020+$deposito_noviembre2020+$deposito_diciembre2020-$retirable_enero2020-$retirable_febrero2020-$retirable_marzo2020-$retirable_abril2020-$retirable_mayo2020-$retirable_junio2020-$retirable_julio2020-$retirable_agosto2020-$retirable_septiembre2020-$retirable_octubre2020-$retirable_noviembre2020-$retirable_diciembre2020;
$totalretirable2020=$ahorro_retirable2020;

$ahorro_retirable2021=$deposito_enero2021+$deposito_febrero2021+$deposito_marzo2021+$deposito_abril2021+$deposito_mayo2021+$deposito_junio2021+$deposito_julio2021+$deposito_agosto2021+$deposito_septiembre2021+$deposito_octubre2021+$deposito_noviembre2021+$deposito_diciembre2021-$retirable_enero2021-$retirable_febrero2021-$retirable_marzo2021-$retirable_abril2021-$retirable_mayo2021-$retirable_junio2021-$retirable_julio2021-$retirable_agosto2021-$retirable_septiembre2021-$retirable_octubre2021-$retirable_noviembre2021-$retirable_diciembre2021;
$totalretirable2021=$ahorro_retirable2021;


$total_retirable=$ahorro_retirable2021+$ahorro_retirable2020+$ahorro_retirable2019+$ahorro_retirable2018+$ahorro_retirable2017+$ahorro_retirable2016+$ahorro_retirable2015;
echo "<div><h1>".$nombre." ".$apellido."</h1></div>";
echo "<h6 style='margin:0;'><a href='modnombre.php?sitio=$sitio'>Modificar nombre</a></h6>";
echo "<div>".$sitio."</div><br>";

/* Calculo de los prestamos*/
$queryedu=sprintf("SELECT * FROM prestamos_educativos WHERE cedula LIKE '$sitio'");
$resultadoedu=mysqli_query($sgstec,$queryedu);
$rowedu = mysqli_fetch_assoc($resultadoedu);
$deudaedu=$rowedu['monto'];
$interesedu=$rowedu['interes'];
$anosedu=$rowedu['plazo'];
if($deudaedu && $anosedu && $interesedu)
{	
$interesedu=($interesedu/100)/12;
$medu=($deudaedu*$interesedu*(pow((1+$interesedu),($anosedu))))/((pow((1+$interesedu),($anosedu)))-1); 
}
$querymadres=sprintf("SELECT * FROM prestamo_especial_madres WHERE cedula LIKE '$sitio'");
$resultadomadres=mysqli_query($sgstec,$querymadres);
$rowmadres = mysqli_fetch_assoc($resultadomadres);
$deudamadres=$rowmadres['monto'];
$interesmadres=$rowmadres['interes'];
$anosmadres=$rowmadres['plazo'];
if($deudamadres && $anosmadres && $interesmadres)
{	
$interesmadres=($interesmadres/100)/12;
$mmadres=($deudamadres*$interesmadres*(pow((1+$interesmadres),($anosmadres))))/((pow((1+$interesmadres),($anosmadres)))-1); 
}
$queryesco=sprintf("SELECT * FROM prestamos_escolares WHERE cedula LIKE '$sitio'");
$resultadoesco=mysqli_query($sgstec,$queryesco);
$rowesco = mysqli_fetch_assoc($resultadoesco);
$deudaesco=$rowesco['monto'];
$interesesco=$rowesco['interes'];
$anosesco=$rowesco['plazo'];
if($deudaesco && $anosesco && $interesesco)
{	
$interesesco=($interesesco/100)/12;
$mesco=($deudaesco*$interesesco*(pow((1+$interesesco),($anosesco))))/((pow((1+$interesesco),($anosesco)))-1); 
}
$queryger=sprintf("SELECT * FROM prestamos_gerenciales WHERE cedula LIKE '$sitio'");
$resultadoger=mysqli_query($sgstec,$queryger);
$rowger = mysqli_fetch_assoc($resultadoger);
$deudager=$rowger['monto'];
$interesger=$rowger['interes'];
$anosger=$rowger['plazo'];
if($deudager && $anosger && $interesger)
{	
$interesger=($interesger/100)/12;
$mger=($deudager*$interesger*(pow((1+$interesger),($anosger))))/((pow((1+$interesger),($anosger)))-1); 
}
$queryvac=sprintf("SELECT * FROM prestamos_vacacionales WHERE cedula LIKE '$sitio'");
$resultadovac=mysqli_query($sgstec,$queryvac);
$rowvac = mysqli_fetch_assoc($resultadovac);
$deudavac=$rowvac['monto'];
$interesvac=$rowvac['interes'];
$anosvac=$rowvac['plazo'];
if($deudavac && $anosvac && $interesvac)
{	
$interesvac=($interesvac/100)/12;
$mvac=($deudavac*$interesvac*(pow((1+$interesvac),($anosvac))))/((pow((1+$interesvac),($anosvac)))-1); 
}
$querynor=sprintf("SELECT * FROM prestamos_normales WHERE cedula LIKE '$sitio'");
$resultadonor=mysqli_query($sgstec,$querynor);
$rownor = mysqli_fetch_assoc($resultadonor);
$deudanor=$rownor['monto'];
echo "<h1>$deudanor</h1>";
$interesnor=$rownor['interes'];
$anosnor=$rownor['plazo'];
if($deudanor && $anosnor && $interesnor)
{	
$interesnor=($interesnor/100)/12;
@$mnor=($deudanor*$interesnor*(pow((1+$interesnor),($anosnor))))/((pow((1+$interesnor),($anosnor)))-1); 
}

$sumadeprestamos=$medu+$mmadres+$mesco+$mnor+$mvac+$mger;
$sumamensual=$sumadeprestamos+$sumadeahorros;
/*INICIO DE LOS AHORROS*/
echo "<div style='    width: 40%;
    float: left;
    text-align: left;
    margin-left: 10%;
    '><h2 style='padding:0 5%;margin:0;'>Ahorros</h2>";

/* Cuota Normal*/
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Cuota normal</h4>
<h6 style='margin:0;'><a href='editar_aporte.php?sitio=$sitio'>Modificar cuota normal</a></h6>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".$guia."</span></h4>
</div></div><br>";

/* Cuota retirable*/
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Cuota retirable</h4>
<h6 style='margin:0;'><a href='editar_aporte_retirable.php?sitio=$sitio'>Modificar cuota retirable</a></h6>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".$guia_reti."</span></h4>
</div></div><br>";

/*Ahorro Normal*/
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Ahorro normal</h4>
<h6 style='margin:0;'><a href='modahorros.php?sitio=$sitio'>Modificar ahorro normal</a></h6>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".number_format($total_general,2,".",",")."</span></h4>
</div></div><br>";

/*Ahorro Retirable*/
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Ahorro retirable</h4>
<h6 style='margin:0;'><a href='modretirables.php?sitio=$sitio'>Modificar ahorro retirable</a></h6>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".number_format($total_retirable,2,".",",")."</span></h4>
</div></div><br>";

/*Total descuento en ahorros*/
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Total descuento en ahorros</h4>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".number_format($sumadeahorros,2,".",",")."</span></h4>
</div></div><br>";

/* Cierre del div lateral 1*/
echo "</div>";


/*INICIO DE LOS PRESTAMOS*/


echo "<div style='width:40%;text-align:left;margin-right:5%;    float: left;border-left: 3px solid #009A00;'><h2 style='padding:0 5%;margin:0;'>Préstamos</h2>";
/*Normal*/
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Normal</h4>
<h6 style='margin:0;'><a href='crearprestamo.php?sitio=$sitio&sitio2=prestamos_normales'>Crear</a>   |   <a href='verproductos.php?sitio=$sitio&sitio2=normales'>Ver Tabla</a>   |   <a href='borrarprestamo.php?sitio=$sitio&sitio2=prestamos_normales'>Eliminar</a></h6>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".number_format($mnor,2,".",",")."</span></h4>
<h6 style='margin:0;text-align:right;'>Cuota</h6>
</div></div><br>";

/*Útiles escolares*/
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Útiles escolares</h4>
<h6 style='margin:0;'><a href='crearprestamo.php?sitio=$sitio&sitio2=prestamos_escolares'>Crear</a>   |   <a href='verproductos.php?sitio=$sitio&sitio2=escolares'>Ver Tabla</a>   |   <a href='borrarprestamo.php?sitio=$sitio&sitio2=prestamos_escolares'>Eliminar</a></h6>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".number_format($mesco,2,".",",")."</span></h4>
<h6 style='margin:0;text-align:right;'>Cuota</h6>
</div></div><br>";

/*Educativo*/
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Educativo</h4>
<h6 style='margin:0;'><a href='crearprestamo.php?sitio=$sitio&sitio2=prestamos_educativos'>Crear</a>   |   <a href='verproductos.php?sitio=$sitio&sitio2=educativos'>Ver Tabla</a>   |   <a href='borrarprestamo.php?sitio=$sitio&sitio2=prestamos_educativos'>Eliminar</a></h6>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".number_format($medu,2,".",",")."</span></h4>
<h6 style='margin:0;text-align:right;'>Cuota</h6>
</div></div><br>";

/*Vacacional*/
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Vacacional</h4>
<h6 style='margin:0;'><a href='crearprestamo.php?sitio=$sitio&sitio2=prestamos_vacacionales'>Crear</a>   |   <a href='verproductos.php?sitio=$sitio&sitio2=vacacionales'>Ver Tabla</a>   |   <a href='borrarprestamo.php?sitio=$sitio&sitio2=prestamos_vacacionales'>Eliminar</a></h6>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".number_format($mvac,2,".",",")."</span></h4>
<h6 style='margin:0;text-align:right;'>Cuota</h6>
</div></div><br>";

/*Especial Madres*/
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Especial Madres</h4>
<h6 style='margin:0;'><a href='crearprestamo.php?sitio=$sitio&sitio2=prestamo_especial_madres'>Crear</a>   |   <a href='verproductos.php?sitio=$sitio&sitio2=prestamo_especial_madres'>Ver Tabla</a>   |   <a href='borrarprestamo.php?sitio=$sitio&sitio2=prestamo_especial_madres'>Eliminar</a></h6>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".number_format($mmadres,2,".",",")."</span></h4>
<h6 style='margin:0;text-align:right;'>Cuota</h6>
</div></div><br>";

/*Gerencial*/
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Gerencial</h4>
<h6 style='margin:0;'><a href='crearprestamo.php?sitio=$sitio&sitio2=prestamos_gerenciales'>Crear</a>   |   <a href='verproductos.php?sitio=$sitio&sitio2=gerenciales'>Ver Tabla</a>   |   <a href='borrarprestamo.php?sitio=$sitio&sitio2=prestamos_gerenciales'>Eliminar</a></h6>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".number_format($mger,2,".",",")."</span></h4>
<h6 style='margin:0;text-align:right;'>Cuota</h6>
</div></div><br>";

/*Total descuento en prestamos*/
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Total descuento en prestamos</h4>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".number_format($sumadeprestamos,2,".",",")."</span></h4>
</div></div><br>";

/* Cierre del div lateral 2*/
echo "</div><br><br>";

/* RESULTADO TOTAL*/
echo "<div style='width: 50%;
    border: 3px solid #009A00;
    text-align: center;
    display: inline-block;
    clear: both;
    padding: 25px;'>";
	
	
echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;background-color:#009A00;padding: 5px;'>Total descuento mensual</h4>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<span style='padding:5px;float:left;'><b>RD$</b></span><span style='border:1px solid gray;padding:5px;width:150px;float:left;text-align:right;'>".number_format($sumamensual,2,".",",")."</span></h4>
</div></div><br>";

echo "<div><div style='width:50%;float:left;text-align:left;padding:0 5% ;    clear: both;'>
<h4 style='margin:0;'><a href='verahorros.php?sitio=$sitio'>Ver detalle de ahorros</a></h4>
</div>
<div style='width:50%;float:left;text-align:left;padding:0 5% ;margin-bottom: 20px;'>
<h4 style='margin:0;'><a href='resetearpassword.php?sitio=$sitio'>Resetear contraseña de usuario</a></h4>
</div></div><br>";

echo "</div>";

?>


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