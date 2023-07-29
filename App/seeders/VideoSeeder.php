<?php

namespace App\Seeders;

use App\Models\Video;

class VideoSeeder extends Seed {

	private function definition($id_formation)
	{
		$data = [];
        $data['Idformation'] = $id_formation;
	    $data['nomVideo'] = $this->faker->sentence(3);
	    $data['url'] = $this->getRandomVideo();
	    $data['duree'] = $this->faker->numberBetween(60 * 3, 60 * 10);
	    $data['desc'] = $this->faker->paragraph;

		$video = new Video;
		return $video->create($data);
	}

	public function seed($records = 1, $id_formation = null)
	{
		for($i = $records; $i > 0 ;$i--){
			$this->definition($id_formation);
		}

		return [];
	}
	
}