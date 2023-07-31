<?php

/**
 * Model Preview
 */

namespace App\Models;

use App\Libraries\Database;

class Preview
{
    private $connect;

    public function __construct()
    {
        $this->connect = Database::getConnection();
    }

    public function insertPreviewVideo($id_video, $id_formation)
    {
        $query = $this->connect->prepare("
			INSERT INTO apercus VALUES (:id_formation, :id_video)
		");

        $query->bindParam(':id_video', $id_video);
        $query->bindParam(':id_formation', $id_formation);
        $query->execute();

        $lastInsertId = $this->connect->lastInsertId();
        if ($lastInsertId > 0) {
            return $lastInsertId;
        }
        return false;
    }

    public function getPreviewByFormation($id_formation)
    {
        $query = $this->connect->prepare("
            SELECT * 
            FROM apercus 
            WHERE id_formation = :id_formation
        ");
        $query->bindParam(':id_formation', $id_formation);
        $query->execute();
        $preview = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $preview;
        }
        return false;
    }

    public function getPreviewVideo($id_formation)
    {
        $query = $this->connect->prepare("
            SELECT
                a.id_video,  
                url
            FROM apercus a
            JOIN videos USING (id_video)
            WHERE a.id_formation = :id_formation
        ");
        $query->bindParam(':id_formation', $id_formation);
        $query->execute();
        $previewVideo = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $previewVideo;
        }
        return false;
    }

    public function updatePreview($id_video, $id_formation)
    {
        $query = $this->connect->prepare("
			UPDATE apercus
            SET id_video = :id_video
            WHERE id_formation = :id_formation
		");

        $query->bindParam(':id_video', $id_video);
        $query->bindParam(':id_formation', $id_formation);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
