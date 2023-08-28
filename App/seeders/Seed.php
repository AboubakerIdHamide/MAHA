<?php

namespace App\Seeders;

class Seed {
	protected $faker;

	public function __construct() {
        $this->faker = \Faker\Factory::create();
    }

	protected function getRandomImage($width, $height, $path, $prefix = 'image')
	{
		// URL of the image you want to download.
		$imageUrl = "https://dummyimage.com/{$width}x{$height}/ffc107/000/fff.png";

		// Generate a unique filename for the downloaded image.
		$localFilename = "images/{$path}/{$prefix}_". uniqid() . '.png';

		file_put_contents($localFilename, file_get_contents($imageUrl));

		return str_replace('images/', '', $localFilename);
	}

	protected function getRandomVideo($prefix = 'video')
	{
		// URL of the video you want to download.
		$videoUrl = "https://www.w3schools.com/html/mov_bbb.mp4";

		// Generate a unique filename for the downloaded video.
		$localFilename = "videos/{$prefix}_". uniqid() . '.mp4';

		file_put_contents($localFilename, file_get_contents($videoUrl));

		return str_replace('videos/', '', $localFilename);
	}
}