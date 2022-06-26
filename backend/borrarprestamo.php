<?php 
require_once('Connections/sgstec.php');
include('funciones/functions.php');
@$cedula=$_GET['sitio'];
@$sitio2=$_GET['sitio2'];

retornoadmin();

if($cedula && $sitio2)
{	
	mysqli_query($sgstec,"Delete from $sitio2 WHERE cedula='$cedula'") or die(mysqli_error());
	echo "El préstamos de cedula: ".$cedula." ha sido eliminado correctamente";
}
 ?>