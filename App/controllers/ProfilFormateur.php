<?php

class ProfilFormateur extends Controller
{
    private $stockedModel;
    private $formationModel;
    private $inscriptionModel;
    private $fomateurModel;

    public function __construct()
    {
        $this->fomateurModel = $this->model("Formateur");
        $this->formationModel = $this->model("Formation");
        $this->inscriptionModel = $this->model("Inscription");
        $this->stockedModel = $this->model("Stocked");
    }
    public function index($id)
    {
        $formateur = $this->fomateurModel->getFormateurById($id);
        $formateur->img = URLROOT . "/Public/" . $formateur->img;
        $formations = $this->formationModel->getFormationsFormateurById($id);
        $numFormations = $this->fomateurModel->getnumFormationsFormateurById($id);
        $numAcht = $this->fomateurModel->getNumFormationAchtByIdFormateur($id);
        $themeData = $this->stockedModel->getThemeData();
        $theme["logo"] = URLROOT . "/Public/" . $themeData->logo;
        foreach ($formations as $formation) {
            $formation->inscriptions = $this->inscriptionModel->countApprenantsOfFormation($formation->id_formateur, $formation->id_formation);
            $formation->imgFormation = URLROOT . "/Public/" . $formation->imgFormation;
            $formation->imgFormateur = URLROOT . "/Public/" . $formation->imgFormateur;
        }
        $data = [
            'formateur' => $formateur,
            'formations' => $formations,
            'numFormations' => $numFormations,
            'numAcht' => $numAcht,
            'theme' => $theme
        ];

        $this->view("pages/profilFormateur", $data);
    }
}
