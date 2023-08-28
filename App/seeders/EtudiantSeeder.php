<?php

namespace App\Seeders;

use App\Models\Etudiant;

class EtudiantSeeder extends Seed {

	private function definition()
	{
       $data = [
		    'nom' => $this->faker->lastName,
		    'prenom' => $this->faker->firstName,
		    'email' => $this->faker->safeEmail(),
		    'password' => password_hash('DIMAbarca123@@@', PASSWORD_DEFAULT),
		    'img' => $this->getRandomImage(200, 200, 'users', 'etudiant'),
		    'verified' => date('Y-m-d H:i:s')
		];

		$etudiant = new Etudiant;
		$etudiant->create($data);
		return $etudiant->whereEmail($data['email'])->id_etudiant;
	}

	public function seed($records = 1)
	{
		$etudiants = [];

		for($i = $records; $i > 0 ;$i--){
			array_push($etudiants, $this->definition());

			if($i % 5 === 0) {
				sleep(1);
			}
		}

		return $etudiants;
	}
}