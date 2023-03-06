<?php

class Pages extends Controller
{
	public function __construct()
	{
		$this->categorieModel = $this->model("Stocked");
		$this->formationModel = $this->model("Formation");
		$this->inscriptionModel = $this->model("Inscription");
		$this->etudiantModel = $this->model("Etudiant");
		$this->formateurModel = $this->model("Formateur"); 
	}
	public function index()
	{
		$courses = $this->formationModel->getPopularCourses();
		$categories = $this->categorieModel->getAllCategories();
		$totalEtudiants = $this->etudiantModel->countEtudiant();
		$totalFormations = $this->formationModel->countFormations();
		$totalFormateurs = $this->formateurModel->countFormateurs();

		foreach ($courses as $course) {
			$course->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($course->IdFormteur, $course->IdFormation)['total_apprenants'];
			$course->imgFormation = URLROOT."/Public/".$course->imgFormation;
			$course->imgFormateur = URLROOT."/Public/".$course->imgFormateur;
		}

		$data = [
			'courses' => $courses,
			'categories' => $categories,
			'totalEtudiants' => $totalEtudiants,
			'totalFormations' => $totalFormations,
			'totalFormateurs' => $totalFormateurs
		];

		$this->view("pages/index", $data);
	}
}
