<?php

use App\Models\Formateur;
use App\Models\Inscription;
use App\Models\Stocked;

use App\Libraries\Request;
use App\Libraries\Response;
use App\Libraries\Validator;

class FormateurController
{
	private $id_formateur;
	private $formateurModel;
	private $inscriptionModel;
	private $stockedModel;

	public function __construct()
	{
		if (!auth()) {
			return redirect('user/login');
		}

		if(session('user')->get()->type !== 'formateur'){
			return view('errors/page_404');
		}

		if(!session('user')->get()->email_verified_at) {
			return redirect('user/verify');
		}

		if(!session('user')->get()->is_all_info_present){
			return redirect('user/continue');
		}

		$this->id_formateur = session('user')->get()->id_formateur;
		$this->formateurModel = new Formateur;
		$this->inscriptionModel = new Inscription;
		$this->stockedModel = new Stocked;
	}

	public function index()
	{
		$data = [
			'inscriptions' => json_encode($this->inscriptionModel->getLast7DaysRevenus($this->id_formateur)),
			'latestTransactions' => $this->inscriptionModel->getTransactions($this->id_formateur),
			'salesToday' => $this->inscriptionModel->getSalesToday($this->id_formateur)
		];

		return view('formateurs/index', $data);
	}

	public function earnings()
	{
		return view('formateurs/earnings');
	}

	public function getEarnings()
	{
		$request = new Request;
		if($request->getMethod() !== 'GET'){
			return Response::json(null, 405, "Method Not Allowed");
		}

		$years = []; // Generate last 5 years.
		for($i = date('Y'); $i >= date('Y') - 5;$i--) array_push($years, $i);

		if(!in_array($request->get('year'), $years)) Response::json(null, 400);

		$earnings = $this->inscriptionModel->getEarningsThisYear($this->id_formateur, date("{$request->get('year')}-01-01"));
		return Response::json($earnings);
	}

	public function getSalesOfAllTime()
	{
		$request = new Request;
		if($request->getMethod() !== 'GET'){
			return Response::json(null, 405, "Method Not Allowed");
		}
		
		$total = $this->inscriptionModel->countAllCoursesThatHaveSubscribers($this->id_formateur);
		$totalPages = ceil($total / 4);

        $page = htmlspecialchars(strip_tags($request->get('page')));
        if(!isset($page) || $page < 1 || $page > $totalPages) $page = 1;

        $offset = ($page - 1) * 4;	
        $formationsRevenue = $this->inscriptionModel->getSalesOfAllTime($this->id_formateur, $offset);
        $totalRevenue = $this->inscriptionModel->getTotalRevenueFormateur($this->id_formateur);
        
        $data = [
        	'formationsRevenue' => $formationsRevenue,
        	'totalRevenue' => $totalRevenue,
        	'totalCourses' => (int) $total,
            'totalPages' => $totalPages == 0 ? 1 : $totalPages,
            'currentPage' => (int) $page,
            'nextPage' => $page < $totalPages ? $page + 1 : $totalPages,
            'prevPage' => $page - 1 === 0 ? null : $page - 1,
        ];

        return Response::json($data);
	}

	public function transactions()
	{
		return view('formateurs/transactions');
	}

	public function getTransactionsInSpecificDates()
	{
		$request = new Request;
		if($request->getMethod() !== 'GET'){
			return Response::json(null, 405, "Method Not Allowed");
		}

		$validator = new Validator([
            'start' => strip_tags(trim($request->get('start'))),
            'end' => strip_tags(trim($request->get('end'))),
        ]);

        $validator->validate([
            'start' => 'date',
            'end' => 'date'
        ]);

        $dates = $validator->validated();

        // Check if dates are not emty, because they aren't required.
        if($dates['end'] && $dates['start']){
        	foreach ($dates as $key => $date) {
       			$isoDateTime = new DateTime($date);
				$dates[$key] = $isoDateTime->format("Y-m-d");
       		}

       		$filter = "AND DATE(date_inscription) BETWEEN '{$dates['start']}' AND '{$dates['end']}'";
        }else{
        	$filter = "AND DATE(date_inscription) BETWEEN '".date('Y-m-d')."' - INTERVAL 1 YEAR AND '".date('Y-m-d')."'";
        }
        
        $total = $this->inscriptionModel->countTransactionsOfFormateur($this->id_formateur, $filter);
		$totalPages = ceil($total / 4);

        $page = htmlspecialchars(strip_tags($request->get('page')));
        if(!isset($page) || $page < 1 || $page > $totalPages) $page = 1;

        $offset = ($page - 1) * 4;	

        $sort = htmlspecialchars(strip_tags($request->get('sort')));
        $sorts = ['amount' => 'i.prix DESC', 'course' => 'nom ASC'];

        if(array_key_exists($sort, $sorts)){
            $sort = $sorts[$sort];
        }else{
        	$sort = 'date_inscription DESC';
        }

        $transactions = $this->inscriptionModel->getTransactions($this->id_formateur, $offset, $sort, $filter);

        $data = [
        	'transactions' => $transactions,
        	'totalTransactions' => (int) $total,
            'totalPages' => $totalPages == 0 ? 1 : $totalPages,
            'currentPage' => (int) $page,
            'nextPage' => $page < $totalPages ? $page + 1 : $totalPages,
            'prevPage' => $page - 1 === 0 ? null : $page - 1,
        ];
		return Response::json($data);
	}

	public function edit()
	{
		$request = new Request;
		if($request->getMethod() === 'GET'){
			$data = [
				'formateur' => $this->formateurModel->formateur($this->id_formateur),
				'categories' => $this->stockedModel->getAllCategories(),
			];

			return view('formateurs/edit-profil', $data);
		}

		$tabs = ["AccountTab", "PublicTab", "PrivateTab", "SocialTab"];
		if($request->getMethod() === 'PUT'){
			if(!in_array($request->post("tab"), $tabs)){
				return Response::json(null, 400);
			}

			return $this->{"_edit".$request->post('tab')}($request);
		}

		return Response::json(null, 405, "Method Not Allowed");
	}

	private function _strip_critical_tags($text)
    {
        $dom = new DOMDocument();
        $dom->loadHTML($text);
        $tags_to_remove = ['script', 'style', 'iframe', 'link', 'video', 'img'];
        foreach($tags_to_remove as $tag){
            $element = $dom->getElementsByTagName($tag);
            foreach($element as $item){
                $item->parentNode->removeChild($item);
            }
        }

        $body = $dom->getElementsByTagName('body')->item(0);
        $cleanedHtml = '';

        if ($body) {
            foreach ($body->childNodes as $childNode) {
                $cleanedHtml .= $dom->saveHTML($childNode);
            }
        }
        return $cleanedHtml; 
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

	        $oldAvatar = $this->formateurModel->select($this->id_formateur, ['img']);

	        if($oldAvatar !== 'users/avatars/default.png'){
	        	unlink('images/'.$oldAvatar->img);
	        }

	        $updatedData['img'] = uploader($request->file("image"), 'images/users/avatars');
	        $_SESSION['user']->img = $updatedData['img'];
        }

        // update phone number
        if($request->post('tel')){
        	unset($validator);

        	$validator = new Validator([
            	'tel' => trim($request->post("tel")),
	        ]);

	        $validator->validate([
	            'tel' => 'min:8|max:20',
	        ]);

	        $updatedData['tel'] = $request->post('tel');
        }

        // update paypal email
        if($request->post('paypalMail')){
        	unset($validator);

        	$validator = new Validator([
            	'paypalMail' => strip_tags(trim($request->post("paypalMail"))),
	        ]);

	        $validator->validate([
	            'paypalMail' => 'email|max:100',
	        ]);

	        $updatedData['paypalMail'] = $request->post('paypalMail');	
        }

        if($formateur = $this->formateurModel->update($updatedData, $this->id_formateur)){
        	return Response::json($formateur, 200, 'Updated successfuly.');
        }
        return Response::json(null, 500, "Coudn't update your account, please try again later.");
    }

    public function refreshCode()
	{
		$request = new Request;
		if ($request->getMethod() === 'PUT') {
			$code = strtoupper(bin2hex(random_bytes(20)));
            while ($this->formateurModel->isCodeExist($code)) {
                $code = strtoupper(bin2hex(random_bytes(20)));      
            }
			if($this->formateurModel->update(['code' => $code], $this->id_formateur)){
        		return Response::json($code, 200, "Your code updated successfuly.");
	        }
	        return Response::json(null, 500, "Coudn't update your account, please try again later.");
		}

		return Response::json(null, 405, "Method Not Allowed");
	}

    private function _editPublicTab($request)
    {
    	$validator = new Validator([
            'id_categorie' => strip_tags(trim($request->post("categorie"))),
            'specialite' => strip_tags(trim($request->post("speciality"))),
            'biographie' => $this->_strip_critical_tags($request->post("biography")),
        ]);

        $validator->validate([
            'biographie' => 'required|min:15|max:700',
            'id_categorie' => 'required|numeric|exists:categories',
            'specialite' => 'required|min:3|max:30',
        ]);

        $updatedData = $validator->validated();
        unset($updatedData['type']);

        // update background
        if($request->file('background')){
        	unset($validator);

        	$validator = new Validator([
            	'img' => $request->file("background"),
	        ]);

	        $validator->validate([
	            'img' => 'size:10|image',
	        ]);

	        $oldBackground = $this->formateurModel->select($this->id_formateur, ['background_img']);

	        if($oldBackground !== 'users/background/default.png'){
	        	unlink('images/'.$oldBackground->background_img);
	        }

	        $updatedData['background_img'] = uploader($request->file("background"), 'images/users/backgrounds');
	        $_SESSION['user']->background_img = $updatedData['background_img'];
        }

        if($formateur = $this->formateurModel->update($updatedData, $this->id_formateur)){
        	return Response::json($formateur, 200, 'Updated successfuly.');
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
            'cmdp' => 'required|check_password:formateurs',
            'password' => 'required|confirm|min:10|max:50',
        ]);


        if($this->formateurModel->update(['mot_de_passe' => $validator->validated()['password']], $this->id_formateur)){
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
	            'email' => 'email|max:100|unique:formateurs|unique:etudiants',
	        ]);			

	        $token = bin2hex(random_bytes(16));
            $this->formateurModel->updateToken(session('user')->get()->email, hash('sha256', $token), 30);
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
                    URLROOT."/formateur/confirmEmail/?token=".$token,
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
            FROM formateurs
            WHERE verification_token = :token
        ");

        $statement->execute([
            "token" => hash('sha256', $request->get('token')),
        ]);

        $formateur = $statement->fetch(\PDO::FETCH_OBJ);
        if(!$formateur) {
            return view('errors/page_404');
        }

        if(strtotime($formateur->expiration_token_at) < time()) {
            return view('errors/token_expired');
        }

        $this->formateurModel->update(["email" => session('new_email')->get()], $this->id_formateur);
        $_SESSION['user']->email = session('new_email')->get();
        session('email')->remove();
        flash("emailChanged", '<i class="material-icons text-success mr-3">check_circle</i><div class="text-body">You\'re email changed successfuly</div>', "alert alert-light border-1 border-left-3 border-left-success d-flex");
        return redirect('formateur/edit');
    }

    private function _editSocialTab($request)
    {
    	// update Facebook
    	if($request->post('facebook')){
        	$validator = new Validator([
            	'facebook' => str_replace(' ', '', $request->post("facebook")),
	        ]);

	        $validator->validate([
	            'facebook' => 'min:5|max:50',
	        ]);

	        $updatedData["facebook_profil"] = "https://www.facebook.com/".$validator->validated()['facebook'];
        }

        // update Twitter
        if($request->post('twitter')){
        	unset($validator);

        	$validator = new Validator([
            	'twitter' => str_replace(' ', '', $request->post("twitter")),
	        ]);

	        $validator->validate([
	            'twitter' => 'min:5|max:50',
	        ]);

	        $updatedData['twitter_profil'] = "https://www.twitter.com/".$validator->validated()['twitter'];
        }

        // update LinkedIn
        if($request->post('linkedin')){
        	unset($validator);

        	$validator = new Validator([
            	'linkedin' => str_replace(' ', '', $request->post("linkedin")),
	        ]);

	        $validator->validate([
	            'linkedin' => 'min:5|max:50',
	        ]);

	        $updatedData['linkedin_profil'] = "https://www.linkedin.com/".$validator->validated()['linkedin'];
        }

        if(isset($updatedData)) {
        	if($formateur = $this->formateurModel->update($updatedData, $this->id_formateur)){
	        	return Response::json(null, 200, 'Updated successfuly.');
	        }
	        return Response::json(null, 500, "Coudn't update your account, please try again later.");
        }
        return Response::json(null, 400, "You must provide a social profil link (facebook, linkedin, twitter).");
    }
}
