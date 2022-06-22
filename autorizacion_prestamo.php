<?php require_once('Connections/sgstec.php'); ?>
<?php
include('funciones/functions.php');
//initialize the session
mysql_query("SET NAMES 'utf8'",$sgstec);
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
$query_sexo = sprintf("SELECT id,nombre, apellido, sexo FROM usuarios WHERE cedula = %s", GetSQLValueString($colname_sexo, "text"));
$sexo = mysql_query($query_sexo, $sgstec) or die(mysql_error());
$row_sexo = mysql_fetch_assoc($sexo);
$totalRows_sexo = mysql_num_rows($sexo);
$_SESSION['id'] = $row_sexo['id'];
?>
<?php
if(isset($_POST['submit']) && !empty($_POST['submit'])) {
@$cedula_garante='';
@$nombre_garante='';
@$departamento_garante='';
@$celular_garante='';
@$sueldo_garante='';
@$cantidad_garante='';
@$cedula=$_POST['cedula'];
@$nombre=$_POST['nombre'];
@$departamento=$_POST['departamento'];
@$celular=$_POST['celular'];
@$sueldo=$_POST['sueldo'];
@$cantidad=$_POST['cantidad'];
@$destino=$_POST['destino'];
@$cedula_garante=$_POST['cedula_garante'];
@$nombre_garante=$_POST['nombre_garante'];
@$departamento_garante=$_POST['departamento_garante'];
@$celular_garante=$_POST['celular_garante'];
@$sueldo_garante=$_POST['sueldo_garante'];
@$cantidad_garante=$_POST['cantidad_garante'];
@$anterior=$_POST['anterior'];
@$prestamo=$_POST['prestamo'];
$fecha = date ('d-m-Y');
if ($prestamo==='Préstamo Normal'){$normal='X';}
if ($prestamo==='Préstamo Educativo'){$educativo='X';}
if ($prestamo==='Préstamo útiles escolares'){$utiles='X';}
if ($prestamo==='Préstamo vacacional'){$vacacional='X';}
if ($prestamo==='Préstamo especial'){$especial='X';}
if ($prestamo==='Préstamo gerencial'){$gerencial='X';}
if($cedula && $nombre && $fecha)
{	
$to = "yuly.mercedes@proconsumidor.gob.do, alexander.german@proconsumidor.gob.do, suleika.baez@proconsumidor.gob.do, suleikabaezs8253@gmail.com";
//$to = "esleidinmatos@gmail.com";
$subject = "SOLICITUD DE PRÉSTAMO $nombre";
$message = "<html><body>
<div style='text-align:center;width:720px;height:960px;border:solid gray 1px;padding:20px;    display: inline-block;font-size:12px;'>
	<p><h3>Cooperativa de Ahorros, Créditos y Servicios Múltiples de los Empleados del
	Instituto Nacional de Protección de los Derechos del Consumidor
	COOPROCON</h3></p>
	<p>RNC: 4-30-14783-4</p>
	<p><h4>SOLICITUD DE PRÉSTAMO</h4></p>
	<table style='width:100%;text-align:left;'><tr><td>Número______________</td><td>Fecha:<span style='text-decoration: underline;'>$fecha</span></td></tr></table>
	<p style='width:100%;padding:5px;'><h3>Datos del solicitante</h3></p>
	<table style='width:100%;border:solid 1px gray;padding:5px;text-align:left;' border='1'>
	<tr><td><b>Nombre completo:</b></td><td>$nombre</td><td><b>Cédula:</b></td><td>$cedula</td></tr>
	<tr><td><b>Departamento:</b></td><td>$departamento</td><td><b>Celular:</b></td><td>$celular</td></tr>
	<tr><td><b>Sueldo RD$:</b></td><td>$sueldo</td><td><b>Cantidad solicitada  RD$:</b></td><td>$cantidad</td></tr>
	<tr><td><b>Destino del préstamo:</b></td><td>$destino</td><td><b>Préstamo anterior:</b></td><td>$anterior</td></tr>
	</table>
	<p style='text-align:right:'>Firma: <span style='text-decoration: underline;'>$nombre</span></p>
	<p style='width:100%;padding:5px;'><h3>Datos del garante</h3></p>
	<table style='width:100%;border:solid 1px gray;text-align:left;' border='1'>

	<tr><td style='width:20%;'><b>Nombre completo:</b></td><td style='width:30%;'>$nombre_garante</td><td style='width:20%;'><b>Cédula:</b></td><td style='width:30%;'>$cedula_garante</td></tr>
	<tr><td style='width:20%;'><b>Departamento:</b></td><td style='width:30%;'>$departamento_garante</td><td style='width:20%;'><b>Celular:</b></td><td style='width:30%;'>$celular_garante</td></tr>
	<tr><td style='width:20%;'><b>Sueldo RD$:</b></td><td style='width:30%;'>$sueldo_garante</td><td><b style='width:20%;'>Cantidad en garantía  RD$:</b></td><td style='width:30%;'>$cantidad_garante</td></tr>
	</table>
	<p style='text-align:right:'>Firma: <span style='text-decoration: underline;'>$nombre_garante</span></p><br>

	<div style='text-align:center;background:#d9d6d6;border:solid gray 1px;'>Para ser llenado por la administración de la Cooperativa</div>

	<div style='width:100%;text-align:left;'>
	<table style='width:100%;border:solid 1px gray;' border='1'>
	<tr style='heigth:5px;><td style='width:20%;'><b>Tipo de préstamo</b></td><td style='width:20%;border:none;'></td><td style='width:25%;'>Ahorro acumulado</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Normal</td><td style='width:20%;text-align:center;'><b>$normal</b></td><td style='width:25%;'>Ahorro mensual</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Gerencial</td><td style='width:20%;text-align:center;'><b>$gerencial</b></td><td style='width:25%;'>Saldo anterior RD$</td style='width:35%;'><td></td></tr>
	<tr><td style='width:20%;'>Vacacional</td><td style='width:20%;text-align:center;'><b>$vacacional</b></td><td style='width:25%;'>Capital</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Educativo</td><td style='width:20%;text-align:center;'><b>$educativo</b></td><td style='width:25%;'>Interés</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Útiles Escolares</td><td style='width:20%;text-align:center;'><b>$utiles</b></td><td style='width:25%;'>Gasto administrativo</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Especial</td><td style='width:20%;text-align:center;'><b>$especial</b></td><td style='width:25%;'>Total a saldar</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;border:none;'></td><td style='width:20%;border:none;'></td><td style='width:25%;'>Cantidad cuotas</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;text-align:center;'><b>Comité de crédito</b></td><td style='width:20%;border:none;'></td><td style='width:25%;'>Monto cuotas</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Firma</td><td style='width:20%;'></td><td style='width:25%;'>Fecha primera cuota</td><td style='width:35%;'></td></tr>
	<tr><td style='width:20%;'>Fecha de aprobación</td><td style='width:20%;'></td><td style='width:25%;'>Monto entregado</td><td style='width:35%;'></td></tr>
	</table>
	</div>
</div></body></html>";
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "Bcc: alexandermercedes@gmail.com" . "\r\n"; // esto sería copia oculta
mail($to, $subject, $message, $headers);
?>
<script>
alert('Estimado socio, tu solicitud ha sido enviada con éxito. Un personal de la cooperativa se pondrá en contacto contigo para completar el proceso. Sera direccionado al Formulario de Autorización de Descuento de Préstamo, Gracias por ser parte de nuestra familia COOPROCON.');
</script>
<?php
}
}



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


</head>

<body onload="cargar_funciones(<?php echo $row_sexo['id']; ?>)">
<header>
	<div id="secondbox">
    	<a href="index.php"><div id="logo" class="fleft"></div></a>
        <?php encabezados();?>
<div class="fright">
  
        </div>
    
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

<h1>Autorización de descuento por préstamos</h1>
<br>
<form style="width:75%;" action="prestamoautorizado.php" method="POST" style="margin-top: 10px;">
	<div class="formulario2">
	<p>
<span> Seleccione el tipo de préstamo:</span>
<select name="prestamo" required>
<option value="Préstamo Normal">Préstamo Normal</option>
<option value="Préstamo Educativo">Préstamo Educativo</option>
<option value="Préstamo útiles escolares">Préstamo útiles escolares</option>
<option value="Préstamo vacacional">Préstamo vacacional</option>
<option value="Préstamo Especial">Préstamo Especial</option>
<option value="Préstamo gerencial">Préstamo gerencial</option>
</select></p>
<br>
<span style="width:100%; text-align: justify;">Yo <input type="text" name="nombre" > de cédula No. <input type="text" name="cedula" maxlength=13 >,
en mi calidad de socio de la Cooperativa
de Ahorros, Créditos y Servicios Múltiples de los empleados de Pro Consumidor,
(COOPROCON), informo que he adquirido un préstamo en dicha cooperativa, del tipo indicado al inicio, y autorizo formalmente a PROCONSUMIDOR, a descontar de mi salario y entregar a dicha cooperativa, según la siguiente descripción:</span>
<br><br>
<p style="text-align:left;">Monto de las cuotas RD$: <input type="text" name= "cuota" onchange="MASK(this,this.value,'-##,###,##0.00',1)"></p><br>
<p style="text-align:left;">Cantidad de cuotas: <input type="text" name="cantidad_cuotas" ></p><br>
<p style="text-align:left;">A partir del mes de: <input type="text" name="mes" style="margin-right:5px;">del año<input type="text" name="ano" ></p><br>
<p style="text-align:left;border:solid 1px black;padding:5px;"><b>NOTA:</b> Si al momento de mi desvinculación de la Institución queda algún compromiso de pago,
autorizo a PROCONSUMIDOR a descontarlo de mis prestaciones y entregar a la Cooperativa
dicho monto.</p>
<br><br>

	</div>

		<br><br><br>
	<div>
		<p><input class="enviar" type="submit" value="Autorizar" name="submit"></p>
	</div>
</form>
<script>
// formatea un numero según una mascara dada ej: "-$###,###,##0.00"
//
// elm   = elemento html <input> donde colocar el resultado
// n     = numero a formatear
// mask  = mascara ej: "-$###,###,##0.00"
// force = formatea el numero aun si n es igual a 0
//
// La función devuelve el numero formateado

function MASK(form, n, mask, format) {
  if (format == "undefined") format = false;
  if (format || NUM(n)) {
    dec = 0, point = 0;
    x = mask.indexOf(".")+1;
    if (x) { dec = mask.length - x; }

    if (dec) {
      n = NUM(n, dec)+"";
      x = n.indexOf(".")+1;
      if (x) { point = n.length - x; } else { n += "."; }
    } else {
      n = NUM(n, 0)+"";
    } 
    for (var x = point; x < dec ; x++) {
      n += "0";
    }
    x = n.length, y = mask.length, XMASK = "";
    while ( x || y ) {
      if ( x ) {
        while ( y && "#0.".indexOf(mask.charAt(y-1)) == -1 ) {
          if ( n.charAt(x-1) != "-")
            XMASK = mask.charAt(y-1) + XMASK;
          y--;
        }
        XMASK = n.charAt(x-1) + XMASK, x--;
      } else if ( y && "$0".indexOf(mask.charAt(y-1))+1 ) {
        XMASK = mask.charAt(y-1) + XMASK;
      }
      if ( y ) { y-- }
    }
  } else {
     XMASK="";
  }
  if (form) { 
    form.value = XMASK;
    if (NUM(n)<0) {
      form.style.color="#FF0000";
    } else {
      form.style.color="#000000";
    }
  }
  return XMASK;
}

// Convierte una cadena alfanumérica a numérica (incluyendo formulas aritméticas)
//
// s   = cadena a ser convertida a numérica
// dec = numero de decimales a redondear
//
// La función devuelve el numero redondeado

function NUM(s, dec) {
  for (var s = s+"", num = "", x = 0 ; x < s.length ; x++) {
    c = s.charAt(x);
    if (".-+/*".indexOf(c)+1 || c != " " && !isNaN(c)) { num+=c; }
  }
  if (isNaN(num)) { num = eval(num); }
  if (num == "")  { num=0; } else { num = parseFloat(num); }
  if (dec != undefined) {
    r=.5; if (num<0) r=-r;
    e=Math.pow(10, (dec>0) ? dec : 0 );
    return parseInt(num*e+r) / e;
  } else {
    return num;
  }
}
</script>



</div>
</div>
</section>
<footer>
<center style="background:#232F3E;color:white;font-weight:bold;">© 2021 COOPROCON</center>
<div id="footer"></div></footer> 
</body>
</html>

