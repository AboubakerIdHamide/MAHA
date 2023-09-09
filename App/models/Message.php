<?php

/**
 * Model Message
 */

namespace App\Models;

use App\Libraries\Database;

class Message
{
	private $connect;

	public function __construct()
	{
		$this->connect = Database::getConnection();
	}

	public function create($message)
	{
		$query = $this->connect->prepare("
			INSERT INTO messages
			VALUES (DEFAULT, :from, :to, :message, DEFAULT)
		");

		$query->bindValue(':from', $message['from']);
		$query->bindValue(':to', $message['to']);
		$query->bindValue(':message', $message['message']);
		$query->execute();

		$lastInsertId = $this->connect->lastInsertId();
		if ($lastInsertId > 0) {
			return $lastInsertId;
		}
		return false;
	}
}
