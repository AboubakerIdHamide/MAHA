<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= URLROOT . '/public' ?>/images/favicon.ico">
    <title><?= SITENAME ?> | Notifications</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/dashBoardNav.css" ?>">
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/etudiantFormation.css" ?>">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= URLROOT ?>/public/css/notifications.css" />

</head>

<body>
    <?php require_once APPROOT . "/views/includes/etudiantHeader.php"; ?>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Commentaires</h5>
            <button id="clear-seen" class="btn btn-secondary btn-sm">Effacer les notifications vues</button>
        </div>
        <div class="containter notifications mt-3"></div>
    </div>
    </div>
    </div>
    <script>
        const urlRoot = "<?= URLROOT ?>";
        const controller = "etudiants";
    </script>
    <script src="<?= URLROOT . "/Public/jQuery/jquery-3.6.0.min.js" ?>"></script>
    <script src="<?= URLROOT . "/Public/js/dashBoardNav.js" ?>"></script>
    <script src="<?= URLROOT . "/Public/js/etudiantFormations.js" ?>"></script>
    <script src="<?= URLROOT; ?>/public/js/notifications.js"></script>
</body>

</html>