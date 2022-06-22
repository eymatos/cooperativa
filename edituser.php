<?php require_once('Connections/sgstec.php'); ?>
<?php require_once('Connections/sgstec.php'); ?>
<?php require_once('Connections/sgstec.php'); ?>
<?php
include('funciones/functions.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_sgstec, $sgstec);
$query_usuario = sprintf("SELECT id, sexo, nombre, apellido, cedula, cedula FROM usuarios WHERE cedula = %s", GetSQLValueString($colname_usuario, "text"));
$cedula = mysql_query($query_usuario, $sgstec) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($cedula);
$totalRows_usuario = mysql_num_rows($cedula);

mysql_select_db($database_sgstec, $sgstec);
$query_Usuarios = "SELECT id, nombre, apellido FROM usuarios WHERE departamento = ".$row_usuario['departamento']." ORDER BY nombre ASC";
$Usuarios = mysql_query($query_Usuarios, $sgstec) or die(mysql_error());
$row_Usuarios = mysql_fetch_assoc($Usuarios);
$totalRows_Usuarios = mysql_num_rows($Usuarios);

mysql_select_db($database_sgstec, $sgstec);
$query_localidades = "SELECT DISTINCT localidad FROM departamentos";
$localidades = mysql_query($query_localidades, $sgstec) or die(mysql_error());
$row_localidades = mysql_fetch_assoc($localidades);
$totalRows_localidades = mysql_num_rows($localidades);

$colname_users_dept = "-1";
if (isset($_GET['dept'])) {
  $colname_users_dept = $_GET['dept'];
}
mysql_select_db($database_sgstec, $sgstec);
$query_users_dept = sprintf("SELECT id, nombre, apellido, cedula, tipo_usuario FROM usuarios WHERE departamento = %s ORDER BY id ASC", GetSQLValueString($colname_users_dept, "int"));
$users_dept = mysql_query($query_users_dept, $sgstec) or die(mysql_error());
$row_users_dept = mysql_fetch_assoc($users_dept);
$totalRows_users_dept = mysql_num_rows($users_dept);

$colname_dept_selected = "-1";
if (isset($_GET['dept'])) {
  $colname_dept_selected = $_GET['dept'];
}
mysql_select_db($database_sgstec, $sgstec);
$query_dept_selected = sprintf("SELECT localidad FROM departamentos WHERE id = %s", GetSQLValueString($colname_dept_selected, "int"));
$dept_selected = mysql_query($query_dept_selected, $sgstec) or die(mysql_error());
$row_dept_selected = mysql_fetch_assoc($dept_selected);
$totalRows_dept_selected = mysql_num_rows($dept_selected);

$cedula = $row_usuario['id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><!-- Global site tag (gtag.js) - Google Analytics --><script async src="https://www.googletagmanager.com/gtag/js?id=UA-60738677-4"></script><script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-60738677-4');</script><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: Sistema de Gestión de Servicios Técnicos ::</title>

<link href="css/estilos1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<script src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/libreria.js" type="text/javascript"></script>
</head>
<body onload="cont_mensajes(<?php echo $row_usuario['id']; ?>)">
	<div id="secondbox">
    	<div id="logo" class="fleft">
        	&nbsp;
        </div>
        <?php encabezados();?>
<div class="fright">
        	<?php menu();?>
        </div>
        <div class="clearfix"></div>
        <?php sidemenu();?>
        <div id="cpanel1">
<div id="formulario">
   	  <div class="encabezado_azul">Modificaci&oacute;n de Usurios</div>
       <form name="form" id="form" style="padding: 10px 0 20px 20px;">
        	<label for="departamento">Departamento : </label>
           <select name="departamento" onchange="MM_jumpMenu('parent',this,0)">
                    	<option>-- Seleccione un Departamento --</option>
						<?php do { ?>
                        <optgroup label="<?php echo $row_localidades['localidad']; ?>">
                        	<?php
								mysql_select_db($database_sgstec, $sgstec);
								$query_departamentos = "SELECT id FROM departamentos WHERE localidad = '".$row_localidades['localidad']."'";
								$departamentos = mysql_query($query_departamentos, $sgstec) or die(mysql_error());
								$row_departamentos = mysql_fetch_assoc($departamentos);
								$totalRows_departamentos = mysql_num_rows($departamentos);	
                            ?>
                            <?php do { ?>
                            	<option value="edituser.php?dept=<?php echo $row_departamentos['id'];?>" <?php if($_GET['dept']==$row_departamentos['id']){?> selected="selected" <?php }?>><?php echo htmlentities($row_departamentos['departamento'], ENT_QUOTES,'ISO-8859-1');?></option>
                            <?php } while ($row_departamentos = mysql_fetch_assoc($departamentos)); ?>
                        </optgroup>
						<?php } while ($row_localidades = mysql_fetch_assoc($localidades)); ?>
                      </select>
           
      </form>
      <div class="encabezados_verdes"><?php echo htmlentities($row_dept_selected['departamento']); ?> - <?php echo $row_dept_selected['localidad']; ?></div>
      <?php if(empty($row_users_dept['nombre'])){ ?>
		<div style="font-weight: bold; color: #036; font-size: 20px; text-align: center; padding: 30px;">Este Departamento no Contiene Usuarios en el Sistema</div>	
		<?php }else{ ?>
      <table id="detusuario">
       	<thead>
       	<td>Usuario</td>
          <td>Nombre</td>
          <td>Apellido</td>
          <td>Departamento</td>
          <td>Tipo de Usuario</td>
          <td>Editar</td>
          <td>Password</td>
          <td>Borrar</td>
            </thead>
            <?php do { ?>
            <?php
				mysql_select_db($database_sgstec, $sgstec);
				$query_depusuario = "SELECT departamento FROM departamentos WHERE id = ".$row_users_dept['departamento'];
				$depusuario = mysql_query($query_depusuario, $sgstec) or die(mysql_error());
				$row_depusuario = mysql_fetch_assoc($depusuario);
				$totalRows_depusuario = mysql_num_rows($depusuario);
            ?>
          <tr>
                  <td><?php echo $row_users_dept['cedula']; ?></td>
                  <td><?php echo $row_users_dept['nombre']; ?></td>
                  <td><?php echo $row_users_dept['apellido']; ?></td>
                  <td><?php echo ucfirst(strtolower(htmlentities($row_depusuario['departamento']))); ?></td>
                  <td><?php echo tipousuario3($row_users_dept['tipo_usuario']); ?></td>
                  <td align="center" valign="middle"><a href="useredit.php?user=<?php echo $row_users_dept['id']; ?>"><img src="images/icons/user-edit.png" width="16" height="16" /></a></td>
                  <td align="center" valign="middle"><a href="password.php?user=<?php echo $row_users_dept['id']; ?>"><img src="images/icons/passedit.png" width="16" height="16" /></a></td>
                  <td align="center" valign="middle"><a href="del_user.php?user=<?php echo $row_users_dept['id']; ?>"><img src="images/icons/deletuser.png" width="16" height="16" /></a></td>               
                </tr>
                <?php } while ($row_users_dept = mysql_fetch_assoc($users_dept)); ?>
        </table>
        <?php } ?>

</div>
</div>
        <div class="clearfix"></div>
        <div id="bienvenida" style="margin-top: 40px;">Bienvenid<?php if($row_usuario['cedula']==1){?>o<?php }else{?>a<?php } ?> <?php echo p_nombre($row_usuario['nombre']); ?> <?php echo p_nombre($row_usuario['apellido']); ?></div>
    </div>
    
</body>
</html>
<?php
//mysql_free_result($cedula);

mysql_free_result($localidades);

mysql_free_result($users_dept);

mysql_free_result($dept_selected);
?>
