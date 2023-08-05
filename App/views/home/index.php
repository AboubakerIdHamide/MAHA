<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Maha a modern educational site" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title>Cours en ligne - Apprenez ce que vous voulez, à votre rythme | <?= SITENAME ?></title>
    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- BASE CSS -->
    <link href="<?= CSSROOT ?>/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/style.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/vendors.css" rel="stylesheet" />
    <style>
        .hero_single.version_2:before {
            background: url("<?= $theme->landingImg ?>") center center no-repeat;
        }

        @media (max-width: 575px) {
          #custom-search-input input[type="submit"] {
            text-indent: -999px;
            background: #92278f url(<?= URLROOT ?>/images/home/search.svg) no-repeat center center;
          }
        }
    </style>
</head>

<body>
    <div id="page" class="theia-exception">
        <header class="header menu_2">
            <div id="preloader">
                <div data-loader="circle-side"></div>
            </div><!-- /Preload -->
            <div id="logo">
                <a href="<?= URLROOT ?>"><img class="logo" src="<?= $theme->logo ?>" width="149" height="42" alt="logo Maha"></a>
            </div>
            <ul id="top_menu">
                <li><a href="javascript:void(0)" class="search-overlay-menu-btn">Search</a></li>
                <?php if (!isset($_SESSION['user'])) : ?>
                    <li class="hidden_tablet"><a href="<?= URLROOT . "/user/login" ?>" class="btn_1 rounded">Se Connecter</a></li>
                <?php endif ?>
                <?php if (isset($_SESSION['id_formateur'])) : ?>
                    <li class="hidden_tablet"><a href="<?= URLROOT . "/formateur/dashboard" ?>" class="btn_1 rounded">Dashboard</a>
                    </li>
                <?php endif ?>
                <?php if (isset($_SESSION['id_etudiant'])) : ?>
                    <li class="hidden_tablet"><a href="<?= URLROOT . "/etudiant/dashboard" ?>" class="btn_1 rounded">Mes Cours</a>
                    </li>
                <?php endif ?>

            </ul>
            <!-- /top_menu -->
            <a href="#menu" class="btn_mobile">
                <div class="hamburger hamburger--spin" id="hamburger">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </a>
            <nav id="menu" class="main-menu">
                <ul>
                    <li><span><a href="<?= URLROOT ?>">Accueil</a></span></li>
                    <li><span><a href="<?= URLROOT ?>/courses/search">Formations</a></span></li>
                    <li><span><a href="<?= URLROOT ?>/#contact-us">Contactez-nous</a></span></li>
                    <?php if (!isset($_SESSION['user'])) : ?>
                        <li class="d-lg-none"><a href="<?= URLROOT . "/user/login" ?>">Se Connecter</a></li>
                    <?php endif ?>
                    <?php if (isset($_SESSION['id_formateur'])) : ?>
                        <li class="d-lg-none"><a href="<?= URLROOT . "/formateur/dashboard" ?>">Dashboard</a>
                        </li>
                    <?php endif ?>
                    <?php if (isset($_SESSION['id_etudiant'])) : ?>
                        <li class="d-lg-none"><a href="<?= URLROOT . "/etudiant/dashboard" ?>">Mes Cours</a>
                        </li>
                    <?php endif ?>
                </ul>
            </nav>
            <!-- Search Menu -->
            <div class="search-overlay-menu">
                <span class="search-overlay-close"><span class="closebt"><i class="fa-solid fa-xmark"></i></span></span>
                <form role="search" class="searchForm">
                    <input id="input-search" name="q" type="text" placeholder="Recherche..." />
                    <button type="submit"><i id="searchIcon" class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div><!-- End Search Menu -->
        </header>
        <!-- /header -->

        <main>
            <section class="hero_single version_2">
                <div class="wrapper">
                    <div class="container">
                        <h3>QU'APPRENDRIEZ-VOUS?</h3>
                        <p>Améliorez votre expertise en affaires, technologie et développement personnel</p>
                        <form method="GET" action="<?= URLROOT ?>/courses/search">
                            <div id="custom-search-input">
                                <div class="input-group">
                                    <input name="q" type="text" class=" search-query" placeholder="Ex. Architecture, Specialization...">
                                    <input type="submit" class="btn_search" value="Rechercher">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <!-- /hero_single -->

            <div class="features clearfix">
                <div class="container">
                    <ul>
                        <li><i class="fa-solid fa-desktop"></i>
                            <h4>+<?=  $totalFormations - $totalFormations[-1] ?> Formations</h4><span>Une large sélection de cours</span>
                        </li>
                        <li><i class="fa-solid fa-person-chalkboard"></i>
                            <h4>Enseignants experts</h4><span>Trouvez le bon formateur/formatrice pour vous</span>
                        </li>
                        <li><i class="fa-solid fa-bullseye"></i>
                            <h4>Concentrez-vous sur la cible</h4><span>Améliorez votre expertise personnelle</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /features -->

            <div class="container-fluid margin_120_0">
                <div class="main_title_2">
                    <span><em></em></span>
                    <h2 class="text-uppercase">Les 10 formations les plus populaires</h2>
                    <p>Les formations hautement acclamés et les meilleures ventes de MAHA.</p>
                </div>
                <div id="reccomended" class="owl-carousel owl-theme">
                    <?php foreach ($formations as $formation) : ?>
                    <div class="item" data-url="<?= URLROOT ?>/courses/<?= $formation->slug ?>">
                        <div class="box_grid">
                            <figure class="block-reveal">
                                <div class="block-horizzontal"></div>
                                <span class="langue">
                                    <i class="fa-solid fa-language me-1"></i> 
                                    <?= $formation->nomLangue ?>
                                </span>
                                <span class="niveau d-flex align-items-center gap-2">
                                    <span><?= $formation->iconNiveau ?></span>
                                    <?= $formation->nomNiveau ?>
                                </span>
                                <span class="likes d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-heart" style="color: #e91e63"></i>
                                    <?= $formation->jaimes ?>
                                </span>
                                <img src="<?= $formation->imgFormation ?>" class="img-fluid" alt="image formation" />
                                <div class="price">$<?= $formation->prix ?></div>
                                <div class="preview"><span>Apercu de formation</span></div>
                            </figure>
                            <div class="wrapper">
                                <small><?= $formation->nomCategorie ?></small>
                                <h3 class="title"><?= $formation->nomFormation ?></h3>
                                <p class="description"><?= $formation->description ?></p>
                            </div>
                            <ul>
                                <li>
                                    <i class="fa-solid fa-clock"></i>
                                    <?= explode(':', $formation->mass_horaire)[0] ?>h
                                    <?= explode(':', $formation->mass_horaire)[1]?>min
                                </li>
                                <li><i class="fa-solid fa-users"></i> <?= $formation->total_inscriptions ?></li>
                                <li><a class="buy" href="<?= URLROOT ?>/PaymentPaypal/makePayment/<?= $formation->id_formation ?>">Acheter</a></li>
                            </ul>
                            
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
                <!-- /carousel -->
                <div class="container">
                    <p class="btn_home_align"><a href="<?= URLROOT ?>/courses/search" class="btn_1 rounded">Explorer les formations</a></p>
                </div>
                <!-- /container -->
                <hr>
            </div>
            <!-- /container -->

            <div class="container margin_120_0">
                <div class="main_title_2">
                    <span><em></em></span>
                    <h2 class="text-uppercase">Les catégories de formations</h2>
                    <p>Notre meilleures catégories.</p>
                </div>
                <div class="row">
                    <?php foreach ($categories as $categorie) : ?>
                    <div class="col-lg-4 col-md-6 wow" data-wow-offset="150">
                        <a href="<?= URLROOT ?>/courses/search?categorie=<?= str_replace(' ', '+', strtolower($categorie->nom)) ?>" class="grid_item">
                            <figure class="block-reveal">
                                <div class="block-horizzontal"></div>
                                <img src="<?= $categorie->image ?>" class="img-fluid" alt="categorie image">
                                <div class="info">
                                    <small><?= $categorie->formation_count ?> formations</small>
                                    <h3><?= $categorie->nom ?></h3>
                                </div>
                            </figure>
                        </a>
                    </div>
                    <!-- /grid_item -->
                    <?php endforeach ?>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->

            <div class="container-fluid margin_120_0">
                <div class="main_title_2">
                    <span><em></em></span>
                    <h2 class="text-uppercase">Nos formateurs experts.</h2>
                    <p>Les formateurs qui ont suscité beaucoup d'intérêt parmi les étudiants.</p>
                </div>
                <div id="instructors" class="owl-carousel owl-theme">
                <?php foreach ($formateurs as $formateur) : ?>
                <div class="item" data-formateur-slug="<?= $formateur->slug ?>">
                    <div class="box_grid">
                        <figure class="block-reveal">
                            <div class="block-horizzontal"></div>
                            <?php if($formateurs[0] === $formateur) : ?>
                            <span class="top-seller">
                                Meilleure
                            </span>
                            <?php endif ?>
                            <span class="etudiants">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <?= $formateur->etudiants ?>
                            </span>
                            <img src="<?= $formateur->img ?>" class="img-fluid" alt="image formation" />
                        
                        </figure>
                        <div class="wrapper text-center">
                            <small><?= $formateur->nomCategorie ?></small>
                            <h3 class="title"><span class="text-uppercase"><?= $formateur->nomFormateur ?></span> <?= $formateur->prenom ?></h3>
                        </div>
                        
                    </div>
                </div>
                <!-- /grid_item -->
                <?php endforeach ?>
                </div>
            </div>
            <!-- /container -->

            <div class="container margin_120_0 join-us">
                <div class="main_title_2">
                    <span><em></em></span>
                    <h2 class="text-uppercase">REJOIGNEZ-NOUS</h2>
                    <p>Lequel est adapté pour vous ?</p>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center bg-white p-4 shadow etudiant-box">
                            <div class="custom-shape-divider-top-1691155204">
                                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white">Voulez-vous <span style="color: #ffc107">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;apprendre</span>?</h3>
                                <p class="text-muted mt-5">Un apprentissage qui vous ressemble des compétences pour aujourd'hui.</p>
                                <a href="<?= URLROOT ?>/user/register" class="btn_1">Rejoignez maintenant</a>
                            </div>
                           <img src="images/home/etudiant.png" alt="instructor illustration" class="img-fluid w-50" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center bg-white p-4 shadow formateur-box">
                            <div class="custom-shape-divider-top-1691155204">
                                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
                            </svg>
                            </div>
                            <div>
                                <h3 class="text-white">Voulez-vous <span style="color: #ffc107">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;enseigner</span>?</h3>
                                <p class="text-muted mt-5">Nous vous offrons les outils et les compétences nécessaires pour enseigner ce que vous aimez.</p>
                                <a href="<?= URLROOT ?>/user/register" class="btn_1">Commencez à enseigner</a>
                            </div>
                           <img src="images/home/formateur.png" alt="instructor illustration" class="img-fluid w-50" />
                        </div>
                    </div>
                    <!-- /grid_item -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->

            <div class="container margin_120_0">
                <div class="main_title_2" id="contact-us">
                    <span><em></em></span>
                    <h2 class="text-uppercase">Contactez-nous</h2>
                    <p>Nous serions ravis de vous entendre.</p>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="box_detail shadow">
                            <div id="message-contact"></div>
                            <form method="POST" id="contact-form" autocomplete="off">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12 col-sm-6">
                                        <span class="input">
                                            <input class="input_field" type="text" id="name_contact" name="name">
                                            <label class="input_label">
                                                <span class="input__label-content">Nom & Prénom</span>
                                            </label>
                                        </span>
                                        <small class="text-danger name_error error"></small>
                                    </div>
                                    <div class="col-xl-6 col-lg-12 col-sm-6">
                                        <span class="input">
                                            <input class="input_field" type="email" id="email" name="email">
                                            <label class="input_label">
                                                <span class="input__label-content">E-mail</span>
                                            </label>
                                        </span>
                                        <small class="text-danger email_error error"></small>
                                    </div>
                                </div>
                                <!-- /row -->
                                <span class="input">
                                    <input class="input_field" type="text" name="subject">
                                    <label class="input_label">
                                        <span class="input__label-content">Sujet</span>
                                    </label>
                                </span>
                                <small class="text-danger subject_error error"></small>
                                <!-- /row -->
                                <span class="input">
                                    <textarea class="input_field" id="message_contact" name="message" style="height:120px;"></textarea>
                                    <label class="input_label">
                                        <span class="input__label-content">Vore message</span>
                                    </label>
                                </span>
                                <small class="text-danger message_error error"></small>
                                <div style="position:relative;" class="mt-4">
                                    <button type="submit"class="btn_1 full-width" id="submit-contact">Envoyer Mon Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /grid_item -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </main>
    <!-- /main -->
        <footer>
            <div class="container p-4">
                <div class="row justify-content-between">
                    <div class="col-lg-5 col-md-12">
                        <p><img src="<?= $theme->logo ?>" width="149" height="42" alt="maha logo"></p>
                        <p>
                            MAHA Est Un Site Internet De Formation En Ligne Qui Contient Des Cours Et Des Vidéos
                            d'apprentissage
                            Dans Plusieur Domains Tels Que Le Web Development, E-commerce, Digital Marketing ...
                        </p>
                    </div>
                    <div class="col-lg-3 col-md-6 ml-lg-auto">
                        <h5>Liens utiles</h5>
                        <ul class="links">
                            <li><a href="<?= URLROOT ?>">Accueil</a></li>
                            <li><a href="<?= URLROOT ?>/courses/search">Formations</a></li>
                            <li><a href="<?= URLROOT ?>/#contact-us">Contactez-Nous</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5>En contact avec nous</h5>
                        <ul class="contacts">
                            <li><a href="tel://0524345057"><i class="fa-solid fa-mobile"></i> (+212) 524 34 50 57</a></li>
                            <li><a href="mailto:mahateamisgi@gmail.com"><i class="fa-solid fa-envelope"></i> mahateamisgi@gmail.com</a></li>
                            <li><a href="mailto:mahateamisgi@gmail.com"><i class="fa-solid fa-location-dot"></i> Boulevard de Mohammedia</a></li>
                        </ul>
                    </div>
                </div>
                <!--/row-->
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div id="copy">© Copyright <strong><span>MAHA</span></strong>. All Rights Reserved (2023)</div>
                    </div>
                </div>
            </div>
        </footer>
        <!--/footer-->
    </div>

    <!-- Scripts -->
    <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/bootstrap.bundle.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/theia-sticky-sidebar.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.mmenu.js"></script>
    <script src="<?= JSROOT ?>/plugins/owl.carousel.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/wow.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/classie.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>
    <script src="<?= JSROOT ?>/common.js"></script>
    <script src="<?= JSROOT ?>/home.js"></script>
</body>
</html>