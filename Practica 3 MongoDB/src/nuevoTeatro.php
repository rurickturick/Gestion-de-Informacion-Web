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
 
 
	$teatro= new DBHelper();
	 $datos=$teatro->buscar_user($_SESSION['usuario']);
	 foreach($datos as $row){
	 $row2=$row["rol"];  
	 } 
	 
    if (isset($_REQUEST['operacion']))		$operacion=$_REQUEST['operacion'];	
	if (isset($operacion)){
  	
	if ($operacion=="añadir"){
	   $teatro =  new DBHelper();
	   $num_obras=$teatro->nume_obras();
	   $id_obra=(string)$num_obras;
	   $teatro->add_teatro($id_obra, $_POST['nombreObra'],  $_POST['nombreTeatro'], $_POST['descripcion'], $_POST['sesion1'], $_POST['sesion2'], $_POST['sesion3'], $_POST['filas'], $_POST['asientos']);
	  
		header('Location:index2.php');
	}
  }
  echo "<CENTER><P>
	  <TABLE border='0' width='600'>
	  <TR>
	     <TD valign=top align=CENTER colspan=2>";
		  if ($row2 == 'user'){
	     	echo "<FORM name='form1' METHOD='POST' ACTION='index2.php?operacion=buscar'>
	     	    <b>Buscar teatro </b>";
	     	    if (!isset($busqueda)) $busqueda="";
	     	    echo "<INPUT TYPE='TEXT' NAME='busqueda' value='$busqueda' size='20'> ";
	     	    echo "<INPUT TYPE='SUBMIT' NAME='boton_buscar' VALUE='!Buscar!'>
	     	</FORM>";}
			
			
	     echo "</TD></TR><TR><TD align=right>
	        <FORM name='form2' METHOD='POST' ACTION='index2.php?operacion=introducir'>
	            <INPUT TYPE='SUBMIT' NAME='alta' VALUE='Nuevo teatro'>
	        </FORM>
	     </TD><TD width=100 align=left>
	        <FORM name='form3' METHOD='POST' ACTION='index2.php?operacion=listado'>
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