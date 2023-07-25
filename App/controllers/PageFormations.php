<?php

class PageFormations extends Controller
{
    private $stockedModel;
    private $previewsModel;
    private $formationModel;
    private $videoModel;
    private $inscriptionModel;
    private $categorieModel;

    public function __construct()
    {
        $this->formationModel = $this->model("Formation");
        $this->inscriptionModel = $this->model("Inscription");
        $this->stockedModel = $this->model("Stocked");
        $this->videoModel = $this->model("Video");
        $this->previewsModel = $this->model("Previews");
        $this->categorieModel = $this->model("Stocked");
    }
    public function index()
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();
        $totalFormations = $this->formationModel->countAllFormations();
        $themeData = $this->stockedModel->getThemeData();

        $dataPages = $this->pagenition($totalFormations);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        $this->formationModel->insertIntoTableFilter($type = 'all', $totalFormations, $arg1 = '', $arg2 = '');

        $formations = $this->formationModel->getPopularFormations($offset);
	
        if ($formations) {
            foreach ($formations as $formation) {
                $formation->inscriptions = $this->inscriptionModel->countApprenantsOfFormation($formation->IdFormteur, $formation->IdFormation);
                $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
                $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
            }
        } else {
            $formation = "Aucun Formations";
        }

        $themeData["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;
        $data = [
            'nivaux' => $nivaux,
            'langages' => $langages,
            'categories' => $categories,
            'totalFormations' => $totalFormations,
            'formation' => $formation,
            'pageno' => $pageno,
            'totalPages' => $totalPages,
            'theme' => $themeData,
        ];
	
        $this->view("pages/pageFormations", $data);
    }

    public function coursDetails($id = null)
    {
        if (is_null($id)) {
            redirect('pageFormations');
            exit;
        }

        $formation = $this->formationModel->getFormationById($id);
        $videos = $this->videoModel->getInfoVideosFormationById($id);
        $numVideos = $this->videoModel->countVideosFormationById($id);
        $formation->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($formation->id_formateur, $formation->id_formation);
        $formation->niveau = $this->stockedModel->getLevelById($formation->niveau)->nom;
        $formation->langue = $this->stockedModel->getLangueById($formation->langue)->nom;
        $formation->categorie = $this->stockedModel->getCategorieById($formation->categorie)->nom;
        $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
        $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
        $previewVideo = $this->previewsModel->getPreviewVideo($formation->id_formation);
        $previewVideo = $previewVideo ? URLROOT . "/Public/" . $previewVideo->url : null;

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $data = [
            'formation' => $formation,
            'videos' => $videos,
            'numbVIdeo' => $numVideos,
            'previewVideo' => $previewVideo,
            'theme' => $themeData
        ];
        $this->view("pages/cours-details", $data);
    }

    public function rechercheFormations($valRech = '')
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();
        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $errs = false;
        // ================  Valide Valeur de Recherche  ================
        $arrVal = str_split($valRech);
        $newArrVal = [];
        foreach ($arrVal as $car) {
            if (preg_match('/[a-zA-Z]/', $car) == 1) {
                array_push($newArrVal, $car);
            }
        }
        $valRecherche = implode($newArrVal);
        // ================  Valide Valeur de Recherche  ================
        if (strlen($valRecherche) > 200 || strlen($valRecherche) < 1) {
            $errs = true;
        }
        if ($errs == false) {
            $numbFormations = $this->formationModel->countFormationsRech($valRecherche);

            $dataPages = $this->pagenition($numbFormations);

            $pageno = $dataPages['pageno'];
            $offset = $dataPages['offset'];
            $totalPages = $dataPages['total_pages'];

            if ($numbFormations == 0) {
                $this->formationModel->deleteFromTableFilter();
                $data = [
                    'nivaux' => $nivaux,
                    'langages' => $langages,
                    'categories' => $categories,
                    'numbFormations' => 0,
                    'info' => 'Aucun Formations',
                    'theme' => $themeData
                ];

                $this->view("pages/pageFormations", $data);
            } else {
                $this->formationModel->insertIntoTableFilter($type = 'rech', $numbFormations['numbFormations'], $valRecherche, $arg2 = '');
                $formations = $this->formationModel->getFormationsByValRech($valRecherche, $offset);
                foreach ($formations as $row) {
                    $row->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($row->IdFormteur, $row->IdFormation)['total_apprenants'];
                    $row->imgFormateur = URLROOT . "/Public/" . $row->imgFormateur;
                    $row->imgFormation = URLROOT . "/Public/" . $row->imgFormation;
                }
                $data = [
                    'nivaux' => $nivaux,
                    'langages' => $langages,
                    'categories' => $categories,
                    'numbFormations' => $numbFormations['numbFormations'],
                    'info' => $formations,
                    'pageno' => $pageno,
                    'totalPages' => $totalPages,
                    'theme' => $themeData
                ];

                $this->view("pages/pageFormations", $data);
            }
        } else {
            $this->formationModel->deleteFromTableFilter();

            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => 0,
                'info' => 'Aucun Formations',
                'theme' => $themeData
            ];

            $this->view("pages/pageFormations", $data);
        }
    }

    public function filter($cat = '', $choi = '')
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();

        $numbFormations = $this->formationModel->countFormationsFilter($cat, $choi);

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $dataPages = $this->pagenition($numbFormations);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations == 0) {
            $this->formationModel->deleteFromTableFilter();

            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => 0,
                'info' => 'Aucun Formations',
                'theme' => $themeData
            ];

            $this->view("pages/pageFormations", $data);
        } else {
            $this->formationModel->insertIntoTableFilter($type = 'filter', $numbFormations, $cat, $choi);

            $formations = $this->formationModel->getFormationsByFilter($cat, $choi, $offset);
            foreach ($formations as $formation) {
                $formation->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($formation->IdFormteur, $formation->IdFormation);
                $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
                $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => $numbFormations,
                'formations' => $formations,
                'pageno' => $pageno,
                'totalPages' => $totalPages,
                'theme' => $themeData
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function getPopularCourses()
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();
        $numbFormations = $this->formationModel->countAllFormations();

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $dataPages = $this->pagenition($numbFormations);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations == 0) {
            $this->formationModel->deleteFromTableFilter();

            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => 0,
                'info' => 'Aucun Formations',
                'theme' => $themeData
            ];

            $this->view("pages/pageFormations", $data);
        } else {
            $this->formationModel->insertIntoTableFilter($type = 'all', $numbFormations, $arg1 = '', $arg2 = '');
            $formations = $this->formationModel->getPopularFormations($offset);
            foreach ($formations as $formation) {
                $formation->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($formation->IdFormteur, $formation->IdFormation);
                $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
                $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => $numbFormations,
                'formations' => $formations,
                'pageno' => $pageno,
                'totalPages' => $totalPages,
                'theme' => $themeData
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function plusFormationsAmais()
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();
        $numbFormations = $this->formationModel->countAllFormations();

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $dataPages = $this->pagenition($numbFormations);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations == 0) {
            $this->formationModel->deleteFromTableFilter();

            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => 0,
                'info' => 'Aucun Formations',
                'theme' => $themeData
            ];

            $this->view("pages/pageFormations", $data);
        } else {
            $this->formationModel->insertIntoTableFilter($type = 'all', $numbFormations, $arg1 = '', $arg2 = '');

            $formations = $this->formationModel->getPlusFormationsAmais($offset);
            foreach ($formations as $formation) {
                $formation->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($formation->IdFormteur, $formation->IdFormation);
                $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
                $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => $numbFormations,
                'formations' => $formations,
                'pageno' => $pageno,
                'totalPages' => $totalPages,
                'theme' => $themeData
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function plusFormationsAcheter()
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();
        $numbFormations = $this->formationModel->countAllFormations();

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $dataPages = $this->pagenition($numbFormations);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations == 0) {
            $this->formationModel->deleteFromTableFilter();

            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => 0,
                'info' => 'Aucun Formations',
                'theme' => $themeData
            ];

            $this->view("pages/pageFormations", $data);
        } else {
            $this->formationModel->insertIntoTableFilter($type = 'all', $numbFormations, $arg1 = '', $arg2 = '');

            $formations = $this->formationModel->getPlusFormationsAcheter($offset);
            foreach ($formations as $formation) {
                $formation->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($formation->IdFormteur, $formation->IdFormation);
                $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
                $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => $numbFormations,
                'formations' => $formations,
                'pageno' => $pageno,
                'totalPages' => $totalPages,
                'theme' => $themeData
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function formationsByLanguage($id_langue = 1)
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();
        $numbFormations = $this->formationModel->countFormationsByLangage($id_langue);

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $dataPages = $this->pagenition($numbFormations);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations == 0) {
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => 0,
                'info' => 'Aucun Formations',
                'theme' => $themeData
            ];

            $this->view("pages/pageFormations", $data);
        } else {
            $formations = $this->formationModel->getFormationsByLanguage($id_langue, $offset);
            foreach ($formations as $formation) {
                $formation->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($formation->IdFormteur, $formation->IdFormation);
                $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
                $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => $numbFormations,
                'formations' => $formations,
                'pageno' => $pageno,
                'totalPages' => $totalPages,
                'theme' => $themeData
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function formationsByNiveau($id_niveau = '')
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();
        $numbFormations = $this->formationModel->countFormationsByNiveau($id_niveau);

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $dataPages = $this->pagenition($numbFormations);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations == 0) {
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => 0,
                'info' => 'Aucun Formations',
                'theme' => $themeData
            ];

            $this->view("pages/pageFormations", $data);
        } else {
            $formations = $this->formationModel->getFormationsByNiveau($id_niveau, $offset);
            foreach ($formations as $formation) {
                $formation->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($formation->IdFormteur, $formation->IdFormation);
                $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
                $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => $numbFormations,
                'formations' => $formations,
                'pageno' => $pageno,
                'totalPages' => $totalPages,
                'theme' => $themeData
            ];
            $this->view("pages/pageFormations", $data);
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

        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();
        $numbFormations = $this->formationModel->countFormationsByDuree($minH, $maxH);

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;

        $dataPages = $this->pagenition($numbFormations);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($errs == false) {

            if ($numbFormations == 0) {
                $data = [
                    'nivaux' => $nivaux,
                    'langages' => $langages,
                    'categories' => $categories,
                    'numbFormations' => 0,
                    'info' => 'Aucun Formations',
                    'theme' => $themeData
                ];

                $this->view("pages/pageFormations", $data);
            } else {
                $formations = $this->formationModel->getFormationsByDuree($minH, $maxH, $offset);
                foreach ($formations as $formation) {
                    $formation->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($formation->IdFormteur, $formation->IdFormation);
                    $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
                    $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
                }
                $data = [
                    'nivaux' => $nivaux,
                    'langages' => $langages,
                    'categories' => $categories,
                    'numbFormations' => $numbFormations,
                    'formations' => $formations,
                    'pageno' => $pageno,
                    'totalPages' => $totalPages,
                    'theme' => $themeData
                ];
                $this->view("pages/pageFormations", $data);
            }
        } else {
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => 0,
                'info' => 'Aucun Formations',
                'theme' => $themeData
            ];

            $this->view("pages/pageFormations", $data);
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
