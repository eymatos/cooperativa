<?php
// conectar al servidor 
$server_link = mysql_connect("localhost", "cooproco_n", "procon01");mysql_query("SET NAMES 'utf8'");
if(!$server_link){
    die("Falló la Conexión ". mysql_error());
}
// seleccionamos la base de datos
$db_selected = mysql_select_db("cooproco_amr", $server_link);
if(!$db_selected){
    die("No se pudo seleccionar la Base de Datos ". mysql_error());mysql_set_charset('utf8');
}
// varificamos que el formulario halla sido enviado
if(isset($_GET['buscar']) && $_GET['buscar'] == 'Buscar'){
    $frase = addslashes($_GET['frase']);
	
$filename = "AMRegistrolabel".date('Ymd') . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename");

    $sqlBuscar = mysql_query("SELECT * FROM registro WHERE cedula LIKE '%$frase%' OR nombre LIKE '%$frase%' OR apellido LIKE '%$frase%' OR sexo LIKE '%$frase%' OR celular LIKE '%$frase%' Or correo LIKE '%$frase%' Or institucion LIKE '%$frase%' Or tipoinstitucion LIKE '%$frase%' Or cargo LIKE '%$frase%' OR regional LIKE '%$frase%' OR distrito LIKE '%$frase%' OR  redes LIKE '%$frase%' OR asistenciaespecial LIKE '%$frase%' OR participaras LIKE '%$frase%' OR teenteraste LIKE '%$frase%' OR  participaste LIKE '%$frase%' OR notificaciones LIKE '%$frase%' ORDER BY nombre", $server_link)
                            or die(mysql_error());
    $totalRows = mysql_num_rows($sqlBuscar);
    // Enviamos un mensaje
    // indicando la cantidad de resultados ($totalRows)
    // para la frase busada ($frase)
    if(!empty($totalRows)){
        // mostramos los resultados
echo "<table border='1' style='background-color: #fff;border: 1px;' >";
while($row = mysql_fetch_array($sqlBuscar)){
$cedula=$row['cedula'];
$nombre=$row['nombre'];
$apellido=$row['apellido'];
$institucion=$row['institucion'];
echo "<tr>";
echo "<td><h3>$cedula</h3></td> ";
echo "<td><h3>$nombre</h3></td> ";
echo "<td><h3>$apellido</h3></td> ";
echo "<td><h3>$institucion</h3></td>";
echo "</tr>";
        }
		echo "</table>";
    }
   // si se ha enviado vacio el formulario
    // mostramos un mensaje del tipo Oops...!
    elseif(empty($_GET['frase'])){
        echo "Debe introducir una palabra o frase.";
    }
    // si no hay resultados //
    elseif($totalRows == 0){
        echo stripslashes("<p>Su busqueda no arrojo resultados para:</p><br> <h1>$frase</h1>");
		 }
}
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />