<?php

namespace App\Seeders;

use App\Models\Inscription;
use App\Models\Formation;

class InscriptionSeeder extends Seed {

	private function definition($etudiant, $formation, $formateur)
	{
        $data = [
		    'id_formation' => $formation, 
		    'id_etudiant' => $etudiant, 
		    'id_formateur' => $formateur, 
		    'date_inscription' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
		    'prix' => $this->faker->randomFloat(2, 10, 100), 
		    'transaction_info' => json_encode(['info' => 'paypal info']),
		    'payment_id' => $this->faker->uuid,
		    'payment_state' => $this->faker->randomElement(['approved', 'created']), 
		    'approval_url' => $this->faker->url,
		];

		$inscription = new Inscription;
		return $inscription->create($data);
	}

	private function setLike($id_formation, $id_etudiant)
	{
		$formation = new Formation;
		$formation->setLike($id_etudiant, $id_formation);
	}

	public function seed($etudiants, $formations)
	{
		$inscriptions = [];

		foreach ($etudiants as $etudiant) {
			foreach ($formations as $formation => $formateur) {
				array_push($inscriptions, $this->definition($etudiant, $formation, $formateur));

				if(rand(1, 10) < 6){
					$this->setLike($formation, $etudiant);
				}

				if(rand(1, 10) < 6){
					break;
				}
			}
		}
		
		return $inscriptions;
	}
}