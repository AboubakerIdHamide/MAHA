<?php

/**
 * Model Message
 */

namespace App\Models;

use App\Libraries\Database;
use Carbon\Carbon;

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
			return $this->find($lastInsertId);
		}
		return false;
	}

	public function find($id)
	{
		$query = $this->connect->prepare("
			SELECT
				`from`,
				`to`,
				message,
				sent_at
			FROM messages
			WHERE id_message = :id
			ORDER BY sent_at
		");

		$query->bindValue(':id', $id);
		$query->execute();

		$conversation = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			$datetime = new Carbon($conversation->sent_at);
			$conversation->sent_at = $datetime->diffForHumans();
			return $conversation;
		}
		return false;
	}

	public function conversations($slug, $id_etudiant)
	{
		$query = $this->connect->prepare("
			SELECT
				`from`,
				`to`,
				message,
				sent_at
			FROM messages m
			JOIN formateurs AS f ON m.`to` = f.id_formateur OR m.`from` = f.id_formateur
			JOIN etudiants AS e ON m.`to` = e.id_etudiant OR m.`from` = e.id_etudiant
			WHERE slug = :slug AND id_etudiant = :id_etudiant
			ORDER BY sent_at
		");

		$query->bindValue(':slug', $slug);
		$query->bindValue(':id_etudiant', $id_etudiant);
		$query->execute();

		$conversations = $query->fetchAll(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			foreach ($conversations as $conversation) {
				$datetime = new Carbon($conversation->sent_at);
				$conversation->sent_at = $datetime->diffForHumans();
			}
			return $conversations;
		}
		return [];
	}

	public function myFormateurs($id_etudiant)
	{
		$query = $this->connect->prepare("
			SELECT
				DISTINCT i.id_formateur,
				nom,
				prenom,
				img,
				specialite,
				is_active,
				slug
			FROM inscriptions i
			JOIN formateurs AS f USING (id_formateur)
			WHERE id_etudiant = :id_etudiant
		");

		$query->bindValue(':id_etudiant', $id_etudiant);
		$query->execute();

		$myFormateurs = $query->fetchAll(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $myFormateurs;
		}
		return [];
	}
}

