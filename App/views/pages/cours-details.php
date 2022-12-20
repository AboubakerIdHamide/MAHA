<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COURS - <?php echo $data['info']['nomFormation'] ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/cours-details.css" />
</head>

<body>
  <!-- Header -->
  <header>
    <div class="loding-bar"></div>
    <div class="container">
      <h1 class="logo"><a href="<?php echo URLROOT . "/pages/index" ?>">M<span>A</span>H<span>A</span></a></h1>
      <div class="burger-icon" id="menuBtn">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <ul id="navBarUl" class="hide">
        <li><a href="<?php echo URLROOT . "/#catalogue" ?>">Catalogue</a></li>
        <li><a href="<?php echo URLROOT . "/pageFormations/" ?>">Formations</a></li>
        <li class="menu-drop-down">
          <span id="dropMenu">Autre <i class='fa fa-chevron-down'></i></span>
          <ul id="droppedMenu" class="hide">
            <li><a href="<?php echo URLROOT . "/users/register" ?>">S'inscrire</a></li>
            <li><a href="<?php echo URLROOT . "/#popular" ?>">Les Plus Populaires</a></li>
            <li><a href="<?php echo URLROOT . "/#equipe" ?>">Notre équipe </a></li>
            <li><a href="<?php echo URLROOT . "/#contact" ?>">Contactez-Nous</a></li>
          </ul>
        </li>
        <li class="search-bar">
          <i class="fa fa-search" id="searchIcon"></i>
          <form action="" class="hide" id="seacrhForm"><input type="text"></form>
        </li>
        <li class="sign-in"><a href="<?php echo URLROOT . "/users/login" ?>">Se Connecter</a></li>
      </ul>
    </div>
  </header>
  <!-- Fin Header -->
  <section class="media-header">
    <div class="container mt-3">
      <div class="row">
        <div class="col-xl-3">
          <img class="img-fluid" src="<?php echo $data['info']['imgFormation']; ?>" alt="formation image">
        </div>
        <div class="col-xl-7">
          <div class="group d-flex flex-column justify-content-center">
            <h3 class="title"><?php echo $data['info']['nomFormation']; ?></h3>
            <p>Formation catégorie <span><?php echo $data['info']['categorie']; ?></span></p>
            <div class="instructor d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center gap-2">
                <img src="<?php echo $data['info']['imgFormateur']; ?>" alt="" class="formateur-img">
                <div class="instructor-info">
                  <h5><?php echo $data['info']['nomFormateur']; ?> <?php echo $data['info']['prenomFormateur']; ?></h5>
                  <p class="specialite mb-0"><?php echo $data['info']['specialite']; ?></p>
                </div>
              </div>
              <div class="voir-profil d-flex align-items-center gap-2">
                <a href="<?php echo URLROOT . "/profilFormateur/index/" . $data['info']['IdFormteur'] ?>">Voir Profil</a>
              </div>
            </div>
            <div class="mt-3 masse-h d-flex flex-row justify-content-between">
              <p><i class="fa-solid fa-clock"></i> <?php echo $data['info']['duree']; ?></p>
              <p><i class="fa-solid fa-language"></i> <?php echo $data['info']['langageFormation']; ?></p>
            </div>
          </div>
        </div>
        <div class="col-xl-2 align-self-center">
          <div class="info-plus">
            <div class="text-center mb-1 apprenants-nbr">
              <p class="nbr"><?php echo $data['info']['numbAcht']; ?></p>
              <p>Apprenants</p>
            </div>
            <div class="fomation-niveau text-center mb-1">
              <div class="level-indicator">
                <?php if ($data['info']['niveauFormation'] == 'débutant') : ?>
                  <svg width="58" height="30" viewBox="0 0 38 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#E5E5E5" d="M9 4h6v2H9zM23 4h6v2h-6z"></path>
                    <circle cx="5" cy="5" r="5" fill="#8887FF"></circle>
                    <circle fill="#E5E5E5" cx="19" cy="5" r="5"></circle>
                    <circle fill="#E5E5E5" cx="33" cy="5" r="5"></circle>
                  </svg>
                <?php endif ?>
                <?php if ($data['info']['niveauFormation'] == 'intermédiaire') : ?>
                  <svg width="58" height="30" viewBox="0 0 38 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 4h6v2H9z" fill="#8887FF"></path>
                    <path d="M23 4h6v2h-6z" fill="#E5E5E5"></path>
                    <circle cx="5" cy="5" r="5" fill="#8887FF"></circle>
                    <circle cx="19" cy="5" r="5" fill="#8887FF"></circle>
                    <circle fill="#E5E5E5" cx="33" cy="5" r="5"></circle>
                  </svg>
                <?php endif ?>
                <?php if ($data['info']['niveauFormation'] == 'avancé') : ?>
                  <svg width="58" height="30" viewBox="0 0 38 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#8887FF" d="M9 4h6v2H9zM23 4h6v2h-6z"></path>
                    <circle cx="5" cy="5" r="5" fill="#8887FF"></circle>
                    <circle fill="#8887FF" cx="19" cy="5" r="5"></circle>
                    <circle fill="#8887FF" cx="33" cy="5" r="5"></circle>
                  </svg>
                <?php endif ?>
              </div>
              <p>Niveau <?php echo $data['info']['niveauFormation']; ?></p>
            </div>
            <div class="text-center">
              <p class="nbr"><?php echo $data['info']['likes']; ?></p>
              <p>Likes</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="video-description">
    <div class="container">
      <div class="row">
        <div class="col">
          <!-- Apercu Head -->
          <section class="section-title mt-2" id="catalogue">
            <div class="container">
              <div>
                <p>Aperçu</p>
              </div>
            </div>
          </section>
          <!-- Fin Apercu Head -->
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 align-self-center">
          <div class="video-preview pt-2">
            <video src="<?= $data['previewVideo'] ?>" controls></video>
          </div>
        </div>
        <div class="col-lg-6 preview-prix">
          <p class="date-pub">Published: <?php echo $data['info']['dateCreationFormation']; ?></p>
          <div class="pay pt-3">
            <h2 class="text-center prix">$ <?php echo $data['info']['prix']; ?></h2>
            <div>
              <div id="paypal-button-container"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <!-- DESCRIPTION Head -->
          <section class="section-title mt-2" id="catalogue">
            <div class="container">
              <div>
                <h2>DESCRIPTION</h2>
                <p>À propos de cette formation</p>
              </div>
            </div>
          </section>
          <!-- Fin DESCRIPTION Head -->
        </div>
        <div class="row">
          <div class="col">
            <p class="desc"><?php echo $data['info']['description']; ?>
          </div>
        </div>
      </div>
  </section>

  <section>
    <div class="container">
      <div class="row">
        <div class="col">
          <!-- Contenu Head -->
          <section class="section-title mt-2" id="catalogue">
            <div class="container">
              <div>
                <h2>Contenu du cours</h2>
                <p><?php echo $data['numbVIdeo']['NumbVideo']; ?> leçons</p>
              </div>
            </div>
          </section>
          <!-- Fin Contenu Head -->
        </div>
      </div>
    </div>
  </section>
  <section class="playlist-formation">
    <div class="container">
      <?php foreach ($data['videos'] as $video) : ?>
        <div class="row mb-2">
          <div class="col">
            <div class="lesson d-flex justify-content-between">
              <span class="lesson-titre"><?php echo $video->IdVideo; ?>. <?php echo $video->NomVideo; ?></span>
              <span class="lesson-time"><?php echo $video->DureeVideo; ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Footer -->
  <footer class="mt-5" id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-4 footer-contact">
            <h1 class="logo"><a href="#">M<span>A</span>H<span>A</span></a></h1>
            <p>
              Boulevard de Mohammedia <br>
              QI Azli 40150<br>
              Maroc <br><br>
              <strong>Phone:</strong> (+212) 524 34 50 57<br>
              <strong>Email:</strong> info@maha.com<br>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="container d-md-flex py-4">
      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          © Copyright <strong><span>MAHA</span></strong>. All Rights Reserved
        </div>
      </div>
    </div>
  </footer>
  <!-- Fin Footer -->
  <!-- To-up Button -->
  <span class="to-top" href="#"><i class="fa fa-chevron-up"></i></span>
  <!-- To-up Button -->
  <!-- Fin Equipe -->
  <script src="jQuery/jquery-3.6.0.min.js"></script>
  <script src="<?php echo URLROOT; ?>/public/js/cours-details.js"></script>
  <!-- Sample PayPal credentials (client-id) are included -->
  <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD&intent=capture&enable-funding=venmo" data-sdk-integration-source="integrationbuilder"></script>
  <script src="<?php echo URLROOT; ?>/public/js/main.js"></script>
  <script src="<?php echo URLROOT; ?>/public/js/cours-details.js"></script>
  <script src="<?php echo URLROOT; ?>/public/js/paypal.js"></script>
</body>

</html>