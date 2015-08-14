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
if (!isset($_SESSION['token'])) {
	if (!isset($_POST['token']))
		$token = $_SESSION['token'];
	else if ($_POST['token'] != $_SESSION['token'])   
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
 $length=64;
$teatro= new DBHelper();
$user1=Inputs::usuarioValido($_SESSION['usuario']);
	 if($user1=="error"){
		header('Location:errorLogueado.php');
	 }
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
	    $nuevaPass = Inputs::passwordValido($_POST['nuevaPass']);
		$passAct = Inputs::passwordValido($_POST['PassAct']);
		if($nuevaPass=="error" or $passAct=="error"){
			header('Location:errorLogueado.php');
		}
		else{
	    $datos = $teatro->datos_usr($usuario,$passAct);
		if($datos){
		$sal=mcrypt_create_iv($length, MCRYPT_DEV_RANDOM);
		$sal=bin2hex($sal);
	    $pass=$nuevaPass;
	    $pass=$pass.$sal;
	    $pass=hash('sha256',$pass,false);
	
	   if($teatro->edit_user($usuario, $nombre, $apellidos,$dni, $correo, $pass,$sal, $rol)){
		 header('Location:indexx.php');
	   }
	   else{
		echo "No se ha podido cambiar la contraseña... ";
	   }
	   }
	    else{
		echo "No se ha podido cambiar la contraseña... ";
	  }
	
	}
  
     }
  

  echo "<CENTER><P>
	 
	  <CENTER><FONT  COLOR= 'green'><b><h2>Editar Contraseña</b></h2> </FONT></CENTER>
	  <CENTER>
	  <FORM name = 'cambiar' method='post' enctype='multipart/form-data' ACTION='cambiarPass.php?operacion=editar'>
			<input type='hidden' name='token' value='$token' />
	  <TABLE border='0' width='600' cellspacing='10' >
	        
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Contraseña Actual</FONT> </TD>
			<TD><INPUT type='password' title ='Introduzca contraseña actual' NAME='PassAct' VALUE='' required SIZE='50'  MAXLENGTH='30'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nueva Contraseña</FONT> </TD>
			<TD><INPUT type='password' title ='Introduzca nueva contraseña' NAME='nuevaPass' VALUE='' required SIZE='50'  MAXLENGTH='50'></TD></TR>


			</BR>		
	</TABLE>
	<INPUT TYPE='SUBMIT' VALUE='Guardar Contraseña'>
	</FORM>
	</CENTER>";
	

?>	
<input type="button" value="Volver" onClick="location='index2.php'"/>

</BODY>
</HTML>