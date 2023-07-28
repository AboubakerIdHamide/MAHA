<?php

namespace App\Seeders;

use App\Models\Formateur;

class FormateurSeeder extends Seed {

	private function definition()
	{
       $data = [
		    'nom' => $this->faker->lastName,
		    'prenom' => $this->faker->firstName,
		    'email' => $this->faker->safeEmail(),
		    'tel' => $this->faker->regexify('^06[0-9]{8}$'),
		    'mdp' => password_hash('DIMAbarca123@@@', PASSWORD_DEFAULT),
		    'img' => $this->getRandomImage(200, 200),
		    'bio' => $this->faker->paragraph,
		    'pmail' => $this->faker->safeEmail(),
		    'specId' => $this->faker->numberBetween(1, 12),
		    'code_formateur' => strtoupper($this->faker->uuid()),
		];

		$formateur = new Formateur;
		$formateur->create($data);
		return $formateur->whereEmail($data['email'])->id_formateur;
	}

	public function seed($records = 1)
	{
		$formateurs = [];
		for($i = $records; $i > 0 ;$i--){
			array_push($formateurs, $this->definition());
		}

		return $formateurs;
	}
}