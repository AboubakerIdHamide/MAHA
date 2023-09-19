<?php

use App\Models\Formation;
use App\Models\Video;
use App\Models\Inscription;
use App\Models\Etudiant;
use App\Models\Message;
use App\Models\Formateur;

use App\Libraries\Response;
use App\Libraries\Request;
use App\Libraries\Validator;

class EtudiantController
{
	private $id_etudiant;
	private $formationModel;
	private $videoModel;
	private $inscriptionModel;
	private $etudiantModel;

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

		$this->id_etudiant = session('user')->get()->id_etudiant;
		$this->formationModel = new Formation;
		$this->videoModel = new Video;
		$this->inscriptionModel = new Inscription;
		$this->etudiantModel = new Etudiant;
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

	public function messages($slug = null)
    {
		$messageModel = new Message;
		$conversations = $messageModel->conversations($slug, $this->id_etudiant);
		$myFormateurs = $messageModel->myFormateurs($this->id_etudiant);
		$slugs = [];
		foreach($myFormateurs as $formateur) array_push($slugs, $formateur->slug);
		
		// Prevent getting conversations that user not allowed to
		if($slug && !in_array($slug, $slugs)){
			return Response::json(null, 403, "Something went wrong!");
		}

		// Match video name with its formation
		foreach ($conversations as $conversation) {
			if (preg_match('/@([^@]+)@/', $conversation->message, $matches)) {
				$nomVideo = $matches[1];
				if($video = $this->videoModel->whereNom($nomVideo)){
					$conversation->message = preg_replace('/@([^@]+)@/', "<div class=\"pb-2\"><a target=\"_blank\" href=\"".URLROOT."/etudiant/formation/{$video->id_formation}\">{$nomVideo}</a></div>", $conversation->message, 1);
				}
			}
		}

		$formateurModel = new Formateur;
		$formateur = $formateurModel->whereSlug($slug);
		
        return view('etudiants/messages', compact('conversations', 'formateur', 'myFormateurs'));
    }

	public function edit()
	{
		$request = new Request;
		if($request->getMethod() === 'GET'){
			return view('etudiants/edit-profil', ['etudiant' => $this->etudiantModel->find($this->id_etudiant)]);
		}

		$tabs = ["AccountTab", "PrivateTab"];
		if($request->getMethod() === 'PUT'){
			if(!in_array($request->post("tab"), $tabs)){
				return Response::json(null, 400);
			}

			return $this->{"_edit".$request->post('tab')}($request);
		}

		return Response::json(null, 405, "Method Not Allowed");
	}

	private function _editAccountTab($request)
    {
    	$validator = new Validator([
            'nom' => strip_tags(trim($request->post("nom"))),
            'prenom' => strip_tags(trim($request->post("prenom"))),
        ]);

        $validator->validate([
            'nom' => 'required|min:3|max:15|alpha',
            'prenom' => 'required|min:3|max:15|alpha',
        ]);

        $updatedData = $validator->validated();

        // update avatar
        if($request->file('image')){
        	unset($validator);

        	$validator = new Validator([
            	'img' => $request->file("image"),
	        ]);

	        $validator->validate([
	            'img' => 'size:5|image',
	        ]);

	        $oldAvatar = $this->etudiantModel->select($this->id_etudiant, ['img']);

	        if($oldAvatar !== 'users/avatars/default.png'){
	        	unlink('images/'.$oldAvatar->img);
	        }

	        $updatedData['img'] = uploader($request->file("image"), 'images/users/avatars');
	        $_SESSION['user']->img = $updatedData['img'];
        }

        if($etudiant = $this->etudiantModel->update($updatedData, $this->id_etudiant)){
        	return Response::json($etudiant, 200, 'Updated successfuly.');
        }
        return Response::json(null, 500, "Coudn't update your account, please try again later.");
    }

	private function _editPrivateTab($request)
    {
    	$validator = new Validator([
            'cmdp' => $request->post("cmdp"),
            'password' => $request->post("mdp"),
            'password_confirmation' => $request->post("vmdp"),
        ]);

        $validator->validate([
            'cmdp' => 'required|check_password:etudiants',
            'password' => 'required|confirm|min:10|max:50',
        ]);


        if($this->etudiantModel->update(['mot_de_passe' => $validator->validated()['password']], $this->id_etudiant)){
        	return Response::json(null, 200, 'Updated successfuly.');
        }
        return Response::json(null, 500, "Coudn't update your password, please try again later.");
    }

	public function changeEmail()
    {
    	$request = new Request;
    	if ($request->getMethod() === 'PUT') {
			$validator = new Validator([
            	'email' => strip_tags(trim($request->post("email"))),
	        ]);

	        $validator->validate([
	            'email' => 'email|max:100|unique:etudiants|unique:formateurs',
	        ]);			

	        $token = bin2hex(random_bytes(16));
            $this->etudiantModel->updateToken(session('user')->get()->email, hash('sha256', $token), 30);
	        session('new_email')->set($validator->validated()['email']);

            try {
                $mail = new App\Libraries\Mail;
                $mail->to(session('new_email')->get())
                ->subject("Vérification d'adresse e-mail")
                ->body(null, 'verify-email.php', [
                    '::tokenLink',
                    '::expirationTime',
                ],
                [
                    URLROOT."/etudiant/confirmEmail/?token=".$token,
                    '30 minutes',
                ])->attach(['images/MAHA.png' => 'logo'])
                ->send();

                return Response::json(null, 200, "Nous avons envoyé votre lien de vérification par e-mail.");
            } catch (Exception $e) {
                // echo json_encode($mail->ErrorInfo);
                return Response::json(null, 500, "L'email n'a pas pu être envoyé.");
            }
		}

		return Response::json(null, 405, "Method Not Allowed");	
    }

    public function confirmEmail()
    {
    	$request = new Request;
    	if($request->getMethod() !== 'GET'){
    		return Response::json(null, 405, "Method Not Allowed");
    	}

    	if(!$request->get('token')){
            return view('errors/page_404');
        }

		$statement = App\Libraries\Database::getConnection()->prepare("
            SELECT
                verification_token,
                expiration_token_at
            FROM etudiants
            WHERE verification_token = :token
        ");

        $statement->execute([
            "token" => hash('sha256', $request->get('token')),
        ]);

        $etudiant = $statement->fetch(\PDO::FETCH_OBJ);
        if(!$etudiant) {
            return view('errors/page_404');
        }

        if(strtotime($etudiant->expiration_token_at) < time()) {
            return view('errors/token_expired');
        }

        $this->etudiantModel->update(["email" => session('new_email')->get()], $this->id_etudiant);
        $_SESSION['user']->email = session('new_email')->get();
        session('email')->remove();
        flash("emailChanged", '<i class="material-icons text-success mr-3">check_circle</i><div class="text-body">You\'re email changed successfuly</div>', "alert alert-light border-1 border-left-3 border-left-success d-flex");
        return redirect('etudiant/edit');
    }
}
