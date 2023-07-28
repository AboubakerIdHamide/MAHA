<?php

namespace App\Seeders;

use App\Models\Formation;

class FormationSeeder extends Seed {

	private function definition($id_formateur)
	{
        $data = [];
		$data['nom_formation'] = $this->faker->sentence(4);
		$data['img_formation'] = $this->getRandomImage('600', '400');
		$data['masse_horaire'] = $this->faker->time('H:i:s');
		$data['prix_formation'] = $this->faker->randomFloat(2, 10, 1000);
		$data['description'] = $this->faker->paragraph(3);
		$data['etat_formation'] = $this->faker->randomElement(['public', 'private']);
		$data['id_langue'] = $this->faker->numberBetween(1, 4);
		$data['niveau_formation'] = $this->faker->numberBetween(1, 3);
		$data['id_formateur'] = $id_formateur;
		$data['categorie'] = $this->faker->numberBetween(1, 12);

		$formation = new Formation;
		return $formation->insertFormation($data);
	}

	public function seed($records = 1, $id_formateur = null)
	{
		$formations = [];

		for($i = $records; $i > 0 ;$i--){
			array_push($formations, $this->definition($id_formateur));
		}

		return $formations;
	}
}