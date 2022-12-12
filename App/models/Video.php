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
				videos(id_formation, nom_video, url_video, duree_video, description_video) 
				VALUES (:formation, :nom, :url, :duree, :description)"
		);

		$request->bindParam(':formation', $dataVideo['Idformation']);
		$request->bindParam(':nom', $dataVideo['nomVideo']);
		$request->bindParam(':url', $dataVideo['url']);
		$request->bindParam(':duree', $dataVideo['duree']);
		$request->bindParam(':description', $dataVideo['desc']);
		$response = $request->execute();

		return $response;
	}

	public function getVideo($idFormation, $idVideo){
		$request = $this->connect->prepare("SELECT * FROM videos WHERE id_formation = :id_formation AND id_video = :id_video");

		$request->bindParam(':id_formation', $idFormation);
		$request->bindParam(':id_video', $idVideo);
		$request->execute();

		$video = $request->fetch();
		return $video;
	}

	public function countMassHorraire($id_formation)
	{
		$request = $this->connect->prepare("
					SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(duree_video))) AS mass_horaire  
					FROM videos
					WHERE id_formation = :id_formation
					GROUP BY id_formation");
		$request->bindParam(':id_formation', $id_formation);
		$request->execute();
		$time = $request->fetch(PDO::FETCH_OBJ);
		return $time->mass_horaire;
	}

	public function setOrderVideos($data)
	{
		foreach ($data as $key => $value) {
			$request = $this->connect->prepare("
				UPDATE videos
				SET 
					order_video = :order_video
				WHERE id_video = :id_video");
			$request->bindParam(':order_video', $value->order);
			$request->bindParam(':id_video', $value->id);
			$response = $request->execute();
		}
	}

	public function getVideosOfFormation($idFormation)
	{
		$request = $this->connect->prepare("
			SELECT 
				v.id_video,
				f.id_formation,
				nom_video,
				url_video,
				duree_video,
				description_video,
				date_creation_formation,
				nom_formation,
				mass_horaire,
				p.id_formation AS preview,
				order_video
			FROM videos v
			LEFT JOIN previews p ON v.id_video = p.id_video
			JOIN formations f ON v.id_formation = f.id_formation
			WHERE f.id_formation = :id_formation
			ORDER BY order_video
		");

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

	public function setWatch($etudiant_id, $video_id)
	{
		// watch or unwatch
        $watched=$this->watchedBefore($etudiant_id, $video_id);
        if($watched){
            // watch
            $req=$this->connect->prepare("DELETE FROM watched WHERE id_etudiant=:eId AND id_video=:vId");
        }else{
            // unwatch
            $req=$this->connect->prepare("INSERT INTO watched(id_etudiant, id_video) VALUES (:eId,:vId)");
        }
        $req->bindParam(':eId', $etudiant_id);
        $req->bindParam(':vId', $video_id);
        $res=$req->execute();
        return $res;
	}

	public function watchedBefore($etudiant_id, $video_id)
	{
		$req=$this->connect->prepare("SELECT * FROM watched WHERE id_etudiant=:eId AND id_video=:vId");
        $req->bindParam(':eId', $etudiant_id);
        $req->bindParam(':vId', $video_id);
        $req->execute();
        $res=$req->fetch();
        if(!empty($res)){
            return true;
        }
        return false;
	}

	public function getWatchedVideos($etudiant_id)
	{
		$request = $this->connect->prepare("SELECT * FROM watched w
		JOIN videos USING(id_video) 
		JOIN formations USING (id_formation)
		WHERE w.id_etudiant=:id_etudiant");

		$request->bindParam(':id_etudiant', $etudiant_id);
		$request->execute();

		$videos = $request->fetchAll(PDO::FETCH_OBJ);
		return $videos;
	}

	public function setBookmark($etudiant_id, $video_id)
	{
		// watch or unwatch
        $bookmarked=$this->bookmarked($etudiant_id, $video_id);
        if($bookmarked){
            // watch
            $req=$this->connect->prepare("DELETE FROM bookmarks WHERE id_etudiant=:eId AND id_video=:vId");
        }else{
            // unwatch
            $req=$this->connect->prepare("INSERT INTO bookmarks(id_etudiant, id_video) VALUES (:eId,:vId)");
        }
        $req->bindParam(':eId', $etudiant_id);
        $req->bindParam(':vId', $video_id);
        $res=$req->execute();
        return $res;
	}

	public function bookmarked($etudiant_id, $video_id)
	{
		$req=$this->connect->prepare("SELECT * FROM bookmarks WHERE id_etudiant=:eId AND id_video=:vId");
        $req->bindParam(':eId', $etudiant_id);
        $req->bindParam(':vId', $video_id);
        $req->execute();
        $res=$req->fetch();
        if(!empty($res)){
            return true;
        }
        return false;
	}

	public function getBookmarkedVideos($etudiant_id)
	{
		$request = $this->connect->prepare("SELECT * FROM bookmarks b
		JOIN videos USING(id_video) 
		JOIN formations USING (id_formation)
		WHERE b.id_etudiant=:id_etudiant");

		$request->bindParam(':id_etudiant', $etudiant_id);
		$request->execute();

		$videos = $request->fetchAll(PDO::FETCH_OBJ);
		return $videos;
	}


	public function deteleVideoId($idVideo)
	{
		$request = $this->connect->prepare("
			DELETE FROM videos
			WHERE id_video = :id_video
		");
		$idVideo = htmlspecialchars($idVideo);
		$request->bindParam(':id_video', $idVideo);
		$response = $request->execute();
		return $response;
	}

	public function updateVideoId($dataVideo)
	{
		if (isset($dataVideo['description']) && isset($dataVideo['titre'])) {
			$request = $this->connect->prepare("
				UPDATE videos
				SET 
					description_video = :description,
					nom_video = :titre
				WHERE id_video = :id_video");
			$request->bindParam(':description', $dataVideo['description']);
			$request->bindParam(':titre', $dataVideo['titre']);
		} else {
			if (isset($dataVideo['description'])) {
				$request = $this->connect->prepare("
					UPDATE videos
					SET description_video = :description
					WHERE id_video = :id_video");
				$request->bindParam(':description', $dataVideo['description']);
			} else {
				$request = $this->connect->prepare("
					UPDATE videos
					SET nom_video = :titre
					WHERE id_video = :id_video");
				$request->bindParam(':titre', $dataVideo['titre']);
			}
		}

		$request->bindParam(':id_video', $dataVideo['id_video']);
		$response = $request->execute();
		return $response;
	}
}
