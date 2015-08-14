<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
class teatro {
  	
  	private $datos;
  	private $id_conexion;
  	
	//Constructor
  	function teatro ()
  	{
  	  //Datos propios de la base de datos	  
	  $DBHost="localhost";
	  $DBUser="root";
	  $DBPass="";
	  $DB="practica";
	  
  	  /* Intentamos establecer una conexión persistente con el servidor.*/
  	  $this->id_conexion = @mysql_pconnect($DBHost, $DBUser, $DBPass) or
  	  		die("<CENTER><H3>No se ha podido establecer la conexión.
  	  			<P>Compruebe si está activado el servidor de bases de datos MySQL.</H3></CENTER>");
  	  			
  	  /* Intentamos seleccionar la base de datos. Si no se consigue, se informa de ello y se indica cuál es el motivo del fallo con el n?mero y el mensaje de error.*/
  	  if (!mysql_select_db($DB))
  	  	printf("<CENTER><H3>No se ha podido seleccionar la base de datos\"$DB\": <P>%s",'Error nº '.mysql_errno().'.-'.mysql_error());
	}
	
	//Destructor
	function _teatro ()
	{
	  /* Liberamos la conexión persistente con el servidor.*/
	  if (isset($this->datos)) mysql_free_result($this->datos);
	  if (isset($this->id_conexion)) mysql_close($this->id_conexion);
	}
	
	// Añade un teatro
	function add_teatro($registro, $nombre_obra, $nombre_teatro, $descripcion, $sesion1, $sesion2, $sesion3, $nume_filas, $nume_asientos)
	{
       //Ejecuta un insert sobre la tabla "teatro"
	   $query = "INSERT INTO teatro (`Id`, `nombre_teatro`, `nombre_obra`, `descripcion`, `sesion1`, `sesion2`, `sesion3`, `nume_filas`, `nume_asientos`) VALUES ('$registro',  '$nombre_teatro','$nombre_obra', '$descripcion', '$sesion1', '$sesion2', '$sesion3', '$nume_filas', '$nume_asientos')";
					
	   $consulta = mysql_query ($query,$this->id_conexion);		
	}
    
	// Modifica un teatro
	function modificar($registro, $nombre_obra, $nombre_teatro, $descripcion, $sesion1, $sesion2, $sesion3, $nume_filas, $nume_asientos)
	{
    
		$query_modify = "UPDATE teatro SET `nombre_obra`='$nombre_obra',`nombre_teatro`='$nombre_teatro',`descripcion`='$descripcion',`sesion1`='$sesion1',`sesion2`='$sesion2',`sesion3`='$sesion3',`nume_filas`='$nume_filas',`nume_asientos`='$nume_asientos' WHERE `Id`= '$registro' ";
		
		$consulta = mysql_query ($query_modify,$this->id_conexion);
	 
	 if($consulta)
		     echo "exito se ha modificado correctamente";
		else
			echo "fail modify ";
    }
		
    // Recupera el nº total de obras
    function nume_obras () {
    	$sql_script = "SELECT * FROM teatro";
    	$this->datos = mysql_query($sql_script,$this->id_conexion);
    	return mysql_num_rows($this->datos);
    	}
    	
    // Borra un teatro
    function del_teatro($identificador) {
      //Ejecuta un "delete" para eliminar los datos del teatro($identificador) y entradas asociadas sobre las tablas "teatro" y "entradas".
		$sql_script = "DELETE FROM teatro WHERE `Id`='$identificador'";
    	$consulta = mysql_query($sql_script,$this->id_conexion);
		$this->_teatro();
		header('Location:index2.php');
		
    }
    
    // Recuperar datos para modificar un teatro
    function recuperar_teatro($identificador) {
	  //Crea la página en la que se muestran los datos de un teatro($identificador) que se va a editar    	
    }
    
	// Introducir datos para añadir un teatro
    function datos_teatro() {
	  $this->_teatro();
	  header('Location:nuevoTeatro.php');   	
    }
    
	// Buscar obra
    function buscar($busqueda) {
      //Se ejecuta un select para recuperar toda la información de la tabla "teatro" referida al campo de búsqueda. 
      //i se produce un error se indica al usuario. En caso contrario si no hay resultados se muestra un mensaje informando de tal situaci?n, y en caso de que haya resultados se muestran los resultados recuperados.	  
		$sql_script = "SELECT * FROM teatro WHERE `nombre_obra`='$busqueda'";
    	$this->datos = mysql_query($sql_script,$this->id_conexion);
    	return $this->datos;

		
	}
	 function buscarId($busqueda) {
      	$sql_script = "SELECT Id FROM teatro WHERE `nombre_obra`='$busqueda'";
    	$this->datos = mysql_query($sql_script,$this->id_conexion);
		$row=mysql_fetch_row($this->datos);
    	return $row[0];

		
	}
    // Listado de obras
    function listar() {
      //Se ejecuta un select para recuperar toda la información de la tabla "teatro".
      //Si se produce un error se indica al usuario. En caso contrario se muestran los resultados recuperados.	  
	  $sql_script = "SELECT * FROM teatro ";
      $this->datos = mysql_query($sql_script,$this->id_conexion);
      return $this->datos;
	}
	function disponible($Id, $sesion, $dia,$fila,$columna) {
		$sql_script = "SELECT * FROM entradas WHERE `Id_teatro`='$Id' AND `sesion`='$sesion' AND `fila`='$fila' AND `asiento`='$columna' AND `dia`='$dia'";
		$this->datos = mysql_query($sql_script,$this->id_conexion);
    	return mysql_num_rows($this->datos);
	  //Crea la página de compra,y dibuja el teatro.
	}
	
	// Función que almacena/elimina en base de datos la reserva de entradas
	function exec_comprar($Id_teatro, $sesion, $fila, $asiento, $accion, $dia){
	    //Ejecuta un insert o un delete de la tabla entradas teniendo en cuenta si el asiento estaba seleccionado o no(variable $accion). Actualiza la página.
		//$Id es el identificador del teatro, $sesión la sesión de la obra, $fila y $asiento la localización de la butaca y $día el día de la representación.	
		if($accion=='borrar'){
			$sql_script = "DELETE FROM entradas WHERE `Id_teatro`='$Id_teatro' AND `sesion`='$sesion' AND `fila`='$fila' AND `asiento`='$asiento' AND `dia`='$dia'";
			$consulta = mysql_query($sql_script,$this->id_conexion);
			
		}
		else if($accion=='insertar'){
		 $query = "INSERT INTO entradas (`Id` ,`Id_teatro`, `sesion`, `fila`, `asiento`, `dia`) VALUES ('','$Id_teatro',  '$sesion','$fila', '$asiento', '$dia')";			
		 $consulta = mysql_query ($query,$this->id_conexion);
		 
	}
	}
	function mostrarBusqueda($cadena){
	$this->_teatro();
	 header('Location:busqueda.php?bus='.$cadena);
   }

   // Añade un usuario
	function add_user($usuario, $nombre, $apellidos, $dni, $correo, $password)
	{
       //Ejecuta un insert sobre la tabla "usuarios"
	   $query = "INSERT INTO usuarios (`usuario`, `nombre`, `apellidos`, `dni`, `correo`, `password`) VALUES ('$usuario',  '$nombre', '$apellidos', '$dni', '$correo', '$password')";		
	   $consulta = mysql_query ($query,$this->id_conexion);	
	   if($consulta)
		header('Location:indexx.php'); 	
		else
			echo "El DNI introducido ya existe";
	}

	// Buscar usuario
    function buscar_user($usuario) {
      //Se ejecuta un select para recuperar toda la información de la tabla "usuarios". 
		$sql_script = "SELECT * FROM usuarios WHERE `usuario`='$usuario'";
    	$this->datos = mysql_query($sql_script,$this->id_conexion);
        return $this->datos;
       
	}

	function edit_user($usuario, $nombre, $apellidos, $dni, $correo, $password){
    
		
		$query_modify = "UPDATE usuarios SET `usuario`='$usuario',`nombre`='$nombre',`apellidos`='$apellidos',`correo`='$correo',`password`='$password' WHERE `dni`= '$dni' ";
		$consulta = mysql_query ($query_modify,$this->id_conexion);
	 
	 if($consulta)
		     header('Location:indexx.php');
		else
			echo "No se han podido modificar los datos... ";
    }
	
	function datos_usr($usuario, $password)
	{
		$sql_script="SELECT * FROM `usuarios` WHERE `usuario`= '$usuario' AND `password` = '$password'";
		$this->datos = mysql_query($sql_script,$this->id_conexion);
		
		return (mysql_num_rows($this->datos) == 1);

	}
	

}
?>