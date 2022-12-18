<?php

/**
 * class Formateur
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
		$request = $this->connect->prepare("SELECT COUNT(*) AS total_formateurs FROM formateurs");
		$request->execute();
		$response = $request->fetch(PDO::FETCH_OBJ);
		return $response->total_formateurs;
	}

	public function getAllFormateur($q = '')
	{
		$request = $this->connect->prepare("
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
		$request->bindParam(':q', $q);
		$request->execute();
		$formateurs = $request->fetchAll(PDO::FETCH_OBJ);
		return $formateurs;
	}

	public function insertFormateur($dataFormateur)
	{
		$request = $this->connect->prepare(
			"INSERT INTO 
				formateurs(nom_formateur, prenom_formateur, email_formateur, tel_formateur, mot_de_passe, img_formateur, biography,  paypalMail, specialiteId) 
				VALUES (:nom, :prenom, :email, :tel, :mdp, :img_for, :bio, :pmail, :spId)"
		);

		$request->bindParam(':nom', $dataFormateur['nom']);
		$request->bindParam(':prenom', $dataFormateur['prenom']);
		$request->bindParam(':email', $dataFormateur['email']);
		$request->bindParam(':img_for', $dataFormateur['img']);
		$request->bindParam(':tel', $dataFormateur['tel']);
		$request->bindParam(':mdp', $dataFormateur['mdp']);
		$request->bindParam(':pmail', $dataFormateur['pmail']);
		$request->bindParam(':bio', $dataFormateur['bio']);
		$request->bindParam(':spId', $dataFormateur['specId']);
		$response = $request->execute();

		return $response;
	}

	public function getFormateurByEmail($email)
	{
		$request = $this->connect->prepare("SELECT *, img_formateur as avatar, email_formateur as email, prenom_formateur as prenom  FROM formateurs WHERE email_formateur = :email");
		$request->bindParam(':email', $email);
		$request->execute();
		$formateur = $request->fetch();
		return $formateur;
	}

	public function getFormateurByPaypalEmail($email)
	{
		$request = $this->connect->prepare("SELECT * FROM formateurs WHERE paypalMail = :pmail");
		$request->bindParam(':pmail', $email);
		$request->execute();
		$formateur = $request->fetch();
		return $formateur;
	}

	public function updateFormateur($dataFormateur)
	{
		$request = $this->connect->prepare("
								UPDATE formateurs
								SET nom_formateur = :nom,
								 	prenom_formateur = :prenom, 
								 	email_formateur = :email, 
								 	mot_de_passe = :mdp, 
								 	img_formateur = :img, 
								 	tel_formateur = :tel 
								WHERE id_formateur = :id");

		$request->bindParam(':nom', $dataFormateur['nom']);
		$request->bindParam(':prenom', $dataFormateur['prenom']);
		$request->bindParam(':email', $dataFormateur['email']);
		$request->bindParam(':img', $dataFormateur['img']);
		$request->bindParam(':tel', $dataFormateur['tel']);
		$request->bindParam(':mdp', $dataFormateur['mdp']);
		$request->bindParam(':id', $dataFormateur['id']);

		$response = $request->execute();

		return $response;
	}

	public function editFormateur($dataFormateur)
	{
		$request = $this->connect->prepare("
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

		$request->bindParam(':nom_formateur', $dataFormateur['nom_formateur']);
		$request->bindParam(':prenom_formateur', $dataFormateur['prenom_formateur']);
		$request->bindParam(':email_formateur', $dataFormateur['email_formateur']);
		$request->bindParam(':tel_formateur', $dataFormateur['tel_formateur']);
		$request->bindParam(':paypalMail', $dataFormateur['paypalMail']);
		$request->bindParam(':specialiteId', $dataFormateur['specialiteId']);
		$request->bindParam(':biography', $dataFormateur['biography']);
		$request->bindParam(':id_formateur', $dataFormateur['id_formateur']);
		$response = $request->execute();
		return $response;
	}

	public function updateFormateurPasswordByEmail($dataFormateur)
	{
		$request = $this->connect->prepare("UPDATE formateurs SET mot_de_passe = :mdp WHERE email_formateur = :email");
		$request->bindParam(':email', $dataFormateur['email']);
		$request->bindParam(':mdp', $dataFormateur['mdp']);
		$response = $request->execute();

		return $response;
	}

	public function deteleFormateur($id)
	{
		$request = $this->connect->prepare("
								DELETE FROM formateurs
								WHERE id_formateur = :id");
		$request->bindParam(':id', $id);
		$response = $request->execute();
		return $response;
	}

	public function getFormateurById($id){
		$request = $this->connect->prepare("SELECT formateurs.id_formateur as 'IdFormateur',
												formateurs.nom_formateur as 'nomFormateur',
												formateurs.prenom_formateur as 'prenomFormateur',
												formateurs.img_formateur as 'img',
												formateurs.biography as 'biography',
												categories.nom_categorie as 'categorie',
												formateurs.specialiteId as 'id_categorie',
												formateurs.email_formateur as 'email',
												formateurs.tel_formateur as 'tel'
										from formateurs, categories
										where formateurs.specialiteId = categories.id_categorie 
										and formateurs.id_formateur = :id;
		");
		$request->bindParam(':id', $id);
		$request->execute();
		$formateur = $request->fetch();
		return $formateur;
	}
	public function getnumFormationsFormateurById($id)
	{
		$request = $this->connect->prepare("SELECT count(formations.id_formation) as 'numFormations'
												from formations
												where formations.id_formateur = :id
			");
		$request->bindParam(':id', $id);
		$request->execute();
		$formateur = $request->fetch();
		return $formateur;
	}
	public function getNumFormationAchtByIdFormateur($id){
		$request = $this->connect->prepare("SELECT count(inscriptions.id_formation) as 'numAcht'
											from inscriptions
											where inscriptions.id_formateur = :id
		");
		$request->bindParam(':id', $id);
		$request->execute();
		$formations = $request->fetch();
		return $formations;
	}
}
