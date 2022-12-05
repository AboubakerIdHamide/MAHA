<?php

class Admin extends Controller
{
    public function __construct()
    {
        // if (!isset($_SESSION['user_id'])) {
        // 	redirect('users/login');
        // 	return;
        // }
        $this->fomateurModel = $this->model("Formateur");
        $this->etudiantModel = $this->model("Etudiant");
        $this->formationModel = $this->model("Formation");
        $this->inscriptionModel = $this->model("Inscription");
    }

    public function index()
    {
        $this->dashboard();
    }

    public function dashboard()
    {
        $this->view('admin/index');
    }
}
