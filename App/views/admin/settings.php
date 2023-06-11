<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<main class="container px-5 me-lg-5 p-md-0 mt-3 bg-color p-lg-3 rounded">
    <div class="row mb-3 pt-5 pt-lg-0">
        <div class="col">
            <form id="settings-form">
                <h4 class="mb-3">Paramètre</h4>
                <div class="mb-3">
                    <label for="platform-pourcentage" class="form-label">Platform Pourcentage (%)</label>
                    <input value="<?= $data->platform_pourcentage ?>" type="text" id="platform-pourcentage"
                        name="platform_pourcentage" class="form-control" placeholder="Platform Pourcentage" required>
                </div>
                <div class="mb-3">
                    <label for="username-p" class="form-label">Username Paypal</label>
                    <input value="<?= $data->username_paypal ?>" type="text" id="username-p" name="username_p"
                        class="form-control" placeholder="Username Paypal" required>
                </div>
                <div class="mb-3">
                    <label for="password-p" class="form-label">Password Paypal</label>
                    <input value="<?= $data->password_paypal ?>" type="text" id="password-p" name="password_p"
                        class="form-control" placeholder="Password Paypal" required>
                </div>
                <button class="btn btn-primary">Changer</button>
            </form>
        </div>
    </div>
</main>
<script src="<?= URLROOT ?>/public/js/bootstrap.bundle.min.js"></script>
<script src="<?= URLROOT; ?>/public/jQuery/jquery-3.6.0.min.js"></script>
<script src="<?= URLROOT; ?>/public/js/dashBoardNav.js"></script>
<script type="text/javascript">
$('#settings-form').submit(function(event) {
    event.preventDefault();
    $.ajax({
        url: '<?= URLROOT ?>' + '/admin/settings',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            $('#settings-form').prepend(
                `<div class="alert alert-success" role="alert">${response}</div>`);
        },
        fail: function(res) {
            $('#settings-form').prepend(
                `<div class="alert alert-danger" role="alert">${response}</div>`);
        }
    });
});
</script>
</body>

</html>