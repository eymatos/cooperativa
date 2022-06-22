<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Puerto_Rico');
require_once('Connections/sgstec.php'); 


/**
 *
 * Valida un email usando funciones de manejo de strings. 
 *  Devuelve true si es correcto o false en caso contrario
 *
 * @param    string  $str la dirección a validar
 * @return   boolean
 *
 */

// seleccionamos la base de datos

$cedula= $_GET["cedula"];
$password = "coo123procon";
$pass=md5($password);

if ($cedula & $pass){
$server_link = mysqli_connect("localhost", "cooproco_n", "procon01","cooproco_n");
$query="UPDATE `usuarios` SET `clave`='$pass' WHERE `cedula`='$cedula'";

mysqli_query($server_link,$query);

	$mensaje = 'Su password fue actualizado con exito. Su nueva clave de acceso temporal es coo123procon';
	$status = True;

	
}
else {
		$mensaje = 'La contraseña o cedula son incorrectas.';
	$status = False;
}

echo $mensaje;
echo "<div><a href='index.php'>Regresar a portada</a></div>";

 ?>