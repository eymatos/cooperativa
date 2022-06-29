<?php 
require_once('Connections/sgstec.php');
include('funciones/functions.php');
retornoadmin();
@$sitio=$_GET['sitio'];
@$sitio2=$_GET ['sitio2'];


$queryn=sprintf("SELECT * FROM usuarios where cedula LIKE '$sitio'");
$resultadon=mysqli_query($sgstec,$queryn);
$rown = mysqli_fetch_assoc($resultadon);
$nombre=$rown['nombre'];
$apellido=$rown['apellido'];


echo "<div class='bordes'>";
echo "<tr><table class='table-striped' style='width: 100%;'><td><b>SOCIO:</b></td><td>".$nombre." ".$apellido."</td><td><b>CÉDULA:</b></td><td>".$sitio."</td></table>";
echo "</div>";
if ($sitio2 === 'normales'){
$query2=sprintf("SELECT * FROM prestamos_normales WHERE cedula LIKE '$sitio'");
$resultado2=mysqli_query($sgstec,$query2);
$row2 = mysqli_fetch_assoc($resultado2);
$deuda=$row2['monto'];
$interes=$row2['interes'];
$anos=$row2['plazo'];
$numero_prestamo=$row2['numero_prestamo'];
$fecha_prestamo=$row2['fecha_prestamo'];
$primera_cuota=$row2['primera_cuota'];
$total_pagar=$row2['total_pagar'];
$tipo=$row2['tipo'];$desembolso=$row2['desembolso'];$prestamo_anterior=$row2['prestamo_anterior'];

	 
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

if ($sitio2 === 'educativos'){
$query2=sprintf("SELECT * FROM prestamos_educativos WHERE cedula LIKE '$sitio'");
$resultado2=mysqli_query($sgstec,$query2);
$row2 = mysqli_fetch_assoc($resultado2);
$deuda=$row2['monto'];
$interes=$row2['interes'];
$anos=$row2['plazo'];
$numero_prestamo=$row2['numero_prestamo'];
$fecha_prestamo=$row2['fecha_prestamo'];
$primera_cuota=$row2['primera_cuota'];
$total_pagar=$row2['total_pagar'];
$tipo=$row2['tipo'];$desembolso=$row2['desembolso'];$prestamo_anterior=$row2['prestamo_anterior'];

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

if ($sitio2 === 'prestamo_especial_madres'){
$query2=sprintf("SELECT * FROM prestamo_especial_madres WHERE cedula LIKE '$sitio'");
$resultado2=mysqli_query($sgstec,$query2);
$row2 = mysqli_fetch_assoc($resultado2);
$deuda=$row2['monto'];
$interes=$row2['interes'];
$anos=$row2['plazo'];
$numero_prestamo=$row2['numero_prestamo'];
$fecha_prestamo=$row2['fecha_prestamo'];
$primera_cuota=$row2['primera_cuota'];
$total_pagar=$row2['total_pagar'];
$tipo=$row2['tipo'];$desembolso=$row2['desembolso'];$prestamo_anterior=$row2['prestamo_anterior'];
	?>
	</div>

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

if ($sitio2 === 'escolares'){
$query2=sprintf("SELECT * FROM prestamos_escolares WHERE cedula LIKE '$sitio'");
$resultado2=mysqli_query($sgstec,$query2);
$row2 = mysqli_fetch_assoc($resultado2);
$deuda=$row2['monto'];
$interes=$row2['interes'];
$anos=$row2['plazo'];
$numero_prestamo=$row2['numero_prestamo'];
$fecha_prestamo=$row2['fecha_prestamo'];
$primera_cuota=$row2['primera_cuota'];
$total_pagar=$row2['total_pagar'];
$tipo=$row2['tipo'];$desembolso=$row2['desembolso'];$prestamo_anterior=$row2['prestamo_anterior'];

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

if ($sitio2 === 'gerenciales'){
$query2=sprintf("SELECT * FROM prestamos_gerenciales WHERE cedula LIKE '$sitio'");
$resultado2=mysqli_query($sgstec,$query2);
$row2 = mysqli_fetch_assoc($resultado2);
$deuda=$row2['monto'];
$interes=$row2['interes'];
$anos=$row2['plazo'];
$numero_prestamo=$row2['numero_prestamo'];
$fecha_prestamo=$row2['fecha_prestamo'];
$primera_cuota=$row2['primera_cuota'];
$total_pagar=$row2['total_pagar'];
$tipo=$row2['tipo'];$desembolso=$row2['desembolso'];$prestamo_anterior=$row2['prestamo_anterior'];

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

if ($sitio2 === 'vacacionales'){
$query2=sprintf("SELECT * FROM prestamos_vacacionales WHERE cedula LIKE '$sitio'");
$resultado2=mysqli_query($sgstec,$query2);
$row2 = mysqli_fetch_assoc($resultado2);
$deuda=$row2['monto'];
$interes=$row2['interes'];
$anos=$row2['plazo'];
$numero_prestamo=$row2['numero_prestamo'];
$fecha_prestamo=$row2['fecha_prestamo'];
$primera_cuota=$row2['primera_cuota'];
$total_pagar=$row2['total_pagar'];
$tipo=$row2['tipo'];$desembolso=$row2['desembolso'];$prestamo_anterior=$row2['prestamo_anterior'];

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
