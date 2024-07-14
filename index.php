<?php 


require_once('Connections/sgstec.php'); ?>
<?php
include('funciones/functions.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['cedula'])) {
  $loginUsername=$_POST['cedula'];
  $password= md5($_POST['clave']);
  $tipo=$_POST['tipo'];
  $MM_fldUserAuthorization = "";
  if($tipo==0){
	  
	  $MM_redirectLoginSuccess = "inicio.php";
  }else{
	  $MM_redirectLoginSuccess = "soporte.php";
  }
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = true;
  mysqli_select_db($sgstec,$database_sgstec);
  
  if($tipo==0){
	  	  $LoginRS__query=sprintf("SELECT cedula, clave FROM usuarios WHERE cedula=%s AND clave=%s", 
	  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));
  }else{
	  $LoginRS__query=sprintf("SELECT cedula, password FROM soporte_tecnico WHERE cedula=%s AND password=%s", 
	  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));
  }
   
  $LoginRS = mysqli_query($sgstec,$LoginRS__query) or die(mysqli_error());
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><!-- Global site tag (gtag.js) - Google Analytics --><script async src="https://www.googletagmanager.com/gtag/js?id=UA-60738677-4"></script><script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-60738677-4');</script><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>COOPROCON</title>

<link href="css/estilos1.css" rel="stylesheet" type="text/css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/libreria.js" type="text/javascript"></script>
<script>
window.onload=funtion(){
	cont_mensajes(<?php echo $row_sexo['id']; ?>);
}
</script>
</head>
<body>
<header>
<div id="secondbox">
    	<a href="index.php"><div id="logo" class="fleft"></div></a>
        <?php encabezados();?>
<div class="fright"></header>
<section style="min-height:600px!important;">
<div id="menu" style='margin-top:80px;'><?php sidemenu2();?></div> 
<center>
<script type='text/javascript'>
$('#loginform input').keydown(function(e) {
    if (e.keyCode == 13) {
        $('#loginform').submit();
    }
});
</script>
<div id="login">
		<p><h1 style="color:#0E9801;">Conéctate</h1></p>
		<form id="loginform" ACTION="<?php echo $loginFormAction; ?>" method="POST" id="login_form">
            	<p><label>Cédula:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </label><input type="text" placeholder="" name="cedula" id="cedula" /></p>
                <p style="font-style: italic;font-size: 12px;color: gray;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(000-0000000-0)</p>
				<p><label>Contrase&ntilde;a:</label><input placeholder="Contraseña" type="password" name="clave" id="clave" /></p>
				<div style="margin-top:20px;font-size:12px;text-transform:none;"><a href="recupera_contraseña.php">He olvidado mi contraseña</a></div>
              <div id="botones"><input type="reset" value="Borrar datos" /> <input type="submit" value="Ingresar"/></div>
			  <br>
			  <div><p style="font-size:9px;text-align:left;color:gray;">Para protección de tu información en la cooperativa es necesario que cambies la contraseña la primera vez que entres.
	Nota: Para realizar el cambio de contraseña debes seleccionar en el menú de la izquierda la opción "mi usuario" y hacer clic en el botón verde que dice "cambiar contraseña".
	Debes llenar la casilla que dice "nueva contraseña" con datos que no olvides y que sea única para ti. 
	Luego vuelves a pulsar el botón verde que dice "cambiar contraseña", y ya estará listo el proceso. Esto se realiza solo una vez
	Después cuando vuelvas a ingresar debes utilizar la contraseña personal que pusiste.</p></div>
            </form></center></div>
	
    </div>
</center>	
</section>
	<footer>
	<center style="background:#232F3E;color:white;font-weight:bold;">© 2021 COOPROCON</center>
<div id="footer"></div></footer>
</body>
</html>