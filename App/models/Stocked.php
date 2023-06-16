<?php

/**
 * Model Stocked
 */

class Stocked
{
	private $connect;

	public function __construct($database)
	{
		$this->connect = $database;
	}

	public function getAllCategories()
	{
		$req = $this->connect->prepare("SELECT * FROM categories");
		$req->execute();
		$res = $req->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}

	public function getCategorieById($id)
	{
		$req = $this->connect->prepare("SELECT * FROM categories WHERE id_categorie=:id");
		$req->bindParam(':id', $id);
		$req->execute();
		$res = $req->fetch();
		return $res;
	}

	public function getLangueById($id)
	{
		$req = $this->connect->prepare("SELECT * FROM langues WHERE id_langue=:id");
		$req->bindParam(':id', $id);
		$req->execute();
		$res = $req->fetch();
		return $res;
	}

	public function getLevelById($id)
	{
		$req = $this->connect->prepare("SELECT * FROM niveaux WHERE id_niveau=:id");
		$req->bindParam(':id', $id);
		$req->execute();
		$res = $req->fetch();
		return $res;
	}

	public function getAllLangues()
	{
		$req = $this->connect->prepare("SELECT * FROM langues");
		$req->execute();
		$res = $req->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}

	public function getAllLevels()
	{
		$req = $this->connect->prepare("SELECT * FROM niveaux");
		$req->execute();
		$res = $req->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}

	public function insertCategorie($data)
	{
		$req = $this->connect->prepare("
			INSERT INTO categories VALUES (DEFAULT, :icon, :nom_categorie)
		");
		$res = $req->execute(['icon' => $data['icon'], 'nom_categorie' => $data['nom_categorie']]);
		return $res;
	}


	public function deleteCategorie($categorie_id)
	{
		$req = $this->connect->prepare("
			DELETE FROM categories WHERE id_categorie = :id_categorie
		");
		$res = $req->execute(['id_categorie' => $categorie_id]);
		return $res;
	}

	public function editCategorie($data)
	{
		$req = $this->connect->prepare("
			UPDATE categories 
			SET nom_categorie = :nom_categorie
			WHERE id_categorie = :id_categorie
		");
		$res = $req->execute(['id_categorie' => $data->categorieID, 'nom_categorie' => $data->NouveauNom]);
		return $res;
	}

	public function insertLangue($langue)
	{
		$req = $this->connect->prepare("
			INSERT INTO langues VALUES (DEFAULT, :nom_langue)
		");
		$res = $req->execute(['nom_langue' => $langue]);
		return $res;
	}

	public function deleteLangue($langueID)
	{
		$req = $this->connect->prepare("
			DELETE FROM langues WHERE id_langue = :id
		");
		$res = $req->execute(['id' => $langueID]);
		return $res;
	}

	public function getThemeData()
	{
		$req = $this->connect->prepare("SELECT * FROM theme WHERE id=1");
		$res = $req->execute();
		return $req->fetch();
	}

	public function setThemeData($data)
	{
		$req = $this->connect->prepare("
			UPDATE theme SET logo=:logo , landingImg=:landingImg WHERE id=1
		");
		$res = $req->execute([
			'logo' => $data["logo"],
			'landingImg' => $data["landingImg"],
		]);
		return $res;
	}
}
