<?php

class HttpPost {
	public $url;
	public $postString;
	public $httpResponse;
	public $ch;
	
	/**
	 * 
	 *  Construimo sun objeto HttpPost e inicializamos CURL
	 * @param url : URL al que vamos a acceder
	 */
	public function __construct($url) {
		$this->url = $url;
		$this->ch = curl_init( $this->url );
		curl_setopt($this->ch, CURLOPT_URL, $this->url);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
	}
	
	
	public function __destruct() {
		curl_close($this->ch);
	}
	
	
	public function setPostData($params) {
		
		$this->postString = $params;
		curl_setopt( $this->ch, CURLOPT_POST, true );
		curl_setopt ( $this->ch, CURLOPT_POSTFIELDS, $this->postString );
	}
	

	 // Hacemos un post request al servidor
	public function send() {
		$this->httpResponse = curl_exec( $this->ch );
	}
	
	 //Obtener la respuesta que nos ha dado el servidor
	 public function getResponse() {
		return $this->httpResponse;
	}
	
}

?>
