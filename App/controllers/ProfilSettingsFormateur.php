<?php

class ProfilSettingsFormateur extends Controller
{
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
        $info = $this->fomateurModel->getFormateurById($id);
        $data = [
            'info' => $info
        ];
        $this->view("formateur/profilSettingsFormateur", $data);
    }
    public function updateInfoFormateur()
    {
    }
    public function changeImgProfelFormateur()
    {
    }
}
