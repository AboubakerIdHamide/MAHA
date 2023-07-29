<?php

use App\Models\Formateur;
use App\Models\Etudiant;
use App\Models\Formation;
use App\Models\Video;
use App\Models\Inscription;
use App\Models\Commentaire;

class AjaxController
{
    private $fomateurModel;
    private $etudiantModel;
    private $formationModel;
    private $videoModel;
    private $inscriptionModel;
    private $commentaireModel;

    public function __construct()
    {
        $this->fomateurModel = new Formateur;
        $this->etudiantModel = new Etudiant;
        $this->formationModel = new Formation;
        $this->videoModel = new Video;
        $this->inscriptionModel = new Inscription;
        $this->commentaireModel = new Commentaire;    
    }

    public function checkEmail()
    {
        $data = [
            "thereIsError" => false,
            "error" => "",
        ];

        if (isset($_POST["email"])) {
            if (!empty($this->etudiantModel->whereEmail($_POST["email"]))) {
                $data["thereIsError"] = true;
                $data["error"] = "Adresse e-mail déjà utilisée";
            }
            if (!empty($this->fomateurModel->whereEmail($_POST["email"]))) {
                $data["thereIsError"] = true;
                $data["error"] = "Adresse e-mail déjà utilisée";
            }
        }

        echo json_encode($data);
    }

    public function checkPaypalEmail()
    {
        $data = [
            "thereIsError" => false,
            "error" => "",
        ];

        if (isset($_POST["pmail"])) {
            if (!empty($this->fomateurModel->wherePaypal($_POST["pmail"]))) {
                $data["thereIsError"] = true;
                $data["error"] = "Adresse e-mail de Paypal déjà utilisée";
            }
        }

        echo json_encode($data);
    }

    public function getMyFormations($nomFormation = '')
    {
        $formations = $this->formationModel->getFormationsOfFormateur($_SESSION['id_formateur'], $nomFormation);

        // don't forget to add Zipfile (Ressourses)
        foreach ($formations as $formation) {
            $formation->apprenants = $this->inscriptionModel->countApprenantsOfFormation($_SESSION['id_formateur'], $formation->id_formation);
        }

        echo json_encode($formations);
    }

    public function deleteFormation()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['formations'])) {
                foreach ($_POST['formations'] as $id_formation) {
                    $videos = $this->videoModel->getVideosOfFormation($id_formation);
                    $this->formationModel->delete($id_formation);
                    if (!empty($videos)) {
                        foreach ($videos as $video) {
                            $this->videoModel->delete($video->id_video);
                            unlink($video->url);
                        }
                    }
                }
                echo json_encode('Formation supprimé avec succès !!!');
            }
        }
    }

    public function likeToformation()
    {
        $id_etudiant = $_POST["idEtudiant"];
        $id_formation = $_POST["idFormation"];
        $res = $this->formationModel->setLike($id_etudiant, $id_formation);
        $jaimes = $this->formationModel->getLikes($id_formation);
        $data = ["success" => $res, "jaimes" => $jaimes];
        echo json_encode($data);
    }

    public function watchVideo()
    {
        $etudiantId = $_POST["idEtudiant"];
        $videoId = $_POST["idVideo"];
        $automatic = $_POST["automatic"];
        $res = false;
        if (filter_var($automatic, FILTER_VALIDATE_BOOLEAN)) {
            $watched = $this->videoModel->watchedBefore($etudiantId, $videoId);
            if (!$watched) {
                $res = $this->videoModel->setWatch($etudiantId, $videoId);
            }
        } else {
            $res = $this->videoModel->setWatch($etudiantId, $videoId);
        }
        $data = ["success" => $res];
        echo json_encode($data);
    }

    public function markVideo()
    {
        $etudiantId = $_POST["idEtudiant"];
        $videoId = $_POST["idVideo"];
        $res = $this->videoModel->setBookmark($etudiantId, $videoId);
        $data = ["success" => $res];
        echo json_encode($data);
    }

    public function addComment()
    {
        $data = [
            "idVideo" => $_POST["videoId"],
            "commentaire" => $_POST["comment"],
            "type_user" => $_SESSION['user']->type,
            "from_user" => $_POST["from_user"],
            "to_user" => $_POST["to_user"]
        ];

        $res = $this->commentaireModel->insertCommentaire($data);
        if ($res) {
            $comments = $this->commentaireModel->getCommentaireByVideoId($data["idVideo"], $data["to_user"], $data["from_user"]);
            foreach ($comments as $comment) {
                $comment->img =  URLROOT . "/Public/" . $comment->img;
            }
            echo json_encode(["success" => $res, "comments" => $comments]);
        }
    }

    public function uploadVideo()
    {
        if (isset($_FILES['file'])) {
            $errors = "";
            $path = 'images/formations/videos/';
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $new_file_name = substr(number_format(time() * rand(), 0, '', ''), 0, 5) . "_" . strtolower(preg_replace('/\s+/', '_', $file_name));
            $upload_path = $path . $new_file_name;
            if ($file_size > 41943040) {
                $errors = 'Très grande taille de fichier';
                return null;
            } else {
                move_uploaded_file($file_tmp, $upload_path);
            }

            if (empty($errors)) {
                echo json_encode(["videoPath" => $upload_path]);
                return null;
            } else {
                echo json_encode(["error" => $errors]);
                return null;
            }
        }
    }

    public function checkMontant()
    {
        if (isset($_SESSION['id_formateur'])) {
            echo json_encode($this->fomateurModel->getBalance($_SESSION['id_formateur']));
        }
    }

    public function googleLogin()
    {
        $url = "";
        $token = $_POST['token'];
        $verificationUrl = "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=" . $token;
        $response = file_get_contents($verificationUrl);

        if ($response !== false) {
            $data = json_decode($response, true);

            if (isset($data['aud']) && $data['aud'] === '778408900492-6dbjf9arq9mo3thm3l4fr4fid6sjcis6.apps.googleusercontent.com') {
                $email = $data['email'];

                // Shecking If That User Exists
                $user = $this->etudiantModel->whereEmail($email);
                if (empty($user)) {
                    $user = $this->fomateurModel->whereEmail($email);
                    if (!empty($user)) {
                        $user->type = "formateur";
                        $url = $this->createUserSessions($user);
                        echo json_encode([
                            "authorized" => true,
                            "message" => "rediriger ...",
                            "url" => $url
                        ]);
                    } else {
                        echo json_encode([
                            "authorized" => false,
                            "message" => "Aucun utilisateur avec cette adresse e-mail !"
                        ]);
                    }
                } else {
                    $user->type = "etudiant";
                    $url = $this->createUserSessions($user);
                    echo json_encode([
                        "authorized" => true,
                        "message" => "rediriger ...",
                        "url" => $url
                    ]);
                }
            } else {
                echo json_encode([
                    "authorized" => false,
                    "message" => "Utilisateur non autorisé"
                ]);
            }
        } else {
            echo json_encode([
                "authorized" => false,
                "message" => "Erreur serveur"
            ]);
        }
    }

    public function facebookLogin()
    {
        $url = "";
        $token = $_POST['token'];
        $verificationUrl = "https://graph.facebook.com/v17.0/me?access_token=" . $token . "&fields=id,email";
        $response = file_get_contents($verificationUrl);

        if ($response !== false) {
            $data = json_decode($response, true);
            $email = $data['email'];

            // Shecking If That User Exists
            $user = $this->etudiantModel->whereEmail($email);
            if (empty($user)) {
                $user = $this->fomateurModel->whereEmail($email);
                if (!empty($user)) {
                    $user->type = "formateur";
                    $url = $this->createUserSessions($user);
                    echo json_encode([
                        "authorized" => true,
                        "message" => "rediriger ...",
                        "url" => $url
                    ]);
                } else {
                    echo json_encode([
                        "authorized" => false,
                        "message" => "Aucun utilisateur avec cet adresse e-mail"
                    ]);
                }
            } else {
                $user->type = "etudiant";
                $url = $this->createUserSessions($user);
                echo json_encode([
                    "authorized" => true,
                    "message" => "rediriger ...",
                    "url" => $url
                ]);
            }
        } else {
            echo json_encode([
                "authorized" => false,
                "message" => "Erreur Serveur"
            ]);
        }
    }

    public function createUserSessions($user)
    {
        if ($user->type === 'formateur') {
            $_SESSION['id_formateur'] = $user->id_formateur;
            $_SESSION['user'] = $user;
            // setting up the image link
            $_SESSION['user']->img = URLROOT . "/Public/" . $_SESSION['user']->img;
            return URLROOT . '/formateurs/dashboard';
        } else {
            $_SESSION['id_etudiant'] = $user->id_etudiant;
            $_SESSION['user'] = $user;
            // setting up the image link
            $_SESSION['user']->img = URLROOT . "/Public/" . $_SESSION['user']->img;
            return URLROOT . '/etudiants/dashboard';
        }
    }

    public function joinCourse($code = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (is_null($code)) {
                echo json_encode("le code de la formation est obligatoire.");
                http_response_code(400);
                exit;
            }

            $formations = $this->formationModel->join($code);
            if ($formations) {
                foreach ($formations as $formation) {
                    $inscription = $this->inscriptionModel->checkIfAlready($_SESSION['id_etudiant'], $formation->id_formation);
                    if (empty($inscription)) {
                        $inscriptionData = [
                            "id_formation" => $formation->id_formation,
                            "id_etudiant" => $_SESSION['id_etudiant'],
                            "id_formateur" => $formation->id_formateur,
                            "prix" => $formation->prix,
                            "transaction_info" => 0,
                            "payment_id" => 0,
                            "payment_state" => 'approved',
                            "date_inscription" => date('Y-m-d H:i:s'),
                            "approval_url" => 0
                        ];

                        $this->inscriptionModel->create($inscriptionData);
                        http_response_code(201);
                    }
                }

                flash("joined", "Vous avez rejoindre toutes les formations de formateur <strong>{$formations[0]->nom} {$formations[0]->prenom}</strong>.");
            } else {
                echo json_encode("ce code est invalid.");
                http_response_code(404);
            }
        } else {
            redirect();
            exit;
        }
    }
}