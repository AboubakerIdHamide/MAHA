<?php
	
class Pages extends Controller {
    public function __construct()
    {
        $this->fomateurModel = $this->model("Formateur");
        $this->etudiantModel = $this->model("Etudiant");
        $this->formationModel = $this->model("Formation");
        $this->inscriptionModel = $this->model("Inscription");
    }
	public function index()
    {
        $info = $this->formationModel->getPupalaireCourses();
        $data = [
            'info' => $info
        ];
        $this->view("pages/index", $data);
    }
}