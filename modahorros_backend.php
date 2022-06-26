<?php require_once('Connections/sgstec.php'); 
include('funciones/functions.php');
retornoadmin();
 @$cedula=$_POST['sitio'];
@$sitio2=$_POST['sitio2'];
@$sitio3=$_POST['sitio3'];
@$sitio4=$_POST['sitio4'];
$monto=$_POST["monto"];
$comentario=$_POST["comentario"];
$query30=sprintf("SELECT * FROM usuarios WHERE cedula LIKE '$cedula'");
$resultado30=mysqli_query($sgstec,$query30);
$row30 = mysqli_fetch_assoc($resultado30);
$nombre=$row30['nombre'];
$apellido=$row30['apellido'];
echo "Usted ha seleccionado a $nombre $apellido de cédula $cedula";
if($cedula && $sitio2 && $sitio3 && $monto)
{	

mysqli_query("UPDATE $sitio2 SET $sitio3='$monto' WHERE cedula='$cedula'") or die(mysqli_error());
mysqli_query("UPDATE $sitio2 SET $sitio4='$comentario' WHERE cedula='$cedula'") or die(mysqli_error());
	
echo "El nuevo monto ahorrado para ".$cedula." es ".$monto." Aplicado en la seccion del mes ".$sitio3." de la tabla de año ".$sitio2;

}
 ?>