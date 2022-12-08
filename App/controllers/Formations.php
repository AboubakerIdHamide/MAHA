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
				if($formationId){
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
				}
				redirect("formateur/index");
				flash("formationAdded", "Vos détails de cours sont insérés avec succès, vous devez donner une description à vos vidéos", "alert alert-info mt-1");
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

	public function addVideo($idFormation=''){
		// check the Id if exists
		$formationData=$this->formationModel->getFormation($idFormation, $_SESSION['user_id']);
		if(empty($idFormation) || empty($formationData)){
			redirect("formateur/index");
		}

		// handling request
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$data=[
				"videosCollcetion"	=>json_decode($_POST["JsonVideos"]),
			];

			// insert data
			$formationId=$idFormation;
			foreach($data["videosCollcetion"] as $video){
				$videoData=[
					"Idformation"=>$formationId,
					"nomVideo"=>$video->name,
					"duree"=>$video->duree,
					"url"=>$video->file_id,
					"desc"=>"décrivez ces vidéos ou ajoutez des ressources !",
				];
				$this->videoModel->insertVideo($videoData);
			}
			redirect("formateur/index");
			flash("videoAdded", "Vos vidéos ajoutées avec succès !", "alert alert-info mt-1");
		}else{
			$data=[
				"folders"=>$this->folderModel->getFolderByEmail($_SESSION['user']['email']),
			];
			$this->view("formateur/addVideo", $data);
		}
	}

	public function deleteVideo()
	{
		if (isset($_POST['id_video'])) {
			// delete video in pcloud and our dataBase
			$videoDataToDelete=$this->videoModel->getVideo($_SESSION['id_formation'], $_POST['id_video']);
			$res=$this->videoModel->deteleVideo($_SESSION['id_formation'], $_POST['id_video']);
			if($res){
				$this->pcloudFile()->delete(intval($videoDataToDelete["url_video"]));
				echo 'Le Video a ete supprimer avec success !!!';
				flash('deteleVideo', 'Le Video a ete supprimer avec success !!!');
			}else{
				echo 'Une erreur ce produit lors de la suppression !!!';
				flash('deteleVideo', 'Une erreur ce produit lors de la suppression !!!');
			}
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
		// check if this formateur has this formation.
		$hasFormation = $this->formationModel->getFormation($id_formation, $_SESSION['user_id']);
		if (!empty($hasFormation)) {
			$data = $this->videoModel->getVideosOfFormation($id_formation);
			if (!empty($data)) {
				$data[0]->date_creation_formation = $this->formatDate($data[0]->date_creation_formation);
				// to access to that formation in deleteVideo method
				// I unset this variable when i go back to the dashboard 
				$_SESSION['id_formation'] = $data[0]->id_formation;
				$data[0]->masse_horaire = $this->videoModel->countMassHorraire($data[0]->id_formation);
				foreach ($data as $key => $value) {
					$data[$key]->url_video = $this->pcloudFile()->getLink($data[$key]->url_video);
				}
				$this->view('formateur/videos', $data);
			} else
				flash("formationVide", "Votre cours ne contient aucune vidéo, ajoutez des vidéos", "alert alert-info");
				redirect("formations/addVideo/".$id_formation);
		} else {
			flash("formationNotExists", "Cette formation n`existe pas", "alert alert-info");
			redirect("formateur/index");
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

    public function setOrdreVideos()
    {
    	if($_SERVER['REQUEST_METHOD'] == 'POST'){
    		if(isset($_POST['videosWithOrder'])){
    			// Don't Forget Validation Back-end Order
    			$this->videoModel->setOrderVideos(json_decode($_POST['videosWithOrder']));
    			flash("orderApplied", "L'order a ete appliquer avec succes !!!");
    			echo "DONE !!!";
    		}
    	}
    }
}
