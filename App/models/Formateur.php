<?php

/**
 * Model Formateur
 */

namespace App\Models;

use App\Libraries\Database;

class Formateur
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
				COUNT(*) AS total_formateurs 
			FROM formateurs
		");

		$query->execute();
		$response = $query->fetch(\PDO::FETCH_OBJ);

		if ($query->rowCount() > 0) {
			return $response->total_formateurs;
		}
		return 0;
	}

	public function whereNomOrPrenom($q = '')
	{
		$query = $this->connect->prepare("
			SELECT  
				id_formateur,
				f.nom AS nomFormateur,
				prenom,
				email,
				tel,
				date_creation,
				img,
				paypalMail, 
				biographie,
				c.nom AS nomCategorie,
				balance,
				c.id_categorie
			FROM formateurs f
			JOIN categories c ON f.id_categorie = c.id_categorie
			WHERE f.nom LIKE CONCAT('%', :q,'%')
			OR f.prenom LIKE CONCAT('%', :q,'%')
		");

		$query->bindValue(':q', $q);
		$query->execute();

		$formateurs = $query->fetchAll(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateurs;
		}
		return [];
	}

	public function whereSlug($slug)
	{
		$query = $this->connect->prepare("
			SELECT 
				id_formateur,
				f.nom AS nomFormateur,
				prenom,
				img,
				biographie,
				c.nom AS nomCategorie,
				c.id_categorie,
				email,
				tel,
				background_img,
				specialite,
				facebook_profil,
				twitter_profil,
				linkedin_profil,
				is_active,
				slug
			FROM formateurs f, categories c
			WHERE f.id_categorie = c.id_categorie 
			AND f.slug = :slug
		");

		$query->bindValue(':slug', $slug);
		$query->execute();

		$formateur = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}

	public function create($formateur, $verificationToken = '', $expiry = 120)
	{
		$query = $this->connect->prepare("
			INSERT INTO formateurs(nom, prenom, email, mot_de_passe, code, expiration_token_at, verification_token, img, email_verified_at, id_categorie) 
			VALUES (:nom, :prenom, :email, :password, :code_formateur, :expiry, :token, :img, :email_verified_at, :id_categorie)
		");

		$query->bindValue(':nom', $formateur['nom'] ?? '');
		$query->bindValue(':prenom', $formateur['prenom']);
		$query->bindValue(':email', $formateur['email']);
		$query->bindValue(':password', $formateur['password'] ?? null);
		$query->bindValue(':code_formateur', $formateur['code_formateur']);
		$query->bindValue(':expiry', date('Y-m-d H:i:s',  time() + 60 * $expiry));
		$query->bindValue(':token', $verificationToken);
		$query->bindValue(':img', $formateur['img'] ?? null);
		$query->bindValue(':email_verified_at', $formateur['verified'] ?? null);
		$query->bindValue(':id_categorie', $formateur['id_categorie'] ?? null);

		$query->execute();

		$lastInsertId = $this->connect->lastInsertId();
		if ($lastInsertId > 0) {
			return $lastInsertId;
		}
		return false;
	}

	public function formateur($id_formateur)
	{
		$query = $this->connect->prepare("
			SELECT 
				id_formateur,
				nom,
				tel,
				date_creation,
				paypalMail,
				biographie,
				balance,
				specialite,
				code,
				slug,
				id_categorie,
				img, 
				email, 
				prenom,
				code,
				is_all_info_present,
				email_verified_at,
				'formateur' AS `type`,
				background_img,
				facebook_profil,
				twitter_profil,
				linkedin_profil
			FROM formateurs
			WHERE id_formateur = :id_formateur
		");

		$query->bindValue(':id_formateur', $id_formateur);
		$query->execute();

		$formateur = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			$formateur->facebook_profil = explode(".com/", $formateur->facebook_profil)[1] ?? '';
			$formateur->twitter_profil = explode(".com/", $formateur->twitter_profil)[1] ?? '';
			$formateur->linkedin_profil = explode(".com/", $formateur->linkedin_profil)[1] ?? '';
			return $formateur;
		}
		return false;
	}

	public function select($id_formateur, $selectedFields)
	{
		$query = $this->connect->prepare("
			SELECT 
				".implode(', ', $selectedFields)."
			FROM formateurs
			WHERE id_formateur = :id_formateur
		");

		$query->bindValue(':id_formateur', $id_formateur);
		$query->execute();

		$formateur = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}

	public function whereEmail($email)
	{
		$query = $this->connect->prepare("
			SELECT 
				id_formateur,
				nom,
				tel,
				date_creation,
				paypalMail,
				biographie,
				balance,
				specialite,
				code,
				slug,
				id_categorie,
				img, 
				email, 
				prenom,
				code,
				is_all_info_present,
				email_verified_at,
				'formateur' AS `type`
			FROM formateurs
			WHERE email = :email
		");

		$query->bindValue(':email', $email);
		$query->execute();

		$formateur = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}

	public function wherePaypal($paypalEmail)
	{
		$query = $this->connect->prepare("
			SELECT 
				id_formateur,
				nom,
				tel,
				date_creation,
				paypalMail,
				biographie,
				balance,
				code,
				id_categorie,
				img, 
				email, 
				prenom 
			FROM formateurs 
			WHERE paypalMail = :pmail
		");
		$query->bindValue(':pmail', $paypalEmail);
		$query->execute();

		$formateur = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}

	public function update($data, $id)
	{
        $sql = "UPDATE formateurs SET ";
        
        $updates = [];
        foreach ($data as $field => $value) {
            $updates[] = "$field = :$field";
        }
        
        $sql .= implode(', ', $updates);
        $sql .= " WHERE id_formateur = :id";
        
        $query = $this->connect->prepare($sql);
        
        foreach ($data as $field => $value) {
            $query->bindValue(":$field", $value);
        }


        $query->bindValue(':id', $id);
        $query->execute();

		if ($query->rowCount() > 0) {
			if(in_array('img', array_keys($data)) || in_array('background_img', array_keys($data))){
				return $this->select($id, ['img', 'background_img']);
			}
			return true;
		}
		return false;
	}

	public function getPassword($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				mot_de_passe AS mdp
			FROM formateurs
			WHERE id_formateur = :id
		");

		$query->bindValue(':id', $id);
		$query->execute();
		$password = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $password;
		}
		return false;
	}

	public function edit($formateur)
	{
		$query = $this->connect->prepare("
			UPDATE formateurs
			SET nom = :nom_formateur,
				prenom = :prenom_formateur, 
				email = :email_formateur, 
				tel = :tel_formateur,
				paypalMail = :paypalMail,
				id_categorie = :specialiteId,
				biographie = :biographie
			WHERE id_formateur = :id_formateur
		");

		$query->bindValue(':nom_formateur', $formateur['nom_formateur']);
		$query->bindValue(':prenom_formateur', $formateur['prenom_formateur']);
		$query->bindValue(':email_formateur', $formateur['email_formateur']);
		$query->bindValue(':tel_formateur', $formateur['tel_formateur']);
		$query->bindValue(':paypalMail', $formateur['paypalMail']);
		$query->bindValue(':specialiteId', $formateur['specialiteId']);
		$query->bindValue(':biographie', $formateur['biographie']);
		$query->bindValue(':id_formateur', $formateur['id_formateur']);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function updatePassword($formateur)
	{
		$query = $this->connect->prepare("
			UPDATE formateurs 
			SET mot_de_passe = :mdp 
			WHERE email = :email
		");

		$query->bindValue(':email', $formateur['email']);
		$query->bindValue(':mdp', $formateur['mdp']);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function delete($id)
	{
		$query = $this->connect->prepare("
			DELETE FROM formateurs
			WHERE id_formateur = :id
		");

		$query->bindValue(':id', $id);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function find($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				id_formateur,
				f.nom AS nomFormateur,
				prenom,
				img,
				biographie,
				c.nom AS nomCategorie,
				c.id_categorie,
				email,
				tel
			FROM formateurs f, categories c
			WHERE f.id_categorie = c.id_categorie 
			AND f.id_formateur = :id
		");

		$query->bindValue(':id', $id);
		$query->execute();

		$formateur = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}

	public function countFormations($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				COUNT(id_formation) as numFormations
			FROM formations
			WHERE id_formateur = :id
		");

		$query->bindValue(':id', $id);
		$query->execute();

		$numFormations = $query->fetch(\PDO::FETCH_OBJ)->numFormations;
		if ($query->rowCount() > 0) {
			return $numFormations;
		}
		return 0;
	}

	public function countInscriptions($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				COUNT(id_formation) AS inscriptions
			FROM inscriptions
			WHERE id_formateur = :id
		");

		$query->bindValue(':id', $id);
		$query->execute();

		$inscriptions = $query->fetch(\PDO::FETCH_OBJ)->inscriptions;
		if ($query->rowCount() > 0) {
			return $inscriptions;
		}
		return 0;
	}

	public function countPublicInscriptions($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				COUNT(id_formation) AS inscriptions
			FROM inscriptions i
			JOIN formations f USING (id_formation)
			WHERE i.id_formateur = :id
			AND f.etat = 'public' AND payment_state = 'approved'
		");

		$query->bindValue(':id', $id);
		$query->execute();

		$inscriptions = $query->fetch(\PDO::FETCH_OBJ)->inscriptions;
		if ($query->rowCount() > 0) {
			return $inscriptions;
		}
		return 0;
	}

	public function updateBalance($id, $balance)
	{
		$query = $this->connect->prepare("
			UPDATE formateurs 
			SET balance = balance + :balance 
			WHERE id_formateur = :id
		");

		$query->bindValue(':balance', $balance);
		$query->bindValue(':id', $id);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function getBalance($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				balance 
			FROM formateurs 
			WHERE id_formateur = :id
		");

		$query->bindValue(':id', $id);
		$query->execute();

		$formateur = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur->balance;
		}
		return 0;
	}

	public function isCodeExist($code)
	{
		$query = $this->connect->prepare("
			SELECT code 
			FROM formateurs 
			WHERE code=:code
		");

		$query->bindValue(":code", $code);
		$query->execute();

		$code = $query->fetch(\PDO::FETCH_OBJ);
		if ($code) {
			return true;
		}
		return false;
	}

	public function getPopularFormateurs()
	{
		$query = $this->connect->prepare("
            SELECT 
			   	i.id_formateur,
			   	f.nom AS nomFormateur,
			   	prenom,
			   	c.nom AS nomCategorie,
			   	f.img,
			   	slug, 
			   	COUNT(DISTINCT id_etudiant) AS `etudiants`
			FROM inscriptions i
			JOIN formateurs f ON i.id_formateur = f.id_formateur
			JOIN categories c ON f.id_categorie = c.id_categorie
			WHERE i.payment_state = 'approved'
			GROUP BY id_formateur
			ORDER BY `etudiants` DESC
			LIMIT 6
        ");

        $query->execute();
        $formateurs = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            return $formateurs;
        }
        return [];
	}

	public function updateToken($email, $token, $expiry = 120)
	{
		$query = $this->connect->prepare("
			UPDATE formateurs
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