<?php require_once APPROOT . "/views/includes/header.php" ?>

<main>
    <section id="landing" class="hero_single version_2">
        <div class="wrapper">
            <div class="container">
                <h3>QU'APPRENDREZ-VOUS ?</h3>
                <p>
                    Augmentez votre expertise en affaires, en technologie et en développement personnel
                </p>
                <form class="searchForm">
                    <div id="custom-search-input">
                        <div class="input-group">
                            <input type="text" class=" search-query" placeholder="Ex. Architecture, Spécialité...">
                            <input type="submit" class="btn_search" value="Search">
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
                <li><i class="fa-solid fa-graduation-cap"></i>
                    <h4><?= $data['totalFormations'] ?></h4><span>Formations</span>
                </li>
                <li><i class="fa-solid fa-users"></i>
                    <h4><?= $data['totalEtudiants'] ?></h4><span>Etudiants</span>
                </li>
                <li><i class="fa-solid fa-chalkboard-user"></i>
                    <h4><?= $data['totalFormateurs'] ?></h4><span>Formateurs</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /features -->

    <div class="container-fluid margin_120_0" id="popular">
        <div class="main_title_2">
            <span><em></em></span>
            <h2>Les Plus Populaires Formations</h2>
        </div>
        <div id="reccomended" class="owl-carousel owl-theme">
            <?php foreach ($data['formations'] as $formation) : ?>
            <div class="item">
                <div class="box_grid">
                    <figure>
                        <a href='<?= URLROOT . "/pageFormation/coursDetails/" . $formation->id_formation ?>'><img
                                src="<?= $formation->imgFormation ?>" class="img-fluid" alt="Photo"></a>
                        <div class="price">$<?= $formation->prix ?></div>
                    </figure>
                    <div class="wrapper">
                        <small><?= $formation->nomCategorie ?></small>
                        <h3><?= $formation->nomFormation ?></h3>
                        <p class='description'><?= $formation->description ?></p>
                    </div>
                    <ul>
                        <li><i class="fa-solid fa-clock"></i> <?= $formation->mass_horaire ?></li>
                        <li><i class="fa-solid fa-user"></i> <?= $formation->numbAcht ?></li>
                        <li><i class="fa-solid fa-heart"></i> <?= $formation->jaimes ?></li>
                        <li><a href='<?= URLROOT . "/pageFormation/coursDetails/" . $formation->id_formation ?>'>Plus</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /item -->
            <?php endforeach; ?>
        </div>
        <!-- /carousel -->
        <div class="container">
            <p class="btn_home_align">
                <a href="<?= URLROOT . "/pageFormation/" ?>" class="btn_1 rounded">Plus Formations</a>
            </p>
        </div>
        <!-- /container -->
        <hr />
    </div>
    <!-- /container -->

    <div class="container margin_30_95" id="catalogue">
        <div class="main_title_2">
            <span><em></em></span>
            <h2>Toutes Les catégories</h2>
        </div>
        <div class="row gap-2 justify-content-center mx-1">
            <?php foreach ($data['categories'] as $categorie) : ?>
            <div class="col-md-3 categories p-3 fs-6 rounded">
                <a class="d-block"
                    href="<?= URLROOT . '/pageFormation/filter/' . $categorie->nom ?>"><?= $categorie->icon ?>
                    <?= $categorie->nom ?></a>
            </div>
            <?php endforeach ?>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->

    <div class="bg_color_1" id="contact">
        <div class="container p-4">
            <div class="main_title_2">
                <span><em></em></span>
                <h2>Contactez-Nous</h2>
            </div>
        </div>

        <div class="container">
            <form method="post" id="contact-us" autocomplete="off">
                <div class="row">
                    <div class="col-md-12">
                        <span class="input">
                            <input class="input_field" type="text" name="name" id="name" required="">
                            <label class="input_label">
                                <span class="input__label-content">Nom</span>
                            </label>
                        </span>
                    </div>
                </div>
                <!-- /row -->
                <div class="row">
                    <div class="col-md-12">
                        <span class="input">
                            <input class="input_field" type="email" name="email" id="email" required="">
                            <label class="input_label">
                                <span class="input__label-content">Email</span>
                            </label>
                        </span>
                    </div>
                </div>
                <!-- /row -->
                <div class="row">
                    <div class="col-md-12">
                        <span class="input">
                            <input class="input_field" type="text" name="subject" id="subject" required="">
                            <label class="input_label">
                                <span class="input__label-content">Sujet</span>
                            </label>
                        </span>
                    </div>
                </div>
                <!-- /row -->
                <span class="input">
                    <textarea class="input_field" id="message" name="message" required=""
                        style="height:150px;"></textarea>
                    <label class="input_label">
                        <span class="input__label-content">Message</span>
                    </label>
                </span>
                <p class="add_top_30"><input type="submit" value="Envoyer" class="btn_1 rounded">
                </p>
                <input type="hidden" id="is-send" />

            </form>
        </div>
        <!-- /container -->
        <!--/contact_info-->
    </div>
    <!-- /bg_color_1 -->
</main>
<!-- /main -->
<div style="z-index: 999;"
    class="toast align-items-center p-1 border-0 bg-success text-white position-fixed bottom-0 end-0 me-3 mb-3"
    id="liveToast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
            aria-label="Close"></button>
    </div>
</div>

<?php require_once APPROOT . "/views/includes/footer.php"; ?>