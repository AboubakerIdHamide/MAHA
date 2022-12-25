<?php require_once APPROOT . "/views/includes/dashBoardNav.php"; ?>
<!-- profil Head -->
<section class="section-title mt-4">
	<div class="container">
		<div>
			<h4>Aperçu</h4>
			<p>Profil de l'utilisateur</p>
		</div>
	</div>
</section>
<!-- Fin profil Head -->
<section class="container mb-5">

	<p class="success-msg"></p>
	<div class="row profil-row">
		<div class="col-lg-5 profil">
			<div class="card p-2">
				<div class="text-center">
					<div class="avatar-container">
						<img id="avatar-profil" src="<?php echo $data['img'] ?>" alt="user image">
						<div class="mt-2">
							<input id="avatar" class="d-none" type="file" accept=".jpg, .jpeg, .png">
							<label class="btn btn-warning" for="avatar">
								<i class="fa-solid fa-image"></i> Changer Avatar
							</label>
							<small id="error-img-avatar" class="error text-danger"></small>
						</div>
					</div>
					<h5 class="mt-2 nom-prenom" id='nom-prenom-aff'><?php echo $data['nom'] ?> <?php echo $data['prenom'] ?></h5>
					<p class="speciality-display" id='cat-aff'><?php echo $data['categorie'] ?></p>
					<span class="type-account badge rounded-pill text-bg-info"><i class="fa-solid fa-person-chalkboard"></i> Formateur</span>
				</div>
				<hr />
				<div class="px-4">
					<p class="text-secondary" style="font-weight: 500;">Biographie</p>
					<p class="bio-display" id='bio-aff'><?php echo $data['bio'] ?></p>
				</div>
			</div>
		</div>
		<div class="col-lg-7 mt-4 mt-lg-0">
			<div class="card">
				<div class="card-header py-3">
					Informations de compte
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-12">
							<label for="nom" class="form-label">Nom</label>
							<div class="input-group flex-nowrap">
								<input type="text" class="form-control" aria-label="nom" aria-describedby="addon-wrapping" value="<?php echo $data['nom'] ?>" disabled id="nom">
								<span class="input-group-text" id="nom-icon"><i class="fa-solid fa-pen-to-square"></i></span>
							</div>
							<small id="error-nom" class="error text-danger"><?php echo $data['nom_err'] ?></small>
						</div>
						<div class="col mt-3 mt-md-0">
							<label for="prenom" class="form-label">Prénom</label>
							<div class="input-group flex-nowrap">
								<input value="<?php echo $data['prenom'] ?>" type="text" class="form-control" aria-label="prenom" aria-describedby="addon-wrapping" id="prenom" disabled>
								<span class="input-group-text" id="prenom-icon"><i class="fa-solid fa-pen-to-square"></i></span>
							</div>
							<small id="error-prenom" class="error text-danger"><?php echo $data['prenom_err'] ?></small>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<label for="email" class="form-label">Email</label>
							<div class="input-group flex-nowrap">
								<input type="email" class="form-control" id="email" value="<?php echo $data['email'] ?>" disabled>
							</div>
							<small class="error text-danger" id="error-email"></small>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<label for="tele" class="form-label">Numéro Téléphone</label>
							<div class="input-group flex-nowrap">
								<input value="<?php echo $data['tel'] ?>" type="text" class="form-control" aria-label="Numero Telephone" aria-describedby="addon-wrapping" id="tele" disabled>
								<span class="input-group-text" id="phone-icon"><i class="fa-solid fa-pen-to-square"></i></span>
							</div>
							<small class="error text-danger" id="error-tele"><?php echo $data['tel_err'] ?></small>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<label for="mdp-c" class="form-label">Mot de passe current</label>
							<div class="input-group flex-nowrap">
								<input type="password" class="form-control" placeholder="****************" aria-label="password" aria-describedby="addon-wrapping" id="mdp-c" class="mdp-c">
								<span class="input-group-text border border-start-0 eye-icon" id="eye-icon"><i class="fa-solid fa-eye-slash"></i></span>
							</div>
							<small class="text-danger error" id="error-mdp-c"></small>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<label for="mdp" class="form-label">Nouveau Mot de passe</label>
							<div class="input-group flex-nowrap">
								<input type="password" class="form-control" placeholder="****************" aria-label="password" aria-describedby="addon-wrapping" id="mdp">
								<span class="input-group-text border border-start-0 eye-icon" id="eye-icon"><i class="fa-solid fa-eye-slash"></i></span>
							</div>
							<small class="text-danger error" id="error-mdp"></small>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<label for="speciality" class="form-label">Spécialité</label>
							<select id="spec" class="form-select" aria-label="Default select example">
								<?php
								foreach ($data["categories"] as $cat) {
									if ($cat->id_categorie == $data['specId']) {
										echo '<option selected value="' . $cat->id_categorie . '">' . $cat->nom_categorie . '</option>';
									} else {
										echo '<option value="' . $cat->id_categorie . '">' . $cat->nom_categorie . '</option>';
									}
								} ?>
							</select>
							<small class="error text-danger" id="error-spec"><?php echo $data['specId_err'] ?></small>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<label for="bio" class="form-label d-flex justify-content-between bio-icon" id="bio-icon">Biographie<i class="fa-solid fa-pen-to-square"></i></label>
							<textarea id="bio" class="form-control" rows="3" disabled><?php echo $data['bio'] ?></textarea>
							<small id="error-bio" class="error text-danger"><?php echo $data['bio_err'] ?></small>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<div class="d-grid gap-2 d-md-block">
								<button id="update-info" class="btn btn-info">Update Account</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php require_once APPROOT . "/views/includes/footerDashboard.php"; ?>