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
				biography,
				c.nom AS nomCategorie,
				balance,
				c.id_categorie
			FROM formateurs f
			JOIN categories c ON f.id_categorie = c.id_categorie
			WHERE f.nom LIKE CONCAT('%', :q,'%')
			OR f.prenom LIKE CONCAT('%', :q,'%')
		");

		$query->bindParam(':q', $q);
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
				biography,
				c.nom AS nomCategorie,
				c.id_categorie,
				email,
				tel
			FROM formateurs f, categories c
			WHERE f.id_categorie = c.id_categorie 
			AND f.slug = :slug
		");

		$query->bindParam(':slug', $slug);
		$query->execute();

		$formateur = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}

	public function create($formateur)
	{
		$query = $this->connect->prepare("
			INSERT INTO formateurs(nom, prenom, email, tel, mot_de_passe, img, biography,  paypalMail, id_categorie, code) VALUES (:nom, :prenom, :email, :tel, :mdp, :img, :bio, :pmail, :spId, :code_formateur)
		");

		$query->bindParam(':nom', $formateur['nom']);
		$query->bindParam(':prenom', $formateur['prenom']);
		$query->bindParam(':email', $formateur['email']);
		$query->bindParam(':img', $formateur['img']);
		$query->bindParam(':tel', $formateur['tel']);
		$query->bindParam(':mdp', $formateur['mdp']);
		$query->bindParam(':pmail', $formateur['pmail']);
		$query->bindParam(':bio', $formateur['bio']);
		$query->bindParam(':spId', $formateur['specId']);
		$query->bindParam(':code_formateur', $formateur['code_formateur']);
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
				id_formateur,
				nom,
				tel,
				date_creation,
				paypalMail,
				biography,
				balance,
				code,
				id_categorie,
				img, 
				email, 
				prenom,
				mot_de_passe,
				code
			FROM formateurs
			WHERE email = :email
		");

		$query->bindParam(':email', $email);
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
				biography,
				balance,
				code,
				id_categorie,
				img, 
				email, 
				prenom 
			FROM formateurs 
			WHERE paypalMail = :pmail
		");
		$query->bindParam(':pmail', $paypalEmail);
		$query->execute();

		$formateur = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}

	public function update($formateur)
	{
		$query = $this->connect->prepare("
			UPDATE formateurs
			SET nom = :nom,
				prenom = :prenom, 
				tel = :tel,
				biography = :bio,
				id_categorie = :specialite,
				mot_de_passe = :mdp
			WHERE id_formateur = :id
		");

		$query->bindParam(':nom', $formateur['nom']);
		$query->bindParam(':prenom', $formateur['prenom']);
		$query->bindParam(':tel', $formateur['tel']);
		$query->bindParam(':bio', $formateur['bio']);
		$query->bindParam(':specialite', $formateur['specId']);
		$query->bindParam(':mdp', $formateur['n_mdp']);
		$query->bindParam(':id', $formateur['id']);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function updateImage($image, $id)
	{
		$query = $this->connect->prepare("
			UPDATE formateurs
			SET img = :image
			WHERE id_formateur = :id
		");

		$query->bindParam(':image', $img);
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
			FROM formateurs
			WHERE id_formateur = :id
		");

		$query->bindParam(':id', $id);
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
				biography = :biography
			WHERE id_formateur = :id_formateur
		");

		$query->bindParam(':nom_formateur', $formateur['nom_formateur']);
		$query->bindParam(':prenom_formateur', $formateur['prenom_formateur']);
		$query->bindParam(':email_formateur', $formateur['email_formateur']);
		$query->bindParam(':tel_formateur', $formateur['tel_formateur']);
		$query->bindParam(':paypalMail', $formateur['paypalMail']);
		$query->bindParam(':specialiteId', $formateur['specialiteId']);
		$query->bindParam(':biography', $formateur['biography']);
		$query->bindParam(':id_formateur', $formateur['id_formateur']);
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

		$query->bindParam(':email', $formateur['email']);
		$query->bindParam(':mdp', $formateur['mdp']);
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

		$query->bindParam(':id', $id);
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
				biography,
				c.nom AS nomCategorie,
				c.id_categorie,
				email,
				tel
			FROM formateurs f, categories c
			WHERE f.id_categorie = c.id_categorie 
			AND f.id_formateur = :id
		");

		$query->bindParam(':id', $id);
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

		$query->bindParam(':id', $id);
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

		$query->bindParam(':id', $id);
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
			AND f.etat = 'public'
		");

		$query->bindParam(':id', $id);
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

		$query->bindParam(':balance', $balance);
		$query->bindParam(':id', $id);
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

		$query->bindParam(':id', $id);
		$query->execute();

		$formateur = $query->fetch(\PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur->balance;
		}
		return 0;
	}

	public function isValideCode($code)
	{
		$request = $this->connect->prepare("
			SELECT code 
			FROM formateurs 
			WHERE code=:code
		");

		$request->bindParam(":code", $code);
		$request->execute();

		$response = $request->fetch(\PDO::FETCH_OBJ);
		if (!empty($response)) {
			return false;
		}
		return true;
	}

	public function refreshCode($id){
		$isValideCode = false;
		$code_formateur="";

		// Generate formateur code & if the code already used generate other one
		while (!$isValideCode) {
			$code_formateur = bin2hex(random_bytes(20));
			$isValideCode = $this->isValideCode($code_formateur);
		}

		$query = $this->connect->prepare("
			UPDATE formateurs 
			SET code = :code
			WHERE id_formateur = :id
		");

		$query->bindParam(':code', $code_formateur);
		$query->bindParam(':id', $id);
		$query->execute();

		if ($query->rowCount() > 0) {
			return $code_formateur;
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
}
