<?php

class Admin extends Controller
{
    public function __construct()
    {
        // if (!isset($_SESSION['admin_id'])) {
        //     redirect('admin/login');
        //     return;
        // }

        $this->fomateurModel = $this->model("Formateur");
        $this->etudiantModel = $this->model("Etudiant");
        $this->formationModel = $this->model("Formation");
        $this->inscriptionModel = $this->model("Inscription");
        $this->adminModel = $this->model("Administrateur");
        $this->requestPaymentModel = $this->model("requestPayment");
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
                if ($data["password"] == $admin["mot_de_passe"]) {
                    $this->createAdminSession($admin);
                } else {
                    $data["password_err"] = "Mot de passe incorrect";
                }
            } else {
                $data["email_err"] = "Aucun utilisateur avec cet email";
            }
            if (empty($admin) || !empty($data["password_err"]) || !empty($data["email_err"])) {
                $this->view("pages/login", $data);
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

    public function isLoggedIn()
    {
        if (isset($_SESSION['admin_id']))
            return true;
        return false;
    }

    public function createAdminSession($admin)
    {
        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['admin'] = $admin;
        redirect('admin/dashboard');
    }


    public function logout()
    {
        session_destroy();
        redirect('admin/login');
    }

    public function dashboard()
    {
        $data = [];
        $data['countFormations'] = $this->formationModel->countFormations();
        $data['countFormateurs'] = $this->fomateurModel->countFormateurs();
        $data['countEtudiant'] = $this->etudiantModel->countEtudiant();
        $this->view('admin/index', $data);
    }

    public function getAllRequestsPayments($filter)
    {
        $arrayFilter = array(["pending", "accepted", "declined"]);
        if (!in_array($filter, $arrayFilter)) {
            $requestsPayment = $this->requestPaymentModel->getRequestsPaymentsByState($filter);
            // get link of image formateur
            // foreach ($data as $key => $request) {
            //     $request->img_formateur = $this->pcloudFile()->getLink($request->img_formateur);
            // }
            echo json_encode($requestsPayment);
        }
    }

    public function setState()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->requestPaymentModel->setState($_POST['etat_request'], $_POST['id_payment']);
            echo 'request payment changed !!!';
        }
    }
}
