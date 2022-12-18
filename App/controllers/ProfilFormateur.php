<?php

class ProfilFormateur extends Controller
{
    public function __construct()
    {
        $this->fomateurModel = $this->model("Formateur");
        $this->etudiantModel = $this->model("Etudiant");
        $this->formationModel = $this->model("Formation");
        $this->inscriptionModel = $this->model("Inscription");
        $this->stockedModel = $this->model("Stocked");
    }
    public function index($id)
    {
        $infoFormateur = $this->fomateurModel->getFormateurById($id);
        $infoFormateur['img'] = $this->pcloudFile()->getLink($infoFormateur['img']);
        $courses = $this->formationModel->getFormationsFormateurById($id);
        $numFormations = $this->fomateurModel->getnumFormationsFormateurById($id);
        $numAcht = $this->fomateurModel->getNumFormationAchtByIdFormateur($id);
        foreach ($courses as $row) {
            $row->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($row->IdFormteur, $row->IdFormation)['total_apprenants'];
            $row->imgFormation = $this->pcloudFile()->getLink($row->imgFormation);
            $row->imgFormateur = $this->pcloudFile()->getLink($row->imgFormateur);
        }
        $data = [
            'infoFormateur' => $infoFormateur,
            'courses' => $courses,
            'numFormations' => $numFormations,
            'numAcht' => $numAcht
        ];

        $this->view("pages/profilFormateur", $data);
    }
}
