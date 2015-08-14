<?php

//Inicio del procesamiento
session_start();


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

<?php
include 'teatro2.php';

	if (isset($_REQUEST['operacion']))		$operacion=$_REQUEST['operacion'];
	
  $teatro= new teatro();
  $datos=$teatro->buscar_user($_SESSION['usuario']);
  $row=mysql_fetch_row($datos);  

  echo "<CENTER><P>
	 
	  <CENTER><FONT  COLOR= 'green'><b><h2>Editar perfil</b></h2> </FONT></CENTER>
	  <CENTER>
	  <FORM name = 'cambiar' method='post' enctype='multipart/form-data' ACTION='perfil.php?operacion=editar'>
	  <TABLE border='0' width='600' cellspacing='10' >
	        
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Usuario</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca un nombre de usuario' NAME='nombreUsuario' VALUE='".$row[0]."' SIZE='50'  MAXLENGTH='30'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nombre</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca nombre' NAME='nombre' VALUE='".$row[1]."' SIZE='50'  MAXLENGTH='50'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Apellidos</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='apellidos' VALUE='".$row[2]."' SIZE='50'  MAXLENGTH='50'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >DNI (*)</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca su DNI'  readonly='readonly'  NAME='dni' VALUE='".$row[3]."' SIZE='50'  MAXLENGTH='10'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Correo</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca su email' NAME='correo' VALUE='".$row[4]."' SIZE='50'  MAXLENGTH='50'></TD></TR>

			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Contraseña</FONT> </TD>
			<TD><INPUT TYPE='password' NAME='password'  VALUE='".$row[5]."' SIZE='50'  MAXLENGTH='20'></TD></TR>


			<TR><TD width='150'> <b>(*) Este campo no se puede modificar</b></TD></TR>
			</BR>		
	</TABLE>
	<INPUT TYPE='SUBMIT' VALUE='Guardar cambios'>
	</FORM>
	</CENTER>";
	
 if (isset($operacion)){
  	
	if ($operacion=='editar'){
	
		echo $_POST['nombreUsuario'];
	   $teatro =  new teatro();
	   $teatro->edit_user($_POST['nombreUsuario'], $_POST['nombre'], $_POST['apellidos'], $_POST['dni'], $_POST['correo'], $_POST['password']);
	   $teatro->_teatro();
	}
  }
?>	
<input type="button" value="Volver" onClick="location='index2.php'"/>
</BODY>
</HTML>