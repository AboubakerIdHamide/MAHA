<?php

use App\Models\Etudiant;
use App\Models\Formation;
use App\Models\Video;
use App\Models\Inscription;
use App\Models\Stocked;
use App\Models\Commentaire;
use App\Models\Notification;

class EtudiantController
{
	private $etudiantModel;
	private $formationModel;
	private $videoModel;
	private $inscriptionModel;
	private $stockedModel;
	private $commentModel;
	private $notificationModel;
	private $id;


	public function __construct()
	{
		if (!isset($_SESSION['id_etudiant'])) {
			redirect('user/login');
			return;
		}
		$this->etudiantModel = new Etudiant;
		$this->formationModel = new Formation;
		$this->videoModel = new Video;
		$this->inscriptionModel = new Inscription;
		$this->stockedModel = new Stocked;
		$this->commentModel = new Commentaire;
		$this->notificationModel = new Notification;
		$this->id = $_SESSION['id_etudiant'];
	}

	public function index()
	{
		$this->dashboard();
	}

	public function dashboard()
	{
		// preparing data
		$data["inscriptions"] = $this->inscriptionModel->getInscriptionByEtudiant($_SESSION['id_etudiant']);
		foreach ($data["inscriptions"] as $inscription) {
			$inscription->imgFormateur = URLROOT . "/Public/" . $inscription->imgFormateur;
			$inscription->image = URLROOT . "/Public/" . $inscription->image;
			$inscription->apprenants = $this->inscriptionModel->countApprenantsOfFormation($inscription->id_formateur, $inscription->id_formation);
			$inscription->liked = $this->formationModel->isLikedBefore($inscription->id_etudiant, $inscription->id_formation);
		}
		$data['nbrNotifications'] = $this->_getNotifications();
		// loading the view
		return view("etudiant/index", $data);
	}

	public function coursVideos($idFormateur = "", $idFormation = "")
	{
		if (empty($idFormateur) || empty($idFormation)) {
			redirect("etudiant");
		}
		// preparing data
		$formation = $this->inscriptionModel->getInscriptionOfOneFormation($idFormation, $_SESSION['id_etudiant'], $idFormateur);
		$formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
		$formation->image = URLROOT . "/Public/" . $formation->image;
		$formation->imgEtudiant = URLROOT . "/Public/" . $formation->imgEtudiant;
		$formation->formationCategorie = $this->stockedModel->getCategorieById($formation->formationCategorie)->nom;
		$formation->formateurCategorie = $this->stockedModel->getCategorieById($formation->formateurCategorie)->nom;
		$formation->langue = $this->stockedModel->getLangueById($formation->langue)->nom;
		$niveau = $this->stockedModel->getLevelById($formation->niveau);
		$formation->niveau = $niveau->nom;
		$formation->niveauIcon = $niveau->icon;
		$formation->apprenants = $this->inscriptionModel->countApprenantsOfFormation($idFormateur, $idFormation);
		$formation->videos = $this->videoModel->getVideosOfFormation($idFormation);
		$formation->liked = $this->formationModel->isLikedBefore($_SESSION['id_etudiant'], $idFormation);

		foreach ($formation->videos as $video) {
			// settingUp Video Link
			$video->url = URLROOT . "/Public/" . $video->url;
			$video->comments = $this->commentModel->getCommentaireByVideoId($video->id_video, $idFormateur, $_SESSION['id_etudiant']);
			$video->watched = $this->videoModel->watchedBefore($_SESSION['id_etudiant'], $video->id_video);
			$video->bookmarked = $this->videoModel->bookmarked($_SESSION['id_etudiant'], $video->id_video);
			// settingUp User image Link for comment
			foreach ($video->comments as $comment) {
				$comment->img = URLROOT . "/Public/" . $comment->img;
			}
		}

		// loading the view
		return view("etudiant/coursVideos", $formation);
	}

	public function watchedVideos()
	{
		// Preparing Data
		$data["videos"] = $this->videoModel->getWatchedVideos($_SESSION['id_etudiant']);
		foreach ($data["videos"] as $video) {
			// settingUp Video Link
			$video->url = URLROOT . "/Public/" . $video->url;
		}

		$data["nbrNotifications"] = $this->_getNotifications();

		// loading the view
		return view("etudiant/videoCards", $data);
	}

	public function bookmarkedVideos()
	{
		// Preparing Data
		$data["videos"] = $this->videoModel->getBookmarkedVideos($_SESSION['id_etudiant']);
		foreach ($data["videos"] as $video) {
			// settingUp Video Link
			$video->url = URLROOT . "/Public/" . $video->url;
		}

		$data["nbrNotifications"] = $this->_getNotifications();

		// loading the view
		return view("etudiant/videoCards", $data);
	}

	// Update Profil 

	public function updateInfos()
	{
		$idEtudiant = $this->id;
		$etudiant = $this->etudiantModel->find($idEtudiant);
		$etudiant->img = URLROOT . "/Public/" . $etudiant->img;

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Prepare Data
			$data = [
				"id" => $idEtudiant,
				"nom" => trim($_POST["nom"]),
				"prenom" => trim($_POST["prenom"]),
				"tel" => trim($_POST["tel"]),
				"c_mdp" => trim($_POST["c_mdp"]),
				"n_mdp" => trim($_POST["n_mdp"]),
				"nom_err" => "",
				"prenom_err" => "",
				"tel_err" => "",
				"c_mdp_err" => "",
				"n_mdp_err" => "",
				"thereIsError" => false,
			];


			// Validate Data
			$data = $this->validateMDP($data);
			$data = $this->validateDataUpdate($data);

			// Checking If There Is An Error
			if ($data["thereIsError"] == true) {
				echo json_encode($data);
			} else {
				// Hashing Password
				$data["n_mdp"] = password_hash($data["n_mdp"], PASSWORD_DEFAULT);

				$this->etudiantModel->update($data);

				$_SESSION["user_data"] = $data;

				$etudiant = $this->etudiantModel->find($idEtudiant);
				$etudiant->img = URLROOT . "/Public/" . $etudiant->img;
				$data = [
					"nom" => $etudiant->nom,
					"prenom" => $etudiant->prenom,
					"email" => $etudiant->email,
					"tel" => $etudiant->tel,
					"img" => $etudiant->img,
					"nom_err" => "",
					"prenom_err" => "",
					"img_err" => "",
					"tel_err" => "",
					"c_mdp_err" => "",
					"n_mdp_err" => "",
				];
				echo json_encode($data);
			}
		} else {
			$data = [
				"nom" => $etudiant->nom,
				"prenom" => $etudiant->prenom,
				"email" => $etudiant->email,
				"tel" => $etudiant->tel,
				"img" => $etudiant->img,
				"nom_err" => "",
				"prenom_err" => "",
				"img_err" => "",
				"tel_err" => "",
				"c_mdp_err" => "",
				"n_mdp_err" => "",
			];

			$data["nbrNotifications"] = $this->_getNotifications();

			return view("etudiant/updateInfos", $data);
		}
	}

	private function validateDataUpdate($data)
	{
		// Validate Nom & Prenom
		if (strlen($data["nom"]) < 3) {
			$data["thereIsError"] = true;
			$data["nom_err"] = "Le nom doit comporter au moins 3 caractères";
		}
		if (strlen($data["prenom"]) < 3) {
			$data["thereIsError"] = true;
			$data["prenom_err"] = "Le prenom doit comporter au moins 3 caractères";
		}
		if (strlen($data["nom"]) > 30) {
			$data["thereIsError"] = true;
			$data["nom_err"] = "Le nom doit comporter au maximum 30 caractères";
		}
		if (strlen($data["prenom"]) > 30) {
			$data["thereIsError"] = true;
			$data["prenom_err"] = "Le prenom doit comporter au maximum 30 caractères";
		}

		// Validate Tele
		if (!preg_match_all("/^((06|07)\d{8})+$/", $data["tel"])) {
			$data["thereIsError"] = true;
			$data["tel_err"] = "Le numéro de telephone que vous saisi est invalide";
		}

		// Validate Password
		if (preg_match_all("/[!@#$%^&*()\-__+.]/", $data["n_mdp"])) {
			if (preg_match_all("/\d/", $data["n_mdp"])) {
				if (!preg_match_all("/[a-zA-Z]/", $data["n_mdp"])) {
					$data["thereIsError"] = true;
					$data["n_mdp_err"] = "Le mot de passe doit contenir au moins une lettre";
				}
			} else {
				$data["thereIsError"] = true;
				$data["n_mdp_err"] = "Le mot de passe doit contenir au moins un chiffres";
			}
		} else {
			$data["thereIsError"] = true;
			$data["n_mdp_err"] = "Le mot de passe doit contient au moin un caractère spécial";
		}
		if (strlen($data["n_mdp"]) > 50) {
			$data["thereIsError"] = true;
			$data["n_mdp_err"] = "Le mot de passe doit comporter au maximum 50 caractères";
		}
		if (strlen($data["n_mdp"]) < 10) {
			$data["thereIsError"] = true;
			$data["n_mdp_err"] = "Le mot de passe doit comporter au moins 10 caractères";
		}

		return $data;
	}

	public function validateMDP($data)
	{
		$data['mdpDb'] = $this->etudiantModel->getPassword($data['id'])->mdp;

		if (!(password_verify($data["c_mdp"], $data['mdpDb']))) {
			$data["thereIsError"] = true;
			$data["c_mdp_err"] = "Mot de passe incorrect !";
		}
		return $data;
	}

	public function changeImg()
	{
		$idEtudiant = $this->id;
		$etudiant = $this->etudiantModel->find($idEtudiant);
		$etudiant->img = URLROOT . "/Public/" . $etudiant->img;

		$data = [];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data['img'] = $_FILES["img"];
			$data['img_err'] = "";
			$data['thereIsError'] = false;

			$data['email'] = $etudiant->email;

			// Upload The Image In Our Server
			$data = $this->uploadImage($data);

			// Checking If There Is An Error
			if ($data["thereIsError"] == true) {
				echo json_encode($data);
			} else {
				// Delete The Old Image
				if ($data["img"] != "images/default.jpg") {
					unlink($etudiant->img);
				}

				$this->etudiantModel->updateImage($data["img"], $idEtudiant);

				$_SESSION["user_data"] = $data;

				$etudiant->img = URLROOT . "/Public/" . $data["img"];
				$data = [
					"img" => $etudiant->img,
				];
				echo json_encode($data);
			}
		} else {
			$data = [
				"nom" => $etudiant->nom,
				"prenom" => $etudiant->prenom,
				"email" => $etudiant->email,
				"tel" => $etudiant->tel,
				"img" => $etudiant->img,
				"nom_err" => "",
				"prenom_err" => "",
				"email_err" => "",
				"img_err" => "",
				"tel_err" => "",
			];
			return view("etudiant/updateInfos", $data);
		}
	}

	private  function uploadImage($data)
	{
		$file = $data["img"]; // Image Array
		$fileName = $file["name"]; // name
		$fileTmpName = $file["tmp_name"]; // location
		$fileError = $file["error"]; // error

		if (!empty($fileTmpName)) {
			$fileExt = explode(".", $fileName);
			$fileRealExt = strtolower(end($fileExt));
			$allowed = array("jpg", "jpeg", "png");


			if (in_array($fileRealExt, $allowed)) {
				if ($fileError === 0) {
					$fileNameNew = substr(number_format(time() * rand(), 0, '', ''), 0, 5) . "." . $fileRealExt;
					$fileDestination = 'images/userImage/' . $fileNameNew;
					move_uploaded_file($fileTmpName, $fileDestination);
					$data["img"] = $fileDestination;
				} else {
					$data["thereIsError"] = true;
					$data["img_err"] = "Une erreur s'est produite lors du téléchargement de votre image !";
				}
			} else {
				$data["thereIsError"] = true;
				$data["img_err"] = "Vous ne pouvez pas télécharger ce fichier. (uniquement jpg, jpeg, png, ico sont autorisé)";
			}
		} else {
			$data["img"] = 'images/default.jpg';
		}

		return $data;
	}

	public function getAllNotifications()
	{
		$notifications = $this->notificationModel->getNotificationsOfEtudiant($_SESSION['id_etudiant']);
		echo json_encode($notifications);
	}

	private function _getNotifications()
	{
		return $this->notificationModel->getNewNotificationsOfEtudiant($_SESSION['id_etudiant']);
	}

	public function notifications()
	{
		$data = ['nbrNotifications' => $this->_getNotifications()];
		return view('etudiant/notifications', $data);
	}

	public function setStateToSeen($id_notification)
	{
		$this->notificationModel->setStateToSeen($id_notification);
		echo json_encode('Terminée !!');
	}

	public function deleteSeenNotifications()
	{
		$this->notificationModel->deleteSeenNotifications();
		echo json_encode('Terminée !!');
	}
}
