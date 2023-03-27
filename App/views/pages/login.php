<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo SITENAME?></title>

    <!-- Bootstrap -->
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/> -->
    <!-- Style -->
    <link rel="stylesheet" href="<?php echo URLROOT."/Public/css/mahaAlert.css";?>"/>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/public/css/login.css"/>

  </head>
  <body>
    <div class="container">
      <div class="form login">
        <div class="main-form-heading">
          <h1 class="logo">
            <a href="<?php echo URLROOT."/pages/index"?>" class="l">M<span>A</span>H<span>A</span></a>
          </h1>
        </div>
        <?php flash("changePassMsg");?>
        <?php flash("signupMsg");?>
        <form class="mainForm" action="" method="post">
          <div class="field">
            <label for="email">Email</label>
            <div class="input-field">
              <input type="text" id="email" name="email"  value="<?php echo $data["email"];?>"/>
              <i class="fa-solid fa-envelope"></i>
            </div>
            <span class="error" id="error-email"><?php echo $data["email_err"];?></span>
          </div>

          <div class="field">
            <label for="mdp">Mot De Passe</label>
            <div class="input-field">
              <input type="password" name="password" id="password" value="<?php echo $data["password"];?>"/>
              <i class="fa-solid fa-lock"></i>
              <i class="fa-solid fa-eye" id="togglePassword"></i>
            </div>
            <span class="error" id="error-mdp"><?php echo !empty($data["password_err"])? $data["password_err"]:"";?></span>
            <div class="checkbox-text">
              <div class="checkbox-content">
                <input type="checkbox" id="logCheck" name="rememberMe" <?php echo isset($_COOKIE["useremail"])?"checked":"";?>/>
                <label for="logCheck">se souvenir de moi</label>
              </div>

              <a href="<?=  URLROOT?>/users/forgotPassword" class="text">Mot de passe oublié ?</a>
            </div>

            <div class="input-field button">
              <input type="submit" value="S'identifier" />
            </div>
          </div>
        </form>
        <div class="login-signup">
          <span class="text">
            Pas un membre?
            <a href="<?php echo URLROOT;?>/users/register" class="text signup-text">S'inscrire</a>
          </span>
        </div>
      </div>
    </div>
    <script src="<?php echo URLROOT;?>/public/js/login.js"></script>
  </body>
</html>
