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
}