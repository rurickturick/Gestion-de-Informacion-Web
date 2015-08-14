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
    if (isset($_REQUEST['operacion']))		$operacion=$_REQUEST['operacion'];
	if (isset($_REQUEST['bus'])){
	$bus=Inputs::nombreObraValido($_REQUEST['bus']);
	if($bus=="error"){
	header('Location:errorLogueado.php');
	}
	}
  echo "<CENTER><P>
	  <TABLE border='0' width='600'>
	  <TR>
	     <TD valign=top align=CENTER colspan=2>
	     	<FORM name='form1' METHOD='POST' ACTION='index2.php?operacion=buscar'>
					<input type='hidden' name='token' value='$token' />
	     	    <b>Buscar obra </b>";
	     	    if (!isset($busqueda)) $busqueda="";
	     	    echo "<INPUT TYPE='TEXT' NAME='busqueda' value='$busqueda' size='20'> ";
	     	    echo "<INPUT TYPE='SUBMIT' NAME='boton_buscar' VALUE='¡Buscar!'>
	     	</FORM>
	     </TD></TR><TR><TD align=right>
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
	  </TR></TABLE>
	    <h3>Resultados para la búsqueda: $bus</h3>
	  </br>";

	 $teatro= new DBHelper();
		 
	  $datos=$teatro->buscar($bus);
	  $nObras=$datos->count();
	 
	   if($nObras == '0')	   
	   {
		 echo"<center><table border='1' width='700' >
		<tr><td  align = 'center' > <b > <font size = '3'>Ningún resultado coincide con la búsqueda</font></b> </td></tr></table></center>
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
	   
	   foreach($datos as $row){
		$nombreTeatro= $row["nombre_teatro"];
		$nombreObra=$row["nombre_obra"];
        $descripcion=$row["descripcion"]; 
        $id=$row["id"];
		
	    echo"
	    <tr> <td> <b>$nombreTeatro</b>  </td><td> <b>$nombreObra</b> </td><td><b>$descripcion</b> </td><td >  <table border='0' width='100''> <center>

	       <tr><td><form name='form4' method='post' action='consulta.php?bus=$id'>
				<input type='hidden' name='token' value='$token' />
	          <input type='submit' name= 'consulta'style=' color:green;font-weight:bold;text-decoration:underline' value='Consulta'> </form></td>
	       
	      <td><form name='form6' method='post' action='comprar.php?bus=$id&edit=1'>
				<input type='hidden' name='token' value='$token' />
	          <input type='submit' name= 'comprar' style=' color:green;font-weight:bold;text-decoration:underline' value='Comprar'> </form> </td> 
	      
	      </tr> </center> </table> </td></tr>
	   ";
	   		
		}
	  };
	  
	  echo"</table>
	  <FONT  COLOR= 'green'><BR><b>El nº total de obras es : $nObras</b> </FONT></CENTER>
	  "; 
	 

 
?>
</BODY>
</HTML>

