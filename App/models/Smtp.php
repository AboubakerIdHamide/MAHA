<?php

/**
 * Model Smtp
 */

class Smtp
{
	private $connect;

	public function __construct($database)
	{
		$this->connect = $database;
	}

	public function replaceSmtp($smtpData)
	{
		if ($this->getSmtp()) {
			$request = $this->connect->prepare("
				UPDATE smtp 
				SET host = :host, 
				username = :username, 
				password = :password, 
				port = :port
			");
		} else {
			$request = $this->connect->prepare("
				INSERT INTO smtp VALUES (DEFAULT, :host, :username, :password, :port)
			");
		}


		$request->bindParam(':host', $smtpData['host']);
		$request->bindParam(':username', $smtpData['username']);
		$request->bindParam(':password', $smtpData['password']);
		$request->bindParam(':port', $smtpData['port']);
		$response = $request->execute();

		return $response;
	}

	public function getSmtp()
	{
		$request = $this->connect->prepare("
			SELECT * FROM smtp WHERE id = 1
		");

		$request->execute();
		return $request->fetch();
	}
}
