<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MAHA a modern educational platform">
    <title><?= SITENAME ?> | Formateur</title>
    <!-- Favicons-->
    <link rel="icon" type="image/x-icon" href="<?= URLROOT . '/public' ?>/images/favicon.ico">
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- BASE CSS -->
    <link href="<?= URLROOT ?>/public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= URLROOT ?>/public/css/style.css" rel="stylesheet">
    <link href="<?= URLROOT ?>/public/css/vendors.css" rel="stylesheet">
    <!-- font awesome -->
    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- YOUR CUSTOM CSS -->
    <link href="<?= URLROOT ?>/public/css/custom.css" rel="stylesheet">
    <style>
    #hero_in.general:before {
        background: url(<?= $data['formateur']->img ?>) center center no-repeat;
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
                <a href="<?= URLROOT ?>"><img class="logo" src="<?= $data['theme']['logo'] ?>" width="149" height="42"
                        alt="logo Maha"></a>
            </div>
            <ul id="top_menu">
                <li class="search-overlay-menu-btn"><i class="fa-solid fa-magnifying-glass"></i></li>
                <?php if (!isset($_SESSION['user'])) : ?>
                <li class="hidden_tablet"><a href="<?= URLROOT . "/users/login" ?>" class="btn_1 rounded">Se
                        Connecter</a></li>
                <?php endif ?>
                <?php if (isset($_SESSION['id_formateur'])) : ?>
                <li class="hidden_tablet"><a href="<?= URLROOT . "/formateurs/dashboard" ?>"
                        class="btn_1 rounded">Dashboard</a>
                </li>
                <?php endif ?>
                <?php if (isset($_SESSION['id_etudiant'])) : ?>
                <li class="hidden_tablet"><a href="<?= URLROOT . "/etudiants/dashboard" ?>" class="btn_1 rounded">Mes
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
                <form role="search" id="searchform" method="get">
                    <input id="input-search" type="search" placeholder="Search..." />
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
                            <span></span><?= $data['formateur']->prenom . ' ' . $data['formateur']->nomFormateur ?>
                        </h1>
                    </div>
                </div>
            </section>
            <!--/hero_in-->
            <div class="container margin_60_35">
                <div class="row">
                    <aside class="col-lg-3" id="sidebar">
                        <div class="profile">
                            <figure><img id="avatar-formateur" src="<?= $data['formateur']->img ?>"
                                    alt="Formateur image" class="rounded-circle"></figure>
                            <ul>
                                <li>Name <span
                                        class="float-right"><?= $data['formateur']->prenom . ' ' . $data['formateur']->nomFormateur ?></span>
                                </li>
                                <li>Etudiants <span class="float-right"><?= $data['numAcht'] ?></span></li>
                                <li>Courses <span
                                        class="float-right"><?= $data['numFormations'] ?></span></li>
                                <li>Email <span class="float-right"><a class="text-muted"
                                            href="mailto:<?= $data['formateur']->email ?>">
                                            <?= $data['formateur']->email ?></a></span></li>
                                <li>Telephone <span class="float-right"><?= $data['formateur']->tel ?></span>
                                </li>
                            </ul>
                        </div>
                    </aside>
                    <!--/aside -->

                    <div class="col-lg-9">
                        <div class="box_teacher">
                            <div class="indent_title_in">
                                <i class="fa-solid fa-user"></i>
                                <h3>Biographie</h3>
                                <p><?= $data['formateur']->nomCategorie ?></p>
                            </div>
                            <div class="wrapper_indent">

                                <p><?= $data['formateur']->biography ?></p>
                            </div>
                            <!--wrapper_indent -->
                            <hr class="styled_2">
                            <div class="indent_title_in">
                                <i class="fa-solid fa-desktop"></i>
                                <h3>Mes Cours</h3>
                                <p>Fais toujours de ton mieux même si personne ne regarde</p>
                            </div>
                            <div class="wrapper_indent">
                                <div class="table-responsive">
                                    <table class="table table-striped add_bottom_30">
                                        <thead>
                                            <tr>
                                                <th>Formation</th>
                                                <th>Categorie</th>
                                                <th>Prix</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data['formations'] as $formation) : ?>
                                            <tr>
                                                <td><a
                                                        href="<?= URLROOT . "/pageFormations/coursDetails/" . $formation->id_formation ?>"><?= $formation->nomFormation ?></a>
                                                </td>
                                                <td><?= $formation->nomCategorie ?></td>
                                                <td>$<?= $formation->prix ?></td>
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--wrapper_indent -->
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
                    <div class="col-lg-5 col-md-12">
                        <p><img src="<?= $data['theme']['logo'] ?>" width="149" height="42" alt="maha logo"></p>
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
                            <li><a href="<?= URLROOT . "/pageFormations/" ?>">Formations</a></li>
                            <li><a href="<?= URLROOT ?>/#catalogue">Catalogue</a></li>
                            <li><a href="<?= URLROOT ?>/#popular">Les Plus Populaires</a></li>
                            <li><a href="<?= URLROOT ?>/#contact">Contactez-Nous</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5>En contact avec nous</h5>
                        <ul class="contacts">
                            <li><a href="tel://0524345057"><i class="fa-solid fa-mobile"></i> (+212) 524 34 50 57</a>
                            </li>
                            <li><a href="mailto:mahateamisgi@gmail.com"><i class="fa-solid fa-envelope"></i>
                                    mahateamisgi@gmail.com</a></li>
                            <li><a href="mailto:mahateamisgi@gmail.com"><i class="fa-solid fa-location-dot"></i>
                                    Boulevard de
                                    Mohammedia, QI Azli 40150</a></li>
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
    <script src="<?= URLROOT ?>/public/js/common_scripts.js"></script>
    <script src="<?= URLROOT ?>/public/js/cours-details.js"></script>

</body>

</html>