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
}