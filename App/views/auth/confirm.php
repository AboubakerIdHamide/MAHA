<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title>Email Confirmed | <?= SITENAME ?></title>
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
                <h4 class="my-3"><i class="fa-regular fa-circle-check" style="color: #25d45a;font-size: 5rem"></i></h4>
                <div class="text-center">
                    <p class="fw-bolder">Toutes nos félicitations!</p> 
                    Votre adresse e-mail a été vérifiée avec succès.
                </div>
            </div>
            <a href="<?= URLROOT ?>/<?= session('user')->get()->type ?>" class="btn_1 full-width">aller au DASHBOARD</a>
        </div>
    </div>
    <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>
    <script src="<?= JSROOT ?>/auth/forgot.js"></script>
</body>

</html>