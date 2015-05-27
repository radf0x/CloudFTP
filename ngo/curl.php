<?php
class curl {

	private $fetchLink;

	function __construct($link) {
		$this -> fetchLink = $link;
	}

	function initCurl() {
		set_time_limit(0);
		$curl = curl_init($this -> fetchLink);
		if (!$curl) {
			die("Cannot allocate a new PHP-CURL handle");
		}

		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		$data = curl_exec($curl);
		return $data;
	}

	function getCurlLink() {
		return $this -> fetchLink;
	}
}

class Connection {
	private $host = 'localhost', $name = '', $user = 'root', $pass = '';

	public function Connect() {
		return new PDO("mysql:host=$this->host; dbname=$this->name", $this -> user, $this -> pass);
	}

}
