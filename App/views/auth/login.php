<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title>Connectez-vous et commencez à apprendre | <?= SITENAME ?></title>
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/bootstrap.min.css" />
    <!-- Font Icons -->
    <link href="<?= CSSROOT ?>/icons/all.min.css" rel="stylesheet" />
    <!-- Style -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/auth/login.css" />
    <style>
        #login_bg {
            background: url(<?= URLROOT ?>/public/images/banner_home.jpg) center center no-repeat fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            min-height: 100vh;
            width: 100%;
        }
    </style>
</head>
<body id="login_bg">
    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div>
    <!-- End Preload -->
    
    <div id="login">
        <aside>
            <figure>
                <a href="<?= URLROOT ?>"><img src="<?= LOGO ?>" width="149" height="42" alt="logo maha"></a>
            </figure>
              <form id="login-form" method="POST">
                <div class="access_social">
                    <a id="linkedin" href="<?= URLROOT ?>/user/login?provider=LinkedIn" class="social_bt linkedin">Connexion avec LinkedIn</a>
                    <a id="google" href="<?= URLROOT ?>/user/login?provider=Google" class="social_bt google">Connexion avec Google</a>
                    <a id="twitter" href="<?= URLROOT ?>/user/login?provider=Twitter" class="social_bt twitter">Connexion avec Twitter</a>
                </div>
                <div class="divider"><span>Ou</span></div>
                <div class="form-group mb-3">
                    <?php flash("changePassMsg") ?>
                    <?php flash("signupMsg") ?> 
                    <span class="input">
                        <input id="email" class="input_field" type="email" name="email" value="<?= old('email') ?>"  />
                        <label class="input_label <?= isset($email_error) ? 'input_error' : '' ?>">
                            <span class="input__label-content">Email</span>
                        </label>
                    </span>
                    <small class="error-message" id="error-email"><?= $email_error ?? '' ?></small>
                    <span class="input">
                        <input id="password" class="input_field" type="password" name="mdp" />
                            <label class="input_label">
                            <span class="input__label-content">Mot De Passe</span>
                            </label>
                        <i class="fa-solid fa-eye toggle-eye"></i>
                    </span>
                    <small class="error-message" id="error-mdp"><?= $password_error ?? '' ?></small>
                    <div class="mt-2">
                        <small><a href="<?= URLROOT ?>/user/forgot">Mot de passe oublié?</a></small>
                    </div>
                </div>
                <button id="btn-login" class="btn_1 rounded full-width">Se connecter</button>
                <div class="text-center mt-3">Vous n'avez pas de compte? <strong><a href="<?= URLROOT ?>/user/register">Inscrivez-vous</a></strong></div>
            </form>
            <div class="copy">© 2023 MAHA</div>
        </aside>
    </div>
    
    <!-- Scripts -->
    <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/classie.js"></script>
    <script src="<?= JSROOT ?>/auth/login.js"></script> 
</body>

</html>