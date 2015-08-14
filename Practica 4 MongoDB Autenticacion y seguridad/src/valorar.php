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
    font-size:200%;
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

.rating:not(:checked) > label:hover,
.rating:not(:checked) > label:hover ~ label {
    color: gold;
    text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
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

	//Obtengo los datos del usuario para saber su rol
	 $teatro= new DBHelper();
	 $user1=Inputs::usuarioValido($_SESSION['usuario']);
	 if($user1=="error"){
		header('Location:errorLogueado.php');
	 }
	 $datos=$teatro->buscar_user($user1);
	 foreach($datos as $row){
	 	$dni_user=$row["dni"]; 
	  	$rol=$row["rol"]; 
	 } 
	 
	 
	 if(isset($_POST['BotonGuardar'])){
		$num=Inputs::numeroValido($_POST['rating']);
		if($num=="error"){
			header('Location:errorLogueado.php');
		}
		$valor = $num;
		}
	 else
		$valor = 0;
		
    if (isset($_REQUEST['operacion']))$operacion=$_REQUEST['operacion'];	
	
	if (isset($_REQUEST['editarVal'])){
	$editar=Inputs::numeroBoolValido($_REQUEST['editarVal']);
	if($editar=="error") header('Location:errorLogueado.php');
	}
	if (isset($_REQUEST['fecha'])){ 
	$fecha=Inputs::fechaValido($_REQUEST['fecha']);
	if($fecha=="error")  header('Location:errorLogueado.php');
	}
	if (isset($_REQUEST['t'])){

	$t=Inputs::numeroValido($_REQUEST['t']);
	if($t=="error") header('Location:errorLogueado.php');
	}
    if (isset($operacion)){
  	
	if($operacion =="guardar")
	{
		$teatro= new DBHelper();
		$comentario = Inputs::comentarioValido($_POST['comentario']);
		echo $comentario;
		if($comentario=='error') {
		header('Location:errorLogueado.php');
		}
		else{
		$datosTeatro=$teatro->consulta($t); //consulta recibe el id del teatro

		foreach($datosTeatro as $doc){
	 		$nombreObra=$doc["nombre_obra"]; 
	  		
		
		$teatro->guardarValoracion($valor, $comentario, $t, $nombreObra, $dni_user,$fecha,$editar);
		header('Location:obrasCompradas.php');
		}
		
		}
	}
  
}
  echo "<CENTER><P>
	  <TABLE border='0' width='600'>
	  <TR>
	     <TD valign=top align=CENTER colspan=2>";
		    if ($rol == 'user'){
				echo "<FORM name='form1' METHOD='POST' ACTION='index2.php?operacion=buscar'>

					<input type='hidden' name='token' value='$token' />
					<b>Buscar teatro</b>";
				
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
				<input type='hidden' name='token' value='$token' />
	            <INPUT TYPE='SUBMIT' NAME='alta' VALUE='Nuevo teatro'>
	        </FORM>
	     </TD>";}
		 
		 
	     echo "<TD width=50 align=left>
	        <FORM name='form3' METHOD='POST' ACTION='index2.php?operacion=listado'>
				<input type='hidden' name='token' value='$token' />
	            <INPUT TYPE='SUBMIT' NAME='alta' VALUE='Listado completo'>
	        </FORM>
	     </TD>
	     <TD align=right>
	        <FORM name='editar' METHOD='POST' ACTION='perfil.php'>
				<input type='hidden' name='token' value='$token' />
	            <INPUT TYPE='SUBMIT' NAME='editar' VALUE='Editar perfil'>
	        </FORM>
	     </TD>
		 <TD >
	        <FORM name='compradas' METHOD='POST' ACTION='obrasCompradas.php'>
				<input type='hidden' name='token' value='$token' />
	            <INPUT TYPE='SUBMIT' NAME='obrasCompradas' VALUE='Ver Obras Compradas'>
	        </FORM>
	     </TD>
	  </TR></TABLE>";

	  $teatro= new DBHelper();
	  $nObras=$teatro->nume_obras();
	  echo"
	  <table border='0' width='900' >
	  <tr> 
		<td bgcolor='green' width='150' align='center' ><font color='FFFFFF' bgcolor='green'> Nombre teatro  </font></td>
		<td bgcolor='green' width='150' align='center'><font color='FFFFFF' bgcolor='green' >  Nombre obra </font> </td>
		<td bgcolor='green' width='150' align='center'><font color='FFFFFF' bgcolor='green' >  Asientos </font> </td>
		<td bgcolor='green' width='150' align='center'><font color='FFFFFF' bgcolor='green' >  Fecha </font> </td>
		<td bgcolor='green' width='210' align='center'><font color='FFFFFF' bgcolor='green' >  Valoracion </font> </td>
	</tr>";

	  $lista=$teatro->consulta($t);
	  foreach($lista as $doc){

	        $id_teatro=$doc["id"];
			$aux = $teatro->get_lista($id_teatro, $dni_user);
			$listado = "";
			$fecha="";
            $nume_filas=$doc["nume_filas"];
			$nombre_obra=$doc["nombre_obra"];
			$nombre_teatro=$doc["nombre_teatro"];
			foreach($aux as $row2){
				$suma = (($row2["fila"]-1)*($nume_filas) + $row2["asiento"]);
				$listado = $listado.$suma.", " ;
				$fecha = $row2["dia"];
			}
			
			$val = $teatro->getValoracion($dni_user, $id_teatro, $nombre_obra);
			
			$valoracion = 0 ;
		  $comentario = "";
		  $editarVal = 0; 
 
      
 	 foreach($val as $doc){
	
		$val_row=$val->count();
		$valoracion = $doc["valoracion"];
		$comentario = $doc["comentario"];
		$editarVal = 1;  // si ya hemos valorado antes y damos al boton guardar, avisamos que se tiene q hacer un update
	
	  }
			
	    echo"
	   <tr> 
			<td width ='150'> <b>$nombre_teatro</b>  </td>
			<td width ='150'> <b> $nombre_obra</b> </td>
			<td width ='150'> <b> $listado</b> </td>
			<td width ='150'> <b> $fecha</b> </td>
			<td width ='210'> 
		<form name ='formmm' METHOD='POST' ACTION='valorar.php?operacion=guardar&t=$t&fecha=$fecha&valor=$valor&editarVal=$editarVal'>
				<input type='hidden' name='token' value='$token' />
		
				<fieldset class='rating'>";
					
						$i = 5;
					while($i>0){
						if ($i == $valoracion)
							echo "<input type='radio' id='star$i' name='rating' value='$i' checked/><label for='star$i'>stars</label>";
						else
							echo "<input type='radio' id='star$i' name='rating' value='$i' /><label for='star$i'>stars</label>";
							
							$i=$i-1;
					}
						
				echo"</fieldset>
		</td>
		</tr>
		</table>
			<br>
				<br> 
				<b>Comentario:</b>
				<br>
				<br> 
				<textarea rows='4' cols='50' name='comentario' value ='guardar' > $comentario </textarea><br><br>
				<input type='submit' value='Guardar' name = 'BotonGuardar'>
		</form>
		";
	
	  };
	 


?>
</BODY>
</HTML>