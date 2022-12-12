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

		public function insertEtudiant($dataEtudiant){
			$request = $this->connect->prepare("INSERT INTO 
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

		public function getEtudiantByEmail($email){
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

		public function updateEtudiant($dataEtudiant){
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
								WHERE id_etudiant = :id");
			$request->bindParam(':id', $id);
			$response = $request->execute();
			return $response;
		}
	}
?>
