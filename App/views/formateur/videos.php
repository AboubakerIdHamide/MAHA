	<?php require_once APPROOT."/views/includes/dashBoardNav.php";?>
	<main class="container my-5 ps-md-5">
		<div class="row mb-3 align-items-center ms-md-3 ms-xl-0">
			<div class="col-2 col-sm-2 col-md-1 col-lg-1">
				<i class="fas fa-chevron-left go-back rounded"></i>
			</div>
			<div class="col col-sm col-md col-lg">
				<h1>Le Nom De La Formation</h1>
				<p>November 7, 2022</p>
				<span>Toutes les videos (45 videos)</span>
			</div>
		</div>
		<div class="row mb-3 align-items-center p-2 video rounded flex-sm-column flex-md-row ms-md-3 ms-lg-4 ms-xl-0">
			<div class="col-xxl-7 col-xl-7 col-lg-6 col-md-8 col-sm">
				<span class="video-name">1 - Compound Join Conditions</span>
				<span class="badge bg-secondary"><i class="fas fa-clock"></i> 11 : 52</span>
			</div>
			<div class="col-lg col-md col-sm mt-3 mt-md-0">
				<button class="btn btn-dark btn-sm apercu" data-bs-toggle="modal" data-bs-target="#voir"><span class="label-btn">Aperçu</span> <i class="fa-solid fa-video"></i></button>
				<a href="#" class="btn btn-warning btn-sm"><span class="label-btn">Télécharger</span> <i class="fa-solid fa-download"></i></a>
				<button class="btn btn-info btn-sm edit" data-bs-toggle="modal" data-bs-target="#modifier"><span class="label-btn">Modifier</span> <i class="fa-solid fa-pen-to-square"></i></button>
				<button class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#supprimer"><span class="label-btn">Supprimer</span> <i class="fa-solid fa-trash"></i></button>
			</div>
		</div>
		<div class="row mb-3 align-items-center p-2 video rounded flex-sm-column flex-md-row ms-md-3 ms-lg-4 ms-xl-0">
			<div class="col-xxl-7 col-xl-7 col-lg-6 col-md-8 col-sm">
				<span class="video-name">2 - Compound Join Conditions</span>
				<span class="badge bg-secondary"><i class="fas fa-clock"></i> 11 : 52</span>
			</div>
			<div class="col-lg col-md col-sm mt-3 mt-md-0">
				<button class="btn btn-dark btn-sm apercu" data-bs-toggle="modal" data-bs-target="#voir"><span class="label-btn">Aperçu</span> <i class="fa-solid fa-video"></i></button>
				<a href="#" class="btn btn-warning btn-sm"><span class="label-btn">Télécharger</span> <i class="fa-solid fa-download"></i></a>
				<button class="btn btn-info btn-sm edit" data-bs-toggle="modal" data-bs-target="#modifier"><span class="label-btn">Modifier</span> <i class="fa-solid fa-pen-to-square"></i></button>
				<button class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#supprimer"><span class="label-btn">Supprimer</span> <i class="fa-solid fa-trash"></i></button>
			</div>
		</div>
		<div class="row mb-3 align-items-center p-2 video rounded flex-sm-column flex-md-row ms-md-3 ms-lg-4 ms-xl-0">
			<div class="col-xxl-7 col-xl-7 col-lg-6 col-md-8 col-sm">
				<span class="video-name">3 - Compound Join Conditions</span>
				<span class="badge bg-secondary"><i class="fas fa-clock"></i> 11 : 52</span>
			</div>
			<div class="col-lg col-md col-sm mt-3 mt-md-0">
				<button class="btn btn-dark btn-sm apercu" data-bs-toggle="modal" data-bs-target="#voir"><span class="label-btn">Aperçu</span> <i class="fa-solid fa-video"></i></button>
				<a href="#" class="btn btn-warning btn-sm"><span class="label-btn">Télécharger</span> <i class="fa-solid fa-download"></i></a>
				<button class="btn btn-info btn-sm edit" data-bs-toggle="modal" data-bs-target="#modifier"><span class="label-btn">Modifier</span> <i class="fa-solid fa-pen-to-square"></i></button>
				<button class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#supprimer"><span class="label-btn">Supprimer</span> <i class="fa-solid fa-trash"></i></button>
			</div>
		</div>
		
		
		
	</main>
	<section class="modifier">
		<!-- Modal -->
		<div class="modal fade" id="modifier" tabindex="-1" aria-labelledby="modifier" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h1 class="modal-title fs-5" id="modifier">Modification</h1>
		        <small class="nom-video text-muted ms-3">nom-video</small>
		        <button type="button" class="btn-close fermer" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		      	<div class="mb-3">
		        	<label for="description" class="form-label" style="font-weight: 600;">Description</label>
  					<textarea class="form-control" id="description" rows="3">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae earum, neque quas! Doloremque perspiciatis nemo ut quam ullam suscipit exercitationem itaque, quis consequatur, commodi, consectetur sed aspernatur blanditiis nobis quae.</textarea>
  					<small class="error-desc text-danger"></small>
  				</div>
  				<div>
  					<label for="title" class="form-label" style="font-weight: 600;">Titre</label>
 					<input type="text" class="form-control" id="title" placeholder="Compound Join Conditions">
 					<small class="error-title text-danger"></small>
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
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
		        <button id="delete-video" type="button" class="btn btn-primary">Oui</button>
		      </div>
		    </div>
		  </div>
		</div>
	</section>
	<section class="voir">
		<!-- Modal -->
		<div class="modal fade" id="voir" tabindex="-1" aria-labelledby="voir" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h1 class="modal-title fs-5" id="voir">Aperçu</h1>
		        <small class="nom-video text-muted ms-3">nom-video</small>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <video id="mp4-video" class="ratio ratio-16x9" src="" controls></video>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
		      </div>
		    </div>
		  </div>
		</div>
	</section>
<?php require_once APPROOT."/views/includes/footerDashboard.php";?>