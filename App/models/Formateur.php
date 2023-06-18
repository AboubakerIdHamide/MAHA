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
		return false;
	}

	public function getAllFormateur($q = '')
	{
		$query = $this->connect->prepare("
			SELECT  
				id_formateur,  
				nom_formateur,  
				prenom_formateur,  
				email_formateur,  
				tel_formateur,  
				date_creation_formateur, 
				img_formateur,    
				paypalMail, 
				biography,  
				nom_categorie,  
				balance,
				c.id_categorie
			FROM formateurs f
			JOIN categories c ON f.specialiteId = c.id_categorie
			WHERE nom_formateur LIKE CONCAT('%', :q,'%')
			OR prenom_formateur LIKE CONCAT('%', :q,'%')
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
			INSERT INTO formateurs(nom_formateur, prenom_formateur, email_formateur, tel_formateur, mot_de_passe, img_formateur, biography,  paypalMail, specialiteId, code_formateur) VALUES (:nom, :prenom, :email, :tel, :mdp, :img_for, :bio, :pmail, :spId, :code_formateur)
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
				nom_formateur,
				tel_formateur,
				date_creation_formateur,
				paypalMail,
				biography,
				balance,
				code_formateur,
				specialiteId,
				img_formateur as avatar, 
				email_formateur as email, 
				prenom_formateur as prenom,
				mot_de_passe,
				code_formateur
			FROM formateurs
			WHERE email_formateur = :email
		");
		$query->bindParam(':email', $email);
		$query->execute();

		// PDO::FETCH_OBJ
		$formateur = $query->fetch();
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
				nom_formateur,
				tel_formateur,
				date_creation_formateur,
				paypalMail,
				biography,
				balance,
				code_formateur,
				specialiteId,
				img_formateur, 
				email_formateur, 
				prenom_formateur 
			FROM formateurs 
			WHERE paypalMail = :pmail
		");
		$query->bindParam(':pmail', $email);
		$query->execute();

		// PDO::FETCH_OBJ
		$formateur = $query->fetch();
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}

	public function updateFormateur($dataFormateur)
	{
		$query = $this->connect->prepare("
			UPDATE formateurs
			SET nom_formateur = :nom,
				prenom_formateur = :prenom, 
				tel_formateur = :tel,
				biography = :bio,
				specialiteId= :specialite,
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
			SET image_formation = :img
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
				formateurs.mot_de_passe as mdp
			FROM formateurs
			WHERE id_formateur = :id
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

	public function editFormateur($dataFormateur)
	{
		$query = $this->connect->prepare("
			UPDATE formateurs
			SET nom_formateur = :nom_formateur,
				prenom_formateur = :prenom_formateur, 
				email_formateur = :email_formateur, 
				tel_formateur = :tel_formateur,
				paypalMail = :paypalMail,
				specialiteId = :specialiteId,
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
			WHERE email_formateur = :email
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
				formateurs.id_formateur as 'IdFormateur',
				formateurs.nom_formateur as 'nomFormateur',
				formateurs.prenom_formateur as 'prenomFormateur',
				formateurs.img_formateur as 'img',
				formateurs.biography as 'biography',
				categories.nom_categorie as 'categorie',
				formateurs.specialiteId as 'id_categorie',
				formateurs.email_formateur as 'email',
				formateurs.tel_formateur as 'tel'
			FROM formateurs, categories
			WHERE formateurs.specialiteId = categories.id_categorie 
			AND formateurs.id_formateur = :id
		");

		$query->bindParam(':id', $id);
		$query->execute();

		// PDO::FETCH_OBJ
		$formateur = $query->fetch();
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

		// PDO::FETCH_OBJ
		$formateur = $query->fetch();
		if ($query->rowCount() > 0) {
			return $formateur;
		}
		return false;
	}
	public function getNumFormationAchtByIdFormateur($id)
	{
		$query = $this->connect->prepare("
			SELECT 
				COUNT(inscriptions.id_formation) as numAcht
			FROM inscriptions
			WHERE inscriptions.id_formateur = :id
		");

		$query->bindParam(':id', $id);
		$query->execute();

		// PDO::FETCH_OBJ
		$formations = $query->fetch();
		if ($query->rowCount() > 0) {
			return $formations;
		}
		return false;
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
		$request = $this->connect->prepare("SELECT code_formateur FROM formateurs WHERE code_formateur=:code");
		$request->bindParam(":code", $code);
		$request->execute();
		$response = $request->fetch();
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
			SET code_formateur = :code
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
