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

<<<<<<< HEAD
	public function addFormation()
	{
		echo "add Formation";
	}
}
=======
	// default method
	public function index()
	{
		$this->dashboard();
	}
}
>>>>>>> 4015d1c6449891054e8aa91d8efbcd5fb863e5df
