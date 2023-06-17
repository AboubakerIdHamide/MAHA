<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<main class="container px-5 me-lg-5 p-md-0 mt-3 bg-color p-lg-3 rounded">
    <div class="row mb-3 pt-5 pt-lg-0">
        <div class="col">
            <form id="smtp-form">
                <h4 class="mb-3">Configurer SMTP Server</h4>
                <div class="mb-3">
                    <label for="host" class="form-label">Host</label>
                    <input value="<?= $data->host ?? '' ?>" type="text" id="host" name="host" class="form-control" placeholder="Host" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input value="<?= $data->username ?? '' ?>" type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input value="<?= $data->password ?? '' ?>" type="text" id="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <label for="port" class="form-label">Port</label>
                    <input value="<?= $data->port ?? '' ?>" type="number" id="port" name="port" class="form-control" placeholder="Port" required>
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
    $('#smtp-form').submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: '<?= URLROOT ?>' + '/admin/smtp',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#smtp-form').prepend(
                    `<div class="alert alert-success" role="alert">${response}</div>`);
            },
            fail: function(res) {
                $('#smtp-form').prepend(
                    `<div class="alert alert-danger" role="alert">${response}</div>`);
            }
        });
    });
</script>
</body>

</html>