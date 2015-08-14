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

	if (isset($_REQUEST['bus'])){
	$bus=Inputs::numeroValido($_REQUEST['bus']);
	if($bus=="error"){
	header('Location:errorLogueado.php');
	}
	}
	if (isset($_REQUEST['id'])){
	$id=Inputs::numeroValido($_REQUEST['id']);
	if($id=="error"){
	header('Location:errorLogueado.php');
	}
	
	}
    if (isset($_REQUEST['operacion']))	$operacion=$_REQUEST['operacion'];	
	if (isset($operacion)){
  
	if ($operacion=="modificar") 
	{			
		$teatro= new DBHelper();
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
		$teatro->modificar($id,$nombreObra,  $nombreTeatro, $descripcion, $sesion1, $sesion2, $sesion3, $filas, $asientos);
		header('Location:index2.php');
	}
	
	 else{
		header('Location:errorLogueado.php');
	  } 
  }
  }
	$teatro= new DBHelper();
	$datos=$teatro->consulta($bus); //A traves del nombre de la obra

	//$row=mysql_fetch_row($datos);
	foreach($datos as $row3){
	    $id = $row3["id"];
	    $nombreTeatro= $row3["nombre_teatro"];
		$nombreObra=$row3["nombre_obra"];
        $descripcion=$row3["descripcion"];
		$ses1=$row3["sesion1"];
		$ses2=$row3["sesion2"];
		$ses3=$row3["sesion3"];
		$filas=$row3["nume_filas"];
		$asientos=$row3["nume_asientos"];
	
  echo "<CENTER><P>
	  <TABLE border='0' width='600'>
	  <TR>
	     <TD valign=top align=CENTER colspan=2>";
	     	
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
	  <CENTER><FONT  COLOR= 'green'><b>Modificar teatro</b> </FONT></CENTER>

	  <CENTER>
	  <FORM name = 'form2' method='post' enctype='multipart/form-data' ACTION='editar.php?operacion=modificar&id=$id'>
	<input type='hidden' name='token' value='$token' />
	  <TABLE border='0' width='600' cellspacing='10' >
	        
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Nombre del Teatro(*)</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca nombre del teatro' NAME='nombreTeatro' VALUE='$nombreTeatro' SIZE='40'  MAXLENGTH='20' required></TD></TR>
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nombre de la obra(*)</FONT> </TD>
			<TD><INPUT TYPE='text' title ='Introduzca nombre de la obra' NAME='nombreObra' VALUE='$nombreObra' SIZE='40'  MAXLENGTH='20'required></TD></TR>
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Descripcion</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='descripcion' VALUE='$descripcion' SIZE='60'  MAXLENGTH='100'></TD></TR>
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Sesion 1 (hora)</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='sesion1' VALUE='$ses1' SIZE='5'  MAXLENGTH='5'></TD></TR>
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Sesion 2 (hora)</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='sesion2' VALUE='$ses2' SIZE='5'  MAXLENGTH='5'></TD></TR>
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Sesion 3 (hora)</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='sesion3' VALUE='$ses3' SIZE='5'  MAXLENGTH='5'></TD></TR>
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nº filas del teatro</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='filas' VALUE='$filas' SIZE='2'  MAXLENGTH='3'></TD></TR>
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nº asientos por fila</FONT> </TD>
			<TD><INPUT TYPE='text' NAME='asientos' VALUE='$asientos' SIZE='2'  MAXLENGTH='2'></TD></TR>

			<TR><TD width='150'><b> (*) Obligatorios</b></TD></TR>
			</BR>		
	</TABLE>
	<INPUT TYPE='SUBMIT' VALUE='Modificar teatro'>
	</FORM>
	</CENTER>";
}
?>
</BODY>
</HTML>

