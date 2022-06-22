<html lang="es">
<head><!-- Global site tag (gtag.js) - Google Analytics --><script async src="https://www.googletagmanager.com/gtag/js?id=UA-60738677-4"></script><script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-60738677-4');</script>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" >
	<title>AMRegistro</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css"
	<link href='https://fonts.googleapis.com/css?family=pacifico' rel='stylesheet' type='text/css'>
	<style>
	.jumbotron p {
       margin-left: 20px;
}
.form-control{text-align:center;}
label {
    display: inline-block;
    max-width: 100%;
    font-weight: bold;
    font-size: 1.5rem;
    font-family: Roboto,sans-serif;
    margin-bottom: 1.5rem!important;
    margin-top: 1.5rem!important;
}
body{font-family:Roboto,sans-serif;}
.border-light {
    border-color: #e0e0e0!important;
}
.text-center {
    text-align: center!important;
}
.p-5 {
    padding: 3rem!important;
}
.border-light {
    border-color: #f8f9fa!important;
}
.border {
    border: 1px solid #dee2e6!important;
}
#formulario{
    font-family: Roboto,sans-serif!important;
    font-size: 1.5rem!important;
    font-weight: 500!important;
    width: 50%;
    margin: auto;
    text-align: center;
   padding: 10px;}
	.jumbotron{
		background-color:#ffffff;
		color:#5D0000;
		margin-top:20px;
		padding-left:0!important;
		padding-right:0!important;
		padding-top:0!important;
		padding-bottom:20px!important;
		-webkit-box-shadow: 10px 10px 31px 0px rgba(0,0,0,0.65);
		text-decoration: none;
-moz-box-shadow: 10px 10px 31px 0px rgba(0,0,0,0.65);
box-shadow: 10px 10px 31px 0px rgba(0,0,0,0.65);
	}
	a:active, a:hover {
    outline: 0;
    text-decoration: none!important;
}
	.tab-content{
		border-left: 1px solid #ddd;
		border-right: 1px solid #ddd;
		border-bottom: 1px solid #ddd;
		padding: 10px;
	}
	.nav-tabs{
		margin-bottom:0;
	}
	body{
	background-repeat:no-repeat;}
	td{border-color: black;
    border-style: solid;
    border-width: 1px;
	text-align:center;
	    padding: 5px;}
		
	
	table{font-size: 12px;
		border-color: black;
    border-style: solid;
    border-width: 1px;
	margin-left: 20px;
	margin-right: 20px;
	margin-bottom: 20px;
	padding-bottom:20px;
	width: 95%;}
	tr{border-color: black;
    border-style: solid;
    border-width: 1px;
	}
	#resultados{background:#e8dcdc;
	padding:10px 0;
	margin-bottom:10px;}
	
@media print {
.impre {display:none;
overflow:hidden!important;}
#productos{width:100%;
margin:auto;}
table{width:100%;
margin:auto;}
.titulo{font-size:18px;}
a[href]:after {
content: none !important;}






	</style>


	
</head>
<body  style="background-color: #5d0000;">

<div class="container">
<div class="jumbotron">
<div class="container">
<div class="titulo">
<a href="menu.php"><H1>AMRegistro</H1></a>
</div>
<div class="impre">
<a href="javascript:history.back(-1);" title="Ir la página anterior" style="margin-right:20px;"><img src="volver.png" width="25" style="
    vertical-align: middle; 
" />Regresar</a><a href="javascript:history.forward(1); " title="Ir la página posterior" style=" margin-right:20px"><img src="adelante.png" width="25" style="
    vertical-align: middle;;" />Adelantar</a>
	<a href='javascript:window.print(); void 0;'><img src="print.png" alt="Imprimir" width="25" />Imprimir</a>
	<?php require("connection.php"); ?>
 

<div id="registro">
<div id="formulario">
<label>Selecciona persona para imprimir label:</label>
<form style="margin-top 10px;" class="text-center border border-light p-5" action="excel.php" method="post">
<select style="width:100%;margin:auto;text-align:center;" name="sitio" class="form-control">
<?php
$server_link = mysql_connect("localhost", "cooproco_n", "procon01");mysql_query("SET NAMES 'utf8'");
if(!$server_link){
    die("Falló la Conexión ". mysql_error());
}
// seleccionamos la base de datos
$db_selected = mysql_select_db("cooproco_amr", $server_link);
if(!$db_selected){
    die("No se pudo seleccionar la Base de Datos ". mysql_error());mysql_set_charset('utf8');
}	
$query2="SELECT * FROM registro ORDER BY nombre ASC";
$resultado2=mysql_query($query2);
while ($row2 = mysql_fetch_array($resultado2)):;
?>
<option value="<?php echo $row2[0]; ?>"><?php echo $row2[1]." ".$row2[2]." de cédula: ".$row2[0]; ?></option>
<?php endwhile; ?>
</select>
<br>
<div>
<button type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-info">Exportar a excel</button>
	</div>
</form>
</div>
</div>
<?php
@$sitio=$_POST['sitio'];
if($sitio){
$query3="SELECT * FROM registro WHERE cedula='$sitio'";
$resultado3=mysql_query($query3);
$developer_records = array();
while($row3 = mysql_fetch_array($resultado3)){
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
}
?>
</div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>


</body>
</html>
