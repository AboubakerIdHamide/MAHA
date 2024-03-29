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

	public function create($etudiant, $verificationToken = '', $expiry = 120)
	{
		$query = $this->connect->prepare("
			INSERT INTO etudiants(nom, prenom, email, mot_de_passe, expiration_token_at, verification_token, img, email_verified_at) 
			VALUES (:nom, :prenom, :email, :password, :expiry, :token, :img, :email_verified_at)
		");

		$query->bindValue(':nom', $etudiant['nom'] ?? '');
		$query->bindValue(':prenom', $etudiant['prenom']);
		$query->bindValue(':email', $etudiant['email']);
		$query->bindValue(':password', $etudiant['password'] ?? null);
		$query->bindValue(':expiry', date('Y-m-d H:i:s',  time() + 60 * $expiry));
		$query->bindValue(':token', $verificationToken);
		$query->bindValue(':img', $etudiant['img'] ?? null);
		$query->bindValue(':email_verified_at', $etudiant['verified'] ?? null);
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
				date_creation,
				img, 
				email, 
				prenom,
				email_verified_at,
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

	public function update($data, $id)
	{
		$sql = "UPDATE etudiants SET ";
        
        $updates = [];
        foreach ($data as $field => $value) {
            $updates[] = "$field = :$field";
        }
        
        $sql .= implode(', ', $updates);
        $sql .= " WHERE id_etudiant = :id";
        
        $query = $this->connect->prepare($sql);
        
        foreach ($data as $field => $value) {
            $query->bindValue(":$field", $value);
        }


        $query->bindValue(':id', $id);
        $query->execute();

		if ($query->rowCount() > 0) {
			if(in_array('img', array_keys($data))){
				return $this->select($id, ['img']);
			}
			return true;
		}
		return false;
	}

	public function select($id_etudiant, $selectedFields)
	{
		$query = $this->connect->prepare("
			SELECT 
				".implode(', ', $selectedFields)."
			FROM etudiants
			WHERE id_etudiant = :id_etudiant
		");

		$query->bindValue(':id_etudiant', $id_etudiant);
		$query->execute();

		$etudiant = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $etudiant;
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
				is_active
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

	public function updateToken($email, $token, $expiry = 120)
	{
		$query = $this->connect->prepare("
			UPDATE etudiants
			SET verification_token = :token,
				expiration_token_at = :expiry
			WHERE email = :email
		");

		$query->bindValue(':token', $token);
		$query->bindValue(':email', $email);
		$query->bindValue(':expiry', date('Y-m-d H:i:s',  time() + 60 * $expiry));
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}
}
