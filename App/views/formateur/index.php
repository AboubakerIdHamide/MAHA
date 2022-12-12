<?php require_once APPROOT . "/views/includes/dashBoardNav.php"; ?>
<div class="container me-5">
	<section class="statistics container mt-4">
		<div class="row">
			<?php flash('updateFormation') ?>
			<?php flash('formationAdded') ?>
			<?php flash('videoAdded') ?>
			<div class="col-6 col-lg">
				<div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
					<div>
						<span class="d-block fs-2 nombre">$ <?= $data['balance'] ?></span>
						<small class="text-muted">Balance</small>
					</div>
					<i class="fa-solid fa-dollar-sign fs-1"></i>
				</div>

			</div>
			<div class="col-6 col-lg">
				<div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
					<div>
						<span class="d-block fs-2 nombre" id="nbr-formations">0</span>
						<small class="text-muted">Formations</small>
					</div>
					<i class="fa-solid fa-person-chalkboard fs-1"></i>
				</div>
			</div>
			<div class="col col-lg mt-3 mt-lg-0">
				<div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
					<div>
						<span id="nbr-likes" class="d-block fs-2 nombre">0</span>
						<small class="text-muted">Likes</small>
					</div>
					<i class="fa-solid fa-heart fs-1"></i>
				</div>
			</div>
			<div class="col col-lg mt-3 mt-lg-0">
				<div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
					<div>
						<span class="d-block fs-2 nombre " id="nbr-apprenants">0</span>
						<small class="text-muted">Apprenants</small>
					</div>
					<i class="fa-solid fa-graduation-cap fs-1"></i>
				</div>
			</div>
		</div>
	</section>
	<main class="container ps-5 pe-5 me-lg-5 p-md-0 mt-3 bg-color p-lg-3 rounded">
		<div class="row mb-3 pt-5 pt-lg-0">
			<div class="col-12 col-lg ps-5">
				<div>
					<a href="<?= URLROOT . "/formations/addFormation" ?>" class="btn btn-primary">Add Formation <i class="fa-solid fa-folder-plus"></i></a>
				</div>
			</div>
			<div class="col col-lg mt-3 mt-lg-0 px-5">
				<div class="d-flex gap-3">
					<input placeholder="Titre Formation" type="text" class="form-control" name="q">
					<button id="chercher" class="btn btn-primary" style="white-space: nowrap;">Chercher <i class="fa-sharp fa-solid fa-magnifying-glass"></i></button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col px-5">
				<div class="d-flex justify-content-between my-2 gap-3 align-items-center">
					<div class="counts-selected">
						<small id="count-selected" class="text-muted" style="font-size: 12px;"></small> <small id="count-label" style="display: none"> COURSES SELECTED</small>
					</div>
					<div class="buttons">
						<button id="edit" class="btn btn-info btn-sm" disabled data-bs-toggle="modal" data-bs-target="#editModal">Modifier <i class="fa-solid fa-pen-to-square"></i></button>
						<button id="delete" class="btn btn-danger btn-sm" disabled data-bs-toggle="modal" data-bs-target="#deleteModal">Supprimer <i class="fa-solid fa-trash"></i></button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">Select</th>
								<th>Titre</th>
								<th class="text-center">Likes</th>
								<th>Description</th>
								<th class="text-center">Apprenants</th>
								<th>Fichiers Attaches</th>
								<th>Added Date</th>
								<th>Details</th>
								<th class="text-center">Prix</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>


	</main>

	<section>
		<!-- Modal -->
		<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5">Supression</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<span style="font-weight: 600;">Etes-vous sûr que vous voulez supprimer cette formation ?</span>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary fermer" data-bs-dismiss="modal">Annuler</button>
						<button id="deleteCours" type="button" class="btn btn-primary">Oui</button>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<section>
	<!-- Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5">Modification</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form action="<?= URLROOT . '/formations/updateFormation' ?>" method="POST">
						<div class="mb-3">
							<label for="title" class="form-label" style="font-weight: 600;">Titre</label>
							<!-- id : titre -->
							<input name="titre" type="text" class="form-control" id="title">
							<small class="error-title text-danger"></small>
						</div>
						<div class="mb-3">
							<!-- prix -->
							<label for="prix" class="form-label" style="font-weight: 600;">Prix</label>
							<input name="prix" type="text" class="form-control" id="prix">
							<small class="error-prix text-danger"></small>
						</div>
						<div class="mb-3">
							<label for="description" class="form-label" style="font-weight: 600;">Description</label>
							<!-- id : description -->
							<textarea name="description" class="form-control" id="description" rows="3"></textarea>
							<small class="error-desc text-danger"></small>
						</div>
						<div class="mb-3">
							<label for="categorie" class="form-label" style="font-weight: 600;">Categories</label>
							<select class="form-select" name="categorie" id="categorie">
								<?php foreach ($data['categories'] as $categorie) : ?>
									<option value="<?= $categorie->id_categorie ?>"><?= $categorie->nom_categorie ?></option>
								<?php endforeach; ?>
							</select>
							<small class="error-spec text-danger"></small>
						</div>
						<div class="mb-3">
							<label for="niveau" class="form-label" style="font-weight: 600;">Niveau Formation</label>
							<select class="form-select" name="niveauFormation" id="niveau">
								<?php foreach ($data['levels'] as $level) : ?>
									<option value="<?= $level->id_niveau ?>"><?= $level->nom_niveau ?></option>
								<?php endforeach; ?>
							</select>
							<small class="error-niveau text-danger"></small>
						</div>
						<div class="mb-3">
							<label for="langue" class="form-label" style="font-weight: 600;">Langue</label>
							<select class="form-select" name="langue" id="langue">
								<?php foreach ($data['langues'] as $langue) : ?>
									<option value="<?= $langue->id_langue ?>"><?= $langue->nom_langue ?></option>
								<?php endforeach; ?>
							</select>
							<small class="error-niveau text-danger"></small>
						</div>
						<div class="mb-3">
							<label for="miniature" class="form-label" style="font-weight: 600;">Miniture</label>
							<div class="text-center">
								<!-- id :  miniature -->
								<img class="img-fluid img-thumbnail rounded" src="" alt="formation image" id="miniature" style="object-fit: cover;">
							</div>
						</div>
						<div class="mt-2 text-center">
							<input onchange="handleMiniature(this.files);" id="miniature-uploader" class="d-none" type="file" name='miniature' accept=".jpg, .jpeg, .png">
							<!-- id : miniature-uploader -->
							<label class="btn btn-warning" for="miniature-uploader">
								<i class="fa-solid fa-image"></i> Changer Miniture
							</label>
							<small class="error-miniature text-danger d-block"></small>
						</div>
						<label class="mt-2 form-label" style="font-weight: 600;">Fichiers Attaches</label>
						<div class="text-center">
							<input onchange="handleRessourse(this.files);" id="ressource" class="d-none" type="file" name='ressource' accept=".zip">
							<label class="btn btn-warning" for="ressource">
								<!-- id : ressource -->
								<i class="fa-solid fa-file"></i> Charger Ressources
							</label>
							<small class="error-ressources text-danger d-block"></small>
						</div>
						<small style="font-size: 12px;" class="text-danger d-block mt-2">Veuillez compresser tous les fichiers et dossiers dans un seul document <strong>ZIP</strong>, l'ancien document sera supprimé après le chargement !!!</small>
						<input id="id" type="hidden" name="id_formation">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary fermer" data-bs-dismiss="modal">Annuler</button>
					<button id="appliquer" type="submit" class="btn btn-primary">Appliquer</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php require_once APPROOT . "/views/includes/footerDashboard.php"; ?>