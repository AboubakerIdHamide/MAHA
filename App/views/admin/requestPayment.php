<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<main class="container ps-5 pe-5 me-lg-5 p-md-0 mt-3 bg-color p-lg-3 rounded">
    <div class="row mb-3 pt-5 pt-lg-0">
        <div class="col col-lg mt-3 mt-lg-0">
            <input placeholder="Nom Formateur" type="text" class="form-control" id="chercher">
        </div>
        <div class="col-2">
            <select class="form-select etat">
                <option value="pending" selected>Pending</option>
                <option value="accepted">Accepted</option>
                <option value="declined">Declined</option>
            </select>
        </div>
    </div>
    <hr />
    <section id="requests"></section>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
</script>
<script src="<?php echo URLROOT; ?>/public/jQuery/jquery-3.6.0.min.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/dashBoardNav.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/adminDashboard.js"></script>
</body>

</html>