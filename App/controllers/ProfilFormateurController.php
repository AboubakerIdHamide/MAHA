<?php

use App\Models\Formation;
use App\Models\Formateur;
use App\Models\Stocked;
use App\Models\Inscription;

class ProfilFormateurController
{
    private $formationModel;
    private $fomateurModel;
    private $stockedModel;
    private $inscriptionModel;

    public function __construct()
    {
        $this->formationModel = new Formation;
        $this->fomateurModel = new Formateur;
        $this->stockedModel = new Stocked;
        $this->inscriptionModel = new Inscription;
    }
    public function index($id = null)
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

        return view("pages/profilFormateur", $data);
    }
}
