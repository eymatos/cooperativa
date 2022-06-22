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
	echo "<center><form action='edit_taller.php' method='POST'>
<span><b>Selecciona Taller:</b></span>
<select style='width:100%;margin:auto;text-align:center;' name='sitio'>";
echo "<option value='planes_mejora'>1.Taller Planes de Mejora: Por una Cultura de Mejoramiento Continuo</option>";
echo "<option value='aula_creativo'>2.Taller El Aula como Espacio Creativo Integrador: Una Mirada desde la Enseñanza de la Ciencia</option>";
echo "<option value='planificacion_evaluacion'>3.Planificación y Evaluación por Competencias</option>";
echo "<option value='coalicion_docentes'>4.Reunión Coalición Docentes de Excelencia</option>";
echo "<option value='gestion_proyecto'>5.Reunión de Equipos de Gestión Proyecto Fortalecimiento y Expansión Educación Técnica</option>";
echo "<option value='victoria_zorraquin'>6.Conferencia Magistral Victoria Zorraquín: Hay Esperanza en la Escuela</option>";
echo "<option value='educacion_economia'>7.Educación, economía y empleo: ¿a qué se enfrentan los maestros en el siglo XXI</option>";
echo "<option value='fundacion_varkey'>8.Fundación Varkey, El Diálogo Interamericano, INICIA Educación</option>";
echo "<option value='biceps'>9.BICEPS: Las Seis Virturdes que los Directores de escuela deben tener para liderar el cambio orientado a mejorar el rendimiento escolar</option>";
echo "<option value='corazon_mirada'>11.Donde está el Corazón está la Mirada";
echo "<option value='transforma_sociedad'>12.El Docente que Transforma la Sociedad: Teach For America</option>";
echo "<option value='sinergias_positivas'>13.Las Sinergias Positivas entre la escuela pública y la escuela privada</option>";
echo "<option value='pedagogia_loto'>14.Pedagogía del Loto. Respirar, pensar, actuar. Educación socioemocional - Mindfullnes, técnicas somáticas, yoga</option>";
echo "<option value='panel_expertos'>15.Panel de Expertos: Qué se esperar del rol docente</option>";
echo "<option value='accion_herramienta'>16.La investigación acción como herramienta de innovación y fortalecimiento de la práctica docente</option>";
echo "<option value='mentoria_docentes'>17.Sistema de Mentoría para Docentes Innovadores</option>";
echo "<option value='innovacion_calidad'>18.Innovación para la Calidad</option>";
echo "<option value='maestro_energia'>19.El Maestro como fuente de Energía</option>";
echo "<option value='socio_emocionales'>20.Competencias Socio Emocionales como base para la Innovación</option>";
echo "<option value='stress_docente'>21.Manejo del Stress Docente para generar eficiencia en el proceso pedagógico</option>";
echo "<option value='juveniles_experiencia'>22.Proyectos Juveniles, Experiencia programa INSPIRACCION - INICIA Educación</option>";
echo "<option value='ideas_sombrero'>23.Sacando Ideas de un Sombrero</option>";
echo "<option value='medio_transformador'>24.El Arte como medio Transformador</option>";
echo "<option value='igenieria_cognitiva'>25.Ingeniería Cognitiva: Del átomo al comportamiento humano. La ciencia de la optimización</option>";
echo "<option value='cambiar_mundo'>26.¿Es posible cambiar el mundo con palabras?</option>";
echo "<option value='aprender_divertido'>27.Aprender es Divertido. Ciencias Sociales</option>";
echo "<option value='aula_quimica'>28.La innovación en el Aula de Química</option>";
echo "<option value='innovacion_transformacion'>29.La Formación Docente para la Innovación y la Transformación de la Escuela</option>";
echo "<option value='portafolio_digital'>30.Portafolio Digital en Educación Secundaria</option>";
echo "<option value='inclusion_escuela'>31.Prácticas Innovadoras para la Inclusión en la escuela: La Experiencia de la UNPHU</option>";
echo "<option value='trabajo_equipo'>32.El Trabajo en Equipo</option>";
echo "<option value='libro_ideice'>33.Presentación Libro IDEICE y entrega de libro a profesores participantes</option>";
echo "<option value='fondo_innovacion'>34.Fondo de Innovación, presentación de proyecto 2019 y premiación nuevos proyectos</option>";
echo "</select></center>";
	echo "<center><table style='width:100%;' class='table-striped'>
		<tr>
			<td><b>No.</b></td>
			<td style='width:100px;'><b>Cédula</b></td>
			<td><b>Nombre</b></td>
			<td><b>Apellido</b></td>		
			<td><b>Nombre de institución</b></td>			
		</tr>";
			$i=1;
$sitio=$row['sitio'];
        while($row = mysql_fetch_array($sqlBuscar)){
$cedula=$row['cedula'];
global $cedcont;
$cedcont=$cedula;
$nombre=$row['nombre'];
$apellido=$row['apellido'];
$institucion=$row['institucion'];
echo "<tr>";
echo "<td>".$i++."</td> ";
?>
<td>
    <input type="hidden" name="frases" value="<?php echo $cedula;?>" />
     <button type="submit" name="buscar" value="Editar" class="btn btn-default" style="font-size: 12px;color:#5D0000;background-color: transparent;border-color: transparent;">
   <span><?php echo $cedula;?></span>
   </button>

</td>
</form>
<?php
echo "<td>$nombre </td> ";
echo "<td>$apellido</td> ";
echo "<td>$institucion</td>";
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
