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

		// public function getCommentaireById($id){
		// 	$request = $this->connect->prepare("SELECT * FROM commentaires WHERE id_commentaire = :id");
		// 	$request->bindParam(':id', $id);
		// 	$request->execute();
		// 	$commentaire = $request->fetch();
		// 	return $commentaire;
		// }
		
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

	