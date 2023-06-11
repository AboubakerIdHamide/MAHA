<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= URLROOT . '/public' ?>/images/favicon.ico">
    <title><?= SITENAME ?> | mot de passe oublié</title>
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/register.css" ?>">
    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="maha-fields">
                <div class="main-form-heading">
                    <h1 class="logo">
                        <a href="<?= URLROOT . "/pages/index"; ?>">
                            <img src="<?= URLROOT . '/Public/images/MAHA.png' ?>" alt="">
                        </a>
                    </h1>
                </div>
                <div class="inputs-boxs-container">
                    <div class="inputs-boxs-container-slider" id="inputsSlider">
                        <div class="input-box">
                            <div class="field">
                                <label for="email">E-mail :</label>
                                <input type="email" id="email" name="email" value="<?= $data["email"] ?>">
                                <span class="error" id="error-email"><?= $data["email_err"] ?></span>
                            </div>

                            <div class="field">
                                <label for="mdp">Nouveau Mot De Passe :</label>
                                <input type="password" id="mdp" name="mdp" value="<?= $data["mdp"] ?>">
                                <span class="error" id="error-mdp"><?= $data["mdp_err"] ?></span>
                            </div>
                            <div class="field">
                                <label for="vmdp">Vérifier Mot De Passe :</label>
                                <input type="password" id="vmdp" name="vmdp" value="<?= $data["vmdp"] ?>">
                                <span class="error" id="error-vmdp"><?= $data["vmdp_err"] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-buttons">
                    <button class="next" id="submit">Envoyez</button>
                </div>
            </div>
        </form>
    </div>
    <script src="<?= URLROOT . "/Public/js/forgotpassword.js" ?>"></script>
</body>

</html>