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
	
@$cedula=$_POST['cedula'];
@$cedula2=$_POST['cedula2'];
@$nombre=$_POST['nombre'];
@$apellido=$_POST['apellido'];
@$sexo=$_POST['sexo'];
@$celular=$_POST['celular'];
@$correo=$_POST['correo'];
@$institucion=$_POST['institucion'];
@$tipoinstitucion=$_POST['tipoinstitucion'];
@$cargo=$_POST['cargo'];
@$regional=$_POST['regional'];
@$distrito=$_POST['distrito'];
@$redes=$_POST['redes'];
@$asistenciaespecial=$_POST['asistenciaespecial'];
@$participaras=$_POST['participaras'];
@$teenteraste=$_POST['teenteraste'];
@$participaste=$_POST['participaste'];
@$notificaciones=$_POST['notificaciones'];
@$taller = implode(',', $_POST['taller']);


/*echo $cedula ."ced<br>". $nombre ."nom<br>". $apellido ."ap<br>". $sexo ."sexo<br>". $celular ."cel<br>". $correo ."co<br>". $institucion ."inc<br>". $tipoinstitucion ."tip<br>". $cargos ."car<br>". $cargo ."este es cargo solo<br>". $regional ."reg<br>". $distrito ."dist<br>". $redes ."red<br>". $asistenciaespecials ."asist<br>". $participaras ."part<br>". $teenterastes ."teent<br>". $participaste ."aste<br>". $notificaciones."not";
*/
if($nombre && $apellido)
{
mysql_query("UPDATE registro SET cedula='$cedula2', nombre='$nombre', apellido='$apellido', sexo='$sexo', celular='$celular', correo='$correo', institucion='$institucion', tipoinstitucion='$tipoinstitucion', cargo='$cargo', regional='$regional', distrito='$distrito', redes='$redes', asistenciaespecial='$asistenciaespecial', participaras='$participaras', teenteraste='$teenteraste', participaste='$participaste', notificaciones='$notificaciones', taller='$taller' WHERE cedula='$cedula'") or die(mysql_error());
echo "<div>La modificación de ".$nombre." ".$apellido." fue completada";
echo "<h3>Gracias por su interés en participar en el Congreso 512.</h3>";
echo "Gracias por completar su inscripción. Le esperamos del 29 al 31 de marzo en el Hotel
Crowne Plaza.</div>";	
}


?>
</div>

</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>


</body>
</html>
