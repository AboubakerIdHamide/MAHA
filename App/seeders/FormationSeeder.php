<?php

namespace App\Seeders;

use App\Models\Formation;

class FormationSeeder extends Seed {

	private function definition($formateur)
	{
		$data = [
			'nom' => str_replace('.', '', $this->faker->sentence(5)),
			'image' => $this->getRandomImage(600, 400, 'formations', 'formation'),
			'masse_horaire' => $this->faker->time('H:i:s'),
			'prix' => $this->faker->randomFloat(2, 10, 1000),
			'description' => $this->faker->paragraph(9),
			'etat' => $this->faker->randomElement(['public', 'private']),
			'id_langue' => $this->faker->numberBetween(1, 18),
			'id_formateur' => $formateur,
			'id_niveau' => $this->faker->numberBetween(1, 3),
			'id_categorie' => $this->faker->numberBetween(1, 10),
		];

		$formation = new Formation;
		return $formation->create($data);
	}

	public function seed($formateurs, $records = null)
	{
		$formations = [];

		$records = is_null($records) ? $this->faker->numberBetween(1, 8) : $records;

		foreach ($formateurs as $formateur) {
			for($i = $records; $i > 0 ;$i--){
				$formations[$this->definition($formateur)] = $formateur;

				if($i % 5 === 0) {
					sleep(1);
				}
			}
		}

		return $formations;
	}
}