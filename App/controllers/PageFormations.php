<?php

class PageFormations extends Controller
{
    public function __construct()
    {
        $this->fomateurModel = $this->model("Formateur");
        $this->etudiantModel = $this->model("Etudiant");
        $this->formationModel = $this->model("Formation");
        $this->inscriptionModel = $this->model("Inscription");
        $this->stockedModel = $this->model("Stocked");
        $this->videoModel = $this->model("Video");
        $this->previewsModel = $this->model("Previews");
    }
    public function index()
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $numbFormations = $this->formationModel->countAllFormations();

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

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
            'numbFormations' => $numbFormations['numbFormations'],
            'info' => $info,
            'pageno' => $pageno,
            'totalPages' => $totalPages
        ];
        $this->view("pages/pageFormations", $data);
    }

    public function coursDetails($id = null)
    {
        if(is_null($id)) {
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
        $data = [
            'info' => $info,
            'videos' => $videos,
            'numbVIdeo' => $numVideos,
            'previewVideo' => $previewVideo
        ];
        $this->view("pages/cours-details", $data);
    }

    public function rechercheFormations($valRech = '')
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();

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
                    'numbFormations' => 0,
                    'info' => 'Aucun Formations'
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
                    'numbFormations' => $numbFormations['numbFormations'],
                    'info' => $formations,
                    'pageno' => $pageno,
                    'totalPages' => $totalPages
                ];

                $this->view("pages/pageFormations", $data);
            }
        } else {
            $this->formationModel->deleteFromTableFilter();

            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'numbFormations' => 0,
                'info' => 'Aucun Formations'
            ];

            $this->view("pages/pageFormations", $data);
        }
    }

    public function filter($cat = '', $choi = '')
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();

        $numbFormations = $this->formationModel->countFormationsFilter($cat, $choi);

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations['numbFormations'] == 0) {
            $this->formationModel->deleteFromTableFilter();

            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'numbFormations' => 0,
                'info' => 'Aucun Formations'
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
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
                'pageno' => $pageno,
                'totalPages' => $totalPages
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function plusPopilairesFormations()
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $numbFormations = $this->formationModel->countAllFormations();

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations['numbFormations'] == 0) {
            $this->formationModel->deleteFromTableFilter();

            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'numbFormations' => 0,
                'info' => 'Aucun Formations'
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
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
                'pageno' => $pageno,
                'totalPages' => $totalPages
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function plusFormationsAmais()
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $numbFormations = $this->formationModel->countAllFormations();

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations['numbFormations'] == 0) {
            $this->formationModel->deleteFromTableFilter();

            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'numbFormations' => 0,
                'info' => 'Aucun Formations'
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
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
                'pageno' => $pageno,
                'totalPages' => $totalPages
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function plusFormationsAchter()
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $numbFormations = $this->formationModel->countAllFormations();

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations['numbFormations'] == 0) {
            $this->formationModel->deleteFromTableFilter();

            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'numbFormations' => 0,
                'info' => 'Aucun Formations'
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
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
                'pageno' => $pageno,
                'totalPages' => $totalPages
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function formationsByLangage($lang = 2)
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $numbFormations = $this->formationModel->countFormationsByLangage($lang);

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations['numbFormations'] == 0) {
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'numbFormations' => 0,
                'info' => 'Aucun Formations'
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
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
                'pageno' => $pageno,
                'totalPages' => $totalPages
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function formationsByNivau($niv = '')
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $numbFormations = $this->formationModel->countFormationsByNiveau($niv);

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];

        if ($numbFormations['numbFormations'] == 0) {
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'numbFormations' => 0,
                'info' => 'Aucun Formations'
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
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
                'pageno' => $pageno,
                'totalPages' => $totalPages,
            ];
            $this->view("pages/pageFormations", $data);
        }
    }

    public function formationsByDuree($deb = '', $fin = '')
    {
        $langages = $this->stockedModel->getAllLangues();
        $nivaux = $this->stockedModel->getAllLevels();
        $numbFormations = $this->formationModel->countFormationsByDuree($deb, $fin);

        $dataPages = $this->pagenition($numbFormations['numbFormations']);

        $pageno = $dataPages['pageno'];
        $offset = $dataPages['offset'];
        $totalPages = $dataPages['total_pages'];


        if ($numbFormations['numbFormations'] == 0) {
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'numbFormations' => 0,
                'info' => 'Aucun Formations'
            ];

            $this->view("pages/pageFormations", $data);
        } else {
            $info = $this->formationModel->getFormationsByDuree($deb, $fin, $offset);
            foreach ($info as $row) {
                $row->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($row->IdFormteur, $row->IdFormation)['total_apprenants'];
                $row->imgFormateur = URLROOT . "/Public/" . $row->imgFormateur;
                $row->imgFormation = URLROOT . "/Public/" . $row->imgFormation;
            }
            $data = [
                'nivaux' => $nivaux,
                'langages' => $langages,
                'numbFormations' => $numbFormations['numbFormations'],
                'info' => $info,
                'pageno' => $pageno,
                'totalPages' => $totalPages
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
