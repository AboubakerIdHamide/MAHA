<?php

class Pages extends Controller
{
	public function __construct()
	{
		$this->categorieModel = $this->model("Stocked");
		$this->formationModel = $this->model("Formation");
		$this->inscriptionModel = $this->model("Inscription");
	}
	public function index()
	{
		$courses = $this->formationModel->getPopularCourses();
		$categories = $this->categorieModel->getAllCategories();

		foreach ($courses as $course) {
			$course->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($course->IdFormteur, $course->IdFormation)['total_apprenants'];
			$course->imgFormation = URLROOT."/Public/".$course->imgFormation;
			$course->imgFormateur = URLROOT."/Public/".$course->imgFormateur;
		}

		$data = [
			'courses' => $courses,
			'categories' => $categories
		];
		$this->view("pages/index", $data);
	}
}
