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
.rating {
    float:left;
}

/* :not(:checked) is a filter, so that browsers that don’t support :checked don’t 
   follow these rules. Every browser that supports :checked also supports :not(), so
   it doesn’t make the test unnecessarily selective */
.rating:not(:checked) > input {
    position:absolute;
    top:-9999px;
    clip:rect(0,0,0,0);
}

.rating:not(:checked) > label {
    float:right;
    width:1em;
    padding:0 .1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:100%;
    line-height:1.2;
    color:#ddd;
    text-shadow:1px 1px #bbb, 2px 2px #666, .1em .1em .2em rgba(0,0,0,.5);
}

.rating:not(:checked) > label:before {
    content: '★ ';
}

.rating > input:checked ~ label {
    color: #f70;
    text-shadow:1px 1px #c60, 2px 2px #940, .1em .1em .2em rgba(0,0,0,.5);
}



.rating > input:checked + label:hover,
.rating > input:checked + label:hover ~ label,
.rating > input:checked ~ label:hover,
.rating > input:checked ~ label:hover ~ label,
.rating > label:hover ~ input:checked ~ label {
    color: #ea0;
    text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
}

.rating > label:active {
    position:relative;
    top:2px;
    left:2px;
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
	
	if (isset($_REQUEST['ordenar'])) {
		  	
	      $ordenar=Inputs::numeroBoolValido($_REQUEST['ordenar']);
		  if($ordenar=="error") header('Location:errorLogueado.php');
		  }
	else
	       $ordenar = 0; //por defecto 0(valoracion)
		   
		   
    if (isset($_REQUEST['operacion']))		$operacion=$_REQUEST['operacion'];	
	
	 $teatro= new DBHelper();
	 $user1=Inputs::usuarioValido($_SESSION['usuario']);
	 if($user1=="error"){
		header('Location:errorLogueado.php');
	 }
	 $datos=$teatro->buscar_user($user1);
	 foreach($datos as $row){
		 $row2=$row["rol"];  
	 }
  echo "<CENTER><P>
	  <TABLE border='0' width='600'>
	  <TR>
	     <TD valign=top align=CENTER colspan=2>";
	     	 if ($row2 == 'user'){
	     	echo "<FORM name='form1' METHOD='POST' ACTION='index2.php?operacion=buscar'>
					<input type='hidden' name='token' value='$token' />
	     	    <b>Buscar obra </b>";
	     	    if (!isset($busqueda)) $busqueda="";
	     	    echo "<INPUT TYPE='TEXT' NAME='busqueda' value='$busqueda' size='20'> ";
	     	    echo "<INPUT TYPE='SUBMIT' NAME='boton_buscar' VALUE='!Buscar!'></FORM>";}
	     	
			
			
	    echo " </TD>
		</TR>
		<TR>
			<TD align=left width='100'>";
		
		if ($row2 == 'admin'){
	        echo "<FORM name='form2' METHOD='POST' ACTION='index2.php?operacion=introducir'>
					<input type='hidden' name='token' value='$token' />
					<INPUT TYPE='SUBMIT' NAME='alta' VALUE='Nuevo teatro'>
				</FORM>";
		}
	     echo "</TD>
		
			<TD width=100 align=right>
				<FORM name='form3' METHOD='POST' ACTION='index2.php?operacion=listado'>
					<input type='hidden' name='token' value='$token' />
					<INPUT TYPE='SUBMIT' NAME='alta' VALUE='Listado completo'>
				</FORM>
			</TD>";
		  if ($row2 == 'user'){
			echo "<TD  width=100 align=left>
					<FORM name='compradas' METHOD='POST' ACTION='obrasCompradas.php'>
					<input type='hidden' name='token' value='$token' />
					<INPUT TYPE='SUBMIT' NAME='obrasCompradas' VALUE='Ver Obras Compradas'>
					</FORM>
				 </TD>";
		}
		 echo "
	  </TR></TABLE></CENTER>
	  
	  
	  <CENTER><FONT  COLOR= 'green'><b>Datos del teatro</b> </FONT></CENTER>
	  <CENTER>";

	  $teatro2= new DBHelper();

	  $datosTeatro=$teatro2->consulta($bus);

	   foreach($datosTeatro as $row3){
	    $id = $row3["id"];
	    $nombreTeatro= $row3["nombre_teatro"];
		$nombreObra=$row3["nombre_obra"];
        $descripcion=$row3["descripcion"];
		$ses1=$row3["sesion1"];
		$ses2=$row3["sesion2"];
		$ses3=$row3["sesion3"];
		$filas=$row3["nume_filas"];
		$asientos=$row3["nume_asientos"];
		
	  echo"
	  <TABLE border='0' width='600' cellspacing='10' >    	
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Nombre del Teatro(*)</FONT> </TD>
			<TD> <b> $nombreTeatro</b></TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nombre de la obra(*)</FONT> </TD>
			<TD> <b>$nombreObra</b> </TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Descripción</FONT> </TD>
			<TD> <b>$descripcion</b> </TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Sesión 1 (hora)</FONT> </TD>
			<TD><b>$ses1</b> </TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Sesión 2 (hora)</FONT> </TD>
			<TD><b>$ses2</b> </TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Sesión 3 (hora)</FONT> </TD>
			<TD><b>$ses3</b></TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nº filas del teatro</FONT> </TD>
			<TD><b>$filas</b> </TD></TR>
			<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green'>Nº asientos por fila</FONT> </TD>
			<TD><b>$asientos</b>  </TD></TR>
			
	</TABLE>
	
		
	</CENTER>";

	$valor= new DBHelper();
	$valoraciones=$valor->getValoraciones($id, $nombreObra,$ordenar);
	$nValoraciones=$valoraciones->count();
	$j=0;
    
	 if($nValoraciones == '0')	   
	   {
		 echo"<center><table border='1' width='700' >
		<tr><td  align = 'center' > <b > <font size = '3'>Lo sentimos, no hay ninguna valoración</font></b> </td></tr></table></center>
		";
	   }
	 else
	 {
	 echo"
	 <CENTER>
	  <TABLE border='0' width='750' cellspacing='10' >    	
		<TR><TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >
		<FORM name='form10' METHOD='POST' ACTION='consulta.php?bus=$bus&ordenar=0'>
			<input type='hidden' name='token' value='$token' />
			<INPUT TYPE='submit' NAME='valoracion' value='Valoracion' size='20' style='background-color:green'>
		</FORM>
		</FONT>
		</TD>
		<TD bgcolor='green' width='300'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Comentario</FONT> </TD>
		<TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >
		<FORM name='form11' METHOD='POST' ACTION='consulta.php?bus=$bus&ordenar=1'>
			<input type='hidden' name='token' value='$token' />
			<INPUT TYPE='submit' NAME='fecha' value='Fecha' size='20' style='background-color:green'>
		</FORM>
		</FONT> </TD>
		<TD bgcolor='green' width='150'><FONT  COLOR= 'FFFFFF' bgcolor='green' >Usuario</FONT> </TD></TR>";
		
      
	foreach($valoraciones as $doc){	
		$val=$doc["valoracion"];
		$comen=$doc["comentario"];
		$idteatro=$doc["id_teatro"];
		$nombreObra=$doc["nombre_obra"];
		$fecha=$doc["fecha"];
		$userDni=$doc["user_dni"];
		
		
		$user= new DBHelper();
		$usuarios = $user->buscar_dni($userDni);
		foreach($usuarios as $nombre_user){
		 $nombre_usuario = $nombre_user["usuario"];
		}
		

	 echo"
		<TR><TD> <b>
				<fieldset class='rating'>";		
					$i = 5;
					while($i>0){
										
						if ($i == $val)
							echo "<input type='radio' readonly='readonly'  id='star$i' name='rating$i$j' value='$i' checked/><label for='star$i'>'stars'</label>";
						else
							echo "<input type='radio' readonly='readonly'  id='' name='' value='$i' /><label for='star$i'>'stars'</label>";
							
							$i=$i-1;
					}
					$j=$j+1;
					echo"</fieldset>
					</b></TD>
		
		<TD><b> $comen</b></TD>
		<TD><b> $fecha</b></TD>
		<TD><b> $nombre_usuario</b></TD></TR>
	 
	 ";
	 }
	 echo "</TABLE>
	  </CENTER>";
	  }
	}
?>
</BODY>
</HTML>
