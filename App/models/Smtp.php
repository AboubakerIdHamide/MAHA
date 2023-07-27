<?php

/**
 * Model Smtp
 */

namespace App\Models;

use App\Libraries\Database;

class Smtp
{
	private $connect;

	public function __construct()
	{
		$this->connect = Database::getConnection();
	}

	public function replaceSmtp($smtpData)
	{
		if ($this->getSmtp()) {
			$query = $this->connect->prepare("
				UPDATE smtp 
				SET host = :host, 
				username = :username, 
				password = :password, 
				port = :port
			");
		} else {
			$query = $this->connect->prepare("
				INSERT INTO smtp VALUES (DEFAULT, :host, :username, :password, :port)
			");
		}

		$query->bindParam(':host', $smtpData['host']);
		$query->bindParam(':username', $smtpData['username']);
		$query->bindParam(':password', $smtpData['password']);
		$query->bindParam(':port', $smtpData['port']);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function getSmtp()
	{
		$query = $this->connect->prepare("
			SELECT * 
			FROM smtp 
			WHERE id_smtp = 1
		");

		$query->execute();
		$smtp = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $smtp;
		}
		return false;
	}
}
