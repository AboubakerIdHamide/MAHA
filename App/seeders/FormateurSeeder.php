<?php

namespace App\Seeders;

use App\Models\Formateur;

class FormateurSeeder extends Seed
{

	private function definition()
	{
		$data = [
			'nom' => $this->faker->lastName(),
			'prenom' => $this->faker->firstName(),
			'email' => $this->faker->safeEmail(),
			'password' => password_hash('DIMAbarca123@@@', PASSWORD_DEFAULT),
			'code_formateur' => strtoupper(bin2hex(random_bytes(20))),
			'img' => $this->getRandomImage(200, 200, 'users/avatars', 'formateur'),
			'verified' => date('Y-m-d H:i:s'),
			'id_categorie' => $this->faker->numberBetween(1, 10),
		];

		$formateur = new Formateur;
		$formateur->create($data);
		return $formateur->whereEmail($data['email'])->id_formateur;
	}

	public function seed($records = 1)
	{
		$formateurs = [];

		for ($i = $records; $i > 0; $i--) {
			array_push($formateurs, $this->definition());

			if ($i % 5 === 0) {
				sleep(1);
			}
		}

		return $formateurs;
	}
}
