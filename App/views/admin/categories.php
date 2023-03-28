<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<div class="container mt-3">
    <div class="row">
        <div class="col-12 col-lg-6">
            <form id="categorie-form" class="border border-dark p-3 rounded mb-4">
                <h3>Ajouter Catégorie</h3>
                <div class="mb-3">
                    <div class="mb-3">
                        <label for="categorie" class="form-label">Entrer une catégorie</label>
                        <input type="text" name="nom_categorie" class="form-control" id="categorie" placeholder="Entrer une catégorie" required>
                    </div>
                    <div class="mb-3">
                        <label for="icon" class="form-label">Entrer une icon categorie (font awesome)</label>
                        <input type="text" name="icon" class="form-control" id="icon" placeholder="Entrer une icon categorie" required>
                    </div>
                    <div class="d-grid">
                        <button id="ajouter-categorie" class="btn btn-primary">Ajouter une catégorie</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-lg-6">
            <form id="sous-categorie-form" class="border border-dark p-3 rounded">
                <h3>Ajouter Sous-catégories</h3>
                <div class="mt-3">
                    <label for="categorie-choisir" class="form-label">Choisissez la categorie</label>
                    <select class="form-select" name="id_categorie" id="categorie-choisir" required>
                        <?php foreach ($data['categories'] as $categorie) : ?>
                            <option value="<?= $categorie->id_categorie ?>"><?= $categorie->nom_categorie ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="mt-3">
                    <label for="sous-categorie" class="form-label">Entrer une sous-catégorie</label>
                    <input name="sous_categorie" type="text" class="form-control" id="sous-categorie" placeholder="Entrer une sous-catégorie" required>
                    <div class="d-grid mt-3">
                        <button id="ajouter-sous-categorie" class="btn btn-primary">Ajouter une sous-catégorie</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <?php foreach ($data['categories'] as $categorie) : ?>
                <li class="categorie border border-dark mb-1 p-2 rounded d-flex justify-content-between align-items-center">
                    <span><?= $categorie->nom_categorie ?></span>
                    <div class="buttons">
                        <button data-bs-toggle="modal" data-bs-target="#showModal" class="btn btn-primary btn-sm show" data-id-categorie="<?= $categorie->id_categorie ?>">Show</button>
                        <button data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-info btn-sm mx-2 edit" data-id-categorie="<?= $categorie->id_categorie ?>" data-nom-categorie="<?= $categorie->nom_categorie ?>">Edit</button>
                        <button id="<?= $categorie->id_categorie ?>" class="btn btn-danger btn-sm delete">Delete</button>
                    </div>
                </li>
            <?php endforeach ?>
        </div>
    </div>

</div>
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier Categorie</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <label for="modifier-cat" class="form-label">Nouveau Nom</label>
                    <input name="nom_categorie" type="text" class="form-control" id="modifier-cat" placeholder="Entrer Nouveau Nom" required>
                </div>
            </div>
            <div class="modal-footer">
                <button id="fermer" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button id="accepter" type="button" class="btn btn-primary">Accepter</button>
            </div>
        </div>
    </div>
</div>
<!-- end Edit Modal -->
<!-- Show Modal -->
<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Sous-Categorie</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="modal-sous-categorie" class="list-group">

                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<!-- end Show Modal -->
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
</script>
<script src="<?php echo URLROOT; ?>/public/jQuery/jquery-3.6.0.min.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/dashBoardNav.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/categories.js"></script>
</body>

</html>