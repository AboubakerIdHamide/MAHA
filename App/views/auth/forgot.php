<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title>Mot de passe oublié | <?= SITENAME ?></title>
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- Font Icons -->
    <link href="<?= CSSROOT ?>/icons/all.min.css" rel="stylesheet" />
    <!-- Styles -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/auth/forgot.css" />
</head>

<body>
    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div>
    <!-- End Preload -->
    <div class="container">
        <form method="post" id="forgot-form" class="wrapper">
            <h1 class="logo">
                <a href="<?= URLROOT ?>">
                    <img src="<?= LOGO ?>" alt="logo maha">
                </a>
            </h1>
            <div>
                <h4>Réinitialiser le mot de passe</h4>
                <p>Entrez votre adresse e-mail et nous vous enverrons un e-mail avec des instructions pour réinitialiser votre mot de passe.</p>
                <div id="message" style="font-size: 14px;text-align: center"></div>
            </div>
            <div class="resent-container mb-3" style="display: none">
                <span id="timer"></span>
                <small>S'il vous plaît, attendez...</small>
            </div>
            <div class="form-group">
                <input type="email" id="email" name="email" class="form-control" placeholder="Adresse e-mail" />
            </div>
            <button class="btn_1 full-width" id="reset" type="submit">Envoyer le lien de réinitialisation</button>
        </form>
    </div>
    <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>
    <script>const URLROOT = `<?= URLROOT ?>`;</script>
    <script src="<?= JSROOT ?>/auth/forgot.js"></script>
</body>

</html>