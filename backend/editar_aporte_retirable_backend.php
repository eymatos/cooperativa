<?php require_once('Connections/sgstec.php');
include('funciones/functions.php');
retornoadmin();
//initialize the session
@$cedula=$_POST['sitio'];
@$guia_reti=$_POST['guia_reti'];
$query30=sprintf("SELECT * FROM usuarios WHERE cedula LIKE '$cedula'");
$resultado30=mysqli_query($sgstec,$query30);
$row30 = mysqli_fetch_assoc($resultado30);
$nombre=$row30['nombre'];
$apellido=$row30['apellido'];
echo "Usted ha seleccionado a $nombre $apellido de cédula $cedula";
if($cedula)
{	

mysqli_query("UPDATE usuarios SET guia_reti='$guia_reti' WHERE cedula='$cedula'") or die(mysqli_error());
	
echo "El monto de aporte mensual para ".$cedula." ha sido modificado a ".$guia_reti." ";

}
 ?>