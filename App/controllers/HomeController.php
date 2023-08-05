<?php

use App\Models\Formation;
use App\Models\Formateur;
use App\Models\Etudiant;
use App\Models\Stocked;

class HomeController
{
	private $formationModel;
	private $formateurModel;
	private $etudiantModel;
	private $stockedModel;

	public function __construct()
	{
		$this->formationModel = new Formation;
		$this->formateurModel = new Formateur;
		$this->etudiantModel = new Etudiant;
		$this->stockedModel = new Stocked;
	}

	public function index()
	{
		$data = [
			'formations' => $this->formationModel->getPopularCourses(),
			'categories' => $this->stockedModel->getPopularCategories(),
			'formateurs' => $this->formateurModel->getPopularFormateurs(),
			'totalFormations' => $this->formationModel->count(),
			'theme' => $this->stockedModel->getThemeData()
		];

		return view("home/index", $data);
	}
}
