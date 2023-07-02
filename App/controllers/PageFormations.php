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
        $numbFormations = $this->formationModel->countAllFormations();
        $themeData = $this->stockedModel->getThemeData();

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        $this->formationModel->insertIntoTableFilter($type = 'all', $numbFormations['numbFormations'], $arg1 = '', $arg2 = '');

        $info = $this->formationModel->getPlusPopilairesFormations($offset);
	
        if ($info) {
            foreach ($info as $row) {
                $row->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($row->IdFormteur, $row->IdFormation)['total_apprenants'];
                $row->imgFormateur = URLROOT . "/Public/" . $row->imgFormateur;
                $row->imgFormation = URLROOT . "/Public/" . $row->imgFormation;
            }
        } else {
            $info = "Aucun Formations";
        }

        $themeData["logo"] = URLROOT . "/Public/" . $themeData["logo"];
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData["landingImg"];
        $data = [
            'nivaux' => $nivaux,
            'langages' => $langages,
            'categories' => $categories,
            'numbFormations' => $numbFormations['numbFormations'],
            'info' => $info,
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

        $info = $this->formationModel->getFormationById($id);
        $videos = $this->videoModel->getInfoVideosFormationById($id);
        $numVideos = $this->videoModel->countVideosFormationById($id);
        $info['numbAcht'] = $this->inscriptionModel->countApprenantsOfFormation($info['IdFormteur'], $info['IdFormation'])['total_apprenants'];
        $info['niveauFormation'] = $this->stockedModel->getLevelById($info['IdNiv'])['nom_niveau'];
        $info['langageFormation'] = $this->stockedModel->getLangueById($info['IdLang'])['nom_langue'];
        $info['specialite'] = $this->stockedModel->getCategorieById($info['specialiteId'])['nom_categorie'];
        $info['imgFormateur'] = URLROOT . "/Public/" . $info['imgFormateur'];
        $info['imgFormation'] = URLROOT . "/Public/" . $info['imgFormation'];
        $previewVideo = $this->previewsModel->getPreviewVideo($info['IdFormation']);
        $previewVideo = $previewVideo ? URLROOT . "/Public/" . $previewVideo->url_video : null;

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData["logo"];
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData["landingImg"];

        $data = [
            'info' => $info,
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
        $themeData["logo"] = URLROOT . "/Public/" . $themeData["logo"];
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData["landingImg"];

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

            $dataPages = $this->pagenition($numbFormations['numbFormations']);

            $pageno = $dataPages['pageno'];
            $offset = $dataPages['offset'];
            $totalPages = $dataPages['total_pages'];

            if ($numbFormations['numbFormations'] == 0) {
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
        $themeData["logo"] = URLROOT . "/Public/" . $themeData["logo"];
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData["landingImg"];

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations['numbFormations'] == 0) {
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
            $this->formationModel->insertIntoTableFilter($type = 'filter', $numbFormations['numbFormations'], $cat, $choi);

            $info = $this->formationModel->getFormationsByFilter($cat, $choi, $offset);
            foreach ($info as $row) {
                $row->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($row->IdFormteur, $row->IdFormation)['total_apprenants'];
                $row->imgFormateur = URLROOT . "/Public/" . $row->imgFormateur;
                $row->imgFormation = URLROOT . "/Public/" . $row->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
                'pageno' => $pageno,
                'totalPages' => $totalPages,
                'theme' => $themeData
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function plusPopilairesFormations()
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();
        $numbFormations = $this->formationModel->countAllFormations();

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData["logo"];
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData["landingImg"];

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations['numbFormations'] == 0) {
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
            $this->formationModel->insertIntoTableFilter($type = 'all', $numbFormations['numbFormations'], $arg1 = '', $arg2 = '');
            $info = $this->formationModel->getPlusPopilairesFormations($offset);
            foreach ($info as $row) {
                $row->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($row->IdFormteur, $row->IdFormation)['total_apprenants'];
                $row->imgFormateur = URLROOT . "/Public/" . $row->imgFormateur;
                $row->imgFormation = URLROOT . "/Public/" . $row->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
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
        $themeData["logo"] = URLROOT . "/Public/" . $themeData["logo"];
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData["landingImg"];

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations['numbFormations'] == 0) {
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
            $this->formationModel->insertIntoTableFilter($type = 'all', $numbFormations['numbFormations'], $arg1 = '', $arg2 = '');

            $info = $this->formationModel->getPlusFormationsAmais($offset);
            foreach ($info as $row) {
                $row->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($row->IdFormteur, $row->IdFormation)['total_apprenants'];
                $row->imgFormateur = URLROOT . "/Public/" . $row->imgFormateur;
                $row->imgFormation = URLROOT . "/Public/" . $row->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
                'pageno' => $pageno,
                'totalPages' => $totalPages,
                'theme' => $themeData
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function plusFormationsAchter()
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();
        $numbFormations = $this->formationModel->countAllFormations();

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData["logo"];
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData["landingImg"];

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations['numbFormations'] == 0) {
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
            $this->formationModel->insertIntoTableFilter($type = 'all', $numbFormations['numbFormations'], $arg1 = '', $arg2 = '');

            $info = $this->formationModel->getPlusFormationsAchter($offset);
            foreach ($info as $row) {
                $row->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($row->IdFormteur, $row->IdFormation)['total_apprenants'];
                $row->imgFormateur = URLROOT . "/Public/" . $row->imgFormateur;
                $row->imgFormation = URLROOT . "/Public/" . $row->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
                'pageno' => $pageno,
                'totalPages' => $totalPages,
                'theme' => $themeData
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function formationsByLangage($lang = 2)
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();
        $numbFormations = $this->formationModel->countFormationsByLangage($lang);

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData["logo"];
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData["landingImg"];

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations['numbFormations'] == 0) {
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
            $info = $this->formationModel->getFormationsByLangage($lang, $offset);
            foreach ($info as $row) {
                $row->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($row->IdFormteur, $row->IdFormation)['total_apprenants'];
                $row->imgFormateur = URLROOT . "/Public/" . $row->imgFormateur;
                $row->imgFormation = URLROOT . "/Public/" . $row->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
                'pageno' => $pageno,
                'totalPages' => $totalPages,
                'theme' => $themeData
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function formationsByNivau($niv = '')
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $categories = $this->categorieModel->getAllCategories();
        $numbFormations = $this->formationModel->countFormationsByNiveau($niv);

        $themeData = $this->stockedModel->getThemeData();
        $themeData["logo"] = URLROOT . "/Public/" . $themeData["logo"];
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData["landingImg"];

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations['numbFormations'] == 0) {
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
            $info = $this->formationModel->getFormationsByNivau($niv, $offset);
            foreach ($info as $row) {
                $row->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($row->IdFormteur, $row->IdFormation)['total_apprenants'];
                $row->imgFormateur = URLROOT . "/Public/" . $row->imgFormateur;
                $row->imgFormation = URLROOT . "/Public/" . $row->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'categories' => $categories,
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
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
        $themeData["logo"] = URLROOT . "/Public/" . $themeData["logo"];
        $themeData["landingImg"] = URLROOT . "/Public/" . $themeData["landingImg"];

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($errs == false) {

            if ($numbFormations['numbFormations'] == 0) {
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
                $info = $this->formationModel->getFormationsByDuree($minH, $maxH, $offset);
                foreach ($info as $row) {
                    $row->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($row->IdFormteur, $row->IdFormation)['total_apprenants'];
                    $row->imgFormateur = URLROOT . "/Public/" . $row->imgFormateur;
                    $row->imgFormation = URLROOT . "/Public/" . $row->imgFormation;
                }
                $data = [
                    'nivaux' => $nivaux,
                    'langages' => $langages,
                    'categories' => $categories,
                    'numbFormations' => $numbFormations['numbFormations'],
                    'info' => $info,
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
