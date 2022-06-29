<?php 
require_once('Connections/sgstec.php');
include('funciones/functions.php');
mysqli_query("SET NAMES 'utf8'",$sgstec);
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
<form style="width:75%;" action="backend/prestamoautorizado.php" method="POST" style="margin-top: 10px;">
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

