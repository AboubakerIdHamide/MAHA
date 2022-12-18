<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Swiper JS  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.4/swiper-bundle.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- Style -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/main.css" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/profilFormateur.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');
    </style>

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
                <li><a href="#landing">Accueil</a></li>
                <li><a href="#catalogue">Catalogue</a></li>
                <li class="menu-drop-down">
                    <span id="dropMenu">Autre <i class='fa fa-chevron-down'></i></span>
                    <ul id="droppedMenu" class="hide">
                        <li><a href="<?php echo URLROOT . "/users/register" ?>">S'inscrire</a></li>
                        <li><a href="#popular">Les Plus Populaires</a></li>
                        <li><a href="#equipe">Notre équipe </a></li>
                        <li><a href="#contact">Contactez-Nous</a></li>
                        <li><a href="#">Formations</a></li>
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

<?php // echo '<pre>';print_r($data['infoFormateur']);echo '</pre>';?>

<section class="profelFormateur">

    <div class="container">
        <div class="infos">
            <div class="main-info"> 
                <h2>Formateur</h2>
                <div class="name"><?php echo $data['infoFormateur']['nomFormateur']; ?> <?php echo $data['infoFormateur']['prenomFormateur']; ?></div>
                <div class="speciel"><?php echo $data['infoFormateur']['categorie']; ?></div>
                <div class="nb-cours">
                    <span>Nombre des cours : </span>
                    <span class="val-nb-cours"><?php echo $data['numFormations']['numFormations']; ?></span>
                </div>
                <div class="nb-achter">
                    <span>Nombre des achtes :</span>
                    <span class="val-nb-achter"><?php echo $data['numAcht']['numAcht']; ?></span>
                </div>
            </div>
            <div class="autre-info">
                <div class="img">
                    <img src="<?php echo $data['infoFormateur']['img']; ?>" alt="Photo-Profel">
                </div>
                <div class="linkes">
                    <div>
                        <i class="fa-solid fa-link"></i>
                        <a href="#">Site Web</a>
                    </div>
                    <div>
                        <i class="fa-brands fa-twitter"></i>
                        <a href="#">Twitter</a>
                    </div>
                    <div>
                        <i class="fa-brands fa-linkedin"></i>
                        <a href="#">Linkedin</a>
                    </div>
                    <div>
                        <i class="fa-brands fa-facebook-f"></i>
                        <a href="#">Facbook</a>
                    </div>
                    <div>
                        <span style='font-weight:bold'>@</span>
                        <a href="#"><?php echo $data['infoFormateur']['email']; ?></a>
                    </div>
                    <div>
                        <span style='font-weight:bold'>Tel</span>
                        <a href="#"><?php echo $data['infoFormateur']['tel']; ?></a>
                    </div>
                </div>
            </div>
            <div class="description">
                    <h2>Informations personnelles</h2>
                    <p><?php echo $data['infoFormateur']['biography']; ?></p>
            </div>
        </div>
        <div class="coures">
        <h2>Mes cours</h2>
        <div class="formations">
            <?php foreach($data['courses'] as $info) : ?>
                <!-- start card -->
                <div class="card_coures">
                <a href='<?php echo URLROOT."/pageFormations/coursDetails/".$info->IdFormation?>' style='display: block; text-decoration: none;'>
                    <!-- img formation -->
                    <div class="img">
                        <img src="<?php echo $info->imgFormation; ?>" alt="photo">
                        <div class="duree">
                            <i class="fa-solid fa-clock" aria-hidden="true"></i>
                            <div class="time"><?php echo $info->duree; ?></div>
                        </div>
                    </div>
                    <!-- informations formation -->
                    <div class="info_formation">
                        <div class="categorie"><?php echo $info->categorie; ?></div>
                        <div class="prix"><?php echo $info->prix; ?></div>
                    </div>
                    <!-- name formation -->
                    <h1><?php echo $info->nomFormation; ?></h1>
                    <!-- description -->
                    <div class="description">
                        <p><?php echo $info->description; ?></p>
                    </div>
                    <div class="footer">
                        <!-- infotrmations formateur -->
                        <a href='<?php echo URLROOT."/profilFormateur/index/".$info->IdFormteur?>' style='display: block; text-decoration: none; z-index: 10;'>
                            <div class="formateur">
                                <div class="img_formateur">
                                    <img src="<?php echo $info->imgFormateur; ?>" alt="photo">
                                </div>
                                <h2><?php echo $info->nomFormateur; ?> <?php echo $info->prenomFormateur; ?></h2>
                            </div>
                        </a>
                        <!-- informations -->
                        <div class="info">
                            <div class="etd"><?php echo $info->numbAcht; ?></div>
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            <div class="likes"><?php echo $info->likes; ?></div>
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                    </div>
                </a>
                </div>
                <!-- end card -->
            <?php endforeach; ?>
        </div>
        </div>
    </div>
</section>
<!-- end page profel formateur -->
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
<script src="<?php echo URLROOT; ?>/public/jQuery/jquery-3.6.0.min.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/main.js"></script>
</body>
</html>

