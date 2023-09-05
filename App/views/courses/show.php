<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="MAHA is a modern educational platform" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title><?= $formation->nomFormation ?> | <?= SITENAME ?></title>
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- Plyr CSS -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/plyr.min.css" />
    <!-- BASE CSS -->
    <link href="<?= CSSROOT ?>/plugins/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/courses/show.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/common.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/vendors.css" rel="stylesheet" />
    <!-- Font Icons -->
    <link href="<?= CSSROOT ?>/icons/elegant-icons.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/icons/all.min.css" rel="stylesheet" />
    <style>
        #hero_in.courses:before {
            background: url(<?= IMAGEROOT ?>/<?= $formation->bgImg ?>) center center no-repeat;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
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
            <section id="hero_in" class="courses">
                <div class="wrapper">
                    <div class="container d-flex align-items-center flex-column">
                        <h1 class="fadeInUp"><span></span><?= $formation->nomFormation ?></h1>
                        <div class="formateur d-flex align-items-center gap-3">
                            <a href="<?= URLROOT ?>/user/<?= $formation->slugFormateur ?>"><img src="<?= strpos($formation->imgFormateur, 'users') === 0 ? IMAGEROOT.'/'.$formation->imgFormateur : $formation->imgFormateur ?>" alt="image formateur" /></a>
                            <div class="d-flex flex-column align-items-start">
                                <h4 class="formateur-name">
                                    <?= $formation->prenom . ' ' . $formation->nomFormateur ?>
                                </h4>
                                <span class="formateur-speciality">
                                    <?= $formation->nomCategorieFormateur ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/hero_in -->

            <div class="bg_color_1">
                <div class="container-fluid margin_35_35">
                    <div class="row flex-column-reverse flex-lg-row">
                        <div class="col-lg-7 col-xl-8">
                            <section id="description">
                                <h2 class="text-uppercase title">Description</h2>
                                <p><?= $formation->description ?></p>
                            </section>
                            <!-- /section -->
                            <section id="lessons">
                                <div class="intro_title">
                                    <h2 class="text-uppercase title">Contenu du cours</h2>
                                </div>
                                <!-- Lessons -->
                                <div class="lesson-container px-2">
                                    <?php $i = 1; ?>
                                        <div class="row">
                                            <?php foreach ($videos as $video) : ?>
                                            <div class="col-12 mb-1 p-2 rounded video-item">
                                                <div class="lesson d-flex justify-content-between">
                                                    <span class="lesson-titre">
                                                        <?php if($video->id_video !== $previewVideo->id_video) : ?>

                                                        <i class="fa-solid fa-lock me-2"></i>
                                                        <?php else: ?>
                                                            <i class="fa-solid fa-unlock me-2"></i>
                                                        <?php endif ?>
                                                        <?= $i++; ?>.
                                                        <?= $video->nom ?>
                                                    </span>
                                                    <div class="d-flex gap-3">
                                                        <?php if($video->id_video === $previewVideo->id_video) : ?>
                                                        <span class="badge bg-warning align-self-center">Aperçu</span>
                                                        <?php endif ?>
                                                        <span class="lesson-time">
                                                        <?= $video->duree ?>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                </div>
                                <!-- /Lessons -->
                            </section>
                            <!-- /section -->
                        </div>
                        <!-- /col -->
                        <aside class="col-lg-5 col-xl-4" id="sidebar-course">
                            <div class="box_detail shadow">
                                <figure id="show-preview" >
                                    <a href="javascript:void(0)" class="video"><i style="color:#FFC107;" class="fa-solid fa-play fs-2"></i><img src="<?= IMAGEROOT ?>/<?= $formation->imgFormation ?>" alt="course image" class="img-fluid"><span>Voir l'aperçu du cours</span></a>
                                </figure>
                                <div class="price-wrapper d-flex justify-content-between">
                                    <span class="price">$<?= $formation->prix ?></span>
                                    <?php if(isInSameWeekAsToday($formation->date_creation)) : ?>
                                    <div class="course-badge">
                                        Nouveau Cours
                                    </div>
                                    <?php endif ?>
                                </div>
                                <a href="<?= URLROOT ?>/PaymentPaypal/makePayment/<?= $formation->id_formation ?>" class="btn_1 full-width">Acheter dès maintenant</a>
                                <div id="list_feat">
                                    <ul>
                                        <li><i class="fa-solid fa-clock"></i> <?= explode(':', $formation->mass_horaire)[0] ?>h
                                            <?= explode(':', $formation->mass_horaire)[1] ?>min</li>
                                        <li><i class="fa-solid fa-file-video"></i> <?= $totalVideos ?> Leçons</li>
                                        <li><i class="fa-solid fa-graduation-cap"></i><?= $formation->inscriptions ?> Etudiants</li>
                                        <li><i class="fa-solid fa-heart"></i> <?= $formation->jaimes ?> Jaimes</li>
                                        <li><i class="fa-solid fa-list"></i> <?= $formation->nomCategorieFormation ?></li>
                                        <li><i class="fa-solid fa-language"></i>
                                            <?= $formation->nomLangue ?></li>
                                        <li>
                                            <i class="fa-solid fa-chart-simple"></i>
                                            <?= $formation->nomNiveau ?>
                                        </li>
                                        <li><i class="fa-solid fa-calendar-days"></i>
                                            <?= date("d/m/Y", strtotime($formation->date_creation)) ?>
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
        <!-- footer -->
        <?php require_once APPROOT . "/views/includes/public/footer.php" ?>
        <!--/footer-->

        <!-- Popup Preview Video -->
        <div class="overlay-content">
            <video style="--plyr-color-main: #662d91;" class="object-fit-cover" id="player" playsinline controls data-poster="<?= IMAGEROOT ?>/<?= $formation->imgFormation ?>">
                <source src="<?= VIDEOROOT ?>/<?=$previewVideo->url ?>" type="video/mp4" />
            </video>
            <button id="closeBtn" class="d-flex align-items-center justify-content-center"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div id="overlay" class="hidden"></div>
        <!-- End Popup -->

        <!-- to-top Button -->
        <span class="to-top-btn"><i class="fa-solid fa-chevron-up"></i></span>
    </div>

    <!-- Scripts -->
    <script src="<?= JSROOT ?>/plugins/plyr.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/theia-sticky-sidebar.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.mmenu.js"></script>
    <script src="<?= JSROOT ?>/plugins/sticky-kit.min.js"></script>
    <script src="<?= JSROOT ?>/common.js"></script>
    <script src="<?= JSROOT ?>/courses/show.js"></script>
</body>
</html>