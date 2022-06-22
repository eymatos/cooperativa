<?php 


require_once('Connections/sgstec.php'); ?>
<?php


function p_nombre($primer){
	
	$posicion = strpos($primer," ");
	$posicion = strpos($primer," ");
	if(!($posicion==0)){
		$nombre = substr($primer, 0,$posicion);
		if($nombre=="de"){
			$segundo = substr($primer, 3);
			$posicion2 = strpos($segundo," ");
			if(!empty($posicion2)){
			$posicion3	= $posicion2+3;
			$nombre	=	substr($primer, 0,$posicion3);
			return $nombre;
			}else{
				return $primer;
			}
		}else{
		return $nombre;
		}
	}else{
		return $primer;
	}
}
function sexo($sexo){
	switch($sexo){
		case 0:
		$sex = "Femenino";
		break;
		case 1:
		$sex = "Masculino";
	}
	return $sex;
}
function sexo2($sexo2){
	switch($sexo2){
		case 0:
		$sex2 = "f";
		break;
		case 1:
		$sex2 = "m";
	}
	return $sex2;
}
function sistemaop($sistema){
	switch($sistema){
		case 0:
		$sis = "&nbsp;";
		break;
		case 1:
		$sis = "Win7";
		break;
		case 2:
		$sis = "Vista";
		break;
		case 3:
		$sis = "Win XP";
		break;
		case 4:
		$sis = "Linux";
		break;
	}
	return $sis;
}
function dia_semana($dia){
	switch($dia){
		case 1:
		$dia_return = "Lunes";
		break;
		case 2:
		$dia_return = "Martes";
		break;
		case 3:
		$dia_return = "Miercoles";
		break;
		case 4:
		$dia_return = "Jueves";
		break;
		case 5:
		$dia_return = "Viernes";
		break;
		case 6:
		$dia_return = "Sabado";
		break;
		case 7:
		$dia_return = "Domingo";
		break;
	}
	return $dia_return;
}
function estatus_solicitudes($estatus){
	switch($estatus){
		case 0:
		$est = "En operaciones sin reporte alguno";
		break;
		case 1:
		$est = "Solicitado";
		break;
		case 2:
		$est = "Diagnostico";
		break;
		case 3:
		$est = "Reparacion";
		break;
		case 4:
		$est = "Suministro";
		break;
		case 5:
		$est = "Finalizado";
	}
	return $est;
}
function tipousuario($usuario){
	switch($usuario){
		case 1:
		$usuarios = "sol_global.php";
		break;
		case 2:
		$usuarios = "sol_departamento.php";
	}
	return $usuarios;
}
function tipousuario2($usuario2){
	switch($usuario2){
		case 1:
		$usuarios2 = "ver_global.php";
		break;
		case 2:
		$usuarios2 = "ver_departamento.php";
	}
	return $usuarios2;
}
function tipousuario3($usuario3){
	switch($usuario3){
		case 1:
		$usuarios3 = "Usuario";
		break;
		case 2:
		$usuarios3 = "Supervisor";
		break;
		case 3:
		$usuarios3 = "Soporte T&eacute;cnico";
		break;
		case 4:
		$usuarios3 = "Secretaria";
		break;
	}
	return $usuarios3;
}
function fecha($fecha){
	$fechas = explode("-",$fecha);
	$fecha_final= $fechas[2]."-".$fechas[1]."-".$fechas[0];
	return $fecha_final;
}
function fecha_i($fecha){
	$fecha = substr($fecha, 0,10);
	$fechas = explode("-",$fecha);
	$fecha_final= $fechas[2]."-".$fechas[1]."-".$fechas[0];
	return $fecha_final;
}
function hora($hora){
	$horas_sep = explode(":",$hora);
	if($horas_sep[0]==0){
		$hora_return = "12:".$horas_sep[1].":".$horas_sep[2]." a.m.";
	}elseif(($horas_sep[0]>0)&&($horas_sep[0]<13)){
		$hora_return = $horas_sep[0].":".$horas_sep[1].":".$horas_sep[2]." a.m.";
	}else{
		$hora_pm = $horas_sep[0]-12;
		$hora_return = $hora_pm.":".$horas_sep[1].":".$horas_sep[2]." p.m.";
	}
	return $hora_return;
}
function hora2($hora){
	$horas_sep = explode(":",$hora);
	if($horas_sep[0]==0){
		$hora_return = "12:".$horas_sep[1]." a.m.";
	}elseif(($horas_sep[0]>0)&&($horas_sep[0]<13)){
		$hora_return = $horas_sep[0].":".$horas_sep[1]." a.m.";
	}else{
		$hora_pm = $horas_sep[0]-12;
		$hora_return = $hora_pm.":".$horas_sep[1]." p.m.";
	}
	return $hora_return;
}
function estatus($status){
	switch($status){
		case 0:
		$estado = "Sin solicitud asignada";
		break;
		case 1:
		$estado = "Soporte solicitado";
		break;
		case 2:
		$estado = "Diagnostico";
		break;
		case 3:
		$estado = "Reparaci&oacute;n";
		break;
		case 4: 
		$estado = "En espera de suministro";
		break;
		case 5:
		$estado = "Finalizado";
	}
	return $estado;
}
function menu(){
	// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
	echo "<ul id='users_menu'  onload='cont_mensajes(".$_SESSION['id'].")'>
        		<li><a href='tecnologia.php'>Tecnolog&iacute;a</a></li>
            	    	<li><a href='rrhh.php'>Recursos Humanos</a></li>
				        	<li><a href='comunicaciones.php'>Comunicaciones</a></li>
				<li><a href='mensajes.php'>Mensajer&iacute;a</a></li>
				<li><a href='documentos.php'>Documentos</a></li>
				
                <li style='clear: left;'>&nbsp;</li>				
        	</ul>";
}
function menuisfo(){
	// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
echo "<nav class='main-nav float-right d-none d-lg-block'>
<ul>
    <li><a href='administrar.php'>Inicio</a></li>
	<li class='drop-down'> <a href=''>Opciones Administrativas</a>
		  <ul>
              <li><a href='/isfo/crearadmin.php'>Crear Administrador</a></li>
			  <li><a href='/isfo/changepw_u.php'>Password de Administrador</a></li>
          </ul>
    </li>
	<li class='drop-down'> <a href=''>Opciones de Usuario</a>
		  <ul>
              <li><a href='/isfo/crearusuario.php'>Crear Usuario</a></li>
			  <li><a href='/isfo/cambiar_password.php'>Password de Usuario</a></li>
			  <li><a href='/isfo/verusuarios.php'>Usuarios Creados</a></li>			  
          </ul>
    </li>
	<li class='drop-down'> <a href=''>Opciones de Talleres</a>
		  <ul>
		  <li><a href='/isfo/creartaller.php'>Crear Taller</a></li>
              <li><a href='/isfo/vertalleres.php'>Talleres Creados</a></li>
			  <li><a href='/isfo/consultartaller.php'>Usuarios confirmados</a></li>
          </ul>
    </li>
</nav>";
	         
}
function encabezados(){
	echo " <div id='topright'class='fright'>
        	<div id='departamento'>
			<p>COOPERATIVA DE AHORROS, CRÉDITOS Y SERVICIOS MULTIPLES DE LOS EMPLEADOS DE PROCONSUMIDOR</p><h1>COOPROCON</h1><p style='float: right; background: linear-gradient(#0E9801 50%, #EDF900 50%);height: 40px;width: 40%;'></p></div>
			<div style='float:left;padding-left:5px;'>Ultima actualización, septiembre 25 2021</div>
        </div>";
}
function sidemenu(){
	echo "<div class='sidemenu fleft'>
        	<ul>
            	<li><a href='inicio.php'>Inicio</a></li>
				<li><a href='quienes.php'>Quiénes somos?</a></li>
				<li><a href='perfil_u.php'>Mi Usuario</a></li>
				<li><a href='ahorros.php'>Mis Ahorros</a></li>
				<li><a href='prestamos.php'>Mis Préstamos</a></li>
				<li><a href='calculo.php'>Calcula tu préstamo</a></li>
				<li><a href='formularios.php'>Formularios</a></li>				<li><a href='contacto.php'>Contacto</a></li>";					
				echo "<li><a href='logout.php'>Salir</a></li>
            </ul>
        </div>";
}
function sidemenu2(){
	echo "<div class='sidemenu fleft'>
        	<ul>
			    <li><a href='index.php'>Portada</a></li>
				<li><a href='quienes2.php'>Quiénes somos?</a></li>
				<li><a href='calculo2.php'>Calcula tu préstamo</a></li>
				<li><a href='formularios2.php'>Formularios</a></li>			
				
            </ul>
        </div>";
}
//$sitio=$_POST['sitio'];
function retornoadmin(){
	
	if (isset($_GET['sitio'])){	$sitio=$_GET['sitio'];
	$temporal=$sitio;}
	echo "<div style='float:right;margin:10px;position:fixed;    bottom: 250px;
    right: 5px; '>
        	<a href='administrador.php'>Retornar a administrador</a>
        </div>";
			echo "<br><div style='float:right;margin:10px;position:fixed;    bottom: 200px;
    right: 5px; '>";
	?>
        	<form action="servicios.php" method='post'>
    <button type='submit' name='sitio' value='<?php echo $sitio; ?>' class='btn-link'>Volver a usuario</button>
</form>
<?php
  echo "</div>";
		
}
function retornoadminb(){
	//$sitio=$_GET['sitio'];
	//$temporal=$sitio;
	echo "<div style='float:right;margin:10px;position:fixed;    bottom: 250px;
    right: 5px; '>
        	<a href='administrador.php'>Retornar a administrador</a>
        </div>";
		
}
function contador_palabras($cont_frase, $cont_numero){
		if(strlen($cont_frase)>$cont_numero){
		$cont_frase = substr($cont_frase, 0,$cont_numero);
		$array_frase = explode(" ",$cont_frase, -1);
		$cuenta_array = count($array_frase);
		$frase_final = implode(" ",$array_frase);
		return $frase_final."...";
		}else{
			return $cont_frase;
		}
}
function tips_solicitudes($tip){
	switch($tip){
		case 0:
		$tip_msg = "Este Equipo no ha sido reportado para soporte tecnico...";
		break;
		case 1:
		$tip_msg = "Soporte Solicitado en espera de asignaci&oacute;n al personal adecuado";
		break;
		case 2:
		$tip_msg = "El equipo esta siendo revisado para determinar la raz&oacute;n de la aver&iacute;a";
		break;
		case 3:
		$tip_msg = "El equipo esta en el proceso de reparaci&oacute;n";
		break;
		case 4:
		$tip_msg = "El equipo requiere de un suministro de piezas";
		break;
		case 5:
		$tip_msg = "El Equipo fue reparado y recibido satisfactoriamente por el usuario asignado";		
	}
	return $tip_msg;
}
function localidad($localidad){
	switch($localidad){
		case "Samana":
		$localidad = "Samaná";
		break;
		case "San Francisco de Macoris":
		$localidad = "San Francisco de Macorís";
		break;
		case "San Pedro de Macoris":
		$localidad = "San Pedro de Macorís";
		break;
	}
	return $localidad;
}
function limpiar_caracteres_especiales($s) {
	$s = str_replace("á","a",$s);
	$s = str_replace("à","a",$s);
	$s = str_replace("â","a",$s);
	$s = str_replace("ã","a",$s);
	$s = str_replace("ª","a",$s);
	$s = str_replace("Á","A",$s);
	$s = str_replace("À","A",$s);
	$s = str_replace("Â","A",$s);
	$s = str_replace("Ã","A",$s);
	$s = str_replace("é","e",$s);
	$s = str_replace("è","e",$s);
	$s = str_replace("ê","e",$s);
	$s = str_replace("É","E",$s);
	$s = str_replace("È","E",$s);
	$s = str_replace("Ê","E",$s);
	$s = str_replace("í","i",$s);
	$s = str_replace("ì","i",$s);
	$s = str_replace("î","i",$s);
	$s = str_replace("Í","I",$s);
	$s = str_replace("Ì","I",$s);
	$s = str_replace("Î","I",$s);
	$s = str_replace("ó","o",$s);
	$s = str_replace("ò","o",$s);
	$s = str_replace("ô","o",$s);
	$s = str_replace("õ","o",$s);
	$s = str_replace("º","o",$s);
	$s = str_replace("Ó","O",$s);
	$s = str_replace("Ò","O",$s);
	$s = str_replace("Ô","O",$s);
	$s = str_replace("Õ","O",$s);
	$s = str_replace("ú","u",$s);
	$s = str_replace("ù","u",$s);
	$s = str_replace("û","u",$s);
	$s = str_replace("Ú","U",$s);
	$s = str_replace("Ù","U",$s);
	$s = str_replace("Û","U",$s);
	$s = str_replace("ñ","n",$s);
	$s = str_replace("Ñ","N",$s);
	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
	return $s;
}
function sel_dept($dept){
	switch($dept){
		case 1:
		$salida = "dir_ejecutiva";
		break;
		case 2:
		$salida = "conciliacion";
		break;
		case 3:
		$salida = "juridica";
		break;
		case 4:
		$salida = "registro";
		break;
		case 5:
		$salida = "fiscalia";
		break;
		case 6:
		$salida = "oai";
		break;
		case 7:
		$salida = "planificacion";
		break;
		case 8:
		$salida = "rrhh";
		break;
		case 9:
		$salida = "comunicaciones";
		break;
		case 10:
		$salida = "r_publicas";
		break;
		case 11:
		$salida = "tecnologia";
		break;
		case 12:
		$salida = "sub_tecnica";
		break;
		case 13:
		$salida = "sub_coop_internacional";
		break;
		case 14:
		$salida = "sub_operaciones";
		break;
		case 15:
		$salida = "educacion";
		break;
		case 16:
		$salida = "orientacion";
		break;
		case 17:
		$salida = "asociaciones";
		break;
		case 18:
		$salida = "investigacion";
		break;
		case 19:
		$salida = "articulacion_soc";
		break;
		case 20:
		$salida = "reclamaciones";
		break;
		case 21:
		$salida = "serv_usuario";
		break;
		case 22:
		$salida = "call_center";
		break;
		case 23:
		$salida = "insp_vigilancia";
		break;
		case 24:
		$salida = "estadistica";
		break;
		case 25:
		$salida = "encuesta";
		break;
		case 26:
		$salida = "analisis_productos";
		break;
		case 27:
		$salida = "buenas_practicas";
		break;
		case 28:
		$salida = "analisis_mercado";
		break;
		case 29:
		$salida = "publicidad_eng";
		break;
		case 30:
		$salida = "sub_adm";
		break;
		case 31:
		$salida = "administrativo";
		break;
		case 32:
		$salida = "compras";
		break;
		case 33:
		$salida = "financiero";
		break;
		case 34:
		$salida = "contabilidad";
		break;
		case 35:
		$salida = "almacen";
		break;
		case 36:
		$salida = "correspondencia";
		break;
		case 37:
		$salida = "serv_generales";
		break;
		case 38:
		$salida = "mantenimiento";
		break;
		case 39:
		$salida = "transportacion";
		break;
		case 40:
		$salida = "seguridad";
		break;
		case 41:
		$salida = "recepcion";
		break;
		case 42:
		$salida = "cibao_central";
		break;
		case 43:
		$salida = "san_francisco";
		break;
		case 44:
		$salida = "samana";
		break;
		case 45:
		$salida = "san_pedro";
		break;
		case 46:
		$salida = "barahona";
		break;
		case 52:
		$salida = "serv_usuario";
	}
	return $salida;
}
function num_mensaje($numero){
		return $numero+1;
}
function bienvenida($sexo, $nombre, $apellido){
	if($sexo==1){
		$sex_letter = "o";
	}else{
		$sex_letter = "a";
	}
	echo "<div id='bienvenida'>Bienvenid".$sex_letter." ".p_nombre($nombre)." ".p_nombre($apellido)."</div>";
}
function restadirectio($cadena_x){
	$posicion_x = strpos($cadena_x, "/");
	$cadena_xx  = substr($cadena_x, $posicion_x+1);
	return $cadena_xx;
}
function directorio_attachment($mystring){
	$findme   = '/';
	$pos = strpos($mystring, $findme);
	$total_letras = strlen($mystring);
	$restar = $total_letras-$pos;
	$reverse1 = strrev($mystring);
	$restar2 = substr($reverse1,$restar);
	$final = strrev($restar2);
	return $final;
}
function limpiar_nomb_doc($nomb){
	$cortar1	= substr($nomb, 0,-4);
	$rev		= strrev($cortar1);
	$posision	= strpos($rev, "/");
	$cortar2	= substr($rev, 0,$posision);
	$rev2		= strrev($cortar2);
	$nomb		= str_replace("_", " ", $rev2);
	return $nomb;
}
function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
       } 
     } 
     reset($objects); 
     rmdir($dir); 
   } 
 }
 function folder_usuario($usuario){
	 mkdir("filemanager/".$usuario, 0777);
	 mkdir("filemanager/".$usuario."/publica", 0777);	 
 }
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
$hostname_sgstec = "db-mysql-arreglatap-do-user-11514964-0.b.db.ondigitalocean.com:25060";
$database_sgstec = "cooperativav2";
$username_sgstec = "developer";
$password_sgstec = "AVNS_-VOrwRcsZd7Xjc_";
$sgstec = mysqli_connect($hostname_sgstec, $username_sgstec, $password_sgstec) or trigger_error(mysqli_error(),E_USER_ERROR);
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($sgstec,$theValue) : mysqli_escape_string($sgstec,$theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
/* $colname_sexo = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_sexo = $_SESSION['MM_Username'];
}
mysqli_select_db($sgstec,$database_sgstec);
$query_sexo = sprintf("SELECT id, nombre, apellido, sexo, departamento, usuario FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_sexo, "text"));
$sexo = mysqli_query($sgstec,$query_sexo) or die(mysqli_error());
$row_sexo = mysqli_fetch_assoc($sexo);
$totalRows_sexo = mysqli_num_rows($sexo);

mysqli_free_result($sexo); */

function sexo_check($val1,$val2){
	if($val1==$val2){
		$result1 = "checked=\"checked\"";
		}else{
			$result1 = "";
		}
		return $result1;
}
function moneda($moneda){
	return "RD$ ".number_format($moneda, 2);
}
function quitar_moneda($moneda){
	return substr($moneda, 4);
}
?>
