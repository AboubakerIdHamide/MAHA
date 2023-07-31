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
        // Theme
        $themeData = $this->stockedModel->getThemeData();
        // Remembre: (Move to view)
        $theme["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $theme["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $data = [
            'niveaux' => $this->formationModel->groupByNiveau(),
            'langues' => $this->formationModel->groupByLangue(),
            'categories' => $this->formationModel->groupByCategorie(),
            'durations' => $this->formationModel->groupByDuration(),
            'theme' => $theme
        ];

        return view("pages/pageFormations", $data);
    }

    public function index($slug = null)
    {
        $formation = $this->formationModel->whereSlug($slug);
        if(!$formation){
            redirect('courses/search');
            exit;
        }

        
        $videos = $this->videoModel->getVideosOfFormationPublic($formation->id_formation);
        $numVideos = $this->videoModel->countVideosOfFormation($formation->id_formation);
        $formation->inscriptions = $this->inscriptionModel->countApprenantsOfFormation($formation->id_formateur, $formation->id_formation);
        $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
        $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
        $previewVideo = $this->previewsModel->getPreviewVideo($formation->id_formation);
        $previewVideo = $previewVideo ? URLROOT . "/Public/" . $previewVideo->url : null;

        $themeData = $this->stockedModel->getThemeData();
        $theme["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $theme["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $data = [
            'formation' => $formation,
            'videos' => $videos,
            'numbVIdeo' => $numVideos,
            'previewVideo' => $previewVideo,
            'theme' => $theme
        ];
        return view("pages/cours-details", $data);   
    }

    public function getPopularCourses()
    {
        $langues = $this->stockedModel->getAllLangues();
        $niveaux = $this->stockedModel->getAllLevels();
        $categories = $this->stockedModel->getAllCategories();
        $numbFormations = $this->formationModel->count();

        $themeData = $this->stockedModel->getThemeData();
        $theme["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $theme["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $dataPages = $this->pagenition($numbFormations);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations == 0) {
            $data = [
                'niveaux' => $niveaux,
                'langues' => $langues,
                'categories' => $categories,
                'numbFormations' => 0,
                'formations' => 'Aucun Formations',
                'theme' => $theme
            ];

            return view("pages/pageFormations", $data);
        } else {
            $formations = $this->formationModel->getPopularCourses($offset);
            foreach ($formations as $formation) {
                $formation->inscriptions = $this->inscriptionModel->countApprenantsOfFormation($formation->id_formateur, $formation->id_formation);
                $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
                $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
            }
            $data = [
                'niveaux' => $niveaux,
                'langues' => $langues,
                'categories' => $categories,
                'numbFormations' => $numbFormations,
                'formations' => $formations,
                'pageno' => $pageno,
                'totalPages' => $totalPages,
                'theme' => $theme
            ];
            return view("pages/pageFormations", $data);
        }
    }
}
