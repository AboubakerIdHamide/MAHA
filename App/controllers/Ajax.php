<?php

class Ajax extends Controller{
    public function __construct()
    {
        $this->fomateurModel = $this->model("Formateur");
        $this->etudiantModel = $this->model("Etudiant");
        $this->formationModel = $this->model("Formation");
        $this->inscriptionModel = $this->model("Inscription");
    }

    public function checkEmail(){
        $data=[
            "thereIsError"=>false,
            "error"=>"",
        ];

        if(isset($_POST["email"])){
            if(!empty($this->etudiantModel->getEtudiantByEmail($_POST["email"]))){
                $data["thereIsError"]=true;
                $data["error"]="Adresse e-Mail déjà utilisée";
            }
            if(!empty($this->fomateurModel->getFormateurByEmail($_POST["email"]))){
                $data["thereIsError"]=true;
                $data["error"]="Adresse e-Mail déjà utilisée";
            }
        }

        echo json_encode($data);
    }

    public function checkPaypalEmail(){
        $data = [
            "thereIsError"=>false,
            "error"=>"",
        ];

        if(isset($_POST["pmail"])){
            if(!empty($this->fomateurModel->getFormateurByPaypalEmail($_POST["pmail"]))){
                $data["thereIsError"]=true;
                $data["error"]="Adresse e-Mail de Paypal déjà utilisée";
            }
        }

        echo json_encode($data);
    }

    public function getMyFormations($words = '')
    {
        $data = $this->formationModel->getAllFormationsOfFormateur($_SESSION['user_id'], $words);
        

        // don't forget to add APPROOT look at (js file (Miniature and Zipfile))
        foreach ($data as $key => $course) {
            $course->miniature=$this->pcloudFile()->getLink($course->miniature);
            $course->apprenants = $this->inscriptionModel->countApprenantsOfFormation($_SESSION['user_id'], $course->id)[0];
        }

        echo json_encode($data);
    }

    public function deleteFormation()
    {
        if(isset($_POST['id'])){
            foreach ($_POST['id'] as $key => $id_formation) {
                $this->formationModel->deleteFormation($id_formation);
            }
            echo 'La Formation a ete supprimer avec success !!!';
        }
    }
    
}

