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
    if (isset($_REQUEST['bus'])) $bus=$_REQUEST['bus'];
    if (isset($_REQUEST['operacion']))		$operacion=$_REQUEST['operacion'];	
  echo "<CENTER><P>
	  <TABLE border='0' width='600'>
	  <TR>
	     <TD valign=top align=CENTER colspan=2>
	     	<FORM name='form1' METHOD='POST' ACTION='index2.php?operacion=buscar'>
	     	    <b>Buscar teatro </b>";
	     	    if (!isset($busqueda)) $busqueda="";
	     	    echo "<INPUT TYPE='TEXT' NAME='busqueda' value='$busqueda' size='20'> ";
	     	    echo "<INPUT TYPE='SUBMIT' NAME='boton_buscar' VALUE='¡Buscar!'>
	     	</FORM>
	     </TD></TR><TR><TD align=right>
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
	  <CENTER><FONT  COLOR= 'green'><b>Datos del teatro</b> </FONT></CENTER>
	  <CENTER>";
	  $teatro= new teatro();
	  $datos=$teatro->buscar($bus);
	  $row=mysql_fetch_row($datos);
	  echo"
	  <TABLE border='0' width='600' cellspacing='10' >
	        
			
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Nombre del Teatro(*)</FONT> </TD>
			<TD> <b> $row[1]</b></TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nombre de la obra(*)</FONT> </TD>
			<TD> <b>$row[2]</b> </TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Descripción</FONT> </TD>
			<TD> <b>$row[3]</b> </TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Sesión 1 (hora)</FONT> </TD>
			<TD><b>$row[4]</b> </TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Sesión 2 (hora)</FONT> </TD>
			<TD><b>$row[5]</b> </TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Sesión 3 (hora)</FONT> </TD>
			<TD><b>$row[6]</b></TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nº filas del teatro</FONT> </TD>
			<TD><b>$row[7]</b> </TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nº asientos por fila</FONT> </TD>
			<TD><b>$row[8]</b>  </TD></TR>
			<TR><TD width='150'> <b>(*) Obligatorios</b></TD></TR>
			
	</TABLE>
	</CENTER>";
	$teatro->_teatro();
?>
</BODY>
</HTML>
