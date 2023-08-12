<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title><?= SITENAME ?> | Vérification d'email</title>
    <link rel="stylesheet" href="<?= CSSROOT ?>/emailVerification.css" />
    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>
<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="main-form-heading">
                <h1 class="logo">
                    <a href="<?= URLROOT ?>">
                        <img src="<?= LOGO ?>" alt="logo maha">
                    </a>
                </h1>
            </div>
            <p>Vous êtes presque! Nous avons envoyé un code de vérification à <span class="user-email">
                <?= session('user_data')->get()["email"] ?></span> .</p>
            <label for="code">Entrez le code ici pour vérifier votre identité</label>
            <input type="text" id="code" placeholder="code" name="code" value="<?= $code ?>">
            <span class="error" id="error"><?= $code_err ?></span>
            <button class="submit-btn" id="sbmtBtn">Vérifier</button>
            <button class="resend-link" name="resend" value="true" id="resend">Renvoyer</button>
        </form>
    </div>
    <script src="<?= JSROOT ?>/emailVerification.js"></script>
</body>

</html>