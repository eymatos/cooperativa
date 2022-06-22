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
<h1>Tus Préstamos</h1>
<div>
<form method="POST">
Seleccione el tipo de préstamo:
<select style="width:100%;margin:auto;text-align:center;" name="sitio">
<option value="normales">Préstamos Normales</option>
<option value="educativos">Préstamos Educativos</option>
<option value="escolares">Préstamos Útiles Escolares</option>
<option value="vacacionales">Préstamos Vacacionales</option>
<option value="gerenciales">Préstamos Gerenciales</option>
<option value="prestamo_especial_madres">Préstamo Especial Madres</option>
</select>
<div style="margin-top: 10px;">
<input class="enviar" type="submit" value="Revisar">
</div>
</form>
<div id="ahorross">
<?php
$resultado=mysql_query($query_sexo);
$row = mysql_fetch_assoc($resultado);
$cedula= $row['cedula'];
$queryaviso="SELECT * FROM aviso WHERE cedula='$cedula' AND estatus='1'";
$resultadoaviso=mysql_query($queryaviso);
$conteoaviso = mysql_num_rows($resultadoaviso);
if($conteoaviso>0){
?>
<script>

//Alert message once script- By JavaScript Kit
//Credit notice must stay intact for use
//Visit http://javascriptkit.com for this script

//specify message to alert
var alertmessage="Estimado socio. Recuerda que durante los meses de abril y mayo de 2020, por motivo de la pandemia provocada por el COVID-19, no se realizaron los descuentos de los préstamos activos en esa fecha. El cobro se reanudó el mes de junio de 2020. Los dos meses no cobrados se sumarán al final del período de tu préstamo, por lo que terminarás el pago de las cuotas dos meses más de lo que indican las tablas de amortización a las que aplique. Gracias por la comprensión."

///No editing required beyond here/////

//Alert only once per browser session (0=no, 1=yes)
var once_per_session=1


function get_cookie(Name) {
  var search = Name + "="
  var returnvalue = "";
  if (document.cookie.length > 0) {
    offset = document.cookie.indexOf(search)
    if (offset != -1) { // if cookie exists
      offset += search.length
      // set index of beginning of value
      end = document.cookie.indexOf(";", offset);
      // set index of end of cookie value
      if (end == -1)
         end = document.cookie.length;
      returnvalue=unescape(document.cookie.substring(offset, end))
      }
   }
  return returnvalue;
}

function alertornot(){
if (get_cookie('alerted')==''){
loadalert()
document.cookie="alerted=yes"
}
}

function loadalert(){
alert(alertmessage)
}

if (once_per_session==0)
loadalert()
else
alertornot()

</script>

<?php	
}
@$sitio=$_POST['sitio'];
if ($sitio === 'normales'){
$query2=sprintf("SELECT * FROM prestamos_normales WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$row2 = mysql_fetch_assoc($resultado2);
$deuda=$row2['monto'];
$interes=$row2['interes'];
$anos=$row2['plazo'];
$numero_prestamo=$row2['numero_prestamo'];
$fecha_prestamo=$row2['fecha_prestamo'];
$primera_cuota=$row2['primera_cuota'];
$total_pagar=$row2['total_pagar'];
$tipo=$row2['tipo'];$desembolso=$row2['desembolso'];$prestamo_anterior=$row2['prestamo_anterior'];
$desembolso=$row2['desembolso'];
$prestamo_anterior=$row2['prestamo_anterior'];


	// hacemos los calculos...
	?>
	</div>
	<div><h1>Préstamos Normales</h1></div>
	 <div class="bordes">
	 <?php
if($deuda && $anos && $interes)
{	

	$interes=($interes/100)/12;
	$m=($deuda*$interes*(pow((1+$interes),($anos))))/((pow((1+$interes),($anos)))-1); 
	
	echo "<table class='table-striped' style='width: 100%;'>";
	echo "<tr><td><b>MONTO</b></td><td> RD$ ".number_format($deuda,2,".",",")."</td><td><b>NÚMERO PRÉSTAMO</b></td><td>".$numero_prestamo."</td></tr>";
	echo "<tr><td><b>INTERES</b></td><td>".(($interes*12)*100)."%</td><td><b>FECHA DEL PRÉSTAMO</b></td><td>".$fecha_prestamo."</td></tr>";
	echo "<tr><td><b>PLAZO</b></td><td>".$anos." Meses</td><td><b>PRIMERA CUOTA</b></td><td>".$primera_cuota."</td></tr>";
		echo "<tr><td><b>CUOTA</b></td><td>RD$ ".number_format($m,2,".",",")."</td><td><b>TOTAL A PAGAR</b></td><td>".number_format($total_pagar,2,".",",")."</td></tr>";	echo "<tr><td><b>DESEMBOLSO</b></td><td>RD$ ".number_format($desembolso,2,".",",")."</td><td><b>NO. PRESTAMO ANTERIOR</b></td><td>".$prestamo_anterior."</td></tr>";
	echo "</table>";
	?>
	<div class="table-responsive">
	<table id="tables" class="table" border=1 cellpadding=5 cellspacing=0>
		<tr>
		<th>Pago</th>
			<th>Mes</th>
			<th>Intereses</th>
			<th>Amortización</th>
			<th>Capital Pendiente</th>
		</tr>
		<?php
		// mostramos todos los meses...
		$primera_cuota=date("m-d-Y",strtotime($primera_cuota)); 
		$nuevafecha=$primera_cuota;
		for($i=1;$i<=$anos;$i++)
		{
			echo "<tr>";
			echo "<td align=right>".$i."</td>";
				echo "<td align=right>".$nuevafecha."</td>";
				$nuevafecha = strtotime ( '+'.$i.'month' , strtotime ( $primera_cuota ) ) ;
				$nuevafecha = date ( 'd-m-Y' , $nuevafecha );
				echo "<td align=right>".number_format($deuda*$interes,2,".",",")."</td>";
				echo "<td align=right>".number_format($m-($deuda*$interes),2,".",",")."</td>";
 
				$deuda=$deuda-($m-($deuda*$interes));
				if ($deuda<0)
				{
					echo "<td align=right>0</td>";
				}else{
					echo "<td align=right>".number_format($deuda,2,".",",")."</td>";
				}
				
			echo "</tr>";
			
		}
		?>
</table>
	<?php
} else {echo "No tiene prétamos de este tipo";}}
?>
<?php
if ($sitio === 'educativos'){
$query2=sprintf("SELECT * FROM prestamos_educativos WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$row2 = mysql_fetch_assoc($resultado2);
$deuda=$row2['monto'];
$interes=$row2['interes'];
$anos=$row2['plazo'];
$numero_prestamo=$row2['numero_prestamo'];
$fecha_prestamo=$row2['fecha_prestamo'];
$primera_cuota=$row2['primera_cuota'];
$total_pagar=$row2['total_pagar'];
$tipo=$row2['tipo'];$desembolso=$row2['desembolso'];$prestamo_anterior=$row2['prestamo_anterior'];


	// hacemos los calculos...
	?>
	</div>
	<div><h1>Préstamos Educativos</h1></div>
	 <div class="bordes">
	 <?php
if($deuda && $anos && $interes)
{	

	$interes=($interes/100)/12;
	$m=($deuda*$interes*(pow((1+$interes),($anos))))/((pow((1+$interes),($anos)))-1); 
	
	echo "<table class='table-striped' style='width: 100%;'>";
	echo "<tr><td><b>MONTO</b></td><td> RD$ ".number_format($deuda,2,".",",")."</td><td><b>NÚMERO PRÉSTAMO</b></td><td>".$numero_prestamo."</td></tr>";
	echo "<tr><td><b>INTERES</b></td><td>".(($interes*12)*100)."%</td><td><b>FECHA DEL PRÉSTAMO</b></td><td>".$fecha_prestamo."</td></tr>";
	echo "<tr><td><b>PLAZO</b></td><td>".$anos." Meses</td><td><b>PRIMERA CUOTA</b></td><td>".$primera_cuota."</td></tr>";
		echo "<tr><td><b>CUOTA</b></td><td>RD$ ".number_format($m,2,".",",")."</td><td><b>TOTAL A PAGAR</b></td><td>".number_format($total_pagar,2,".",",")."</td></tr>";	echo "<tr><td><b>DESEMBOLSO</b></td><td>RD$ ".number_format($desembolso,2,".",",")."</td><td><b>NO. PRESTAMO ANTERIOR</b></td><td>".$prestamo_anterior."</td></tr>";
	echo "</table>";
	?>
	<div class="table-responsive">
	<table id="tables" class="table" border=1 cellpadding=5 cellspacing=0>
		<tr>
		<th>Pago</th>
			<th>Mes</th>
			<th>Intereses</th>
			<th>Amortización</th>
			<th>Capital Pendiente</th>
		</tr>
		<?php
		// mostramos todos los meses...
		$primera_cuota=date("m-d-Y",strtotime($primera_cuota)); 
		$nuevafecha=$primera_cuota;
		for($i=1;$i<=$anos;$i++)
		{
			echo "<tr>";
			echo "<td align=right>".$i."</td>";
				echo "<td align=right>".$nuevafecha."</td>";
				$nuevafecha = strtotime ( '+'.$i.'month' , strtotime ( $primera_cuota ) ) ;
				$nuevafecha = date ( 'd-m-Y' , $nuevafecha );
				echo "<td align=right>".number_format($deuda*$interes,2,".",",")."</td>";
				echo "<td align=right>".number_format($m-($deuda*$interes),2,".",",")."</td>";
 
				$deuda=$deuda-($m-($deuda*$interes));
				if ($deuda<0)
				{
					echo "<td align=right>0</td>";
				}else{
					echo "<td align=right>".number_format($deuda,2,".",",")."</td>";
				}
			echo "</tr>";
			
		}
		?>
</table>
	<?php
} else {echo "No tiene prétamos de este tipo";}}
?>
<?php
if ($sitio === 'escolares'){
$query2=sprintf("SELECT * FROM prestamos_escolares WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$row2 = mysql_fetch_assoc($resultado2);
$deuda=$row2['monto'];
$interes=$row2['interes'];
$anos=$row2['plazo'];
$numero_prestamo=$row2['numero_prestamo'];
$fecha_prestamo=$row2['fecha_prestamo'];
$primera_cuota=$row2['primera_cuota'];
$total_pagar=$row2['total_pagar'];
$tipo=$row2['tipo'];$desembolso=$row2['desembolso'];$prestamo_anterior=$row2['prestamo_anterior'];


	// hacemos los calculos...
	?>
	</div>
	<div><h1>Préstamos Útiles Escolares</h1></div>
	 <div class="bordes">
	 <?php
if($deuda && $anos && $interes)
{	

	$interes=($interes/100)/12;
	$m=($deuda*$interes*(pow((1+$interes),($anos))))/((pow((1+$interes),($anos)))-1); 
	
	echo "<table class='table-striped' style='width: 100%;'>";
	echo "<tr><td><b>MONTO</b></td><td> RD$ ".number_format($deuda,2,".",",")."</td><td><b>NÚMERO PRÉSTAMO</b></td><td>".$numero_prestamo."</td></tr>";
	echo "<tr><td><b>INTERES</b></td><td>".(($interes*12)*100)."%</td><td><b>FECHA DEL PRÉSTAMO</b></td><td>".$fecha_prestamo."</td></tr>";
	echo "<tr><td><b>PLAZO</b></td><td>".$anos." Meses</td><td><b>PRIMERA CUOTA</b></td><td>".$primera_cuota."</td></tr>";
		echo "<tr><td><b>CUOTA</b></td><td>RD$ ".number_format($m,2,".",",")."</td><td><b>TOTAL A PAGAR</b></td><td>".number_format($total_pagar,2,".",",")."</td></tr>";	echo "<tr><td><b>DESEMBOLSO</b></td><td>RD$ ".number_format($desembolso,2,".",",")."</td><td><b>NO. PRESTAMO ANTERIOR</b></td><td>".$prestamo_anterior."</td></tr>";
	echo "</table>";
	?>
	<div class="table-responsive">
	<table id="tables" class="table" border=1 cellpadding=5 cellspacing=0>
		<tr>
		<th>Pago</th>
			<th>Mes</th>
			<th>Intereses</th>
			<th>Amortización</th>
			<th>Capital Pendiente</th>
		</tr>
		<?php
		// mostramos todos los meses...
		$primera_cuota=date("m-d-Y",strtotime($primera_cuota)); 
		$nuevafecha=$primera_cuota;
		for($i=1;$i<=$anos;$i++)
		{
			echo "<tr>";
			echo "<td align=right>".$i."</td>";
				echo "<td align=right>".$nuevafecha."</td>";
				$nuevafecha = strtotime ( '+'.$i.'month' , strtotime ( $primera_cuota ) ) ;
				$nuevafecha = date ( 'd-m-Y' , $nuevafecha );
				echo "<td align=right>".number_format($deuda*$interes,2,".",",")."</td>";
				echo "<td align=right>".number_format($m-($deuda*$interes),2,".",",")."</td>";
 
				$deuda=$deuda-($m-($deuda*$interes));
				if ($deuda<0)
				{
					echo "<td align=right>0</td>";
				}else{
					echo "<td align=right>".number_format($deuda,2,".",",")."</td>";
				}
			echo "</tr>";
			
		}
		?>
</table>
	<?php
} else {echo "No tiene prétamos de este tipo";}}
?>
<?php
if ($sitio === 'gerenciales'){
$query2=sprintf("SELECT * FROM prestamos_gerenciales WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$row2 = mysql_fetch_assoc($resultado2);
$deuda=$row2['monto'];
$interes=$row2['interes'];
$anos=$row2['plazo'];
$numero_prestamo=$row2['numero_prestamo'];
$fecha_prestamo=$row2['fecha_prestamo'];
$primera_cuota=$row2['primera_cuota'];
$total_pagar=$row2['total_pagar'];
$tipo=$row2['tipo'];$desembolso=$row2['desembolso'];$prestamo_anterior=$row2['prestamo_anterior'];


	// hacemos los calculos...
	?>
	</div>
	<div><h1>Préstamos Gerenciales</h1></div>
	 <div class="bordes">
	 <?php
if($deuda && $anos && $interes)
{	

	$interes=($interes/100)/12;
	$m=($deuda*$interes*(pow((1+$interes),($anos))))/((pow((1+$interes),($anos)))-1); 
	
	echo "<table class='table-striped' style='width: 100%;'>";
	echo "<tr><td><b>MONTO</b></td><td> RD$ ".number_format($deuda,2,".",",")."</td><td><b>NÚMERO PRÉSTAMO</b></td><td>".$numero_prestamo."</td></tr>";
	echo "<tr><td><b>INTERES</b></td><td>".(($interes*12)*100)."%</td><td><b>FECHA DEL PRÉSTAMO</b></td><td>".$fecha_prestamo."</td></tr>";
	echo "<tr><td><b>PLAZO</b></td><td>".$anos." Meses</td><td><b>PRIMERA CUOTA</b></td><td>".$primera_cuota."</td></tr>";
		echo "<tr><td><b>CUOTA</b></td><td>RD$ ".number_format($m,2,".",",")."</td><td><b>TOTAL A PAGAR</b></td><td>".number_format($total_pagar,2,".",",")."</td></tr>";	echo "<tr><td><b>DESEMBOLSO</b></td><td>RD$ ".number_format($desembolso,2,".",",")."</td><td><b>NO. PRESTAMO ANTERIOR</b></td><td>".$prestamo_anterior."</td></tr>";
	echo "</table>";
	?>
	<div class="table-responsive">
	<table id="tables" class="table" border=1 cellpadding=5 cellspacing=0>
		<tr>
		<th>Pago</th>
			<th>Mes</th>
			<th>Intereses</th>
			<th>Amortización</th>
			<th>Capital Pendiente</th>
		</tr>
		<?php
		// mostramos todos los meses...
		$primera_cuota=date("m-d-Y",strtotime($primera_cuota)); 
		$nuevafecha=$primera_cuota;
		for($i=1;$i<=$anos;$i++)
		{
			echo "<tr>";
			echo "<td align=right>".$i."</td>";
				echo "<td align=right>".$nuevafecha."</td>";
				$nuevafecha = strtotime ( '+'.$i.'month' , strtotime ( $primera_cuota ) ) ;
				$nuevafecha = date ( 'd-m-Y' , $nuevafecha );
				echo "<td align=right>".number_format($deuda*$interes,2,".",",")."</td>";
				echo "<td align=right>".number_format($m-($deuda*$interes),2,".",",")."</td>";
 
				$deuda=$deuda-($m-($deuda*$interes));
				if ($deuda<0)
				{
					echo "<td align=right>0</td>";
				}else{
					echo "<td align=right>".number_format($deuda,2,".",",")."</td>";
				}
			echo "</tr>";
			
		}
		?>
</table>
	<?php
} else {echo "No tiene prétamos de este tipo";}}
?>
<?php
if ($sitio === 'prestamo_especial_madres'){
$query2=sprintf("SELECT * FROM prestamo_especial_madres WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$row2 = mysql_fetch_assoc($resultado2);
$deuda=$row2['monto'];
$interes=$row2['interes'];
$anos=$row2['plazo'];
$numero_prestamo=$row2['numero_prestamo'];
$fecha_prestamo=$row2['fecha_prestamo'];
$primera_cuota=$row2['primera_cuota'];
$total_pagar=$row2['total_pagar'];
$tipo=$row2['tipo'];$desembolso=$row2['desembolso'];$prestamo_anterior=$row2['prestamo_anterior'];


	// hacemos los calculos...
	?>
	</div>
	<div><h1>Préstamo Especial Madres</h1></div>
	 <div class="bordes">
	 <?php
if($deuda && $anos && $interes)
{	

	$interes=($interes/100)/12;
	$m=($deuda*$interes*(pow((1+$interes),($anos))))/((pow((1+$interes),($anos)))-1); 
	
	echo "<table class='table-striped' style='width: 100%;'>";
	echo "<tr><td><b>MONTO</b></td><td> RD$ ".number_format($deuda,2,".",",")."</td><td><b>NÚMERO PRÉSTAMO</b></td><td>".$numero_prestamo."</td></tr>";
	echo "<tr><td><b>INTERES</b></td><td>".(($interes*12)*100)."%</td><td><b>FECHA DEL PRÉSTAMO</b></td><td>".$fecha_prestamo."</td></tr>";
	echo "<tr><td><b>PLAZO</b></td><td>".$anos." Meses</td><td><b>PRIMERA CUOTA</b></td><td>".$primera_cuota."</td></tr>";
		echo "<tr><td><b>CUOTA</b></td><td>RD$ ".number_format($m,2,".",",")."</td><td><b>TOTAL A PAGAR</b></td><td>".number_format($total_pagar,2,".",",")."</td></tr>";	echo "<tr><td><b>DESEMBOLSO</b></td><td>RD$ ".number_format($desembolso,2,".",",")."</td><td><b>NO. PRESTAMO ANTERIOR</b></td><td>".$prestamo_anterior."</td></tr>";
	echo "</table>";
	?>
	<div class="table-responsive">
	<table id="tables" class="table" border=1 cellpadding=5 cellspacing=0>
		<tr>
		<th>Pago</th>
			<th>Mes</th>
			<th>Intereses</th>
			<th>Amortización</th>
			<th>Capital Pendiente</th>
		</tr>
		<?php
		// mostramos todos los meses...
		$primera_cuota=date("m-d-Y",strtotime($primera_cuota)); 
		$nuevafecha=$primera_cuota;
		for($i=1;$i<=$anos;$i++)
		{
			echo "<tr>";
			echo "<td align=right>".$i."</td>";
				echo "<td align=right>".$nuevafecha."</td>";
				$nuevafecha = strtotime ( '+'.$i.'month' , strtotime ( $primera_cuota ) ) ;
				$nuevafecha = date ( 'd-m-Y' , $nuevafecha );
				echo "<td align=right>".number_format($deuda*$interes,2,".",",")."</td>";
				echo "<td align=right>".number_format($m-($deuda*$interes),2,".",",")."</td>";
 
				$deuda=$deuda-($m-($deuda*$interes));
				if ($deuda<0)
				{
					echo "<td align=right>0</td>";
				}else{
					echo "<td align=right>".number_format($deuda,2,".",",")."</td>";
				}
			echo "</tr>";
			
		}
		?>
</table>
	<?php
} else {echo "No tiene prétamos de este tipo";}}
?>
<?php
if ($sitio === 'vacacionales'){
$query2=sprintf("SELECT * FROM prestamos_vacacionales WHERE cedula LIKE '$cedula'");
$resultado2=mysql_query($query2);
$row2 = mysql_fetch_assoc($resultado2);
$deuda=$row2['monto'];
$interes=$row2['interes'];
$anos=$row2['plazo'];
$numero_prestamo=$row2['numero_prestamo'];
$fecha_prestamo=$row2['fecha_prestamo'];
$primera_cuota=$row2['primera_cuota'];
$total_pagar=$row2['total_pagar'];
$tipo=$row2['tipo'];$desembolso=$row2['desembolso'];$prestamo_anterior=$row2['prestamo_anterior'];


	// hacemos los calculos...
	?>
	</div>
<div><h1>Préstamos Vacacionales</h1></div>
	 <div class="bordes">
	 <?php
if($deuda && $anos && $interes)
{	

	$interes=($interes/100)/12;
	$m=($deuda*$interes*(pow((1+$interes),($anos))))/((pow((1+$interes),($anos)))-1); 
	
	echo "<table class='table-striped' style='width: 100%;'>";
	echo "<tr><td><b>MONTO</b></td><td> RD$ ".number_format($deuda,2,".",",")."</td><td><b>NÚMERO PRÉSTAMO</b></td><td>".$numero_prestamo."</td></tr>";
	echo "<tr><td><b>INTERES</b></td><td>".(($interes*12)*100)."%</td><td><b>FECHA DEL PRÉSTAMO</b></td><td>".$fecha_prestamo."</td></tr>";
	echo "<tr><td><b>PLAZO</b></td><td>".$anos." Meses</td><td><b>PRIMERA CUOTA</b></td><td>".$primera_cuota."</td></tr>";
		echo "<tr><td><b>CUOTA</b></td><td>RD$ ".number_format($m,2,".",",")."</td><td><b>TOTAL A PAGAR</b></td><td>".number_format($total_pagar,2,".",",")."</td></tr>";	echo "<tr><td><b>DESEMBOLSO</b></td><td>RD$ ".number_format($desembolso,2,".",",")."</td><td><b>NO. PRESTAMO ANTERIOR</b></td><td>".$prestamo_anterior."</td></tr>";
	echo "</table>";
	?>
	<div class="table-responsive">
	<table id="tables" class="table" border=1 cellpadding=5 cellspacing=0>
		<tr>
		<th>Pago</th>
			<th>Mes</th>
			<th>Intereses</th>
			<th>Amortización</th>
			<th>Capital Pendiente</th>
		</tr>
		<?php
		// mostramos todos los meses...
		$primera_cuota=date("m-d-Y",strtotime($primera_cuota)); 
		$nuevafecha=$primera_cuota;
		for($i=1;$i<=$anos;$i++)
		{
			echo "<tr>";
			    echo "<td align=right>".$i."</td>";
				echo "<td align=right>".$nuevafecha."</td>";
				$nuevafecha = strtotime ( '+'.$i.'month' , strtotime ( $primera_cuota ) ) ;
				$nuevafecha = date ( 'd-m-Y' , $nuevafecha );
				echo "<td align=right>".number_format($deuda*$interes,2,".",",")."</td>";
				echo "<td align=right>".number_format($m-($deuda*$interes),2,".",",")."</td>";
 
				$deuda=$deuda-($m-($deuda*$interes));
				if ($deuda<0)
				{
					echo "<td align=right>0</td>";
				}else{
					echo "<td align=right>".number_format($deuda,2,".",",")."</td>";
				}
			echo "</tr>";
			
		}
		?>
</table>
	<?php
} else {echo "No tiene prétamos de este tipo";}}
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