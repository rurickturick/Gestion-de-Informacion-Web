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
	
	if (isset($_REQUEST['i'])) $i=$_REQUEST['i'];
	if (isset($_REQUEST['j'])) $j=$_REQUEST['j'];
	if (isset($_REQUEST['bus'])) $bus=$_REQUEST['bus'];
	if (isset($_REQUEST['dia'])) $dia=$_REQUEST['dia'];
	if (isset($_REQUEST['sesion'])) $sesion=$_REQUEST['sesion'];
	if (isset($_REQUEST['accion'])) $accion=$_REQUEST['accion'];
	if (isset($operacion)){
  	if ($operacion=="sesion"){
       $dia= $_POST['dia']  ;
	   $sesion= $_POST['ad']  ;
	 
     }
	
	if ($operacion=="color"){
       $teatro=new teatro();
	   $Id_teatro=$teatro->buscarId($bus);
	   $teatro->exec_comprar($Id_teatro, $sesion, $i, $j, $accion, $dia);
	   header('Location:comprar.php?bus='.$bus.'&dia='.$dia.'&sesion='.$sesion);
	 
     }	
	 }
	 if(!isset($sesion)) $sesion='Elija Sesion';
	 if(!isset($dia)) $dia='AAAA-MM-DD';
	 	
		 
	 
	
  echo "<CENTER><P>
	  <TABLE border='0' width='600'>
	  <TR>
	     <TD valign=top align=CENTER colspan=2>
	     	<FORM name='form1' METHOD='POST' ACTION='index2.php?operacion=buscar'>
	     	    <b>Buscar teatro</b> ";
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
	  $datos=$teatro->buscar($bus);
	  $row=mysql_fetch_row($datos);
	echo" <hr />
	<FORM name = 'form2' method='post' enctype='multipart/form-data' ACTION='comprar.php?operacion=sesion&bus=$bus'>
	 <table border='0'width='600> 
	 <tr>
	 <td bgcolor ='00FF00'  align='center' ><font color='FFFFFF' bgcolor='green' >   </font> </td>
	 <td bgcolor ='green'  align='center' ><font color='FFFFFF' bgcolor='green' > Nombre Teatro </font> </td>
	 <td><b>$row[1]</b> </td>
	 <td bgcolor ='green'  align='center' width=100 ><font color='FFFFFF' bgcolor='green' > Nombre Obra </font> </td>
	  <td>  <b>$bus</b></td> </tr>
	  <tr> <td bgcolor ='green'  align='center' ><font color='FFFFFF' bgcolor='green' > Sesión </font> </td>
	 <td> <b>Hora</b> <select name='ad' >
<option selected> $sesion
<option value='$row[4]'>$row[4]
<option value='$row[5]'>$row[5]
<option value='$row[6]'>$row[6]
</select> <b>Día </b></td>
<td>
		 <INPUT TYPE='TEXT' NAME='dia' value='$dia' size='20'> </td>
	    <td> <INPUT TYPE='SUBMIT' NAME='boton_buscar' VALUE='Cambiar sesion'>
		 </td>
	 </tr>
	  </table>
	 
	</FORM>
	  <br/>
	  <b>Escenario</b>
	  <hr width=13% />
	  </CENTER>
	";
	
	echo"<center>   <table border='0' width='1' > ";
	$Id_teatro1=$row[0];
	
	if($sesion!='Elija Sesion'){ 
		if($dia!='AAAA-MM-DD') {
	  for ($i=1;$i<=$row[7];$i++){
	   echo"<tr>";
	   for ($j=1;$j<=$row[8]; $j++){
	   
       if($teatro->disponible($row[0], $sesion, $dia,$i,$j)!=0){
	   echo"
	  <FORM name='form' method='post' ACTION='comprar.php?operacion=color&i=$i&j=$j&bus=$bus&dia=$dia&sesion=$sesion&accion=borrar'>
		<td  width ='1'align='center'><input type='submit' value='' style='background-color:#FF0000' '></td>
	  </FORM>
	   ";
	   }
	   else{
	   
	    echo"
	  <FORM name='form' method='post' ACTION='comprar.php?operacion=color&i=$i&j=$j&bus=$bus&dia=$dia&sesion=$sesion&accion=insertar'>
		<td  width ='1'align='center'><input type='submit' value='' style='background-color:#00FF00' '></td>
	  </FORM>
	   ";
	   }
	   }	    	
	   echo" </tr> ";
	  }
	echo"</table></center>";}}

?>
</BODY>
</HTML>

