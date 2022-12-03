<?php

class Formations extends Controller
{
	public function __construct()
	{
		if (!isset($_SESSION['user_id'])) {
			redirect('users/login');
			return;
		}

		$this->formationModel = $this->model("Formation");
		$this->videoModel = $this->model("Video");
		$this->stockedModel = $this->model("Stocked");
		$this->folderModel = $this->model("Folder");
	}

	public function index()
	{
		redirect('formateur/dashboard');
	}

	private function validFormation($data)
	{
		$id_formation = $data['id_formation'];
		if (empty($this->formationModel->getFormation($id_formation, $_SESSION['user_id']))) {
			return 'This Course is not yours !!!';
		}
		
		// title
		$titre = $data['titre'];
		$countTitre = strlen($titre);

		if ($countTitre > 0) {
			if ($countTitre < 5)
				return 'Mininum caracteres 5 !!!';
			else
				if ($countTitre > 25)
				return 'Maxmimun caracteres 25 !!!';
		} else
			return 'Veuillez remplir le champ titre !!!';

		// description
		$description = $data['description'];
		$countDesc = strlen($description);

		if ($countDesc > 0) {
			if ($countDesc < 10)
				return 'Mininum caracteres 10 !!!';
			else
				if ($countDesc > 500)
				return 'Maxmimun caracteres 500 !!!';
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
			return "this categorie doesn't exist in the DB !!!";

		// level
		$niveauFormation = $data['niveauFormation'];
		if (empty($this->stockedModel->getLevelById($niveauFormation)))
			return "this level doesn't exist in the DB !!!";

		// langue
		$langue = $data['langue'];
		if (empty($this->stockedModel->getLangueById($langue)))
			return "this language doesn't exist in the DB !!!";

		return false;
	}
		
	public function addFormation(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$data=[
				"id_formateur"		=>$_SESSION['user_id'],
				"nom_formation"		=>$_POST["nom"],
				"prix_formation"	=>$_POST["prix"],
				"niveau_formation"	=>$_POST["niveau"],
				"categorie"			=>$_POST["categorie"],
				"img_formation"		=>$_FILES["image"],
				"description"		=>$_POST["description"],
				"videosCollcetion"	=>json_decode($_POST["JsonVideos"]),
				"masse_horaire"		=>0,
				"error"				=>''
			];
			// some data for view
			$data["folders"]=$this->folderModel->getFolderByEmail($_SESSION['user']['email']);
			$data["allcategories"]=$this->stockedModel->getAllCategories($_SESSION['user']['email']);
			$data["levels"]=$this->stockedModel->getAllLevels();

			// validate data
			$data['error']=$this->validateInsertedData($data);

			// upload formation Image
			$data=$this->uploadImage($data);

			// insert data
			if($data["error"]==false){
				$formationId= $this->formationModel->insertFormation($data);
				foreach($data["videosCollcetion"] as $video){
					$videoData=[
						"Idformation"=>$formationId,
						"nomVideo"=>$video->name,
						"duree"=>$video->duree,
						"url"=>$video->file_id,
						"desc"=>"discribe this video or add a ressources !",
					];
					$this->videoModel->insertVideo($videoData);
				}
				redirect("formateur/index");
				flash("formationAdded", "Vos détails de cours sont insérés avec succès, vous devez donner une description à vos vidéos", "alert alert-info mt-5");
			}else{
				$this->view("formation/addFormation", $data);
			}
		}else{
			$data=[
				"nom_formation"		=>"",
				"prix_formation"	=>"",
				"description"		=>"",
				"error"				=>""
			];
			$data["folders"]=$this->folderModel->getFolderByEmail($_SESSION['user']['email']);
			$data["allcategories"]=$this->stockedModel->getAllCategories($_SESSION['user']['email']);
			$data["levels"]=$this->stockedModel->getAllLevels();
			$this->view("formation/addFormation", $data);
		}
	}	

	public function deleteVideo()
	{
		if (isset($_POST['id_video'])) {
			$this->videoModel->deteleVideo($_SESSION['id_formation'], $_POST['id_video']);
			flash('deteleVideo', 'La Formation a ete supprimer avec success !!!');
			echo 'La Formation a ete supprimer avec success !!!';
		}
	}
	
	public function isLoggedIn(){
		if(isset($_SESSION['user_id']))
			return true;
		return false;
  	}
	
	public function validateInsertedData($data)
	{
		// title
		$titre = $data['nom_formation'];
		$countTitre = strlen($titre);

		if($countTitre > 0){
			if($countTitre < 5)
				return 'Mininum caracteres 5 !!!';
			else
				if($countTitre > 50)
					return 'Maxmimun caracteres 50 !!!';
		}
		else
			return 'Veuillez remplir le champ titre !!!';

		// description
		$description = $data['description'];
		$countDesc = strlen($description);

		if($countDesc > 0){
			if($countDesc < 60)
				return 'Mininum caracteres 60 !!!';
			else
				if($countDesc > 700)
					return 'Maxmimun caracteres 700 !!!';
		}
		else
			return 'Veuillez remplir le champ description !!!';

		// prix
		$prix = $data['prix_formation'];
		if(strlen($prix) > 0){
			if(!filter_var($prix, FILTER_VALIDATE_INT))
				return 'incorrect number !!!';
		}
		else
			return 'Veuillez remplir le champ prix !!!';

		//categorie
		$categorie = $data['categorie'];
		if(empty($this->stockedModel->getCategorieById($categorie)))
			return "this categorie doesn't exist in the DB !!!";

		// level
		$niveauFormation = $data['niveau_formation'];
		if(empty($this->stockedModel->getLevelById($niveauFormation)))
			return "this level doesn't exist in the DB !!!";

		return false;
	}

	public function updateFormation()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$error = $this->validFormation($_POST);
			if ($error === false) {
				unset($error);
				// update formation
				$this->formationModel->updateFormation($_POST);
				flash('updateFormation', 'La Modification a ete faites avec success !!!');
				redirect('formateur/dashboard');
			}
			flash('updateFormation', $error);
			redirect('formateur/dashboard');
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
		// to access to that formation in deleteVideo method
		// I unset this variable when i go back to the dashboard 
		$_SESSION['id_formation'] = $id_formation;
		// check if this formateur has this formation.
		$hasFormation = $this->formationModel->getFormation($id_formation, $_SESSION['user_id']);
		if (!empty($hasFormation)) {
			$data = $this->videoModel->getVideosOfFormation($id_formation);
			if (!empty($data)) {
				$data[0]->date_creation_formation = $this->formatDate($data[0]->date_creation_formation);
				$data[0]->url_video = $this->pcloudFile()->getLink($data[0]->url_video);
				$this->view('formateur/videos', $data);
			} else
				die("This Formation doesn't have any videos !!!");
		} else {
			die('Error 404 !!!');
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
					return 'Mininum caracteres 5 !!!';
				else
					if ($countTitre > 50)
					return 'Maxmimun caracteres 50 !!!';
			} else
				return 'Veuillez remplir le champ titre !!!';
		}

		// Description
		if (isset($data['description'])) {
			$description = $data['description'];
			$countDesc = strlen($description);

			if ($countDesc > 0) {
				if ($countDesc < 6)
					return 'Mininum caracteres 6 !!!';
				else
						if ($countDesc > 600)
					return 'Maxmimun caracteres 600 !!!';
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
				$this->videoModel->updateVideo($data);
				flash('updateVideo', 'La Modification a ete faites avec success !!!');
				echo 'La Modification a ete faites avec success !!!';
			}
		}
	}

	private  function uploadImage($data)
   	{
        $file = $data["img_formation"]; // Image Array
        $fileName = $file["name"]; // name
        $fileTmpName = $file["tmp_name"]; // location
        $fileError = $file["error"]; // error

        if(!empty($fileTmpName)){
            $fileExt = explode(".", $fileName);
            $fileRealExt = strtolower(end($fileExt));
            $allowed = array("jpg", "jpeg", "png");
    
    
            if (in_array($fileRealExt, $allowed)) {
                if ($fileError === 0 && $data["error"]==false) {
                    $fileNameNew = substr(number_format(time() * rand(), 0, '', ''), 0, 5).".". $fileRealExt;
                    $fileDestination = 'images\\userImage\\' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $data["img_formation"]=$fileDestination;

					// upload it to pCloud
                    $imagesFolderId=$data["folders"]["imagesId"];
                    $metaData=$this->pcloudFile()->upload($fileDestination, $imagesFolderId);
                    unlink($fileDestination);
                    $data["img_formation"]=$metaData->metadata->fileid;

                } else {
                    $data["error"]="Une erreur s'est produite lors du téléchargement de votre image ";
                }
            } else {
                $data["error"]="Vous ne pouvez pas télécharger ce fichier uniquement (jpg | jpeg | png | ico) autorisé";
            }
        }else{
            $data["img_formation"]=45389586920;
        }

        return $data;
    }
}
