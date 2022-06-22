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
   #formulario2{
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

<a href='menu.php'  style="margin-right:20px;"><img src="home.png" alt="Imprimir" width="25" />Inicio</a><a href="javascript:history.back(-1);" title="Ir la página anterior" style="margin-right:20px;"><img src="volver.png" width="25" style="
    vertical-align: middle; 
" />Regresar</a><a href="javascript:history.forward(1); " title="Ir la página posterior" style=" margin-right:20px"><img src="adelante.png" width="25" style="
    vertical-align: middle;;" />Adelantar</a>
	
	<?php require("connection.php"); ?>
 



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
$sitio= $_POST["sitio"]; 
$editar= $_POST["editar"]; 
$frase = $_POST['frases'];
$query3="SELECT * FROM registro WHERE cedula='$frase'";
$resultado3=mysql_query($query3);
while($row3 = mysql_fetch_array($resultado3)){
$cedula=$row3['cedula'];
$cedula2=$row3['cedula'];
$nombre=$row3['nombre'];
$apellido=$row3['apellido'];
$institucion=$row3['institucion'];}

if($nombre && $apellido)
{
mysql_query("DELETE FROM $sitio WHERE cedula='$cedula'");
echo "<div>".$nombre." ".$apellido." fue eliminado del taller seleccionado";
}


?>

</div>

</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>


</body>
</html>
