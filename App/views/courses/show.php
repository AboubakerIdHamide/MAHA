<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="MAHA a modern educational platform" />
    <title><?= SITENAME ?> | <?= $data['formation']->nomFormation ?></title>
    <!-- Favicons-->
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- BASE CSS -->
    <link href="<?= CSSROOT ?>/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/style.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/vendors.css" rel="stylesheet" />
    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- YOUR CUSTOM CSS -->
    <link href="<?= CSSROOT ?>/custom.css" rel="stylesheet" />
    <style>
        #hero_in.courses:before {
            background: url(<?= $data['formation']->imgFormation ?>) center center no-repeat;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
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
                <a href="<?= URLROOT ?>"><img class="logo" src="<?= $data['theme']["logo"] ?>" width="149" height="42" alt="logo Maha"></a>
            </div>
            <ul id="top_menu">
                <li class="search-overlay-menu-btn"><i class="fa-solid fa-magnifying-glass"></i></li>
                <?php if (!isset($_SESSION['user'])) : ?>
                    <li class="hidden_tablet"><a href="<?= URLROOT . "/user/login" ?>" class="btn_1 rounded">Se
                            Connecter</a></li>
                <?php endif ?>
                <?php if (isset($_SESSION['id_formateur'])) : ?>
                    <li class="hidden_tablet"><a href="<?= URLROOT . "/formateur/dashboard" ?>" class="btn_1 rounded">Dashboard</a>
                    </li>
                <?php endif ?>
                <?php if (isset($_SESSION['id_etudiant'])) : ?>
                    <li class="hidden_tablet"><a href="<?= URLROOT . "/etudiant/dashboard" ?>" class="btn_1 rounded">Mes
                            Cours</a>
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
                    <li><span><a href="<?= URLROOT ?>/pageFormation">Courses</a></span></li>
                    <li><span><a href="<?= URLROOT ?>/#catalogue">Categories</a></span></li>
                    <li><span><a href="<?= URLROOT ?>/#contact">Contactez-nous</a></span></li>
                    <?php if (!isset($_SESSION['user'])) : ?>
                        <li><span><a href="<?= URLROOT ?>/user/register">S'inscrire</a></span></li>
                    <?php endif ?>
                    <?php if (!isset($_SESSION['user'])) : ?>
                        <li class="d-lg-none"><a href="<?= URLROOT . "/user/login" ?>">Se
                                Connecter</a></li>
                    <?php endif ?>
                    <?php if (isset($_SESSION['id_formateur'])) : ?>
                        <li class="d-lg-none"><a href="<?= URLROOT . "/formateur/dashboard" ?>">Dashboard</a>
                        </li>
                    <?php endif ?>
                    <?php if (isset($_SESSION['id_etudiant'])) : ?>
                        <li class="d-lg-none"><a href="<?= URLROOT . "/etudiant/dashboard" ?>">Mes
                                Cours</a>
                        </li>
                    <?php endif ?>
                </ul>
            </nav>
            <!-- Search Menu -->
            <div class="search-overlay-menu">
                <span class="search-overlay-close"><span class="closebt"><i class="fa-solid fa-xmark"></i></span></span>
                <form role="search" id="searchform" method="get">
                    <input id="input-search" type="search" placeholder="Search..." />
                    <button type="submit"><i id="searchIcon" class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div><!-- End Search Menu -->
        </header>
        <!-- /header -->

        <main>
            <section id="hero_in" class="courses">
                <div class="wrapper">
                    <div class="container">
                        <h1 class="fadeInUp"><span></span><?= $data['formation']->nomFormation ?></h1>
                    </div>
                </div>
            </section>
            <!--/hero_in -->

            <div class="bg_color_1">
                <nav class="secondary_nav sticky_horizontal">
                    <div class="container">
                        <ul class="clearfix">
                            <li><a href="#description" class="active">Description</a></li>
                            <li><a href="#lessons">Lessons</a></li>
                        </ul>
                    </div>
                </nav>
                <div class="container margin_60_35">
                    <div class="row">
                        <div class="col-lg-8">

                            <section id="description">
                                <h2>Description</h2>
                                <p><?= $data['formation']->description ?></p>
                            </section>
                            <!-- /section -->

                            <section id="lessons">
                                <div class="intro_title">
                                    <h2>Lessons</h2>
                                    <ul>
                                        <li><?= $data['numbVIdeo'] ?> lessons</li>
                                        <li><?= $data['formation']->mass_horaire ?></li>
                                    </ul>
                                </div>

                                <!-- Lessons -->
                                <div class="lesson-container">
                                    <?php $i = 1; ?>
                                    <?php foreach ($data['videos'] as $video) : ?>
                                        <div class="row mb-3 border p-2 rounded">
                                            <div class="col">
                                                <div class="lesson d-flex justify-content-between">
                                                    <span class="lesson-titre"><i class="fa-solid fa-lock me-2"></i>
                                                        <?= $i++; ?>.
                                                        <?= $video->nom ?>
                                                    </span>
                                                    <span class="lesson-time"><?= $video->duree ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <!-- /Lessons -->
                            </section>
                            <!-- /section -->

                            <section>
                                <h2>Statistics</h2>
                                <div class="reviews-container">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="statistics">
                                                <div>
                                                    <strong><?= $data['formation']->inscriptions ?> <i class="fa-solid fa-graduation-cap"></i></strong>
                                                </div>
                                                <span>Apprenants</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="statistics">
                                                <div>
                                                    <strong><?= $data['formation']->jaimes ?> <i class="fa-solid fa-heart"></i></strong>
                                                </div>
                                                <span>J'aime</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- /section -->
                        </div>
                        <!-- /col -->

                        <aside class="col-lg-4" id="sidebar">
                            <div class="box_detail">
                                <figure class="rounded-corner">
                                    <a href="<?= $data['previewVideo'] ?>" class="video"><i style="color:#FFC107;" class="fa-solid fa-play fs-2"></i><img src="<?= $data['formation']->imgFormation ?>" alt="course image" class="img-fluid rounded-corner"><span>Voir l'aperçu du cours</span></a>
                                </figure>
                                <div class="price">
                                    $<?= $data['formation']->prix ?>
                                </div>
                                <a href="<?= URLROOT ?>/PaymentPaypal/makePayment/<?= $data['formation']->id_formation ?>" class="btn_1 full-width">Acheter</a>
                                <div id="list_feat">
                                    <h3>Informations du cours</h3>
                                    <ul>
                                        <li><i class="fa-solid fa-person-chalkboard"></i>
                                            <a href="<?= URLROOT . "/profilFormateur/" . $data['formation']->id_formateur ?>">
                                                <?= $data['formation']->prenom . ' ' . $data['formation']->nomFormateur ?>
                                            </a>
                                        </li>
                                        <li><i class="fa-solid fa-list"></i> <?= $data['formation']->nomCategorie ?></li>
                                        <li><i class="fa-solid fa-language"></i>
                                            <?= $data['formation']->nomLangue ?></li>
                                        <li>
                                            <?= $data['formation']->iconNiveau ?>
                                            <?= $data['formation']->nomNiveau ?>
                                        <li><i class="fa-solid fa-calendar-days"></i>
                                            <?= $data['formation']->date_creation ?></li>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>
                    <!-- /row -->
                </div>
                <!-- /container -->
            </div>
            <!-- /bg_color_1 -->
        </main>
        <!--/main-->

        <footer>
            <div class="container p-4">
                <div class="row justify-content-between">
                    <div class="col-lg-5 col-md-12">
                        <p><img src="<?= $data['theme']["logo"] ?>" width="149" height="42" alt="maha logo"></p>
                        <p>
                            MAHA Est Un Site Internet De Formation En Ligne Qui Contient Des Cours Et Des Vidéos
                            d'apprentissage
                            Dans Plusieur Domains Tels Que Le Web Development, E-commerce, Digital Marketing ...
                        </p>
                    </div>
                    <div class="col-lg-3 col-md-6 ml-lg-auto">
                        <h5>Liens utiles</h5>
                        <ul class="links">
                            <li><a href="<?= URLROOT ?>">Home</a></li>
                            <li><a href="<?= URLROOT ?>/pageFormation">Formations</a></li>
                            <li><a href="<?= URLROOT ?>/#catalogue">Catalogue</a></li>
                            <li><a href="<?= URLROOT ?>/#popular">Les Plus Populaires</a></li>
                            <li><a href="<?= URLROOT ?>/#contact">Contactez-Nous</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5>En contact avec nous</h5>
                        <ul class="contacts">
                            <li>
                                <a href="tel://0524345057"><i class="fa-solid fa-mobile"></i> (+212) 524 34 50 57</a>
                            </li>
                            <li>
                                <a href="mailto:mahateamisgi@gmail.com"><i class="fa-solid fa-envelope"></i>mahateamisgi@gmail.com</a>
                            </li>
                            <li>
                                <a href="mailto:mahateamisgi@gmail.com"><i class="fa-solid fa-location-dot"></i> Boulevard de Mohammedia, QI Azli 40150</a>
                            </li>
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
    <!-- page -->

    <!-- SCRIPTS -->
    <script src="<?= URLROOT ?>/public/jQuery/jquery-3.6.0.min.js"></script>
    <script src="<?= JSROOT ?>/common_scripts.js"></script>
    <script src="<?= JSROOT ?>/cours-details.js"></script>
    <script src="<?= JSROOT ?>/mainT.js"></script>

</body>

</html>