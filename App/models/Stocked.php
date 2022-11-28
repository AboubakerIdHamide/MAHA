<?php 
	/**
	 * class Formateur
	 */

	class Stocked
	{
		private $connect;

		public function __construct($database)
		{
			$this->connect = $database;
		}

		public function getAllCategories(){
			$req=$this->connect->prepare("SELECT * FROM categories");
			$req->execute();
			$res=$req->fetchAll(PDO::FETCH_OBJ);
			return $res;
		}

		public function getCategorieById($id){
			$req=$this->connect->prepare("SELECT * FROM categories WHERE id_categorie=:id");
			$req->bindParam(':id', $id);
			$req->execute();
			$res=$req->fetch();
			return $res;
		}

		public function getLangueById($id)
		{
			$req=$this->connect->prepare("SELECT * FROM langues WHERE id_langue=:id");
			$req->bindParam(':id', $id);
			$req->execute();
			$res=$req->fetch();
			return $res;
		}

		public function getLevelById($id)
		{
			$req=$this->connect->prepare("SELECT * FROM niveaux WHERE id_niveau=:id");
			$req->bindParam(':id', $id);
			$req->execute();
			$res=$req->fetch();
			return $res;
		}

		public function getAllLangues()
		{
			$req = $this->connect->prepare("SELECT * FROM langues");
			$req->execute();
			$res=$req->fetchAll(PDO::FETCH_OBJ);
			return $res;
		}

		public function getAllLevels()
		{
			$req = $this->connect->prepare("SELECT * FROM niveaux");
			$req->execute();
			$res=$req->fetchAll(PDO::FETCH_OBJ);
			return $res;
		}

	}


	