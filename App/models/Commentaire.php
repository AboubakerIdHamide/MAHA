<?php

/**
 * class Commentaire
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
		$request = $this->connect->prepare("
			INSERT INTO commentaires(id_user, id_video, commentaire, type_user) 
			VALUES (:id_user, :id_video, :commentaire, :type_user)
		");

		$request->bindParam(':id_user', $dataCommentaire['idEtudiant']);
		$request->bindParam(':id_video', $dataCommentaire['idVideo']);
		$request->bindParam(':commentaire', $dataCommentaire['commentaire']);
		$request->bindParam(':type_user', $dataCommentaire['type_user']);
		$response = $request->execute();

		return $response;
	}

	public function getCommentaireByVideoId($videoId)
	{
		$request = $this->connect->prepare("	
			SELECT 
				id_user, 
				id_video, 
				nom_etudiant AS nom, 
				prenom_etudiant AS prenom, 
				img_etudiant AS image, 
				commentaire, 
				created_at,
				type_user
			FROM commentaires c 
			JOIN etudiants e ON c.id_user = e.id_etudiant
			WHERE id_video = :videoId
			UNION
			SELECT 
				id_user, 
				id_video, 
				nom_formateur, 
				prenom_formateur, 
				img_formateur, 
				commentaire, 
				created_at,
				type_user
			FROM commentaires c 
			JOIN formateurs f ON c.id_user = f.id_formateur
			WHERE id_video = :videoId
		");
		$request->bindParam(':videoId', $videoId);
		$request->execute();
		$commentaire = $request->fetchAll(PDO::FETCH_OBJ);
		return $commentaire;
	}

	public function updateCommentaire($dataCommentaire)
	{
		$request = $this->connect->prepare("
								UPDATE commentaires
								SET commentaire = :commentaire
								WHERE id_commentaire = :id");
		$request->bindParam(':id', $dataCommentaire['id']);
		$request->bindParam(':commentaire', $dataCommentaire['commentaire']);
		$response = $request->execute();

		return $response;
	}

	public function deteleCommentaire($id)
	{
		$request = $this->connect->prepare("
								DELETE FROM commentaires
								WHERE id_commentaire = :id");
		$request->bindParam(':id', $id);
		$response = $request->execute();
		return $response;
	}
}
