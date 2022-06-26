<?php require_once('Connections/sgstec.php');
include('funciones/functions.php');

@$deuda=$_POST["importe"];
@$anos=$_POST["anos"];
@$interes=$_POST["interes"];
?>
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