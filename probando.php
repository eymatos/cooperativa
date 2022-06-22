<?php
$dbuser="cooproco_n";
$dbpass="procon01";
$dbname="cooproco_n";
$chandle = mysqli_connect("localhost", $dbuser, $dbpass) or die("Error conectando a la BBDD");
echo "Conectado correctamente
";
mysqli_select_db($dbname, $chandle) or die ($dbname . " Base de datos no encontrada." . $dbuser);
echo "Base de datos " . $database . " seleccionada";
mysqli_close($chandle);
?>