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
		foreach($info as $row){
            $row->numbAcht = $this->inscriptionModel->countApprenantsOfFormation($row->IdFormteur, $row->IdFormation)['total_apprenants'];
        }
		$data = [
		    'info' => $info
		];
		$this->view("pages/index", $data);
  	}
}
