<?php
session_start();
error_reporting(E_ALL);
require('../config.php');
require('../HttpPost.class.php');

//echo $state;
if(isset($_GET['code'])) {
	$code = $_GET['code'];
	$stateRequested = " ";
	if(isset($_GET['state']))
		$stateRequested = $_GET['state'];
		
	
	
	/*
	 *Nos aseguramos  que no hay falsificación de petición , y que el usuario
   	 *que envia  esta solicitud de conexión es el usuario que se suponía.
	*/
	echo "Este es el estado autogenerado".$_SESSION['state'];
	echo "<br>";
	echo "Este es el estado segun google".$stateRequested;
	echo "<br>";
	
		if($_SESSION['state']!= $stateRequested)
			die('Invalid state parameter');
	
	$url = "https://accounts.google.com/o/oauth2/token";
	$post = array(
        "code" => $code,
        "client_id" => $oauth2_client_id,
        "client_secret" => $oauth2_secret,
        "redirect_uri" => $oauth2_redirect,
        "grant_type" => "authorization_code"
    );
	

	
//convertimos $post en un post String que usaremos en nuestro HttpPost.
$postText = http_build_query($post);
//creamos un objeto HttpPost pasando por parametro la URL a la que vamos a acceder.
$request = new HttpPost($url);
$request->setPostData($postText);
$request->send();



//decodificamos el string con formato json
$data = json_decode($request->getResponse());
//Alamacenamos los tokens
$id_token = $data->id_token;
$access_token = $data->access_token;


//Url que nos da la informacion del usuario en formato JWT (json web token).
$url_id_token = "https://www.googleapis.com/oauth2/v1/tokeninfo?id_token=".$id_token;

/* la informacion es de esta forma:
 {
 "issuer": "accounts.google.com",
 "issued_to": "547638711794-hn5b8ikbbhvaqodjeh6v36hcm7i8uk94.apps.googleusercontent.com",
 "audience": "547638711794-hn5b8ikbbhvaqodjeh6v36hcm7i8uk94.apps.googleusercontent.com",
 "user_id": "118279672935836979189",
 "expires_in": 3092,
 "issued_at": 1422267492,
 "email": "sakabatou1990@gmail.com",
 "email_verified": true
}
*/
//hacemos la peticion para obtener los datos de la url anterior.
$ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url_id_token);
    curl_setopt($ch, CURLOPT_REFERER, $url_id_token);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
	
	echo $result;
echo "<br>";
	
	$obj = json_decode($result);
	
    $issuer =  $obj->issuer;
	$issued_to = $obj->issued_to;
	$audience = $obj->audience;
	$user_id = $obj->user_id;
	$expires_in = $obj->expires_in;
	$issued_at =  $obj->issued_at;
	$email = $obj->email;
	$email_verified =  $obj->email_verified;
	

//$accessToken seria el valor que necesitamos.
echo "Access Token -> ".$access_token;
echo "<br>";
echo "<br>";
echo "Id Token-> ".$id_token;
echo "<br>";


/*		Ahora nos aseguramos que los datos sean correctos		*/

//asegurarnos que el token obtenido es para nuestra aplicacion.
if( $audience != $oauth2_client_id)
	die('El ID del cliente es invalido');

	
}


?>
