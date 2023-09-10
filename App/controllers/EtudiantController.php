<?php

use App\Models\Etudiant;
use App\Models\Formation;
use App\Models\Video;
use App\Models\Inscription;
use App\Models\Stocked;

use App\Libraries\Response;
use App\Libraries\Request;
use App\Libraries\Validator;

class EtudiantController
{
	private $id_etudiant;
	private $etudiantModel;
	private $formationModel;
	private $videoModel;
	private $inscriptionModel;
	private $stockedModel;


	public function __construct()
	{
		if (!auth()) {
			return redirect('user/login');
		}

		if(session('user')->get()->type !== 'etudiant'){
			return view('errors/page_404');
		}

		if(!session('user')->get()->email_verified_at) {
			return redirect('user/verify');
		}

		$this->etudiantModel = new Etudiant;
		$this->formationModel = new Formation;
		$this->videoModel = new Video;
		$this->inscriptionModel = new Inscription;
		$this->stockedModel = new Stocked;
		$this->id_etudiant = session('user')->get()->id_etudiant;
	}

	public function index()
	{
		return view("etudiants/index");
	}

	public function inscriptions()
	{
		$request = new Request;
		if($request->getMethod() !== 'GET'){
			return Response::json(null, 405, "Method Not Allowed");
		}

		$totalInscriptions = $this->inscriptionModel->countInscriptionsOfEtudiant($this->id_etudiant);
		$formations = paginator($totalInscriptions, 4, 'my_courses', $this->inscriptionModel, 'getFormationsOfEtudiant', ['id' => $this->id_etudiant]);
		return Response::json($formations);
	}

	public function joinCourse()
    {
    	$request = new Request;
		if($request->getMethod() !== 'POST'){
			return Response::json(null, 405, "Method Not Allowed");
		}

		$validator = new Validator([
			'code' => strip_tags(trim($request->post('code')))
		]);

		$validator->validate([
			'code' => 'required|min:30|max:60|alphanum|exists:formateurs'
		]);

		$formations = $this->formationModel->getPrivateFormations($validator->validated()["code"]);
		if(!$formations){
			return Response::json(null, 400, "Sorry! this instractor doesn't have any courses yet.");
		}

        foreach ($formations as $formation) {
            $inscription = $this->inscriptionModel->checkIfAlready($this->id_etudiant, $formation->id_formation);
            if (!$inscription) {
                $inscriptionData = [
                    "id_formation" => $formation->id_formation,
                    "id_etudiant" => $this->id_etudiant,
                    "id_formateur" => $formation->id_formateur,
                    "prix" => $formation->prix,
                    "transaction_info" => 0,
                    "payment_id" => 0,
                    "payment_state" => 'approved',
                    "date_inscription" => date('Y-m-d H:i:s'),
                    "approval_url" => 0
                ];

                $this->inscriptionModel->create($inscriptionData);
            }
        }

        return Response::json(null, 200, "Congrats! vous avez rejoindre toutes les formations de formateur <strong>{$formations[0]->nom} {$formations[0]->prenom}</strong>.");
    }

    public function formation($id_formation = null)
    {
    	$request = new Request;
		if($request->getMethod() !== 'GET'){
			return Response::json(null, 405, "Method Not Allowed");
		}

		if(is_null($id_formation) || !is_numeric($id_formation)){
			return view("errors/page_404");
		}

		$formation = $this->inscriptionModel->getMyCourse($this->id_etudiant, $id_formation);
		if(!$formation){
			return view("errors/page_404");
		}

		$videos = $this->videoModel->getVideosOfFormation($id_formation);
		return view('etudiants/formation', compact('formation', 'videos'));
    }

	public function bookmarks()
	{
		$bookmarks = $this->videoModel->getMyBookmarks($this->id_etudiant);
		return view("etudiants/bookmarks", compact('bookmarks'));
	}

    public function toggleLikeFormation($id_formation = null)
    {
    	$request = new Request;
		if($request->getMethod() !== 'POST'){
			return Response::json(null, 405, "Method Not Allowed");
		}

		$validator = new Validator([
			'id_formation' => strip_tags(trim($id_formation))
		]);

		$validator->validate([
			'id_formation' => 'required|numeric|exists:formations|check_etudiant:inscriptions'
		]);

		$isLiked = $this->formationModel->toggleLike($this->id_etudiant, $id_formation);
        $newLikes = $this->formationModel->getLikes($id_formation);
        return Response::json(array_merge($newLikes, $isLiked));
    }

    public function toggleBookmarkVideo($id_video = null)
    {
    	$request = new Request;
		if($request->getMethod() !== 'POST'){
			return Response::json(null, 405, "Method Not Allowed");
		}

		$validator = new Validator([
			'id_video' => strip_tags(trim($id_video))
		]);

		$validator->validate([
			'id_video' => 'required|numeric|exists:videos'
		]);

		$relationship = [
			"from" => "inscriptions",
			"join" => "videos",
			"using" => "id_formation",
			"where" => [
				"id_video" => $id_video,
				"id_etudiant" => $this->id_etudiant,
			]
		];

		$validator->checkPermissions($relationship);

        $response = $this->videoModel->toggleBookmark($this->id_etudiant, $id_video);
        return Response::json($response);
    }
}
