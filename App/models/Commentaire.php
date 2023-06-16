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
		$request = $this->connect->prepare("
			INSERT INTO commentaires(from_user, to_user, id_video, commentaire, type_user) 
			VALUES (:from_user, :to_user, :id_video, :commentaire, :type_user)
		");

		$request->bindParam(':id_video', $dataCommentaire['idVideo']);
		$request->bindParam(':commentaire', $dataCommentaire['commentaire']);
		$request->bindParam(':type_user', $dataCommentaire['type_user']);
		$request->bindParam(':from_user', $dataCommentaire['from_user']);
		$request->bindParam(':to_user', $dataCommentaire['to_user']);
		$response = $request->execute();

		return $response;
	}


	public function getCommentaireByVideoId($videoId, $formateurId, $etudiantId)
	{
		$request = $this->connect->prepare("	
			SELECT 
				from_user,
				to_user, 
				id_video, 
				nom_etudiant AS nom, 
				prenom_etudiant AS prenom, 
				img_etudiant AS image, 
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
				nom_formateur, 
				prenom_formateur, 
				img_formateur, 
				commentaire, 
				created_at,
				type_user
			FROM commentaires c 
			JOIN formateurs f ON c.from_user = f.id_formateur
			WHERE id_video = :videoId AND to_user = :etudiantId
			ORDER BY created_at
		");
		$request->bindParam(':videoId', $videoId);
		$request->bindParam(':formateurId', $formateurId);
		$request->bindParam(':etudiantId', $etudiantId);
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
