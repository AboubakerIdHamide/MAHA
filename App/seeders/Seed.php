<?php

namespace App\Seeders;

class Seed {

	protected $faker;
	protected $formateurs = [];
	protected $formations = [];
	protected $videos = [];
	protected $etudiants;
	protected $parent;

	public function __construct() {
        $this->faker = \Faker\Factory::create();
    }

	protected function getRandomImage($width, $height, $prefix = 'image')
	{
		// URL of the image you want to download.
		$imageUrl = "https://dummyimage.com/{$width}x{$height}/ffc107/000/fff.png";

		// Generate a unique filename for the downloaded image.
		$localFilename = "images/formations/images/{$prefix}_". uniqid() . '.png';

		file_put_contents($localFilename, file_get_contents($imageUrl));

		return $localFilename;
	}

	protected function getRandomVideo($prefix = 'video')
	{
		// URL of the video you want to download.
		$videoUrl = "https://vod-progressive.akamaized.net/exp=1690577030~acl=%2Fvimeo-prod-skyfire-std-us%2F01%2F4800%2F15%2F399003581%2F1701022046.mp4~hmac=71a654c7c178f9d33c48593f2b94b1d308ef417bc50be5218cd2d64e10e00a34/vimeo-prod-skyfire-std-us/01/4800/15/399003581/1701022046.mp4?download=1&filename=production_id%3A3969453+%28720p%29.mp4";

		// Generate a unique filename for the downloaded video.
		$localFilename = "images/formations/videos/{$prefix}_". uniqid() . '.mp4';

		file_put_contents($localFilename, file_get_contents($videoUrl));

		return $localFilename;
	}

	public function first($seeder, $records = 1){
		$this->setParentName($seeder);
		$this->{$this->parent} = $seeder->seed($records);

		return $this;
	}

	private function setParentName($seeder){
		$name = strtolower(str_replace('Seeder', '', str_replace('App\Seeders\\', '', get_class($seeder)))) . 's';
		$this->parent = $name;
	}

	private function getSeederName($seeder){
		return strtolower(str_replace('Seeder', '', str_replace('App\Seeders\\', '', get_class($seeder)))) . 's';
	}

	public function with($seeder, $records = 1, $isInscription = false)
	{
		if($isInscription){
			$seeder->seed($records, $this->formations[0], $this->etudiants, $this->formateurs[0]);

			return $this;
		}

		$helper = [];
		foreach ($this->{$this->parent} as $id) {
			array_push($helper, $seeder->seed($records, $id));
		}
		
		$this->setParentName($seeder);

		$this->{$this->parent} = array_reduce($helper, 'array_merge', []);

		return $this;
	}
}