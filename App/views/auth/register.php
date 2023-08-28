<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title>Inscrivez-vous et commencez à apprendre | <?= SITENAME ?></title>
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/bootstrap.min.css" />
    <!-- Font Icons -->
    <link href="<?= CSSROOT ?>/icons/all.min.css" rel="stylesheet" />
    <!-- Style -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/auth/register.css" />
    <style>
        #register_bg {
            background: url(<?= URLROOT ?>/public/images/banner_home.jpg) center center no-repeat fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
</head>

<body id="register_bg">
    <div id="register">
        <aside>
            <figure>
                <a href="<?= URLROOT ?>"><img src="<?= LOGO ?>" width="149" height="42" alt="logo maha"></a>
            </figure>
            <form method="POST" id="register-form">
                <div class="form-group">
                    <div class="d-flex gap-3 flex-column flex-lg-row">
                        <div class="flex-item">
                            <span class="input">
                    <input class="input_field" type="text" id="nom" name="nom" />
                        <label class="input_label">
                        <span class="input__label-content">Nom</span>
                    </label>
                    </span>
                    <small class="error-message" id="error-nom"><?= $nom_error ?? '' ?></small>
                        </div>

                        <div class="flex-item">
                             <span class="input">
                    <input class="input_field" type="text" id="prenom" name="prenom" />
                        <label class="input_label">
                        <span class="input__label-content">Prénom</span>
                    </label>
                    </span>
                    <small class="error-message" id="error-prenom"><?= $prenom_error ?? '' ?></small>
                        </div>
                   
                    </div>

                    <span class="input">
                    <input class="input_field" type="email" id="email" name="email" />
                        <label class="input_label">
                        <span class="input__label-content">Email</span>
                    </label>
                    </span>
                    <small class="error-message" id="error-email"><?= $email_error ?? '' ?></small>

                    <div class="d-flex gap-3 flex-column flex-lg-row mb-3">
                        <div class="flex-item">
                            <span class="input">
                    <input class="input_field" type="password" id="mdp" name="mdp" />
                        <label class="input_label">
                        <span class="input__label-content">Mot de passe</span>
                    </label>
                    </span>
                    <small class="error-message" id="error-mdp"><?= $password_error ?? '' ?></small>
                        </div>

                    <div class="flex-item">
                        <span class="input">
                    <input class="input_field" type="password" id="vmdp" name="vmdp" />
                        <label class="input_label">
                        <span class="input__label-content">Confirmer le mot de passe</span>
                    </label>
                    </span>
                    <small class="error-message" id="error-vmdp"></small>
                    </div>
                    
                    </div>
                </div>
                <div class="mb-2 user-types">
                    <label style="color: #999">Veuillez choisir entre les deux options suivantes:</label>
                    <div class="radio-tile-group">
                        <div class="input-container w-50">
                          <input id="etudiant" class="radio-button" type="radio" name="type" value="etudiant" />
                          <div class="radio-tile">
                            <div class="icon">
                              <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <label for="drive" class="radio-tile-label">Etudiant</label>
                          </div>
                        </div>

                        <div class="input-container w-50">
                          <input id="formateur" class="radio-button" type="radio" name="type" value="formateur" />
                          <div class="radio-tile">
                            <div class="icon">
                              <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                            <label for="fly" class="radio-tile-label">Formateur</label>
                          </div>
                        </div>
                    </div>
                    <small class="error-message d-inline-block text-center" id="error-type"><?= $type_error ?? '' ?></small>
                </div>

                <button id="register-btn" class="btn_1 rounded full-width">S'inscrire</button>
                <div class="text-center mt-3">Vous avez déjà un compte? <strong><a href="<?= URLROOT ?>/user/login">Se connecter</a></strong></div>
            </form>
            <div class="copy">© 2023 MAHA</div>
        </aside>
    </div>
    <!-- /login -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/classie.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>
    <script src="<?= JSROOT ?>/auth/register.js"></script>
</body>

</html>