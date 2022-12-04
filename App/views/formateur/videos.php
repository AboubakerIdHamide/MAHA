	<?php require_once APPROOT . "/views/includes/dashBoardNav.php"; ?>
	<main class="container my-5 ps-md-5">
		<div class="row mb-3 align-items-center ms-md-3 ms-xl-0 header">
			<div class="col-2 col-md-2 col-lg-1">
				<a href="<?= URLROOT ?>/formateur/dashboard"><i class="fas fa-chevron-left go-back rounded"></i></a>
			</div>
			<div class="col-6 col-md-7 col-lg-9">
				<h1><?= $data[0]->nom_formation ?></h1>
				<p><?= $data[0]->date_creation_formation ?></p>
				<span>Total videos (<?= count($data) ?> videos)</span>
			</div>
			<div class="col">
				<a href="<?= URLROOT?>/formations/addVideo/<?= $_SESSION['id_formation']?>" class="btn btn-primary">Add Video <i class="fa-solid fa-file-circle-plus"></i></a>
			</div>
		</div>
		<?php flash('deteleVideo') ?>
		<?php flash('updateVideo') ?>
		<?php $order = 1 ?>
		<?php foreach ($data as $video) : ?>
			<div class="row mb-3 align-items-center p-2 video rounded flex-sm-column flex-md-row ms-md-3 ms-lg-4 ms-xl-0">
				<div class="col-1 p-0" style="width: 50px;">
					<input style="width: 56px;text-align: center;" maxlength="3" type="text" class="order-video form-control" placeholder="<?= $order ?>" />
				</div>
				<div class="col-xl-7 col-lg-6 col-md-8 col-sm">
					<span class="video-name"><?= $video->nom_video ?></span>
					<span class="badge bg-secondary"><i class="fas fa-clock"></i> <?= $video->duree_video ?></span>
				</div>
				<input id="description-video" type="hidden" value="<?= $video->description_video ?>">
				<input id="link-video" type="hidden" value="<?= $video->url_video ?>">
				<div class="col-lg col-md col-sm mt-3 mt-md-0">
					<a href="<?= $video->url_video ?>" class="btn btn-warning btn-sm" download><span class="label-btn">Télécharger</span> <i class="fa-solid fa-download"></i></a>
					<button id="<?= $video->id_video ?>" class="btn btn-info btn-sm edit" data-bs-toggle="modal" data-bs-target="#modifier"><span class="label-btn">Modifier</span> <i class="fa-solid fa-pen-to-square"></i></button>
					<button id="<?= $video->id_video ?>" class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#supprimer"><span class="label-btn">Supprimer</span> <i class="fa-solid fa-trash"></i></button>
				</div>
			</div>
			<?php $order++; ?>
		<?php endforeach; ?>

	</main>

	<!-- End Main -->

	<section class="modifier">
		<!-- Modal -->
		<div class="modal fade" id="modifier" tabindex="-1" aria-labelledby="modifier" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="modifier">Modification</h1>
						<small class="nom-video text-muted ms-3"></small>
						<button type="button" class="btn-close fermer" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div>
							<label class="form-label" for="mp4-video" style="font-weight: 600;">Aperçu</label>
							<video id="mp4-video" class="ratio ratio-16x9 rounded" src="" controls></video>
						</div>
						<div class="my-3">
							<label for="title" class="form-label" style="font-weight: 600;">Titre</label>
							<input type="text" class="form-control" id="title">
							<small class="error-title text-danger"></small>
						</div>
						<div>
							<label for="description" class="form-label" style="font-weight: 600;">Description</label>
							<textarea class="form-control" id="description" rows="3"></textarea>
							<small class="error-desc text-danger"></small>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="fermer">Fermer</button>
						<button id="apply-btn" type="button" class="btn btn-primary">Appliquer</button>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="supprimer">
		<!-- Modal -->
		<div class="modal fade" id="supprimer" tabindex="-1" aria-labelledby="supprimer" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="supprimer">Supression</h1>
						<small class="nom-video text-muted ms-3"></small>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<span style="font-weight: 600;">Etes-vous sûr que vous voulez supprimer cette video ?</span>
					</div>
					<div class="modal-footer">
						<!-- <form method="POST"> -->
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
						<button id="delete-video" type="button" class="btn btn-primary">Oui</button>
						<!-- </form> -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php require_once APPROOT . "/views/includes/footerDashboard.php"; ?>