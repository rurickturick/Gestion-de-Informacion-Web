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
	 	$dni_user=$row["dni"]; 
	  	$rol=$row["rol"]; 
	 } 

    if (isset($_REQUEST['operacion']))		$operacion=$_REQUEST['operacion'];
	
	if (isset($_REQUEST['i'])) $i=$_REQUEST['i'];
	if (isset($_REQUEST['j'])) $j=$_REQUEST['j'];
	if (isset($_REQUEST['bus'])) $bus=$_REQUEST['bus'];
	if (isset($_REQUEST['dia'])) $dia=$_REQUEST['dia'];
	if (isset($_REQUEST['sesion'])) $sesion=$_REQUEST['sesion'];
	if (isset($_REQUEST['accion'])) $accion=$_REQUEST['accion'];
	
	
	if(isset($_REQUEST['edit'])) $edit = $_REQUEST['edit'];
	
	if (isset($operacion)){
  	if ($operacion=="sesion"){
       $dia= $_POST['dia']  ;
	   $sesion= $_POST['ad']  ;
	 
     }
	
	if ($operacion=="color"){

 	   $teatro= new DBHelper();	   
	   $var=$teatro->exec_comprar($bus, $dni_user,$sesion, $i, $j, $accion, $dia);
	   header('Location:comprar.php?bus='.$bus.'&dia='.$dia.'&sesion='.$sesion.'&edit='.$edit);
	 	
     }	
	 }
	 
	 if(!isset($sesion)) $sesion='Elija Sesion';
	 if(!isset($dia)) $dia='';
	 	
		 
	
  echo "<CENTER><P>
	  <TABLE border='0' width='600'>
	  <TR>
	     <TD valign=top align=CENTER colspan=2>";
	     	 if ($rol == 'user'){
	     	echo "<FORM name='form1' METHOD='POST' ACTION='index2.php?operacion=buscar'>
	     	    <b>Buscar obra </b>";
	     	    if (!isset($busqueda)) $busqueda="";
	     	    echo "<INPUT TYPE='TEXT' NAME='busqueda' value='$busqueda' size='20'> ";
	     	    echo "<INPUT TYPE='SUBMIT' NAME='boton_buscar' VALUE='¡Buscar!'></FORM>";}
	     
		 echo "</TD></TR><TR><TD align=right>";
	        if ($rol == 'admin'){
	        echo "<FORM name='form2' METHOD='POST' ACTION='index2.php?operacion=introducir'>
					<INPUT TYPE='SUBMIT' NAME='alta' VALUE='Nuevo teatro'>
				</FORM>";
		}
	     echo "</TD><TD width=100 align=left>
	        <FORM name='form3' METHOD='POST' ACTION='index2.php?operacion=listado'>
	            <INPUT TYPE='SUBMIT' NAME='alta' VALUE='Listado completo'>
	        </FORM>
	     </TD>
	  </TR></TABLE>";



	  $teatro2= new DBHelper();
	  $datosTeatro=$teatro2->consulta($bus); //consulta por el nombre de la obra

	  foreach($datosTeatro as $doc){
		$nombreTeatro= $doc["nombre_teatro"];
		$nombreObra=$doc["nombre_obra"];
        $s1=$doc["sesion1"];  
        $s2=$doc["sesion2"]; 
        $s3=$doc["sesion3"]; 
        $idteatro=$doc["id"];
        $filas=$doc["nume_filas"];
        $asientos=$doc["nume_asientos"];
	 


	echo" <hr />
	<FORM name = 'form2' method='post' enctype='multipart/form-data' ACTION='comprar.php?operacion=sesion&bus=$bus&edit=$edit'>
	 <table border='0'width='600> 
	 <tr>
	 <td bgcolor ='00FF00'  align='center' ><font color='FFFFFF' bgcolor='green' >   </font> </td>
	 <td bgcolor ='green'  align='center' ><font color='FFFFFF' bgcolor='green' > Nombre Teatro </font> </td>
	 <td><b>$nombreTeatro</b> </td>

	 <td bgcolor ='green'  align='center' width=100 ><font color='FFFFFF' bgcolor='green' > Nombre Obra </font> </td>
	  <td>  <b> $nombreObra </b></td> </tr>

	  <tr> <td bgcolor ='green'  align='center' ><font color='FFFFFF' bgcolor='green' > Sesión </font> </td>
	 <td> <b>Hora</b> <select name='ad' >
		<option selected> $sesion
			<option value=$s1> $s1
			<option value=$s2> $s2
			<option value=$s3> $s3
		</select> <b>Día </b></td>
	<td>";
}
echo"

		 <INPUT TYPE='date' NAME='dia' value='$dia' size='20'> </td>
	    <td> <INPUT TYPE='SUBMIT' NAME='boton_buscar' VALUE='Cambiar sesion'>
		 </td>
	 </tr>
	  </table>
	 
	</FORM>
	  <br/>
	  <b>Escenario</b>
	  <hr width=13% />
	  </CENTER>



	<center>   <table border='0' width='1' > ";
	
	if($sesion!='Elija Sesion'){ 
		if($dia!='') {
	  for ($i=1;$i<=$filas;$i++){
	   echo"<tr>";
	   
	   for ($j=1;$j<=$asientos; $j++){
	   $teatro3= new DBHelper();
	   if($edit == '1'){
	   
			if($teatro3->disponible($bus, $sesion, $dia,"$i","$j") != 0){
			
			echo"
				<FORM name='form' method='post' ACTION='comprar.php?operacion=color&i=$i&j=$j&bus=$bus&dia=$dia&sesion=$sesion&accion=borrar&edit=$edit'>
				<td  width ='1'align='center'><input type='submit' value='' style='background-color:#FF0000' '></td>
				</FORM>";
			}
			else{ 
			echo "<FORM name='form' method='post' ACTION='comprar.php?operacion=color&i=$i&j=$j&bus=$bus&dia=$dia&sesion=$sesion&accion=insertar&edit=$edit'>
					<td  width ='1'align='center'><input type='submit' value='' style='background-color:#00FF00' '></td>
				 </FORM>";
			}
	   }
	   else
	   {
			if($teatro3->disponible($bus, $sesion, $dia,"$i","$j") != 0){
			
			echo "<td  width ='1' align='center'>
				<input type='submit' value='' style='background-color:#FF0000' '>
				  </td>";
			}
			else{ 
			echo "<td  width ='1' align='center'>
				<input type='submit' value='' style='background-color:#00FF00' '>
				  </td>";
			}
	   }
	   }	    	
	   echo" </tr> ";
	  }
	  }
	  }

	echo "</table></center>";

?>
</BODY>
</HTML>