<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="MAHA a modern educational platform" />
    <title><?= $data['formation']->nomFormation ?> | <?= SITENAME ?></title>
    <!-- Favicons-->
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- Plyr CSS -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/plyr.min.css" />
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
                <a href="<?= URLROOT ?>"><img class="logo" src="<?= $data['theme']['logo'] ?>" width="149" height="42" alt="logo Maha"></a>
            </div>
            <ul id="top_menu">
                <li><a href="javascript:void(0)" class="search-overlay-menu-btn">Search</a></li>
                <?php if (!isset($_SESSION['user'])) : ?>
                    <li class="hidden_tablet"><a href="<?= URLROOT . "/user/login" ?>" class="btn_1 rounded">Se
                            Connecter</a></li>
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
                <form role="search" class="searchForm">
                    <input id="input-search" name="q" type="search" placeholder="Recherche..." />
                    <button type="submit"><i id="searchIcon" class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div><!-- End Search Menu -->
        </header>
        <!-- /header -->

        <main>

            <section id="hero_in" class="courses">
                <div class="wrapper">
                    <div class="container d-flex align-items-center flex-column">
                        <h1 class="fadeInUp"><span></span><?= $data['formation']->nomFormation ?></h1>
                        <div class="d-flex justify-content-center gap-5">
                            <div class="statistics">
                            <div>
                                <strong><?= $data['formation']->inscriptions ?></strong>
                            </div>
                            <span>Participants</span>
                        </div>
                        <div class="statistics">
                            <div>
                                <strong><?= $data['formation']->jaimes ?></strong>
                            </div>
                            <span>J'aime</span>
                        </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/hero_in -->

            <div class="bg_color_1">
                <nav class="secondary_nav sticky_horizontal">
                    <div class="container">
                        <ul class="clearfix">
                            <li><a href="#description" class="active">Description</a></li>
                            <li><a href="#lessons">Contenu du cours</a></li>
                        </ul>
                    </div>
                </nav>
                <div class="container margin_35_35">
                    <div class="row flex-column-reverse flex-lg-row px-3">
                        <div class="col-lg-8">

                            <section id="description">
                                <h2>Description</h2>
                                <p><?= $data['formation']->description ?></p>
                            </section>
                            <!-- /section -->

                            <section id="lessons">
                                <div class="intro_title">
                                    <h2>Contenu du cours</h2>
                                </div>

                                <!-- Lessons -->
                                <div class="lesson-container">
                                    <?php $i = 1; ?>
                                    <?php foreach ($data['videos'] as $video) : ?>
                                        <div class="row mb-3 border p-2 rounded">
                                            <div class="col">
                                                <div class="lesson d-flex justify-content-between">
                                                    <span class="lesson-titre">
                                                        <?php if($video->id_video !== $data['previewVideo']->id_video) : ?>

                                                        <i class="fa-solid fa-lock me-2"></i>
                                                        <?php else: ?>
                                                            <i class="fa-solid fa-unlock me-2"></i>
                                                        <?php endif ?>
                                                        <?= $i++; ?>.
                                                        <?= $video->nom ?>
                                                    </span>
                                                    <div class="d-flex gap-3">
                                                        <?php if($video->id_video === $data['previewVideo']->id_video) : ?>
                                                        <span class="badge bg-warning align-self-center">Aperçu</span>
                                                        <?php endif ?>
                                                        <span class="lesson-time">
                                                        <?= $video->duree ?>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <!-- /Lessons -->
                            </section>
                            <!-- /section -->
                        </div>
                        <!-- /col -->
                    
                        <aside class="col-lg-4" id="sidebar-course">
                            <div class="box_detail">
                                <figure class="rounded-corner" id="show-preview" >
                                    <a href="javascript:void(0)" class="video"><i style="color:#FFC107;" class="fa-solid fa-play fs-2"></i><img src="<?= $data['formation']->imgFormation ?>" alt="course image" class="img-fluid rounded-corner"><span>Voir l'aperçu du cours</span></a>
                                </figure>
                                <div class="price-wrapper d-flex justify-content-between">
                                    <span class="price">$<?= $data['formation']->prix ?></span>
                                    <?php if(isInSameWeekAsToday($data['formation']->date_creation)) : ?>
                                    <div class="badge bg-info align-self-end p-2">
                                        Nouveau Cours
                                    </div>
                                    <?php endif ?>
                                </div>
                                <a href="<?= URLROOT ?>/PaymentPaypal/makePayment/<?= $data['formation']->id_formation ?>" class="btn_1 full-width">Acheter dès maintenant</a>
                                <div id="list_feat">
                                    <h3>Informations du cours</h3>
                                    <ul>
                                        <li><i class="fa-solid fa-chalkboard-user"></i>
                                            <a href="<?= URLROOT . "/profilFormateur/" . $data['formation']->id_formateur ?>">
                                                <?= $data['formation']->prenom . ' ' . $data['formation']->nomFormateur ?>
                                            </a>
                                        </li>
                                        <li><i class="fa-solid fa-clock"></i> <?= explode(':', $data['formation']->mass_horaire)[0] ?>h
                                            <?= explode(':', $data['formation']->mass_horaire)[1] ?>min</li>
                                        <li><i class="fa-solid fa-file-video"></i> <?= $data['numbVIdeo'] ?> Leçons</li>
                                        <li><i class="fa-solid fa-list"></i> <?= $data['formation']->nomCategorie ?></li>
                                        <li><i class="fa-solid fa-language"></i>
                                            <?= $data['formation']->nomLangue ?></li>
                                        <li>
                                            <i class="fa-solid fa-chart-simple"></i>
                                            <?= $data['formation']->nomNiveau ?>
                                        </li>
                                        <li><i class="fa-solid fa-calendar-days"></i>
                                            <?= date("d/m/Y", strtotime($data['formation']->date_creation)) ?>
                                        </li>
                                        <li><i class="fa-solid fa-infinity"></i>
                                            Accès illimité
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
    <!-- Popup Preview Video -->
    <div class="overlay-content">
        <video style="--plyr-color-main: #662d91;" class="object-fit-cover" id="player" playsinline controls data-poster="<?= $data['formation']->imgFormation ?>">
            <source src="<?= $data['previewVideo']->url ?>" type="video/mp4" />
        </video>
        <button id="closeBtn" class="d-flex align-items-center justify-content-center"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div id="overlay" class="hidden"></div>
    <!-- End Popup -->
<?php require_once APPROOT . "/views/includes/footer.php"; ?>