<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="MAHA a modern educational platform" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title><?= $formateur->prenom . ' ' . $formateur->nomFormateur ?> | <?= SITENAME ?></title>
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- BASE CSS -->
    <link href="<?= CSSROOT ?>/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/formateurs/profil.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/common.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/vendors.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/quill.snow.css" /> 
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <style>
    #hero_in.general::before {
        background: url(<?= URLROOT ?>/public/<?= $formateur->img ?>) center center no-repeat;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }

    #avatar-formateur {
        object-fit: cover;
        width: 150px;
        height: 150px;
    }
    </style>
</head>

<body>
    <div id="page" class="theia-exception">
        <!-- header -->
        <header class="header menu_2">
            <div id="preloader">
                <div data-loader="circle-side"></div>
            </div><!-- /Preload -->
            <div id="logo">
                <a href="<?= URLROOT ?>"><img class="logo" src="<?= LOGO ?>" width="149" height="42" alt="logo Maha"></a>
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
                <form role="search" id="searchform" method="GET" action="<?= URLROOT ?>/courses/search">
                    <input id="input-search" name="q" type="text" placeholder="Search..." />
                    <button type="submit"><i id="searchIcon" class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div><!-- End Search Menu -->
        </header>
        <!-- /header -->

        <main>
            <section id="hero_in" class="general">
                <div class="wrapper">
                    <div class="container">
                        <h1 class="fadeInUp">
                            <span></span><?= $formateur->prenom . ' ' . $formateur->nomFormateur ?>
                        </h1>
                    </div>
                </div>
            </section>
            <!--/hero_in-->
            <div class="container margin_60_35">
                <div class="row">
                    <aside class="col-lg-3" id="sidebar">
                        <div class="profile">
                            <figure><img id="avatar-formateur" src="<?= URLROOT ?>/public/<?= $formateur->img ?>" alt="Formateur image" class="rounded-circle"></figure>
                            <ul>
                                <li class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-column-reverse align-items-center">
                                        <span>Participants</span>
                                        <span class="fw-bolder fs-4"><?= $numberInscriptions ?></span>
                                    </div>
                                    <div class="d-flex flex-column-reverse align-items-center">
                                        <span>Formations</span>
                                        <span class="fw-bolder fs-4"><?= $numberFormations ?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <i class="fa-solid fa-envelope"></i> <a class="text-muted" href="mailto:<?= $formateur->email ?>"><?= $formateur->email ?></a>
                                    </div>
                                </li>
                            </ul>
                            <div class="custom-shape-divider-top-1691328636">
                                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                                    <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
                                </svg>
                            </div>
                        </div>
                    </aside>
                    <!--/aside -->

                    <div class="col-lg-9">
                        <div class="box_teacher">
                            <div class="indent_title_in">
                                <i class="fa-solid fa-scroll"></i>
                                <h3>Biographie</h3>
                                <p><?= $formateur->nomCategorie ?></p>
                            </div>
                            <div class="wrapper_indent ql-editor">
                                <p><?= $formateur->biographie ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach ($formations as $formation) : ?>
                            <div class="col-md-6 col-xl-4">
                                <div class="course shadow">
                                    <div class="course-img">
                                        <a href="<?= URLROOT ?>/courses/<?= $formation->slug ?>"><img class="w-100" src="<?= URLROOT ?>/public/<?= $formation->image ?>" alt="Course Img"></a><div class="course-category"><a href="course.html"><?= $formation->nomCategorie ?></a></div><a href="<?= URLROOT ?>/courses/<?= $formation->slug ?>" class="vs-btn">Consulté</a></div>
                                    <div class="course-content"><div class="course-top"><div class="course-review"><i class="fa fa-heart" style="color: #e83232"></i>(<?= $formation->jaimes ?>)</div><span class="course-price">$<?= $formation->prix ?></span></div><h3 class="h5 course-name"><a title="<?= $formation->nomFormation ?>" href="<?= URLROOT ?>/courses/<?= $formation->slug ?>"><?= $formation->nomFormation ?></a></h3><div class="course-teacher"><span class="text-inherit" >POUR <?= $formation->nomNiveau ?></span></div></div>
                                    <div class="course-meta"><span><i class="fa fa-users"></i><?= $formation->inscriptions ?> Etudiants</span> <span><i class="fa fa-clock"></i><?= explode(':', $formation->mass_horaire)[0] ?>h
                                    <?= explode(':', $formation->mass_horaire)[1] ?>m</span> <span><i class="fa fa-calendar-alt"></i><?= date("d/m/Y", strtotime($formation->date_creation)) ?></span></div>
                                </div>
                            </div>
                            <?php endforeach ?>
                            <?php if(count($formations) === 0) : ?>
                                <div class="col">
                                    <div class="alert alert-info">Ce formateur n'a pas encore de formation.</div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- /col -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </main>
        <!--/main-->

        <!-- footer -->
        <footer>
            <div class="container p-4">
                <div class="row justify-content-between">
                    <div class="col-lg-4 col-md-12">
                        <p><img src="<?= LOGO ?>" width="149" height="42" alt="maha logo"></p>
                        <p>
                            MAHA Est Un Site Internet De Formation En Ligne Qui Contient Des Cours Et Des Vidéos
                            d'apprentissage
                            Dans Plusieur Domains Tels Que Le Web Development, E-commerce, Digital Marketing ...
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-6 ml-lg-auto">
                        <h5>Liens utiles</h5>
                        <ul class="links">
                            <li><a href="<?= URLROOT ?>">Accueil</a></li>
                            <li><a href="<?= URLROOT ?>/courses/search">Formations</a></li>
                            <li><a href="<?= URLROOT ?>/#contact-us">Contactez-Nous</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <h5>En contact avec nous</h5>
                        <ul class="contacts">
                            <li><a href="tel://0524345057"><i class="fa-solid fa-mobile"></i> (+212) 524 34 50 57</a>
                            </li>
                            <li><a href="mailto:mahateamisgi@gmail.com"><i class="fa-solid fa-envelope"></i> mahateamisgi@gmail.com</a></li>
                            <li><a href="mailto:mahateamisgi@gmail.com"><i class="fa-solid fa-location-dot"></i> Boulevard de Mohammedia</a></li>
                        </ul>
                    </div>
                </div>
                <!--/row-->
                <hr>
                <div class="row">
                    <div class="col">
                        <div id="copy">© Copyright <strong><span>MAHA</span></strong>. All Rights Reserved (2023)</div>
                    </div>
                </div>
            </div>
        </footer>
        <!--/footer-->
    </div>
    <!-- page -->

    <!-- SCRIPTS -->
    <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.mmenu.js"></script>
    <script src="<?= JSROOT ?>/plugins/theia-sticky-sidebar.js"></script>
    <script src="<?= JSROOT ?>/common.js"></script>
</body>
</html>