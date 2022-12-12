<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo SITENAME ?></title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo URLROOT . "/Public/css/mahaAlert.css"; ?>" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/login.css" />

</head>

<body>
  <div class="container">
    <div class="form login">
      <div class="main-form-heading">
        <h1 class="logo">
          <a href="<?php echo URLROOT . "/pages/index" ?>" class="l">M<span>A</span>H<span>A</span></a>
        </h1>
        <span class="badge bg-primary fs-6">Admin</span>
      </div>
      <?php flash("changePassMsg"); ?>
      <?php flash("signupMsg"); ?>
      <form class="mainForm" action="" method="post">
        <div class="field">
          <label for="email">E-mail :</label>
          <div class="input-field">
            <input type="text" id="email" name="email" value="<?php echo $data["email"]; ?>" />
            <i class="bi bi-envelope"></i>
          </div>
          <span class="error" id="error-email"><?php echo $data["email_err"]; ?></span>
        </div>

        <div class="field">
          <label for="mdp">Mot De Passe :</label>
          <div class="input-field">
            <input type="password" name="password" id="password" value="<?php echo $data["password"]; ?>" />
            <i class="bi bi-lock"></i>
            <i class="bi bi-eye-slash" id="togglePassword"></i>
          </div>
          <span class="error" id="error-mdp"><?php echo !empty($data["password_err"]) ? $data["password_err"] : ""; ?></span>
          <div class="input-field button">
            <input type="submit" value="S'identifier" />
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="<?php echo URLROOT; ?>/public/js/login.js"></script>
</body>

</html>