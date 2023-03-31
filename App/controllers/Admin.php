<?php

class Admin extends Controller
{
    public function __construct()
    {
        $this->fomateurModel = $this->model("Formateur");
        $this->etudiantModel = $this->model("Etudiant");
        $this->formationModel = $this->model("Formation");
        $this->inscriptionModel = $this->model("Inscription");
        $this->adminModel = $this->model("Administrateur");
        $this->requestPaymentModel = $this->model("requestPayment");
        $this->stockedModel = $this->model("Stocked");
        $this->videoModel = $this->model("Video");
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
                $this->view("pages/loginAdmin", $data);
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

            $this->view("pages/loginAdmin", $data);
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
        $admin->img_admin = URLROOT . "/Public/" . $admin->img_admin;
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
        $data['countFormateurs'] = $this->fomateurModel->countFormateurs();
        $data['countEtudiant'] = $this->etudiantModel->countEtudiant();
        $data['balance'] = $this->adminModel->getAdminByEmail($_SESSION['admin']->email_admin)->balance;
        $this->view('admin/index', $data);
    }

    public function getAllRequestsPayments($filter)
    {
        $this->checkSession();

        $arrayFilter = array(["pending", "accepted", "declined"]);
        if (!in_array($filter, $arrayFilter)) {
            $requestsPayment = $this->requestPaymentModel->getRequestsPaymentsByState($filter);
            echo json_encode($requestsPayment);
        }
    }

    public function setState()
    {
        $this->checkSession();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->requestPaymentModel->setState($_POST['etat_request'], $_POST['id_payment']);
            echo 'request payment changed !!!';
        }
    }

    public function formateurs()
    {
        $this->checkSession();

        if (isset($_GET['q'])) {
            $data['formateurs'] = $this->fomateurModel->getAllFormateur($_GET['q']);
        } else {
            $data['formateurs'] = $this->fomateurModel->getAllFormateur();
        }

        $data['specialite'] = $this->stockedModel->getAllCategories();
        // get link of image formateur
        foreach ($data['formateurs'] as $formateur) {
            $formateur->img_formateur = URLROOT . "/Public/" . $formateur->img_formateur;
        }
        $this->view("admin/formateurs", $data);
    }

    public function removeFormateur($id_formateur)
    {
        $this->checkSession();

        $this->fomateurModel->deteleFormateur($id_formateur);
        echo "Le Formateur Supprimer Avec Success !!!";
    }

    public function editFormateur()
    {
        $this->checkSession();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // don't forget validate data
            $data = (array) json_decode($_POST['formateur']);
            $this->fomateurModel->editFormateur($data);
            echo "Le Formateur a été Modifier Avec Success !!!";
        }
    }

    public function etudiants()
    {
        $this->checkSession();

        if (isset($_GET['q'])) {
            $data = $this->etudiantModel->getAllEtudiant($_GET['q']);
        } else {
            $data = $this->etudiantModel->getAllEtudiant();
        }
        // get link of image etudiant
        foreach ($data as $etudiant) {
            $etudiant->img_etudiant = URLROOT . "/Public/" . $etudiant->img_etudiant;
            $etudiant->total_inscription = $this->etudiantModel->countTotalInscriById($etudiant->id_etudiant);
        }
        $this->view("admin/etudiants", $data);
    }

    public function removeEtudiant($id_etudiant)
    {
        $this->checkSession();

        $this->etudiantModel->deteleEtudiant($id_etudiant);
        echo "L'etudiant a été supprimer avec success !!!";
    }

    public function editEtudiant()
    {
        $this->checkSession();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // don't forget validate data
            $data = (array) json_decode($_POST['etudiant']);
            $this->etudiantModel->editEtudiant($data);
            echo "L'etudiant a été modifier avec success !!!";
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
            $formation->img_formateur = URLROOT . "/Public/" . $formation->img_formateur;
            $formation->image_formation = URLROOT . "/Public/" . $formation->image_formation;
        }

        $data['categories'] = $this->stockedModel->getAllCategories();
        $data['langues'] = $this->stockedModel->getAllLangues();
        $data['levels'] = $this->stockedModel->getAllLevels();

        $this->view("admin/formations", $data);
    }

    public function removeFormation($idFormation)
    {
        $this->checkSession();

        $this->formationModel->deleteFormation($idFormation);
        echo "La Formation Supprimer Avec Success !!!";
    }

    public function editFormation()
    {
        $this->checkSession();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // don't forget validate data
            $data = (array) json_decode($_POST['formation']);
            $this->formationModel->updateFormation($data);
            echo "La Formation Modifier Avec Success !!!";
        }
    }

    public function videos($id_formation)
    {
        $this->checkSession();
        // test method post
        $data = $this->videoModel->getVideosOfFormation($id_formation);
        if (!empty($data)) {
            foreach ($data as $video) {
                $video->url_video = URLROOT . "/Public/" . $video->url_video;
            }
            echo json_encode($data);
        } else {
            echo json_encode("This Formation doesn't have any videos !!!");
        }
    }

    public function removeVideo($id_video)
    {
        $this->checkSession();

        $this->videoModel->deteleVideoId($id_video);
        echo "La Video Supprimer Avec Success !!!";
    }

    private function validVideo($data)
    {
        // title
        if (isset($data['titre'])) {
            $titre = $data['titre'];
            $countTitre = strlen($titre);
            if ($countTitre > 0) {
                if ($countTitre < 5)
                    return 'Mininum caracteres 5 !!!';
                else
					if ($countTitre > 50)
                    return 'Maxmimun caracteres 50 !!!';
            } else
                return 'Veuillez remplir le champ titre !!!';
        }

        // Description
        if (isset($data['description'])) {
            $description = $data['description'];
            $countDesc = strlen($description);

            if ($countDesc > 0) {
                if ($countDesc < 6)
                    return 'Mininum caracteres 6 !!!';
                else
						if ($countDesc > 600)
                    return 'Maxmimun caracteres 600 !!!';
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
                echo 'La Modification a ete faites avec success !!!';
            }
        }
    }

    public function getFormationsOfStudent($id_etudiant)
    {
        $this->checkSession();

        $data = $this->inscriptionModel->getFormationsOfStudent($id_etudiant);
        foreach ($data as $inscription) {
            $inscription->img_formateur = URLROOT . "/Public/" . $inscription->img_formateur;
        }
        echo json_encode($data);
    }

    public function removeInscription($id_inscription)
    {
        $this->checkSession();

        $this->inscriptionModel->deteleInscription($id_inscription);
        echo "L'inscription a été supprimer avec success !!!";
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
                if(isset($_GET['debut'], $_GET['fin']) && !empty($_GET['debut']) && !empty($_GET['fin'])){
                    extract($_GET);
                    $inscriptions = $this->inscriptionModel->top5BestSellersBetween2Days($debut, $fin);
                }else{
                    exit;
                }
                
                break;
        }
        
        echo json_encode($inscriptions);
    }

    public function getAllFormateurs()
    {
        $this->checkSession();
        $f = $this->fomateurModel->getAllFormateur();
        echo json_encode($f);
    }

    public function requestPayment()
    {
        $this->checkSession();
        return $this->view('admin/requestPayment');
    }

    public function getTop10BestSellers()
    {
        $this->checkSession();
        $formateurs = $this->inscriptionModel->top10BestSellers();
        echo json_encode($formateurs);
    }

    public function categories($id = null)
    {
        if (is_null($id)) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $data['categories'] = $this->stockedModel->getAllCategories();
                $this->view('admin/categories', $data);
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['sous_categorie'])) {
                        $this->stockedModel->insertSousCategorie($_POST);
                        echo 'La Sous-categorie ' . $_POST['sous_categorie'] . ' a été ajouter avec success.';
                    } else {
                        $this->stockedModel->insertCategorie($_POST);
                        echo 'La Categorie ' . $_POST['nom_categorie'] . ' a été ajouter avec success.';
                    }
                } else {
                    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                        $this->stockedModel->deleteCategorie(file_get_contents("php://input"));
                        echo 'La Categorie a été supprimer avec success.';
                    } else {
                        $this->stockedModel->editCategorie(json_decode(file_get_contents("php://input")));
                        echo 'La Categorie a été modifier avec success.';
                    }
                }
            }
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $sous_categories = $this->stockedModel->getAllSousCategoriesOfCategorie($id);
                echo json_encode($sous_categories);
            } else {
                $this->stockedModel->deleteSousCategorie($id);
                echo 'La Sous-Categorie a été supprimer avec success.';
            }
        }
    }

    public function langues($langueID = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['langues'] = $this->stockedModel->getAllLangues();

            $this->view('admin/langues', $data);
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->stockedModel->insertLangue($_POST['nom_langue']);
                echo 'La Langue ' . $_POST['nom_langue'] . ' a été ajouter avec success.';
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                    if (!is_null($langueID)) {
                        $this->stockedModel->deleteLangue($langueID);
                        echo 'La Langue a été supprimer avec success.';
                    }
                }
            }
        }
    }

    public function changeTheme(){
        $data=$this->stockedModel->getThemeData();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $logo=$this->uploadImage($_FILES["logo"]);
            $landingImg=$this->uploadImage($_FILES["landingImg"]);
            
            if($logo==false){
                $logo=$data["logo"];
            }

            if($landingImg==false){
                $landingImg=$data["landingImg"];
            }

            $this->stockedModel->setThemeData([
                "logo"=>$logo,
                "landingImg"=>$landingImg
            ]);

            redirect("admin/");
        }else{
            $data["logo"]=URLROOT."/Public/".$data["logo"];
            $data["landingImg"]=URLROOT."/Public/".$data["landingImg"];
            $this->view('admin/theme', $data);
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
}
