<?php

/**
 * Model Stocked
 */
namespace App\Models;

use App\Libraries\Database;

class Stocked
{
	private $connect;

	public function __construct()
	{
		$this->connect = Database::getConnection();
	}

	public function getAllCategories()
	{
		$query = $this->connect->prepare("
			SELECT * 
			FROM categories
			ORDER BY nom
		");

		$query->execute();
		$categories = $query->fetchAll(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $categories;
		}
		return [];
	}

	public function getCategorieById($id)
	{
		$query = $this->connect->prepare("
			SELECT * 
			FROM categories 
			WHERE id_categorie=:id
		");

		$query->bindParam(':id', $id);
		$query->execute();
		$categorie = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $categorie;
		}
		return false;
	}

	public function getLangueById($id)
	{
		$query = $this->connect->prepare("
			SELECT * 
			FROM langues 
			WHERE id_langue=:id
		");

		$query->bindParam(':id', $id);
		$query->execute();
		$langue = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $langue;
		}
		return false;
	}

	public function getLevelById($id)
	{
		$query = $this->connect->prepare("
			SELECT * 
			FROM niveaux 
			WHERE id_niveau=:id
		");

		$query->bindParam(':id', $id);
		$query->execute();
		$level = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $level;
		}
		return false;
	}

	public function getAllLangues()
	{
		$query = $this->connect->prepare("
			SELECT * 
			FROM langues
		");

		$query->execute();
		$langues = $query->fetchAll(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $langues;
		}
		return [];
	}

	public function getAllLevels()
	{
		$query = $this->connect->prepare("
			SELECT * 
			FROM niveaux
		");

		$query->execute();
		$levels = $query->fetchAll(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $levels;
		}
		return [];
	}

	public function insertCategorie($data)
	{
		$query = $this->connect->prepare("
			INSERT INTO categories VALUES (DEFAULT, :nom, :image)
		");
		$query->execute(['image' => $data['image'], 'nom' => $data['nom_categorie']]);
		$lastInsertId = $this->connect->lastInsertId();
		if ($lastInsertId > 0) {
			return $lastInsertId;
		}
		return false;
	}

	public function getPopularCategories()
    {
        $query = $this->connect->prepare("
			SELECT
				c.nom,
				c.image,
				COUNT(DISTINCT f.id_formation) AS formation_count,
				COUNT(i.id_inscription) AS inscription_count,
				SUM(f.jaimes) AS total_jaimes
			FROM categories c
			INNER JOIN formations f ON c.id_categorie = f.id_categorie
			LEFT JOIN inscriptions i ON f.id_formation = i.id_formation
			GROUP BY c.id_categorie, c.nom
			ORDER BY inscription_count DESC, total_jaimes DESC
			LIMIT 6
        ");

        $query->execute();
        $categories = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            return $categories;
        }
        return [];
    }

	public function deleteCategorie($categorie_id)
	{
		$query = $this->connect->prepare("
			DELETE FROM categories 
			WHERE id_categorie = :id_categorie
		");

		$query->execute(['id_categorie' => $categorie_id]);
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function editCategorie($data)
	{
		$query = $this->connect->prepare("
			UPDATE categories 
			SET nom = :nom_categorie
			WHERE id_categorie = :id_categorie
		");
		$query->execute(['id_categorie' => $data->categorieID, 'nom_categorie' => $data->NouveauNom]);
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function insertLangue($langue)
	{
		$query = $this->connect->prepare("
			INSERT INTO langues VALUES (DEFAULT, :nom)
		");
		$query->execute(['nom' => $langue]);
		$lastInsertId = $this->connect->lastInsertId();
		if ($lastInsertId > 0) {
			return $lastInsertId;
		}
		return false;
	}

	public function deleteLangue($langueID)
	{
		$query = $this->connect->prepare("
			DELETE FROM langues 
			WHERE id_langue = :id
		");
		$query->execute(['id' => $langueID]);
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function getThemeData()
	{
		$query = $this->connect->prepare("
			SELECT * 
			FROM theme 
			WHERE id_theme = 1
		");

		$query->execute();
		$theme = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $theme;
		}
		return false;
	}

	public function setThemeData($data)
	{
		$query = $this->connect->prepare("
			UPDATE theme 
			SET logo=:logo, 
				landingImg=:landingImg 
			WHERE id_theme=1
		");

		$query->execute([
			'logo' => $data["logo"],
			'landingImg' => $data["landingImg"],
		]);

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}
}
