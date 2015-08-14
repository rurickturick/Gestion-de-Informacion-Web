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
	if (isset($_REQUEST['bus'])) $bus=$_REQUEST['bus'];
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
	  </TR></TABLE>";
	  $teatro= new teatro();
	 
	 
	  $lista=$teatro->buscar($bus);
	   $nObras=mysql_num_rows($lista);
	   
	   if($nObras == '0')	   
	   {
		   echo"<center><table border='1' width='700' >
		   <tr><td  align = 'center' > <b > <font size = '5'>No se encuentra ningún registro</font></b> </td></tr></table></center>
		   ";
	   }
	   else
	   {
	    echo"
	  <table border='0' width='1000' >
	  <tr> <td bgcolor='green' widht ='150'align='center'><font color='FFFFFF' bgcolor='green'> Nombre teatro  </font></td>
	  <td bgcolor='green' width='150'align='center'><font color='FFFFFF' bgcolor='green' >  Obra </font> </td>
	  <td bgcolor='green' width='250'align='center'><font color='FFFFFF' bgcolor='green'> Descripción</font> </td>
	  <td bgcolor='green' width='450'align='center'><font color='FFFFFF' bgcolor='green'> Operaciones </font></td></tr>";
	   
	   
		while ($row=mysql_fetch_row($lista)){
	    echo"
	    <tr> <td> <b>$row[1]</b>  </td><td> <b>$row[2]</b> </td><td><b>$row[3]</b> </td><td > <table border='0' width='100''> <center>
	       <tr><td><form name='form4' method='post' action='consulta.php?bus=$row[2]'>
	          <input type='submit' name= 'consulta'style=' color:green;font-weight:bold;text-decoration:underline' value='Consulta'> </form></td>
	       <td><form name='form5' method='post' action='editar.php?bus=$row[2]'>
	          <input type='submit' name= 'editar' style=' color:green;font-weight:bold;text-decoration:underline' value='Editar'> </form></td>
	      <td><form name='form6' method='post' action='comprar.php?bus=$row[2]'>
	          <input type='submit' name= 'comprar' style=' color:green;font-weight:bold;text-decoration:underline' value='Comprar'> </form> </td> 
	      <td> <form name='form7' method='post' action='index2.php?operacion=borrar&id=$row[0]'>
	          <input type='submit' name='borrar' style=' color:green ; font-weight:bold;text-decoration:underline'value='Borrar'   > </form></td></tr> </center> </table>  </td></tr>
	   ";
		}
	  };
	  
	  echo"</table>
	  <FONT  COLOR= 'green'><BR><b>El nº total de obras es : $nObras</b> </FONT></CENTER>
	  "; 
	$teatro->_teatro();  

 
?>
</BODY>
</HTML>

