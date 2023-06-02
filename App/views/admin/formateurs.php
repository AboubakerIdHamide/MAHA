<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<main class="container ps-5 pe-5 me-lg-5 p-md-0 mt-3 bg-color p-lg-3 rounded">
    <div class="row mb-3 justify-content-center">
        <form class="col d-flex gap-3">
            <input placeholder="Nom Formateur" type="text" class="form-control form-control-sm" name="q">
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
                            <th>Creation</th>
                            <th>Paypal</th>
                            <th>Spécialité</th>
                            <th>Balance</th>
                            <th colspan="2" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['formateurs'] as $formateur) : ?>
                        <tr>
                            <input type="hidden" value="<?= $formateur->biography ?>" class="biographie-formateur">
                            <td><?= $formateur->id_formateur ?></td>
                            <td class="d-flex gap-1" style="font-weight: 500;">
                                <img style="width: 35px;" class="img-fluid rounded-circle avatar-formateur"
                                    src="<?= $formateur->img_formateur ?>" alt="formateur avatar">
                                <div class="d-flex flex-column me-3">
                                    <span class="nom-formateur"><?= $formateur->nom_formateur ?></span>
                                    <span class="prenom-formateur"><?= $formateur->prenom_formateur ?></span>
                                </div>
                            </td>
                            <td class="email-formateur"><?= $formateur->email_formateur ?></td>
                            <td class="tele-formateur"><?= $formateur->tel_formateur ?></td>
                            <td><?= $formateur->date_creation_formateur ?></td>
                            <td class="paypal-formateur"><?= $formateur->paypalMail ?></td>
                            <td class="specialite-formateur" id="<?= $formateur->id_categorie ?>">
                                <?= $formateur->nom_categorie ?></td>
                            <td class="text-center"><strong><span style="font-size: 15px;"
                                        class="badge bg-dark"><?= $formateur->balance ?> $</span></strong></td>
                            <td class="text-center">
                                <input id="<?= $formateur->id_formateur ?>" class="btn btn-danger btn-sm delete"
                                    type="button" value="Supprimer" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                            </td>
                            <td class="text-center">
                                <input id="<?= $formateur->id_formateur ?>" class="btn btn-info btn-sm edit"
                                    type="button" value="Modifier" data-bs-toggle="modal" data-bs-target="#editModal">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<!-- Edit Formateur Modal Start -->
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
                    <label for="avatar-formateur" class="form-label" style="font-weight: 600;">Photo de profil</label>
                    <div class="text-center">
                        <!-- avatar -->
                        <img class="img-fluid rounded" src="" alt="formateur avatar" id="avatar-formateur"
                            style="object-fit: cover;width:50%">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="nom-formateur" class="form-label" style="font-weight: 600;">Nom</label>
                    <!-- nom -->
                    <input type="text" class="form-control" id="nom-formateur">
                </div>
                <div class="mb-3">
                    <!-- prenom -->
                    <label for="prenom-formateur" class="form-label" style="font-weight: 600;">Prenom</label>
                    <input type="text" class="form-control" id="prenom-formateur">
                </div>
                <div class="mb-3">
                    <!-- email -->
                    <label for="email-formateur" class="form-label" style="font-weight: 600;">Email</label>
                    <input type="email" class="form-control" id="email-formateur">
                </div>
                <div class="mb-3">
                    <!-- email paypal -->
                    <label for="email-pay-formateur" class="form-label" style="font-weight: 600;">Email Paypal</label>
                    <input type="email" class="form-control" id="email-pay-formateur">
                </div>
                <div class="mb-3">
                    <!-- telephone  -->
                    <label for="telephone-formateur" class="form-label" style="font-weight: 600;">Telephone</label>
                    <input type="number" class="form-control" id="telephone-formateur">
                </div>
                <div class="mb-3">
                    <label for="categorie" class="form-label" style="font-weight: 600;">Spécialité</label>
                    <select class="form-select" id="specialite">
                        <?php foreach ($data['specialite'] as $specialite) : ?>
                        <option value="<?= $specialite->id_categorie ?>"><?= $specialite->nom_categorie ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <!-- prenom -->
                    <label for="biographie-formateur" class="form-label" style="font-weight: 600;">Biographie</label>
                    <textarea class="form-control" id="biographie-formateur" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                <button id="appliquer" type="button" class="btn btn-primary btn-sm">Appliquer</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Formateur Modal end -->

<!-- Delete Formateur Modal Start -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Supprimer Formation</h1>
                <button type="button" class="btn-close close-modal-delete" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Etes-vous sûr que vous voulez supprimer ?</p>
                <div class="text-danger"><strong id="nom-formateur-modal"></strong></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">fermer</button>
                <button type="button" class="btn btn-danger btn-sm" id="delete-formateur">supprimer</button>
            </div>
        </div>
    </div>
</div>
<!-- Detele Formateur Modal end -->
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
</script>
<script src="<?= URLROOT; ?>/public/jQuery/jquery-3.6.0.min.js"></script>
<script src="<?= URLROOT; ?>/public/js/dashBoardNav.js"></script>
<script src="<?= URLROOT; ?>/public/js/adminFormateurs.js"></script>
</body>

</html>