<?php require_once APPROOT . "/views/includes/header.php"; ?>

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
                <li><span class="h6 text-white"><i class="fa-solid fa-sort"></i> Trier par</span></li>
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
                <div id="filters_col"> <a data-bs-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" id="filters_col_bt">Filtrer </a>
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
                                <?php foreach ($data['categories'] as $categorie) : ?>
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
                                <?php foreach ($data['langues'] as $langue) : ?>
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
                                <?php foreach ($data['niveaux'] as $niveau) : ?>
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
                                <?php foreach ($data['durations'] as $duration) :  ?>
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
    <!-- /container -->
</div>
<!-- /container -->
</main>
<!--/main-->

<?php require_once APPROOT . "/views/includes/footer.php"; ?>