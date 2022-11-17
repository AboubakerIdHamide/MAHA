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

		public function insertFormateur($dataFormateur){
			$request = $this->connect->prepare("INSERT INTO 
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

		public function getFormateurByEmail($email){
			$request = $this->connect->prepare("SELECT * FROM formateurs WHERE email_formateur = :email");
			$request->bindParam(':email', $email);
			$request->execute();
			$formateur = $request->fetch();
			return $formateur;
		}

		public function getFormateurByPaypalEmail($email){
			$request = $this->connect->prepare("SELECT * FROM formateurs WHERE paypalMail = :pmail");
			$request->bindParam(':pmail', $email);
			$request->execute();
			$formateur = $request->fetch();
			return $formateur;
		}
		
		public function updateFormateur($dataFormateur){
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

		public function updateFormateurPasswordByEmail($dataFormateur){
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
	}


	