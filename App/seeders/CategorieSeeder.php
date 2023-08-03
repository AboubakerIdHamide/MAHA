<?php

namespace App\Seeders;

use App\Models\Stocked;

class CategorieSeeder extends Seed {

	private function definition()
	{
       $data = [
		    'nom_categorie' => $this->faker->jobTitle(),
		    'image' => $this->getRandomImage(800, 533, 'categories'),
		];

		$categorie = new Stocked;
		$categorie->insertCategorie($data);
	}

	public function seed($records = 1)
	{
		for($i = $records; $i > 0 ;$i--){
			$this->definition();
		}

		return [];
	}
}