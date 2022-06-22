<?php require_once('Connections/sgstec.php'); ?>
<?php
include('funciones/functions.php');
//initialize the session

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
 <div id="menu"><?php sidemenu2();?></div>		
        <div id="contenido">
		<?php

@$deuda=$_POST["importe"];
@$anos=$_POST["anos"];
@$interes=$_POST["interes"];
?>
<div id="Préstamo">
<h1>Cálculo de préstamos</h1>
<form action="calculo2.php" method="POST" style="margin-top: 10px;">
	<div class="formulario">
		<span><b>Importe</b> :</span>
		<span><input type="text" name="importe" maxlength=9></span>
	</div>
	<br><br>
	<div class="formulario">
		<span><b>Meses</b> :</span>
		<span><input type="text" name="anos" maxlength=2></span>
	</div>
	<br><br>
	<div class="formulario">
		<span><b>Interés</b> :</span>
		<span><input type="text" name="interes"  value="18" maxlength=9></span>
	</div>
	<br><br><br>
	<div>
		<p><input class="enviar" type="submit" value="CALCULAR"></p>
	</div>
</form>
</div>
 <div class="bordes">
<?php

if($deuda && $anos && $interes)
{
	$deuda=$_POST["importe"];
	$anos=$_POST["anos"];
	$interes=$_POST["interes"];
	
 
	// hacemos los calculos...
	$interes=($interes/100)/12;
	$m=($deuda*$interes*(pow((1+$interes),($anos))))/((pow((1+$interes),($anos)))-1);
 
	echo "<div>Capital Inicial: ".number_format($deuda,2,".",",")." RD$";
	echo "<br>Cuota a pagar mensualmente: ".number_format($m,2,".",",")." RD$</div>";
	?>
	<div class="table-responsive">
	<table id="tables" class="table" border=1 cellpadding=5 cellspacing=0>
		<tr>
			<th>Mes</th>
			<th>Intereses</th>
			<th>Amortización</th>
			<th>Capital Pendiente</th>
		</tr>
		<?php
		// mostramos todos los meses...
		for($i=1;$i<=$anos;$i++)
		{
			echo "<tr>";
				echo "<td align=right>".$i."</td>";
				
				echo "<td align=right>".number_format($deuda*$interes,2,",",".")."</td>";
				echo "<td align=right>".number_format($m-($deuda*$interes),2,",",".")."</td>";
 
				$deuda=$deuda-($m-($deuda*$interes));
				if ($deuda<0)
				{
					echo "<td align=right>0</td>";
				}else{
					echo "<td align=right>".number_format($deuda,2,",",".")."</td>";
				}
			echo "</tr>";
		}
		?>
	</table>
	<a href='javascript:window.print(); void 0;'>Imprimir</a>
	</div>

	<?php
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
