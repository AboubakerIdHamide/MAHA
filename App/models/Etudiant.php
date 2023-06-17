<?php

/**
 * Model Etudiant
 */

class Etudiant
{
	private $connect;

	public function __construct($database)
	{
		$this->connect = $database;
	}

	public function countEtudiant()
	{
		$query = $this->connect->prepare("
			SELECT 
				COUNT(*) AS total_etudiants 
			FROM etudiants
		");

		$query->execute();
		$response = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $response->total_etudiants;
		}
		return false;
	}

	public function getAllEtudiant($q = '')
	{
		$query = $this->connect->prepare("
			SELECT  
				id_etudiant,  
				nom_etudiant,  
				prenom_etudiant,  
				email_etudiant,  
				tel_etudiant,  
				date_creation_etudiant, 
				img_etudiant
			FROM etudiants
			WHERE nom_etudiant LIKE CONCAT('%', :q,'%')
			OR prenom_etudiant LIKE CONCAT('%', :q,'%')
		");

		$q = htmlspecialchars($q);
		$query->bindParam(':q', $q);
		$query->execute();

		$etudiants = $query->fetchAll(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $etudiants;
		}
		return false;
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

		$response = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $response->total_inscription;
		}
		return false;
	}

	public function insertEtudiant($dataEtudiant)
	{
		$query = $this->connect->prepare("
			INSERT INTO etudiants(nom_etudiant, prenom_etudiant, email_etudiant, tel_etudiant, mot_de_passe, img_etudiant) VALUES (:nom, :prenom, :email, :tel, :mdp, :img_etu)
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
				nom_etudiant,
				tel_etudiant,
				date_creation_etudiant,
				img_etudiant as avatar, 
				email_etudiant as email, 
				prenom_etudiant as prenom
			FROM etudiants 
			WHERE email = :email
		");

		$query->bindParam(':email', $email);
		$query->execute();

		// PDO::FETCH_OBJ
		$etudiant = $query->fetch();
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
			WHERE email_etudiant = :email
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
			SET nom_etudiant = :nom,
				prenom_etudiant = :prenom, 
				mot_de_passe = :mdp, 
				tel_etudiant = :tel
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
			SET img_etudiant = :img
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
				etudiants.mot_de_passe as mdp
			FROM  etudiants
			WHERE id_etudiant = :id
		");

		$query->bindParam(':id', $id);
		$query->execute();

		// PDO::FETCH_OBJ
		$password = $query->fetch();
		if ($query->rowCount() > 0) {
			return $password;
		}
		return false;
	}

	public function getEtudiantById($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				etudiants.id_etudiant as IdEtudiant,
				etudiants.nom_etudiant as nomEtudiant,
				etudiants.prenom_etudiant as prenomEtudiant,
				etudiants.img_etudiant as img,
				etudiants.email_etudiant as email,
				etudiants.tel_etudiant as tel
			FROM etudiants
			WHERE etudiants.id_etudiant = :id;
		");

		$query->bindParam(':id', $id);
		$query->execute();

		// PDO::FETCH_OBJ
		$etudiant = $query->fetch();
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
			SET nom_etudiant = :nom_etudiant,
				prenom_etudiant = :prenom_etudiant, 
				email_etudiant = :email_etudiant, 
				tel_etudiant = :tel_etudiant
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
