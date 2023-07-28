<?php

use App\Models\Formateur;

class ProfilSettingsFormateurController
{
    private $fomateurModel;

    public function __construct()
    {
        if (!isset($_SESSION['id_formateur'])) {
            redirect('user/login');
            return;
        }
        $this->fomateurModel = new Formateur;
    }
    public function index($id)
    {
        $formateur = $this->fomateurModel->find($id);
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
