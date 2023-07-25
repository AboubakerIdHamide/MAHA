<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="<?= URLROOT . '/public' ?>/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/bootstrap.min.css" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/addVideo.css" ?>">
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/dashBoardNav.css">
    <title><?= SITENAME ?> | Ajouter Videos</title>
</head>
<!-- Header -->
<header>
    <span id="overlay"></span>
    <div class="logo" data-user-name="<?= $_SESSION['user']->prenom ?>">
        <img src="<?= $_SESSION['user']->img ?>" alt="avatar">
    </div>
    <nav>
        <div class="menu-i">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <ul class="hide-menu">
            <li id="notifications" class="justify-content-center">
                <a href="<?= URLROOT . '/formateurs/notifications' ?>">
                    <i style="font-size:25px;" class="fa-solid fa-bell position-relative">
                        <?php if ($data['nbrNotifications']->totalNew != 0) : ?>
                            <span style="font-size: 9px;" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger nbr-notifications">
                                <?= $data['nbrNotifications']->totalNew ?>
                            </span>
                        <?php endif ?>
                    </i>
                </a>
            </li>
            <li id="addnews"><a href="<?= URLROOT . '/formateurs/dashboard' ?>"><i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a></li>
            <li id="paiment"><a href="<?= URLROOT . '/formateurs/requestPayment' ?>"><i class=" far fa-credit-card"></i><span>Paiement</span></a></li>
            <li id="statistics"><a href="<?= URLROOT . '/formateurs/updateInfos' ?>"><i class="fas fa-user-gear"></i><span>Paramètre</span></a></li>
            <li id="disconnect"><a href="<?= URLROOT . '/users/logout' ?>"><i class="fas fa-sign-out-alt"></i><span>Déconnexion</span></a></li>
        </ul>
    </nav>
</header>
<!-- end Header -->
<div class="container">
    <form enctype="multipart/form-data" method="post" id="form">
        <input type="hidden" name="JsonVideos" id="jsonVideos">
        <div class="prog" id="prog_bar"></div>
        <div class="main-form-heading">
            <h1 class="logo">
                <a href="<?= URLROOT . "/pages/index"; ?>">
                    <img src="<?= $data['logo'] ?>" alt="">
                </a>
            </h1>
        </div>
        <div class="field-container">
            <?php flash("formationVide") ?>
            <div class="field-section-slyder" id="fieldSectionSlyder">
                <div class="field-section">
                    <div class="field-box">
                        <div class="input-field">
                            <div class="image-uploader for-video">
                                <input type="file" id="videos" name="videos" multiple>
                            </div>
                            <span class="error" id="error_videos"></span>
                        </div>
                    </div>
                    <div class="field-box">
                        <div class="input-field">
                            <label for="videos">Charger Votre Videos</label>
                            <div class="uploded-videos" id="uplodedVideosContainer">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-buttons">
            <button class="prev" id="prev">Annuler</button>
            <button class="next" id="next">Télécharger</button>
        </div>
    </form>
</div>
<script src="<?= URLROOT . "/Public/js/addVideo.js" ?>"></script>
<script src="<?= URLROOT; ?>/public/js/dashBoardNav.js"></script>
</body>

</html>