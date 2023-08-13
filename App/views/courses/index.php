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
    <link href="<?= CSSROOT ?>/vendors.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/common.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/courses/index.css" rel="stylesheet" />
    <!-- SPECIFIC CSS -->
    <link href="<?= CSSROOT ?>/skins/yellow.css" rel="stylesheet" />
    <style>
        #hero_in.courses:before {
            background: url("<?= IMAGEROOT ?>/bg_courses.jpg") center center no-repeat;
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
                <a href="<?= URLROOT ?>"><img class="logo" src="<?= LOGO ?>" width="149" height="42" alt="logo Maha"></a>
            </div>
            <ul id="top_menu">
                <li><a href="javascript:void(0)" class="search-overlay-menu-btn">Search</a></li>
                <?php if (!session('user')->get()) : ?>
                    <li class="hidden_tablet"><a href="<?= URLROOT . "/user/login" ?>" class="btn_1 rounded">Se Connecter</a></li>
                <?php else: ?>
                    <?php if (session('user')->get()->type === 'formateur') : ?>
                        <li class="hidden_tablet"><a href="<?= URLROOT . "/formateur/dashboard" ?>" class="btn_1 rounded">Dashboard</a>
                        </li>
                    <?php else: ?>
                        <li class="hidden_tablet"><a href="<?= URLROOT . "/etudiant/dashboard" ?>" class="btn_1 rounded">Mes Cours</a>
                        </li>
                    <?php endif ?>
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
                        <li><span><a href="<?= URLROOT ?>/user/register">S'inscrire</a></span></li>
                    <?php endif ?>
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
            <section id="hero_in" class="courses">
                <div class="wrapper">
                    <div class="container">
                        <h1 class="fadeInUp"><span></span>Formations</h1>
                        <div class="hero-section"></div>
                    </div>
                </div>
            </section>
            <!--/hero_in-->

            <div class="filters_listing sticky_horizontal">
                <div class="container">
                    <ul class="clearfix d-flex align-items-center">
                        <li><span class="h6 text-white"><i class="fa-solid fa-sort"></i> <span class="sort">Trier par</span></span></li>
                        <li>
                            <div class="switch-field">
                                <input type="radio" id="all" name="sort" value="all" />
                                <label for="all">les plus pertinents</label>
                                <input type="radio" id="newest" name="sort" value="newest" />
                                <label for="newest">les plus récents</label>
                                <input type="radio" id="mostLiked" name="sort" value="mostLiked">
                                <label for="mostLiked">les plus aimés</label>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- /container -->
            </div>

            <!-- /filters -->
            <div class="container margin_35_35">
                <div class="row">
                    <aside class="col-lg-3" id="sidebar">
                        <div id="filters_col"> <span id="filters_col_bt">Filtrer</span>
                            <div class="collapse show" id="collapseFilters">
                                <div class="filter_type">
                                    <h6 class="d-flex justify-content-between align-items-center">
                                        <span>Categories</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </h6>
                                    <ul style="display: none;">
                                        <li>
                                            <label for="categorie-all">
                                                <input id="categorie-all" name="categorie" type="radio" class="icheck" value="all" />Tous les categories
                                            </label>
                                        </li>
                                        <?php foreach ($categories as $categorie) : ?>
                                        <li>
                                            <label for="categorie-<?= $categorie->nom ?>">
                                                <input id="categorie-<?= $categorie->nom ?>" name="categorie" type="radio" value="<?= strtolower($categorie->nom) ?>" class="icheck"><?= $categorie->nom ?> <small>(<?= $categorie->total_formations ?>)</small>
                                            </label>
                                        </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                                <div class="filter_type">
                                    <h6 class="d-flex justify-content-between align-items-center">
                                        <span>Langues</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </h6>
                                    <ul style="display: none;">
                                        <li>
                                            <label for="langue-all">
                                                <input id="langue-all" name="langue" type="radio" class="icheck" value="all" />Tous les langues
                                            </label>
                                        </li>
                                        <?php foreach ($langues as $langue) : ?>
                                        <li>
                                            <label for="langue-<?= $langue->nom ?>">
                                                <input id="langue-<?= $langue->nom ?>" name="langue" type="radio" value="<?= strtolower($langue->nom) ?>" class="icheck"><?= $langue->nom ?> <small>(<?= $langue->total_formations ?>)</small>
                                            </label>
                                        </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                                <div class="filter_type">
                                    <h6 class="d-flex justify-content-between align-items-center">
                                        <span>Niveaux</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </h6>
                                    <ul style="display: none;">
                                        <li>
                                            <label for="niveau-all">
                                                <input id="niveau-all" name="niveau" type="radio" class="icheck" value="all" />Tous les niveaux
                                            </label>
                                        </li>
                                        <?php foreach ($niveaux as $niveau) : ?>
                                        <li>
                                            <label for="niveau-<?= $niveau->nom ?>">
                                                <input id="niveau-<?= $niveau->nom ?>" name="niveau" type="radio" value="<?= strtolower($niveau->nom) ?>" class="icheck"><?= $niveau->nom ?> <small>(<?= $niveau->total_formations ?>)</small>
                                            </label>
                                        </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                                <div class="filter_type">
                                    <h6 class="d-flex justify-content-between align-items-center">
                                        <span>Durée de la formation</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </h6>
                                    <ul style="display: none;">
                                        <li>
                                            <label for="duration-all">
                                                <input id="duration-all" name="duration" type="radio" class="icheck" value="all" />Tous
                                            </label>
                                        </li>
                                        <?php foreach ($durations as $duration) :  ?>
                                        <li>
                                            <label for="duration-<?= $duration->value ?>">
                                                <input id="duration-<?= $duration->value ?>" name="duration" value="<?= $duration->value ?>" type="radio" class="icheck" /><?= $duration->label ?> <small>(<?= $duration->total_formations ?>)</small>
                                            </label>
                                        </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            </div>
                            <!--/collapse -->
                        </div>
                        <!--/filters col-->
                    </aside>
                    <!-- /aside -->

                    <div class="col-lg-9">
                        <div class="row" id="courses"></div>
                    </div>
                    <!-- /col -->
                </div>
                <!-- /row -->
            </div>
        </main>
        <!--/main-->
        <footer>
        <div class="container p-4">
            <div class="row justify-content-between">
                <div class="col-lg-5 col-md-12">
                    <p><img src="<?= LOGO ?>" width="149" height="42" alt="maha logo"></p>
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
<script src="<?= JSROOT ?>/plugins/theia-sticky-sidebar.js"></script>
<script src="<?= JSROOT ?>/plugins/jquery.mmenu.js"></script>
<script src="<?= JSROOT ?>/plugins/sticky-kit.min.js"></script>
<script src="<?= JSROOT ?>/plugins/wow.min.js"></script>
<script src="<?= JSROOT ?>/plugins/icheck.min.js"></script>
<script src="<?= JSROOT ?>/courses/index.js"></script>
<script src="<?= JSROOT ?>/common.js"></script>

</body>
</html>