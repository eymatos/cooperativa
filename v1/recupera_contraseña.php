<?php 


require_once('Connections/sgstec.php'); ?>
<?php
include('funciones/functions.php');
//initialize the session

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

<div id="login">
		<p><h1 style="color:#0E9801;">Introduce tu cédula</h1></p>
		<form id="loginform" ACTION="recupera_contraseña.php" method="POST" id="login_form">
            	<p><label>Cédula:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </label><input type="text" placeholder="" name="cedula" id="cedula" /></p>
                <p style="font-style: italic;font-size: 12px;color: gray;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(000-0000000-0)</p>
				     <br>         <input class="btn-primary" type="submit" value="Enviar"/></div>
			  <br>
			 
            </form>
	

<?php
date_default_timezone_set('America/Puerto_Rico');





$cedula= $_POST["cedula"];

if ($cedula){
$server_link = mysqli_connect("localhost", "cooproco_n", "procon01","cooproco_n");
$query2="SELECT * FROM usuarios WHERE `cedula`='$cedula'";
$resultado2=mysqli_query($server_link,$query2);
$conteo2 = mysqli_num_rows($resultado2);
if ($conteo2 < 1){
	$mensaje = 'La cédula insertada no existe en nuestra base de datos';
	$status = False;
}
else{
while ($row = mysqli_fetch_array($resultado2)){

$email=$row['email'];}

$to = "$email";
$subject = "Solicitud de cambio de contraseña";
$message = "Hemos recibido una solicitud de cambio de contraseña para tu cuenta de Cooprocon.com.

Si no has solicitado un cambio de contraseña, ignora este correo electrónico y no se realizará ningún cambio en tu cuenta. Puede que otro usuario haya introducido tu cédula por equivocación.

Para cambiar tu contraseña, hacer click al siguiente enlace:

https://cooprocon.com/password.php?cedula=$cedula";

mail($to, $subject, $message);
	$mensaje = 'Se ha enviado un requerimiento de cambio de contraseña al correo '.$email;
	
}
echo '<div>Se ha enviado un enlace a tu correo electrónico registrado en cooprocon, sino cuenta con un correo registrado, por favor comunicarse con la administración.</div>';

}


 ?>	
 </center>
 

</section>
	<footer>
	<center style="background:#232F3E;color:white;font-weight:bold;">© 2021 COOPROCON</center>
<div id="footer"></div></footer>
</body>
</html>