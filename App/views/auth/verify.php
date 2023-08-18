<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title>Vérification d'email | <?= SITENAME ?></title>
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- Styles -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/auth/forgot.css" />
</head>

<body>
    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div>
    <!-- End Preload -->
    <div class="container">
        <div class="wrapper">
            <h1 class="logo mb-3">
                <a href="<?= URLROOT ?>">
                    <img src="<?= LOGO ?>" alt="logo maha">
                </a>
            </h1>
            <div>
                <h4>Merci de consulter vos emails</h4>
                <div>Un e-mail a été envoyé à <span class="fw-bolder"><?= session('email')->get() ?></span>.Veuillez rechercher un e-mail de la société et cliquez sur le lien inclus pour Vérifiez votre compte.</div>
                <div id="message" style="font-size: 14px;text-align: center"></div>
            </div>
            <div class="resent-container mb-3" style="display: none">
                <span id="timer"></span>
                <small>S'il vous plaît, attendez...</small>
            </div>
            <button class="btn_1 full-width" id="resend" type="button">Renvoyer</button>
        </div>
    </div>

    <!-- Logout -->
    <a href="<?= URLROOT ?>/user/logout" id="logout" class="btn_1 rounded"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>

    <!-- Scripts -->
    <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>
    <script src="<?= JSROOT ?>/auth/forgot.js"></script>
</body>

</html>