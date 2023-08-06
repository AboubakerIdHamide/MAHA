<?php

use App\Models\Stocked;
use App\Models\Preview;
use App\Models\Formation;
use App\Models\Video;
use App\Models\Inscription;
use App\Libraries\Request;
use App\Libraries\Response;

class coursesController
{
    private $stockedModel;
    private $previewsModel;
    private $formationModel;
    private $videoModel;
    private $inscriptionModel;

    public function __construct()
    {
        $this->stockedModel = new Stocked;
        $this->previewsModel = new Preview;
        $this->formationModel = new Formation;
        $this->videoModel = new Video;
        $this->inscriptionModel = new Inscription;
    }

    public function search()
    {
        $data = [
            'niveaux' => $this->formationModel->groupByNiveau(),
            'langues' => $this->formationModel->groupByLangue(),
            'categories' => $this->formationModel->groupByCategorie(),
            'durations' => $this->formationModel->groupByDuration(),
        ];

        return view("courses/index", $data);
    }

    public function index($slug = null)
    {
        $formation = $this->formationModel->whereSlug($slug);
        if(!$formation){
            redirect('courses/search');
            exit;
        }

        $videos = $this->videoModel->getVideosOfFormationPublic($formation->id_formation);
        $formation->inscriptions = $this->inscriptionModel->countApprenantsOfFormation($formation->id_formateur, $formation->id_formation);

        $data = [
            'formation' => $formation,
            'videos' => $videos,
            'totalVideos' => count($videos),
            'previewVideo' => $this->previewsModel->getPreviewVideo($formation->id_formation),
        ];

        return view("courses/show", $data);   
    }
}
