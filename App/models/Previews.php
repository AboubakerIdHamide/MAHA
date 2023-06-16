<?php

/**
 * Model Preview
 */

class Previews
{
    private $connect;

    public function __construct($database)
    {
        $this->connect = $database;
    }

    public function insertPreviewVideo($id_video, $id_formation)
    {
        $request = $this->connect->prepare("
			INSERT INTO previews
            VALUES (:id_formation, :id_video)
		");

        $request->bindParam(':id_video', $id_video);
        $request->bindParam(':id_formation', $id_formation);
        $response = $request->execute();
        return $response;
    }

    public function getPreviewByFormation($id_formation)
    {
        $request = $this->connect->prepare("
            SELECT * FROM previews 
            WHERE id_formation = :id_formation
        ");
        $request->bindParam(':id_formation', $id_formation);
        $request->execute();
        $preview = $request->fetch(PDO::FETCH_OBJ);
        return $preview;
    }

    public function getPreviewVideo($id_formation)
    {
        $request = $this->connect->prepare("
            SELECT  
                url_video
            FROM previews p
            JOIN videos USING (id_video)
            WHERE p.id_formation = :id_formation
        ");
        $request->bindParam(':id_formation', $id_formation);
        $request->execute();
        $previewVideo = $request->fetch(PDO::FETCH_OBJ);
        return $previewVideo;
    }

    public function updatePreview($id_video, $id_formation)
    {
        $request = $this->connect->prepare("
			UPDATE previews
            SET id_video = :id_video
            WHERE id_formation = :id_formation
		");

        $request->bindParam(':id_video', $id_video);
        $request->bindParam(':id_formation', $id_formation);
        $response = $request->execute();
        return $response;
    }
}
