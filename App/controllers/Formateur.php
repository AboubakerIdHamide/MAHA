<?php
<<<<<<< HEAD
	
class Formateur extends Controller {
	public function __construct(){
		if(!isset($_SESSION['user_id'])){
=======

class Formateur extends Controller
{
	public function __construct()
	{
		if (!isset($_SESSION['user_id'])) {
>>>>>>> dd0c7cebe874638ddfed7dbcae2a8836d9f45125
			redirect('users/login');
			return;
		}
		$this->stockedModel = $this->model("Stocked");
	}

<<<<<<< HEAD
=======
	public function index()
	{
		redirect('formateur/dashboard');
	}

>>>>>>> dd0c7cebe874638ddfed7dbcae2a8836d9f45125
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
}
=======

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
>>>>>>> dd0c7cebe874638ddfed7dbcae2a8836d9f45125
