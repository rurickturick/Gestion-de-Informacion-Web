<?php
//para usar los datos obtenidos.
require('config.php');
session_start();

//creamos un state token para prevenir request forgery.
$stateToSave = md5(rand());

//Lo almacenamos en la session !
$_SESSION['state'] = $stateToSave;

$url = "https://accounts.google.com/o/oauth2/auth";

// construimos la  HTTP GET query
$params = array(
    "response_type" => "code",
    "client_id" => $oauth2_client_id,
	"state" => $_SESSION['state'],
    "redirect_uri" => $oauth2_redirect,
    "scope" => "openid profile email"
    );
 
 //"scope" => "https://www.googleapis.com/auth/plus.me"
$request_to = $url . '?' . http_build_query($params);

header("Location: " . $request_to);
?>