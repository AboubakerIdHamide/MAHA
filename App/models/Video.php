<?php

/**
 * Model Video
 */

namespace App\Models;

use Carbon\Carbon;

use App\Libraries\Database;

class Video
{
	private $connect;

	public function __construct()
	{
		$this->connect = Database::getConnection();
	}

	public function create($video)
	{
		$query = $this->connect->prepare("
			INSERT INTO videos(id_formation, nom, url, duree, description, thumbnail) VALUES (:id_formation, :nom, :url, SEC_TO_TIME(:duree), :description, :thumbnail)
		");

		$query->bindValue(':id_formation', $video['id_formation']);
		$query->bindValue(':nom', $video['nom']);
		$query->bindValue(':url', $video['url']);
		$query->bindValue(':duree', $video['duration']);
		$query->bindValue(':thumbnail', $video['thumbnail']);
		$query->bindValue(':description', $video['description'] ?? 'Preview Formation');
		$query->execute();

		$lastInsertId = $this->connect->lastInsertId();
		if ($lastInsertId > 0) {
			return $lastInsertId;
		}
		return false;
	}

	public function find($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				v.id_video,
				f.id_formation,
				v.nom AS nomVideo,
				url,
				duree,
				v.description,
				v.created_at,
				date_creation,
				f.nom AS nomFormation,
				mass_horaire,
				IF(a.id_video = v.id_video, 1, 0) AS is_preview,
				ordre,
				thumbnail
			FROM videos v
			LEFT JOIN apercus a ON v.id_video = a.id_video
			JOIN formations f ON v.id_formation = f.id_formation
			WHERE v.id_video = :id_video
		");

		$query->bindValue(':id_video', $id);
		$query->execute();

		$video = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			$datetime = new Carbon($video->created_at);
			$video->created_at = $datetime->diffForHumans();
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

		$time = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $time->mass_horaire;
		}
		return false;
	}

	public function setOrderVideos($videos)
	{
		foreach ($videos as $video) {
			$query = $this->connect->prepare("
				UPDATE videos
				SET ordre = :order_video
				WHERE id_video = :id_video
			");
			$query->bindParam(':order_video', $video->order);
			$query->bindParam(':id_video', $video->id);
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
				v.created_at,
				date_creation,
				f.nom AS nomFormation,
				mass_horaire,
				IF(a.id_video = v.id_video, 1, 0) AS is_preview,
				ordre,
				thumbnail,
				IF(b.id_video = v.id_video, 1, 0) AS is_bookmarked
			FROM videos v
			LEFT JOIN apercus a ON v.id_video = a.id_video
			LEFT JOIN bookmarks b ON v.id_video = b.id_video
			JOIN formations f ON v.id_formation = f.id_formation
			WHERE f.id_formation = :id_formation
			ORDER BY ordre
		");

		$query->bindParam(':id_formation', $idFormation);
		$query->execute();

		$videos = $query->fetchAll(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			foreach ($videos as $video) {
				$datetime = new Carbon($video->created_at);
				$video->created_at = $datetime->diffForHumans();
				$duree = explode(":", $video->duree);
				$video->duree = $duree[1].":".$duree[2];
			}
			
			return $videos;
		}
		return [];
	}

	public function update($video, $id)
	{
		$columnsToUpdate = array_keys($video);
		$updateFields = '';
		foreach ($columnsToUpdate as $column) {
			$updateFields .= "{$column} = :{$column}, ";
		}
		$updateFields = rtrim($updateFields, ', ');

		$query = $this->connect->prepare("
			UPDATE videos
			SET {$updateFields}
			WHERE id_video = :id_video
		");

		foreach ($video as $field => $value) {
			$query->bindValue(":{$field}", $value);
		}

		$query->bindValue(':id_video', $id);

		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function sortVideos($videos, $id_formation)
	{
		foreach ($videos as $order => $video) {
			$query = $this->connect->prepare("
				UPDATE videos
				SET ordre = :order
				WHERE id_formation = :id_formation AND id_video = :id_video
			");

			$query->bindValue(':id_formation', $id_formation);
			$query->bindValue(':id_video', $video['id']);
			$query->bindValue(':order', $order);
			$query->execute();
		}

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

	public function toggleBookmark($id_etudiant, $id_video)
	{
		// toggle bookmark
		$isBookmarked = $this->isBookmarked($id_etudiant, $id_video);
		if ($isBookmarked) {
			// remove bookmark
			$query = $this->connect->prepare("
				DELETE FROM bookmarks 
				WHERE id_etudiant=:eId 
				AND id_video=:vId
			");
		}else{
			// add book mark
			$query = $this->connect->prepare("
				INSERT INTO bookmarks(id_etudiant, id_video) VALUES (:eId,:vId)
			");
		}

		$query->bindParam(':eId', $id_etudiant);
		$query->bindParam(':vId', $id_video);
		$query->execute();

		if ($query->rowCount() > 0) {
			return ["id_video" => (int) $id_video, "isBookmarked" => !$isBookmarked];
		}
		return false;
	}

	private function isBookmarked($id_etudiant, $id_video)
	{
		$query = $this->connect->prepare("
			SELECT COUNT(*) AS isBookmarked
			FROM bookmarks 
			WHERE id_etudiant=:eId 
			AND id_video=:vId
		");

		$query->bindParam(':eId', $id_etudiant);
		$query->bindParam(':vId', $id_video);
		$query->execute();
		
		$isBookmarked = $query->fetch(\PDO::FETCH_OBJ)->isBookmarked;
		return (bool) $isBookmarked;
	}

	public function getBookmarkedVideos($etudiant_id)
	{
		$query = $this->connect->prepare("
			SELECT 
				f.id_formation,
				f.nom AS nomFormation,
				f.id_formateur,
				v.id_video,
				v.nom AS nomVideo,
				url,
				v.description 
			FROM bookmarks b
			JOIN videos v ON b.id_video = v.id_video 
			JOIN formations f ON v.id_formation = f.id_formation
			WHERE b.id_etudiant=:id_etudiant
		");

		$query->bindParam(':id_etudiant', $etudiant_id);
		$query->execute();

		$videos = $query->fetchAll(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $videos;
		}
		return [];
	}

	public function delete($id)
	{
		$query = $this->connect->prepare("
			DELETE FROM videos
			WHERE id_video = :id
		");

		$query->bindParam(':id', $id);
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
				DATE_FORMAT(videos.duree, '%i:%s') AS duree
			FROM videos
			WHERE id_formation = :id_formation
		");

		$query->bindParam(':id_formation', $id_formation);
		$query->execute();

		$videos = $query->fetchAll(\PDO::FETCH_OBJ);
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

		$numberVideos = $query->fetch(\PDO::FETCH_OBJ)->NumbVideo;
		if ($query->rowCount() > 0) {
			return $numberVideos;
		}
		return 0;
	}

	public function getMyBookmarks($id_etudiant)
	{
		$query = $this->connect->prepare("
			SELECT 
				id_formation,
				nom,
				url,
				IF(TIME_FORMAT(duree, '%H') > 0, 
                    CONCAT(TIME_FORMAT(duree, '%H'), 'H ', TIME_FORMAT(duree, '%i'), 'Min'), 
                    TIME_FORMAT(duree, '%i Min')
                ) AS duree,
				thumbnail
			FROM bookmarks
			JOIN videos USING (id_video)
			WHERE id_etudiant = :id_etudiant
		");

		$query->bindParam(':id_etudiant', $id_etudiant);
		$query->execute();

		$boomarks = $query->fetchAll(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $boomarks;
		}
		return [];
	}

	public function whereNom($nom)
	{
		$query = $this->connect->prepare("
			SELECT 
				id_formation
			FROM videos 
			WHERE nom LIKE CONCAT('%', :nom, '%')
		");

		$query->bindValue(':nom', $nom);
		$query->execute();

		$video = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $video;
		}
		return false;
	}
}