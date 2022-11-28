<?php

/**
 * class Video
 */

class Video
{
	private $connect;

	public function __construct($database)
	{
		$this->connect = $database;
	}

	public function insertVideo($dataVideo)
	{
		$request = $this->connect->prepare(
			"INSERT INTO 
				videos(id_formation, nom_video, url_video, duree_video, miniature_video, description_video) 
				VALUES (:formation, :nom, :url, :duree, :miniature, :description)"
		);

		$request->bindParam(':formation', $dataVideo['Idformation']);
		$request->bindParam(':nom', $dataVideo['nomVideo']);
		$request->bindParam(':url', $dataVideo['url']);
		$request->bindParam(':duree', $dataVideo['duree']);
		$request->bindParam(':miniature', $dataVideo['img']);
		$request->bindParam(':description', $dataVideo['desc']);
		$response = $request->execute();

		return $response;
	}

	// public function getVideo($idFormation, $idVideo){
	// 	$request = $this->connect->prepare("SELECT * FROM videos WHERE id_formation = :id_formation AND id_video = :id_video");

	// 	$request->bindParam(':id_formation', $idFormation);
	// 	$request->bindParam(':id_video', $idVideo);
	// 	$request->execute();

	// 	$video = $request->fetch();
	// 	return $video;
	// }

	public function getVideosOfFormation($idFormation)
	{
		$request = $this->connect->prepare("
				SELECT * FROM videos
				JOIN formations USING (id_formation)
				WHERE id_formation = :id_formation");

		$request->bindParam(':id_formation', $idFormation);
		$request->execute();

		$videos = $request->fetchAll(PDO::FETCH_OBJ);
		return $videos;
	}

	public function updateVideo($dataVideo)
	{
		if (isset($dataVideo['description']) && isset($dataVideo['titre'])) {
			$request = $this->connect->prepare("
				UPDATE videos
				SET 
					description_video = :description,
					nom_video = :titre
				WHERE id_formation = :id_formation AND id_video = :id_video");
			$request->bindParam(':description', $dataVideo['description']);
			$request->bindParam(':titre', $dataVideo['titre']);
		} else {
			if (isset($dataVideo['description'])) {
				$request = $this->connect->prepare("
					UPDATE videos
					SET description_video = :description
					WHERE id_formation = :id_formation AND id_video = :id_video");
				$request->bindParam(':description', $dataVideo['description']);
			} else {
				$request = $this->connect->prepare("
					UPDATE videos
					SET nom_video = :titre
					WHERE id_formation = :id_formation AND id_video = :id_video");
				$request->bindParam(':titre', $dataVideo['titre']);
			}
		}

		$request->bindParam(':id_formation', $dataVideo['id_formation']);
		$request->bindParam(':id_video', $dataVideo['id_video']);
		$response = $request->execute();
		return $response;
	}

	public function deteleVideo($idFormation, $idVideo)
	{
		$request = $this->connect->prepare("
								DELETE FROM videos
								WHERE id_formation = :id_formation AND id_video = :id_video");
		$request->bindParam(':id_formation', $idFormation);
		$request->bindParam(':id_video', $idVideo);
		$response = $request->execute();
		return $response;
	}
}
