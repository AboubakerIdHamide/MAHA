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
                        <a class="dropdown-item" id='plusPopilaires' ckecked
                            href="<?= URLROOT . "/pageFormations/plusPopilairesFormations" ?>">Les Plus Populaires</a>
                        <a class="dropdown-item" id='plusAmais'
                            href="<?= URLROOT . "/pageFormations/plusFormationsAmais" ?>">Les Plus Amais</a>
                        <a class="dropdown-item" id='plusAchter'
                            href="<?= URLROOT . "/pageFormations/plusFormationsAchter" ?>">Les Plus Achter</a>
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
                <div id="filters_col"> <a data-bs-toggle="collapse" href="#collapseFilters" aria-expanded="false"
                        aria-controls="collapseFilters" id="filters_col_bt">Filters </a>
                    <div class="collapse show" id="collapseFilters">
                        <div class="filter_type">
                            <h6><strong>Categories</strong></h6>
                            <ul>
                                <?php foreach ($data['categories'] as $categorie) : ?>
                                <li>
                                    <a class="nav-link"
                                        href="<?= URLROOT . '/pageFormations/filter/' . $categorie->nom_categorie ?>"><?= $categorie->nom_categorie ?></a>
                                </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="filter_type">
                            <h6><strong>Langues</strong></h6>
                            <ul>
                                <?php foreach ($data['langages'] as $lang) : ?>
                                <li>
                                    <a class="nav-link"
                                        href="<?= URLROOT . '/pageFormations/formationsByLangage/' . $lang->id_langue ?>"><?= $lang->nom_langue ?></a>
                                </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="filter_type">
                            <h6><strong>Niveaux</strong></h6>
                            <ul>
                                <?php foreach ($data['nivaux'] as $niv) : ?>
                                <li>
                                    <a class="nav-link"
                                        href="<?= URLROOT . '/pageFormations/formationsByNivau/' . $niv->id_niveau ?>"><?= $niv->nom_niveau ?></a>
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
            <?php if ($data['numbFormations'] == 0) : ?>
            <div class="col-lg-9">
                <h2 style="color: #662d91; padding-top: 180px" class='aucunF d-flex justify-content-center'>
                    <?= $data['info'] ?></h2>
            </div>
            <?php else : ?>
            <div class="col-lg-9">
                <div class="row">
                    <?php foreach ($data['info'] as $info) : ?>
                    <div class="col-md-6">
                        <div class="box_grid wow">
                            <figure class="block-reveal">
                                <div class="block-horizzontal"></div>
                                <a href='<?= URLROOT . "/pageFormations/coursDetails/" . $info->IdFormation ?>'><img
                                        src="<?= $info->imgFormation; ?>" class="img-fluid" alt="Photo"></a>
                                <div class="price">$<?= $info->prix; ?></div>
                                <div class="preview"><span>Plus Details</span></div>
                            </figure>
                            <div class="wrapper">
                                <small><?= $info->categorie; ?></small>
                                <h3><?= $info->nomFormation; ?></h3>
                                <p class='description'><?= $info->description; ?></p>
                            </div>
                            <ul>
                                <li><i class="fa-solid fa-clock"></i> <?= $info->duree; ?></li>
                                <li><i class="fa-solid fa-user"></i> <?= $info->numbAcht; ?></li>
                                <li><i class="fa-solid fa-heart"></i> <?= $info->likes; ?></li>
                                <li><a
                                        href='<?= URLROOT . "/pageFormations/coursDetails/" . $info->IdFormation ?>'>Plus</a>
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
            <li style='font-size: 22px;' class='page-item'><a class='page-link'
                    href="?pageno=<?= intval($data['totalPages']); ?>">Last</a></li>
        </ul>
    </div>
    <!-- end pagenition -->
    <?php endif; ?>
    </div>
    <!-- /container -->
</main>
<!--/main-->

<?php require_once APPROOT . "/views/includes/footer.php"; ?>