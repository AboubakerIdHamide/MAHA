<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= SITENAME ?> | Admin</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/bootstrap.min.css" />
    <!-- Font Icons -->
    <link href="<?= CSSROOT ?>/icons/all.min.css" rel="stylesheet" />
    <!-- Style -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/mahaAlert.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/login.css" />
</head>

<body>
    <div class="container">
        <div class="form login">
            <div class="main-form-heading">
                <h1 class="logo">
                    <a href="<?= URLROOT ?>/page">
                        <img src="<?= IMAGEROOT ?>/MAHA.png" alt="logo platform">
                    </a>
                </h1>
                <span class="badge bg-primary fs-6">Admin</span>
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
                    <div class="input-field button">
                        <input type="submit" value="S'identifier" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="<?= JSROOT ?>/login.js"></script>
</body>

</html>