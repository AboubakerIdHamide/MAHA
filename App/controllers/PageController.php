<?php

use App\Models\Stocked;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\Etudiant;
use App\Models\Formateur;

class PageController
{
	private $formationModel;
	private $inscriptionModel;
	private $formateurModel;
	private $etudiantModel;
	private $stockedModel;

	public function __construct()
	{
		$this->formationModel = new Formation;
		$this->inscriptionModel = new Inscription;
		$this->formateurModel = new Formateur;
		$this->etudiantModel = new Etudiant;
		$this->stockedModel = new Stocked;
	}

	public function index()
	{
		$formations = $this->formationModel->getPopularCourses();
		$categories = $this->stockedModel->getAllCategories();
		$totalEtudiants = $this->etudiantModel->count();
		$totalFormations = $this->formationModel->countFormations();
		$totalFormateurs = $this->formateurModel->count();
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
