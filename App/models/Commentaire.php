<?php

/**
 * Model Commentaire
 */

class Commentaire
{
	private $connect;

	public function __construct($database)
	{
		$this->connect = $database;
	}

	public function insertCommentaire($dataCommentaire)
	{
		$query = $this->connect->prepare("
			INSERT INTO commentaires(from_user, to_user, id_video, commentaire, type_user) 
			VALUES (:from_user, :to_user, :id_video, :commentaire, :type_user)
		");

		$query->bindParam(':id_video', $dataCommentaire['idVideo']);
		$query->bindParam(':commentaire', $dataCommentaire['commentaire']);
		$query->bindParam(':type_user', $dataCommentaire['type_user']);
		$query->bindParam(':from_user', $dataCommentaire['from_user']);
		$query->bindParam(':to_user', $dataCommentaire['to_user']);
		$query->execute();

		$lastInsertId = $this->connect->lastInsertId();
		if ($lastInsertId > 0) {
			return $lastInsertId;
		}
		return false;
	}

	public function getCommentaireByVideoId($videoId, $formateurId, $etudiantId)
	{
		$query = $this->connect->prepare("	
			SELECT 
				from_user,
				to_user, 
				id_video, 
				nom, 
				prenom, 
				img, 
				commentaire, 
				created_at,
				type_user
			FROM commentaires c 
			JOIN etudiants e ON c.from_user = e.id_etudiant
			WHERE id_video = :videoId AND to_user = :formateurId AND c.from_user = :etudiantId
			UNION
			SELECT 
				from_user,
				to_user, 
				id_video, 
				nom, 
				prenom, 
				img, 
				commentaire, 
				created_at,
				type_user
			FROM commentaires c 
			JOIN formateurs f ON c.from_user = f.id_formateur
			WHERE id_video = :videoId AND to_user = :etudiantId
			ORDER BY created_at
		");

		$query->bindParam(':videoId', $videoId);
		$query->bindParam(':formateurId', $formateurId);
		$query->bindParam(':etudiantId', $etudiantId);
		$query->execute();


		$commentaires = $query->fetchAll(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $commentaires;
		}
		return [];
	}

	public function updateCommentaire($dataCommentaire)
	{
		$query = $this->connect->prepare("
			UPDATE commentaires
			SET commentaire = :commentaire
			WHERE id_commentaire = :id
		");
		$query->bindParam(':id', $dataCommentaire['id']);
		$query->bindParam(':commentaire', $dataCommentaire['commentaire']);
		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function deteleCommentaire($id)
	{
		$query = $this->connect->prepare("
			DELETE FROM commentaires
			WHERE id_commentaire = :id
		");

		$query->bindParam(':id', $id);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}
}
