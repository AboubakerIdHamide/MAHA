<?php

class ProfilSettingsFormateur extends Controller
{
    private $fomateurModel;

    public function __construct()
    {
        if (!isset($_SESSION['id_formateur'])) {
            redirect('users/login');
            return;
        }
        $this->fomateurModel = $this->model("Formateur");
    }
    public function index($id)
    {
        $formateur = $this->fomateurModel->getFormateurById($id);
        $data = [
            'formateur' => $formateur
        ];
        return view("formateur/profilSettingsFormateur", $data);
    }
    public function updateInfoFormateur()
    {
    }
    public function changeImgProfelFormateur()
    {
    }
}
