<?php require_once APPROOT . "/views/includes/header.php"; ?>

<main>
    <section id="hero_in" class="courses">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span>Les Formations</h1>
            </div>
        </div>
    </section>
    <!--/hero_in-->

    <div class="filters_listing sticky_horizontal">
        <div class="container">
            <ul class="clearfix">
                <li>
                    <div class="switch-field">
                        <a class="dropdown-item" id='plusPopilaires' ckecked href="<?= URLROOT . "/pageFormations/getPopularCourses" ?>">Les Plus Populaires</a>
                        <a class="dropdown-item" id='plusAmais' href="<?= URLROOT . "/pageFormations/plusFormationsAmais" ?>">Les Plus Amais</a>
                        <a class="dropdown-item" id='plusAchter' href="<?= URLROOT . "/pageFormations/plusFormationsAcheter" ?>">Les Plus Achter</a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /filters -->
    <div class="container margin_60_35">
        <div class="row">
            <aside class="col-lg-3" id="sidebar">
                <div id="filters_col"> <a data-bs-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" id="filters_col_bt">Filters </a>
                    <div class="collapse show" id="collapseFilters">
                        <div class="filter_type">
                            <h6><strong>Categories</strong></h6>
                            <ul>
                                <?php foreach ($data['categories'] as $categorie) : ?>
                                    <li>
                                        <a class="nav-link" href="<?= URLROOT . '/pageFormations/filter/' . $categorie->nom ?>"><?= $categorie->nom ?></a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="filter_type">
                            <h6><strong>Langues</strong></h6>
                            <ul>
                                <?php foreach ($data['langues'] as $langue) : ?>
                                    <li>
                                        <a class="nav-link" href="<?= URLROOT . '/pageFormations/formationsByLangue/' . $langue->id_langue ?>"><?= $langue->nom ?></a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="filter_type">
                            <h6><strong>Niveaux</strong></h6>
                            <ul>
                                <?php foreach ($data['niveaux'] as $niveau) : ?>
                                    <li>
                                        <a class="nav-link" href="<?= URLROOT . '/pageFormations/formationsByNiveau/' . $niveau->id_niveau ?>"><?= $niveau->nom ?></a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="filter_type">
                            <h6><strong>Durée :</strong></h6>
                            <form action="<?= URLROOT . "/pageFormations/formationsByDuree/" ?>" method="GET">
                                <div class="m-2">
                                    <label class="form-label" for="minH">Min heure :</label>
                                    <input type="number" name="minH" class="form-control">
                                </div>
                                <div class="m-2">
                                    <label class="form-label" for="maxH">Max heure :</label>
                                    <input type="number" name="maxH" class="form-control">
                                </div>
                                <div class="m-2 d-grid">
                                    <input type="submit" value="Filter" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--/collapse -->
                </div>
                <!--/filters col-->
            </aside>
            <!-- /aside -->
            <?php if (!is_array($data['formations'])) : ?>
                <div class="col-lg-9">
                    <h2 style="color: #662d91; padding-top: 180px" class='aucunF d-flex justify-content-center'>
                        <?= $data['formations'] ?></h2>
                </div>
            <?php else : ?>
                <div class="col-lg-9">
                    <div class="row">
                        <?php foreach ($data['formations'] as $formation) : ?>
                            <div class="col-md-6">
                                <div class="box_grid wow">
                                    <figure class="block-reveal">
                                        <div class="block-horizzontal"></div>
                                        <a href='<?= URLROOT . "/pageFormations/coursDetails/" . $formation->id_formation ?>'><img src="<?= $formation->imgFormation ?>" class="img-fluid" alt="Photo"></a>
                                        <div class="price">$<?= $formation->prix ?></div>
                                        <div class="preview"><span>Plus Details</span></div>
                                    </figure>
                                    <div class="wrapper">
                                        <small><?= $formation->nomCategorie ?></small>
                                        <h3><?= $formation->nomFormation ?></h3>
                                        <p class='description'><?= $formation->description ?></p>
                                    </div>
                                    <ul>
                                        <li><i class="fa-solid fa-clock"></i> <?= $formation->mass_horaire ?></li>
                                        <li><i class="fa-solid fa-user"></i> <?= $formation->inscriptions ?></li>
                                        <li><i class="fa-solid fa-heart"></i> <?= $formation->jaimes ?></li>
                                        <li><a href='<?= URLROOT . "/pageFormations/coursDetails/" . $formation->id_formation ?>'>Plus</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /box_list -->
                        <?php endforeach; ?>
                    </div>
                </div>
        </div>
    </div>
    <!-- start pagenition -->
    <div class='footer_page_formations'>
        <ul class="pagination d-flex justify-content-center">
            <li style='font-size: 22px;' class='page-item'><a class='page-link' href="?pageno=1">First</a></li>
            <li style='font-size: 22px;' class="page-item <?php if (intval($data['pageno']) <= 1) {
                                                                echo 'disabled';
                                                            } ?>">
                <a class='page-link' href="<?php if (intval($data['pageno']) <= 1) {
                                                echo '#';
                                            } else {
                                                echo "?pageno=" . (intval($data['pageno']) - 1);
                                            } ?>">Prev</a>
            </li>
            <li style='font-size: 22px;' class="page-item  <?php if (intval($data['pageno']) >= intval($data['totalPages'])) {
                                                                echo 'disabled';
                                                            } ?>">
                <a class='page-link' href="<?php if (intval($data['pageno']) >= intval($data['totalPages'])) {
                                                echo '#';
                                            } else {
                                                echo "?pageno=" . (intval($data['pageno']) + 1);
                                            } ?>">Next</a>
            </li>
            <li style='font-size: 22px;' class='page-item'><a class='page-link' href="?pageno=<?= intval($data['totalPages']); ?>">Last</a></li>
        </ul>
    </div>
    <!-- end pagenition -->
<?php endif; ?>
</div>
<!-- /container -->
</main>
<!--/main-->

<?php require_once APPROOT . "/views/includes/footer.php"; ?>