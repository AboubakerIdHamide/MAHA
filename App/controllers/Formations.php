<?php

class Formations extends Controller {
	public function __construct(){
		if(!isset($_SESSION['user_id'])){
			redirect('users/login');
			return;
		}

		$this->formationModel = $this->model("Formation");
		$this->stockedModel = $this->model("Stocked");
	}

	private function validFormation($data)
	{
		$id_formation = $data['id_formation'];
		if(empty($this->formationModel->getFormation($id_formation, $_SESSION['user_id']))){
			return 'This Course is not yours !!!';
		}
		// echo "error 1";
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

		// echo "error 2";
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
			if(!preg_match_all('/^[1-9]+(\.[0-9])?$/', $prix))
				return 'incorrect number !!!';
		}
		else
			return 'Veuillez remplir le champ prix !!!';

		// echo "error 3";
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
				$success = 'Modification a ete passer avec success !!!';
				redirect('privatePages/formateur/index');
			}

			echo $error;
		}	
	}
}