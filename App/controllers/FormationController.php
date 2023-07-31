<?php

use App\Models\Formation;
use App\Models\Preview;
use App\Models\Video;
use App\Models\Stocked;
use App\Models\Notification;

class FormationController
{
	private $formationModel;
	private $previewsModel;
	private $videoModel;
	private $stockedModel;
	private $notificationModel;

	public function __construct()
	{
		if (!isset($_SESSION['id_formateur'])) {
			redirect('user/login');
			return;
		}

		$this->formationModel = new Formation;
		$this->previewsModel = new Preview;
		$this->videoModel = new Video;
		$this->stockedModel = new Stocked;
		$this->notificationModel = new Notification;
	}

	public function index()
	{
		redirect('formateur/dashboard');
	}

	private function validFormation($data)
	{
		$id_formation = $data['id_formation'];
		if (empty($this->formationModel->getFormation($id_formation, $_SESSION['id_formateur']))) {
			return 'This Course is not yours !!!';
		}

		// title
		$titre = $data['titre'];
		$countTitre = strlen($titre);

		if ($countTitre > 0) {
			if ($countTitre < 5)
				return '5 caractères au maximum !!!';
			else
				if ($countTitre > 25)
				return '25 caractères au maximum !!!';
		} else
			return 'Veuillez remplir le champ titre !!!';

		// description
		$description = $data['description'];
		$countDesc = strlen($description);

		if ($countDesc > 0) {
			if ($countDesc < 10)
				return '10 caractères au minimum !!!';
			else
				if ($countDesc > 700)
				return '700 caractères au maximum !!!';
		} else
			return 'Veuillez remplir le champ description !!!';

		// prix
		$prix = $data['prix'];
		if (strlen($prix) > 0) {
			if (!preg_match_all('/^(?!0\d)\d*(\.\d+)?$/m', $prix))
				return 'incorrect number !!!';
		} else
			return 'Veuillez remplir le champ prix !!!';

		//categorie
		$categorie = $data['categorie'];
		if (empty($this->stockedModel->getCategorieById($categorie)))
			return "Cette categorie est invalide !!!";

		// level
		$niveauFormation = $data['niveauFormation'];
		if (empty($this->stockedModel->getLevelById($niveauFormation)))
			return "Ce niveau est invalide !!!";

		// langue
		$langue = $data['langue'];
		if (empty($this->stockedModel->getLangueById($langue)))
			return "Ce language est invalide !!!";

		// visibilty
		if ($data['visibility'] != "public" && $data['visibility'] != "private")
			return "Etat de formation invalide !!!";

		return false;
	}

	public function addFormation()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data = [
				"id_formateur"		=> $_SESSION['id_formateur'],
				"nom_formation"		=> $_POST["nom"],
				"prix_formation"	=> $_POST["prix"],
				"niveau_formation"	=> $_POST["niveau"],
				"categorie"			=> $_POST["categorie"],
				"img_formation"		=> $_FILES["image"],
				"description"		=> $_POST["description"],
				"etat_formation"	=> $_POST["visibility"],
				"id_langue"			=> $_POST["language"],
				"videosCollection"	=> json_decode($_POST["JsonVideos"]),
				"masse_horaire"		=> 0,
				"error"				=> ''
			];
			// some data for view
			$data["categories"] = $this->stockedModel->getAllCategories();
			$data["niveaux"] = $this->stockedModel->getAllLevels();
			$data["langues"] = $this->stockedModel->getAllLangues();

			// validate data
			$data['error'] = $this->validateInsertedData($data);

			// upload formation Image
			$data = $this->uploadImage($data);

			// insert data
			if ($data["error"] == false) {
				$formationId = $this->formationModel->create($data);
				if ($formationId) {
					foreach ($data["videosCollection"] as $video) {
						$videoData = [
							"Idformation" => $formationId,
							"nomVideo" => $video->name,
							"duree" => $video->duree,
							"url" => $video->videoPath,
							"desc" => "décrivez ce vidéo ou ajoutez des ressources !",
						];
						$this->videoModel->create($videoData);
					}
				}
				redirect("formateur/dashboard");
				flash("formationAdded", "Vos détails de cours sont insérés avec succès, vous devez donner une description à vos vidéos", "alert alert-info mt-1");
			} else {
				$data['nbrNotifications'] = $this->notificationModel->getNewNotificationsOfFormateur($_SESSION['id_formateur']);
				return view("formation/addFormation", $data);
			}
		} else {
			$data = [
				"nom_formation"		=> "",
				"prix_formation"	=> "",
				"description"		=> "",
				"error"				=> ""
			];
			$data["categories"] = $this->stockedModel->getAllCategories();
			$data["niveaux"] = $this->stockedModel->getAllLevels();
			$data["langues"] = $this->stockedModel->getAllLangues();
			$data['nbrNotifications'] = $this->notificationModel->getNewNotificationsOfFormateur($_SESSION['id_formateur']);
			$data["logo"] = URLROOT . "/Public/" . $this->stockedModel->getThemeData()->logo;
			return view("formation/addFormation", $data);
		}
	}

	public function addVideo($idFormation = '')
	{
		// check the Id if exists
		$formationData = $this->formationModel->getFormation($idFormation, $_SESSION['id_formateur']);
		if (empty($idFormation) || empty($formationData)) {
			redirect("formateur");
		}

		// handling request
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data = [
				"videosCollection"	=> json_decode($_POST["JsonVideos"]),
			];

			// insert data
			foreach ($data["videosCollection"] as $video) {
				$videoData = [
					"Idformation" => $idFormation,
					"nomVideo" => $video->name,
					"duree" => $video->duree,
					"url" => $video->videoPath,
					"desc" => "décrivez ces vidéos ou ajoutez des ressources !",
				];
				$this->videoModel->create($videoData);
			}
			redirect("formateur");
			flash("videoAdded", "Vos vidéos ajoutées avec succès !", "alert alert-info mt-1");
		} else {
			$data['nbrNotifications'] = $this->notificationModel->getNewNotificationsOfFormateur($_SESSION['id_formateur']);
			$data["logo"]= URLROOT . "/Public/" . $this->stockedModel->getThemeData()->logo;
			return view("formateur/addVideo", $data);
		}
	}

	public function deleteVideo()
	{
		if (isset($_POST['id_video'])) {
			$res = $this->videoModel->delete($_POST['id_video']);
			if ($res) {
				unlink($this->videoModel->getVideo($_SESSION['id_formation'], $_POST['id_video'])->url);
				echo json_encode('Video supprimé avec succès !!!');
				flash('deteleVideo', 'Video supprimé avec succès !!!');
			} else {
				echo json_encode("Une erreur s'est produite lors de la suppression !!!");
				flash('deteleVideo', "Une erreur s'est produite lors de la suppression !!!");
			}
		}
	}

	public function isLoggedIn()
	{
		if (isset($_SESSION['id_formateur']))
			return true;
		return false;
	}

	public function validateInsertedData($data)
	{
		// title
		$titre = $data['nom_formation'];
		$countTitre = strlen($titre);

		if ($countTitre > 0) {
			if ($countTitre < 5)
				return '5 caractères au minimum !!!';
			else
				if ($countTitre > 50)
				return '50 caractères au maximum !!!';
		} else
			return 'Veuillez remplir le champ titre !!!';

		// description
		$description = $data['description'];
		$countDesc = strlen($description);

		if ($countDesc > 0) {
			if ($countDesc < 60)
				return '60 caractères au minimum !!!';
			else
				if ($countDesc > 700)
				return '700 caractères au maximum !!!';
		} else
			return 'Veuillez remplir le champ description !!!';

		// prix
		$prix = $data['prix_formation'];
		if (strlen($prix) > 0) {
			if (!filter_var($prix, FILTER_VALIDATE_INT))
				return 'Nombre incorrect !!!';
		} else
			return 'Veuillez remplir le champ prix !!!';

		//categorie
		$categorie = $data['categorie'];
		if (empty($this->stockedModel->getCategorieById($categorie)))
			return "Cette categorie est invalide !!!";

		// level
		$niveauFormation = $data['niveau_formation'];
		if (empty($this->stockedModel->getLevelById($niveauFormation)))
			return "Ce niveau est invalide !!!";

		return false;
	}

	private function uploadFile($path, $id)
	{
		$errors = "";
		$file_name = $_FILES['file']['name'];
		$file_size = $_FILES['file']['size'];
		$file_tmp = $_FILES['file']['tmp_name'];

		$new_file_name = substr(number_format(time() * rand(), 0, '', ''), 0, 5) . "_" . strtolower(preg_replace('/\s+/', '_', $file_name));
		$upload_path = $path . $new_file_name;
		if ($file_size > 41943040) {
			$errors = 'Très grande taille de fichier';
			return null;
		} else {
			move_uploaded_file($file_tmp, $upload_path);
		}

		if (empty($errors)) {
			$data = [];
			$data['path'] = $upload_path;
			$data['id'] = $id;
			if (explode('/', $path)[2] === 'files') {
				$this->formationModel->updateFile($data);
				echo json_encode("Pièce jointe ajouté avec succès");
			} else {
				$this->formationModel->updateImage($data);
				echo json_encode("La vignette de formation ajouté avec succès");
			}
		} else {
			echo json_encode(["error" => $errors]);
		}
	}

	public function updateFormation($id = null)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_FILES['file']) && !is_null($id)) {
				if ($_FILES['file']['type'] !== 'application/zip' && $_FILES['file']['type'] !== 'application/x-zip-compressed') {
					$path = 'images/formations/images/';
				} else {
					$path = 'images/formations/files/';
				}
				$this->uploadFile($path, $id);
			} else {
				$error = $this->validFormation($_POST);
				if ($error === false) {
					unset($error);
					// update formation
					$this->formationModel->update($_POST);
					flash('updateFormation', 'Modification affecté avec succès !!!');
					redirect('formateur/dashboard');
				}
				flash('updateFormation', $error);
				redirect('formateur/dashboard');
			}
		}
	}

	private function formatDate($dateTime)
	{
		$date = explode('-', date('d-F-Y', strtotime($dateTime)));
		$day = $date[0];
		$month = $date[1];
		$year = $date[2];
		$date = $month . ' ' . $day . ', ' . $year;
		return $date;
	}

	public function videos(int $id_formation)
	{
		// check if this formateur has this formation.
		$hasFormation = $this->formationModel->getFormation($id_formation, $_SESSION['id_formateur']);
		if (!empty($hasFormation)) {
			$data["videos"] = $this->videoModel->getVideosOfFormation($id_formation);
			if (!empty($data['videos'])) {
				$data["videos"][0]->date_creation = $this->formatDate($data["videos"][0]->date_creation);
				// to access to that formation in deleteVideo method
				// I unset this variable when i go back to the dashboard 
				$_SESSION['id_formation'] = $data["videos"][0]->id_formation;
				$data["videos"][0]->masse_horaire = $this->videoModel->countMassHorraire($data["videos"][0]->id_formation);
				foreach ($data["videos"] as $key => $value) {
					$data["videos"][$key]->url = URLROOT . "/Public/" . $data["videos"][$key]->url;
				}
				$data['nbrNotifications'] = $this->notificationModel->getNewNotificationsOfFormateur($_SESSION['id_formateur']);

				return view('formateur/videos', $data);
			} else {
				flash("formationVide", "Votre cours ne contient aucune vidéo, veuillez ajoutez des vidéos", "alert alert-info");
				redirect("formation/addVideo/" . $id_formation);
			}
		} else {
			flash("formationNotExists", "Cette formation n`existe pas", "alert alert-info");
			redirect("formateur");
		}
	}

	private function validVideo($data)
	{
		// title
		if (isset($data['titre'])) {
			$titre = $data['titre'];
			$countTitre = strlen($titre);
			if ($countTitre > 0) {
				if ($countTitre < 5)
					return '5 caractères au minimum !!!';
				else
					if ($countTitre > 50)
					return '50 caractères au maximum !!!';
			} else
				return 'Veuillez remplir le champ titre !!!';
		}

		// Description
		if (isset($data['description'])) {
			$description = $data['description'];
			$countDesc = strlen($description);

			if ($countDesc > 0) {
				if ($countDesc < 6)
					return '6 caractères au minimum !!!';
				else
						if ($countDesc > 600)
					return '600 caractères au maximum !!!';
			} else
				return 'Veuillez remplir le champ description !!!';
		}

		return false;
	}

	public function updateVideo()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$error = $this->validVideo($_POST);
			if ($error === false) {
				unset($error);
				// update Video
				$data = $_POST;
				$data['id_formation'] = $_SESSION['id_formation'];
				$this->videoModel->update($data);
				flash('updateVideo', 'Modification affecté avec succès !!!');
				echo json_encode('Modification affecté avec succès !!!');
			}
		}
	}

	private  function uploadImage($data)
	{
		$file = $data["img_formation"]; // Image Array
		$fileName = $file["name"]; // name
		$fileTmpName = $file["tmp_name"]; // location
		$fileError = $file["error"]; // error

		if (!empty($fileTmpName)) {
			$fileExt = explode(".", $fileName);
			$fileRealExt = strtolower(end($fileExt));
			$allowed = array("jpg", "jpeg", "png");


			if (in_array($fileRealExt, $allowed)) {
				if ($fileError === 0 && $data["error"] == false) {
					$fileNameNew = substr(number_format(time() * rand(), 0, '', ''), 0, 5) . "." . $fileRealExt;
					$fileDestination = 'images/formations/images/' . $fileNameNew;
					move_uploaded_file($fileTmpName, $fileDestination);
					$data["img_formation"] = $fileDestination;
				} else {
					$data["error"] = "Une erreur s'est produite lors du téléchargement de votre image ";
				}
			} else {
				$data["error"] = "Vous ne pouvez pas télécharger ce fichier. (uniquement jpg, jpeg, png, ico sont autorisé)";
			}
		} else {
			$data["img_formation"] = "images/default_formation.jpg";
		}

		return $data;
	}

	public function setOrdreVideos()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['videosWithOrder'])) {
				// Don't Forget Validation Back-end Order
				$this->videoModel->setOrderVideos(json_decode($_POST['videosWithOrder']));
				flash("orderApplied", "Demande appliqueé avec succès !!!");
				echo json_encode("Terminée !!!");
			}
		}
	}

	public function updatePreviewVideo($id_video)
	{
		$this->previewsModel->updatePreview($id_video, $_SESSION['id_formation']);
		echo json_encode('Updated Well !!!');
	}

	public function insertPreviewVideo($id_video)
	{
		if (empty($this->previewsModel->getPreviewByFormation($_SESSION['id_formation']))) {
			$this->previewsModel->insertPreviewVideo($id_video, $_SESSION['id_formation']);
			echo json_encode('Bien inseré !!!');
		} else {
			$this->updatePreviewVideo($id_video);
		}
	}
}