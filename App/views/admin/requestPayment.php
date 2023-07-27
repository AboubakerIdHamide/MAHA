<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<main class="container ps-5 pe-5 me-lg-5 p-md-0 mt-3 bg-color p-lg-3 rounded">
    <div class="row mb-3 pt-5 pt-lg-0">
        <div class="col col-lg mt-3 mt-lg-0">
            <input placeholder="Nom Formateur" type="text" class="form-control" id="chercher">
        </div>
        <div class="col-2">
            <select class="form-select etat">
                <option value="pending" selected>En attente</option>
                <option value="accepted">Accepté</option>
                <option value="declined">Refusé</option>
            </select>
        </div>
    </div>
    <hr />
    <section id="requests"></section>
</main>
<script src="<?= JSROOT ?>/bootstrap.bundle.min.js"></script>
<script src="<?= URLROOT ?>/public/jQuery/jquery-3.6.0.min.js"></script>
<script src="<?= JSROOT ?>/dashBoardNav.js"></script>
<script src="<?= JSROOT ?>/adminDashboard.js"></script>
</body>

</html>