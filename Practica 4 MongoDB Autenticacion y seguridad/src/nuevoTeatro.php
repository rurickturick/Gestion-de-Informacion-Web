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
 
 
	 $teatro= new DBHelper();
	 $user=Inputs::usuarioValido($_SESSION['usuario']);
	 if($user=="error"){
		header('Location:errorLogueado.php');
	 }
	 $datos=$teatro->buscar_user($user);
	 foreach($datos as $row){
	 $row2=$row["rol"];  
	 } 
	 
    if (isset($_REQUEST['operacion']))		$operacion=$_REQUEST['operacion'];	
	if (isset($operacion)){
  	
	if ($operacion=="añadir"){
	   $teatro =  new DBHelper();
	   $num_obras=$teatro->nume_obras();
	   $id_obra=(string)$num_obras;
	   $nombreObra=Inputs::nombreObraValido($_POST['nombreObra']);
	   $nombreTeatro=Inputs::nombreTeatroValido($_POST['nombreTeatro']);
	   $descripcion=Inputs::descripcionValido($_POST['descripcion']);
	   $sesion1=Inputs::sesionValido($_POST['sesion1']);
	   $sesion2=Inputs::sesionValido($_POST['sesion2']);
	   $sesion3=Inputs::sesionValido($_POST['sesion3']);
	   $filas=Inputs::numeroValido($_POST['filas']);
	   $asientos=Inputs::numeroValido($_POST['asientos']);
	   if($nombreObra!="error" and $asientos!="error"  and $nombreTeatro!="error" and $descripcion!="error" and $sesion1!="error" and $sesion2!="error"
	   and $sesion3!="error" and $filas!="error" ){
	   $teatro->add_teatro($id_obra,$nombreObra ,  $nombreTeatro, $descripcion, $sesion1, $sesion2, $sesion3, $filas, $asientos);
	   header('Location:index2.php');
	   }
	   else{
		header('Location:errorLogueado.php');
	  }
	}
  }
  echo "<CENTER><P>
	  <TABLE border='0' width='600'>
	  <TR>
	     <TD valign=top align=CENTER colspan=2>";
		  if ($row2 == 'user'){
	     	echo "<FORM name='form1' METHOD='POST' ACTION='index2.php?operacion=buscar'>
				<input type='hidden' name='token' value='$token' />
	     	    <b>Buscar teatro </b>";
	     	    if (!isset($busqueda)) $busqueda="";
	     	    echo "<INPUT TYPE='TEXT' NAME='busqueda' value='$busqueda' size='20'> ";
	     	    echo "<INPUT TYPE='SUBMIT' NAME='boton_buscar' VALUE='!Buscar!'>
	     	</FORM>";}
			
			
	     echo "</TD></TR><TR><TD align=right>
	        <FORM name='form2' METHOD='POST' ACTION='index2.php?operacion=introducir'>
				<input type='hidden' name='token' value='$token' />
	            <INPUT TYPE='SUBMIT' NAME='alta' VALUE='Nuevo teatro'>
	        </FORM>
	     </TD><TD width=100 align=left>
	        <FORM name='form3' METHOD='POST' ACTION='index2.php?operacion=listado'>
				<input type='hidden' name='token' value='$token' />
	            <INPUT TYPE='SUBMIT' NAME='alta' VALUE='Listado completo'>
	        </FORM>
	     </TD>
	  </TR></TABLE></CENTER>
	  </BR>
	  </BR>
	  </BR>
	  </BR>
	  </BR>
	  <CENTER><FONT  COLOR= 'green'><b>Alta de nuevo teatro</b> </FONT></CENTER>
	  <CENTER>
	  <FORM name = 'form2' method='post' enctype='multipart/form-data' ACTION='nuevoTeatro.php?operacion=añadir'>
		<input type='hidden' name='token' value='$token' />
	  <TABLE border='0' width='600' cellspacing='10' >
	        
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Nombre del Teatro(*)</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca nombre del teatro' NAME='nombreTeatro' VALUE='' SIZE='40'  MAXLENGTH='20' required></TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nombre de la obra(*)</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca nombre de la obra' NAME='nombreObra' VALUE='' SIZE='40'  MAXLENGTH='20'required></TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Descripción</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='descripcion' VALUE='' SIZE='60'  MAXLENGTH='100'></TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Sesión 1 (hora)</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='sesion1' VALUE='16:00' SIZE='5'  MAXLENGTH='5'></TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Sesión 2 (hora)</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='sesion2' VALUE='19:00' SIZE='5'  MAXLENGTH='5'></TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Sesión 3 (hora)</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='sesion3' VALUE='22:00' SIZE='5'  MAXLENGTH='5'></TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nº filas del teatro</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='filas' VALUE='10' SIZE='2'  MAXLENGTH='3'></TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nº asientos por fila</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='asientos' VALUE='10' SIZE='2'  MAXLENGTH='2'></TD></TR>
			<TR><TD width='150'> <b>(*) Obligatorios</b></TD></TR>
			</BR>		
	</TABLE>
	<INPUT TYPE='SUBMIT' VALUE='Alta teatro'>
	</FORM>
	</CENTER>";
	

?>
</BODY>
</HTML>