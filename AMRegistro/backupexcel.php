<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<?php
$server_link = mysql_connect("localhost", "cooproco_n", "procon01");mysql_query("SET NAMES 'utf8'");
if(!$server_link)
{
    die("Falló la Conexión ". mysql_error());
}
// seleccionamos la base de datos
$db_selected = mysql_select_db("cooproco_amr", $server_link);
if(!$db_selected)
{
    die("No se pudo seleccionar la Base de Datos ". mysql_error());mysql_set_charset('utf8');
}	
$query2="SELECT * FROM registro ORDER BY nombre ASC";
$resultado2=mysql_query($query2);


@$sitio=$_POST['sitio'];
if($sitio)
{
$query3="SELECT * FROM registro WHERE cedula='$sitio'";
$resultado3=mysql_query($query3);
$developer_records = array();
while($row3 = mysql_fetch_array($resultado3))
	{
	$developer_records[] = $row3;
	$cedula=$row3['cedula'];
	$nombre=$row3['nombre'];
	$apellido=$row3['apellido'];
	$sexo=$row3['sexo'];
	$celular=$row3['celular'];
	$correo=$row3['correo'];
	$institucion=$row3['institucion'];
	$tipoinstitucion=$row3['tipoinstitucion'];
	$cargo=$row3['cargo'];
	$regional=$row3['regional'];
	$distrito=$row3['distrito'];
	$redes=$row3['redes'];
	$asistenciaespecial=$row3['asistenciaespecial'];
	$participaras=$row3['participaras'];
	$teenteraste=$row3['teenteraste'];
	$participaste=$row3['participaste'];
	$notificaciones=$row3['notificaciones'];
	}
if(isset($_POST["export_data"]))
	{
	$filename = "cooproco_amrlabel".date('Ymd') . ".xls";
	/*header("Content-Type: application/vnd.ms-excel");*/
	header("Content-Disposition: attachment; filename=$filename");

	//en la sigte linea colocar entre comillas el nombre del servidor mysql (generalmente, localhost) 
	$servidor="localhost"; 
	//en la sigte linea colocar entre comillas el nombre de usuario 
	$user="root"; 
	//en la sigte linea colocar entre comillas la contraseña 
	$pass=""; 
	//en la sigte linea colocar entre comillas e nombre de la base de datos 
	$db="cooproco_amr"; 
	//en la sigte linea colocar entre comillas e nombre de la tabla
	$tabla="registro"; 
	mysql_connect($servidor,$user,$pass) ; 
	mysql_set_charset('utf8');
	mysql_select_db($db) ; 
	$qry=mysql_query("select cedula, nombre, apellido, institucion from $tabla where cedula='$cedula'" ) ;
	$campos = mysql_num_fields($qry) ; 
	 
	echo "<table border='1' style='background-color: #fff;border: 1px;' >"; 
	$row=mysql_fetch_array($qry);
		echo "<tr style='width:250px;border: none;vertical-align: middle;'>";
		echo "<td style='width:250px;border: none;vertical-align: middle;text-align:center;'><h3>".$row['cedula']."</h3></td>";	
		echo "<td style='width:250px;border: none;vertical-align: middle;text-align:center;'><h3>".$row['nombre']." ".$row['apellido']."</h3></td>";
		echo "<td style='width:250px;border: none;vertical-align: middle;text-align:center;'><h3>".$row['institucion']."</h3></td>";
		echo "</tr>";	
	echo "</table>";
	}

}
?>