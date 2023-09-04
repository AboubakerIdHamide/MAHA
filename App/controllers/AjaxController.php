<?php

use App\Models\Formateur;
use App\Models\Etudiant;
use App\Models\Formation;
use App\Models\Video;
use App\Models\Inscription;
use App\Models\Commentaire;

class AjaxController
{
    private $formateurModel;
    private $etudiantModel;
    private $formationModel;
    private $videoModel;
    private $inscriptionModel;
    private $commentaireModel;

    public function __construct()
    {
        $this->formateurModel = new Formateur;
        $this->etudiantModel = new Etudiant;
        $this->formationModel = new Formation;
        $this->videoModel = new Video;
        $this->inscriptionModel = new Inscription;
        $this->commentaireModel = new Commentaire;    
    }

    public function checkEmail()
    {
        $request = new App\Libraries\Request;
        if($request->getMethod() === 'POST'){
            $isThisEmailNew  = true;

            if(!$request->post('email')){
                return App\Libraries\Response::json(null, 400, "The email is field is requied.");
            }

            if ($this->etudiantModel->whereEmail($request->post('email'))) {
                $isThisEmailNew = false;
            }

            if ($this->formateurModel->whereEmail($request->post('email'))) {
                $isThisEmailNew = false;
            }

            echo json_encode($isThisEmailNew);
            return;
        }

        return App\Libraries\Response::json(null, 405, "Method Not Allowed");
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

    public function checkMontant()
    {
        // Code Check Balance Formateur Here (Before Making request money)
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