<?php

namespace App\Seeders;

use App\Models\Inscription;

class InscriptionSeeder extends Seed {

	private function definition($id_formation, $id_etudiant, $id_formateur)
	{
        $data = [
		    'id_formation' => $id_formation, 
		    'id_etudiant' => $id_etudiant, 
		    'id_formateur' => $id_formateur, 
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

	public function seed($records = 1, $id_formation, $etudiants, $id_formateur)
	{

		foreach ($etudiants as $id_etudiant) {
			$this->definition($id_formation, $id_etudiant, $id_formateur);	
		}

		return [];
	}
}