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
		redirect('formateur/dashboard');
	}

	public function dashboard()
	{
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

	public function addFormation()
	{
		echo "add Formation";
	}
}
