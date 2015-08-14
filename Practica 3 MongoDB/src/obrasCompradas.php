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
	 
    if (isset($_REQUEST['operacion']))$operacion=$_REQUEST['operacion'];
    if (isset($_REQUEST['id'])) $id=$_REQUEST['id'];
	if (isset($_REQUEST['teat'])) $teat=$_REQUEST['teat'];
	if (isset($_REQUEST['valor'])) $valor=$_REQUEST['valor'];
    if (isset($operacion)){
  	if ($operacion=="introducir"){
       $teatro= new DBHelper();
	   $teatro->datos_teatro();
	  
     }	
 else
	if ($operacion=="borrar") {
					$teatro= new DBHelper();
					$teatro->del_teatro($id);
					
					
  
  }
  else 
    if ($operacion=="buscar") {
					$teatro= new DBHelper();
					$teatro->mostrarBusqueda($_POST['busqueda']);
				
     }

  
}
  echo "<CENTER><P>
	  <TABLE border='0' width='600'>
	  <TR>
	     <TD valign=top align=CENTER colspan=2>";
		    if ($rol == 'user'){
				echo "<FORM name='form1' METHOD='POST' ACTION='index2.php?operacion=buscar'>
					<b>Buscar obra</b>";
				
					if (!isset($busqueda)) 
							$busqueda="";
							
					echo "<INPUT TYPE='TEXT' NAME='busqueda' value='$busqueda' size='20'> ";
					echo "<INPUT TYPE='SUBMIT' NAME='boton_buscar' VALUE='¡Buscar!'>";
				}
				
	     echo	"</FORM>
	     </TD></TR>";
		 if ($rol == 'admin'){
		echo      "<TR><TD align=right>
	        <FORM name='form2' METHOD='POST' ACTION='index2.php?operacion=introducir'>
	            <INPUT TYPE='SUBMIT' NAME='alta' VALUE='Nuevo teatro'>
	        </FORM>
	     </TD>";}
		 
		 
	     echo "<TD width=50 align=left>
	        <FORM name='form3' METHOD='POST' ACTION='index2.php?operacion=listado'>
	            <INPUT TYPE='SUBMIT' NAME='alta' VALUE='Listado completo'>
	        </FORM>
	     </TD>
	     <TD align=right>
	        <FORM name='editar' METHOD='POST' ACTION='perfil.php'>
	            <INPUT TYPE='SUBMIT' NAME='editar' VALUE='Editar perfil'>
	        </FORM>
	     </TD>
		 <TD >
	        <FORM name='compradas' METHOD='POST' ACTION='obrasCompradas.php'>
	            <INPUT TYPE='SUBMIT' NAME='obrasCompradas' VALUE='Ver Obras Compradas'>
	        </FORM>
	     </TD>
	  </TR></TABLE>";
      
	   

	  $teatro= new DBHelper(); 

	  $listaOb=$teatro->listar_Obras($dni_user);


	  if (count($listaOb) == 0){

	  	echo"<center><table border='1' width='700' >
		<tr><td  align = 'center' > <b > <font size = '3'>Aún no has comprado ninguna entrada</font></b> </td></tr></table></center>
		";
	  }
	  else{

	  echo"
	  <table border='0' width='750' >
	  <tr> <td bgcolor='green' width ='150'align='center'><font color='FFFFFF' bgcolor='green'> Nombre teatro  </font></td>
	  <td bgcolor='green' width='150'align='center'><font color='FFFFFF' bgcolor='green' >  Nombre obra </font> </td>
	  <td bgcolor='green' width='150'align='center'><font color='FFFFFF' bgcolor='green' >  Asientos </font>
	  <td bgcolor='green' width='150'align='center'><font color='FFFFFF' bgcolor='green' >  Fecha </font>	  </td>
	  <td bgcolor='green' width='150'align='center'><font color='FFFFFF' bgcolor='green' > Operaciones </font> </td>";

	  $lista=$teatro->listar_Obras($dni_user);
	
	  $tam=count($lista);
	  for ($i=0; $i<$tam;$i++){
		

        $id=$lista[$i];
	
        $tmp=$teatro->consulta($id);
		foreach($tmp as $tmp2){
		  $nume_filas=$tmp2["nume_filas"];
		  $nom_teatro=$tmp2["nombre_teatro"];
		  $nom_obra=$tmp2["nombre_obra"];
		
	        
			$aux = $teatro->get_lista($id, $dni_user);
			$listado = " ";
			$fecha = "";

			foreach($aux as $doc){
				$suma = (($doc["fila"]-1)*($nume_filas) + $doc["asiento"]);
				$listado = $listado.$suma.", " ;
				$fecha = $doc["dia"];
			}
			
			
	    echo"
	   <tr> 
			<td> <b>$nom_teatro</b>  </td>
			<td> <b> $nom_obra</b> </td>
			<td> <b> $listado</b> </td>
			<td> <b> $fecha</b> </td>
			
			<td > <table border='0' width='100'> <center>
				<tr>
					<td><form name='form4' method='post' action='consulta.php?bus=$id'>
						<input type='submit' name= 'consulta'style=' color:green;font-weight:bold;text-decoration:underline' value='Consulta'> 
						</form>
				   </td>
				   <td>
						<form name='form5' method='post' action='valorar.php?t=$id'>
							<input type='submit' name= 'Valorar 'style=' color:green;font-weight:bold;text-decoration:underline' value='Valorar'> 
						</form>
				   </td>
				</tr>"
	       ;
		   
		 
	
			echo  "</center> </table>  </td></tr>
	   ";
	   }
	  };
	  echo"</table>"; 
	  
	   }
			
?>
</BODY>
</HTML>