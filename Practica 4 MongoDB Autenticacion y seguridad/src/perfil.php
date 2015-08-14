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
if (!isset($_SESSION['token']) OR ($_POST['token'] != $_SESSION['token'])){ 
      header('Location:error.php');
}
else
{
	$token = $_SESSION['token'];
}

?>

<?php header('Content-type: text/html; charset=utf-8'); ?>
<HTML>
<HEAD><TITLE>Práctica-Teatros</TITLE>
   <STYLE  TYPE="text/css">
   
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
	

  $teatro= new DBHelper();
   $user1=Inputs::usuarioValido($_SESSION['usuario']);
	 if($user1=="error"){
		header('Location:errorLogueado.php');
	 }
  else{
  $datos=$teatro->buscar_user($user1);
  $user=$datos->count();
  if ($user = '1'){ 

  	foreach($datos as $row){
		$usuario= $row["usuario"];
		$nombre=$row["nombre"];
		$apellidos=$row["apellidos"];
		$dni=$row["dni"];
		$correo=$row["correo"];
		$password=$row["password"];
        $rol=$row["rol"]; 
 }
 }
	if (isset($_REQUEST['operacion']))		
		$operacion=$_REQUEST['operacion'];
	else
		$operacion ="";
	

	if ($operacion=='editar'){
	
	   $nombreUsuario=Inputs::usuarioValido($_POST['nombreUsuario']);
	   $nombre=Inputs::nombreUsuarioValido($_POST['nombre']);
	   $apellidos=Inputs::apellidosValido($_POST['apellidos']);
	   $dni=Inputs::dniValido($_POST['dni']);
	   $correo=Inputs::correoValido($_POST['correo']);
	   $rol=Inputs::validaRol($_POST['rol']);
	   
	   
	   
	   $sal = $teatro->get_sal($nombreUsuario);
	   if($nombreUsuario != "error" and $nombre!="error" and $apellidos!="error" and $dni!="error" and $correo!="error" and $rol!="error"){
	   if($teatro->edit_user($nombreUsuario,$nombre ,$apellidos ,$dni ,$correo , $password,$sal,$rol )){
		 header('Location:indexx.php');
	   }
	   else{
		echo "No se han podido modificar los datos... ";
	   }
	   }
	   else header('Location:errorLogueado.php');
	}
  

  

  echo "<CENTER><P>
	 
	  <CENTER><FONT  COLOR= 'green'><b><h2>Editar perfil</b></h2> </FONT></CENTER>
	  <CENTER>
	  <FORM name = 'cambiar' method='post' enctype='multipart/form-data' ACTION='perfil.php?operacion=editar'>
	  <input type='hidden' name='token' value='$token' />
	  <TABLE border='0' width='600' cellspacing='10' >
	        
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Usuario (*)</FONT> </TD>
			<TD><INPUT TYPE='text'  NAME='nombreUsuario'readonly = 'readonly' VALUE='$usuario' required SIZE='50'  MAXLENGTH='30'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nombre</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca nombre' NAME='nombre' VALUE='$nombre'required SIZE='50'  MAXLENGTH='50'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Apellidos</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='apellidos' VALUE='$apellidos' required SIZE='50'  MAXLENGTH='50'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >DNI (*)</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='dni' readonly = 'readonly' VALUE='$dni' required SIZE='50'  MAXLENGTH='50'></TD>
            <TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Contraseña</FONT> </TD>
			<TD> <a href='cambiarPass.php'>Cambiar contraseña</a></TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Correo</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca su email' NAME='correo' VALUE='$correo' required SIZE='50'  MAXLENGTH='50'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Rol (*)</FONT> </TD> 
				<TD><INPUT TYPE='text' NAME='rol' readonly = 'readonly' VALUE='$rol' required SIZE='50'  MAXLENGTH='50'></TD></TR></TR>

			<TR><TD width='150'> <b>(*) Este campo no se puede modificar</b></TD></TR>
			</BR>		
	</TABLE>
	<INPUT TYPE='SUBMIT' VALUE='Guardar cambios'>
	</FORM>
	</CENTER>";
	
}
?>	
<input type="button" value="Volver" onClick="location='index2.php'"/>

</BODY>
</HTML>