<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<div class="container mt-3">
    <div class="row">
        <div class="col-12 col-lg-6">
            <form id="langue-form" class="border border-dark p-3 rounded mb-4">
                <h3>Ajouter Langue</h3>
                <div class="mb-3">
                    <div class="mb-3">
                        <label for="langue" class="form-label">Entrer une langue</label>
                        <input type="text" name="nom_langue" class="form-control" id="langue" placeholder="Entrer une langue" required>
                    </div>
                    <div class="d-grid">
                        <button id="ajouter-langue" class="btn btn-primary">Ajouter une langue</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-lg-6">
            <h3>List Langues</h3>
            <ul class="list-group" id="langues">
                <?php foreach ($data['langues'] as $langue) : ?>
                    <li class="list-group-item langue d-flex justify-content-between align-items-center">
                        <span><?= $langue->nom_langue ?></span>
                        <button data-id-langue="<?= $langue->id_langue ?>" class="btn btn-danger btn-sm delete"><i class="fa-solid fa-trash"></i></button>
                    </li>

                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>
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
<script src="<?php echo URLROOT; ?>/public/js/langues.js"></script>
</body>

</html>