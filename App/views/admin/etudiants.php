<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<main class="container ps-5 pe-5 me-lg-5 p-md-0 mt-3 bg-color p-lg-3 rounded">
    <div class="row mb-3 justify-content-center">
        <form class="col d-flex gap-3">
            <input placeholder="Nom Etudiant" type="text" class="form-control form-control-sm" name="q">
            <button class="btn btn-primary btn-sm" style="white-space: nowrap;">Chercher <i
                    class="fa-sharp fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Nom & Prenom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Creation de Compte</th>
                            <th class="text-center">Inscriptions</th>
                            <th colspan="2" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $etudiant) : ?>
                        <tr>
                            <td class="text-center"><?= $etudiant->id_etudiant ?></td>
                            <td class="d-flex gap-1" style="font-weight: 500;">
                                <img class="img-fluid me-1 rounded-circle avatar-etudiant"
                                    src="<?= $etudiant->img_etudiant ?>" alt="etudiant avatar">
                                <div class="d-flex flex-column me-3">
                                    <span class="nom-etudiant"><?= $etudiant->nom_etudiant ?></span>
                                    <span class="prenom-etudiant"><?= $etudiant->prenom_etudiant ?></span>
                                </div>
                            </td>
                            <td class="email-etudiant"><?= $etudiant->email_etudiant ?></td>
                            <td class="tele-etudiant"><?= $etudiant->tel_etudiant ?></td>
                            <td><?= $etudiant->date_creation_etudiant ?></td>
                            <td class="text-center"><span
                                    class="nbr-inscriptions"><?= $etudiant->total_inscription ?></span> inscriptions
                                <?php if ($etudiant->total_inscription != 0) echo '<button class="btn btn-primary btn-sm show" id="' . $etudiant->id_etudiant . '" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fa-solid fa-eye"></i></button>' ?>
                            </td>
                            <td class="text-center">
                                <button id="<?= $etudiant->id_etudiant ?>" class="btn btn-info btn-sm edit"
                                    type="button" data-bs-toggle="modal" data-bs-target="#editModal"><i
                                        class="fa-solid fa-pen-to-square"></i> Modifier</button>
                            </td>
                            <td class="text-center">
                                <button id="<?= $etudiant->id_etudiant ?>" class="btn btn-danger btn-sm delete"
                                    type="button" data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                                        class="fa-solid fa-trash"></i> Supprimer</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Edit etudiant Modal Start -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modification</h1>
                <button type="button" class="btn-close close-modal-edit" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="avatar-etudiant" class="form-label" style="font-weight: 600;">Photo de profil</label>
                    <div class="text-center">
                        <!-- avatar -->
                        <img class="img-fluid rounded" src="<?= URLROOT; ?>/public/images/membre.jpg"
                            alt="etudiant avatar" id="avatar-etudiant" style="object-fit: cover;width:50%">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="nom-etudiant" class="form-label" style="font-weight: 600;">Nom</label>
                    <!-- nom -->
                    <input type="text" class="form-control" id="nom-etudiant">
                </div>
                <div class="mb-3">
                    <!-- prenom -->
                    <label for="prenom-etudiant" class="form-label" style="font-weight: 600;">Prenom</label>
                    <input type="text" class="form-control" id="prenom-etudiant">
                </div>
                <div class="mb-3">
                    <!-- email -->
                    <label for="email-etudiant" class="form-label" style="font-weight: 600;">Email</label>
                    <input type="email" class="form-control" id="email-etudiant">
                </div>
                <div class="mb-3">
                    <!-- telephone  -->
                    <label for="telephone-etudiant" class="form-label" style="font-weight: 600;">Telephone</label>
                    <input type="number" class="form-control" id="telephone-etudiant">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                <button id="appliquer" type="button" class="btn btn-primary btn-sm">Appliquer</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit etudiant Modal end -->

<!-- Delete etudiant Modal Start -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Confirmer la suppression</h1>
                <button type="button" class="btn-close close-modal-delete" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Etes-vous sûr que vous voulez supprimer ?</p>
                <div class="text-danger"><strong class="d-block" id="nom-etudiant-modal"></strong></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">fermer</button>
                <button type="button" class="btn btn-danger btn-sm" id="delete-etudiant">supprimer</button>
            </div>
        </div>
    </div>
</div>
<!-- Detele etudiant Modal end -->
<!-- Voir Formations Modal Start -->
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Inscriptions</h1>
                <button type="button" class="btn-close close-modal-delete" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">fermer</button>
            </div>
        </div>
    </div>
</div>
<!-- Voir Formations Modal end -->
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
<script src="<?= URLROOT; ?>/public/jQuery/jquery-3.6.0.min.js"></script>
<script src="<?= URLROOT; ?>/public/js/dashBoardNav.js"></script>
<script src="<?= URLROOT; ?>/public/js/adminEtudiants.js"></script>
</body>

</html>