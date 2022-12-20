<?php

class Formateurs extends Controller
{
	public function __construct()
	{
		if (!isset($_SESSION['id_formateur'])) {
			redirect('users/login');
			return;
		}
		$this->stockedModel = $this->model("Stocked");
		$this->fomateurModel = $this->model("Formateur");
		$this->requestPaymentModel = $this->model("requestPayment");
		$this->notificationModel = $this->model("Notification");
		$this->folderModel = $this->model("Folder");
		$this->inscriptionModel = $this->model("Inscription");
		$this->videoModel = $this->model("Video");
		$this->formationModel = $this->model("Formation");
		$this->commentModel = $this->model("Commentaire");
	}

	public function index()
	{
		$this->dashboard();
	}

	public function dashboard()
	{
		if (isset($_SESSION['id_formation'])) unset($_SESSION['id_formation']);
		$categories = $this->stockedModel->getAllCategories();
		$langues = $this->stockedModel->getAllLangues();
		$levels = $this->stockedModel->getAllLevels();
		$balance = $this->fomateurModel->getFormateurByEmail($_SESSION['user']['email_formateur'])['balance'];
		$data = [
			'balance' => $balance,
			'categories' => $categories,
			'langues' => $langues,
			'levels' => $levels,
		];

		$this->view('formateur/index', $data);
	}

	public function requestPayment()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$requestInfo = json_decode($_POST['data']);
			if ($this->checkBalance($requestInfo)) {
				// placer la demande
				$this->requestPaymentModel->insertRequestPayment($_SESSION['id_formateur'], $requestInfo->montant);
				echo "votre demande a été placer avec success";
			}
		} else {
			$this->view('formateur/requestPayment');
		}
	}

	private function checkBalance($requestInfo)
	{
		if ($requestInfo->paypalEmail == $_SESSION['user']['paypalMail']) {
			if ($requestInfo->montant >= 10) {
				$formateur_balance = $this->fomateurModel->getFormateurByEmail($_SESSION['user']['email_formateur'])['balance'];
				if ($requestInfo->montant <= $formateur_balance)
					return true;
				return false;
			}
		}
	}

	public function getPaymentsHistory()
	{
		$requestsPayments = $this->requestPaymentModel->getRequestsOfFormateur($_SESSION['id_formateur']);
		echo json_encode($requestsPayments);
	}

	public function deleteRequest($id_req)
	{
		$this->requestPaymentModel->deleteRequest($id_req);
		echo 'request deleted with success';
	}

	public function getAllNotifications()
	{
		$notifications = $this->notificationModel->getNotificationsOfFormateur($_SESSION['id_formateur']);
		echo json_encode($notifications);
	}

	public function notifications()
	{
		$nbrNotifications = $this->notificationModel->getNewNotificationsOfFormateur($_SESSION['id_formateur']);
		$this->view('pages/notifications', $nbrNotifications);
	}

	public function setStateToSeen($id_notification)
	{
		$this->notificationModel->setStateToSeen($id_notification);
		echo 'DONE!!';
	}

	public function deleteSeenNotifications()
	{
		$this->notificationModel->deleteSeenNotifications();
		echo 'DONE **';
	}

	// Update Profil 

	public function updateInfos()
	{
		$idFormateur = $_SESSION['id_formateur'];;
		$info = $this->fomateurModel->getFormateurById($idFormateur);
		$info['img'] = $this->pcloudFile()->getLink($info['img']);
		$categories = $this->stockedModel->getAllCategories();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Prepare Data
			$data = [
				"id" => $idFormateur,
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

				$this->fomateurModel->updateFormateur($data);

				$_SESSION["user_data"] = $data;

				$info = $this->fomateurModel->getFormateurById($idFormateur);
				$info['img'] = $this->pcloudFile()->getLink($info['img']);

				$data = [
					"nom" => $info['nomFormateur'],
					"prenom" => $info['prenomFormateur'],
					"email" => $info['email'],
					"tel" => $info['tel'],
					"img" => $info['img'],
					'categorie' => $info['categorie'],
					"specId" => $info['id_categorie'],
					"bio" => $info['biography'],
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
				"nom" => $info['nomFormateur'],
				"prenom" => $info['prenomFormateur'],
				"email" => $info['email'],
				"tel" => $info['tel'],
				"img" => $info['img'],
				'categorie' => $info['categorie'],
				"specId" => $info['id_categorie'],
				"bio" => $info['biography'],
				"nom_err" => "",
				"prenom_err" => "",
				"img_err" => "",
				"tel_err" => "",
				"specId_err" => "",
				"bio_err" => "",
				"c_mdp_err" => "",
				"n_mdp_err" => "",
			];
			$this->view("formateur/updateInfos", [$data, $categories]);
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
					$data["n_mdp_err"] = "Le mot de passe doit contenir au moins 1 lettre";
				}
			} else {
				$data["thereIsError"] = true;
				$data["n_mdp_err"] = "Le mot de passe doit contenir au moins 1 chiffres";
			}
		} else {
			$data["thereIsError"] = true;
			$data["n_mdp_err"] = "Le mot de passe doit contient spécial character";
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
			$data["bio_err"] = "La Biography doit comporter au maximum 500 caractères";
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
		$data['mdpDb'] = $this->fomateurModel->getMDPFormateurById($data['id'])['mdp'];
		if (!(password_verify($data["c_mdp"], $data['mdpDb']))) {
			$data["thereIsError"] = true;
			$data["c_mdp_err"] = "Le mots de passe est incorrect.";
		}
		return $data;
	}

	public function changeImg()
	{
		$idFormateur = $_SESSION['id_formateur'];
		$info = $this->fomateurModel->getFormateurById($idFormateur);
		$info['img'] = $this->pcloudFile()->getLink($info['img']);

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data['img'] = $_FILES["img"];
			$data['img_err'] = "";
			$data['thereIsError'] = false;

			$data['email'] = $info['email'];

			// Upload The Image In Our Server
			$data = $this->uploadImage($data);

			// Checking If There Is An Error
			if ($data["thereIsError"] == true) {
				echo json_encode($data);
			} else {
				// Upload The Image
				if ($data["img"] != 45393256813) {
					$imagesFolderId = $this->folderModel->getFolderByEmail($data['email']);
					$imagesFolderId = $imagesFolderId["imagesId"];
					$imagePath = $data["img"];
					$this->pcloudFile()->delete((int) $info['img']);
					$metaData = $this->pcloudFile()->upload($imagePath, $imagesFolderId);
					unlink($imagePath);
					$data["img"] = $metaData->metadata->fileid;
				}

				$this->fomateurModel->changeImg($data["img"], $idFormateur);

				$_SESSION["user_data"] = $data;

				$infos = $this->fomateurModel->getFormateurById($idFormateur);
				$info['img'] = $this->pcloudFile()->getLink($info['img']);
				$data = [
					"img" => $infos['img'],
				];
				echo json_encode($data);
			}
		} else {
			$data = [
				"nom" => $info->nomFormateur,
				"prenom" => $info->prenomFormateur,
				"email" => $info->email,
				"tel" => $info->tel,
				"img" => $info->img,
				"specId" => $info->id_categorie,
				"bio" => $info->biography,
				"nom_err" => "",
				"prenom_err" => "",
				"email_err" => "",
				"img_err" => "",
				"tel_err" => "",
				"specId_err" => "",
				"bio_err" => "",
			];
			$this->view("formateur/updateInfos", $data);
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
					$fileDestination = 'images\\userImage\\' . $fileNameNew;
					move_uploaded_file($fileTmpName, $fileDestination);
					$data["img"] = $fileDestination;
				} else {
					$data["thereIsError"] = true;
					$data["img_err"] = "Une erreur s'est produite lors du téléchargement de votre image ";
				}
			} else {
				$data["thereIsError"] = true;
				$data["img_err"] = "Vous ne pouvez pas télécharger ce fichier uniquement (jpg | jpeg | png | ico) autorisé";
			}
		} else {
			$data["img"] = 45393256813;
		}

		return $data;
	}

	public function coursVideos($idFormateur = "", $idFormation = "")
	{
		// preparing data
		$data = $this->inscriptionModel->getInscriptionOfOneFormation($idFormation, 5, $idFormateur);
		$data->img_formateur = $this->pcloudFile()->getLink($data->img_formateur);
		$data->image_formation = $this->pcloudFile()->getLink($data->image_formation);
		$data->img_etudiant = $this->pcloudFile()->getLink($data->img_etudiant);
		$data->categorie = $this->stockedModel->getCategorieById($data->categorie)["nom_categorie"];
		$data->specialiteId = $this->stockedModel->getCategorieById($data->specialiteId)["nom_categorie"];
		$data->id_langue = $this->stockedModel->getLangueById($data->id_langue)["nom_langue"];
		$data->niveau = $this->stockedModel->getLevelById($data->niveau_formation)["nom_niveau"];
		$data->apprenants = $this->inscriptionModel->countApprenantsOfFormation($data->id_formateur, $data->id_formation)["total_apprenants"];
		$data->videos = $this->videoModel->getVideosOfFormation($idFormation);
		$data->liked = $this->formationModel->likedBefore($data->id_etudiant, $data->id_formation);

		foreach ($data->videos as $video) {
			// settingUp Video Link
			$video->url_video = $this->pcloudFile()->getLink($video->url_video);
			$video->comments = $this->commentModel->getCommentaireByVideoId($video->id_video);
			$video->watched = $this->videoModel->watchedBefore($data->id_etudiant, $video->id_video);
			$video->bookmarked = $this->videoModel->bookmarked($data->id_etudiant, $video->id_video);
			// settingUp User image Link for comment
			foreach ($video->comments as $comment) {
				$comment->img_etudiant = $this->pcloudFile()->getLink($comment->img_etudiant);
			}
		}
		// loading the view
		$this->view("etudiant/coursVideos", $data);
	}
}
