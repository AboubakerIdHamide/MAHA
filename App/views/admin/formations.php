<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<main class="container mt-3 rounded">
    <div class="row mb-3 justify-content-center">
        <form class="col d-flex gap-3">
            <input placeholder="chercher ..." type="text" class="form-control form-control-sm" name="q">
            <select name="critere" class="form-select form-select-sm w-25" aria-label=".form-select-sm example">
                <option value="nom_formation">Nom Formation</option>
                <option value="nom_formateur">Nom Formateur</option>
            </select>
            <button id="chercher" class="btn btn-primary btn-sm" style="white-space: nowrap;">Chercher <i class="fa-sharp fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>
    <div class="row fomations">
        <?php
        if (empty($data["formations"])) {
            if (isset($_GET["q"]) || !empty($_GET["q"]))
                echo '<div class="alert alert-danger" role="alert">la formation ou le formateur : <strong>' . $_GET["q"] . "</strong> n'existe pas.</div>";
            else
                echo '<div class="alert alert-danger" role="alert">Aucune Formation Existe !!!</div>';
        }
        ?>
        <?php foreach ($data["formations"] as $formation) : ?>
            <div class="col-md-6 col-lg-4 col-xxl-3 mb-3 formation-<?= $formation->id_formation ?>">
                <div class="card text-center shadow-lg">
                    <div class="card-header">
                        <div class="mt-1 mb-3 text-center">
                            <button id="<?= $formation->id_formation ?>" class="btn btn-sm btn-dark voir" type="button" data-bs-toggle="modal" data-bs-target="#videosModal">Videos</button>
                            <input id="<?= $formation->id_formation ?>" class="btn btn-sm btn-primary edit" type="button" value="Modifier" data-bs-toggle="modal" data-bs-target="#editModal">
                            <input id="<?= $formation->id_formation ?>" class="btn btn-sm btn-danger delete" type="button" value="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        </div>
                        <div class="d-flex gap-2 justify-content-center align-items-center">
                            <img class="img-fluid rounded-circle border border-info" style="width: 38px;" src="<?= $formation->img_formateur ?>" alt="avatar formateur">
                            <div class="d-flex flex-column align-items-start">
                                <span style="font-weight: 600;font-size: 13px;"><?= $formation->nom_formateur ?>
                                    <?= $formation->prenom_formateur ?></span>
                                <small style="max-width: 200px;" class="badge bg-info d-inline-block text-truncate categorie" id="<?= $formation->id_categorie ?>" title="<?= $formation->nom_categorie ?>"><?= $formation->nom_categorie ?></small>
                            </div>
                        </div>
                        <hr>
                        <span class="d-block"><?= $formation->date_creation_formation ?></span>
                        <span class="badge bg-warning langue" id="<?= $formation->id_langue ?>"><?= $formation->nom_langue ?></span>
                    </div>
                    <div class="card-body">
                        <img class="img-fluid rounded miniature" style="max-height: 250px;object-fit:cover" src="<?= $formation->image_formation ?>" alt="formation image">
                        <h6 style="font-weight: 800;" title="<?= $formation->nom_formation ?>" class="card-title mt-2 mb-1 text-truncate title"><?= $formation->nom_formation ?></h6>
                        <span class="badge bg-secondary mb-2"><i class="fas fa-clock"></i>
                            <?= $formation->mass_horaire ?></span>
                        <p class="card-text text-truncate description" title="<?= $formation->description ?>">
                            <?= $formation->description ?>
                        </p>
                    </div>
                    <div class="card-footer text-muted d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column gap-2">
                            <span class="badge bg-black"><?= $formation->likes ?> <i class="fa fa-heart"></i></span>
                            <span class="badge bg-black niveau" id="<?= $formation->id_niveau ?>"><?= $formation->nom_niveau ?></span>
                        </div>
                        <p class="m-0 h4"><span class="badge bg-info"><span class="prix"><?= $formation->prix_formation ?></span> $</span></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<!-- Voir Modal start -->
<div class="modal fade" id="videosModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"></h1>
                <button type="button" class="btn-close close-modal-voir" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion accordion-flush" id="accordionFlushExample"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<!-- Voir Modal end -->
<!-- Edit Modal start -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modification</h1>
                <button type="button" class="btn-close close-modal-edit" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                    <label for="niveau" class="form-label" style="font-weight: 600;">Niveau de formation</label>
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
                    <label for="miniature" class="form-label" style="font-weight: 600;">Miniature</label>
                    <div class="text-center">
                        <!-- id :  miniature -->
                        <img class="img-fluid img-thumbnail rounded" src="" alt="formation image" id="miniature" style="object-fit: cover;">
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <input onchange="handleMiniature(this.files);" id="miniature-uploader" class="d-none" type="file" name='miniature' accept=".jpg, .jpeg, .png">
                    <!-- id : miniature-uploader -->
                    <label class="btn btn-warning" for="miniature-uploader">
                        <i class="fa-solid fa-image"></i> Changer Miniature
                    </label>
                    <small class="error-miniature text-danger d-block"></small>
                </div>
                <label class="mt-2 form-label" style="font-weight: 600;">Fichiers Attachés</label>
                <div class="text-center">
                    <input onchange="handleRessourse(this.files);" id="ressource" class="d-none" type="file" name='ressource' accept=".zip">
                    <label class="btn btn-warning" for="ressource">
                        <!-- id : ressource -->
                        <i class="fa-solid fa-file"></i> Charger Ressources
                    </label>
                    <small class="error-ressources text-danger d-block"></small>
                </div>
                <small style="font-size: 12px;" class="text-danger d-block mt-2">Veuillez compresser tous les fichiers
                    et dossiers dans un seul document <strong>ZIP</strong>, l'ancien document sera supprimé après le
                    chargement !!!</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                <button id="appliquer" type="button" class="btn btn-primary btn-sm appliquer">Appliquer</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Modal end -->
<!-- Delete Modal start -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Supprimer Formation</h1>
                <button type="button" class="btn-close close-modal-delete" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Etes-vous sûr que vous voulez supprimer ?</p>
                <div class="text-danger"><strong class="nom-formation-modal"></strong></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-danger btn-sm delete-formation" id="delete-formation">Supprimer</button>
            </div>
        </div>
    </div>
</div>
<!-- Delete Modal end -->
<!-- toast start -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body rounded d-flex justify-content-between">
            <span id="message" class="text-white"></span>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<!-- toast end -->
<script src="<?= URLROOT ?>/public/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo URLROOT; ?>/public/jQuery/jquery-3.6.0.min.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/dashBoardNav.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/adminFormations.js"></script>
</body>

</html>