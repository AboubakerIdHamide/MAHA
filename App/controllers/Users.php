<?php
// PHP Mailler Classes Autolader
require_once './../vendor/autoload.php';

// PHP Mailler Classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Users extends Controller
{
    public function __construct()
    {
        $this->fomateurModel = $this->model("Formateur");
        $this->etudiantModel = $this->model("Etudiant");
        $this->stockedModel = $this->model("Stocked");
    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        if ($this->isLoggedIn()) {
            if ($this->isLoggedIn() == 'formateur') {
                redirect('formateurs/dashboard');
            } else {
                redirect('etudiants/dashboard');
            }
        }

        // Checking If The User Submit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST["rememberMe"]) && $_POST["rememberMe"] == "on") {
                setcookie("useremail", $_POST["email"], time() + 2592000);
                setcookie("userpw", $_POST["password"], time() + 2592000);
            } else {
                setcookie("useremail", $_POST["email"], time() + 10);
                setcookie("userpw", $_POST["password"], time() + 10);
            }

            $data = [
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'email_err' => '',
                'password_err' => '',
            ];

            // Validate Data
            if (filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                if (!preg_match_all("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $data["email"])) {
                    $data["email_err"] = "L'e-mail inséré est invalide";
                }
            } else {
                $data["email_err"] = "L'e-mail inséré est invalide";
            }


            // Shecking If That User Exists
            $user = $this->etudiantModel->getEtudiantByEmail($data["email"]);
            if (empty($user)) {
                $user = $this->fomateurModel->getFormateurByEmail($data["email"]);
                if (!empty($user)) {
                    if (password_verify($data["password"], $user["mot_de_passe"])) {
                        $user["type"] = "formateur";
                        $this->createUserSessios($user);
                    } else {
                        $data["password_err"] = "Mot de passe incorrect";
                    }
                } else {
                    $data["email_err"] = "Aucun utilisateur avec cet email";
                }
            } else {
                if (password_verify($data["password"], $user["mot_de_passe"])) {
                    $user["type"] = "etudiant";
                    $this->createUserSessios($user);
                } else {
                    $data["password_err"] = "Mot de passe incorrect";
                }
            }
            if (empty($user) || !empty($data["password_err"]) || !empty($data["email_err"])) {
                $this->view("pages/login", $data);
            }
        } else {
            $data = [
                'email' => "",
                'password' => "",
                'email_err' => "",
                'password_err' => "",
            ];
            if (isset($_COOKIE["useremail"]) && isset($_COOKIE["userpw"])) {
                $data["email"] = $_COOKIE["useremail"];
                $data["password"] = $_COOKIE["userpw"];
            }

            $this->view("pages/login", $data);
        }
    }

    public function register()
    {
        // all categories
        $categories = $this->stockedModel->getAllCategories();

        // Checking If The User Submit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Prepare Data
            $data = [
                "nom" => trim($_POST["nom"]),
                "prenom" => trim($_POST["prenom"]),
                "email" => trim($_POST["email"]),
                "img" => $_FILES["photo"],
                "tel" => trim($_POST["tele"]),
                "mdp" => $_POST["mdp"],
                "vmdp" => $_POST["vmdp"],
                "type" => $_POST["type"],
                "pmail" => trim($_POST["pmail"]),
                "specId" => trim($_POST["specialite"]),
                "bio" => trim($_POST["biography"]),
                "nom_err" => "",
                "prenom_err" => "",
                "email_err" => "",
                "img_err" => "",
                "tel_err" => "",
                "mdp_err" => "",
                "vmdp_err" => "",
                "pmail_err" => "",
                "specId_err" => "",
                "bio_err" => "",
                "thereIsError" => false,
            ];

            // Upload The Image In Our Server
            $data = $this->uploadImage($data);

            // Validate Data
            $data = $this->validateData($data);

            // Checking If There Is An Error
            if ($data["thereIsError"] == true) {
                $this->view("pages/register", [$data, $categories]);
            } else {
                // Hashing Password
                $data["mdp"] = password_hash($data["mdp"], PASSWORD_DEFAULT);

                // Generating Verification Email Code
                if (isset($_SESSION["vcode"])) {
                    $verification_code = $_SESSION["vcode"];
                } else {
                    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                    $_SESSION["vcode"] = $verification_code;
                    $_SESSION["resend"] = true;
                }

                // To Email Verification
                $_SESSION["user_data"] = $data;
                redirect("users/verifyEmail");
            }
        } else {
            $data = [
                "nom" => "",
                "prenom" => "",
                "email" => "",
                "img" => "",
                "tel" => "",
                "mdp" => "",
                "vmdp" => "",
                "type" => "",
                "pmail" => "",
                "specId" => "",
                "bio" => "",
                "nom_err" => "",
                "prenom_err" => "",
                "email_err" => "",
                "img_err" => "",
                "tel_err" => "",
                "mdp_err" => "",
                "vmdp_err" => "",
                "pmail_err" => "",
                "specId_err" => "",
                "bio_err" => "",
            ];
            $this->view("pages/register", [$data, $categories]);
        }
    }

    public  function verifyEmail()
    {
        // redirect if there isn't a verification code
        if (!isset($_SESSION["vcode"])) {
            redirect("pages/index");
        }

        // preparing data
        $data = [$_SESSION["user_data"], ["code" => "", "code_err" => ""]];

        // checking Post Data
        if (isset($_POST["code"])) {
            // if the code valide insert user
            if ($_POST["code"] == $_SESSION["vcode"]) {
                // Insert The User 
                if ($data[0]["type"] == "formateur") {
                    $this->fomateurModel->insertFormateur($data[0]);
                } else {
                    $this->etudiantModel->insertEtudiant($data[0]);
                }
                unset($_SESSION["vcode"]);
                unset($_SESSION["resend"]);
                unset($_SESSION["user_data"]);
                flash("signupMsg", "Félicitations, votre compte a été créé avec succès.", "alert alert-primary");
                redirect("users/login");
            } else {
                $data[1]["code"] = $_POST["code"];
                $data[1]["code_err"] = "Code invalide";
                $this->view("pages/emailVerification", $data);
            }


            if (isset($_POST["resend"]) && $_POST["resend"] == true) {
                $_SESSION["resend"] = true;
            }
        } else {
            $this->view("pages/emailVerification", $data);
        }

        // send Email Verification
        if (isset($_SESSION["vcode"]) == true && $_SESSION["resend"] == true) {
            $email = $this->model("Smtp")->getSmtp()['username'];
            $this->sendEmail($data[0]["email"], $email, 'MAHA', 'Email vérification', null, $data[0]["prenom"], $_SESSION["vcode"], URLROOT . "/pages/verifyEmail");
            $_SESSION["resend"] = false;
        }
    }

    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                "email" => trim($_POST["email"]),
                "mdp" => $_POST["mdp"],
                "vmdp" => $_POST["vmdp"],
                "email_err" => "",
                "mdp_err" => "",
                "vmdp_err" => ""
            ];

            // Validate Email
            if (filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                if (!preg_match_all("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $data["email"])) {
                    $data["email_err"] = "L'e-mail inséré est invalide";
                }
            } else {
                $data["email_err"] = "L'e-mail inséré est invalide";
            }
            // Validate Password
            if (empty($data["mdp"])) {
                $data["mdp_err"] = "Le mot de passe doit comporter au moins 10 caractères";
            }
            if (strlen($data["mdp"]) > 50) {
                $data["mdp_err"] = "Le mot de passe doit comporter au maximum 50 caractères";
            }
            if ($data["mdp"] != $data["vmdp"]) {
                $data["vmdp"] = "Les deux mots de passe doivent être identiques";
            }

            // Shecking If That User Exists
            $user = $this->etudiantModel->getEtudiantByEmail($data["email"]);
            if (empty($user)) {
                $user = $this->fomateurModel->getFormateurByEmail($data["email"]);
                if (!empty($user)) {
                    if (empty($data["mdp_err"]) && empty($data["vmdp_err"])) {
                        $_SESSION["changePasswordData"] = $data;
                        $_SESSION["type"] = "formateur";
                        redirect("users/changePassword");
                    }
                } else {
                    $data["email_err"] = "Aucun utilisateur avec cet email";
                }
            } else {
                if (empty($data["mdp_err"]) && empty($data["vmdp_err"])) {
                    $_SESSION["changePasswordData"] = $data;
                    $_SESSION["type"] = "etudiant";
                    redirect("users/changePassword");
                }
            }

            if (empty($user) || !empty($data["mdp_err"]) || !empty($data["email_err"]) || !empty($data["vmdp_err"])) {
                $this->view("pages/forgotpassword", $data);
            }
        } else {
            $data = [
                "email" => "",
                "mdp" => "",
                "vmdp" => "",
                "email_err" => "",
                "mdp_err" => "",
                "vmdp_err" => ""
            ];
            $this->view("pages/forgotpassword", $data);
        }
    }

    public function changePassword()
    {
        // redirect if there isn't a data
        if (!isset($_SESSION["changePasswordData"])) {
            redirect("pages/index");
        }

        // prepare data
        $data = [$_SESSION["changePasswordData"], ["code" => "", "code_err" => ""]];

        // Generating Verification Email Code
        if (isset($_SESSION["vcode"])) {
            $verification_code = $_SESSION["vcode"];
        } else {
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $_SESSION["vcode"] = $verification_code;
            $_SESSION["resend"] = true;
        }

        // checking for post data
        if (isset($_POST["code"])) {
            // if the code valide update password
            if ($_POST["code"] == $_SESSION["vcode"]) {
                // hach the new password
                $data[0]["mdp"] = password_hash($data[0]["mdp"], PASSWORD_DEFAULT);

                // Upadte The Password
                if ($_SESSION["type"] == "formateur") {
                    $this->fomateurModel->updateFormateurPasswordByEmail($data[0]);
                } else {
                    $this->etudiantModel->updateEtudiantPasswordByEmail($data[0]);
                }

                unset($_SESSION["vcode"]);
                unset($_SESSION["resend"]);
                unset($_SESSION["changePasswordData"]);
                flash("changePassMsg", "votre mot de passe changer avec succès.", "alert alert-primary");
                redirect("users/login");
            } else {
                $data[1]["code"] = $_POST["code"];
                $data[1]["code_err"] = "Code invalide";
                $this->view("pages/emailVerification", $data);
            }


            if (isset($_POST["resend"]) && $_POST["resend"] == true) {
                $_SESSION["resend"] = true;
            }
        } else {
            $this->view("pages/emailVerification", $data);
        }

        // send Email Change Password
        if (isset($_SESSION["vcode"]) == true && $_SESSION["resend"] == true) {
            $email = $this->model("Smtp")->getSmtp()['username'];
            $this->sendEmail($data[0]["email"], $email, 'MAHA', 'Email vérification', null, '', $_SESSION["vcode"], URLROOT . "/pages/changePassword");
            $_SESSION["resend"] = false;
        }
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['id_formateur'])) {
            return 'formateur';
        } else if (isset($_SESSION['id_etudiant'])) {
            return 'etudiant';
        }
        return false;
    }

    public function createUserSessios($user)
    {
        if ($user['type'] == 'formateur') {
            $_SESSION['id_formateur'] = $user['id_formateur'];
            $_SESSION['user'] = $user;
            // setting up the image link
            $_SESSION['user']['avatar'] = URLROOT . "/Public/" . $_SESSION['user']['avatar'];
            redirect('formateurs/dashboard');
        } else {
            $_SESSION['id_etudiant'] = $user['id_etudiant'];
            $_SESSION['user'] = $user;
            // setting up the image link
            $_SESSION['user']['avatar'] = URLROOT . "/Public/" . $_SESSION['user']['avatar'];
            redirect('etudiants/dashboard');
        }
    }

    private function sendEmail($to, $from, $name, $subject, $message, $destinataire, $code, $link)
    {
        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $smtp = $this->model("Smtp")->getSmtp();
        try {
            //Enable verbose debug output
            $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

            //Send using SMTP
            $mail->isSMTP();

            //Set the SMTP server to send through => 'smtp.gmail.com'
            $mail->Host = $smtp['host'];

            //Enable SMTP authentication
            $mail->SMTPAuth = true;

            //SMTP username => 'mahateamisgi@gmail.com'
            $mail->Username = $smtp['username'];

            //SMTP password => 'fmllrxzwfsrovexr'
            $mail->Password = $smtp['password'];

            //Enable TLS encryption;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port = $smtp['port'];

            //Recipients
            $mail->setFrom($from, $name);

            //Add a recipient
            $mail->addAddress($to);

            //Set email format to HTML
            $mail->isHTML(true);
            $mail->Subject = "$from ($subject)";
            if ($name === 'MAHA') {
                $mail->Body    = '<p>Salut ' . $destinataire . '</p>
                <p>Votre code de vérification est : <b style="font-size: 30px;color:#06283D;">' . $code . '</b><br/>
                Entrez ce code <a href="' . $link . '" style="color:#47B5FF;">ici</a> pour vérifier votre identité .</p>
                <p>Par l\'equipe de <span style="font-size:18px;color:#47B5FF;">M<span style="color:#06283D;">A</span>H<span style="color:#06283D;">A</span></span> .</p>';
            } else {
                $mail->Body = '<p>Bonjour ' . $destinataire . ',</p>
                <p>' . $message . '</p>';
            }

            // send it
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            die;
        }
    }

    public function contactUs()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            $username = $this->model("Smtp")->getSmtp()['username'];
            $this->sendEmail($username, $email, $name, $subject, $message, 'MAHA', null, null);
            echo "Votre Message a ete envoyer avec success !";
        }
    }

    public function logout()
    {
        session_destroy();
        redirect('users/login');
    }

    private function validateData($data)
    {
        // Validate Nom & Prenom
        if (strlen($data["nom"]) < 3) {
            $data["thereIsError"] = true;
            $data["nom_err"] = "Le nom doit comporter au moins 3 caractères";
        }
        if (strlen($data["prenom"]) < 3) {
            $data["thereIsError"] = true;
            $data["prenom_err"] = "Le prenom doit comporter au moins 3 caractères";
        }
        if (strlen($data["nom"]) > 30) {
            $data["thereIsError"] = true;
            $data["nom_err"] = "Le nom doit comporter au maximum 30 caractères";
        }
        if (strlen($data["prenom"]) > 30) {
            $data["thereIsError"] = true;
            $data["prenom_err"] = "Le prenom doit comporter au maximum 30 caractères";
        }

        // Validate Email
        if (filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            if (!preg_match_all("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $data["email"])) {
                $data["thereIsError"] = true;
                $data["email_err"] = "L'e-mail inséré est invalide";
            }
        } else {
            $data["thereIsError"] = true;
            $data["email_err"] = "L'e-mail inséré est invalide";
        }
        if (!empty($this->etudiantModel->getEtudiantByEmail($data["email"]))) {
            $data["thereIsError"] = true;
            $data["email_err"] = "Adresse e-Mail déjà utilisée";
        }
        if (!empty($this->fomateurModel->getFormateurByEmail($data["email"]))) {
            $data["thereIsError"] = true;
            $data["email_err"] = "Adresse e-Mail déjà utilisée";
        }



        // Validate Tele
        if (!preg_match_all("/^((06|07)\d{8})+$/", $data["tel"])) {
            $data["thereIsError"] = true;
            $data["tel_err"] = "Le numéro de telephone que vous saisi est invalide";
        }

        // Validate Password
        if (preg_match_all("/[!@#$%^&*()\-__+.]/", $data["mdp"])) {
            if (preg_match_all("/\d/", $data["mdp"])) {
                if (!preg_match_all("/[a-zA-Z]/", $data["mdp"])) {
                    $data["thereIsError"] = true;
                    $data["mdp_err"] = "Le mot de passe doit contenir au moins 1 lettre";
                }
            } else {
                $data["thereIsError"] = true;
                $data["mdp_err"] = "Le mot de passe doit contenir au moins 1 chiffres";
            }
        } else {
            $data["thereIsError"] = true;
            $data["mdp_err"] = "Le mot de passe doit contient spécial character";
        }
        if (strlen($data["mdp"]) > 50) {
            $data["thereIsError"] = true;
            $data["mdp_err"] = "Le mot de passe doit comporter au maximum 50 caractères";
        }
        if (strlen($data["mdp"]) < 10) {
            $data["thereIsError"] = true;
            $data["mdp_err"] = "Le mot de passe doit comporter au moins 10 caractères";
        }
        if ($data["mdp"] != $data["vmdp"]) {
            $data["thereIsError"] = true;
            $data["mdp_err"] = "Les deux mots de passe doivent être identiques";
        }


        // Validate Type
        if ($data["type"] != "formateur" && $data["type"] != "etudiant") {
            $data["thereIsError"] = true;
            $data["img_err"] = "Type Invalide";
        }

        // Validate Other Info If UserType Is Formateur
        if ($data["type"] == "formateur") {
            // Validate  Paypal Email
            if (filter_var($data["pmail"], FILTER_VALIDATE_EMAIL)) {
                if (!preg_match_all("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $data["pmail"])) {
                    $data["thereIsError"] = true;
                    $data["pmail_err"] = "L'e-mail inséré est invalide";
                }
            } else {
                $data["thereIsError"] = true;
                $data["pmail_err"] = "L'e-mail inséré est invalide";
            }
            if (!empty($this->fomateurModel->getFormateurByPaypalEmail($data["pmail"]))) {
                $data["thereIsError"] = true;
                $data["pmail_err"] = "Adresse e-Mail de Paypal déjà utilisée";
            }


            // Validate Biography
            if (strlen($data["bio"]) > 500) {
                $data["thereIsError"] = true;
                $data["bio_err"] = "La Biography doit comporter au maximum 500 caractères";
            }
            if (strlen($data["bio"]) < 130) {
                $data["thereIsError"] = true;
                $data["bio_err"] = "Le résumé doit avoir au moins 130 caractères";
            }

            // Validate Specialité
            if (empty($this->stockedModel->getCategorieById($data["specId"]))) {
                $data["thereIsError"] = true;
                $data["specId_err"] = "Spécialité Invalide";
            }
        }

        return $data;
    }

    private  function uploadImage($data)
    {
        $file = $data["img"]; // Image Array
        $fileName = $file["name"]; // name
        $fileTmpName = $file["tmp_name"]; // location
        $fileError = $file["error"]; // error

        if (!empty($fileTmpName)) {
            $fileExt = explode(".", $fileName);
            $fileRealExt = strtolower(end($fileExt));
            $allowed = array("jpg", "jpeg", "png");


            if (in_array($fileRealExt, $allowed)) {
                if ($fileError === 0) {
                    $fileNameNew = substr(number_format(time() * rand(), 0, '', ''), 0, 5) . "." . $fileRealExt;
                    $fileDestination = 'images/userImage/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $data["img"] = $fileDestination;
                } else {
                    $data["thereIsError"] = true;
                    $data["img_err"] = "Une erreur s'est produite lors du téléchargement de votre image ";
                }
            } else {
                $data["thereIsError"] = true;
                $data["img_err"] = "Vous ne pouvez pas télécharger ce fichier uniquement (jpg | jpeg | png | ico) autorisé";
            }
        } else {
            $data["img"] = 'images/default.jpg';
        }

        return $data;
    }
}
