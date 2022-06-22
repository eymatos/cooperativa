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

if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password= md5($_POST['clave']);
  $MM_fldUserAuthorization = "";
  if($tipo==0){
	  
	  $MM_redirectLoginSuccess = "menu.php";
  }else{
	  $MM_redirectLoginSuccess = "menu.php";
  }
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_sgstec, $sgstec);
  
  if($tipo==0){
	  	  $LoginRS__query=sprintf("SELECT usuario, clave FROM usuarios WHERE usuario=%s AND clave=%s", 
	  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));
  }else{
	  $LoginRS__query=sprintf("SELECT usuario, password FROM soporte_tecnico WHERE usuario=%s AND password=%s", 
	  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));
  }
   
  $LoginRS = mysql_query($LoginRS__query, $sgstec) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
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
<html lang="es">
<head><!-- Global site tag (gtag.js) - Google Analytics --><script async src="https://www.googletagmanager.com/gtag/js?id=UA-60738677-4"></script><script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-60738677-4');</script>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content=width = device-width, initial-scale = 1">
	<title>AMRegistro</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css"
	<link href='https://fonts.googleapis.com/css?family=pacifico' rel='stylesheet' type='text/css'>
	<style>
	.jumbotron{
		background-color:#ffffff;
		color:#333;
		margin-top:120px;
		padding-left:0!important;
		padding-top:0!important;
		padding-bottom:0!important;
		-webkit-box-shadow: 10px 10px 31px 0px rgba(0,0,0,0.65);
-moz-box-shadow: 10px 10px 31px 0px rgba(0,0,0,0.65);
box-shadow: 10px 10px 31px 0px rgba(0,0,0,0.65);
display: block;
overflow: auto;
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
		background-repeat:no-repeat;
		
	}
	</style>
	
</head>
<body  style="background-color: #5d0000;">
<script type='text/javascript'>
$('#loginform input').keydown(function(e) {
    if (e.keyCode == 13) {
        $('#loginform').submit();
    }
});
</script>
<div class="container">
<div class="jumbotron">
<div style="float: left;
    margin-right: 40px;
    margin-left: 50px;
    width: 20%;
	display: block;
overflow: auto;">
	<img style="width:100%;"src="proveedores.png">
	</div>

<div style="padding: 50px;
    background: #e8dcdc;
    margin: 60px auto;
    width: 50%;
	display: block;
overflow: auto;">
	
	<h1>AMRegistro</h1>
<div id="login">
		<p><h3>Conéctate</h3></p>
		<form id="loginform" ACTION="index.php" method="POST" id="login_form">
            	<p><label>usuario:</label><input type="text" placeholder="Usuario" name="usuario" id="usuario" class="form-control" /></p>
              	<p><label>Contrase&ntilde;a:</label><input placeholder="Contraseña" type="password" name="clave" id="clave" class="form-control" /></p>
              <div id="botones"><input type="reset" value="Borrar datos" /> <input type="submit" value="Ingresar"/></div>
			  </form></center></div>
</div>
</div>
</div>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>


</body>
</html>