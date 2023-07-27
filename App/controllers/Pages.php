<?php

class Pages extends Controller
{
	private $stockedModel;
	private $formationModel;
	private $inscriptionModel;
	private $categorieModel;
	private $formateurModel;
	private $etudiantModel;

	public function __construct()
	{
		$this->categorieModel = $this->model("Stocked");
		$this->formationModel = $this->model("Formation");
		$this->inscriptionModel = $this->model("Inscription");
		$this->etudiantModel = $this->model("Etudiant");
		$this->formateurModel = $this->model("Formateur");
		$this->stockedModel = $this->model("Stocked");
	}
	public function index()
	{
		$formations = $this->formationModel->getPopularCourses();
		$categories = $this->categorieModel->getAllCategories();
		$totalEtudiants = $this->etudiantModel->countEtudiant();
		$totalFormations = $this->formationModel->countFormations();
		$totalFormateurs = $this->formateurModel->countFormateurs();
		$themeData = $this->stockedModel->getThemeData();

		foreach ($formations as $formation) {
			$formation->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($formation->id_formateur, $formation->id_formation);
			$formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
			$formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
		}
		$theme["logo"] = URLROOT . "/Public/" . $themeData->logo;
		$theme["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;
		$data = [
			'formations' => $formations,
			'categories' => $categories,
			'totalEtudiants' => $totalEtudiants,
			'totalFormations' => $totalFormations,
			'totalFormateurs' => $totalFormateurs,
			'theme' => $theme
		];

		return view("pages/index", $data);
	}
}
