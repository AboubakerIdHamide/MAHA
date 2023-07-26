<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= URLROOT . '/public' ?>/images/favicon.ico">
    <title><?= SITENAME ?> | Mes videos</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- BootStrap -->
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/bootstrap.quartz.min.css" ?>">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/watchedBookMarkedVideos.css" ?>">
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/dashBoardNav.css" ?>">
</head>

<body>
    <?php require_once APPROOT . "/views/includes/etudiantHeader.php"; ?>
    <div class="container">
        <?php if (count($data["videos"]) === 0) : ?>
        <div class="alert alert-danger mt-3">Aucune video est ajouté !</div>
        <?php endif ?>
        <ul class="cards">
            <?php foreach ($data["videos"] as $video) { ?>
            <li class="cards_item">
                <div class="card">
                    <div class="card_image">
                        <video controls src="<?= $video->url ?>"></video>
                    </div>
                    <div class="card_content">
                        <h2 class="card_title"><?= $video->nomVideo ?></h2>
                        <p class="card_text"><?= $video->description ?></p>
                        <a href="<?= URLROOT . "/etudiants/coursVideos/" . $video->id_formateur . "/" . $video->id_formation ?>"
                            class="btn card_btn"><?= $video->nomFormation ?></a>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>

    <script src="<?= URLROOT . "/Public/js/dashBoardNav.js" ?>"></script>
</body>

</html>