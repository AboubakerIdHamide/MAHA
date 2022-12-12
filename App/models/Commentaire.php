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

		public function insertCommentaire($dataCommentaire){
			$request = $this->connect->prepare("INSERT INTO 
				commentaires(id_etudiant, id_video, commentaire) 
				VALUES (:idEtudiant, :idVideo, :commentaire)"
			);

			$request->bindParam(':idEtudiant', $dataCommentaire['idEtudiant']);
			$request->bindParam(':idVideo', $dataCommentaire['idVideo']);
			$request->bindParam(':commentaire', $dataCommentaire['commentaire']);
			$response = $request->execute();

			return $response;
		}

		public function getCommentaireByVideoId($videoId){
			$request = $this->connect->prepare("
			SELECT id_etudiant, id_video, nom_etudiant, prenom_etudiant, img_etudiant, commentaire, created_at 
			FROM commentaires 
			JOIN etudiants USING(id_etudiant)
			WHERE id_video = :videoId"
			);
			$request->bindParam(':videoId', $videoId);
			$request->execute();
			$commentaire = $request->fetchAll(PDO::FETCH_OBJ);
			return $commentaire;
		}
		
		public function updateCommentaire($dataCommentaire){
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

	