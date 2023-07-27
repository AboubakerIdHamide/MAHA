<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title><?= SITENAME ?> | <?= $data["videos"][0]->nomFormation ?></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/bootstrap.min.css" />
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/dashBoardNav.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/dashboard-formateur.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/videos.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/notifications.css" />
</head>

<body>
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
                    <a href="<?= URLROOT . '/formateur/notifications' ?>">
                        <i style="font-size:25px;" class="fa-solid fa-bell position-relative">
                            <?php if ($data['nbrNotifications']->totalNew != 0) : ?>
                                <span style="font-size: 9px;" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger nbr-notifications">
                                    <?= $data['nbrNotifications']->totalNew ?>
                                </span>
                            <?php endif ?>
                        </i>
                    </a>
                </li>
                <li id="addnews"><a href="<?= URLROOT . '/formateur/dashboard' ?>"><i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a></li>
                <li id="paiment"><a href="<?= URLROOT . '/formateur/requestPayment' ?>"><i class=" far fa-credit-card"></i><span>Paiement</span></a></li>
                <li id="statistics"><a href="<?= URLROOT . '/formateur/updateInfos' ?>"><i class="fas fa-user-gear"></i><span>Paramètre</span></a></li>
                <li id="disconnect"><a href="<?= URLROOT . '/user/logout' ?>"><i class="fas fa-sign-out-alt"></i><span>Déconnexion</span></a></li>
            </ul>
        </nav>
    </header>
    <!-- end Header -->
    <main class="container my-5 ps-md-5">
        <div class="row mb-3 align-items-center ms-md-3 ms-xl-0 header">
            <div class="col-2 col-md-2 col-lg-1">
                <a href="<?= URLROOT ?>/formateur/dashboard"><i class="fas fa-chevron-left go-back rounded"></i></a>
            </div>
            <div class="col-6 col-md-7 col-lg-9">
                <h1><?= $data["videos"][0]->nomFormation ?></h1>
                <p><?= $data["videos"][0]->date_creation ?></p>
                <span>Total videos (<?= count($data["videos"]) ?> videos) · <span class="badge bg-primary"><i class="fas fa-clock"></i> <?= $data["videos"][0]->masse_horaire ?></span></span>
            </div>
            <div class="col">
                <a href="<?= URLROOT ?>/formation/addVideo/<?= $_SESSION['id_formation'] ?>" class="btn btn-primary">Add
                    Video <i class="fa-solid fa-file-circle-plus"></i></a>
            </div>
        </div>
        <?php flash('deteleVideo') ?>
        <?php flash('updateVideo') ?>
        <?php $order = 1 ?>
        <hr />
        <div class="row mb-3">
            <?php flash("orderApplied") ?>
            <div class="col">
                <button class="btn btn-primary btn-sm order">Appliquer L'ordre <i class="fa-solid fa-check-to-slot"></i></button>
            </div>
        </div>
        <?php foreach ($data["videos"] as $video) : ?>
            <div class="row mb-3 p-2 video rounded">
                <div class="col-12 col-md-6">
                    <input style="width: 55px;text-align: center;" maxlength="3" type="text" class="order-video form-control d-inline-block" placeholder="<?= $order ?>" />
                    <span class="video-name text-white"><?= $video->nomVideo ?></span>
                    <span class="badge bg-secondary"><i class="fas fa-clock"></i> <?= $video->duree ?></span>
                </div>
                <input id="description-video" type="hidden" value="<?= $video->description ?>">
                <input id="link-video" type="hidden" value="<?= $video->url ?>">
                <div class="col-12 col-md-6">
                    <div class="d-flex gap-1 justify-content-end">
                        <a data-bs-custom-class="custom-tooltip" data-bs-title="Télécharger" data-bs-toggle="tooltip" data-bs-placement="top" href="<?= $video->url ?>" class="btn btn-warning btn-sm" download><i class="fa-solid fa-download"></i></a>
                        <button id="<?= $video->id_video ?>" class="btn btn-info btn-sm edit" data-bs-toggle="modal" data-bs-target="#modifier"> <i class="fa-solid fa-pen-to-square" data-bs-custom-class="custom-tooltip" data-bs-title="Modifier" data-bs-toggle="tooltip" data-bs-placement="top"></i></button>
                        <button id="<?= $video->id_video ?>" class="btn btn-primary btn-sm preview" <?php if ($video->is_preview == 1) echo 'disabled' ?>> <i class="fa-solid fa-video" data-bs-custom-class="custom-tooltip" data-bs-title="Apercu Video" data-bs-toggle="tooltip" data-bs-placement="top"></i></button>
                        <button id="<?= $video->id_video ?>" class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#supprimer"> <i class="fa-solid fa-trash" data-bs-custom-class="custom-tooltip" data-bs-title="Supprimer" data-bs-toggle="tooltip" data-bs-placement="top"></i></button>
                    </div>
                </div>
            </div>
            <?php $order++; ?>
        <?php endforeach; ?>

    </main>

    <!-- End Main -->

    <section class="modifier">
        <!-- Modal -->
        <div class="modal fade" id="modifier" tabindex="-1" aria-labelledby="modifier" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modifier">Modification</h1>
                        <small class="nom-video text-muted ms-3"></small>
                        <button type="button" class="btn-close fermer" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label class="form-label" for="mp4-video" style="font-weight: 600;">Aperçu</label>
                            <video id="mp4-video" class="ratio ratio-16x9 rounded" src="" controls></video>
                        </div>
                        <div class="my-3">
                            <label for="title" class="form-label" style="font-weight: 600;">Titre</label>
                            <input type="text" class="form-control" id="title">
                            <small class="error-title text-danger"></small>
                        </div>
                        <div>
                            <label for="description" class="form-label" style="font-weight: 600;">Description</label>
                            <textarea class="form-control" id="description" rows="3"></textarea>
                            <small class="error-desc text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="fermer">Fermer</button>
                        <button id="apply-btn" type="button" class="btn btn-primary">Appliquer</button>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="supprimer">
        <!-- Modal -->
        <div class="modal fade" id="supprimer" tabindex="-1" aria-labelledby="supprimer" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="supprimer">Supression</h1>
                        <small class="nom-video text-muted ms-3"></small>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span style="font-weight: 600;">Etes-vous sûr que vous voulez supprimer cette video ?</span>
                    </div>
                    <div class="modal-footer">
                        <!-- <form method="POST"> -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button id="delete-video" type="button" class="btn btn-primary">Oui</button>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require_once APPROOT . "/views/includes/footerDashboard.php"; ?>