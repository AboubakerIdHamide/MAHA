<?php

/**
 * class Etudiant
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
		$request = $this->connect->prepare("
			SELECT COUNT(*) AS total_etudiants 
			FROM etudiants
		");
		$request->execute();
		$response = $request->fetch(PDO::FETCH_OBJ);
		return $response->total_etudiants;
	}

	public function getAllEtudiant($q = '')
	{
		$request = $this->connect->prepare("
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
		$request->bindParam(':q', $q);
		$request->execute();
		$etudiants = $request->fetchAll(PDO::FETCH_OBJ);
		return $etudiants;
	}

	public function countTotalInscriById($id_etudiant)
	{
		$request = $this->connect->prepare("
			SELECT 
				COUNT(*) AS total_inscription
			FROM inscriptions
			WHERE id_etudiant = :id_etudiant
		");

		$request->bindParam(':id_etudiant', $id_etudiant);
		$request->execute();
		$response = $request->fetch(PDO::FETCH_OBJ);
		return $response->total_inscription;
	}

	public function insertEtudiant($dataEtudiant)
	{
		$request = $this->connect->prepare(
			"INSERT INTO 
				etudiants(nom_etudiant, prenom_etudiant, email_etudiant, tel_etudiant, mot_de_passe, img_etudiant) 
				VALUES (:nom, :prenom, :email, :tel, :mdp, :img_etu)"
		);

		$request->bindParam(':nom', $dataEtudiant['nom']);
		$request->bindParam(':prenom', $dataEtudiant['prenom']);
		$request->bindParam(':email', $dataEtudiant['email']);
		$request->bindParam(':img_etu', $dataEtudiant['img']);
		$request->bindParam(':tel', $dataEtudiant['tel']);
		$request->bindParam(':mdp', $dataEtudiant['mdp']);
		$response = $request->execute();

		return $response;
	}

	public function getEtudiantByEmail($email)
	{
		$request = $this->connect->prepare("SELECT *, img_etudiant as avatar, email_etudiant as email, prenom_etudiant as prenom   FROM etudiants WHERE email_etudiant = :email");
		$request->bindParam(':email', $email);
		$request->execute();
		$etudiant = $request->fetch();
		return $etudiant;
	}



	public function updateEtudiantPasswordByEmail($dataEtudiant){
			$request = $this->connect->prepare("UPDATE etudiants SET mot_de_passe = :mdp WHERE email_etudiant = :email");
			$request->bindParam(':email', $dataEtudiant['email']);
			$request->bindParam(':mdp', $dataEtudiant['mdp']);
			$response = $request->execute();
		return $response;
	}


	public function updateEtudiant($dataEtudiant)
	{
		$request = $this->connect->prepare("
								UPDATE etudiants
								SET nom_etudiant = :nom,
								 	prenom_etudiant = :prenom, 
								 	email_etudiant = :email, 
								 	mot_de_passe = :mdp, 
								 	img_etudiant = :img, 
								 	tel_etudiant = :tel 
								WHERE id_etudiant = :id");

		$request->bindParam(':nom', $dataEtudiant['nom']);
		$request->bindParam(':prenom', $dataEtudiant['prenom']);
		$request->bindParam(':email', $dataEtudiant['email']);
		$request->bindParam(':img', $dataEtudiant['img']);
		$request->bindParam(':tel', $dataEtudiant['tel']);
		$request->bindParam(':mdp', $dataEtudiant['mdp']);
		$request->bindParam(':id', $dataEtudiant['id']);

		$response = $request->execute();

		return $response;
	}

	public function deteleEtudiant($id)
	{
		$request = $this->connect->prepare("
			DELETE FROM etudiants
			WHERE id_etudiant = :id
		");
		$request->bindParam(':id', $id);
		$response = $request->execute();
		return $response;
	}

	public function editEtudiant($dataEtudiant)
	{
		$request = $this->connect->prepare("
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

		$request->bindParam(':nom_etudiant', $dataEtudiant['nom_etudiant']);
		$request->bindParam(':prenom_etudiant', $dataEtudiant['prenom_etudiant']);
		$request->bindParam(':email_etudiant', $dataEtudiant['email_etudiant']);
		$request->bindParam(':tel_etudiant', $dataEtudiant['tel_etudiant']);
		$request->bindParam(':id_etudiant', $dataEtudiant['id_etudiant']);
		$response = $request->execute();
		return $response;
	}
}
