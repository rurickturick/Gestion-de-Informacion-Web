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

<?php
include 'teatro2.php';
include 'inputs.php';
    if (isset($_REQUEST['operacion']))		$operacion=$_REQUEST['operacion'];
   $length=64;	
   if (isset($operacion)){
  	
	if ($operacion=="añadir"){
	$sal=mcrypt_create_iv($length, MCRYPT_DEV_RANDOM);
	$sal=bin2hex($sal);
	$password=Inputs::passwordValido($_POST['password']);
	echo $password;
	if($password=="error"){
		header('Location:error.php');
	}
	else{
	   $pass=$password;
	   $pass=$pass.$sal;
	   $pass=hash('sha256',$pass,false);
	   
	   $teatro =  new DBHelper();
	   $nombreUsuario=Inputs::usuarioValido($_POST['nombreUsuario']);
	   $nombre=Inputs::nombreUsuarioValido($_POST['nombre']);
	   $apellidos=Inputs::apellidosValido($_POST['apellidos']);
	   $dni=Inputs::dniValido($_POST['dni']);
	   $correo=Inputs::correoValido($_POST['correo']);
	   $rol=Inputs::validaRol($_POST['rol']);
	   
	   
	   
	   //$sal = $teatro->get_sal($nombreUsuario);
	   if($nombreUsuario != "error" and $nombre!="error" and $apellidos!="error" and $dni!="error" and $correo!="error" and $rol!="error"){
	   if($teatro->add_user($nombreUsuario, $nombre, $apellidos, $dni, $correo,$pass, $sal, $rol))
		header('Location:indexx.php');
		else  echo "El DNI introducido ya existe";
    }
	else header('Location:error.php');
  }
  }
  }
  echo "<CENTER><P>
	 
	  <CENTER><FONT  COLOR= 'green'><b><h2>Registro</b></h2> </FONT></CENTER>
	  <CENTER>
	  <FORM name = 'registro' method='post' enctype='multipart/form-data' ACTION='registro.php?operacion=añadir'>
	  <TABLE border='0' width='600' cellspacing='10' >
	        
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Usuario</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca un nombre de usuario'  required NAME='nombreUsuario' VALUE='' SIZE='50'  MAXLENGTH='30'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nombre</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca nombre' NAME='nombre' required VALUE='' SIZE='50'  MAXLENGTH='50'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Apellidos</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='apellidos' VALUE='' SIZE='50'  required MAXLENGTH='50'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >DNI</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca su DNI' NAME='dni' VALUE='' required SIZE='50'  MAXLENGTH='10'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Correo</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca su email' NAME='correo' VALUE='' required SIZE='50'  MAXLENGTH='50'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Contraseña</FONT> </TD>
			<TD><INPUT TYPE='password' NAME='password' VALUE='' SIZE='50' required  MAXLENGTH='20'></TD></TR>
				<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Elija su Rol</FONT> </TD> 
				<td><select name='rol' >
					
					<option  value='admin'>Administrador
					<option selected value='user'>Cliente
					</select> 
				</td></TR>


			<TR><TD width='150'> <b>Todos los campos son obligatorios</b></TD></TR>
			</BR>		
	</TABLE>

	<INPUT TYPE='SUBMIT' VALUE='Registrarme'>
	</FORM>
	</CENTER>";
	
 
?>	
		<input type="button" value="Volver" onClick="location='indexx.php'"/>
</BODY>
</HTML>