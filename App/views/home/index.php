<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Maha a modern educational site" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title>Cours en ligne - Apprenez ce que vous voulez, à votre rythme | <?= SITENAME ?></title>
    <!-- Font Icons -->
    <link href="<?= CSSROOT ?>/icons/elegant-icons.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/icons/all.min.css" rel="stylesheet" />
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- BASE CSS -->
    <link href="<?= CSSROOT ?>/plugins/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/common.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/index.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/vendors.css" rel="stylesheet" />
    <style>
        .hero_single.version_2 {
            background: url('<?= IMAGEROOT ?>/banner_home.jpg') center center no-repeat;
        }

        @media (max-width: 575px) {
          #custom-search-input input[type="submit"] {
            text-indent: -999px;
            background: #92278f url('<?= IMAGEROOT ?>/home/search.svg') no-repeat center center;
          }
        }
    </style>
</head>

<body>
    <div id="page" class="theia-exception">
        <!-- header -->
        <?php require_once APPROOT . "/views/includes/public/header.php" ?>
        <!-- /header -->
        <!-- main -->
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
                    <div class="item">
                        <div class="box_grid wow">
                            <figure class="block-reveal">
                                <div class="block-horizzontal"></div>
                                <span class="langue">
                                    <i class="fa-solid fa-language me-1"></i> 
                                    <?= $formation->nomLangue ?>
                                </span>
                                <span class="niveau d-flex align-items-center gap-2">
                                    <span><?= $formation->iconNiveau ?></span>
                                </span>
                                <span class="likes d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-heart" style="color: #e91e63"></i>
                                    <?= $formation->jaimes ?>
                                </span>
                                <a href="<?= URLROOT ?>/courses/<?= $formation->slug ?>">
                                    <img src="<?= IMAGEROOT ?>/<?= $formation->imgFormation ?>" class="img-fluid" alt="image formation" />
                                </a>
                                <div class="price">$<?= $formation->prix ?></div>
                                <div class="preview"><span>Apercu de formation</span></div>
                            </figure>
                            <div class="wrapper">
                                <small><?= $formation->nomCategorie ?></small>
                                <h3 class="title"><?= $formation->nomFormation ?></h3>
                                <p class="text-dark description"><?= $formation->description ?></p>
                            </div>
                            <ul>
                                <li>
                                    <i class="fa-solid fa-clock"></i>
                                    <?= $formation->mass_horaire ?>
                                </li>
                                <li><i class="fa-solid fa-users"></i> <?= $formation->total_inscriptions ?></li>
                                <li><a class="buy" href="<?= URLROOT ?>/paypal/payment/<?= $formation->id_formation ?>">Acheter</a></li>
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
                                <img src="<?= IMAGEROOT ?>/<?= $categorie->image ?>" class="img-fluid" alt="categorie image">
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
                <div class="item">
                    <div class="box_grid wow">
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
                            <a href="<?= URLROOT ?>/user/<?= $formateur->slug ?>">
                                <img src="<?= IMAGEROOT ?>/<?= $formateur->img ?>" class="img-fluid" alt="image formateur" />
                            </a>
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
                        <div class="d-flex align-items-center p-4 py-xl-0 shadow etudiant-box">
                            <div>
                                <h3>Voulez-vous <span style="color: #662d91">apprendre</span>?</h3>
                                <p class="text-dark">Un apprentissage qui vous ressemble des compétences pour aujourd'hui.</p>
                                <a data-type="etudiant" href="<?= URLROOT ?>/user/register" class="btn_1 join">Rejoignez maintenant</a>
                            </div>
                           <img src="<?= IMAGEROOT ?>/home/etudiant.png" alt="instructor illustration" class="img-fluid" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center p-4 py-xl-0 shadow formateur-box">
                            <div>
                                <h3>Voulez-vous <span style="color: #662d91">enseigner</span>?</h3>
                                <p class="text-dark">Nous vous offrons les outils et les compétences nécessaires pour enseigner ce que vous aimez.</p>
                                <a data-type="formateur" href="<?= URLROOT ?>/user/register" class="btn_1 join">Commencez à enseigner</a>
                            </div>
                           <img src="<?= IMAGEROOT ?>/home/formateur.png" alt="instructor illustration" class="img-fluid" />
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
                                    <button type="submit" class="btn_1 full-width" id="submit-contact">Envoyer Mon Message</button>
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
        <!-- footer -->
        <?php require_once APPROOT . "/views/includes/public/footer.php" ?>
        <!--/footer-->
    </div>
    <!-- Scripts -->
    <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/bootstrap.bundle.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/theia-sticky-sidebar.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.mmenu.js"></script>
    <script src="<?= JSROOT ?>/plugins/owl.carousel.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/classie.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/wow.min.js"></script>
    <script src="<?= JSROOT ?>/common.js"></script>
    <script>const URLROOT = `<?= URLROOT ?>`;</script>
    <script src="<?= JSROOT ?>/home.js"></script>
</body>
</html>