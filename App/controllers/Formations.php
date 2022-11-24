<?php

class Formations extends Controller {
	public function __construct(){
		if(!isset($_SESSION['user_id'])){
			redirect('users/login');
			return;
		}

		$this->formationModel = $this->model("Formation");
		$this->stockedModel = $this->model("Stocked");
		$this->videosModel = $this->model("Video");
	}

	private function validFormation($data)
	{
		$id_formation = $data['id_formation'];
		if(empty($this->formationModel->getFormation($id_formation, $_SESSION['user_id']))){
			return 'This Course is not yours !!!';
		}

		// title
		$titre = $data['titre'];
		$countTitre = strlen($titre);

		if($countTitre > 0){
			if($countTitre < 5)
				return 'Mininum caracteres 5 !!!';
			else
				if($countTitre > 25)
					return 'Maxmimun caracteres 25 !!!';
		}
		else
			return 'Veuillez remplir le champ titre !!!';

		// description
		$description = $data['description'];
		$countDesc = strlen($description);

		if($countDesc > 0){
			if($countDesc < 10)
				return 'Mininum caracteres 10 !!!';
			else
				if($countDesc > 500)
					return 'Maxmimun caracteres 500 !!!';
		}
		else
			return 'Veuillez remplir le champ description !!!';

		// prix
		$prix = $data['prix'];
		if(strlen($prix) > 0){
			if(!preg_match_all('/^(?!0\d)\d*(\.\d+)?$/m', $prix))
				return 'incorrect number !!!';
		}
		else
			return 'Veuillez remplir le champ prix !!!';

		//categorie
		$categorie = $data['categorie'];
		if(empty($this->stockedModel->getCategorieById($categorie)))
			return "this categorie doesn't exist in the DB !!!";

		// level
		$niveauFormation = $data['niveauFormation'];
		if(empty($this->stockedModel->getLevelById($niveauFormation)))
			return "this level doesn't exist in the DB !!!";

		// langue
		$langue = $data['langue'];
		if(empty($this->stockedModel->getLangueById($langue)))
			return "this language doesn't exist in the DB !!!";

		return false;
	}

	public function updateFormation()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$error = $this->validFormation($_POST);
			if($error === false){
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

	public function videos($id_formation)
	{
		// check if this formateur has this formation.
		$hasFormation = $this->formationModel->getFormation($id_formation, $_SESSION['user_id']);
		if(!empty($hasFormation)){
			$data = $this->videosModel->getVideosOfFormation($id_formation);
			$this->view('formateur/videos');
			// render view passing this data to it.
		}else{
			die('Error 404 !!!');
		}
	}
}