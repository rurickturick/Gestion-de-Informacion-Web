 <!--
 Esta práctica pertenece a la asignatura de Gestion de Información Web del Grado de Ingeniería Informática de la Universidad Complutense de Madrid
 La siguiente implementación corresponde a la Práctica 3: MongoDB realizada por el Grupo 4 
 el cual está formado por los alumnos:
 -Claudia Gil Navarro
 -Ángel Luis Ortiz Folgado
 -Oscar Eduardo Pérez la Madrid
 -Esteban Vargas Rastrollo
 El siguiente código es fruto del trabajo y el esfuerzo únicamente de los miembros del grupo anteriormente citados.
  -->
<?php

//Inicio del procesamiento
session_start();

include 'teatro2.php';


	$usuario_nombre = $_POST['username']; 
	$usuario_clave = $_POST['password'];
	
    
	$teatro= new DBHelper();
	$datos = $teatro->datos_usr($usuario_nombre,$usuario_clave);
	
	if($datos)
	{
				echo $datos;
				$_SESSION['login'] = true;
				$_SESSION['usuario'] = $usuario_nombre;
	}
	else
		$_SESSION['login'] = false;
	
	
	

?>
<?php header('Content-type: text/html; charset=utf-8'); ?>

<HTML>
<HEAD><TITLE>Práctica-Teatros</TITLE>
   <STYLE  TYPE="text/css">
   <!--
	input
	{
	  font-family : Arial, Helvetica;
	  font-size : 14;
	  color : #000033;
	  font-weight : normal;
	  border-color : #999999;
	  border-width : 1;
	  background-color : #FFFFFF;
	}
   -->
   </style>
</HEAD>

<BODY bgcolor="#C0C0C0" link="green" vlink="green" alink="green">
<BASEFONT face="arial, helvetica">

<TABLE border="0" align="center" cellspacing="3" cellpadding="3" width="1000">
<TR><TH colspan="2" width="100%" bgcolor="green"><FONT size="6" color="white">Teatros</FONT></TH>
</TR></TABLE><P>

	<div id="contenido">
	<?php
		$acceso = $_SESSION["login"];
		if ($acceso) {
			header('Location:index2.php');
		} else {
			echo "<h1>ERROR</h1>";
			echo "<p>El usuario o contraseña no son válidos.</p>";

		}
	?>
	<input type="button" value="Volver" onClick="location='indexx.php'"/>
	</div>

</BODY>
</HTML>