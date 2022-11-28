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
		$this->stockedModel = $this->model("Stocked");
		$this->videosModel = $this->model("Video");
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
			$data = $this->videosModel->getVideosOfFormation($id_formation);
			if (!empty($data)) {
				$data[0]->date_creation_formation = $this->formatDate($data[0]->date_creation_formation);
				$this->view('formateur/videos', $data);
			} else
				die("This Formation doesn't have any videos !!!");
		} else {
			die('Error 404 !!!');
		}
	}

	public function deleteVideo()
	{
		if (isset($_POST['id_video'])) {
			$this->videosModel->deteleVideo($_SESSION['id_formation'], $_POST['id_video']);
			flash('deteleVideo', 'La Formation a ete supprimer avec success !!!');
			echo 'La Formation a ete supprimer avec success !!!';
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
				$this->videosModel->updateVideo($data);
				flash('updateVideo', 'La Modification a ete faites avec success !!!');
				echo 'La Modification a ete faites avec success !!!';
			}
		}
	}
}
