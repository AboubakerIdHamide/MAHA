<?php

/**
 * Model Etudiant
 */

namespace App\Models;

use App\Libraries\Database;

class Etudiant
{
	private $connect;

	public function __construct()
	{
		$this->connect = Database::getConnection();
	}

	public function countEtudiant()
	{
		$query = $this->connect->prepare("
			SELECT 
				COUNT(*) AS total_etudiants 
			FROM etudiants
		");

		$query->execute();
		$response = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $response->total_etudiants;
		}
		return 0;
	}

	public function getAllEtudiant($q = '')
	{
		$query = $this->connect->prepare("
			SELECT  
				id_etudiant,  
				nom,  
				prenom,  
				email,  
				tel,  
				date_creation, 
				img
			FROM etudiants
			WHERE nom LIKE CONCAT('%', :q,'%')
			OR prenom LIKE CONCAT('%', :q,'%')
		");

		$q = htmlspecialchars($q);
		$query->bindParam(':q', $q);
		$query->execute();

		$etudiants = $query->fetchAll(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $etudiants;
		}
		return [];
	}

	public function countTotalInscriById($id_etudiant)
	{
		$query = $this->connect->prepare("
			SELECT 
				COUNT(*) AS total_inscription
			FROM inscriptions
			WHERE id_etudiant = :id_etudiant
		");

		$query->bindParam(':id_etudiant', $id_etudiant);
		$query->execute();

		$response = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $response->total_inscription;
		}
		return false;
	}

	public function insertEtudiant($dataEtudiant)
	{
		$query = $this->connect->prepare("
			INSERT INTO etudiants(nom, prenom, email, tel, mot_de_passe, img) VALUES (:nom, :prenom, :email, :tel, :mdp, :img_etu)
		");

		$query->bindParam(':nom', $dataEtudiant['nom']);
		$query->bindParam(':prenom', $dataEtudiant['prenom']);
		$query->bindParam(':email', $dataEtudiant['email']);
		$query->bindParam(':img_etu', $dataEtudiant['img']);
		$query->bindParam(':tel', $dataEtudiant['tel']);
		$query->bindParam(':mdp', $dataEtudiant['mdp']);
		$query->execute();

		$lastInsertId = $this->connect->lastInsertId();
		if ($lastInsertId > 0) {
			return $lastInsertId;
		}
		return false;
	}

	public function getEtudiantByEmail($email)
	{
		$query = $this->connect->prepare("
			SELECT
				id_etudiant,
				nom,
				tel,
				date_creation,
				img, 
				email, 
				prenom,
				mot_de_passe
			FROM etudiants 
			WHERE email = :email
		");

		$query->bindParam(':email', $email);
		$query->execute();

		$etudiant = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $etudiant;
		}
		return false;
	}

	public function updateEtudiantPasswordByEmail($dataEtudiant)
	{
		$query = $this->connect->prepare("
			UPDATE etudiants 
			SET mot_de_passe = :mdp 
			WHERE email = :email
		");
		$query->bindParam(':email', $dataEtudiant['email']);
		$query->bindParam(':mdp', $dataEtudiant['mdp']);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function updateEtudiant($dataEtudiant)
	{
		$query = $this->connect->prepare("
			UPDATE etudiants
			SET nom = :nom,
				prenom = :prenom, 
				mot_de_passe = :mdp, 
				tel = :tel
			WHERE id_etudiant = :id
		");

		$query->bindParam(':nom', $dataEtudiant['nom']);
		$query->bindParam(':prenom', $dataEtudiant['prenom']);
		$query->bindParam(':tel', $dataEtudiant['tel']);
		$query->bindParam(':mdp', $dataEtudiant['n_mdp']);
		$query->bindParam(':id', $dataEtudiant['id']);

		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function changeImg($img, $id)
	{
		$query = $this->connect->prepare("
			UPDATE etudiants
			SET img = :img
			WHERE id_etudiant = :id
		");

		$query->bindParam(':img', $img);
		$query->bindParam(':id', $id);

		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function getMDPEtudiantById($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				mot_de_passe as mdp
			FROM  etudiants
			WHERE id_etudiant = :id
		");

		$query->bindParam(':id', $id);
		$query->execute();

		$password = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $password;
		}
		return false;
	}

	public function getEtudiantById($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				id_etudiant,
				nom,
				prenom,
				img,
				email,
				tel
			FROM etudiants
			WHERE id_etudiant = :id;
		");

		$query->bindParam(':id', $id);
		$query->execute();

		$etudiant = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $etudiant;
		}
		return false;
	}

	public function deteleEtudiant($id)
	{
		$query = $this->connect->prepare("
			DELETE FROM etudiants
			WHERE id_etudiant = :id
		");

		$query->bindParam(':id', $id);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function editEtudiant($dataEtudiant)
	{
		$query = $this->connect->prepare("
			UPDATE etudiants
			SET nom = :nom_etudiant,
				prenom = :prenom_etudiant, 
				email = :email_etudiant, 
				tel = :tel_etudiant
			WHERE id_etudiant = :id_etudiant
		");

		$dataEtudiant['nom_etudiant'] = htmlspecialchars($dataEtudiant['nom_etudiant']);
		$dataEtudiant['prenom_etudiant'] = htmlspecialchars($dataEtudiant['prenom_etudiant']);
		$dataEtudiant['email_etudiant'] = htmlspecialchars($dataEtudiant['email_etudiant']);
		$dataEtudiant['tel_etudiant'] = htmlspecialchars($dataEtudiant['tel_etudiant']);
		$dataEtudiant['id_etudiant'] = htmlspecialchars($dataEtudiant['id_etudiant']);

		$query->bindParam(':nom_etudiant', $dataEtudiant['nom_etudiant']);
		$query->bindParam(':prenom_etudiant', $dataEtudiant['prenom_etudiant']);
		$query->bindParam(':email_etudiant', $dataEtudiant['email_etudiant']);
		$query->bindParam(':tel_etudiant', $dataEtudiant['tel_etudiant']);
		$query->bindParam(':id_etudiant', $dataEtudiant['id_etudiant']);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}
}
