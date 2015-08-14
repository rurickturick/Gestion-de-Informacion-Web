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

    if (isset($_REQUEST['operacion']))$operacion=$_REQUEST['operacion'];
	
    if (isset($_REQUEST['id'])) $id=$_REQUEST['id'];
	
    if (isset($operacion)){
		if ($operacion=="introducir"){
			$teatro= new DBHelper();
			$teatro->datos_teatro();
	  
		}	
		else if ($operacion=="borrar") {
					$teatro= new DBHelper();
					$teatro->del_teatro($id);
		}
		else if ($operacion=="buscar") {
					$teatro= new DBHelper();
					$teatro->mostrarBusqueda($_POST['busqueda']);
				
		}
	}
	
  echo "<CENTER><P>
	  <TABLE border='0' width='600'>
	  <TR>
	     <TD valign=top align=CENTER colspan=2>";
		    if ($row2 == 'user'){
				echo "<FORM name='form1' METHOD='POST' ACTION='index2.php?operacion=buscar'>
					<b>Buscar obra</b>";
				
					if (!isset($busqueda)) 
							$busqueda="";
							
					echo "<INPUT TYPE='TEXT' NAME='busqueda' value='$busqueda' size='20'> ";
					echo "<INPUT TYPE='SUBMIT' NAME='boton_buscar' VALUE='¡Buscar!'></FORM>";
			}
				
			echo "</TD></TR>";	
	     
		 if ($row2 == 'admin'){
				echo      "<TD align=right>
							<FORM name='form2' METHOD='POST' ACTION='index2.php?operacion=introducir'>
							<INPUT TYPE='SUBMIT' NAME='alta' VALUE='Nuevo teatro'>
							</FORM>
						  </TD>";
		 }
		 
		 
	     echo "<TD width=50 align=left>
				<FORM name='form3' METHOD='POST' ACTION='index2.php?operacion=listado'>
					<INPUT TYPE='SUBMIT' NAME='alta' VALUE='Listado completo'>
				</FORM>
			  </TD>
			  <TD align=right>
				<FORM name='editar' METHOD='POST' ACTION='perfil.php'>
					<INPUT TYPE='SUBMIT' NAME='editar' VALUE='Editar perfil'>
				</FORM>
			  </TD>";
		 
		  if ($row2 == 'user'){
			echo "<TD >
					<FORM name='compradas' METHOD='POST' ACTION='obrasCompradas.php'>
					<INPUT TYPE='SUBMIT' NAME='obrasCompradas' VALUE='Ver Obras Compradas'>
					</FORM>
				 </TD>";
		}
	  
	  echo "</TR></TABLE>";

	  $teatro= new DBHelper();
	  $nObras=$teatro->nume_obras();
	  echo"
	  <table border='0' width='800' >
	  <tr> 
		<td bgcolor='green' width ='150'align='center'><font color='FFFFFF' bgcolor='green'> Nombre teatro  </font></td>
		<td bgcolor='green' width='150'align='center'><font color='FFFFFF' bgcolor='green' >  Obra </font> </td>
		<td bgcolor='green' width='250'align='center'><font color='FFFFFF' bgcolor='green'> Descripción</font> </td>
		<td bgcolor='green' width='250'align='center'><font color='FFFFFF' bgcolor='green'> Operaciones </font></td>
	 </tr>";
	 
	  $lista=$teatro->listar();
	  
	  foreach($lista as $row){
	    $id = $row["id"];
	    $nombreTeatro= $row["nombre_teatro"];
		$nombreObra=$row["nombre_obra"];
        $descripcion=$row["descripcion"];	   
		echo"
		
	   <tr> 
		<td> <b>$nombreTeatro</b>  </td>
		<td> <b> $nombreObra</b> </td>
		<td><b>$descripcion</b> </td>
		<td > <table border='0' width='100''> 
		    <center>
	       
		      <td><form name='form4' method='post' action='consulta.php?bus=$id'>
	          <input type='submit' name= 'consulta'style=' color:green;font-weight:bold;text-decoration:underline' value='Consulta'> </form>
			  </td>";
		   
		   if ($row2 == 'admin'){
	          echo "<td><form name='form5' method='post' action='editar.php?bus=$id'>
					<input type='submit' name= 'editar' style=' color:green;font-weight:bold;text-decoration:underline' value='Editar'> </form></td>
					
					<td><form name='form6' method='post' action='comprar.php?bus=$id&edit=0'> 
					<input type='submit' name= 'comprar' style=' color:green;font-weight:bold;text-decoration:underline' value='Localidades'> </form> </td> 
					
					<td> <form name='form7' method='post' action='index2.php?operacion=borrar&id=$id '>
					<input type='submit' name='borrar' style=' color:green ; font-weight:bold;text-decoration:underline'value='Borrar'   > </form></td></tr>";	
		  }
		  else
		  {
				echo  "<td><form name='form6' method='post' action='comprar.php?bus=$id&edit=1'> 
				<input type='submit' name= 'comprar' style=' color:green;font-weight:bold;text-decoration:underline' value='Comprar'> </form> </td> ";
		  }
	
			echo  "</td></tr></table>";
	}
	  echo"<FONT COLOR= 'green'>El nº total de obras es : $nObras </FONT></CENTER>" ;
	  
?>
</BODY>
</HTML>