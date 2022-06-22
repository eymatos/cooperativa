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
<?php
$resultado=mysql_query($query_sexo);
$row = mysql_fetch_assoc($resultado);
$cedula= $row['cedula'];
$nombre=$row['nombre'];
$apellido=$row['apellido'];
$fecha=$row['fecha_inscripcion'];
$inscripcion=$row['inscripcion'];
$aporte=$row['aporte_capital'];
#Suma de Ahorro Retirable!

$retirables2021=sprintf("SELECT * FROM retirable_2021 WHERE cedula LIKE '$cedula'");
$resultable2021=mysql_query($retirables2021);
$rowresult2021 = mysql_fetch_assoc($resultable2021);
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

$retirables2020=sprintf("SELECT * FROM retirable_2020 WHERE cedula LIKE '$cedula'");
$resultable2020=mysql_query($retirables2020);
$rowresult2020 = mysql_fetch_assoc($resultable2020);
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
$retirables2019=sprintf("SELECT * FROM retirable_2019 WHERE cedula LIKE '$cedula'");
$resultable2019=mysql_query($retirables2019);
$rowresult2019 = mysql_fetch_assoc($resultable2019);
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
$retirables2018=sprintf("SELECT * FROM retirable_2018 WHERE cedula LIKE '$cedula'");
$resultable2018=mysql_query($retirables2018);
$rowresult2018 = mysql_fetch_assoc($resultable2018);
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
$retirables2017=sprintf("SELECT * FROM retirable_2017 WHERE cedula LIKE '$cedula'");
$resultable2017=mysql_query($retirables2017);
$rowresult2017 = mysql_fetch_assoc($resultable2017);
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
$retirables2016=sprintf("SELECT * FROM retirable_2016 WHERE cedula LIKE '$cedula'");
$resultable2016=mysql_query($retirables2016);
$rowresult2016 = mysql_fetch_assoc($resultable2016);
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
$retirables2015=sprintf("SELECT * FROM retirable_2015 WHERE cedula LIKE '$cedula'");
$resultable2015=mysql_query($retirables2015);
$rowresult2015 = mysql_fetch_assoc($resultable2015);
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

#Suma de Ahorros!

$query2021=sprintf("SELECT * FROM ahorros_2021 WHERE cedula LIKE '$cedula'");
$resultado2021=mysql_query($query2021);
$row2021 = mysql_fetch_assoc($resultado2021);
$aporte_enero2021=$row2021['aporte_enero'];
$aporte_febrero2021=$row2021['aporte_febrero'];
$aporte_marzo2021=$row2021['aporte_marzo'];
$aporte_abril2021=$row2021['aporte_abril'];
$aporte_mayo2021=$row2021['aporte_mayo'];
$aporte_junio2021=$row2021['aporte_junio'];
$aporte_julio2021=$row2021['aporte_julio'];
$aporte_agosto2021=$row2021['aporte_agosto'];
$aporte_septiembre2021=$row2021['aporte_septiembre'];
$aporte_octubre2021=$row2021['aporte_octubre'];
$aporte_noviembre2021=$row2021['aporte_noviembre'];
$aporte_diciembre2021=$row2021['aporte_diciembre'];

$query2020=sprintf("SELECT * FROM ahorros_2020 WHERE cedula LIKE '$cedula'");
$resultado2020=mysql_query($query2020);
$row2020 = mysql_fetch_assoc($resultado2020);
$aporte_enero2020=$row2020['aporte_enero'];
$aporte_febrero2020=$row2020['aporte_febrero'];
$aporte_marzo2020=$row2020['aporte_marzo'];
$aporte_abril2020=$row2020['aporte_abril'];
$aporte_mayo2020=$row2020['aporte_mayo'];
$aporte_junio2020=$row2020['aporte_junio'];
$aporte_julio2020=$row2020['aporte_julio'];
$aporte_agosto2020=$row2020['aporte_agosto'];
$aporte_septiembre2020=$row2020['aporte_septiembre'];
$aporte_octubre2020=$row2020['aporte_octubre'];
$aporte_noviembre2020=$row2020['aporte_noviembre'];
$aporte_diciembre2020=$row2020['aporte_diciembre'];

$query2019=sprintf("SELECT * FROM ahorros_2019 WHERE cedula LIKE '$cedula'");
$resultado2019=mysql_query($query2019);
$row2019 = mysql_fetch_assoc($resultado2019);
$aporte_enero2019=$row2019['aporte_enero'];
$aporte_febrero2019=$row2019['aporte_febrero'];
$aporte_marzo2019=$row2019['aporte_marzo'];
$aporte_abril2019=$row2019['aporte_abril'];
$aporte_mayo2019=$row2019['aporte_mayo'];
$aporte_junio2019=$row2019['aporte_junio'];
$aporte_julio2019=$row2019['aporte_julio'];
$aporte_agosto2019=$row2019['aporte_agosto'];
$aporte_septiembre2019=$row2019['aporte_septiembre'];
$aporte_octubre2019=$row2019['aporte_octubre'];
$aporte_noviembre2019=$row2019['aporte_noviembre'];
$aporte_diciembre2019=$row2019['aporte_diciembre'];
$query2018=sprintf("SELECT * FROM ahorros_2018 WHERE cedula LIKE '$cedula'");
$resultado2018=mysql_query($query2018);
$row2018 = mysql_fetch_assoc($resultado2018);
$aporte_enero2018=$row2018['aporte_enero'];
$aporte_febrero2018=$row2018['aporte_febrero'];
$aporte_marzo2018=$row2018['aporte_marzo'];
$aporte_abril2018=$row2018['aporte_abril'];
$aporte_mayo2018=$row2018['aporte_mayo'];
$aporte_junio2018=$row2018['aporte_junio'];
$aporte_julio2018=$row2018['aporte_julio'];
$aporte_agosto2018=$row2018['aporte_agosto'];
$aporte_septiembre2018=$row2018['aporte_septiembre'];
$aporte_octubre2018=$row2018['aporte_octubre'];
$aporte_noviembre2018=$row2018['aporte_noviembre'];
$aporte_diciembre2018=$row2018['aporte_diciembre'];
$query2017=sprintf("SELECT * FROM ahorros_2017 WHERE cedula LIKE '$cedula'");
$resultado2017=mysql_query($query2017);
$row2017 = mysql_fetch_assoc($resultado2017);
$aporte_enero2017=$row2017['aporte_enero'];
$aporte_febrero2017=$row2017['aporte_febrero'];
$aporte_marzo2017=$row2017['aporte_marzo'];
$aporte_abril2017=$row2017['aporte_abril'];
$aporte_mayo2017=$row2017['aporte_mayo'];
$aporte_junio2017=$row2017['aporte_junio'];
$aporte_julio2017=$row2017['aporte_julio'];
$aporte_agosto2017=$row2017['aporte_agosto'];
$aporte_septiembre2017=$row2017['aporte_septiembre'];
$aporte_octubre2017=$row2017['aporte_octubre'];
$aporte_noviembre2017=$row2017['aporte_noviembre'];
$aporte_diciembre2017=$row2017['aporte_diciembre'];

$query2016=sprintf("SELECT * FROM ahorros_2016 WHERE cedula LIKE '$cedula'");
$resultado2016=mysql_query($query2016);
$row2016 = mysql_fetch_assoc($resultado2016);
$aporte_enero2016=$row2016['aporte_enero'];
$retiros_enero2016=$row2016['retiros_enero'];
$aporte_febrero2016=$row2016['aporte_febrero'];
$retiros_febrero2016=$row2016['retiros_febrero'];
$aporte_marzo2016=$row2016['aporte_marzo'];
$retiros_marzo2016=$row2016['retiros_marzo'];
$aporte_abril2016=$row2016['aporte_abril'];
$retiros_abril2016=$row2016['retiros_abril'];
$aporte_mayo2016=$row2016['aporte_mayo'];
$retiros_mayo2016=$row2016['retiros_mayo'];
$aporte_junio2016=$row2016['aporte_junio'];
$retiros_junio2016=$row2016['retiros_junio'];
$aporte_julio2016=$row2016['aporte_julio'];
$retiros_julio2016=$row2016['retiros_julio'];
$aporte_agosto2016=$row2016['aporte_agosto'];
$retiros_agosto2016=$row2016['retiros_agosto'];
$aporte_septiembre2016=$row2016['aporte_septiembre'];
$retiros_septiembre2016=$row2016['retiros_septiembre'];
$aporte_octubre2016=$row2016['aporte_octubre'];
$retiros_octubre2016=$row2016['retiros_octubre'];
$aporte_noviembre2016=$row2016['aporte_noviembre'];
$retiros_noviembre2016=$row2016['retiros_noviembre'];
$aporte_diciembre2016=$row2016['aporte_diciembre'];
$retiros_diciembre2016=$row2016['retiros_diciembre'];
$query2015=sprintf("SELECT * FROM ahorros_2015 WHERE cedula LIKE '$cedula'");
$resultado2015=mysql_query($query2015);
$row2015 = mysql_fetch_assoc($resultado2015);
$aporte_enero2015=$row2015['aporte_enero'];
$retiros_enero2015=$row2015['retiros_enero'];
$aporte_febrero2015=$row2015['aporte_febrero'];
$retiros_febrero2015=$row2015['retiros_febrero'];
$aporte_marzo2015=$row2015['aporte_marzo'];
$retiros_marzo2015=$row2015['retiros_marzo'];
$aporte_abril2015=$row2015['aporte_abril'];
$retiros_abril2015=$row2015['retiros_abril'];
$aporte_mayo2015=$row2015['aporte_mayo'];
$retiros_mayo2015=$row2015['retiros_mayo'];
$aporte_junio2015=$row2015['aporte_junio'];
$retiros_junio2015=$row2015['retiros_junio'];
$aporte_julio2015=$row2015['aporte_julio'];
$retiros_julio2015=$row2015['retiros_julio'];
$aporte_agosto2015=$row2015['aporte_agosto'];
$retiros_agosto2015=$row2015['retiros_agosto'];
$aporte_septiembre2015=$row2015['aporte_septiembre'];
$retiros_septiembre2015=$row2015['retiros_septiembre'];
$aporte_octubre2015=$row2015['aporte_octubre'];
$retiros_octubre2015=$row2015['retiros_octubre'];
$aporte_noviembre2015=$row2015['aporte_noviembre'];
$retiros_noviembre2015=$row2015['retiros_noviembre'];
$aporte_diciembre2015=$row2015['aporte_diciembre'];
$query2014=sprintf("SELECT * FROM ahorros_2014 WHERE cedula LIKE '$cedula'");
$resultado2014=mysql_query($query2014);
$row2014 = mysql_fetch_assoc($resultado2014);
$aporte_enero2014=$row2014['aporte_enero'];
$retiros_enero2014=$row2014['retiros_enero'];
$aporte_febrero2014=$row2014['aporte_febrero'];
$retiros_febrero2014=$row2014['retiros_febrero'];
$aporte_marzo2014=$row2014['aporte_marzo'];
$retiros_marzo2014=$row2014['retiros_marzo'];
$aporte_abril2014=$row2014['aporte_abril'];
$retiros_abril2014=$row2014['retiros_abril'];
$aporte_mayo2014=$row2014['aporte_mayo'];
$retiros_mayo2014=$row2014['retiros_mayo'];
$aporte_junio2014=$row2014['aporte_junio'];
$retiros_junio2014=$row2014['retiros_junio'];
$aporte_julio2014=$row2014['aporte_julio'];
$retiros_julio2014=$row2014['retiros_julio'];
$aporte_agosto2014=$row2014['aporte_agosto'];
$retiros_agosto2014=$row2014['retiros_agosto'];
$aporte_septiembre2014=$row2014['aporte_septiembre'];
$retiros_septiembre2014=$row2014['retiros_septiembre'];
$aporte_octubre2014=$row2014['aporte_octubre'];
$retiros_octubre2014=$row2014['retiros_octubre'];
$aporte_noviembre2014=$row2014['aporte_noviembre'];
$retiros_noviembre2014=$row2014['retiros_noviembre'];
$aporte_diciembre2014=$row2014['aporte_diciembre'];
$retiros_diciembre2014=$row2014['retiros_diciembre'];
$query2013=sprintf("SELECT * FROM ahorros_2013 WHERE cedula LIKE '$cedula'");
$resultado2013=mysql_query($query2013);
$row2013 = mysql_fetch_assoc($resultado2013);
$aporte_enero2013=$row2013['aporte_enero'];
$retiros_enero2013=$row2013['retiros_enero'];
$aporte_febrero2013=$row2013['aporte_febrero'];
$retiros_febrero2013=$row2013['retiros_febrero'];
$aporte_marzo2013=$row2013['aporte_marzo'];
$retiros_marzo2013=$row2013['retiros_marzo'];
$aporte_abril2013=$row2013['aporte_abril'];
$retiros_abril2013=$row2013['retiros_abril'];
$aporte_mayo2013=$row2013['aporte_mayo'];
$retiros_mayo2013=$row2013['retiros_mayo'];
$aporte_junio2013=$row2013['aporte_junio'];
$retiros_junio2013=$row2013['retiros_junio'];
$aporte_julio2013=$row2013['aporte_julio'];
$retiros_julio2013=$row2013['retiros_julio'];
$aporte_agosto2013=$row2013['aporte_agosto'];
$retiros_agosto2013=$row2013['retiros_agosto'];
$aporte_septiembre2013=$row2013['aporte_septiembre'];
$retiros_septiembre2013=$row2013['retiros_septiembre'];
$aporte_octubre2013=$row2013['aporte_octubre'];
$retiros_octubre2013=$row2013['retiros_octubre'];
$aporte_noviembre2013=$row2013['aporte_noviembre'];
$retiros_noviembre2013=$row2013['retiros_noviembre'];
$aporte_diciembre2013=$row2013['aporte_diciembre'];
$retiros_diciembre2013=$row2013['retiros_diciembre'];
$query2012=sprintf("SELECT * FROM ahorros_2012 WHERE cedula LIKE '$cedula'");
$resultado2012=mysql_query($query2012);
$row2012 = mysql_fetch_assoc($resultado2012);
$aporte_enero2012=$row2012['aporte_enero'];
$retiros_enero2012=$row2012['retiros_enero'];
$aporte_febrero2012=$row2012['aporte_febrero'];
$retiros_febrero2012=$row2012['retiros_febrero'];
$aporte_marzo2012=$row2012['aporte_marzo'];
$retiros_marzo2012=$row2012['retiros_marzo'];
$aporte_abril2012=$row2012['aporte_abril'];
$retiros_abril2012=$row2012['retiros_abril'];
$aporte_mayo2012=$row2012['aporte_mayo'];
$retiros_mayo2012=$row2012['retiros_mayo'];
$aporte_junio2012=$row2012['aporte_junio'];
$retiros_junio2012=$row2012['retiros_junio'];
$aporte_julio2012=$row2012['aporte_julio'];
$retiros_julio2012=$row2012['retiros_julio'];
$aporte_agosto2012=$row2012['aporte_agosto'];
$retiros_agosto2012=$row2012['retiros_agosto'];
$aporte_septiembre2012=$row2012['aporte_septiembre'];
$retiros_septiembre2012=$row2012['retiros_septiembre'];
$aporte_octubre2012=$row2012['aporte_octubre'];
$retiros_octubre2012=$row2012['retiros_octubre'];
$aporte_noviembre2012=$row2012['aporte_noviembre'];
$retiros_noviembre2012=$row2012['retiros_noviembre'];
$aporte_diciembre2012=$row2012['aporte_diciembre'];
$retiros_diciembre2012=$row2012['retiros_diciembre'];
$query2011=sprintf("SELECT * FROM ahorros_2011 WHERE cedula LIKE '$cedula'");
$resultado2011=mysql_query($query2011);
$row2011 = mysql_fetch_assoc($resultado2011);
$aporte_enero2011=$row2011['aporte_enero'];
$retiros_enero2011=$row2011['retiros_enero'];
$aporte_febrero2011=$row2011['aporte_febrero'];
$retiros_febrero2011=$row2011['retiros_febrero'];
$aporte_marzo2011=$row2011['aporte_marzo'];
$retiros_marzo2011=$row2011['retiros_marzo'];
$aporte_abril2011=$row2011['aporte_abril'];
$retiros_abril2011=$row2011['retiros_abril'];
$aporte_mayo2011=$row2011['aporte_mayo'];
$retiros_mayo2011=$row2011['retiros_mayo'];
$aporte_junio2011=$row2011['aporte_junio'];
$retiros_junio2011=$row2011['retiros_junio'];
$aporte_julio2011=$row2011['aporte_julio'];
$retiros_julio2011=$row2011['retiros_julio'];
$aporte_agosto2011=$row2011['aporte_agosto'];
$retiros_agosto2011=$row2011['retiros_agosto'];
$aporte_septiembre2011=$row2011['aporte_septiembre'];
$retiros_septiembre2011=$row2011['retiros_septiembre'];
$aporte_octubre2011=$row2011['aporte_octubre'];
$retiros_octubre2011=$row2011['retiros_octubre'];
$aporte_noviembre2011=$row2011['aporte_noviembre'];
$retiros_noviembre2011=$row2011['retiros_noviembre'];
$aporte_diciembre2011=$row2011['aporte_diciembre'];
$retiros_diciembre2011=$row2011['retiros_diciembre'];

$ahorro2011=$aporte_enero2011+$aporte_febrero2011+$aporte_marzo2011+$aporte_abril2011+$aporte_mayo2011+$aporte_junio2011+$aporte_julio2011+$aporte_agosto2011+$aporte_septiembre2011+$aporte_octubre2011+$aporte_noviembre2011+$aporte_diciembre2011;
$retiros2011=$retiros_enero2011+$retiros_febrero2011+$retiros_marzo2011+$retiros_abril2011+$retiros_mayo2011+$retiros_junio2011+$retiros_julio2011+$retiros_agosto2011+$retiros_septiembre2011+$retiros_octubre2011+$retiros_noviembre2011+$retiros_diciembre2011;
$total2011=$ahorro2011-$retiros2011;

$ahorro2012=$aporte_enero2012+$aporte_febrero2012+$aporte_marzo2012+$aporte_abril2012+$aporte_mayo2012+$aporte_junio2012+$aporte_julio2012+$aporte_agosto2012+$aporte_septiembre2012+$aporte_octubre2012+$aporte_noviembre2012+$aporte_diciembre2012;
$retiros2012=$retiros_enero2012+$retiros_febrero2012+$retiros_marzo2012+$retiros_abril2012+$retiros_mayo2012+$retiros_junio2012+$retiros_julio2012+$retiros_agosto2012+$retiros_septiembre2012+$retiros_octubre2012+$retiros_noviembre2012+$retiros_diciembre2012;
$total2012=$ahorro2012-$retiros2012;

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

$total_general=$ahorro2021+$ahorro2020+$ahorro2019+$ahorro2018+$ahorro2017+$ahorro2016+$ahorro2015+$ahorro2014+$ahorro2013+$ahorro2012+$ahorro2011-$retiros2012-$retiros2011;

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
?>
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
<div id="ahorros" >
<h1 style="
    color: black;
">Ahorro total a la fecha </h1>
<?php 
echo"<center><div class='item'><h4>Cédula:</h4> $cedula</div><div class='item'><h4>Nombre:</h4> $nombre</div><div class='item'><h4>Apellido:</h4> $apellido</div><div class='item'><h4>Fecha de Inscripción:</h4> $fecha</div><div class='item'><h4>Pago de Inscripción:</h4>".number_format($inscripcion,2,".",",")."</div><div class='item'><h4>Aporte a Capital:</h4>".number_format($aporte,2,".",",")."</div><div class='item'><h4>Total Ahorrado:</h4>".number_format($total_general,2,".",",")."</div><div class='item'><h4>Retirable:</h4>".number_format($total_retirable,2,".",",")."</div></center>";
?>
</div>
<div id="ahorros2" style="
    width: 100%;
    clear: both;
    margin-top: 20px;
    padding: 10px;
    background: white;
	border-radius: 10px;
">
<h1>Tus ahorros por año</h1>
<div>
<form method="POST">
Seleccione el año:
<select style="width:100%;margin:auto;text-align:center;padding: 2px;" name="sitio">
<option value="2021">2021</option>
<option value="2020">2020</option>
<option value="2019">2019</option>
<option value="2018">2018</option>
<option value="2017">2017</option>
<option value="2016">2016</option>
<option value="2015">2015</option>
<option value="2014">2014</option>
<option value="2013">2013</option>
<option value="2012">2012</option>
<option value="2011">2011</option>
<option value="Todos">Todos</option>
</select>
<div style="margin-top: 10px;">
<input class="enviar" type="submit" value="Revisar">
</div>
</form>
<div id="ahorross">
<?php
@$sitio=$_POST['sitio'];
?>

<?php
if ($sitio === '2021'){
$query2=sprintf("SELECT * FROM ahorros_2021 WHERE cedula LIKE '$cedula'");
$query3=sprintf("SELECT * FROM retirable_2021 WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$resultado3=mysql_query($query3);
$row2 = mysql_fetch_assoc($resultado2);
$row3 = mysql_fetch_assoc($resultado3);
$aporte_enero=$row2['aporte_enero'];
$comentarios_enero=$row2['comentarios_enero'];
$aporte_febrero=$row2['aporte_febrero'];
$comentarios_febrero=$row2['comentarios_febrero'];
$aporte_marzo=$row2['aporte_marzo'];
$comentarios_marzo=$row2['comentarios_marzo'];
$aporte_abril=$row2['aporte_abril'];
$comentarios_abril=$row2['comentarios_abril'];
$aporte_mayo=$row2['aporte_mayo'];
$comentarios_mayo=$row2['comentarios_mayo'];
$aporte_junio=$row2['aporte_junio'];
$comentarios_junio=$row2['comentarios_junio'];
$aporte_julio=$row2['aporte_julio'];
$comentarios_julio=$row2['comentarios_julio'];
$aporte_agosto=$row2['aporte_agosto'];
$comentarios_agosto=$row2['comentarios_agosto'];
$aporte_septiembre=$row2['aporte_septiembre'];
$comentarios_septiembre=$row2['comentarios_septiembre'];
$aporte_octubre=$row2['aporte_octubre'];
$comentarios_octubre=$row2['comentarios_octubre'];
$aporte_noviembre=$row2['aporte_noviembre'];
$comentarios_noviembre=$row2['comentarios_noviembre'];
$aporte_diciembre=$row2['aporte_diciembre'];
$comentarios_diciembre=$row2['comentarios_diciembre'];
$aporte_enero3=$row3['aporte_enero'];
$retiros_enero3=$row3['retiros_enero'];
$aporte_febrero3=$row3['aporte_febrero'];
$retiros_febrero3=$row3['retiros_febrero'];
$aporte_marzo3=$row3['aporte_marzo'];
$retiros_marzo3=$row3['retiros_marzo'];
$aporte_abril3=$row3['aporte_abril'];
$retiros_abril3=$row3['retiros_abril'];
$aporte_mayo3=$row3['aporte_mayo'];
$retiros_mayo3=$row3['retiros_mayo'];
$aporte_junio3=$row3['aporte_junio'];
$retiros_junio3=$row3['retiros_junio'];
$aporte_julio3=$row3['aporte_julio'];
$retiros_julio3=$row3['retiros_julio'];
$aporte_agosto3=$row3['aporte_agosto'];
$retiros_agosto3=$row3['retiros_agosto'];
$aporte_septiembre3=$row3['aporte_septiembre'];
$retiros_septiembre3=$row3['retiros_septiembre'];
$aporte_octubre3=$row3['aporte_octubre'];
$retiros_octubre3=$row3['retiros_octubre'];
$aporte_noviembre3=$row3['aporte_noviembre'];
$retiros_noviembre3=$row3['retiros_noviembre'];
$aporte_diciembre3=$row3['aporte_diciembre'];
$retiros_diciembre3=$row3['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2021</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Comentarios</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td><td>".$comentarios_enero."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td><td>".$comentarios_febrero."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td><td>".$comentarios_marzo."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td><td>".$comentarios_abril."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td><td>".$comentarios_mayo."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td><td>".$comentarios_junio."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td><td>".$comentarios_julio."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td><td>".$comentarios_agosto."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td><td>".$comentarios_septiembre."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td><td>".$comentarios_octubre."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td><td>".$comentarios_noviembre."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td><td>".$comentarios_diciembre."</td></tr></table></center>";
echo"<table class='table'><th style='border: none;'><b>Ahorros Retirables 2021</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Retiros</b></td></tr><tr><td>Enero</td><td>$aporte_enero3</td><td>$retiros_enero3</td></tr><tr><td>Febrero</td><td>$aporte_febrero3</td><td>$retiros_febrero3</td></tr><tr><td>Marzo</td><td>$aporte_marzo3</td><td>$retiros_marzo3</td></tr><tr><td>Abril</td><td>$aporte_abril3</td><td>$retiros_abril3</td></tr><tr><td>Mayo</td><td>$aporte_mayo3</td><td>$retiros_mayo3</td></tr><tr><td>Junio</td><td>$aporte_junio3</td><td>$retiros_junio3</td></tr><tr><td>Julio</td><td>$aporte_julio3</td><td>$retiros_julio3</td></tr><tr><td>Agosto</td><td>$aporte_agosto3</td><td>$retiros_agosto3</td></tr><tr><td>Septiembre</td><td>$aporte_septiembre3</td><td>$retiros_septiembre3</td></tr><tr><td>Octubre</td><td>$aporte_octubre3</td><td>$retiros_octubre3</td></tr><tr><td>Noviembre</td><td>$aporte_noviembre3</td><td>$retiros_noviembre3</td></tr><tr><td>Diciembre</td><td>$aporte_diciembre3</td><td>$retiros_diciembre3</td></tr></table></center>";
$ahorro_2021=$aporte_enero+$aporte_febrero+$aporte_marzo+$aporte_abril+$aporte_mayo+$aporte_junio+$aporte_julio+$aporte_agosto+$aporte_septiembre+$aporte_octubre+$aporte_noviembre+$aporte_diciembre;
}
?>


<?php
if ($sitio === '2020'){
$query2=sprintf("SELECT * FROM ahorros_2020 WHERE cedula LIKE '$cedula'");
$query3=sprintf("SELECT * FROM retirable_2020 WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$resultado3=mysql_query($query3);
$row2 = mysql_fetch_assoc($resultado2);
$row3 = mysql_fetch_assoc($resultado3);
$aporte_enero=$row2['aporte_enero'];
$comentarios_enero=$row2['comentarios_enero'];
$aporte_febrero=$row2['aporte_febrero'];
$comentarios_febrero=$row2['comentarios_febrero'];
$aporte_marzo=$row2['aporte_marzo'];
$comentarios_marzo=$row2['comentarios_marzo'];
$aporte_abril=$row2['aporte_abril'];
$comentarios_abril=$row2['comentarios_abril'];
$aporte_mayo=$row2['aporte_mayo'];
$comentarios_mayo=$row2['comentarios_mayo'];
$aporte_junio=$row2['aporte_junio'];
$comentarios_junio=$row2['comentarios_junio'];
$aporte_julio=$row2['aporte_julio'];
$comentarios_julio=$row2['comentarios_julio'];
$aporte_agosto=$row2['aporte_agosto'];
$comentarios_agosto=$row2['comentarios_agosto'];
$aporte_septiembre=$row2['aporte_septiembre'];
$comentarios_septiembre=$row2['comentarios_septiembre'];
$aporte_octubre=$row2['aporte_octubre'];
$comentarios_octubre=$row2['comentarios_octubre'];
$aporte_noviembre=$row2['aporte_noviembre'];
$comentarios_noviembre=$row2['comentarios_noviembre'];
$aporte_diciembre=$row2['aporte_diciembre'];
$comentarios_diciembre=$row2['comentarios_diciembre'];
$aporte_enero3=$row3['aporte_enero'];
$retiros_enero3=$row3['retiros_enero'];
$aporte_febrero3=$row3['aporte_febrero'];
$retiros_febrero3=$row3['retiros_febrero'];
$aporte_marzo3=$row3['aporte_marzo'];
$retiros_marzo3=$row3['retiros_marzo'];
$aporte_abril3=$row3['aporte_abril'];
$retiros_abril3=$row3['retiros_abril'];
$aporte_mayo3=$row3['aporte_mayo'];
$retiros_mayo3=$row3['retiros_mayo'];
$aporte_junio3=$row3['aporte_junio'];
$retiros_junio3=$row3['retiros_junio'];
$aporte_julio3=$row3['aporte_julio'];
$retiros_julio3=$row3['retiros_julio'];
$aporte_agosto3=$row3['aporte_agosto'];
$retiros_agosto3=$row3['retiros_agosto'];
$aporte_septiembre3=$row3['aporte_septiembre'];
$retiros_septiembre3=$row3['retiros_septiembre'];
$aporte_octubre3=$row3['aporte_octubre'];
$retiros_octubre3=$row3['retiros_octubre'];
$aporte_noviembre3=$row3['aporte_noviembre'];
$retiros_noviembre3=$row3['retiros_noviembre'];
$aporte_diciembre3=$row3['aporte_diciembre'];
$retiros_diciembre3=$row3['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2020</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Comentarios</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td><td>".$comentarios_enero."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td><td>".$comentarios_febrero."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td><td>".$comentarios_marzo."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td><td>".$comentarios_abril."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td><td>".$comentarios_mayo."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td><td>".$comentarios_junio."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td><td>".$comentarios_julio."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td><td>".$comentarios_agosto."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td><td>".$comentarios_septiembre."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td><td>".$comentarios_octubre."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td><td>".$comentarios_noviembre."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td><td>".$comentarios_diciembre."</td></tr></table></center>";
echo"<table class='table'><th style='border: none;'><b>Ahorros Retirables 2020</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Retiros</b></td></tr><tr><td>Enero</td><td>$aporte_enero3</td><td>$retiros_enero3</td></tr><tr><td>Febrero</td><td>$aporte_febrero3</td><td>$retiros_febrero3</td></tr><tr><td>Marzo</td><td>$aporte_marzo3</td><td>$retiros_marzo3</td></tr><tr><td>Abril</td><td>$aporte_abril3</td><td>$retiros_abril3</td></tr><tr><td>Mayo</td><td>$aporte_mayo3</td><td>$retiros_mayo3</td></tr><tr><td>Junio</td><td>$aporte_junio3</td><td>$retiros_junio3</td></tr><tr><td>Julio</td><td>$aporte_julio3</td><td>$retiros_julio3</td></tr><tr><td>Agosto</td><td>$aporte_agosto3</td><td>$retiros_agosto3</td></tr><tr><td>Septiembre</td><td>$aporte_septiembre3</td><td>$retiros_septiembre3</td></tr><tr><td>Octubre</td><td>$aporte_octubre3</td><td>$retiros_octubre3</td></tr><tr><td>Noviembre</td><td>$aporte_noviembre3</td><td>$retiros_noviembre3</td></tr><tr><td>Diciembre</td><td>$aporte_diciembre3</td><td>$retiros_diciembre3</td></tr></table></center>";
$ahorro_2020=$aporte_enero+$aporte_febrero+$aporte_marzo+$aporte_abril+$aporte_mayo+$aporte_junio+$aporte_julio+$aporte_agosto+$aporte_septiembre+$aporte_octubre+$aporte_noviembre+$aporte_diciembre;
}
?>
<?php
if ($sitio === '2019'){
$query2=sprintf("SELECT * FROM ahorros_2019 WHERE cedula LIKE '$cedula'");
$query3=sprintf("SELECT * FROM retirable_2019 WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$resultado3=mysql_query($query3);
$row2 = mysql_fetch_assoc($resultado2);
$row3 = mysql_fetch_assoc($resultado3);
$aporte_enero=$row2['aporte_enero'];
$comentarios_enero=$row2['comentarios_enero'];
$aporte_febrero=$row2['aporte_febrero'];
$comentarios_febrero=$row2['comentarios_febrero'];
$aporte_marzo=$row2['aporte_marzo'];
$comentarios_marzo=$row2['comentarios_marzo'];
$aporte_abril=$row2['aporte_abril'];
$comentarios_abril=$row2['comentarios_abril'];
$aporte_mayo=$row2['aporte_mayo'];
$comentarios_mayo=$row2['comentarios_mayo'];
$aporte_junio=$row2['aporte_junio'];
$comentarios_junio=$row2['comentarios_junio'];
$aporte_julio=$row2['aporte_julio'];
$comentarios_julio=$row2['comentarios_julio'];
$aporte_agosto=$row2['aporte_agosto'];
$comentarios_agosto=$row2['comentarios_agosto'];
$aporte_septiembre=$row2['aporte_septiembre'];
$comentarios_septiembre=$row2['comentarios_septiembre'];
$aporte_octubre=$row2['aporte_octubre'];
$comentarios_octubre=$row2['comentarios_octubre'];
$aporte_noviembre=$row2['aporte_noviembre'];
$comentarios_noviembre=$row2['comentarios_noviembre'];
$aporte_diciembre=$row2['aporte_diciembre'];
$comentarios_diciembre=$row2['comentarios_diciembre'];
$aporte_enero3=$row3['aporte_enero'];
$retiros_enero3=$row3['retiros_enero'];
$aporte_febrero3=$row3['aporte_febrero'];
$retiros_febrero3=$row3['retiros_febrero'];
$aporte_marzo3=$row3['aporte_marzo'];
$retiros_marzo3=$row3['retiros_marzo'];
$aporte_abril3=$row3['aporte_abril'];
$retiros_abril3=$row3['retiros_abril'];
$aporte_mayo3=$row3['aporte_mayo'];
$retiros_mayo3=$row3['retiros_mayo'];
$aporte_junio3=$row3['aporte_junio'];
$retiros_junio3=$row3['retiros_junio'];
$aporte_julio3=$row3['aporte_julio'];
$retiros_julio3=$row3['retiros_julio'];
$aporte_agosto3=$row3['aporte_agosto'];
$retiros_agosto3=$row3['retiros_agosto'];
$aporte_septiembre3=$row3['aporte_septiembre'];
$retiros_septiembre3=$row3['retiros_septiembre'];
$aporte_octubre3=$row3['aporte_octubre'];
$retiros_octubre3=$row3['retiros_octubre'];
$aporte_noviembre3=$row3['aporte_noviembre'];
$retiros_noviembre3=$row3['retiros_noviembre'];
$aporte_diciembre3=$row3['aporte_diciembre'];
$retiros_diciembre3=$row3['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2019</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Comentarios</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td><td>".$comentarios_enero."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td><td>".$comentarios_febrero."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td><td>".$comentarios_marzo."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td><td>".$comentarios_abril."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td><td>".$comentarios_mayo."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td><td>".$comentarios_junio."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td><td>".$comentarios_julio."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td><td>".$comentarios_agosto."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td><td>".$comentarios_septiembre."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td><td>".$comentarios_octubre."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td><td>".$comentarios_noviembre."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td><td>".$comentarios_diciembre."</td></tr></table></center>";
echo"<table class='table'><th style='border: none;'><b>Ahorros Retirables 2019</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Retiros</b></td></tr><tr><td>Enero</td><td>$aporte_enero3</td><td>$retiros_enero3</td></tr><tr><td>Febrero</td><td>$aporte_febrero3</td><td>$retiros_febrero3</td></tr><tr><td>Marzo</td><td>$aporte_marzo3</td><td>$retiros_marzo3</td></tr><tr><td>Abril</td><td>$aporte_abril3</td><td>$retiros_abril3</td></tr><tr><td>Mayo</td><td>$aporte_mayo3</td><td>$retiros_mayo3</td></tr><tr><td>Junio</td><td>$aporte_junio3</td><td>$retiros_junio3</td></tr><tr><td>Julio</td><td>$aporte_julio3</td><td>$retiros_julio3</td></tr><tr><td>Agosto</td><td>$aporte_agosto3</td><td>$retiros_agosto3</td></tr><tr><td>Septiembre</td><td>$aporte_septiembre3</td><td>$retiros_septiembre3</td></tr><tr><td>Octubre</td><td>$aporte_octubre3</td><td>$retiros_octubre3</td></tr><tr><td>Noviembre</td><td>$aporte_noviembre3</td><td>$retiros_noviembre3</td></tr><tr><td>Diciembre</td><td>$aporte_diciembre3</td><td>$retiros_diciembre3</td></tr></table></center>";
$ahorro_2019=$aporte_enero+$aporte_febrero+$aporte_marzo+$aporte_abril+$aporte_mayo+$aporte_junio+$aporte_julio+$aporte_agosto+$aporte_septiembre+$aporte_octubre+$aporte_noviembre+$aporte_diciembre;
}
?>
<?php
if ($sitio === '2018'){
$query2=sprintf("SELECT * FROM ahorros_2018 WHERE cedula LIKE '$cedula'");
$query3=sprintf("SELECT * FROM retirable_2018 WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$resultado3=mysql_query($query3);
$row2 = mysql_fetch_assoc($resultado2);
$row3 = mysql_fetch_assoc($resultado3);
$aporte_enero=$row2['aporte_enero'];
$comentarios_enero=$row2['comentarios_enero'];
$aporte_febrero=$row2['aporte_febrero'];
$comentarios_febrero=$row2['comentarios_febrero'];
$aporte_marzo=$row2['aporte_marzo'];
$comentarios_marzo=$row2['comentarios_marzo'];
$aporte_abril=$row2['aporte_abril'];
$comentarios_abril=$row2['comentarios_abril'];
$aporte_mayo=$row2['aporte_mayo'];
$comentarios_mayo=$row2['comentarios_mayo'];
$aporte_junio=$row2['aporte_junio'];
$comentarios_junio=$row2['comentarios_junio'];
$aporte_julio=$row2['aporte_julio'];
$comentarios_julio=$row2['comentarios_julio'];
$aporte_agosto=$row2['aporte_agosto'];
$comentarios_agosto=$row2['comentarios_agosto'];
$aporte_septiembre=$row2['aporte_septiembre'];
$comentarios_septiembre=$row2['comentarios_septiembre'];
$aporte_octubre=$row2['aporte_octubre'];
$comentarios_octubre=$row2['comentarios_octubre'];
$aporte_noviembre=$row2['aporte_noviembre'];
$comentarios_noviembre=$row2['comentarios_noviembre'];
$aporte_diciembre=$row2['aporte_diciembre'];
$comentarios_diciembre=$row2['comentarios_diciembre'];
$aporte_enero3=$row3['aporte_enero'];
$retiros_enero3=$row3['retiros_enero'];
$aporte_febrero3=$row3['aporte_febrero'];
$retiros_febrero3=$row3['retiros_febrero'];
$aporte_marzo3=$row3['aporte_marzo'];
$retiros_marzo3=$row3['retiros_marzo'];
$aporte_abril3=$row3['aporte_abril'];
$retiros_abril3=$row3['retiros_abril'];
$aporte_mayo3=$row3['aporte_mayo'];
$retiros_mayo3=$row3['retiros_mayo'];
$aporte_junio3=$row3['aporte_junio'];
$retiros_junio3=$row3['retiros_junio'];
$aporte_julio3=$row3['aporte_julio'];
$retiros_julio3=$row3['retiros_julio'];
$aporte_agosto3=$row3['aporte_agosto'];
$retiros_agosto3=$row3['retiros_agosto'];
$aporte_septiembre3=$row3['aporte_septiembre'];
$retiros_septiembre3=$row3['retiros_septiembre'];
$aporte_octubre3=$row3['aporte_octubre'];
$retiros_octubre3=$row3['retiros_octubre'];
$aporte_noviembre3=$row3['aporte_noviembre'];
$retiros_noviembre3=$row3['retiros_noviembre'];
$aporte_diciembre3=$row3['aporte_diciembre'];
$retiros_diciembre3=$row3['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2018</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Comentarios</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td><td>".$comentarios_enero."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td><td>".$comentarios_febrero."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td><td>".$comentarios_marzo."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td><td>".$comentarios_abril."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td><td>".$comentarios_mayo."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td><td>".$comentarios_junio."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td><td>".$comentarios_julio."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td><td>".$comentarios_agosto."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td><td>".$comentarios_septiembre."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td><td>".$comentarios_octubre."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td><td>".$comentarios_noviembre."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td><td>".$comentarios_diciembre."</td></tr></table></center>";
echo"<table class='table'><th style='border: none;'><b>Ahorros Retirables 2018</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Retiros</b></td></tr><tr><td>Enero</td><td>$aporte_enero3</td><td>$retiros_enero3</td></tr><tr><td>Febrero</td><td>$aporte_febrero3</td><td>$retiros_febrero3</td></tr><tr><td>Marzo</td><td>$aporte_marzo3</td><td>$retiros_marzo3</td></tr><tr><td>Abril</td><td>$aporte_abril3</td><td>$retiros_abril3</td></tr><tr><td>Mayo</td><td>$aporte_mayo3</td><td>$retiros_mayo3</td></tr><tr><td>Junio</td><td>$aporte_junio3</td><td>$retiros_junio3</td></tr><tr><td>Julio</td><td>$aporte_julio3</td><td>$retiros_julio3</td></tr><tr><td>Agosto</td><td>$aporte_agosto3</td><td>$retiros_agosto3</td></tr><tr><td>Septiembre</td><td>$aporte_septiembre3</td><td>$retiros_septiembre3</td></tr><tr><td>Octubre</td><td>$aporte_octubre3</td><td>$retiros_octubre3</td></tr><tr><td>Noviembre</td><td>$aporte_noviembre3</td><td>$retiros_noviembre3</td></tr><tr><td>Diciembre</td><td>$aporte_diciembre3</td><td>$retiros_diciembre3</td></tr></table></center>";
$ahorro_2018=$aporte_enero+$aporte_febrero+$aporte_marzo+$aporte_abril+$aporte_mayo+$aporte_junio+$aporte_julio+$aporte_agosto+$aporte_septiembre+$aporte_octubre+$aporte_noviembre+$aporte_diciembre;
}
?>
<?php
if ($sitio === '2017'){
$query2=sprintf("SELECT * FROM ahorros_2017 WHERE cedula LIKE '$cedula'");
$query3=sprintf("SELECT * FROM retirable_2017 WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$resultado3=mysql_query($query3);
$row2 = mysql_fetch_assoc($resultado2);
$row3 = mysql_fetch_assoc($resultado3);
$aporte_enero=$row2['aporte_enero'];
$comentarios_enero=$row2['comentarios_enero'];
$retiros_enero=$row2['retiros_enero'];
$aporte_febrero=$row2['aporte_febrero'];
$comentarios_febrero=$row2['comentarios_febrero'];
$retiros_febrero=$row2['retiros_febrero'];
$aporte_marzo=$row2['aporte_marzo'];
$comentarios_marzo=$row2['comentarios_marzo'];
$retiros_marzo=$row2['retiros_marzo'];
$aporte_abril=$row2['aporte_abril'];
$comentarios_abril=$row2['comentarios_abril'];
$retiros_abril=$row2['retiros_abril'];
$aporte_mayo=$row2['aporte_mayo'];
$comentarios_mayo=$row2['comentarios_mayo'];
$retiros_mayo=$row2['retiros_mayo'];
$aporte_junio=$row2['aporte_junio'];
$comentarios_junio=$row2['comentarios_junio'];
$retiros_junio=$row2['retiros_junio'];
$aporte_julio=$row2['aporte_julio'];
$comentarios_julio=$row2['comentarios_julio'];
$retiros_julio=$row2['retiros_julio'];
$aporte_agosto=$row2['aporte_agosto'];
$comentarios_agosto=$row2['comentarios_agosto'];
$retiros_agosto=$row2['retiros_agosto'];
$aporte_septiembre=$row2['aporte_septiembre'];
$comentarios_septiembre=$row2['comentarios_septiembre'];
$retiros_septiembre=$row2['retiros_septiembre'];
$aporte_octubre=$row2['aporte_octubre'];
$comentarios_octubre=$row2['comentarios_octubre'];
$retiros_octubre=$row2['retiros_octubre'];
$aporte_noviembre=$row2['aporte_noviembre'];
$comentarios_noviembre=$row2['comentarios_noviembre'];
$retiros_noviembre=$row2['retiros_noviembre'];
$aporte_diciembre=$row2['aporte_diciembre'];
$comentarios_diciembre=$row2['comentarios_diciembre'];
$retiros_diciembre=$row2['retiros_diciembre'];
$aporte_enero3=$row3['aporte_enero'];
$retiros_enero3=$row3['retiros_enero'];
$aporte_febrero3=$row3['aporte_febrero'];
$retiros_febrero3=$row3['retiros_febrero'];
$aporte_marzo3=$row3['aporte_marzo'];
$retiros_marzo3=$row3['retiros_marzo'];
$aporte_abril3=$row3['aporte_abril'];
$retiros_abril3=$row3['retiros_abril'];
$aporte_mayo3=$row3['aporte_mayo'];
$retiros_mayo3=$row3['retiros_mayo'];
$aporte_junio3=$row3['aporte_junio'];
$retiros_junio3=$row3['retiros_junio'];
$aporte_julio3=$row3['aporte_julio'];
$retiros_julio3=$row3['retiros_julio'];
$aporte_agosto3=$row3['aporte_agosto'];
$retiros_agosto3=$row3['retiros_agosto'];
$aporte_septiembre3=$row3['aporte_septiembre'];
$retiros_septiembre3=$row3['retiros_septiembre'];
$aporte_octubre3=$row3['aporte_octubre'];
$retiros_octubre3=$row3['retiros_octubre'];
$aporte_noviembre3=$row3['aporte_noviembre'];
$retiros_noviembre3=$row3['retiros_noviembre'];
$aporte_diciembre3=$row3['aporte_diciembre'];
$retiros_diciembre3=$row3['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2017</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Comentarios</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td><td>".$comentarios_enero."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td><td>".$comentarios_febrero."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td><td>".$comentarios_marzo."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td><td>".$comentarios_abril."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td><td>".$comentarios_mayo."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td><td>".$comentarios_junio."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td><td>".$comentarios_julio."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td><td>".$comentarios_agosto."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td><td>".$comentarios_septiembre."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td><td>".$comentarios_octubre."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td><td>".$comentarios_noviembre."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td><td>".$comentarios_diciembre."</td></tr></table></center>";
echo"<table class='table'><th style='border: none;'><b>Ahorros Retirables 2017</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Retiros</b></td></tr><tr><td>Enero</td><td>$aporte_enero3</td><td>$retiros_enero3</td></tr><tr><td>Febrero</td><td>$aporte_febrero3</td><td>$retiros_febrero3</td></tr><tr><td>Marzo</td><td>$aporte_marzo3</td><td>$retiros_marzo3</td></tr><tr><td>Abril</td><td>$aporte_abril3</td><td>$retiros_abril3</td></tr><tr><td>Mayo</td><td>$aporte_mayo3</td><td>$retiros_mayo3</td></tr><tr><td>Junio</td><td>$aporte_junio3</td><td>$retiros_junio3</td></tr><tr><td>Julio</td><td>$aporte_julio3</td><td>$retiros_julio3</td></tr><tr><td>Agosto</td><td>$aporte_agosto3</td><td>$retiros_agosto3</td></tr><tr><td>Septiembre</td><td>$aporte_septiembre3</td><td>$retiros_septiembre3</td></tr><tr><td>Octubre</td><td>$aporte_octubre3</td><td>$retiros_octubre3</td></tr><tr><td>Noviembre</td><td>$aporte_noviembre3</td><td>$retiros_noviembre3</td></tr><tr><td>Diciembre</td><td>$aporte_diciembre3</td><td>$retiros_diciembre3</td></tr></table></center>";
$ahorro_2017=$aporte_enero+$aporte_febrero+$aporte_marzo+$aporte_abril+$aporte_mayo+$aporte_junio+$aporte_julio+$aporte_agosto+$aporte_septiembre+$aporte_octubre+$aporte_noviembre+$aporte_diciembre;
}
?>
<?php
if ($sitio === '2016'){
$query2=sprintf("SELECT * FROM ahorros_2016 WHERE cedula LIKE '$cedula'");
$query3=sprintf("SELECT * FROM retirable_2016 WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$resultado3=mysql_query($query3);
$row2 = mysql_fetch_assoc($resultado2);
$row3 = mysql_fetch_assoc($resultado3);
$aporte_enero=$row2['aporte_enero'];
$comentarios_enero=$row2['comentarios_enero'];
$retiros_enero=$row2['retiros_enero'];
$aporte_febrero=$row2['aporte_febrero'];
$comentarios_febrero=$row2['comentarios_febrero'];
$retiros_febrero=$row2['retiros_febrero'];
$aporte_marzo=$row2['aporte_marzo'];
$comentarios_marzo=$row2['comentarios_marzo'];
$retiros_marzo=$row2['retiros_marzo'];
$aporte_abril=$row2['aporte_abril'];
$comentarios_abril=$row2['comentarios_abril'];
$retiros_abril=$row2['retiros_abril'];
$aporte_mayo=$row2['aporte_mayo'];
$comentarios_mayo=$row2['comentarios_mayo'];
$retiros_mayo=$row2['retiros_mayo'];
$aporte_junio=$row2['aporte_junio'];
$comentarios_junio=$row2['comentarios_junio'];
$retiros_junio=$row2['retiros_junio'];
$aporte_julio=$row2['aporte_julio'];
$comentarios_julio=$row2['comentarios_julio'];
$retiros_julio=$row2['retiros_julio'];
$aporte_agosto=$row2['aporte_agosto'];
$comentarios_agosto=$row2['comentarios_agosto'];
$retiros_agosto=$row2['retiros_agosto'];
$aporte_septiembre=$row2['aporte_septiembre'];
$comentarios_septiembre=$row2['comentarios_septiembre'];
$retiros_septiembre=$row2['retiros_septiembre'];
$aporte_octubre=$row2['aporte_octubre'];
$comentarios_octubre=$row2['comentarios_octubre'];
$retiros_octubre=$row2['retiros_octubre'];
$aporte_noviembre=$row2['aporte_noviembre'];
$comentarios_noviembre=$row2['comentarios_noviembre'];
$retiros_noviembre=$row2['retiros_noviembre'];
$aporte_diciembre=$row2['aporte_diciembre'];
$comentarios_diciembre=$row2['comentarios_diciembre'];
$retiros_diciembre=$row2['retiros_diciembre'];
$aporte_enero3=$row3['aporte_enero'];
$retiros_enero3=$row3['retiros_enero'];
$aporte_febrero3=$row3['aporte_febrero'];
$retiros_febrero3=$row3['retiros_febrero'];
$aporte_marzo3=$row3['aporte_marzo'];
$retiros_marzo3=$row3['retiros_marzo'];
$aporte_abril3=$row3['aporte_abril'];
$retiros_abril3=$row3['retiros_abril'];
$aporte_mayo3=$row3['aporte_mayo'];
$retiros_mayo3=$row3['retiros_mayo'];
$aporte_junio3=$row3['aporte_junio'];
$retiros_junio3=$row3['retiros_junio'];
$aporte_julio3=$row3['aporte_julio'];
$retiros_julio3=$row3['retiros_julio'];
$aporte_agosto3=$row3['aporte_agosto'];
$retiros_agosto3=$row3['retiros_agosto'];
$aporte_septiembre3=$row3['aporte_septiembre'];
$retiros_septiembre3=$row3['retiros_septiembre'];
$aporte_octubre3=$row3['aporte_octubre'];
$retiros_octubre3=$row3['retiros_octubre'];
$aporte_noviembre3=$row3['aporte_noviembre'];
$retiros_noviembre3=$row3['retiros_noviembre'];
$aporte_diciembre3=$row3['aporte_diciembre'];
$retiros_diciembre3=$row3['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2016</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Comentarios</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td><td>".$comentarios_enero."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td><td>".$comentarios_febrero."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td><td>".$comentarios_marzo."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td><td>".$comentarios_abril."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td><td>".$comentarios_mayo."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td><td>".$comentarios_junio."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td><td>".$comentarios_julio."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td><td>".$comentarios_agosto."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td><td>".$comentarios_septiembre."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td><td>".$comentarios_octubre."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td><td>".$comentarios_noviembre."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td><td>".$comentarios_diciembre."</td></tr></table></center>";
echo"<table class='table'><th style='border: none;'><b>Ahorros Retirables 2016</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Retiros</b></td></tr><tr><td>Enero</td><td>$aporte_enero3</td><td>$retiros_enero3</td></tr><tr><td>Febrero</td><td>$aporte_febrero3</td><td>$retiros_febrero3</td></tr><tr><td>Marzo</td><td>$aporte_marzo3</td><td>$retiros_marzo3</td></tr><tr><td>Abril</td><td>$aporte_abril3</td><td>$retiros_abril3</td></tr><tr><td>Mayo</td><td>$aporte_mayo3</td><td>$retiros_mayo3</td></tr><tr><td>Junio</td><td>$aporte_junio3</td><td>$retiros_junio3</td></tr><tr><td>Julio</td><td>$aporte_julio3</td><td>$retiros_julio3</td></tr><tr><td>Agosto</td><td>$aporte_agosto3</td><td>$retiros_agosto3</td></tr><tr><td>Septiembre</td><td>$aporte_septiembre3</td><td>$retiros_septiembre3</td></tr><tr><td>Octubre</td><td>$aporte_octubre3</td><td>$retiros_octubre3</td></tr><tr><td>Noviembre</td><td>$aporte_noviembre3</td><td>$retiros_noviembre3</td></tr><tr><td>Diciembre</td><td>$aporte_diciembre3</td><td>$retiros_diciembre3</td></tr></table></center>";
$ahorro_2016=$aporte_enero+$aporte_febrero+$aporte_marzo+$aporte_abril+$aporte_mayo+$aporte_junio+$aporte_julio+$aporte_agosto+$aporte_septiembre+$aporte_octubre+$aporte_noviembre+$aporte_diciembre;
}
?>
<?php
if ($sitio === '2015'){
$query2=sprintf("SELECT * FROM ahorros_2015 WHERE cedula LIKE '$cedula'");
$query3=sprintf("SELECT * FROM retirable_2015 WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$resultado3=mysql_query($query3);
$row2 = mysql_fetch_assoc($resultado2);
$row3 = mysql_fetch_assoc($resultado3);
$aporte_enero=$row2['aporte_enero'];
$comentarios_enero=$row2['comentarios_enero'];
$retiros_enero=$row2['retiros_enero'];
$aporte_febrero=$row2['aporte_febrero'];
$comentarios_febrero=$row2['comentarios_febrero'];
$retiros_febrero=$row2['retiros_febrero'];
$aporte_marzo=$row2['aporte_marzo'];
$comentarios_marzo=$row2['comentarios_marzo'];
$retiros_marzo=$row2['retiros_marzo'];
$aporte_abril=$row2['aporte_abril'];
$comentarios_abril=$row2['comentarios_abril'];
$retiros_abril=$row2['retiros_abril'];
$aporte_mayo=$row2['aporte_mayo'];
$comentarios_mayo=$row2['comentarios_mayo'];
$retiros_mayo=$row2['retiros_mayo'];
$aporte_junio=$row2['aporte_junio'];
$comentarios_junio=$row2['comentarios_junio'];
$retiros_junio=$row2['retiros_junio'];
$aporte_julio=$row2['aporte_julio'];
$comentarios_julio=$row2['comentarios_julio'];
$retiros_julio=$row2['retiros_julio'];
$aporte_agosto=$row2['aporte_agosto'];
$comentarios_agosto=$row2['comentarios_agosto'];
$retiros_agosto=$row2['retiros_agosto'];
$aporte_septiembre=$row2['aporte_septiembre'];
$comentarios_septiembre=$row2['comentarios_septiembre'];
$retiros_septiembre=$row2['retiros_septiembre'];
$aporte_octubre=$row2['aporte_octubre'];
$comentarios_octubre=$row2['comentarios_octubre'];
$retiros_octubre=$row2['retiros_octubre'];
$aporte_noviembre=$row2['aporte_noviembre'];
$comentarios_noviembre=$row2['comentarios_noviembre'];
$retiros_noviembre=$row2['retiros_noviembre'];
$aporte_diciembre=$row2['aporte_diciembre'];
$comentarios_diciembre=$row2['comentarios_diciembre'];
$retiros_diciembre=$row2['retiros_diciembre'];
$aporte_enero3=$row3['aporte_enero'];
$retiros_enero3=$row3['retiros_enero'];
$aporte_febrero3=$row3['aporte_febrero'];
$retiros_febrero3=$row3['retiros_febrero'];
$aporte_marzo3=$row3['aporte_marzo'];
$retiros_marzo3=$row3['retiros_marzo'];
$aporte_abril3=$row3['aporte_abril'];
$retiros_abril3=$row3['retiros_abril'];
$aporte_mayo3=$row3['aporte_mayo'];
$retiros_mayo3=$row3['retiros_mayo'];
$aporte_junio3=$row3['aporte_junio'];
$retiros_junio3=$row3['retiros_junio'];
$aporte_julio3=$row3['aporte_julio'];
$retiros_julio3=$row3['retiros_julio'];
$aporte_agosto3=$row3['aporte_agosto'];
$retiros_agosto3=$row3['retiros_agosto'];
$aporte_septiembre3=$row3['aporte_septiembre'];
$retiros_septiembre3=$row3['retiros_septiembre'];
$aporte_octubre3=$row3['aporte_octubre'];
$retiros_octubre3=$row3['retiros_octubre'];
$aporte_noviembre3=$row3['aporte_noviembre'];
$retiros_noviembre3=$row3['retiros_noviembre'];
$aporte_diciembre3=$row3['aporte_diciembre'];
$retiros_diciembre3=$row3['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2015</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Comentarios</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td><td>".$comentarios_enero."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td><td>".$comentarios_febrero."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td><td>".$comentarios_marzo."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td><td>".$comentarios_abril."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td><td>".$comentarios_mayo."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td><td>".$comentarios_junio."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td><td>".$comentarios_julio."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td><td>".$comentarios_agosto."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td><td>".$comentarios_septiembre."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td><td>".$comentarios_octubre."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td><td>".$comentarios_noviembre."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td><td>".$comentarios_diciembre."</td></tr></table></center>";
echo"<table class='table'><th style='border: none;'><b>Ahorros Retirables 2015</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Retiros</b></td></tr><tr><td>Enero</td><td>$aporte_enero3</td><td>$retiros_enero3</td></tr><tr><td>Febrero</td><td>$aporte_febrero3</td><td>$retiros_febrero3</td></tr><tr><td>Marzo</td><td>$aporte_marzo3</td><td>$retiros_marzo3</td></tr><tr><td>Abril</td><td>$aporte_abril3</td><td>$retiros_abril3</td></tr><tr><td>Mayo</td><td>$aporte_mayo3</td><td>$retiros_mayo3</td></tr><tr><td>Junio</td><td>$aporte_junio3</td><td>$retiros_junio3</td></tr><tr><td>Julio</td><td>$aporte_julio3</td><td>$retiros_julio3</td></tr><tr><td>Agosto</td><td>$aporte_agosto3</td><td>$retiros_agosto3</td></tr><tr><td>Septiembre</td><td>$aporte_septiembre3</td><td>$retiros_septiembre3</td></tr><tr><td>Octubre</td><td>$aporte_octubre3</td><td>$retiros_octubre3</td></tr><tr><td>Noviembre</td><td>$aporte_noviembre3</td><td>$retiros_noviembre3</td></tr><tr><td>Diciembre</td><td>$aporte_diciembre3</td><td>$retiros_diciembre3</td></tr></table></center>";
$ahorro_2015=$aporte_enero+$aporte_febrero+$aporte_marzo+$aporte_abril+$aporte_mayo+$aporte_junio+$aporte_julio+$aporte_agosto+$aporte_septiembre+$aporte_octubre+$aporte_noviembre+$aporte_diciembre;
}
?>
<?php
if ($sitio === '2014'){
$query2=sprintf("SELECT * FROM ahorros_2014 WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$row2 = mysql_fetch_assoc($resultado2);
$aporte_enero=$row2['aporte_enero'];
$retiros_enero=$row2['retiros_enero'];
$aporte_febrero=$row2['aporte_febrero'];
$retiros_febrero=$row2['retiros_febrero'];
$aporte_marzo=$row2['aporte_marzo'];
$retiros_marzo=$row2['retiros_marzo'];
$aporte_abril=$row2['aporte_abril'];
$retiros_abril=$row2['retiros_abril'];
$aporte_mayo=$row2['aporte_mayo'];
$retiros_mayo=$row2['retiros_mayo'];
$aporte_junio=$row2['aporte_junio'];
$retiros_junio=$row2['retiros_junio'];
$aporte_julio=$row2['aporte_julio'];
$retiros_julio=$row2['retiros_julio'];
$aporte_agosto=$row2['aporte_agosto'];
$retiros_agosto=$row2['retiros_agosto'];
$aporte_septiembre=$row2['aporte_septiembre'];
$retiros_septiembre=$row2['retiros_septiembre'];
$aporte_octubre=$row2['aporte_octubre'];
$retiros_octubre=$row2['retiros_octubre'];
$aporte_noviembre=$row2['aporte_noviembre'];
$retiros_noviembre=$row2['retiros_noviembre'];
$aporte_diciembre=$row2['aporte_diciembre'];
$retiros_diciembre=$row2['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2014</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td></tr></table></center>";
$ahorro_2014=$aporte_enero+$aporte_febrero+$aporte_marzo+$aporte_abril+$aporte_mayo+$aporte_junio+$aporte_julio+$aporte_agosto+$aporte_septiembre+$aporte_octubre+$aporte_noviembre+$aporte_diciembre;
}
?>
<?php
if ($sitio === '2013'){
$query2=sprintf("SELECT * FROM ahorros_2013 WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$row2 = mysql_fetch_assoc($resultado2);
$aporte_enero=$row2['aporte_enero'];
$retiros_enero=$row2['retiros_enero'];
$aporte_febrero=$row2['aporte_febrero'];
$retiros_febrero=$row2['retiros_febrero'];
$aporte_marzo=$row2['aporte_marzo'];
$retiros_marzo=$row2['retiros_marzo'];
$aporte_abril=$row2['aporte_abril'];
$retiros_abril=$row2['retiros_abril'];
$aporte_mayo=$row2['aporte_mayo'];
$retiros_mayo=$row2['retiros_mayo'];
$aporte_junio=$row2['aporte_junio'];
$retiros_junio=$row2['retiros_junio'];
$aporte_julio=$row2['aporte_julio'];
$retiros_julio=$row2['retiros_julio'];
$aporte_agosto=$row2['aporte_agosto'];
$retiros_agosto=$row2['retiros_agosto'];
$aporte_septiembre=$row2['aporte_septiembre'];
$retiros_septiembre=$row2['retiros_septiembre'];
$aporte_octubre=$row2['aporte_octubre'];
$retiros_octubre=$row2['retiros_octubre'];
$aporte_noviembre=$row2['aporte_noviembre'];
$retiros_noviembre=$row2['retiros_noviembre'];
$aporte_diciembre=$row2['aporte_diciembre'];
$retiros_diciembre=$row2['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2013</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td></tr></table></center>";
$ahorro_2013=$aporte_enero+$aporte_febrero+$aporte_marzo+$aporte_abril+$aporte_mayo+$aporte_junio+$aporte_julio+$aporte_agosto+$aporte_septiembre+$aporte_octubre+$aporte_noviembre+$aporte_diciembre;
}
?>
<?php
if ($sitio === '2012'){
$query2=sprintf("SELECT * FROM ahorros_2012 WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$row2 = mysql_fetch_assoc($resultado2);
$aporte_enero=$row2['aporte_enero'];
$retiros_enero=$row2['retiros_enero'];
$aporte_febrero=$row2['aporte_febrero'];
$retiros_febrero=$row2['retiros_febrero'];
$aporte_marzo=$row2['aporte_marzo'];
$retiros_marzo=$row2['retiros_marzo'];
$aporte_abril=$row2['aporte_abril'];
$retiros_abril=$row2['retiros_abril'];
$aporte_mayo=$row2['aporte_mayo'];
$retiros_mayo=$row2['retiros_mayo'];
$aporte_junio=$row2['aporte_junio'];
$retiros_junio=$row2['retiros_junio'];
$aporte_julio=$row2['aporte_julio'];
$retiros_julio=$row2['retiros_julio'];
$aporte_agosto=$row2['aporte_agosto'];
$retiros_agosto=$row2['retiros_agosto'];
$aporte_septiembre=$row2['aporte_septiembre'];
$retiros_septiembre=$row2['retiros_septiembre'];
$aporte_octubre=$row2['aporte_octubre'];
$retiros_octubre=$row2['retiros_octubre'];
$aporte_noviembre=$row2['aporte_noviembre'];
$retiros_noviembre=$row2['retiros_noviembre'];
$aporte_diciembre=$row2['aporte_diciembre'];
$retiros_diciembre=$row2['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2012</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Retiros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td><td>".number_format($retiros_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td><td>".number_format($retiros_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td><td>".number_format($retiros_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td><td>".number_format($retiros_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td><td>".number_format($retiros_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td><td>".number_format($retiros_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td><td>".number_format($retiros_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td><td>".number_format($retiros_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td><td>".number_format($retiros_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td><td>".number_format($retiros_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td><td>".number_format($retiros_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td><td>".number_format($retiros_diciembre,2,".",",")."</td></tr></table></center>";
$ahorro_2012=$aporte_enero+$aporte_febrero+$aporte_marzo+$aporte_abril+$aporte_mayo+$aporte_junio+$aporte_julio+$aporte_agosto+$aporte_septiembre+$aporte_octubre+$aporte_noviembre+$aporte_diciembre;
}
?>
<?php
if ($sitio === '2011'){
$query2=sprintf("SELECT * FROM ahorros_2011 WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$row2 = mysql_fetch_assoc($resultado2);
$aporte_enero=$row2['aporte_enero'];
$retiros_enero=$row2['retiros_enero'];
$aporte_febrero=$row2['aporte_febrero'];
$retiros_febrero=$row2['retiros_febrero'];
$aporte_marzo=$row2['aporte_marzo'];
$retiros_marzo=$row2['retiros_marzo'];
$aporte_abril=$row2['aporte_abril'];
$retiros_abril=$row2['retiros_abril'];
$aporte_mayo=$row2['aporte_mayo'];
$retiros_mayo=$row2['retiros_mayo'];
$aporte_junio=$row2['aporte_junio'];
$retiros_junio=$row2['retiros_junio'];
$aporte_julio=$row2['aporte_julio'];
$retiros_julio=$row2['retiros_julio'];
$aporte_agosto=$row2['aporte_agosto'];
$retiros_agosto=$row2['retiros_agosto'];
$aporte_septiembre=$row2['aporte_septiembre'];
$retiros_septiembre=$row2['retiros_septiembre'];
$aporte_octubre=$row2['aporte_octubre'];
$retiros_octubre=$row2['retiros_octubre'];
$aporte_noviembre=$row2['aporte_noviembre'];
$retiros_noviembre=$row2['retiros_noviembre'];
$aporte_diciembre=$row2['aporte_diciembre'];
$retiros_diciembre=$row2['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2011</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Retiros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td><td>".number_format($retiros_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td><td>".number_format($retiros_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td><td>".number_format($retiros_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td><td>".number_format($retiros_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td><td>".number_format($retiros_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td><td>".number_format($retiros_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td><td>".number_format($retiros_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td><td>".number_format($retiros_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td><td>".number_format($retiros_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td><td>".number_format($retiros_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td><td>".number_format($retiros_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td><td>".number_format($retiros_diciembre,2,".",",")."</td></tr></table></center>";
$ahorro_2011=$aporte_enero+$aporte_febrero+$aporte_marzo+$aporte_abril+$aporte_mayo+$aporte_junio+$aporte_julio+$aporte_agosto+$aporte_septiembre+$aporte_octubre+$aporte_noviembre+$aporte_diciembre;
}
?>
<?php
if ($sitio === 'Todos'){
	
			$query2021=sprintf("SELECT * FROM ahorros_2021 WHERE cedula LIKE '$cedula'");
$resultado2021=mysql_query($query2021);
$row2021 = mysql_fetch_assoc($resultado2021);
$aporte_enero=$row2021['aporte_enero'];
$aporte_febrero=$row2021['aporte_febrero'];
$aporte_marzo=$row2021['aporte_marzo'];
$aporte_abril=$row2021['aporte_abril'];
$aporte_mayo=$row2021['aporte_mayo'];
$aporte_junio=$row2021['aporte_junio'];
$aporte_julio=$row2021['aporte_julio'];
$aporte_agosto=$row2021['aporte_agosto'];
$aporte_septiembre=$row2021['aporte_septiembre'];
$aporte_octubre=$row2021['aporte_octubre'];
$aporte_noviembre=$row2021['aporte_noviembre'];
$aporte_diciembre=$row2021['aporte_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2021</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td></tr></table></center>";

	
		$query2020=sprintf("SELECT * FROM ahorros_2020 WHERE cedula LIKE '$cedula'");
$resultado2020=mysql_query($query2020);
$row2020 = mysql_fetch_assoc($resultado2020);
$aporte_enero=$row2020['aporte_enero'];
$aporte_febrero=$row2020['aporte_febrero'];
$aporte_marzo=$row2020['aporte_marzo'];
$aporte_abril=$row2020['aporte_abril'];
$aporte_mayo=$row2020['aporte_mayo'];
$aporte_junio=$row2020['aporte_junio'];
$aporte_julio=$row2020['aporte_julio'];
$aporte_agosto=$row2020['aporte_agosto'];
$aporte_septiembre=$row2020['aporte_septiembre'];
$aporte_octubre=$row2020['aporte_octubre'];
$aporte_noviembre=$row2020['aporte_noviembre'];
$aporte_diciembre=$row2020['aporte_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2020</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td></tr></table></center>";
	
	
		$query2019=sprintf("SELECT * FROM ahorros_2019 WHERE cedula LIKE '$cedula'");
$resultado2019=mysql_query($query2019);
$row2019 = mysql_fetch_assoc($resultado2019);
$aporte_enero=$row2019['aporte_enero'];
$aporte_febrero=$row2019['aporte_febrero'];
$aporte_marzo=$row2019['aporte_marzo'];
$aporte_abril=$row2019['aporte_abril'];
$aporte_mayo=$row2019['aporte_mayo'];
$aporte_junio=$row2019['aporte_junio'];
$aporte_julio=$row2019['aporte_julio'];
$aporte_agosto=$row2019['aporte_agosto'];
$aporte_septiembre=$row2019['aporte_septiembre'];
$aporte_octubre=$row2019['aporte_octubre'];
$aporte_noviembre=$row2019['aporte_noviembre'];
$aporte_diciembre=$row2019['aporte_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2019</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td></tr></table></center>";

	
		$query2018=sprintf("SELECT * FROM ahorros_2018 WHERE cedula LIKE '$cedula'");
$resultado2018=mysql_query($query2018);
$row2018 = mysql_fetch_assoc($resultado2018);
$aporte_enero=$row2018['aporte_enero'];
$aporte_febrero=$row2018['aporte_febrero'];
$aporte_marzo=$row2018['aporte_marzo'];
$aporte_abril=$row2018['aporte_abril'];
$aporte_mayo=$row2018['aporte_mayo'];
$aporte_junio=$row2018['aporte_junio'];
$aporte_julio=$row2018['aporte_julio'];
$aporte_agosto=$row2018['aporte_agosto'];
$aporte_septiembre=$row2018['aporte_septiembre'];
$aporte_octubre=$row2018['aporte_octubre'];
$aporte_noviembre=$row2018['aporte_noviembre'];
$aporte_diciembre=$row2018['aporte_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2018</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td></tr></table></center>";

	$query2017=sprintf("SELECT * FROM ahorros_2017 WHERE cedula LIKE '$cedula'");
$resultado2017=mysql_query($query2017);
$row2017 = mysql_fetch_assoc($resultado2017);
$aporte_enero=$row2017['aporte_enero'];
$aporte_febrero=$row2017['aporte_febrero'];
$aporte_marzo=$row2017['aporte_marzo'];
$aporte_abril=$row2017['aporte_abril'];
$aporte_mayo=$row2017['aporte_mayo'];
$aporte_junio=$row2017['aporte_junio'];
$aporte_julio=$row2017['aporte_julio'];
$aporte_agosto=$row2017['aporte_agosto'];
$aporte_septiembre=$row2017['aporte_septiembre'];
$aporte_octubre=$row2017['aporte_octubre'];
$aporte_noviembre=$row2017['aporte_noviembre'];
$aporte_diciembre=$row2017['aporte_diciembre'];

echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2017</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td></tr></table></center>";
$query2016=sprintf("SELECT * FROM ahorros_2016 WHERE cedula LIKE '$cedula'");
$resultado2016=mysql_query($query2016);
$row2016 = mysql_fetch_assoc($resultado2016);
$aporte_enero=$row2016['aporte_enero'];
$retiros_enero=$row2016['retiros_enero'];
$aporte_febrero=$row2016['aporte_febrero'];
$retiros_febrero=$row2016['retiros_febrero'];
$aporte_marzo=$row2016['aporte_marzo'];
$retiros_marzo=$row2016['retiros_marzo'];
$aporte_abril=$row2016['aporte_abril'];
$retiros_abril=$row2016['retiros_abril'];
$aporte_mayo=$row2016['aporte_mayo'];
$retiros_mayo=$row2016['retiros_mayo'];
$aporte_junio=$row2016['aporte_junio'];
$retiros_junio=$row2016['retiros_junio'];
$aporte_julio=$row2016['aporte_julio'];
$retiros_julio=$row2016['retiros_julio'];
$aporte_agosto=$row2016['aporte_agosto'];
$retiros_agosto=$row2016['retiros_agosto'];
$aporte_septiembre=$row2016['aporte_septiembre'];
$retiros_septiembre=$row2016['retiros_septiembre'];
$aporte_octubre=$row2016['aporte_octubre'];
$retiros_octubre=$row2016['retiros_octubre'];
$aporte_noviembre=$row2016['aporte_noviembre'];
$retiros_noviembre=$row2016['retiros_noviembre'];
$aporte_diciembre=$row2016['aporte_diciembre'];
$retiros_diciembre=$row2016['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2016</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td></tr></table></center>";
$query2015=sprintf("SELECT * FROM ahorros_2015 WHERE cedula LIKE '$cedula'");
$resultado2015=mysql_query($query2015);
$row2015 = mysql_fetch_assoc($resultado2015);
$aporte_enero=$row2015['aporte_enero'];
$retiros_enero=$row2015['retiros_enero'];
$aporte_febrero=$row2015['aporte_febrero'];
$retiros_febrero=$row2015['retiros_febrero'];
$aporte_marzo=$row2015['aporte_marzo'];
$retiros_marzo=$row2015['retiros_marzo'];
$aporte_abril=$row2015['aporte_abril'];
$retiros_abril=$row2015['retiros_abril'];
$aporte_mayo=$row2015['aporte_mayo'];
$retiros_mayo=$row2015['retiros_mayo'];
$aporte_junio=$row2015['aporte_junio'];
$retiros_junio=$row2015['retiros_junio'];
$aporte_julio=$row2015['aporte_julio'];
$retiros_julio=$row2015['retiros_julio'];
$aporte_agosto=$row2015['aporte_agosto'];
$retiros_agosto=$row2015['retiros_agosto'];
$aporte_septiembre=$row2015['aporte_septiembre'];
$retiros_septiembre=$row2015['retiros_septiembre'];
$aporte_octubre=$row2015['aporte_octubre'];
$retiros_octubre=$row2015['retiros_octubre'];
$aporte_noviembre=$row2015['aporte_noviembre'];
$retiros_noviembre=$row2015['retiros_noviembre'];
$aporte_diciembre=$row2015['aporte_diciembre'];
$retiros_diciembre=$row2015['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2015</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td></tr></table></center>";

$query2014=sprintf("SELECT * FROM ahorros_2014 WHERE cedula LIKE '$cedula'");
$resultado2014=mysql_query($query2014);
$row2014 = mysql_fetch_assoc($resultado2014);
$aporte_enero=$row2014['aporte_enero'];
$retiros_enero=$row2014['retiros_enero'];
$aporte_febrero=$row2014['aporte_febrero'];
$retiros_febrero=$row2014['retiros_febrero'];
$aporte_marzo=$row2014['aporte_marzo'];
$retiros_marzo=$row2014['retiros_marzo'];
$aporte_abril=$row2014['aporte_abril'];
$retiros_abril=$row2014['retiros_abril'];
$aporte_mayo=$row2014['aporte_mayo'];
$retiros_mayo=$row2014['retiros_mayo'];
$aporte_junio=$row2014['aporte_junio'];
$retiros_junio=$row2014['retiros_junio'];
$aporte_julio=$row2014['aporte_julio'];
$retiros_julio=$row2014['retiros_julio'];
$aporte_agosto=$row2014['aporte_agosto'];
$retiros_agosto=$row2014['retiros_agosto'];
$aporte_septiembre=$row2014['aporte_septiembre'];
$retiros_septiembre=$row2014['retiros_septiembre'];
$aporte_octubre=$row2014['aporte_octubre'];
$retiros_octubre=$row2014['retiros_octubre'];
$aporte_noviembre=$row2014['aporte_noviembre'];
$retiros_noviembre=$row2014['retiros_noviembre'];
$aporte_diciembre=$row2014['aporte_diciembre'];
$retiros_diciembre=$row2014['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2014</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td></tr></table></center>";
$query2013=sprintf("SELECT * FROM ahorros_2013 WHERE cedula LIKE '$cedula'");
$resultado2013=mysql_query($query2013);
$row2013 = mysql_fetch_assoc($resultado2013);
$aporte_enero=$row2013['aporte_enero'];
$retiros_enero=$row2013['retiros_enero'];
$aporte_febrero=$row2013['aporte_febrero'];
$retiros_febrero=$row2013['retiros_febrero'];
$aporte_marzo=$row2013['aporte_marzo'];
$retiros_marzo=$row2013['retiros_marzo'];
$aporte_abril=$row2013['aporte_abril'];
$retiros_abril=$row2013['retiros_abril'];
$aporte_mayo=$row2013['aporte_mayo'];
$retiros_mayo=$row2013['retiros_mayo'];
$aporte_junio=$row2013['aporte_junio'];
$retiros_junio=$row2013['retiros_junio'];
$aporte_julio=$row2013['aporte_julio'];
$retiros_julio=$row2013['retiros_julio'];
$aporte_agosto=$row2013['aporte_agosto'];
$retiros_agosto=$row2013['retiros_agosto'];
$aporte_septiembre=$row2013['aporte_septiembre'];
$retiros_septiembre=$row2013['retiros_septiembre'];
$aporte_octubre=$row2013['aporte_octubre'];
$retiros_octubre=$row2013['retiros_octubre'];
$aporte_noviembre=$row2013['aporte_noviembre'];
$retiros_noviembre=$row2013['retiros_noviembre'];
$aporte_diciembre=$row2013['aporte_diciembre'];
$retiros_diciembre=$row2013['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2013</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td></tr></table></center>";

$query2012=sprintf("SELECT * FROM ahorros_2012 WHERE cedula LIKE '$cedula'");
$resultado2012=mysql_query($query2012);
$row2012 = mysql_fetch_assoc($resultado2012);
$aporte_enero=$row2012['aporte_enero'];
$retiros_enero=$row2012['retiros_enero'];
$aporte_febrero=$row2012['aporte_febrero'];
$retiros_febrero=$row2012['retiros_febrero'];
$aporte_marzo=$row2012['aporte_marzo'];
$retiros_marzo=$row2012['retiros_marzo'];
$aporte_abril=$row2012['aporte_abril'];
$retiros_abril=$row2012['retiros_abril'];
$aporte_mayo=$row2012['aporte_mayo'];
$retiros_mayo=$row2012['retiros_mayo'];
$aporte_junio=$row2012['aporte_junio'];
$retiros_junio=$row2012['retiros_junio'];
$aporte_julio=$row2012['aporte_julio'];
$retiros_julio=$row2012['retiros_julio'];
$aporte_agosto=$row2012['aporte_agosto'];
$retiros_agosto=$row2012['retiros_agosto'];
$aporte_septiembre=$row2012['aporte_septiembre'];
$retiros_septiembre=$row2012['retiros_septiembre'];
$aporte_octubre=$row2012['aporte_octubre'];
$retiros_octubre=$row2012['retiros_octubre'];
$aporte_noviembre=$row2012['aporte_noviembre'];
$retiros_noviembre=$row2012['retiros_noviembre'];
$aporte_diciembre=$row2012['aporte_diciembre'];
$retiros_diciembre=$row2012['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2012</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Retiros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td><td>".number_format($retiros_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td><td>".number_format($retiros_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td><td>".number_format($retiros_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td><td>".number_format($retiros_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td><td>".number_format($retiros_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td><td>".number_format($retiros_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td><td>".number_format($retiros_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td><td>".number_format($retiros_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td><td>".number_format($retiros_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td><td>".number_format($retiros_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td><td>".number_format($retiros_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td><td>".number_format($retiros_diciembre,2,".",",")."</td></tr></table></center>";

$query2011=sprintf("SELECT * FROM ahorros_2011 WHERE cedula LIKE '$cedula'");
$resultado2011=mysql_query($query2011);
$row2011 = mysql_fetch_assoc($resultado2011);
$aporte_enero=$row2011['aporte_enero'];
$retiros_enero=$row2011['retiros_enero'];
$aporte_febrero=$row2011['aporte_febrero'];
$retiros_febrero=$row2011['retiros_febrero'];
$aporte_marzo=$row2011['aporte_marzo'];
$retiros_marzo=$row2011['retiros_marzo'];
$aporte_abril=$row2011['aporte_abril'];
$retiros_abril=$row2011['retiros_abril'];
$aporte_mayo=$row2011['aporte_mayo'];
$retiros_mayo=$row2011['retiros_mayo'];
$aporte_junio=$row2011['aporte_junio'];
$retiros_junio=$row2011['retiros_junio'];
$aporte_julio=$row2011['aporte_julio'];
$retiros_julio=$row2011['retiros_julio'];
$aporte_agosto=$row2011['aporte_agosto'];
$retiros_agosto=$row2011['retiros_agosto'];
$aporte_septiembre=$row2011['aporte_septiembre'];
$retiros_septiembre=$row2011['retiros_septiembre'];
$aporte_octubre=$row2011['aporte_octubre'];
$retiros_octubre=$row2011['retiros_octubre'];
$aporte_noviembre=$row2011['aporte_noviembre'];
$retiros_noviembre=$row2011['retiros_noviembre'];
$aporte_diciembre=$row2011['aporte_diciembre'];
$retiros_diciembre=$row2011['retiros_diciembre'];
echo"<center><table class='table'><th style='border: none;'><b>Ahorros Normales 2011</b></th><tr><td><b>Mes</b></td><td><b>Ahorros</b></td><td><b>Retiros</b></td></tr><tr><td>Enero</td><td>".number_format($aporte_enero,2,".",",")."</td><td>".number_format($retiros_enero,2,".",",")."</td></tr><tr><td>Febrero</td><td>".number_format($aporte_febrero,2,".",",")."</td><td>".number_format($retiros_febrero,2,".",",")."</td></tr><tr><td>Marzo</td><td>".number_format($aporte_marzo,2,".",",")."</td><td>".number_format($retiros_marzo,2,".",",")."</td></tr><tr><td>Abril</td><td>".number_format($aporte_abril,2,".",",")."</td><td>".number_format($retiros_abril,2,".",",")."</td></tr><tr><td>Mayo</td><td>".number_format($aporte_mayo,2,".",",")."</td><td>".number_format($retiros_mayo,2,".",",")."</td></tr><tr><td>Junio</td><td>".number_format($aporte_junio,2,".",",")."</td><td>".number_format($retiros_junio,2,".",",")."</td></tr><tr><td>Julio</td><td>".number_format($aporte_julio,2,".",",")."</td><td>".number_format($retiros_julio,2,".",",")."</td></tr><tr><td>Agosto</td><td>".number_format($aporte_agosto,2,".",",")."</td><td>".number_format($retiros_agosto,2,".",",")."</td></tr><tr><td>Septiembre</td><td>".number_format($aporte_septiembre,2,".",",")."</td><td>".number_format($retiros_septiembre,2,".",",")."</td></tr><tr><td>Octubre</td><td>".number_format($aporte_octubre,2,".",",")."</td><td>".number_format($retiros_octubre,2,".",",")."</td></tr><tr><td>Noviembre</td><td>".number_format($aporte_noviembre,2,".",",")."</td><td>".number_format($retiros_noviembre,2,".",",")."</td></tr><tr><td>Diciembre</td><td>".number_format($aporte_diciembre,2,".",",")."</td><td>".number_format($retiros_diciembre,2,".",",")."</td></tr></table></center>";
}
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
mysql_free_result($sexo);
?>