<?php require_once('Connections/sgstec.php'); ?>
<?php
include('funciones/functions.php');
retornoadmin();
@$cedula=$_POST['sitio'];
@$sitio2=$_POST['sitio2'];
@$monto=$_POST['monto'];
@$interes=$_POST['interes'];
@$plazo=$_POST['plazo'];
@$numero_prestamo=$_POST['numero_prestamo'];
@$fecha_prestamo=$_POST['fecha_prestamo'];
@$primera_cuota=$_POST['primera_cuota'];
@$total_pagar=$_POST['total_pagar'];
@$tipo=$_POST['tipo'];
@$desembolso=$_POST['desembolso'];
@$prestamo_anterior=$_POST['prestamo_anterior'];


mysqli_query($sgstec,"INSERT INTO $sitio2 (cedula, monto, interes, plazo, numero_prestamo, fecha_prestamo, primera_cuota, total_pagar, tipo, desembolso, prestamo_anterior) VALUES ('$cedula', '$monto', $interes, $plazo, '$numero_prestamo','$fecha_prestamo', '$primera_cuota', '$total_pagar', '$sitio2', $desembolso, '$prestamo_anterior')");

echo "El prestamo ".$tipo." de #: ".$numero_prestamo." ha sido creado, por el monto de ".$monto." al socio de cedula ".$cedula." ";

?>