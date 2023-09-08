<?php

namespace App\Seeders;

use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use Intervention\Image\ImageManagerStatic as Image;

use App\Models\Video;
use App\Models\Preview;

class VideoSeeder extends Seed
{
	private function definition($formation)
	{
		$video = $this->getRandomVideo();
		$data = [
			'id_formation' => $formation,
			'nom' => $this->faker->sentence(3),
			'url' => $video,
			'duration' => $this->faker->numberBetween(60 * 3, 60 * 10),
			'thumbnail' => $this->getThumbnail('videos/' . $video),
			'description' => $this->faker->paragraph(),
		];

		$video = new Video;
		return $video->create($data);
	}

	public function seed($formations, $records = 5)
	{
		$videos = [];

		foreach ($formations as $formation => $formateur) {
			for ($i = $records; $i > 0; $i--) {
				array_push($videos, $this->definition($formation));

				if ($i === $records) {
					$this->insertPreviewVideo(end($videos), $formation);
				}

				if ($i % 5 === 0) {
					sleep(1);
				}
			}
		}

		return $videos;
	}

	private function insertPreviewVideo($video, $formation)
	{
		$preview = new Preview;
		$preview->insertPreviewVideo($video, $formation);
	}

	private function getThumbnail($video)
	{
		$ffmpeg = FFMpeg::create([
			'ffmpeg.binaries'  => 'c:\ffmpeg\bin\ffmpeg.exe',
			'ffprobe.binaries' => 'c:\ffmpeg\bin\ffprobe.exe'
		]);

		$video = $ffmpeg->open($video);

		$thumbnailPath = 'videos/' . generateUniqueName(uniqid()) . '.jpg';
		$frame = $video->frame(TimeCode::fromSeconds(5))->save('images/' . $thumbnailPath);

		$img = Image::make('images/' . $thumbnailPath);

		// resize image instance
		$img->resize(500, 500, function ($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		});

		imagejpeg($img->getCore(), 'images/' . $thumbnailPath, 50);
		return $thumbnailPath;
	}
}
