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

	public function count()
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

	public function whereNomOrPrenom($q = '')
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

		$query->bindParam(':q', $q);
		$query->execute();

		$etudiants = $query->fetchAll(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $etudiants;
		}
		return [];
	}

	public function create($etudiant)
	{
		$query = $this->connect->prepare("
			INSERT INTO etudiants(nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mdp)
		");

		$query->bindParam(':nom', $etudiant['nom']);
		$query->bindParam(':prenom', $etudiant['prenom']);
		$query->bindParam(':email', $etudiant['email']);
		$query->bindParam(':mdp', $etudiant['password']);
		$query->execute();

		$lastInsertId = $this->connect->lastInsertId();
		if ($lastInsertId > 0) {
			return $lastInsertId;
		}
		return false;
	}

	public function whereEmail($email)
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
				'etudiant' AS `type`
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

	public function updatePassword($etudiant)
	{
		$query = $this->connect->prepare("
			UPDATE etudiants 
			SET mot_de_passe = :mdp 
			WHERE email = :email
		");

		$query->bindParam(':email', $etudiant['email']);
		$query->bindParam(':mdp', $etudiant['mdp']);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function update($etudiant)
	{
		$query = $this->connect->prepare("
			UPDATE etudiants
			SET nom = :nom,
				prenom = :prenom, 
				mot_de_passe = :mdp, 
				tel = :tel
			WHERE id_etudiant = :id
		");

		$query->bindParam(':nom', $etudiant['nom']);
		$query->bindParam(':prenom', $etudiant['prenom']);
		$query->bindParam(':tel', $etudiant['tel']);
		$query->bindParam(':mdp', $etudiant['n_mdp']);
		$query->bindParam(':id', $etudiant['id']);

		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function updateImage($image, $id)
	{
		$query = $this->connect->prepare("
			UPDATE etudiants
			SET img = :image
			WHERE id_etudiant = :id
		");

		$query->bindParam(':image', $image);
		$query->bindParam(':id', $id);

		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function getPassword($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				mot_de_passe AS mdp
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

	public function find($id)
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

	public function delete($id)
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

	public function edit($etudiant)
	{
		$query = $this->connect->prepare("
			UPDATE etudiants
			SET nom = :nom_etudiant,
				prenom = :prenom_etudiant, 
				email = :email_etudiant, 
				tel = :tel_etudiant
			WHERE id_etudiant = :id_etudiant
		");

		$query->bindParam(':nom_etudiant', $etudiant['nom_etudiant']);
		$query->bindParam(':prenom_etudiant', $etudiant['prenom_etudiant']);
		$query->bindParam(':email_etudiant', $etudiant['email_etudiant']);
		$query->bindParam(':tel_etudiant', $etudiant['tel_etudiant']);
		$query->bindParam(':id_etudiant', $etudiant['id_etudiant']);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}
}
