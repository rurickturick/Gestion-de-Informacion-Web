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
class Inputs{

	/* http://www.mclibre.org/consultar/php/lecciones/php_expresiones_regulares.html*/
	/*Para poder usar esta clase, hacer el include 'inputs.php'; en cada archivo que se vaya a usar
  y para invocar métodos se pondría Inputs::nombreMetodo()
  Lo que faltaría hacer es hacer llamadas a estas funciones en cada post o get que exista en toda la practica
  de tal modo que se compruebe antes de enviar nada a la db lo que introduce el usuario
  ejemplo:
  if(Inputs::usuarioValido($_POST['username'])){
    //Se trataría como correcto
  }
  else{
    //Lanzar error de formato/caracter no permitido
  }*/
  
  /*Aunque hay varias funciones que lo que hacen es llamar a otras simplemente, las dejo ahí para que se vea que hemos tenido
  en cuenta todo lo que introduce un usuario/administrador a la hora de validar*/
  
  
	private static function desinfectar($cad){
	    $cadena=trim($cad); //quita espacios del principio y del final del string
		$cadena=strip_tags($cadena); //quita etiquetas <php> y html
		return addslashes($cadena); //escapa caracteres
	}
	/*Funcion que comprueba si el nombre de usuario es válido*/
	static function usuarioValido($cad){
		$cadena=Inputs::desinfectar($cad);
		$patron = "/^[\w]{5,15}$/"; // cualquier letra o numero o guion bajo de longitud entre 5 y 15
		if(preg_match($patron, $cadena)){
			return $cadena;		
		}
		else return "error";
		}
  /*Funcion que comprueba si los apellidos de un usuario es válido*/
	static function apellidosValido($cad){
		$cadena=Inputs::desinfectar($cad);
		$patron = "/^(([[:alpha:]])+([[:blank:]]|-)?)*([[:alpha:]])+$/"; //se permite un guion para apellidos compuestos
		if(preg_match($patron, $cadena)){
			return $cadena;		
		}
		else return "error";
	}
  /*Funcion que comprueba si el nombre de un usuario es válido*/
	static function nombreUsuarioValido($cad){
		$cadena=Inputs::desinfectar($cad);
		$patron = "/^[[:alpha:]]+[[:blank:]]?[[:alpha:]]+$/"; //cualquier nombre simple o compuesto
		if(preg_match($patron, $cadena)){
			return $cadena;		
		}
		else return "error";   
	}
  /*Funcion que verifica el formato de un DNI*/
	static function dniValido($cad){
	  $cadena=Inputs::desinfectar($cad);
	  $patron = "/^[[:digit:]]{8}[[:upper:]]$/"; // 8 digitos y una letra mayuscula
	  if(preg_match($patron, $cadena)){
			return $cadena;		
		}
		else return "error";
	}
  /*Funcion que comprueba si la contraseña introducida por el usuario es válida*/
	static function passwordValido($cad){
		return Inputs::usuarioValido($cad);	//La contraseña sera igual que el nombre de usuario, a no ser que se quiera dar otro formatos
	}
  /*Funcion que comprueba si un correo electronico es valido*/
	static function correoValido($cad){
	  $cadena=Inputs::desinfectar($cad);
	  $patron = "/^[[:alnum:]]+@[[:alpha:]]+\.(com|es|org)$/"; // xxx@xxx.es|com|org se podria hacer que lo que viene despues del punto sea un dominio cualuqiera, pero asi supongo que es mas restrictivo
	  if(preg_match($patron, $cadena)){
			return $cadena;		
		}
		else return "error";    
	}
	/*Funcion que comprueba si lo que se introduce en la busqueda de obras es correcto*/
	static function buscarObraValido($cad){
	  return Inputs::nombreObraValido($cad); //en esencia es lo mismo que el nombre de la obra
	}
  /*Funcion que comprueba si el nombre de una obra es correcto*/
  static function nombreObraValido($cad){
	return Inputs::descripcionValido($cad); //en esencia es lo mismo que una descripcion
	}
  /*Funcion que comprueba si el nombre de un teatro es valido*/
  static function nombreTeatroValido($cad){
	  return Inputs::descripcionValido($cad); //en esencia es lo mismo que una descripcion
	}
  /*Funcion que comprueba si el formato de la hora de las sesiones es correcta*/
  static function sesionValido($cad){
	$cadena=Inputs::desinfectar($cad);
    $patron = "/^[[:digit:]]{2}:[[:digit:]]{2}$/"; // 12:34
	if(preg_match($patron, $cadena)){
			return $cadena;		
		}
		else return "error";   
  }
  /*Funcion que comprueba si el numero de filas/asientos está bien puesto*/
  static function numeroValido($cad){
	$cadena=Inputs::desinfectar($cad);
    $patron = "/^[[:digit:]]{1,3}$/"; // numero de filas/asientos puede ser cualquier numero, está limitado a 3 cifras
	if(preg_match($patron, $cadena)){
			return $cadena;		
		}
		else return "error";    
  }
  /*Funcion que comprueba si la descripcion de una obra es valida*/
  static function descripcionValido($cad){
	$cadena=Inputs::desinfectar($cad);
    $patron = "/^([[:alpha:]]+[[:blank:]]?)*[[:alpha:]]+$/"; // Conjunto de letras separadas por espacios
	if(preg_match($patron, $cadena)){
			return $cadena;		
		}
		else return "error";    
  }
  /*Funcion que comprueba si el comentario de una obra al valorar es correcto*/
  static function comentarioValido($cad){
    return Inputs::descripcionValido($cad); //en esencia el comentario es igual que la descripcion un conjunto de palabras separadas por espacios
  }
  /*Aunque ya tengamos el calendario html, por si acaso falla y se pone una fecha a mano o algo*/
  static function fechaValido($cad){
	$cadena=Inputs::desinfectar($cad);
	$patron = "/^[[:digit:]]{4}-[[:digit:]]{2}-[[:digit:]]{2}$/"; // Fecha en formato legible XXXX-XX-XX 
	if(preg_match($patron, $cadena)){
			return $cadena;		
		}
		else return "error"; 
  }
  /*Funcion que comprueba si el id de un teatro es valido*/
  static function busValido($cad){
	$cadena=Inputs::desinfectar($cad);
	$patron = "/^[[:digit:]]+$/"; // Fecha en formato legible XXXX-XX-XX 
	if(preg_match($patron, $cadena)){
			return $cadena;		
		}
		else return "error"; 
  
  }
  /*Funcion que valida un rol*/
  static function validaRol($cad){
	$cadena=Inputs::desinfectar($cad);
	$patron = "/^(admin|user)$/"; // Fecha en formato legible XXXX-XX-XX 
	if(preg_match($patron, $cadena)){
			return $cadena;		
		}
		else return "error"; 
  
  }
  /*Funcion que comprueba si un numero dado es o 0 o 1*/
   static function numeroBoolValido($cad){
	$cadena=Inputs::desinfectar($cad);
	$patron = "/^(0|1)$/"; // Fecha en formato legible XXXX-XX-XX 
	if(preg_match($patron, $cadena)){
			return $cadena;		
		}
		else return "error"; 
  
  }
  
}
?>