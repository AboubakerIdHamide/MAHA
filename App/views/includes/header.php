<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Udema a modern educational site template">
    <meta name="author" content="Ansonika">
    <link rel="icon" type="image/x-icon" href="<?= URLROOT . '/public' ?>/images/favicon.ico">
    <title><?= SITENAME ?></title>

    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- BASE CSS -->
    <link href="<?= URLROOT . '/public/css/' ?>bootstrap.min.css" rel="stylesheet">
    <link href="<?= URLROOT . '/public/css/' ?>style.css" rel="stylesheet">
    <link href="<?= URLROOT . '/public/css/' ?>vendors.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="<?= URLROOT . '/public/css/' ?>custom.css" rel="stylesheet">

    <!-- SPECIFIC CSS -->
    <link href="<?= URLROOT . '/public/css/' ?>grey.css" rel="stylesheet">

    <style>
        #hero_in.courses:before {
            background: url("<?= URLROOT ?>/public/images/bg_courses.jpg") center center no-repeat;
        }

        .hero_single.version_2:before {
            background: url("<?= $data['theme']['landingImg'] ?>") center center no-repeat;
        }
    </style>
</head>

<body>

    <div id="page">
        <header class="header menu_2">
            <div id="preloader">
                <div data-loader="circle-side"></div>
            </div><!-- /Preload -->
            <div id="logo">
                <a href="<?= URLROOT ?>"><img class="logo" src="<?= $data['theme']['logo'] ?>" width="149" height="42" alt="logo Maha"></a>
            </div>
            <ul id="top_menu">
                <li class="search-overlay-menu-btn"><i class="fa-solid fa-magnifying-glass"></i></li>
                <?php if (!isset($_SESSION['user'])) : ?>
                    <li class="hidden_tablet"><a href="<?= URLROOT . "/users/login" ?>" class="btn_1 rounded">Se
                            Connecter</a></li>
                <?php endif ?>
                <?php if (isset($_SESSION['id_formateur'])) : ?>
                    <li class="hidden_tablet"><a href="<?= URLROOT . "/formateurs/dashboard" ?>" class="btn_1 rounded">Dashboard</a>
                    </li>
                <?php endif ?>
                <?php if (isset($_SESSION['id_etudiant'])) : ?>
                    <li class="hidden_tablet"><a href="<?= URLROOT . "/etudiants/dashboard" ?>" class="btn_1 rounded">Mes
                            Cours</a>
                    </li>
                <?php endif ?>

            </ul>
            <!-- /top_menu -->
            <a href="#menu" class="btn_mobile" style='z-index: 100;'>
                <div class="hamburger hamburger--spin" id="hamburger">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </a>
            <nav id="menu" class="main-menu" style='z-index: 100;'>
                <ul>
                    <li><span><a href="<?= URLROOT ?>">Accueil</a></span></li>
                    <li><span><a href="<?= URLROOT ?>/pageFormations/">Courses</a></span></li>
                    <li><span><a href="<?= URLROOT ?>/#catalogue">Categories</a></span></li>
                    <li><span><a href="<?= URLROOT ?>/#contact">Contactez-nous</a></span></li>
                    <?php if (!isset($_SESSION['user'])) : ?>
                        <li><span><a href="<?= URLROOT ?>/users/register">S'inscrire</a></span></li>
                    <?php endif ?>
                    <?php if (!isset($_SESSION['user'])) : ?>
                        <li class="d-lg-none"><a href="<?= URLROOT . "/users/login" ?>">Se
                                Connecter</a></li>
                    <?php endif ?>
                    <?php if (isset($_SESSION['id_formateur'])) : ?>
                        <li class="d-lg-none"><a href="<?= URLROOT . "/formateurs/dashboard" ?>">Dashboard</a>
                        </li>
                    <?php endif ?>
                    <?php if (isset($_SESSION['id_etudiant'])) : ?>
                        <li class="d-lg-none"><a href="<?= URLROOT . "/etudiants/dashboard" ?>">Mes
                                Cours</a>
                        </li>
                    <?php endif ?>
                </ul>
            </nav>
            <!-- Search Menu -->
            <div class="search-overlay-menu">
                <span class="search-overlay-close"><span class="closebt"><i class="fa-solid fa-xmark"></i></span></span>
                <form role="search" class="searchForm">
                    <input id="input-search" type="search" placeholder="Search..." />
                    <button type="submit"><i id="searchIcon" class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div><!-- End Search Menu -->
        </header>
        <!-- /header -->