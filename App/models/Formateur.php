<?php

/**
 * Model Formateur
 */

class Formateur
{
	private $connect;

	public function __construct($database)
	{
		$this->connect = $database;
	}

	public function countFormateurs()
	{
		$query = $this->connect->prepare("
			SELECT 
				COUNT(*) AS total_formateurs 
			FROM formateurs
		");

		$query->execute();
		$response = $query->fetch(PDO::FETCH_OBJ);

		if ($query->rowCount() > 0) {
			return $response->total_formateurs;
		}
		return 0;
	}

	public function getAllFormateur($q = '')
	{
		$query = $this->connect->prepare("
			SELECT  
				id_formateur,
				nom,
				prenom,
				email,
				tel,
				date_creation,
				img,
				paypalMail, 
				biography,
				c.nom,
				balance,
				c.id_categorie
			FROM formateurs f
			JOIN categories c ON f.id_categorie = c.id_categorie
			WHERE f.nom LIKE CONCAT('%', :q,'%')
			OR f.prenom LIKE CONCAT('%', :q,'%')
		");

		$q = htmlspecialchars($q);
		$query->bindParam(':q', $q);
		$query->execute();

		$formateurs = $query->fetchAll(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateurs;
		}
		return [];
	}

	public function insertFormateur($dataFormateur)
	{
		$query = $this->connect->prepare("
			INSERT INTO formateurs(nom, prenom, email, tel, mot_de_passe, img, biography,  paypalMail, id_categorie, code) VALUES (:nom, :prenom, :email, :tel, :mdp, :img_for, :bio, :pmail, :spId, :code_formateur)
		");

		$query->bindParam(':nom', $dataFormateur['nom']);
		$query->bindParam(':prenom', $dataFormateur['prenom']);
		$query->bindParam(':email', $dataFormateur['email']);
		$query->bindParam(':img_for', $dataFormateur['img']);
		$query->bindParam(':tel', $dataFormateur['tel']);
		$query->bindParam(':mdp', $dataFormateur['mdp']);
		$query->bindParam(':pmail', $dataFormateur['pmail']);
		$query->bindParam(':bio', $dataFormateur['bio']);
		$query->bindParam(':spId', $dataFormateur['specId']);
		$query->bindParam(':code_formateur', $dataFormateur['code_formateur']);
		$query->execute();

		$lastInsertId = $this->connect->lastInsertId();
		if ($lastInsertId > 0) {
			return $lastInsertId;
		}
		return false;
	}

	public function getFormateurByEmail($email)
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

		$formateur = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}

	public function getFormateurByPaypalEmail($email)
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
		$query->bindParam(':pmail', $email);
		$query->execute();

		$formateur = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}

	public function updateFormateur($dataFormateur)
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

		$query->bindParam(':nom', $dataFormateur['nom']);
		$query->bindParam(':prenom', $dataFormateur['prenom']);
		$query->bindParam(':tel', $dataFormateur['tel']);
		$query->bindParam(':bio', $dataFormateur['bio']);
		$query->bindParam(':specialite', $dataFormateur['specId']);
		$query->bindParam(':mdp', $dataFormateur['n_mdp']);
		$query->bindParam(':id', $dataFormateur['id']);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function changeImg($img, $id)
	{
		$query = $this->connect->prepare("
			UPDATE formateurs
			SET img = :img
			WHERE id_formateur = :id
		");

		$query->bindParam(':img', $img);
		$query->bindParam(':id', $id);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function getMDPFormateurById($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				mot_de_passe AS mdp
			FROM formateurs
			WHERE id_formateur = :id
		");

		$query->bindParam(':id', $id);
		$query->execute();
		$password = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $password;
		}
		return false;
	}

	public function editFormateur($dataFormateur)
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

		$dataFormateur['nom_formateur'] = htmlspecialchars($dataFormateur['nom_formateur']);
		$dataFormateur['prenom_formateur'] = htmlspecialchars($dataFormateur['prenom_formateur']);
		$dataFormateur['email_formateur'] = htmlspecialchars($dataFormateur['email_formateur']);
		$dataFormateur['tel_formateur'] = htmlspecialchars($dataFormateur['tel_formateur']);
		$dataFormateur['paypalMail'] = htmlspecialchars($dataFormateur['paypalMail']);
		$dataFormateur['specialiteId'] = htmlspecialchars($dataFormateur['specialiteId']);
		$dataFormateur['biography'] = htmlspecialchars($dataFormateur['biography']);
		$dataFormateur['id_formateur'] = htmlspecialchars($dataFormateur['id_formateur']);

		$query->bindParam(':nom_formateur', $dataFormateur['nom_formateur']);
		$query->bindParam(':prenom_formateur', $dataFormateur['prenom_formateur']);
		$query->bindParam(':email_formateur', $dataFormateur['email_formateur']);
		$query->bindParam(':tel_formateur', $dataFormateur['tel_formateur']);
		$query->bindParam(':paypalMail', $dataFormateur['paypalMail']);
		$query->bindParam(':specialiteId', $dataFormateur['specialiteId']);
		$query->bindParam(':biography', $dataFormateur['biography']);
		$query->bindParam(':id_formateur', $dataFormateur['id_formateur']);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function updateFormateurPasswordByEmail($dataFormateur)
	{
		$query = $this->connect->prepare("
			UPDATE formateurs 
			SET mot_de_passe = :mdp 
			WHERE email = :email
		");

		$query->bindParam(':email', $dataFormateur['email']);
		$query->bindParam(':mdp', $dataFormateur['mdp']);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function deteleFormateur($id)
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

	public function getFormateurById($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				id_formateur,
				nom,
				prenom,
				img,
				biography,
				categories.nom AS nomCategorie,
				id_categorie,
				email,
				tel
			FROM formateurs, categories
			WHERE formateurs.id_categorie = categories.id_categorie 
			AND formateurs.id_formateur = :id
		");

		$query->bindParam(':id', $id);
		$query->execute();

		$formateur = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}
	public function getnumFormationsFormateurById($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				COUNT(formations.id_formation) as numFormations
			FROM formations
			WHERE formations.id_formateur = :id
		");

		$query->bindParam(':id', $id);
		$query->execute();

		$numFormations = $query->fetch(PDO::FETCH_OBJ)->numFormations;
		if ($query->rowCount() > 0) {
			return $numFormations;
		}
		return 0;
	}
	public function getNumFormationAchtByIdFormateur($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				COUNT(inscriptions.id_formation) AS numAcht
			FROM inscriptions
			WHERE inscriptions.id_formateur = :id
		");

		$query->bindParam(':id', $id);
		$query->execute();

		$numAcht = $query->fetch(PDO::FETCH_OBJ)->numAcht;
		if ($query->rowCount() > 0) {
			return $numAcht;
		}
		return 0;
	}

	public function updateFormateurBalance($IdFormateur, $balance)
	{
		$query = $this->connect->prepare("
			UPDATE formateurs 
			SET balance = balance + :balance 
			WHERE id_formateur = :id_formateur
		");

		$query->bindParam(':balance', $balance);
		$query->bindParam(':id_formateur', $IdFormateur);
		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function getBalance($formateurID)
	{
		$query = $this->connect->prepare("
			SELECT 
				balance 
			FROM formateurs 
			WHERE id_formateur = :id
		");
		$query->bindParam(':id', $formateurID);
		$query->execute();
		$formateur = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $formateur->balance;
		}
		return false;
	}

	// checking code of formateur is already used
	public function isValideCode($code)
	{
		$request = $this->connect->prepare("SELECT code FROM formateurs WHERE code=:code");
		$request->bindParam(":code", $code);
		$request->execute();
		$response = $request->fetch(PDO::FETCH_OBJ);
		if (!empty($response)) {
			return false;
		}
		return true;
	}

	// changer le code de formateur
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
			WHERE id_formateur = :id_formateur
		");

		$query->bindParam(':code', $code_formateur);
		$query->bindParam(':id_formateur', $id);
		$query->execute();

		if ($query->rowCount() > 0) {
			return $code_formateur;
		}
		return false;
	}
}
