<?php


use PHPMailer\PHPMailer\Exception;

use Hybridauth\Hybridauth;

use GuzzleHttp\Client;

use App\Libraries\Response;
use App\Libraries\Validator;

use App\Models\Formateur;
use App\Models\Etudiant;
use App\Models\Stocked;
use App\Models\Formation;
use App\Models\Inscription;

class UserController
{
    private $formateurModel;
    private $etudiantModel;
    private $stockedModel;
    private $formationModel;

    public function __construct()
    {
        $this->formateurModel = new Formateur;
        $this->etudiantModel = new Etudiant;
        $this->stockedModel = new Stocked;
        $this->formationModel = new Formation;
        $this->inscriptionModel = new Inscription;
    }

    public function index($slug = null)
    {
        if(is_null($slug)){
            return redirect();
        }

        if(!$formateur = $this->formateurModel->whereSlug($slug)){
            return view('errors/page_404');
        }
 
        $formations = $this->formationModel->getFormationsOfFormateur($formateur->id_formateur);

        foreach ($formations as $formation) {
            $formation->inscriptions = $this->inscriptionModel->countApprenantsOfFormation($formateur->id_formateur, $formation->id_formation);
        }

        $data = [
            'formateur' => $formateur,
            'formations' => $formations,
            'numberFormations' => count($formations),
            'numberInscriptions' => $this->formateurModel->countPublicInscriptions($formateur->id_formateur),
        ];

        return view("formateurs/profil", $data);
    }

    public function login()
    {
        if (auth()) {
            return redirect(session('user')->get()->type);
        }

        if(isset(session('user')->get()->email_verified_at) && 
            !session('user')->get()->email_verified_at) {
            return redirect('user/verify');
        }

        $request = new App\Libraries\Request;
        if ($request->getMethod() === 'POST') {
            $validator = new Validator([
                'email' => strip_tags(trim($request->post('email'))),
                'password' => $request->post('mdp'),
            ]);

            $validator->validate([
                'email' => 'required|email|auth',
                'password' => 'required'
            ], 'auth/login', true);

            $credentials = $validator->validated(); 
            $user = $this->{$credentials['type'].'Model'}->whereEmail($credentials['email']);
            return $this->createUserSession($user);
        }

        $providers = ['LinkedIn', 'Google', 'Twitter'];
        $provider = $request->get('provider');
        if($provider && in_array($provider, $providers)){
            session('provider')->set($provider);
        }

        if(session('provider')->get() && session('user_type')->get()){
            // Load Environment Variables (.env)
            $dotenv = \Dotenv\Dotenv::createImmutable(dirname(dirname(__DIR__)));
            $dotenv->load();

            $config = [
                'callback' => $_ENV['REDIRECT_URI'], 
                'providers' => [
                    'Google' => [
                        'enabled' => true,
                        'keys' => [
                            'id' => $_ENV['CLIENT_ID_GOOGLE'],
                            'secret' => $_ENV['CLIENT_SECRET_GOOGLE'],
                        ],
                    ],
                    'LinkedIn' => [
                        'enabled' => true,
                        'keys' => [
                            'id' => $_ENV['CLIENT_ID_LINKEDIN'],
                            'secret' => $_ENV['CLIENT_SECRET_LINKEDIN'],
                        ],
                        "scope" => "openid profile email"
                    ],
                    'Twitter' => [
                        'enabled' => true,
                        'keys' => [
                            'id' => $_ENV['CLIENT_ID_TWITTER'],
                            'secret' => $_ENV['CLIENT_SECRET_TWITTER'],
                        ],
                    ],
                ],  
            ];
            
            $hybridauth = new Hybridauth($config);
            $adapter = $hybridauth->authenticate(session('provider')->get());
            $userProfile = $adapter->getUserProfile();
            $token = $adapter->getAccessToken();
            $this->revokeToken(session('provider')->get(), $token['access_token']);
            $adapter->disconnect();

            $formateur = $this->formateurModel->whereEmail($userProfile->email);
            $etudiant = $this->etudiantModel->whereEmail($userProfile->email);

            if(!$formateur && !$etudiant) {
                $newUser = [];
                $newUser['type'] = session('user_type')->get();
                $newUser['email'] = $userProfile->email; 
                $newUser['prenom'] = $userProfile->firstName;
                $newUser['nom'] = $userProfile->lastName;
                $newUser['img'] = $userProfile->photoURL;
                $newUser['verified'] = date('Y-m-d H:i:s');

                if($newUser['type'] === 'formateur'){
                    $newUser['code_formateur'] = strtoupper(bin2hex(random_bytes(20)));
                    while ($this->formateurModel->isCodeExist($newUser['code_formateur'])) {
                        $newUser['code_formateur'] = strtoupper(bin2hex(random_bytes(20)));      
                    }
                }

                $this->{$newUser['type'].'Model'}->create($newUser);
                $user = $this->{$newUser['type'].'Model'}->whereEmail($userProfile->email);
                
                session('user_type')->remove();
                session('provider')->remove();
                session('user')->set($user);
                return redirect(session('user')->get()->type);
            }

            session('user_type')->remove();
            session('provider')->remove();
            session('user')->set($formateur ? $formateur : $etudiant);
            return redirect(session('user')->get()->type);
        }

        return view("auth/login");
    }

    private function revokeToken($provider, $accessToken)
    {
        $client = new Client();
        // Revoke token
        try {
            switch ($provider) {
                case 'Google':
                    $response = $client->post('https://oauth2.googleapis.com/revoke', [
                        'form_params' => [
                            'token' => $accessToken
                        ]
                    ]);
                    break;
                case 'LinkedIn':
                    $response = $client->post('https://www.linkedin.com/oauth/v2/revoke', [
                       'form_params' => [
                            'client_id' => $_ENV['CLIENT_ID_LINKEDIN'],
                            'client_secret' => $_ENV['CLIENT_SECRET_LINKEDIN'],
                            'token' => $accessToken
                        ],
                        'headers' => [
                            'Content-Type' => 'application/x-www-form-urlencoded'
                        ]
                    ]);
                    break;
                default:
                    return null;
                    break;
            }

            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                // print_r2("Token revoked successfully.");
            } else {
                // print_r2("Token revocation failed.");
            }
        } catch (ClientException $e) {
            // print_r2($e->getMessage);
        }
    }

    public function register()
    {
        if (auth()) {
            return redirect(session('user')->get()->type);
        }

        if(isset(session('user')->get()->email_verified_at) && 
            !session('user')->get()->email_verified_at) {
            return redirect('user/verify');
        }
        
        $request = new App\Libraries\Request;
        if ($request->getMethod() === 'POST') {
            $validator = new Validator([
                'nom' => strip_tags(trim($request->post("nom"))),
                'prenom' => strip_tags(trim($request->post("prenom"))),
                'email' => strip_tags(trim($request->post("email"))),
                'password' => $request->post("mdp"),
                'password_confirmation' => $request->post("vmdp"),
                'type' => strip_tags(trim($request->post("type")))
            ]);

            $validator->validate([
                'nom' => 'required|min:3|max:15|alpha',
                'prenom' => 'required|min:3|max:15|alpha',
                'email' => 'required|email|max:100|unique:formateurs|unique:etudiants',
                'password' => 'required|confirm|min:10|max:50',
                'type' => 'required|in_array:formateur,etudiant'
            ]);

            $user = $validator->validated();
            if($user['type'] === 'formateur'){
                $user['code_formateur'] = strtoupper(bin2hex(random_bytes(20)));
                while ($this->formateurModel->isCodeExist($user['code_formateur'])) {
                    $user['code_formateur'] = strtoupper(bin2hex(random_bytes(20)));      
                }
            }

            // Generate token and hash it, after store it in DB and SESSION.
            $token = bin2hex(random_bytes(16));
            $this->{$user['type'].'Model'}->create($user, hash('sha256', $token));
            session('token')->set($token);

            // Get created user and authenticate him.
            $user = $this->{$user['type'].'Model'}->whereEmail($user['email']);
            session('user')->set($user);

            // send email verification to the authenticated user.
            $this->sendEmailVerification();
        }elseif ($request->getMethod() === 'GET') {
            return view("auth/register");   
        }

        return Response::json(null, 405, "Method Not Allowed");
    } 

    public function sendEmailVerification()
    {
        $request = new App\Libraries\Request;
        if($request->getMethod() === 'POST') {
            if(!session('user')->get() || session('user')->get()->email_verified_at){
                Response::json(null, 404, "404 Route Not Found");
            }

            $token = bin2hex(random_bytes(16));
            $this->{session('user')->get()->type.'Model'}->updateToken(session('user')->get()->email, hash('sha256', $token));

            sleep(12);

            try {
                $mail = new App\Libraries\Mail;
                $mail->to(session('user')->get()->email)
                ->subject("Vérification d'adresse e-mail")
                ->body(null, 'verify-email.php', [
                    '::tokenLink',
                    '::expirationTime',
                ],
                [
                    URLROOT."/user/confirm/?token=".$token,
                    '2 heures',
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

    public function verify()
    {
        $request = new App\Libraries\Request;
        if ($request->getMethod() === 'GET') {
            if(!session('user')->get() || session('user')->get()->email_verified_at){
                return view('errors/page_404');
            }


            return view('auth/verify');
        }
        return Response::json(null, 405, "Method Not Allowed");
    }

    public function confirm()
    {
        $request = new App\Libraries\Request;
        if ($request->getMethod() === 'GET') {
            if(!$request->get('token') || 
                !session('user')->get() || 
                session('user')->get()->email_verified_at){
                return view('errors/page_404');
            }

            $statement = App\Libraries\Database::getConnection()->prepare("
                SELECT
                    verification_token,
                    expiration_token_at
                FROM ".session('user')->get()->type."s
                WHERE verification_token = :token
            ");

            $statement->execute([
                "token" => hash('sha256', $request->get('token')),
            ]);

            $user = $statement->fetch(\PDO::FETCH_OBJ);
            if(!$user) {
                return view('errors/page_404');
            }

            if(strtotime($user->expiration_token_at) < time()) {
                $statement = App\Libraries\Database::getConnection()->prepare("
                    DELETE FROM ".session('user')->get()->type."s
                    WHERE verification_token = :token
                ");

                $statement->execute([
                    "token" => hash('sha256', $request->get('token')),
                ]);

                session()->flush();
                return view('errors/token_expired');
            }

            $statement = App\Libraries\Database::getConnection()->prepare("
                UPDATE ".session('user')->get()->type."s
                SET email_verified_at = NOW()
                WHERE verification_token = :token
            ");

            $statement->execute([
                "token" => hash('sha256', $request->get('token')),
            ]);

            $user = $this->{session('user')->get()->type.'Model'}->whereEmail(session('user')->get()->email);
            session('user')->set($user);
            return view('auth/confirm');
        }
        return Response::json(null, 405, "Method Not Allowed");
    }

    public function forgot()
    {
        if(auth()){
            return view('errors/page_404');
        }

        $request = new App\Libraries\Request;
        if ($request->getMethod() === 'POST') {
            $validator = new Validator([
                'email' => strip_tags(trim($request->post("email"))),
            ]);

            $validator->validate([
                'email' => 'required|email|max:100|exists:formateurs,etudiants',
            ], "auth/forgot");

            $user = $validator->validated();

            $statement = App\Libraries\Database::getConnection()->prepare("
                UPDATE reinitialisations_de_mot_de_passe 
                SET token = :token, 
                    expired_at = :expired_at
                WHERE email = :email
            ");

            $token = bin2hex(random_bytes(16));
            $statement->execute([
                "email" => $user['email'],
                "token" => hash('sha256', $token),
                "expired_at" => date("Y-m-d H:i:s", time() + 60 * 60)
            ]);

            if($statement->rowCount() < 1) {
                $statement = App\Libraries\Database::getConnection()->prepare("
                    INSERT INTO reinitialisations_de_mot_de_passe 
                    VALUES (:email, :token, :expired_at, :type_utilisateur)
                ");

                $token = bin2hex(random_bytes(16));
                $statement->execute([
                    "email" => $user['email'],
                    "type_utilisateur" => $user['type'],
                    "token" => hash('sha256', $token),
                    "expired_at" => date("Y-m-d H:i:s", time() + 60 * 60)
                ]);
            }

            sleep(17);

            try {
                $mail = new App\Libraries\Mail;
                $mail->to($user['email'])
                ->subject('Réinitialiser le mot de passe')
                ->body(null, 'reset-password.php', [
                    '::tokenLink',
                    '::expirationTime',
                ],
                [
                    URLROOT."/user/reset/?token=$token",
                    '60 Minutes',
                ])->attach(['images/MAHA.png' => 'logo'])
                ->send();

                return Response::json(null, 200, "Nous avons envoyé votre lien de réinitialisation par e-mail.");
            } catch (Exception $e) {
                // echo $mail->ErrorInfo;
                return Response::json(null, 500, "L'email n'a pas pu être envoyé.");
            }
        }

        return view("auth/forgot");
    }

    public function reset()
    {
        $request = new App\Libraries\Request;
        if($request->getMethod() === 'GET'){
            if(!$request->get('token')) {
                return view('errors/page_404');
            }

            $statement = App\Libraries\Database::getConnection()->prepare("
                SELECT * FROM reinitialisations_de_mot_de_passe
                WHERE token = :token
            ");

            $statement->execute([
                "token" => hash('sha256', $request->get('token')),
            ]);

            $user = $statement->fetch(\PDO::FETCH_OBJ);
            if(!$user) {
                return view('errors/page_404');
            }

            if(strtotime($user->expired_at) < time()) {
                $statement = App\Libraries\Database::getConnection()->prepare("
                    DELETE FROM reinitialisations_de_mot_de_passe
                    WHERE token = :token
                ");

                $statement->execute([
                    "token" => hash('sha256', $request->get('token')),
                ]);

                return view('errors/token_expired');
            }

            return view('auth/reset');

        }elseif ($request->getMethod() === 'POST') {
           $validator = new Validator([
                'password' => $request->post("password"),
                'password_confirmation' => $request->post("password_confirmation"),
                'token' => strip_tags(trim($request->post("token")))
            ]);

            $validator->validate([
                'password' => 'required|confirm|min:10|max:50',
                'token' => 'required'
            ]);

            $validatedData = $validator->validated();

            $statement = App\Libraries\Database::getConnection()->prepare("
                SELECT * FROM reinitialisations_de_mot_de_passe
                WHERE token = :token
            ");

            $statement->execute([
                "token" => hash('sha256', $validatedData['token']),
            ]);

            $user = $statement->fetch(\PDO::FETCH_OBJ);
            if(!$user) {
                return view('errors/page_404');
            }

            if(strtotime($user->expired_at) < time()) {
                $statement = App\Libraries\Database::getConnection()->prepare("
                    DELETE FROM reinitialisations_de_mot_de_passe
                    WHERE token = :token
                ");

                $statement->execute([
                    "token" => hash('sha256', $validatedData['token']),
                ]);

                return view('errors/token_expired');
            }

            $isUpdated = $this->{$user->type_utilisateur.'Model'}->updatePassword([
                'mdp' => $validatedData['password'],
                'email' => $user->email
            ]);

            if($isUpdated){
                $statement = App\Libraries\Database::getConnection()->prepare("
                    DELETE FROM reinitialisations_de_mot_de_passe
                    WHERE token = :token
                ");

                $statement->execute([
                    "token" => hash('sha256', $validatedData['token']),
                ]);

                flash("changePassMsg", "Votre mot de passe a été réinitialisé avec succès");
                return redirect('user/login');
            }
       
            return view('error/page_500');
        }
        return Response::json(null, 405, "Method Not Allowed");
    }

    private function createUserSession($user)
    {
        session('user')->set($user);
        if ($user->type === 'formateur') {
            if($user->is_all_info_present) {
                return redirect('formateur');
            }
            return redirect('user/continue');
        } 
        return redirect('etudiant');
    }

    private function strip_critical_tags($text)
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

    public function continue()
    {
        if(!auth()){
            return redirect('user/login');
        }

        if(!session('user')->get()->email_verified_at) {
            return redirect('user/verify');
        }

        if(session('user')->get()->type === 'formateur'){
            $request = new App\Libraries\Request;
            if(session('user')->get()->is_all_info_present == false) {
                if($request->getMethod() === 'POST') {
                    $validator = new Validator([
                        'biographie' => $this->strip_critical_tags($request->post("biography")),
                        'id_categorie' => strip_tags(trim($request->post("categorie"))),
                        'specialite' => strip_tags(trim($request->post("speciality"))),
                    ]);

                    $validator->validate([
                        'biographie' => 'required|min:15|max:700',
                        'id_categorie' => 'required|numeric|exists:categories',
                        'specialite' => 'required|min:3|max:30',
                    ], 'formateurs/continue');

                    $data = $validator->validated();
                    $data['is_all_info_present'] = true;

                    if($this->formateurModel->update($data, session('user')->get()->id_formateur)){
                        session('user')->get()->is_all_info_present = true;
                        return redirect('formateur');
                    }
                    return Response::json(null, 500, "Something went wrong, please try again later!");
                }

                return view('formateurs/continue', ['categories' => $this->stockedModel->getAllCategories()]);
            }

            return redirect('formateur');
        }
        return redirect();
    }

    public function contactUs()
    {
        $request = new App\Libraries\Request;
        if ($request->getMethod() === 'POST') {
            $validator = new Validator([
                'email' => strip_tags($request->post("email")),
                'name' => strip_tags($request->post("name")),
                'subject' => strip_tags($request->post("subject")),
                'message' => strip_tags($request->post("message")),
            ]);

            $validator->validate([
                'email' => 'required|email',
                'name' => 'required',
                'subject' => 'required',
                'message' => 'required',
            ]);

            extract($_POST);

            try {
                $mail = new App\Libraries\Mail;
                $mail->to(MAIL_FROM_ADDRESS)
                ->subject("CONTACT US : $name ($email)")
                ->body($message)
                ->send();

                return Response::json(null, 200, "Votre Message a été envoyé avec succès !");
            } catch (Exception $e) {
                // echo $mail->ErrorInfo;
                return Response::json(null, 500, "L'email n'a pas pu être envoyé.");
            }
        }

        return Response::json(null, 405, "Method Not Allowed");
    }

    public function logout()
    {    
        session()->flush();
        return redirect('user/login');
    }

    public function setUserType()
    {
        $request = new App\Libraries\Request;
        if ($request->getMethod() === 'POST') {
            $validator = new Validator([
                'user_type' => strip_tags(trim($request->post("user_type"))),
            ]);

            $validator->validate([
                'user_type' => 'required|in_array:formateur,etudiant',
            ]);

            session('user_type')->set($request->post('user_type'));
            return Response::json(null, 200, "success");
        }

        return Response::json(null, 405, "Method Not Allowed");
    }
}