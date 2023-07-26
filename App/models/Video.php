<?php

/**
 * Model Video
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
		$query = $this->connect->prepare("
			INSERT INTO videos(id_formation, nom, url, duree, description) VALUES (:formation, :nom, :url, SEC_TO_TIME(:duree), :description)
		");

		$query->bindParam(':formation', $dataVideo['Idformation']);
		$query->bindParam(':nom', $dataVideo['nomVideo']);
		$query->bindParam(':url', $dataVideo['url']);
		$query->bindParam(':duree', $dataVideo['duree']);
		$query->bindParam(':description', $dataVideo['desc']);
		$query->execute();

		$lastInsertId = $this->connect->lastInsertId();
		if ($lastInsertId > 0) {
			return $lastInsertId;
		}
		return false;
	}

	public function getVideo($idFormation, $idVideo)
	{
		$query = $this->connect->prepare("
			SELECT * 
			FROM videos 
			WHERE id_formation = :id_formation 
			AND id_video = :id_video
		");

		$query->bindParam(':id_formation', $idFormation);
		$query->bindParam(':id_video', $idVideo);
		$query->execute();

		$video = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $video;
		}
		return false;
	}

	public function countMassHorraire($id_formation)
	{
		$query = $this->connect->prepare("
			SELECT 
				SEC_TO_TIME(SUM(TIME_TO_SEC(duree))) AS mass_horaire  
			FROM videos
			WHERE id_formation = :id_formation
			GROUP BY id_formation
		");

		$query->bindParam(':id_formation', $id_formation);
		$query->execute();

		$time = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $time->mass_horaire;
		}
		return false;
	}

	public function setOrderVideos($data)
	{
		foreach ($data as $value) {
			$query = $this->connect->prepare("
				UPDATE videos
				SET ordre = :order_video
				WHERE id_video = :id_video
			");
			$query->bindParam(':order_video', $value->order);
			$query->bindParam(':id_video', $value->id);
			$query->execute();
		}
	}

	public function getVideosOfFormation($idFormation)
	{
		$query = $this->connect->prepare("
			SELECT 
				v.id_video,
				f.id_formation,
				v.nom AS nomVideo,
				url,
				duree,
				v.description,
				date_creation,
				f.nom AS nomFormation,
				mass_horaire,
				IF(a.id_video = v.id_video, 1, 0) AS is_preview,
				ordre
			FROM videos v
			LEFT JOIN apercus a ON v.id_video = a.id_video
			JOIN formations f ON v.id_formation = f.id_formation
			WHERE f.id_formation = :id_formation
			ORDER BY ordre
		");

		$query->bindParam(':id_formation', $idFormation);
		$query->execute();

		$videos = $query->fetchAll(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $videos;
		}
		return [];
	}

	public function updateVideo($dataVideo)
	{
		if (isset($dataVideo['description']) && isset($dataVideo['titre'])) {
			$query = $this->connect->prepare("
				UPDATE videos
				SET description = :description,
					nom = :titre
				WHERE id_formation = :id_formation AND id_video = :id_video
			");
			$query->bindParam(':description', $dataVideo['description']);
			$query->bindParam(':titre', $dataVideo['titre']);
		} else {
			if (isset($dataVideo['description'])) {
				$query = $this->connect->prepare("
					UPDATE videos
					SET description = :description
					WHERE id_formation = :id_formation AND id_video = :id_video
				");
				$query->bindParam(':description', $dataVideo['description']);
			} else {
				$query = $this->connect->prepare("
					UPDATE videos
					SET nom = :titre
					WHERE id_formation = :id_formation AND id_video = :id_video
				");
				$query->bindParam(':titre', $dataVideo['titre']);
			}
		}

		$query->bindParam(':id_formation', $dataVideo['id_formation']);
		$query->bindParam(':id_video', $dataVideo['id_video']);
		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function deteleVideo($idFormation, $idVideo)
	{
		$query = $this->connect->prepare("
			DELETE FROM videos
			WHERE id_formation = :id_formation 
			AND id_video = :id_video
		");
		$query->bindParam(':id_formation', $idFormation);
		$query->bindParam(':id_video', $idVideo);
		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function setWatch($etudiant_id, $video_id)
	{
		// watch or unwatch
		$watched = $this->watchedBefore($etudiant_id, $video_id);
		if ($watched) {
			// watch
			$query = $this->connect->prepare("
				DELETE FROM vus 
				WHERE id_etudiant=:eId 
				AND id_video=:vId
			");
		} else {
			// unwatch
			$query = $this->connect->prepare("
				INSERT INTO vus(id_etudiant, id_video) VALUES (:eId,:vId)
			");
		}
		$query->bindParam(':eId', $etudiant_id);
		$query->bindParam(':vId', $video_id);
		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function watchedBefore($etudiant_id, $video_id)
	{
		$query = $this->connect->prepare("
			SELECT * 
			FROM vus 
			WHERE id_etudiant=:eId 
			AND id_video=:vId
		");

		$query->bindParam(':eId', $etudiant_id);
		$query->bindParam(':vId', $video_id);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function getWatchedVideos($etudiant_id)
	{
		$query = $this->connect->prepare("
			SELECT 
				f.id_formation,
				f.nom AS nomFormation,
				f.id_formateur,
				vi.id_video,
				vi.nom AS nomVideo,
				url,
				vi.description
			FROM vus v
			JOIN videos vi ON v.id_video = vi.id_video 
			JOIN formations f ON vi.id_formation = f.id_formation
			WHERE v.id_etudiant=:id_etudiant
		");

		$query->bindParam(':id_etudiant', $etudiant_id);
		$query->execute();

		$videos = $query->fetchAll(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $videos;
		}
		return [];
	}

	public function setBookmark($etudiant_id, $video_id)
	{
		// watch or unwatch
		$bookmarked = $this->bookmarked($etudiant_id, $video_id);
		if ($bookmarked) {
			// watch
			$query = $this->connect->prepare("
				DELETE FROM bookmarks 
				WHERE id_etudiant=:eId 
				AND id_video=:vId
			");
		} else {
			// unwatch
			$query = $this->connect->prepare("
				INSERT INTO bookmarks(id_etudiant, id_video) VALUES (:eId,:vId)
			");
		}
		$query->bindParam(':eId', $etudiant_id);
		$query->bindParam(':vId', $video_id);
		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function bookmarked($etudiant_id, $video_id)
	{
		$query = $this->connect->prepare("
			SELECT * 
			FROM bookmarks 
			WHERE id_etudiant=:eId 
			AND id_video=:vId
		");

		$query->bindParam(':eId', $etudiant_id);
		$query->bindParam(':vId', $video_id);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function getBookmarkedVideos($etudiant_id)
	{
		$query = $this->connect->prepare("
			SELECT * 
			FROM bookmarks b
			JOIN videos USING(id_video) 
			JOIN formations USING (id_formation)
			WHERE b.id_etudiant=:id_etudiant
		");

		$query->bindParam(':id_etudiant', $etudiant_id);
		$query->execute();

		$videos = $query->fetchAll(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $videos;
		}
		return [];
	}


	public function deteleVideoId($idVideo)
	{
		$query = $this->connect->prepare("
			DELETE FROM videos
			WHERE id_video = :id_video
		");

		$idVideo = htmlspecialchars($idVideo);
		$query->bindParam(':id_video', $idVideo);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function updateVideoId($dataVideo)
	{
		if (isset($dataVideo['description']) && isset($dataVideo['titre'])) {
			$query = $this->connect->prepare("
				UPDATE videos
				SET description = :description,
					nom = :titre
				WHERE id_video = :id_video
			");
			$query->bindParam(':description', $dataVideo['description']);
			$query->bindParam(':titre', $dataVideo['titre']);
		} else {
			if (isset($dataVideo['description'])) {
				$query = $this->connect->prepare("
					UPDATE videos
					SET description = :description
					WHERE id_video = :id_video
				");
				$query->bindParam(':description', $dataVideo['description']);
			} else {
				$query = $this->connect->prepare("
					UPDATE videos
					SET nom = :titre
					WHERE id_video = :id_video
				");
				$query->bindParam(':titre', $dataVideo['titre']);
			}
		}

		$query->bindParam(':id_video', $dataVideo['id_video']);
		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function getVideosOfFormationPublic($id_formation)
	{
		$query = $this->connect->prepare("
			SELECT 
				videos.id_video,
				videos.nom,
				videos.duree
			FROM videos
			JOIN formations USING (id_formation)
			WHERE id_formation = :id_formation
		");

		$query->bindParam(':id_formation', $id_formation);
		$query->execute();

		$videos = $query->fetchAll(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $videos;
		}
		return [];
	}

	public function countVideosOfFormation($id_formation)
	{
		$query = $this->connect->prepare("
			SELECT 
				COUNT(videos.id_formation) AS NumbVideo
			FROM videos
			JOIN formations USING (id_formation)
			WHERE id_formation = :id_formation
		");

		$query->bindParam(':id_formation', $id_formation);
		$query->execute();

		$numberVideos = $query->fetch(PDO::FETCH_OBJ)->NumbVideo;
		if ($query->rowCount() > 0) {
			return $numberVideos;
		}
		return 0;
	}

	public function getFormateurOfVideo($videoId)
	{
		$query = $this->connect->prepare("
			SELECT 
				id_formateur
			FROM videos
			JOIN formations USING (id_formation)
			JOIN formateurs USING (id_formateur)
			WHERE id_video = :id_video
		");

		$query->bindParam(':id_video', $videoId);
		$query->execute();

		$formateur = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}
}
