<?php
if(isset($_POST["interes"]))
{
	$_POST["interes"]=str_replace(",",".",$_POST["interes"]);
}
?>
<!DOCTYPE html>
<html>
<head><!-- Global site tag (gtag.js) - Google Analytics --><script async src="https://www.googletagmanager.com/gtag/js?id=UA-60738677-4"></script><script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-60738677-4');</script><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<meta charset="utf-8">
	<title>cálculo de hipotecas/préstamos</title>
</head>
 
<style>
form {width:250px;}
form>div>span {width:100px;display: inline-block;text-align:left;}
form input {width:150px;}
form>div {text-align:center;}
</style>
 
<body>
 
<h1>Cálculo de hipotecas/préstamos</h1>
<?php
@$deuda=$_POST["importe"];
@$anos=$_POST["anos"];
@$interes=$_POST["interes"]; ?>
<form action="prueba.php" method="POST">
	<div>
		<span>Importe :</span>
		<span><input type="text" name="importe" maxlength=9></span>
	</div>
	<div>
		<span>Años :</span>
		<span><input type="text" name="anos" maxlength=2></span>
	</div>
	<div>
		<span>Interés :</span>
		<span><input type="text" name="interes" maxlength=9></span>
	</div>
	<div>
		<p><input type="submit" value="Calcular"></p>
	</div>
</form>
 
<?php

if($deuda && $anos && $interes)
{
	$deuda=$_POST["importe"];
	$anos=$_POST["anos"];
	$interes=$_POST["interes"];
 
	// hacemos los calculos...
	$interes=($interes/100)/12;
	$m=($deuda*$interes*(pow((1+$interes),($anos*12))))/((pow((1+$interes),($anos*12)))-1);
 
	echo "<div>Capital Inicial: ".number_format($deuda,2,".",",")." RD$";
	echo "<br>Cuota a pagar mensualmente: ".number_format($m,2,".",",")." RD$</div>";
	?>
	<table border=1 cellpadding=5 cellspacing=0>
		<tr>
			<th>Mes</th>
			<th>Intereses</th>
			<th>Amortización</th>
			<th>Capital Pendiente</th>
		</tr>
		<?php
		// mostramos todos los meses...
		for($i=1;$i<=$anos*12;$i++)
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

	<?php
}
?>
 
</body>
</html>