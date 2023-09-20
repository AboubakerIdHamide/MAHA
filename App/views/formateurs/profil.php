<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="MAHA a modern educational platform" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title><?= $formateur->prenom . ' ' . $formateur->nomFormateur ?> | <?= SITENAME ?></title>
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- BASE CSS -->
    <link href="<?= CSSROOT ?>/plugins/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/formateurs/profil.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/common.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/vendors.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/quill.snow.css" /> 
    <!-- font awesome -->
    <link href="<?= CSSROOT ?>/icons/all.min.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/icons/elegant-icons.css" rel="stylesheet" />
    <style>
    #hero_in.general::before {
        background: url("<?= IMAGEROOT ?>/<?= $formateur->background_img ?>") center center no-repeat;
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
        <?php require_once APPROOT . "/views/includes/public/header.php" ?>
        <!-- /header -->
        <!-- main -->
        <main>
            <section id="hero_in" class="general">
                <div class="wrapper">
                    <div class="container">
                        <h1 class="fadeInUp">
                            <span></span><?= $formateur->prenom . ' ' . $formateur->nomFormateur ?>
                        </h1>
                        <h3 style="color: #eee">(<?= $formateur->specialite ?>)</h3>
                    </div>
                </div>
            </section>
            <!--/hero_in-->
            <div class="container margin_60_35">
                <div class="row">
                    <aside class="col-lg-3" id="sidebar">
                        <div class="profile">
                            <figure><img id="avatar-formateur" src="<?= strpos($formateur->img, 'users') === 0 ? IMAGEROOT.'/'.$formateur->img : $formateur->img ?>" alt="Formateur avatar" class="rounded-circle"></figure>
                            <ul class="d-flex fs-5">
                                <?= $formateur->linkedin_profil ? "<li class='flex-fill text-center'><a target='_blank' href='{$formateur->linkedin_profil}'><i class='fa-brands fa-linkedin'></i></a></li>" : "" ?>

                                <?= $formateur->facebook_profil ? "<li class='flex-fill text-center'><a target='_blank' href='{$formateur->facebook_profil}'><i class='fa-brands fa-facebook'></i></a></li>" : "" ?>

                                <?= $formateur->twitter_profil ? "<li class='flex-fill text-center'><a target='_blank' href='{$formateur->twitter_profil}'><i class='fa-brands fa-twitter'></i></a></li>" : "" ?>
                            </ul>
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
                                <li id="email">
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
                        <hr style="background-color: #662d91;height: 5px;margin: 50px auto;width: 200px" />
                        <div class="row">
                            <?php foreach ($formations as $formation) : ?>
                            <div class="col-md-6 col-xl-4">
                                <div class="course shadow">
                                    <div class="course-img">
                                        <a href="<?= URLROOT ?>/courses/<?= $formation->slug ?>"><img class="w-100" src="<?= IMAGEROOT ?>/<?= $formation->image ?>" alt="Course Img"></a><div class="course-category"><a href="course.html"><?= $formation->nomCategorie ?></a></div><a href="<?= URLROOT ?>/courses/<?= $formation->slug ?>" class="vs-btn">Consulté</a></div>
                                    <div class="course-content"><div class="course-top"><div class="course-review"><i class="fa fa-heart" style="color: #e83232"></i>(<?= $formation->jaimes ?>)</div><span class="course-price">$<?= $formation->prix ?></span></div><h3 class="h5 course-name"><a title="<?= $formation->nomFormation ?>" href="<?= URLROOT ?>/courses/<?= $formation->slug ?>"><?= $formation->nomFormation ?></a></h3><div class="course-teacher"><span class="text-inherit" >POUR <?= $formation->nomNiveau ?></span></div></div>
                                    <div class="course-meta"><span><i class="fa fa-users"></i><?= $formation->inscriptions ?> Etudiants</span> <span><i class="fa fa-clock"></i><?= $formation->mass_horaire ?></span> <span><i class="fa fa-calendar-alt"></i><?= date("d/m/Y", strtotime($formation->date_creation)) ?></span></div>
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
        <?php require_once APPROOT . "/views/includes/public/footer.php" ?>
        <!--/footer-->
    </div>

    <!-- SCRIPTS -->
    <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.mmenu.js"></script>
    <script src="<?= JSROOT ?>/plugins/theia-sticky-sidebar.js"></script>
    <script src="<?= JSROOT ?>/common.js"></script>
</body>
</html>