<?php

class Etudiant extends Controller
{
	public function __construct()
	{
		if (!isset($_SESSION['id_etudiant'])) {
			redirect('users/login');
			return;
		}
		$this->inscriptionModel = $this->model("Inscription");
		$this->stockedModel = $this->model("Stocked");
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
		// preparing data
		$data = $this->inscriptionModel->getInscriptionByEtudiant($_SESSION['id_etudiant']);
		foreach ($data as $inscr) {
			$inscr->img_formateur = $this->pcloudFile()->getLink($inscr->img_formateur);
			$inscr->image_formation = $this->pcloudFile()->getLink($inscr->image_formation);
			$inscr->categorie = $this->stockedModel->getCategorieById($inscr->categorie)["nom_categorie"];
			$inscr->apprenants = $this->inscriptionModel->countApprenantsOfFormation($inscr->id_formateur, $inscr->id_formation)["total_apprenants"];
			$inscr->liked = $this->formationModel->likedBefore($inscr->id_etudiant, $inscr->id_formation);
		}
		// loading the view
		$this->view("etudiant/index", $data);
	}

	public function coursVideos($idFormateur = "", $idFormation = "")
	{
		if (empty($idFormateur) || empty($idFormation)) {
			redirect("etudiant/index");
		}
		// preparing data
		$data = $this->inscriptionModel->getInscriptionOfOneFormation($idFormation, $_SESSION['id_etudiant'], $idFormateur);
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

	public function watchedVideos()
	{
		// Preparing Data
		$data = $this->videoModel->getWatchedVideos($_SESSION['id_etudiant']);
		foreach ($data as $video) {
			// settingUp Video Link
			$video->url_video = $this->pcloudFile()->getLink($video->url_video);
		}

		// loading the view
		$this->view("etudiant/videoCards", $data);
	}

	public function bockMarckedVideos()
	{
		// Preparing Data
		$data = $this->videoModel->getBookmarkedVideos($_SESSION['id_etudiant']);
		foreach ($data as $video) {
			// settingUp Video Link
			$video->url_video = $this->pcloudFile()->getLink($video->url_video);
		}

		// loading the view
		$this->view("etudiant/videoCards", $data);
	}
}
