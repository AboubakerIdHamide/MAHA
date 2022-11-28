<?php
	
class Pages extends Controller {
<<<<<<< HEAD
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
=======
	public function index()
    {
        $this->view("pages/index");
>>>>>>> dd0c7cebe874638ddfed7dbcae2a8836d9f45125
    }
}