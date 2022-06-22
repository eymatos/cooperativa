<html lang="es">
<head><!-- Global site tag (gtag.js) - Google Analytics --><script async src="https://www.googletagmanager.com/gtag/js?id=UA-60738677-4"></script><script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-60738677-4');</script>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content=width = device-width, initial-scale = 1">
	<title>AMRegistro</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css"
	<link href='https://fonts.googleapis.com/css?family=pacifico' rel='stylesheet' type='text/css'>
	<style>
	.jumbotron p {
       margin-left: 20px;
}
.escondido{display:none;
width:160px;}
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
	    padding: 5px;
		    font-size: 0.6vw;}
		
	
	table{font-size: 12px;
		border-color: black;
    border-style: solid;
    border-width: 1px;
	
	margin-bottom: 20px;
	padding-bottom:20px;
	width: 100%;}
	tr{border-color: black;
    border-style: solid;
    border-width: 1px;
	}
	#resultados{background:#e8dcdc;
	padding:10px 0;
	margin-bottom:10px;}
	
@media print {
	.escondido{display: table-cell;
width:160px;}


.impre {display:none;
overflow:hidden!important;}
#productos{width:100%;
margin:auto;}
table{width:100%;
margin:auto;}
.titulo{font-size:18px;}
a[href]:after {
content: none !important;}
@media screen and (max-width: 600px) {
       table {
           width:100%;
       }
       thead {
           display: none;
       }
       tr:nth-of-type(2n) {
           background-color: inherit;
       }
       tr td:first-child {
           background: #f0f0f0;
           font-weight:bold;
           font-size:1.3em;
       }
       tbody td {
           display: block;
           text-align:center;
       }
       tbody td:before {
           content: attr(data-th);
           display: block;
           text-align:center;
       }
}

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
<a href='menu.php'  style="margin-right:20px;"><img src="home.png" alt="Imprimir" width="25" />Inicio</a><a href="javascript:history.back(-1);" title="Ir la pagina anterior" style="margin-right:20px;"><img src="volver.png" width="25" style="
    vertical-align: middle; 
" />Regresar</a><a href="javascript:history.forward(1); " title="Ir la pagina posterior" style=" margin-right:20px"><img src="adelante.png" width="25" style="
    vertical-align: middle;" />Adelantar</a>
	<a href='javascript:window.print(); void 0;'><img src="print.png" alt="Imprimir" width="25" />Imprimir</a>
	<?php require("connection.php"); ?>
 
<h3>Consulta e imprime reportes</h3>
<div id="buscar">
<form class="navbar-form" name="buscar" action="<?php $_SERVER['PHP_SELF'] ?>" method="get">
<div class="form-group input-group">
   <input type="text" placeholder="Buscar" class="form-control" value="" name="frase" >
   <div class="input-group-btn">
   <button type="submit" name="buscar" value="Buscar" class="btn btn-default" style="font-size: 20px;color:#5D0000;">
   <span class="glyphicon glyphicon-search"></span>
   </button>
   </div>
   </div>

</form>
</div>
<!--
<div id="filtros" style="float:right;">
<strong>Ordenar Tabla: </strong> <form action="consultar.php" method="post"><select name="filtro"><option value="todos">Todos</option><option value="recientes">Mas Recientes</option><option value="antiguos">Mas Antiguos</option><option value="caros">Alfabeticamente descendentes</option><option value="economicos">Alfabeticamente ascendentes</option><option value="sector">Por Sector</option></select> <button type="submit">Filtrar</button></form>
</div>
-->
</div>
</div>
<div id="productos">
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
    // hacemos la consulta de busqueda
    // ver explicación mas abajo
    $sqlBuscar = mysql_query("SELECT * FROM registro WHERE cedula LIKE '%$frase%' OR nombre LIKE '%$frase%' OR apellido LIKE '%$frase%' OR sexo LIKE '%$frase%' OR celular LIKE '%$frase%' Or correo LIKE '%$frase%' Or institucion LIKE '%$frase%' Or tipoinstitucion LIKE '%$frase%' Or cargo LIKE '%$frase%' OR regional LIKE '%$frase%' OR distrito LIKE '%$frase%' OR  redes LIKE '%$frase%' OR asistenciaespecial LIKE '%$frase%' OR participaras LIKE '%$frase%' OR teenteraste LIKE '%$frase%' OR  participaste LIKE '%$frase%' OR notificaciones LIKE '%$frase%' OR taller LIKE '%$frase%' ORDER BY nombre", $server_link)
                            or die(mysql_error());
    $totalRows = mysql_num_rows($sqlBuscar);
    // Enviamos un mensaje
    // indicando la cantidad de resultados ($totalRows)
    // para la frase busada ($frase)
    if(!empty($totalRows)){
		echo "<div id='resultados'>";
	
        echo stripslashes("<p style='margin-left=20px;'>Su b&uacute;squeda arroj&oacute; <strong>$totalRows</strong> resultados para:</p> <H2>$frase</H2>");
	
        // mostramos los resultados
		echo "<center><table style='width:100%;' class='table-striped'>
		<tr>
			<td><b>No.</b></td>
			<td style='width:100px;'><b>Cédula</b></td>
			<td><b>Nombre</b></td>
			<td><b>Apellido</b></td>
			<td class='impre'><b>Sexo</b></td>
			<td class='impre' style='width:100px;'><b>Celular</b></td>
			<td class='impre'><b>Correo Electrónico</b></td>
			<td><b>Nombre de institución</b></td>
			<td class='impre'><b>Tipo de institución</b></td>
			<td class='impre'><b>Cargo que ocupa</b></td>
			<td class='impre'><b>Regional</b></td>
			<td class='impre'><b>Distrito</b></td>			
			<td class='impre' style='width:20px;'><b>Redes sociales</b></td>
			<td class='impre'><b>¿Necesitas alguna asistencia especial?</b></td>
			<td class='impre'><b>¿Participarás en el Pre- Congreso?</b></td>
			<td class='impre'><b>¿Cómo te enteraste del Congreso 512?</b></td>
			<td class='impre'><b>¿Participaste en el congreso 512 del 2018?</b></td>
			<td class='impre'><b>¿Deseas recibir notificaciones vía correo electrónico?</b></td>
			<td class='impre'><b>Talleres en los que participa</b></td>
			<td class='escondido'><b>Firma</b></td>
			</tr>";
			$i=1;
        while($row = mysql_fetch_array($sqlBuscar)){
$cedula=$row['cedula'];
global $cedcont;
$cedcont=$cedula;
$nombre=$row['nombre'];
$apellido=$row['apellido'];
$sexo=$row['sexo'];
$celular=$row['celular'];
$correo=$row['correo'];
$institucion=$row['institucion'];
$tipoinstitucion=$row['tipoinstitucion'];
$cargo=$row['cargo'];
$regional=$row['regional'];
$distrito=$row['distrito'];
$redes=$row['redes'];
$asistenciaespecial=$row['asistenciaespecial'];
$participaras=$row['participaras'];
$teenteraste=$row['teenteraste'];
$participaste=$row['participaste'];
$notificaciones=$row['notificaciones'];
$consultataller1 = mysql_query("SELECT * FROM planes_mejora WHERE cedula='$cedula'", $server_link);
$filastaller1 = mysql_num_rows($consultataller1);
$consultataller2 = mysql_query("SELECT * FROM aula_creativo WHERE cedula='$cedula'", $server_link);
$filastaller2 = mysql_num_rows($consultataller2);
$consultataller3 = mysql_query("SELECT * FROM planificacion_evaluacion WHERE cedula='$cedula'", $server_link);
$filastaller3 = mysql_num_rows($consultataller3);
$consultataller4 = mysql_query("SELECT * FROM coalicion_docentes WHERE cedula='$cedula'", $server_link);
$filastaller4 = mysql_num_rows($consultataller4);
$consultataller5 = mysql_query("SELECT * FROM gestion_proyecto WHERE cedula='$cedula'", $server_link);
$filastaller5 = mysql_num_rows($consultataller5);
$consultataller6 = mysql_query("SELECT * FROM victoria_zorraquin WHERE cedula='$cedula'", $server_link);
$filastaller6 = mysql_num_rows($consultataller6);
$consultataller7 = mysql_query("SELECT * FROM educacion_economia WHERE cedula='$cedula'", $server_link);
$filastaller7 = mysql_num_rows($consultataller7);
$consultataller8 = mysql_query("SELECT * FROM fundacion_varkey WHERE cedula='$cedula'", $server_link);
$filastaller8 = mysql_num_rows($consultataller8);
$consultataller9 = mysql_query("SELECT * FROM biceps WHERE cedula='$cedula'", $server_link);
$filastaller9 = mysql_num_rows($consultataller9);
$consultataller10 = mysql_query("SELECT * FROM desafio_escuela WHERE cedula='$cedula'", $server_link);
$filastaller10 = mysql_num_rows($consultataller10);
$consultataller11 = mysql_query("SELECT * FROM corazon_mirada WHERE cedula='$cedula'", $server_link);
$filastaller11 = mysql_num_rows($consultataller11);
$consultataller12 = mysql_query("SELECT * FROM transforma_sociedad WHERE cedula='$cedula'", $server_link);
$filastaller12 = mysql_num_rows($consultataller12);
$consultataller13 = mysql_query("SELECT * FROM sinergias_positivas WHERE cedula='$cedula'", $server_link);
$filastaller13 = mysql_num_rows($consultataller13);
$consultataller14 = mysql_query("SELECT * FROM pedagogia_loto WHERE cedula='$cedula'", $server_link);
$filastaller14 = mysql_num_rows($consultataller14);
$consultataller15 = mysql_query("SELECT * FROM accion_herramienta WHERE cedula='$cedula'", $server_link);
$filastaller15 = mysql_num_rows($consultataller15);
$consultataller16 = mysql_query("SELECT * FROM mentoria_docentes WHERE cedula='$cedula'", $server_link);
$filastaller16 = mysql_num_rows($consultataller16);
$consultataller17 = mysql_query("SELECT * FROM innovacion_calidad WHERE cedula='$cedula'", $server_link);
$filastaller17 = mysql_num_rows($consultataller17);
$consultataller18 = mysql_query("SELECT * FROM maestro_energia WHERE cedula='$cedula'", $server_link);
$filastaller18 = mysql_num_rows($consultataller18);
$consultataller19 = mysql_query("SELECT * FROM socio_emocionales WHERE cedula='$cedula'", $server_link);
$filastaller19 = mysql_num_rows($consultataller19);
$consultataller20 = mysql_query("SELECT * FROM stress_docente WHERE cedula='$cedula'", $server_link);
$filastaller20 = mysql_num_rows($consultataller20);
$consultataller21 = mysql_query("SELECT * FROM juveniles_experiencia WHERE cedula='$cedula'", $server_link);
$filastaller121 = mysql_num_rows($consultataller21);
$consultataller22 = mysql_query("SELECT * FROM ideas_sombrero WHERE cedula='$cedula'", $server_link);
$filastaller22 = mysql_num_rows($consultataller22);
$consultataller23 = mysql_query("SELECT * FROM medio_transformador WHERE cedula='$cedula'", $server_link);
$filastaller23 = mysql_num_rows($consultataller23);
$consultataller24 = mysql_query("SELECT * FROM igenieria_cognitiva WHERE cedula='$cedula'", $server_link);
$filastaller24 = mysql_num_rows($consultataller24);
$consultataller25 = mysql_query("SELECT * FROM cambiar_mundo WHERE cedula='$cedula'", $server_link);
$filastaller25 = mysql_num_rows($consultataller25);
$consultataller26 = mysql_query("SELECT * FROM aprender_divertido WHERE cedula='$cedula'", $server_link);
$filastaller26 = mysql_num_rows($consultataller26);
$consultataller27 = mysql_query("SELECT * FROM aula_quimica WHERE cedula='$cedula'", $server_link);
$filastaller27 = mysql_num_rows($consultataller27);
$consultataller28 = mysql_query("SELECT * FROM innovacion_transformacion WHERE cedula='$cedula'", $server_link);
$filastaller28 = mysql_num_rows($consultataller28);
$consultataller29 = mysql_query("SELECT * FROM portafolio_digital WHERE cedula='$cedula'", $server_link);
$filastaller29 = mysql_num_rows($consultataller29);
$consultataller30 = mysql_query("SELECT * FROM inclusion_escuela WHERE cedula='$cedula'", $server_link);
$filastaller30 = mysql_num_rows($consultataller30);
$consultataller31 = mysql_query("SELECT * FROM trabajo_equipo WHERE cedula='$cedula'", $server_link);
$filastaller31 = mysql_num_rows($consultataller31);
$consultataller32 = mysql_query("SELECT * FROM libro_ideice WHERE cedula='$cedula'", $server_link);
$filastaller32 = mysql_num_rows($consultataller32);
$consultataller33 = mysql_query("SELECT * FROM fondo_innovacion WHERE cedula='$cedula'", $server_link);
$filastaller33 = mysql_num_rows($consultataller33);
$consultataller34 = mysql_query("SELECT * FROM panel_expertos WHERE cedula='$cedula'", $server_link);
$filastaller34 = mysql_num_rows($consultataller34);
echo $filastaller1."<br>";
echo $cedula."<br>";

echo "<tr>";
echo "<td>".$i++."</td> ";
?>
<td><form action="editar.php" method="post" name="editar">
    <input type="hidden" name="frases" value="<?php echo $cedula;?>" />
     <button type="submit" name="buscar" value="Editar" class="btn btn-default" style="font-size: 12px;color:#5D0000;background-color: transparent;border-color: transparent;">
   <span><?php echo $cedula;?></span>
   </button>
</form>
</td>
<?php
echo "<td>$nombre </td> ";
echo "<td>$apellido</td> ";
echo "<td class='impre'>$sexo</td> ";
echo "<td class='impre'>$celular</td> ";
echo "<td class='impre'>$correo</td> ";
echo "<td>$institucion</td>";
echo "<td class='impre'>$tipoinstitucion</td> ";
echo "<td class='impre'>$cargo</td> ";
echo "<td class='impre'>$regional</td> ";
echo "<td class='impre'>$distrito</td> ";
echo "<td class='impre' style='width:100px;'>$redes</td> ";
echo "<td class='impre'>$asistenciaespecial</td>";
echo "<td class='impre'>$participaras</td> ";
echo "<td class='impre'>$teenteraste</td> ";
echo "<td class='impre'>$participaste</td> ";
echo "<td class='impre'>$notificaciones</td>";
echo "<td class='impre'>";
if($filastaller1!=0){echo "1.Taller Planes de Mejora: Por una Cultura de Mejoramiento Continuo, ";}
if($filastaller2!=0){echo "2.Taller El Aula como Espacio Creativo Integrador: Una Mirada desde la Enseñanza de la Ciencia, ";}
if($filastaller3!=0){echo "3.Planificación y Evaluación por Competencias, ";}
if($filastaller4!=0){echo "4.Reunión Coalición Docentes de Excelencia, ";}
if($filastaller5!=0){echo "5.Reunión de Equipos de Gestión Proyecto Fortalecimiento y Expansión Educación Técnica, ";}
if($filastaller6!=0){echo "6.Conferencia Magistral Victoria Zorraquín: Hay Esperanza en la Escuela, ";}
if($filastaller7!=0){echo "7.Educación, economía y empleo: ¿a qué se enfrentan los maestros en el siglo XXI, ";}
if($filastaller8!=0){echo "8.Fundación Varkey, El Diálogo Interamericano, INICIA Educación, ";}
if($filastaller9!=0){echo "9.BICEPS: Las Seis Virturdes que los Directores de escuela deben tener para liderar el cambio orientado a mejorar el rendimiento escolar, ";}
if($filastaller10!=0){echo "10.Desafío de la escuela en la era digital, ";}
if($filastaller11!=0){echo "11.Donde está el Corazón está la Mirada, ";}
if($filastaller12!=0){echo "12.El Docente que Transforma la Sociedad: Teach For America, ";}
if($filastaller13!=0){echo "13.Las Sinergias Positivas entre la escuela pública y la escuela privada, ";}
if($filastaller14!=0){echo "14.Pedagogía del Loto. Respirar, pensar, actuar. Educación socioemocional - Mindfullnes, técnicas somáticas, yoga, ";}
if($filastaller34!=0){echo "15.Panel de Expertos: Qué se esperar del rol docente, ";}
if($filastaller15!=0){echo "16.La investigación acción como herramienta de innovación y fortalecimiento de la práctica docente, ";}
if($filastaller16!=0){echo "17.Sistema de Mentoría para Docentes Innovadores, ";}
if($filastaller17!=0){echo "18.Innovación para la Calidad, ";}
if($filastaller18!=0){echo "19.El Maestro como fuente de Energía, ";}
if($filastaller19!=0){echo "20.Competencias Socio Emocionales como base para la Innovación, ";}
if($filastaller20!=0){echo "21.Manejo del Stress Docente para generar eficiencia en el proceso pedagógico, ";}
if($filastaller21!=0){echo "22.Proyectos Juveniles, Experiencia programa INSPIRACCION - INICIA Educación, ";}
if($filastaller22!=0){echo "23.Sacando Ideas de un Sombrero, ";}
if($filastaller23!=0){echo "24.El Arte como medio Transformador, ";}
if($filastaller24!=0){echo "25.Ingeniería Cognitiva: Del átomo al comportamiento humano. La ciencia de la optimización, ";}
if($filastaller25!=0){echo "26.¿Es posible cambiar el mundo con palabras?, ";}
if($filastaller26!=0){echo "27.Aprender es Divertido. Ciencias Sociales, ";}
if($filastaller27!=0){echo "28.La innovación en el Aula de Química, ";}
if($filastaller28!=0){echo "29.La Formación Docente para la Innovación y la Transformación de la Escuela, ";}
if($filastaller29!=0){echo "30.Portafolio Digital en Educación Secundaria, ";}
if($filastaller30!=0){echo "31.Prácticas Innovadoras para la Inclusión en la escuela: La Experiencia de la UNPHU, ";}
if($filastaller31!=0){echo "32.El Trabajo en Equipo, ";}
if($filastaller32!=0){echo "33.Presentación Libro IDEICE y entrega de libro a profesores participantes, ";}
if($filastaller33!=0){echo "34.Fondo de Innovación, presentación de proyecto 2019 y premiación nuevos proyectos, ";}
echo "</td>";
echo "<td class='escondido'></td>";
echo "</tr>";
        }
		echo "</table></center>";
		echo "</div>";
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

/*
?> 

<div class="impre" style="    background-color: #D4FAD5;padding:10px 0;">
<?php
mysql_connect('localhost','root', '') or die("No se pudo conectar a la base de datos ");
			mysql_select_db('cooproco_amr') or die ("No se encontro la base de datos. ");
			
			
			if(isset($_POST['filtro'])){
switch($_POST['filtro']){
case "todos":
$query = "select * from registro;";
break;
case "recientes":
$query = "select * from registro order by fecha desc;";
break;
case "antiguos":
$query = "select * from registro order by fecha asc;";
break;
case "caros":
$query = "select * from registro order by nombre desc;";
break;
case "economicos":
$query = "select * from registro order by nombre asc;";
break;
case "sector":
$query = "select * from registro order by sector asc;";
break;
}
}else{
$query = "select * from registro;";
}

$resultado=mysql_query($query);
echo"<center><table class='table-striped'><tr><td>Fecha</td><td>Nombre</td><td>Direccion</td><td>Zona</td><td>Sector</td><td>Telefono</td></tr>";
while($row = mysql_fetch_assoc($resultado)){ 

$fecha= $row['fecha'];
$nombre=$row['nombre'];
$direccion=$row['direccion'];
$Zona=$row['Zona'];
$sector=$row['sector'];
$telefono=$row['telefono'];
echo "<tr>";
echo "<td>$fecha</td> ";
echo "<td>$nombre </td> ";
echo "<td>$direccion</td> ";
echo "<td>$Zona</td> ";
echo "<td>$sector</td> ";
echo "<td>$telefono</td>";
echo "</tr>";
} 
echo "</table></center>";*/
?>
</div>

</div>
</div>
</div>
</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>


</body>
</html>
