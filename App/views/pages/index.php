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
				<?php foreach ($data['courses'] as $course) : ?>
					<div class="item">
						<div class="box_grid">
							<figure>
								<a href='<?php echo URLROOT . "/pageFormations/coursDetails/" . $course->IdFormation ?>'><img src="<?php echo $course->imgFormation; ?>" class="img-fluid" alt="Photo"></a>
								<div class="price">$<?php echo $course->prix; ?></div>
							</figure>
							<div class="wrapper">
								<small><?php echo $course->categorie; ?></small>
								<h3><?php echo $course->nomFormation; ?></h3>
								<p class='description'><?php echo $course->description; ?></p>
							</div>
							<ul>
								<li><i class="fa-solid fa-clock"></i> <?php echo $course->duree; ?></li>
								<li><i class="fa-solid fa-user"></i> <?php echo $course->numbAcht; ?></li>
								<li><i class="fa-solid fa-heart"></i> <?php echo $course->likes; ?></li>
								<li><a href='<?php echo URLROOT . "/pageFormations/coursDetails/" . $course->IdFormation ?>'>Plus</a></li>
							</ul>
						</div>
					</div>
					<!-- /item -->
				<?php endforeach; ?>
			</div>
			<!-- /carousel -->
			<div class="container">
				<p class="btn_home_align"><a href="<?php echo URLROOT . "/pageFormations/" ?>" class="btn_1 rounded">Plus Formations</a></p>
			</div>
			<!-- /container -->
			<hr>
		</div>
		<!-- /container -->

		<div class="container margin_30_95" id="catalogue">
			<div class="main_title_2">
				<span><em></em></span>
				<h2>Toutes Les catégories</h2>
			</div>
			<div class="row">
				<?php foreach ($data['categories'] as $categorie) : ?>
					<div class="col-md-4 wow" style="maragin: 5px;" data-wow-offset="150">
						<a href="<?php echo URLROOT . '/pageFormations/filter/' . $categorie->nom_categorie ?>" class="grid_item">
							<figure class="block-reveal">
								<div class="block-horizzontal"></div>
								<img src="<?php echo URLROOT ?>/public/images/categories.jpg" class="img-fluid" alt="">
								<div class="info">
									<h3><?php echo $categorie->icon ?> <?php echo $categorie->nom_categorie ?></h3>
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

		<div class="bg_color_1"  id="equipe">
			<div class="container margin_120_95">
				<div class="main_title_2">
					<span><em></em></span>
					<h2>EQUIPE</h2>
					<p>RENCONTREZ-NOUS</p>
				</div>
			</div>
			<!-- reccomended -->
			<div id="carousel" class="owl-carousel owl-theme">
				<div class="item">
					<div class="title">
						<h4>ABDELMOUMEN MUSTAFA<em>Web Developer</em></h4>
					</div><img src="<?php echo URLROOT . "/Public" ?>/images/membre.jpg" alt="Photo">
				</div>
				<div class="item">
					<div class="title">
						<h4>ID HAMIDE ABOUBAKER<em>Web Developer</em></h4>
					</div><img src="<?php echo URLROOT . "/Public" ?>/images/membre.jpg" alt="Photo">
				</div>
				<div class="item">
					<div class="title">
						<h4>TASDIHT HICHAM<em>Web Developer</em></h4>
					</div><img src="<?php echo URLROOT . "/Public" ?>/images/membre.jpg" alt="Photo">
				</div>
				<div class="item">
					<div class="title">
						<h4>BOUDAL AHMED<em>Web Developer</em></h4>
					</div><img src="<?php echo URLROOT . "/Public" ?>/images/membre.jpg" alt="Photo">
				</div>
			</div>
			<!-- /carousel -->
			<!-- /container -->
		</div>
		<!-- /bg_color_1 -->

		<div class="bg_color_1"  id="contact">
			<div class="container margin_120_95">
				<div class="main_title_2">
					<span><em></em></span>
					<h2>Contactez-Nous</h2>
				</div>
			</div>
			<div class="contact_info">
				<div class="container">
					<ul class="clearfix">
						<li>
							<i class="pe-7s-map-marker"></i>
							<h4>Localisation</h4>
							<span>Boulevard de Mohammedia, QI Azli 40150</span>
						</li>
						<li>
							<i class="pe-7s-mail-open-file"></i>
							<h4>Email</h4>
							<span>info@maha.com</span>

						</li>
						<li>
							<i class="pe-7s-phone"></i>
							<h4>Appel</h4>
							<span>(+212) 524 34 50 57</span>
						</li>
					</ul>
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
								<input class="input_field" type="email"  name="email" id="email" required="">
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
								<input class="input_field" type="email" name="subject" id="subject" required="">
								<label class="input_label">
									<span class="input__label-content">Sujet</span>
								</label>
							</span>
						</div>
					</div>
					<!-- /row -->
					<span class="input">
							<textarea class="input_field" id="message" name="message"  required="" style="height:150px;"></textarea>
							<label class="input_label">
								<span class="input__label-content">Message</span>
							</label>
					</span>
					<p class="add_top_30"><input type="submit" value="Envoyer" class="btn_1 rounded" id="submit-contact"></p>
					<input type="hidden" id="is-send">
				</form>
			</div>
			<!-- /container -->
			<!--/contact_info-->
		</div>
		<!-- /bg_color_1 -->
	</main>
	<!-- /main -->

<?php require_once APPROOT . "/views/includes/footer.php"; ?>
