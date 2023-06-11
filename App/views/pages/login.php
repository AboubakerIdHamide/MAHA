<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= URLROOT . '/public' ?>/images/favicon.ico">
    <title><?= SITENAME ?> | Login</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/bootstrap.min.css" />
    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Style -->
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/mahaAlert.css"; ?>" />
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/login.css" />

</head>

<body>
    <div class="container">
        <div class="form login">
            <div class="login-type">
                <h3>connexion</h3>
                <button type="button" id="maha-login" class="maha"><i class="fa fa-arrow-right-to-bracket"></i>MAHA</button>
                <button type="button" id="facebook-login" class="facebook"><i class="fa-brands fa-facebook"></i>
                    Facebook</button>
                <button type="button" id="google-login" class="google"><i class="fa-brands fa-google-plus-g"></i>
                    Google</button>
                <small class="connection-error"></small>
            </div>
            <div class="maha-fields hide">
                <div class="main-form-heading">
                    <h1 class="logo">
                        <a href="<?= URLROOT . "/pages/index"; ?>">
                            <img src="<?= URLROOT . '/Public/images/MAHA.png' ?>" alt="">
                        </a>
                    </h1>
                </div>
                <?php flash("changePassMsg"); ?>
                <?php flash("signupMsg"); ?>
                <form class="mainForm" action="" method="post">
                    <div class="field">
                        <label for="email">Email</label>
                        <div class="input-field">
                            <input type="text" id="email" name="email" value="<?= $data["email"]; ?>" />
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <span class="error" id="error-email"><?= $data["email_err"]; ?></span>
                    </div>

                    <div class="field">
                        <label for="mdp">Mot De Passe</label>
                        <div class="input-field">
                            <input type="password" name="password" id="password" value="<?= $data["password"]; ?>" />
                            <i class="fa-solid fa-lock"></i>
                            <i class="fa-solid fa-eye" id="togglePassword"></i>
                        </div>
                        <span class="error" id="error-mdp"><?= !empty($data["password_err"]) ? $data["password_err"] : ""; ?></span>
                        <div class="checkbox-text">
                            <div class="checkbox-content">
                                <input type="checkbox" id="logCheck" name="rememberMe" <?= isset($_COOKIE["useremail"]) ? "checked" : ""; ?> />
                                <label for="logCheck">se souvenir de moi</label>
                            </div>
                            <a href="<?= URLROOT ?>/users/forgotPassword" class="text">Mot de passe oublié ?</a>
                        </div>

                        <div class="input-field button">
                            <input type="submit" value="S'identifier" />
                        </div>
                    </div>
                </form>
                <div class="login-signup">
                    <span class="text">
                        Pas un membre?
                        <a href="<?= URLROOT; ?>/users/register" class="text signup-text">S'inscrire</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="<?= URLROOT; ?>/public/js/login.js"></script>
</body>

</html>