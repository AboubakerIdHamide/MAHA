<?php

class Formateur extends Controller
{
	public function __construct()
	{
		if (!isset($_SESSION['user_id'])) {
			redirect('users/login');
			return;
		}
		$this->stockedModel = $this->model("Stocked");
	}

	public function index()
	{
		$this->dashboard();
	}

	public function dashboard()
	{
		if (isset($_SESSION['id_formation'])) unset($_SESSION['id_formation']);
		$categories = $this->stockedModel->getAllCategories();
		$langues = $this->stockedModel->getAllLangues();
		$levels = $this->stockedModel->getAllLevels();
		$data = [
			'categories' => $categories,
			'langues' => $langues,
			'levels' => $levels,
		];

		$this->view('formateur/index', $data);
	}
}
