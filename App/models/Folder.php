<?php 
	/**
	 * class Folder
	 */

	class Folder
	{
		private $connect;

		public function __construct($database)
		{
			$this->connect = $database;
		}		

		public function getFolderByEmail($email){
			$req=$this->connect->prepare("SELECT * FROM folders WHERE userEmail=:email");
			$req->bindParam(':email', $email);
			$req->execute();
			$res=$req->fetch();
			return $res;
		}

        public function insertFolder($userFolderId, $fImagesId, $fVideosId, $fRessourcesId, $userEmail){
			$req=$this->connect->prepare("INSERT INTO folders(userFolderId, imagesId, videosId, ressourcesId, userEmail) VALUES (:userFolderId, :imagesId, :videosId, :ressourcesId, :userEmail)");
			$req->bindParam(':userFolderId', $userFolderId);
			$req->bindParam(':imagesId', $fImagesId);
			$req->bindParam(':videosId', $fVideosId);
			$req->bindParam(':ressourcesId', $fRessourcesId);
			$req->bindParam(':userEmail', $userEmail);
			$res=$req->execute();
			return $res;
		}

	}


	