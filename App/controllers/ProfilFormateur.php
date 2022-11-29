<?php
	
class ProfelFormateur extends Controller {
    public function __construct()
    {
        $this->fomateurModel = $this->model("Formateur");
        $this->etudiantModel = $this->model("Etudiant");
        $this->formationModel = $this->model("Formation");
        $this->inscriptionModel = $this->model("Inscription");
    }
	public function index($id)
    {
        $infoFormateur = $this->fomateurModel->getFormateurById($id);
        $courses = $this->formationModel->getFormationsFormateurById($id);
        $numFormations = $this->formationModel->getnumFormationsFormateurById($id);
        $data = [
            'infoFormateur' => $infoFormateur,
            'courses' => $courses,
            'numFormations' => $numFormations
        ];
        $this->view("pages/profelFormateur", $data);
    }
}
