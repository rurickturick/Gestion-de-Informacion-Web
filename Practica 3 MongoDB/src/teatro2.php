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

<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
class DBHelper {
  	
  	private $datos;
  	private $id_conexion;
	private $dbName ="GIW_grupo04";
	private $DB;
  	
	//Constructor
  	function DBHelper ()
  	{
  	  //Datos propios de la base de datos	  
	 
  	  /* Intentamos establecer una conexión persistente con el servidor.*/
  	  $this->id_conexion = New MongoClient() or
  	  		die("<CENTER><H3>No se ha podido establecer la conexión.
  	  			<P>Compruebe si está activado el servidor de bases de datos MySQL.</H3></CENTER>");
  	  			
  	  /* Intentamos seleccionar la base de datos. Si no se consigue, se informa de ello y se indica cuál es el motivo del fallo con el n?mero y el mensaje de error.*/
     	$aux=$this->id_conexion;
		$aux2=$this->dbName;
		$this->DB =$aux->$aux2;
		
		
		
	}
	
	// Añade un teatro
	function add_teatro($registro, $nombre_obra, $nombre_teatro, $descripcion, $sesion1, $sesion2, $sesion3, $nume_filas, $nume_asientos)
	{
	   if($registro=="0"){
	    $coleccion=$this->DB->contTeatros;
		$doc = array( "name" => "contT","num_Teatros" => 0);
		$coleccion->insert($doc);	  
	  }
	   $coleccion= $this->DB->contTeatros;
	  $query= array("name" => "contT");
	  $datos=$coleccion->find($query);
	  foreach ($datos as $doc) {
	    $id=$doc["num_Teatros"];
		$nuevosDatos=array( "name" => "contT","num_Teatros" => $id+1);
		$coleccion->update($query,$nuevosDatos) ;
	  }
	   $coleccion= $this->DB->teatros;
	   $doc = array( 
	                      "id" => (string) $id,
						  "nombre_teatro" => $nombre_teatro,
						  "nombre_obra" => $nombre_obra,
						  "descripcion" => $descripcion,
						  "sesion1" =>  $sesion1,
						  "sesion2" =>  $sesion2,
						  "sesion3" =>  $sesion3,
						  "nume_filas" =>$nume_filas,
						  "nume_asientos" => $nume_asientos
	           	   );
	   $coleccion->insert($doc) ;		
	}
	
    
	// Modifica un teatro
	function modificar($registro, $nombre_obra, $nombre_teatro, $descripcion, $sesion1, $sesion2, $sesion3, $nume_filas, $nume_asientos)
	{
    
        $coleccion= $this->DB->teatros;
		
		$nuevosDatos = array( 
	                      "id" => $registro,
						  "nombre_teatro" => $nombre_teatro,
						  "nombre_obra" => $nombre_obra,
						  "descripcion" => $descripcion,
						  "sesion1" =>  $sesion1,
						  "sesion2" =>  $sesion2,
						  "sesion3" =>  $sesion3,
						  "nume_filas" =>$nume_filas,
						  "nume_asientos" => $nume_asientos
	           	   );
		
		$coleccion->update(array("id" => $registro),$nuevosDatos) ;
	     
    }

    //Guarda la valoracion hecha sobre una obra
	function guardarValoracion($valoracion, $comentario, $t, $nombreObra, $dni_user,$fecha,$editar)
	{
        if($editar==0){	
	     $coleccion= $this->DB->valoraciones;
		 $doc=array(
		 "valoracion"=>$valoracion,
		 "comentario"=>$comentario,
		 "id_teatro"=>$t,
		 "nombre_obra"=>$nombreObra,
		 "fecha"=>$fecha,
		 "user_dni"=>$dni_user
		 );
		  $coleccion->insert($doc);
		}
		
		else {
		$coleccion= $this->DB->valoraciones;
		$doc=array(
		 "valoracion"=>$valoracion,
		 "comentario"=>$comentario,
		 "id_teatro"=>$t,
		 "nombre_obra"=>$nombreObra,
		 "fecha"=>$fecha,
		 "user_dni"=>$dni_user
		 );
		 $coleccion->update(array("user_dni" => $dni_user,"id_teatro"=>$t,"nombre_obra"=>$nombreObra),$doc);
		}

	}


    // Recupera el nº total de obras
    function nume_obras () {
    	$coleccion= $this->DB->teatros;
		$resul=$coleccion->count();
    	return $resul;
    	}
    	

    // Borra un teatro
    function del_teatro($identificador) {
      //Ejecuta un "delete" para eliminar los datos del teatro ($identificador) y entradas asociadas sobre las tablas "teatro" y "entradas".
		$coleccion= $this->DB->teatros;
		$coleccion->remove(array("id" => $identificador ));
		$coleccion= $this->DB->entradas;
		$coleccion->remove(array("Id_teatro" => $identificador ));
		$coleccion= $this->DB->valoraciones;
		$coleccion->remove(array("id_teatro" => $identificador ));
		header('Location:index2.php');
		
    }
    
   
    
	// Introducir datos para añadir un teatro
    function datos_teatro() {
	  header('Location:nuevoTeatro.php');   	
    }
    

	// Buscar obra por nombre
    function buscar($busqueda) {
		$coleccion= $this->DB->teatros;
		$query= array("nombre_obra" => $busqueda);
		$datos=$coleccion->find($query);
    	
    	return $datos;
	}

	
	//Busca teatro por nombre
	 function buscarTeatro($busqueda) {
		$coleccion= $this->DB->teatros;
		$query= array("nombre_teatro" => $busqueda);
		$datos=$coleccion->find($query);
    	return $datos;
	}
	

	//Devuelve todos los datos encontrados sobre el teatro con el id pasado por el parametro $bus
	function consulta($bus) {
      
		$coleccion= $this->DB->teatros;
		$query= array("id" => $bus);
		$datos=$coleccion->find($query);
       	return $datos;
	}

	
	
	// Devuelve el id del teatro, pasándo el nombre de la obra
	 function buscarId($busqueda) {
	    $coleccion= $this->DB->teatros;
		$query= array("nombre_obra" => $busqueda);
		$fields= array("id" => true);
		$datos=$coleccion->find($query,$fields);
		foreach($datos as $doc){
		 $id=$doc["id"];
		}
       	return $id;
       	 
  	}

    // Listado de obras
    function listar() {
	   $coleccion= $this->DB->teatros;
	   $datos=$coleccion->find();
		return $datos;

	}


	//devuelve el numero de entradas que cumplen los parámetros pasados(es decir 0 ó 1)
	function disponible($Id, $sesion, $dia,$fila,$columna) {
	     $coleccion= $this->DB->entradas;
		 $query=array("Id_teatro" => $Id,"sesion" => $sesion,"fila" => $fila,"asiento" => $columna, "dia" => $dia);
	     $datos=$coleccion->find($query);
		 $cont= $datos->count();
		 
    	return $cont;
	  //Crea la página de compra,y dibuja el teatro.
	}
	

	// Función que almacena/elimina en base de datos la reserva de entradas
	function exec_comprar($Id_teatro,$dni_user, $sesion, $fila, $asiento, $accion, $dia){

		 $coleccion= $this->DB->entradas;
		if($accion=='borrar'){
		   
		    $query=array(
			"Id_teatro"=>$Id_teatro,
			"sesion"=>$sesion,
			"fila"=>$fila,
			"asiento"=>$asiento,
			"dia"=>$dia
			);
			$datos=$coleccion->find($query);
			foreach($datos as $row){
			 $dni_ent=$row["user_dni"];
			}
			 if($dni_user==$dni_ent){
			$coleccion->remove($query);
			}
			
		}
		else if($accion=='insertar'){
		   $colec=$this->DB->contEntradas;
		   $datos=$colec->find(array("name"=>"contE"));
		   
		   if($datos->count()==0){
	           //crear el contador de entradas para usarlo como index 
		      $doc = array( "name" => "contE","num_Entradas" => 0);
		      $colec->insert($doc);	  
	        }
			//recuperar el valor del index
			
			$query= array("name" => "contE");
			$datos=$colec->find($query);
			foreach ($datos as $doc) {
				$id=$doc["num_Entradas"];
			 //actualizar valor del contador de teatros con uno más
				$nuevosDatos=array( "name" => "contE","num_Entradas" => $id+1);
				$colec->update($query,$nuevosDatos) ;
			}
		 
			$datos=array(
			"id"=>(string)$id,
			"user_dni"=>$dni_user, 
			"Id_teatro"=>$Id_teatro,
			"sesion"=>$sesion,
			"fila"=>$fila,
			"asiento"=>$asiento,
			"dia"=>$dia
			);
			$coleccion->insert($datos);
		 
		 
		 
	    }
	}


	function mostrarBusqueda($cadena){
	 header('Location:busqueda.php?bus='.$cadena);
   }


   // Añade un usuario
	function add_user($usuario, $nombre, $apellidos, $dni, $correo, $password, $rol)
	{
	  $coleccion= $this->DB->usuarios;
     //se comprueba si el dni ya existe antes deinsertar uno nuevo
         $query=array("dni"=>$dni);
		 $consulta=$coleccion->find($query);
		 $encontrado=false;
         foreach($consulta as $doc){
             if($doc["dni"]==$dni){
			   $encontrado=true;
			 }
           }
         if($encontrado){
            echo "El DNI introducido ya existe";
          }		 
	     else {  
		   $datos=array(
		   "usuario"=>$usuario,
		   "nombre"=>$nombre,
		   "apellidos"=>$apellidos,
		   "dni"=>$dni,
		   "correo"=>$correo,
		   "password"=>$password,
		   "rol"=>$rol
		   );		
	       $coleccion->insert($datos);	
		   header('Location:indexx.php');
		 }			
	}

	// Buscar usuario
    function buscar_user($usuario) {
	    $coleccion= $this->DB->usuarios;
		$query=array("usuario"=>$usuario);
		$consulta=$coleccion->find($query);		
        return $consulta;
       
	}
	
	function buscar_dni($dni) {
	    $coleccion= $this->DB->usuarios;
		$query=array("dni"=>$dni);
		$consulta=$coleccion->find($query);		
        return $consulta;

	}

    //editar los datos de un usuario
	function edit_user($usuario, $nombre, $apellidos, $dni, $correo, $password, $rol){
        $coleccion= $this->DB->usuarios;
		$nuevosdatos= array("usuario"=>$usuario,"nombre"=>$nombre,"apellidos"=>$apellidos, "dni"=>$dni,"correo"=>$correo,"password"=>$password, "rol"=>$rol);
		$consulta=$coleccion->update(array("dni" => $dni), $nuevosdatos);
	 
	 if($consulta)
		     header('Location:indexx.php');
		else
			echo "No se han podido modificar los datos... ";
    }
	
    //Devuelve los datos de un usuario concreto
	function datos_usr($usuario, $password)
	{
	    $coleccion= $this->DB->usuarios;
		$query=array("usuario"=>$usuario,"password"=>$password);
		$datos=$coleccion->find($query);		
		return ($datos->count() == 1);

	}

	//devuelve los dinstintos valores de los id de los teatros comprados por el usuario con ese dni 	
	function listar_Obras($dni)
	{ 
	 
	  $coleccion= $this->DB->entradas;
	  $query= array("user_dni"=>$dni);
	  $consulta=$coleccion->distinct("Id_teatro",$query);
      return $consulta;
	}
	
	
	function get_lista($id_teatro, $dni_user)
	{
	    $coleccion= $this->DB->entradas;
		$query=array("user_dni"=>$dni_user,"Id_teatro"=>$id_teatro);
		$fields=array("fila"=>true,"asiento"=>true,"dia"=>true);
		$consulta=$coleccion->find($query,$fields);
		return $consulta;
	}
	
	
	
	function getValoracion($dni_user, $idTeatro, $nombre_obra)
	{
	  $coleccion= $this->DB->valoraciones;
	  $query=array(
	  "user_dni"=>$dni_user,
	  "id_teatro"=>$idTeatro,
	  "nombre_obra"=>$nombre_obra
	  );
	  $consulta=$coleccion->find($query);
	  return $consulta;
	}
	function getValoraciones( $idTeatro, $nombre_obra)
	{
	  $coleccion= $this->DB->valoraciones;
	  $query=array("id_teatro"=>$idTeatro,"nombre_obra"=>$nombre_obra);
	  $consulta=$coleccion->find($query);
	  return $consulta;
	}

	
}
?>