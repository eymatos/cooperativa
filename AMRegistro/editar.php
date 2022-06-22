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
$editar= $_POST["editar"]; 
$frase = $_POST['frases'];
$query3="SELECT * FROM registro WHERE cedula='$frase'";
$resultado3=mysql_query($query3);
while($row3 = mysql_fetch_array($resultado3)){
$cedula=$row3['cedula'];
$cedula2=$row3['cedula'];
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
$taller=$row3['taller'];


}


	echo '<div id="registro2">
	<div id="formulario2">';
	echo "<h3>Editar Información de Asistente</h3>";
echo '<form name="modificar" action="modificar.php" method="POST" style="margin-top 10px;" class="text-center border border-light p-5">';
echo '<div>
		<p><input class="btn btn-info" class="enviar" type="submit" value="Modificar" name="modificar"></p>
	</div>';
echo '<div class="form-group">
      <label>Cédula En formato (000-0000000-0)</label>
	  <input type="hidden" name="cedula" maxlength=13 class="form-control" value="'.$cedula.'" placeholder="'.$cedula.'">
	  <input type="text" name="cedula2" maxlength=13 class="form-control" value="'.$cedula2.'" placeholder="'.$cedula2.'">      
    </div>';
echo '<div class="form-group">
    <label>Nombre</label>
	<input type="text" name="nombre" class="form-control" value="'.$nombre.'" placeholder="'.$nombre.'"></div>';
echo '<div class="form-group">
<label>Apellido</label>
<input type="text" name="apellido" class="form-control" value="'.$apellido.'" placeholder="'.$apellido.'">
</div>';    
echo '<div class="form-group">
<label>Sexo</label>
<div><input type="text" name="sexo" class="form-control" value="'.$sexo.'" placeholder="'.$sexo.'"></div>
</div>';
echo '<div class="form-group">
<label>Celular</label>
<input type="text" name="celular" class="form-control" value="'.$celular.'" placeholder="'.$celular.'"></div>
<div class="form-group">
<label>Correo Electrónico</label>
<input type="text" name="correo" class="form-control" value="'.$correo.'" placeholder="'.$correo.'">
</div>
<div class="form-group">
<label>Nombre de institución</label>
<input type="text" name="institucion" class="form-control" value="'.$institucion.'" placeholder="'.$institucion.'">
</div>
<div class="form-group">
<label>Tipo de institución</label>
<div><input type="text" name="tipoinstitucion" class="form-control" value="'.$tipoinstitucion.'" placeholder="'.$tipoinstitucion.'"></div>
</div>
<div class="form-group"><label>Cargo que ocupa</label>
<div><input type="text" name="cargo" class="form-control" value="'.$cargo.'" placeholder="'.$cargo.'"></div>
</div>
<div class="form-group">
<label>Regional</label>
<input type="text" name="regional" class="form-control" value="'.$regional.'" placeholder="'.$regional.'"></div>
<div class="form-group"><label>Distrito</label>
<input type="text" name="distrito" class="form-control" value="'.$distrito.'" placeholder="'.$distrito.'"></div>
<div class="form-group">
<label>Redes sociales</label>
<input type="text" name="redes" class="form-control" value="'.$redes.'" placeholder="'.$redes.'"></div>
<div class="form-group">
<label>¿Necesitas alguna asistencia especial?</label>
<div><input type="text" name="asistenciaespecial" class="form-control" value="'.$asistenciaespecial.'" placeholder="'.$asistenciaespecial.'"></div>
</div><div class="form-group"><label>¿Participarás en el Pre- Congreso del viernes 29 de marzo de 830 AM - 100 PM?</label>
<div><input type="text" name="participaras" class="form-control" value="'.$participaras.'" placeholder="'.$participaras.'"></div>
</div><div class="form-group"><label>¿Cómo te enteraste del Congreso 512?</label>
<div><input type="text" name="teenteraste" class="form-control" value="'.$teenteraste.'" placeholder="'.$teenteraste.'"></div>
</div><div class="form-group"><label>¿Participaste en el congreso 512 del 2018?</label>
<div><input type="text" name="participaste" class="form-control" value="'.$participaste.'" placeholder="'.$participaste.'"></div>
</div>
<div class="form-group"><label>¿Deseas recibir notificaciones vía correo electrónico?</label>
<div><input type="text" name="notificaciones" class="form-control" value="'.$notificaciones.'" placeholder="'.$notificaciones.'"></div>
</div>
<div class="form-group"><label>Talleres en los que participa actualmente<br></label>
<div>Los talleres que tiene inscrito actualmente son: '.$taller.'<br><br>Por favor seleccione nueva vez los talleres:<br><br></div>
<div style="text-align:left;"><input type="checkbox" name="taller[]" value="1.Taller Planes de Mejora: Por una Cultura de Mejoramiento Continuo">1.Taller Planes de Mejora: Por una Cultura de Mejoramiento Continuo<br>
<input type="checkbox" name="taller[]" value="2.Taller El Aula como Espacio Creativo Integrador: Una Mirada desde la Enseñanza de la Ciencia">2.Taller El Aula como Espacio Creativo Integrador: Una Mirada desde la Enseñanza de la Ciencia<br>
<input type="checkbox" name="taller[]" value="3.Planificación y Evaluación por Competencias">3.Planificación y Evaluación por Competencias<br>
<input type="checkbox" name="taller[]" value="4.Reunión Coalición Docentes de Excelencia">4.Reunión Coalición Docentes de Excelencia<br>
<input type="checkbox" name="taller[]" value="5.Reunión de Equipos de Gestión Proyecto Fortalecimiento y Expansión Educación Técnica">5.Reunión de Equipos de Gestión Proyecto Fortalecimiento y Expansión Educación Técnica<br>
<input type="checkbox" name="taller[]" value="6.Conferencia Magistral Victoria Zorraquín: Hay Esperanza en la Escuela">6.Conferencia Magistral Victoria Zorraquín: Hay Esperanza en la Escuela<br>
<input type="checkbox" name="taller[]" value="7.Educación, economía y empleo: ¿a qué se enfrentan los maestros en el siglo XXI">7.Educación, economía y empleo: ¿a qué se enfrentan los maestros en el siglo XXI<br>
<input type="checkbox" name="taller[]" value="8.Fundación Varkey, El Diálogo Interamericano, INICIA Educación">8.Fundación Varkey, El Diálogo Interamericano, INICIA Educación<br>
<input type="checkbox" name="taller[]" value="9.BICEPS: Las Seis Virturdes que los Directores de escuela deben tener para liderar el cambio orientado a mejorar el rendimiento escolar">9.BICEPS: Las Seis Virturdes que los Directores de escuela deben tener para liderar el cambio orientado a mejorar el rendimiento escolar<br>
<input type="checkbox" name="taller[]" value="10.Desafío de la escuela en la era digital">10.Desafío de la escuela en la era digital<br>
<input type="checkbox" name="taller[]" value="11.Donde está el Corazón está la Mirada">11.Donde está el Corazón está la Mirada<br>
<input type="checkbox" name="taller[]" value="12.El Docente que Transforma la Sociedad: Teach For America">12.El Docente que Transforma la Sociedad: Teach For America<br>
<input type="checkbox" name="taller[]" value="13.Las Sinergias Positivas entre la escuela pública y la escuela privada">13.Las Sinergias Positivas entre la escuela pública y la escuela privada<br>
<input type="checkbox" name="taller[]" value="14.Pedagogía del Loto. Respirar, pensar, actuar. Educación socioemocional - Mindfullnes, técnicas somáticas, yoga">14.Pedagogía del Loto. Respirar, pensar, actuar. Educación socioemocional - Mindfullnes, técnicas somáticas, yoga<br>
<input type="checkbox" name="taller[]" value="15.Panel de Expertos: Qué se esperar del rol docente">15.Panel de Expertos: Qué se esperar del rol docente<br>
<input type="checkbox" name="taller[]" value="16.La investigación acción como herramienta de innovación y fortalecimiento de la práctica docente">16.La investigación acción como herramienta de innovación y fortalecimiento de la práctica docente<br>
<input type="checkbox" name="taller[]" value="17.Sistema de Mentoría para Docentes Innovadores">17.Sistema de Mentoría para Docentes Innovadores<br>
<input type="checkbox" name="taller[]" value="18.Innovación para la Calidad">18.Innovación para la Calidad<br>
<input type="checkbox" name="taller[]" value="19.El Maestro como fuente de Energía">19.El Maestro como fuente de Energía<br>
<input type="checkbox" name="taller[]" value="20.Competencias Socio Emocionales como base para la Innovación">20.Competencias Socio Emocionales como base para la Innovación<br>
<input type="checkbox" name="taller[]" value="21.Manejo del Stress Docente para generar eficiencia en el proceso pedagógico">21.Manejo del Stress Docente para generar eficiencia en el proceso pedagógico<br>
<input type="checkbox" name="taller[]" value="22.Proyectos Juveniles, Experiencia programa INSPIRACCION - INICIA Educación">22.Proyectos Juveniles, Experiencia programa INSPIRACCION - INICIA Educación<br>
<input type="checkbox" name="taller[]" value="23.Sacando Ideas de un Sombrero">23.Sacando Ideas de un Sombrero<br>
<input type="checkbox" name="taller[]" value="24.El Arte como medio Transformador">24.El Arte como medio Transformador<br>
<input type="checkbox" name="taller[]" value="25.Ingeniería Cognitiva: Del átomo al comportamiento humano. La ciencia de la optimizació">25.Ingeniería Cognitiva: Del átomo al comportamiento humano. La ciencia de la optimizació<br>
<input type="checkbox" name="taller[]" value="26.¿Es posible cambiar el mundo con palabras?">26.¿Es posible cambiar el mundo con palabras?<br>
<input type="checkbox" name="taller[]" value="27.Aprender es Divertido. Ciencias Sociales">27.Aprender es Divertido. Ciencias Sociales<br>
<input type="checkbox" name="taller[]" value="28.La innovación en el Aula de Química">28.La innovación en el Aula de Química<br>
<input type="checkbox" name="taller[]" value="29.La Formación Docente para la Innovación y la Transformación de la Escuela">29.La Formación Docente para la Innovación y la Transformación de la Escuela<br>
<input type="checkbox" name="taller[]" value="30.Portafolio Digital en Educación Secundaria">30.Portafolio Digital en Educación Secundaria<br>
<input type="checkbox" name="taller[]" value="31.Prácticas Innovadoras para la Inclusión en la escuela: La Experiencia de la UNPHU">31.Taller Prácticas Innovadoras para la Inclusión en la escuela: La Experiencia de la UNPHU<br>
<input type="checkbox" name="taller[]" value="32.El Trabajo en Equipo">32.El Trabajo en Equipo<br>
<input type="checkbox" name="taller[]" value="33.Presentación Libro IDEICE y entrega de libro a profesores participantes">33.Presentación Libro IDEICE y entrega de libro a profesores participantes<br>
<input type="checkbox" name="taller[]" value="34.Fondo de Innovación, presentación de proyecto 2019 y premiación nuevos proyectos">34.Fondo de Innovación, presentación de proyecto 2019 y premiación nuevos proyectos</div>';		
echo '</form></div></div>';


?>

</div>

</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>


</body>
</html>
