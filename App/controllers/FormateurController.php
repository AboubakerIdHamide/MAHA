<?php

use App\Models\Formateur;
use App\Models\Formation;
use App\Models\Video;
use App\Models\Inscription;
use App\Models\Stocked;
use App\Models\Commentaire;
use App\Models\Notification;
use App\Models\requestPayment;

class FormateurController
{
	private $fomateurModel;
	private $formationModel;
	private $videoModel;
	private $inscriptionModel;
	private $stockedModel;
	private $commentModel;
	private $notificationModel;
	private $requestPaymentModel;

	public function __construct()
	{
		if (!auth()) {
			return redirect('user/login');
		}

		if(session('user')->get()->type !== 'formateur'){
			return view('errors/page_404');
		}

		if(!session('user')->get()->email_verified_at) {
			return redirect('user/verify');
		}

		$this->fomateurModel = new Formateur;
		$this->formationModel = new Formation;
		$this->videoModel = new Video;
		$this->inscriptionModel = new Inscription;
		$this->stockedModel = new Stocked;
		$this->commentModel = new Commentaire;
		$this->notificationModel = new Notification;
		$this->requestPaymentModel = new requestPayment;
	}

	public function index()
	{
		if($_SESSION['user']->is_all_info_present){
			if (isset($_SESSION['id_formation'])) unset($_SESSION['id_formation']);
			$categories = $this->stockedModel->getAllCategories();
			$langues = $this->stockedModel->getAllLangues();
			$niveaux = $this->stockedModel->getAllLevels();
			$balance = $this->fomateurModel->whereEmail($_SESSION['user']->email)->balance;
			$data = [
				'balance' => $balance,
				'categories' => $categories,
				'langues' => $langues,
				'niveaux' => $niveaux,
				'nbrNotifications' => $this->_getNotifications()
			];

			return view('formateurs/index', $data);
		}
		return redirect('user/continue');
	}

	public function requestPayment()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$requestInfo = json_decode($_POST['data']);
			if ($this->checkBalance($requestInfo)) {
				// placer la demande
				$this->requestPaymentModel->insertRequestPayment($_SESSION['user']->id_formateur, $requestInfo->montant);
				echo json_encode("votre demande a été mis avec success");
			}
		} else {
			return view('formateurs/requestPayment', ['nbrNotifications' => $this->_getNotifications()]);
		}
	}

	private function checkBalance($requestInfo)
	{
		if ($requestInfo->paypalEmail == $_SESSION['user']->paypalMail) {
			if ($requestInfo->montant >= 10) {
				$formateur_balance = $this->fomateurModel->whereEmail($_SESSION['user']->email)->balance;
				if ($requestInfo->montant <= $formateur_balance)
					return true;
				return false;
			}
		}
	}

	public function getPaymentsHistory()
	{
		echo json_encode($this->requestPaymentModel->getRequestsOfFormateur($_SESSION['user']->id_formateur));
	}

	public function deleteRequest($id_req)
	{
		$this->requestPaymentModel->deleteRequest($id_req);
		echo json_encode('Demande supprimée avec succès !!');
	}

	public function getAllNotifications()
	{
		echo json_encode($this->notificationModel->getNotificationsOfFormateur($_SESSION['user']->id_formateur));
	}

	private function _getNotifications()
	{
		return $this->notificationModel->getNewNotificationsOfFormateur($_SESSION['user']->id_formateur);
	}

	public function notifications()
	{
		return view('common/index', ['nbrNotifications' => $this->_getNotifications()]);
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

	// Update Profil 
	public function updateInfos()
	{
		$formateur = $this->fomateurModel->find($_SESSION['user']->id_formateur);
		// $formateur->img = URLROOT . "/Public/" . $formateur->img;
		$categories = $this->stockedModel->getAllCategories();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Prepare Data
			$data = [
				"id" => $_SESSION['user']->id_formateur,
				"nom" => trim($_POST["nom"]),
				"prenom" => trim($_POST["prenom"]),
				"tel" => trim($_POST["tel"]),
				"specId" => trim($_POST["specialite"]),
				"bio" => trim($_POST["biographie"]),
				"c_mdp" => trim($_POST["c_mdp"]),
				"n_mdp" => trim($_POST["n_mdp"]),
				"nom_err" => "",
				"prenom_err" => "",
				"tel_err" => "",
				"specId_err" => "",
				"bio_err" => "",
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

				$this->fomateurModel->update($data);

				$_SESSION["user_data"] = $data;

				$formateur = $this->fomateurModel->find($_SESSION['user']->id_formateur);
				$formateur->img = URLROOT . "/Public/" . $formateur->img;

				$data = [
					"nom" => $formateur->nomFormateur,
					"prenom" => $formateur->prenom,
					"email" => $formateur->email,
					"tel" => $formateur->tel,
					"img" => $formateur->img,
					'categorie' => $formateur->nomCategorie,
					"specId" => $formateur->id_categorie,
					"bio" => $formateur->biographie,
					"nom_err" => "",
					"prenom_err" => "",
					"img_err" => "",
					"tel_err" => "",
					"specId_err" => "",
					"bio_err" => "",
					"c_mdp_err" => "",
					"n_mdp_err" => "",
				];

				echo json_encode($data);
			}
		} else {
			$data = [
				"nom" => $formateur->nomFormateur,
				"prenom" => $formateur->prenom,
				"email" => $formateur->email,
				"tel" => $formateur->tel,
				"img" => $formateur->img,
				'categorie' => $formateur->nomCategorie,
				"specId" => $formateur->id_categorie,
				"bio" => $formateur->biographie,
				"nom_err" => "",
				"prenom_err" => "",
				"img_err" => "",
				"tel_err" => "",
				"specId_err" => "",
				"bio_err" => "",
				"c_mdp_err" => "",
				"n_mdp_err" => "",
				"categories" => $categories,
				"nbrNotifications" => $this->_getNotifications()
			];
			return view("formateurs/updateInfos", $data);
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

		// Validate Biography
		if (strlen($data["bio"]) > 500) {
			$data["thereIsError"] = true;
			$data["bio_err"] = "La Biographie doit comporter au maximum 500 caractères";
		}
		if (strlen($data["bio"]) < 130) {
			$data["thereIsError"] = true;
			$data["bio_err"] = "Le résumé doit avoir au moins 130 caractères";
		}

		// Validate Specialité
		if (empty($this->stockedModel->getCategorieById($data["specId"]))) {
			$data["thereIsError"] = true;
			$data["specId_err"] = "Spécialité Invalide";
		}

		return $data;
	}

	public function validateMDP($data)
	{
		if (!(password_verify($data["c_mdp"], $this->fomateurModel->getPassword($data['id'])->mdp))) {
			$data["thereIsError"] = true;
			$data["c_mdp_err"] = "Mot de passe incorrect !";
		}
		return $data;
	}

	public function changeImg()
	{
		$formateur = $this->fomateurModel->find($_SESSION['user']->id_formateur);
		$formateur->img = URLROOT . "/Public/" . $formateur->img;

		$data = [];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data['img'] = $_FILES["img"];
			$data['img_err'] = "";
			$data['thereIsError'] = false;

			$data['email'] = $formateur->email;

			// Upload The Image In Our Server
			$data = $this->uploadImage($data);

			// Checking If There Is An Error
			if ($data["thereIsError"] == true) {
				echo json_encode($data);
			} else {
				// Delete The Old Image
				if ($data["img"] != "images/default.jpg") {
					unlink($formateur['img']);
				}

				$this->fomateurModel->updateImage($data["img"], $_SESSION['user']->id_formateur);

				$_SESSION["user_data"] = $data;

				// $infos = $this->fomateurModel->getFormateurById($_SESSION['user']->id_formateur);
				$formateur->img = URLROOT . "/Public/" . $data['img'];
				$data = [
					"img" => $formateur->img,
				];
				echo json_encode($data);
			}
		} else {
			$data = [
				"nom" => $formateur->nom,
				"prenom" => $formateur->prenom,
				"email" => $formateur->email,
				"tel" => $formateur->tel,
				"img" => $formateur->img,
				"specId" => $formateur->id_categorie,
				"bio" => $formateur->biographie,
				"nom_err" => "",
				"prenom_err" => "",
				"email_err" => "",
				"img_err" => "",
				"tel_err" => "",
				"specId_err" => "",
				"bio_err" => "",
			];
			return view("formateur/updateInfos", $data);
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
					$data["img_err"] = "Une erreur s'est produite lors du téléchargement de votre image ";
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

	private function _isFormateurHaveThisFormation($idFormation)
	{
		return (bool) $this->formationModel->getFormation($idFormation, $_SESSION['user']->id_formateur);
	}

	public function coursVideos($id_etudiant = "", $idFormation = "")
	{
		if ($this->_isFormateurHaveThisFormation($idFormation)) {
			// preparing data 
			$data = $this->inscriptionModel->getInscriptionOfOneFormation($idFormation, $id_etudiant, $_SESSION['user']->id_formateur);
			$data->imgFormateur = URLROOT . "/Public/" . $data->imgFormateur;
			$data->image = URLROOT . "/Public/" . $data->image;
			$data->imgEtudiant = URLROOT . "/Public/" . $data->imgEtudiant;
			$data->formationCategorie = $this->stockedModel->getCategorieById($data->formationCategorie)->nom;
			$data->formateurCategorie = $this->stockedModel->getCategorieById($data->formateurCategorie)->nom;
			$data->langue = $this->stockedModel->getLangueById($data->langue)->nom;
			$niveau = $this->stockedModel->getLevelById($data->niveau);
			$data->niveau = $niveau->nom;
			$data->niveauIcon = $niveau->icon;
			$data->apprenants = $this->inscriptionModel->countApprenantsOfFormation($data->id_formateur, $data->id_formation);
			$data->videos = $this->videoModel->getVideosOfFormation($idFormation);
			$data->liked = $this->formationModel->isLikedBefore($data->id_etudiant, $data->id_formation);

			foreach ($data->videos as $video) {
				// settingUp Video Link
				$video->url = URLROOT . "/Public/" . $video->url;
				$video->comments = $this->commentModel->getCommentaireByVideoId($video->id_video, $_SESSION['user']->id_formateur, $id_etudiant);
				// settingUp User image Link for comment
				foreach ($video->comments as $comment) {
					$comment->img = URLROOT . "/Public/" . $comment->img;
				}
			}
			// loading the view
			return view("formateur/coursVideos", $data);
		} else
			die("Une erreur s'est produite !!!");
	}

	public function subscriptionCode()
	{
		$data = ['nbrNotifications' => $this->_getNotifications()];

		// refresh code
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data['code_formateur'] = $this->fomateurModel->refreshCode($_SESSION['user']->id_formateur);
		}

		return view("formateurs/subscriptionCode", $data);
	}
}
