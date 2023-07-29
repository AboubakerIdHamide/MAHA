<?php

use App\Models\Stocked;
use App\Models\Preview;
use App\Models\Formation;
use App\Models\Video;
use App\Models\Inscription;

class PageFormationController
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
    public function index()
    {
        $langues = $this->stockedModel->getAllLangues();
        $niveaux = $this->stockedModel->getAllLevels();
        $categories = $this->stockedModel->getAllCategories();
        $totalFormations = $this->formationModel->count();
        $themeData = $this->stockedModel->getThemeData();

        $dataPages = $this->pagenition($totalFormations);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        $formations = $this->formationModel->getPublic($offset);
	
        if ($formations) {
            foreach ($formations as $formation) {
                $formation->inscriptions = $this->inscriptionModel->countApprenantsOfFormation($formation->id_formateur, $formation->id_formation);
                $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
                $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
            }
        } else {
            $formations = "Aucun Formations";
        }

        $theme["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $theme["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;
        $data = [
            'niveaux' => $niveaux,
            'langues' => $langues,
            'categories' => $categories,
            'totalFormations' => $totalFormations,
            'formations' => $formations,
            'pageno' => $pageno,
            'totalPages' => $totalPages,
            'theme' => $theme,
        ];
	
        return view("pages/pageFormations", $data);
    }

    public function coursDetails($id_formation = null)
    {
        if (is_null($id_formation)) {
            redirect('pageFormation');
            exit;
        }

        $formation = $this->formationModel->find($id_formation);
        $videos = $this->videoModel->getVideosOfFormationPublic($id_formation);
        $numVideos = $this->videoModel->countVideosOfFormation($id_formation);
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

    public function recherche()
    {
        $langues = $this->stockedModel->getAllLangues();
        $niveaux = $this->stockedModel->getAllLevels();
        $categories = $this->stockedModel->getAllCategories();
        $themeData = $this->stockedModel->getThemeData();
        $theme["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $theme["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;
        
        if(!isset($_GET['q'])){
             $data = [
                'niveaux' => $niveaux,
                'langues' => $langues,
                'categories' => $categories,
                'numbFormations' => 0,
                'formations' => 'Aucun Formations',
                'theme' => $theme
            ];

            return view("pages/pageFormations", $data);
        }

        $valRecherche = strip_tags($_GET['q']);

        $numbFormations = $this->formationModel->countFormationsSearched($valRecherche);

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
            $formations = $this->formationModel->getFormationsSearched($valRecherche, $offset);
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

    public function filter($categorie = '', $q = '')
    {
        $langues = $this->stockedModel->getAllLangues();
        $niveaux = $this->stockedModel->getAllLevels();
        $categories = $this->stockedModel->getAllCategories();

        $numbFormations = $this->formationModel->countFormationsFilter($categorie, $q);

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
            $formations = $this->formationModel->getFormationsByFilter($cat, $choi, $offset);
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

    public function plusFormationsAmais()
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
            $formations = $this->formationModel->mostLiked($offset);
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

    public function plusFormationsAcheter()
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

            $formations = $this->formationModel->mostBought($offset);
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

    public function formationsByLangue($id_langue = 1)
    {
        $langues = $this->stockedModel->getAllLangues();
        $niveaux = $this->stockedModel->getAllLevels();
        $categories = $this->stockedModel->getAllCategories();
        $numbFormations = $this->formationModel->countByLangue($id_langue);

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
            $formations = $this->formationModel->getByLangue($id_langue, $offset);
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

    public function formationsByNiveau($id_niveau = '')
    {
        $langues = $this->stockedModel->getAllLangues();
        $niveaux = $this->stockedModel->getAllLevels();
        $categories = $this->stockedModel->getAllCategories();
        $numbFormations = $this->formationModel->countByNiveau($id_niveau);

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
            $formations = $this->formationModel->getByNiveau($id_niveau, $offset);
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

    public function formationsByDuree()
    {
        $minH = 0;
        $maxH = 0;
        $errs = false;

        $minH = $_REQUEST['minH'];
        $maxH = $_REQUEST['maxH'];

        if ($minH !== 0 || $maxH !== 0) {
            // ================  Valide Valeur de Recherche  ================
            $minH = str_split($minH);
            $maxH = str_split($maxH);

            $newMinH = [];
            $newMaxH = [];

            foreach ($minH as $car) {
                if (preg_match('/[0-9]/', $car) == 1) {
                    array_push($newMinH, $car);
                }
            }
            foreach ($maxH as $car) {
                if (preg_match('/[0-9]/', $car) == 1) {
                    array_push($newMaxH, $car);
                }
            }
            $minH = implode($newMinH);
            $maxH = implode($newMaxH);
            // ================  Valide Valeur de Recherche  ================
            if (strlen($minH) > 3 || strlen($maxH) > 3) {
                $errs = true;
            }
        }

        $langues = $this->stockedModel->getAllLangues();
        $niveaux = $this->stockedModel->getAllLevels();
        $categories = $this->stockedModel->getAllCategories();
        $numbFormations = $this->formationModel->countByDuration($minH, $maxH);

        $themeData = $this->stockedModel->getThemeData();
        $theme["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $theme["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $dataPages = $this->pagenition($numbFormations);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($errs == false) {

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
                $formations = $this->formationModel->getByDuration($minH, $maxH, $offset);
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
        } else {
            $data = [
                'niveaux' => $niveaux,
                'langues' => $langues,
                'categories' => $categories,
                'numbFormations' => 0,
                'formations' => 'Aucun Formations',
                'theme' => $theme
            ];

            return view("pages/pageFormations", $data);
        }
    }

    public function pagenition($num)
    {

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }

        $no_of_records_per_page = 10;
        $offset = ($pageno - 1) * $no_of_records_per_page;

        $total_pages = ceil($num / $no_of_records_per_page);


        $data = [
            'pageno' => $pageno,
            'offset' => $offset,
            'total_pages' => $total_pages
        ];
        return $data;
    }
}
