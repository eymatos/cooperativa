<?php require_once('Connections/sgstec.php'); 
include('funciones/functions.php');
retornoadmin();
//initialize the session
 @$cedula=$_POST['sitio'];
@$guia=$_POST['guia'];
$query30=sprintf("SELECT * FROM usuarios WHERE cedula LIKE '$sitio'");
$resultado30=mysqli_query($sgstec,$query30);
$row30 = mysqli_fetch_assoc($resultado30);
$nombre=$row30['nombre'];
$apellido=$row30['apellido'];
echo "Usted ha seleccionado a $nombre $apellido de cédula $sitio";
if($cedula)
{	

mysqli_query("UPDATE usuarios SET guia='$guia' WHERE cedula='$cedula'") or die(mysqli_error());
	
echo "El monto de aporte mensual para ".$cedula." ha sido modificado a ".$guia." ";

}
 ?>