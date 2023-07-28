<?php

use App\Seeders\FormationSeeder;
use App\Seeders\FormateurSeeder;

class FakerController {

	public function index()
	{
		$formation = new FormationSeeder;
		$formateur = new FormateurSeeder;

		$formateur->seed(2)->with($formation, 3);
		$formateur->seed(4)->with($formation, 2);
	}
}