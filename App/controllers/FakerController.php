<?php

use App\Seeders\Seed;
use App\Seeders\CategorieSeeder;
use App\Seeders\EtudiantSeeder;
use App\Seeders\FormateurSeeder;
use App\Seeders\FormationSeeder;
use App\Seeders\InscriptionSeeder;
use App\Seeders\VideoSeeder;

class FakerController {

	public function __construct(){
		$numberRecords = 10;
		
		// Create Categories
		$categorie = new CategorieSeeder;
		$categorieIDs = $categorie->seed($numberRecords);

		// Create Etudiants
		$etudiant = new EtudiantSeeder;
		$etudiantIDs = $etudiant->seed($numberRecords);

		// Create Formateurs
		$formateur = new FormateurSeeder;
		$formateurIDs = $formateur->seed($numberRecords);

		// Create Formations
		// custom formateur IDs.
		// $formateurIDs = ['FOR1', 'FOR2', 'FOR3', 'FOR4', 'FOR5', 'FOR6', 'FOR7', 'FOR8', 'FOR9'];
		$formation = new FormationSeeder;
		$formationIDs = $formation->seed($formateurIDs);

		// Create Inscription
		// Exemple: 
		// 		$formateurIDs = ['FOR1', 'FOR2', 'FOR3', ...];
		// 		$etudiantIDs = ['ETU1', 'ETU2', 'ETU3', ...];
		// 		$formationIDs = ['idFormation1' => 'idFormateur1', 'idFormation2' => 'idFormateur2', ...];

		$inscription = new InscriptionSeeder;
		$inscriptionIDs = $inscription->seed($etudiantIDs, $formationIDs);

		// Create Video
		$video = new VideoSeeder;
		$videoIDs = $video->seed($formationIDs);

		print_r2('<h1 style="text-align: center">DATA GENERATED SUCCESSFULLY!</h1>');
	}
}
