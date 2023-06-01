<?php require_once APPROOT."/views/includes/header.php";?>	

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
                            <a class="dropdown-item" id='plusPopilaires' ckecked href="<?php echo URLROOT . "/pageFormations/plusPopilairesFormations" ?>">Les Plus Populaires</a>
                            <a class="dropdown-item" id='plusAmais' href="<?php echo URLROOT . "/pageFormations/plusFormationsAmais" ?>">Les Plus Amais</a>
                            <a class="dropdown-item" id='plusAchter' href="<?php echo URLROOT . "/pageFormations/plusFormationsAchter" ?>">Les Plus Achter</a>
						</div>
					</li>
					<!-- <li>
						<div class="layout_view">
							<a href="courses-grid.html"><i class="icon-th"></i></a>
							<a href="#0" class="active"><i class="icon-th-list"></i></a>
						</div>
					</li> -->
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
								<h6>Categories</h6>
								<ul>
									<?php foreach ($data['categories'] as $categorie) : ?>
										<li>
											<a class="nav-link" href="<?= URLROOT . '/pageFormations/filter/' . $categorie->nom_categorie ?>"><?= $categorie->nom_categorie ?></a>
										</li>
									<?php endforeach ?>
								</ul>
							</div>
							<div class="filter_type">
								<h6>Langues</h6>
								<ul>
									<?php foreach ($data['langages'] as $lang) : ?>
										<li>
											<a class="nav-link" href="<?= URLROOT . '/pageFormations/formationsByLangage/' . $lang->id_langue ?>"><?= $lang->nom_langue ?></a>
										</li>
									<?php endforeach ?>
								</ul>
							</div>
							<div class="filter_type">
								<h6>Niveaux</h6>
								<ul>
									<?php foreach ($data['nivaux'] as $niv) : ?>
										<li>
											<a class="nav-link" href="<?= URLROOT . '/pageFormations/formationsByNivau/' . $niv->id_niveau ?>"><?= $niv->nom_niveau ?></a>
										</li>
									<?php endforeach ?>
								</ul>
							</div>
							<div class="filter_type">
								<h6>Durée :</h6>
								<form action="<?php echo URLROOT . "/pageFormations/formationsByDuree/" ?>" method="GET">
                                    <div class="m-2">
                                        <label class="form-label" for="minH">Min heure :</label>
                                        <input type="number" name="minH" class="form-control">
                                    </div>
                                    <div class="m-2">
                                        <label class="form-label" for="maxH">Max heure :</label>
                                        <input type="number" name="maxH" class="form-control">
                                    </div>
                                    <div class="m-2 text-end">
                                        <input type="submit" value="Filter" class="btn">
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
						<h2  style="color: #662d91; padding-top: 180px" class='aucunF d-flex justify-content-center'><?php echo $data['info'] ?></h2>
					</div>
				<?php else : ?>
				<div class="col-lg-9">
					<div class="row">
            		<?php foreach ($data['info'] as $info) : ?>
                		<div class="col-md-6">
							<div class="box_grid wow">
								<figure class="block-reveal">
									<div class="block-horizzontal"></div>
									<a href='<?php echo URLROOT . "/pageFormations/coursDetails/" . $info->IdFormation ?>'><img src="<?php echo $info->imgFormation; ?>" class="img-fluid" alt="Photo"></a>
									<div class="price">$<?php echo $info->prix; ?></div>
									<div class="preview"><span>Plus Details</span></div>
								</figure>
								<div class="wrapper">
									<small><?php echo $info->categorie; ?></small>
									<h3><?php echo $info->nomFormation; ?></h3>
									<p class='description'><?php echo $info->description; ?></p>
								</div>
								<ul>
									<li><i class="fa-solid fa-clock"></i> <?php echo $info->duree; ?></li>
									<li><i class="fa-solid fa-user"></i> <?php echo $info->numbAcht; ?></li>
									<li><i class="fa-solid fa-heart"></i> <?php echo $info->likes; ?></li>
									<li><a href='<?php echo URLROOT . "/pageFormations/coursDetails/" . $info->IdFormation ?>'>Plus</a></li>
								</ul>
                    		</div>
                		</div>
                		<!-- /box_list -->
            		<?php endforeach; ?>
    				</div>
    			</div>
				</div>
    		</div>
			<!-- <p class="text-center add_top_60"><a href="#0" class="btn_1">Load more</a></p> -->
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
                        <li style='font-size: 22px;' class='page-item'><a class='page-link' href="?pageno=<?php echo intval($data['totalPages']); ?>">Last</a></li>
                    </ul>
            </div>
            <!-- end pagenition -->
			<?php endif; ?>
		</div>
		<!-- /container -->
	</main>
	<!--/main-->

<?php require_once APPROOT . "/views/includes/footer.php"; ?>