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
		    'tel' => $this->faker->regexify('^06[0-9]{8}$'),
		    'mdp' => password_hash('DIMAbarca123@@@', PASSWORD_DEFAULT),
		    'img' => $this->getRandomImage(200, 200),
		];

		$etudiant = new Etudiant;
		$etudiant->insertEtudiant($data);
		return $etudiant->getEtudiantByEmail($data['email'])->id_etudiant;
	}

	public function seed($records = 1, $id)
	{
		$etudiants = [];

		for($i = $records; $i > 0 ;$i--){
			array_push($etudiants, $this->definition());
		}

		return $etudiants;
	}
}