<?php

use App\Models\Formateur;
use App\Models\Etudiant;
use App\Models\Formation;
use App\Models\Video;
use App\Models\Inscription;
use App\Models\Admin;
use App\Models\requestPayment;
use App\Models\Stocked;
use App\Models\Smtp;

class AdminController
{
    private $fomateurModel;
    private $etudiantModel;
    private $formationModel;
    private $videoModel;
    private $inscriptionModel;
    private $adminModel;
    private $requestPaymentModel;
    private $stockedModel;
    private $smtpModel;

    public function __construct()
    {
        $this->fomateurModel = new Formateur;
        $this->etudiantModel = new Etudiant;
        $this->formationModel = new Formation;
        $this->videoModel = new Video;
        $this->inscriptionModel = new Inscription;
        $this->adminModel = new Admin;
        $this->requestPaymentModel = new requestPayment;
        $this->stockedModel = new Stocked;
        $this->smtpModel = new Smtp;
    }

    private function checkSession()
    {
        if (!$this->isLoggedIn()) {
            redirect('admin/login');
            return;
        }
    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        if ($this->isLoggedIn()) {
            redirect('admin/dashboard');
            exit;
        }

        // Checking If The User Submit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST["rememberMe"]) && $_POST["rememberMe"] == "on") {
                setcookie("useremail", $_POST["email"], time() + 2592000);
                setcookie("userpw", $_POST["password"], time() + 2592000);
            } else {
                setcookie("useremail", $_POST["email"], time() + 10);
                setcookie("userpw", $_POST["password"], time() + 10);
            }

            $data = [
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'email_err' => '',
                'password_err' => '',
            ];

            // Validate Data
            if (filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                if (!preg_match_all("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $data["email"])) {
                    $data["email_err"] = "L'e-mail inséré est invalide";
                }
            } else {
                $data["email_err"] = "L'e-mail inséré est invalide";
            }


            // Shecking If That User Exists
            $admin = $this->adminModel->getAdminByEmail($data["email"]);
            if (!empty($admin)) {
                if ($data["password"] == $admin->mot_de_passe) {
                    $this->createAdminSession($admin);
                } else {
                    $data["password_err"] = "Mot de passe incorrect";
                }
            } else {
                $data["email_err"] = "Aucun utilisateur avec cet email";
            }
            if (empty($admin) || !empty($data["password_err"]) || !empty($data["email_err"])) {
                return view("pages/loginAdmin", $data);
            }
        } else {
            $data = [
                'email' => "",
                'password' => "",
                'email_err' => "",
                'password_err' => "",
            ];
            if (isset($_COOKIE["useremail"]) && isset($_COOKIE["userpw"])) {
                $data["email"] = $_COOKIE["useremail"];
                $data["password"] = $_COOKIE["userpw"];
            }

            return view("pages/loginAdmin", $data);
        }
    }

    private function isLoggedIn()
    {
        if (isset($_SESSION['admin_id']))
            return true;
        return false;
    }

    private function createAdminSession($admin)
    {
        $_SESSION['admin_id'] = $admin->id_admin;
        $_SESSION['admin'] = $admin;
        $admin->img = URLROOT . "/Public/" . $admin->img;
        redirect('admin/dashboard');
    }

    public function logout()
    {
        session_destroy();
        redirect('admin/login');
    }

    public function dashboard()
    {
        $this->checkSession();

        $data = [];
        $data['countFormations'] = $this->formationModel->countFormations();
        $data['countFormateurs'] = $this->fomateurModel->count();
        $data['countEtudiant'] = $this->etudiantModel->count();
        $data['balance'] = $this->adminModel->getAdminByEmail($_SESSION['admin']->email)->balance;
        return view('admin/index', $data);
    }

    public function getAllRequestsPayments($etat)
    {
        $this->checkSession();

        $arrayStates = array(["pending", "accepted", "declined"]);
        if (!in_array($etat, $arrayStates)) {
            $requestsPayment = $this->requestPaymentModel->getRequestsPaymentsByState($etat);
            echo json_encode($requestsPayment);
        }
    }

    public function setState()
    {
        $this->checkSession();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requestPaymentModel->setState($_POST['etat_request'], $_POST['id_payment']);
            echo json_encode('Demande de paiement modifiée !!!');
        }
    }

    public function formateurs()
    {
        $this->checkSession();

        if (isset($_GET['q'])) {
            $data['formateurs'] = $this->fomateurModel->whereNomOrPrenom($_GET['q']);
        } else {
            $data['formateurs'] = $this->fomateurModel->whereNomOrPrenom();
        }

        $data['specialite'] = $this->stockedModel->getAllCategories();
        // get link of image formateur
        foreach ($data['formateurs'] as $formateur) {
            $formateur->img = URLROOT . "/Public/" . $formateur->img;
        }
        return view("admin/formateurs", $data);
    }

    public function removeFormateur($id_formateur)
    {
        $this->checkSession();

        $this->fomateurModel->delete($id_formateur);
        echo json_encode("Formateur supprimé avec succès !!!");
    }

    public function editFormateur()
    {
        $this->checkSession();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // don't forget validate data
            $data = (array) json_decode($_POST['formateur']);
            $this->fomateurModel->edit($data);
            echo json_encode("Formateur modifié avec succès !!!");
        }
    }

    public function etudiants()
    {
        $this->checkSession();

        if (isset($_GET['q'])) {
            $data = $this->etudiantModel->whereNomOrPrenom($_GET['q']);
        } else {
            $data = $this->etudiantModel->whereNomOrPrenom();
        }
        // get link of image etudiant
        foreach ($data as $etudiant) {
            $etudiant->img = URLROOT . "/Public/" . $etudiant->img;
            $etudiant->total_inscription = $this->inscriptionModel->countTotalInscriById($etudiant->id_etudiant);
        }
        return view("admin/etudiants", $data);
    }

    public function removeEtudiant($id_etudiant)
    {
        $this->checkSession();

        $this->etudiantModel->delete($id_etudiant);
        echo json_encode("Etudiant supprimé avec succès !!!");
    }

    public function editEtudiant()
    {
        $this->checkSession();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // don't forget validate data
            $data = (array) json_decode($_POST['etudiant']);
            $this->etudiantModel->edit($data);
            echo json_encode("Etudiant modifiè avec succès !!!");
        }
    }

    public function formations()
    {
        $this->checkSession();

        if (isset($_GET['critere']) && isset($_GET['q'])) {
            $criteres = ['nom_formation', 'nom_formateur'];
            $critere = $_GET['critere'];
            if (in_array($critere, $criteres)) {
                $q = $_GET['q'];
                if ($critere == 'nom_formation') {
                    $data['formations'] = $this->formationModel->getFormationByNomFormation($q);
                } else {
                    $data['formations'] = $this->formationModel->getFormationByNomFormateur($q);
                }
            } else {
                $data['formations'] = $this->formationModel->getAllFormations();
            }
        } else {
            $data['formations'] = $this->formationModel->getAllFormations();
        }
        // get link of image formateur
        foreach ($data['formations'] as $formation) {
            $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
            $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
        }

        $data['categories'] = $this->stockedModel->getAllCategories();
        $data['langues'] = $this->stockedModel->getAllLangues();
        $data['niveaux'] = $this->stockedModel->getAllLevels();

        return view("admin/formations", $data);
    }

    public function removeFormation($idFormation)
    {
        $this->checkSession();

        $this->formationModel->deleteFormation($idFormation);
        echo json_encode("Formation supprimé avec succès !!!");
    }

    public function editFormation()
    {
        $this->checkSession();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // don't forget validate data
            $data = (array) json_decode($_POST['formation']);
            $this->formationModel->updateFormation($data);
            echo json_encode("Formation modifiè avec succès !!!");
        }
    }

    public function videos($id_formation)
    {
        $this->checkSession();
        // test method post
        $data = $this->videoModel->getVideosOfFormation($id_formation);
        if (!empty($data)) {
            foreach ($data as $video) {
                $video->url = URLROOT . "/Public/" . $video->url;
            }
            echo json_encode($data);
        } else {
            echo json_encode("Cette formation n'a pas de vidéos !!!");
        }
    }

    public function removeVideo($id_video)
    {
        $this->checkSession();

        $this->videoModel->deteleVideoId($id_video);
        echo json_encode("Video supprimé avec succès !!!");
    }

    private function validVideo($data)
    {
        // title
        if (isset($data['titre'])) {
            $titre = $data['titre'];
            $countTitre = strlen($titre);
            if ($countTitre > 0) {
                if ($countTitre < 5)
                    return '5 caractères au minimum !!!';
                else
					if ($countTitre > 50)
                    return '5 caractères au maximum !!!';
            } else
                return 'Veuillez remplir le champ titre !!!';
        }

        // Description
        if (isset($data['description'])) {
            $description = $data['description'];
            $countDesc = strlen($description);

            if ($countDesc > 0) {
                if ($countDesc < 6)
                    return '6 caractères au minimum !!!';
                else
						if ($countDesc > 600)
                    return '600 caractères au maximum !!!';
            } else
                return 'Veuillez remplir le champ description !!!';
        }

        return false;
    }

    public function editVideo()
    {
        $this->checkSession();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $error = $this->validVideo($_POST);
            if ($error === false) {
                // update Video
                $data = $_POST;
                $this->videoModel->updateVideoId($data);
                echo json_encode('modification affectée avec succès !!!');
            }
        }
    }

    public function getFormationsOfStudent($id_etudiant)
    {
        $this->checkSession();

        $data = $this->inscriptionModel->getFormationsOfStudent($id_etudiant);
        foreach ($data as $inscription) {
            $inscription->imgFormateur = URLROOT . "/Public/" . $inscription->imgFormateur;
        }
        echo json_encode($data);
    }

    public function removeInscription($id_inscription)
    {
        $this->checkSession();

        $this->inscriptionModel->deteleInscription($id_inscription);
        echo json_encode("Inscription supprimé avec succès !!!");
    }

    public function ajaxData($periode = null)
    {
        $this->checkSession();
        switch ($periode) {
            case 'today':
                $inscriptions = $this->inscriptionModel->top5BestSellersTodayOrYesterday($periode);
                break;
            case 'yesterday':
                $inscriptions = $this->inscriptionModel->top5BestSellersTodayOrYesterday($periode);
                break;
            case 'week':
                $inscriptions = $this->inscriptionModel->top5BestSellersLastWeek();
                break;
            case 'month':
                $inscriptions = $this->inscriptionModel->top5BestSellersLastMonth();
                break;
            case '3months':
                $inscriptions = $this->inscriptionModel->top5BestSellersLast3Months();
                break;
            case 'year':
                $inscriptions = $this->inscriptionModel->top5BestSellersLastYear();
                break;
            default:
                if (isset($_GET['debut'], $_GET['fin']) && !empty($_GET['debut']) && !empty($_GET['fin'])) {
                    extract($_GET);
                    $inscriptions = $this->inscriptionModel->top5BestSellersBetween2Days($debut, $fin);
                } else {
                    exit;
                }

                break;
        }

        echo json_encode($inscriptions);
    }

    public function getAllFormateurs()
    {
        $this->checkSession();
        $formateurs = $this->fomateurModel->whereNomOrPrenom();
        echo json_encode($formateurs);
    }

    public function requestPayment()
    {
        $this->checkSession();
        return view('admin/requestPayment');
    }

    public function getTop10BestSellers()
    {
        $this->checkSession();
        $formateurs = $this->inscriptionModel->top10BestSellers();
        echo json_encode($formateurs);
    }

    public function categories($id = null)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['categories'] = $this->stockedModel->getAllCategories();
            return view('admin/categories', $data);
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->stockedModel->insertCategorie($_POST);
                echo json_encode('Categorie ' . $_POST['nom_categorie'] . ' ajouté avec succès !');
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                    $this->stockedModel->deleteCategorie(file_get_contents("php://input"));
                    echo json_encode('Categorie supprimé avec succès !');
                } else {
                    $this->stockedModel->editCategorie(json_decode(file_get_contents("php://input")));
                    echo json_encode('Categorie  modifiè avec succès !');
                }
            }
        }
    }

    public function langues($langueID = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['langues'] = $this->stockedModel->getAllLangues();

            return view('admin/langues', $data);
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->stockedModel->insertLangue($_POST['nom_langue']);
                echo json_encode('Langue ' . $_POST['nom_langue'] . ' ajouté avec succès !');
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                    if (!is_null($langueID)) {
                        $this->stockedModel->deleteLangue($langueID);
                        echo json_encode('Langue supprimé avec succès !');
                    }
                }
            }
        }
    }

    public function changeTheme()
    {
        $theme = $this->stockedModel->getThemeData();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $logo = $this->uploadImage($_FILES["logo"]);
            $landingImg = $this->uploadImage($_FILES["landingImg"]);
        
            if (empty($logo)) {
                $logo = $theme->logo;
            }

            if (empty($landingImg)) {
                $landingImg = $theme->landingImg;
            }

            $this->stockedModel->setThemeData([
                "logo" => $logo,
                "landingImg" => $landingImg
            ]);

            redirect("admin/changeTheme");
        } else {
            $data["logo"] = URLROOT . "/Public/" . $theme->logo;
            $data["landingImg"] = URLROOT . "/Public/" . $theme->landingImg;
            return view('admin/theme', $data);
        }
    }

    public function smtp()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->smtpModel->replaceSmtp($_POST);
            echo json_encode("SMTP modifié avec succès !");
        } else {
            $smtp['data'] = $this->smtpModel->getSmtp();
            return view('admin/smtp', $smtp);
        }
    }

    private  function uploadImage($file)
    {
        $fileName = $file["name"]; // name
        $fileTmpName = $file["tmp_name"]; // location
        $fileError = $file["error"]; // error

        if (!empty($fileTmpName)) {
            $fileExt = explode(".", $fileName);
            $fileRealExt = strtolower(end($fileExt));
            $allowed = array("jpg", "jpeg", "png");


            if (in_array($fileRealExt, $allowed)) {
                if ($fileError === 0) {
                    $fileNameNew = substr(number_format(time() * rand(), 0, '', ''), 0, 5) . "." . $fileRealExt;
                    $fileDestination = 'images/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    return $fileDestination;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return  false;
        }
    }

    public function settings()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->adminModel->replaceSettings($_POST);
            echo json_encode("Paramètre modifié avec succès !");
        } else {
            $settings['data'] = $this->adminModel->getProfitAndPaypalToken();
            return view('admin/settings', $settings);
        }
    }
}
