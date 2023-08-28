<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title><?= SITENAME ?> | Demande de Payment</title>
    <!-- Font Awesome -->
    <link href="<?= CSSROOT ?>/icons/all.min.css" rel="stylesheet" />
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
                <li id="statistics"><a href="<?= URLROOT . '/formateur/subscriptionCode' ?>"><i class="fa-solid fa-lock"></i> <span>Code</span></a></li>
                <li id="disconnect"><a href="<?= URLROOT . '/user/logout' ?>"><i class="fas fa-sign-out-alt"></i><span>Déconnexion</span></a></li>
            </ul>
        </nav>
    </header>
    <!-- end Header -->
    <div class="container mt-3">
        <h5 class="mb-3">Demander un paiement</h5>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input value="<?= $_SESSION['user']->paypalMail ?>" type="email" class="form-control" id="paypal-email" placeholder="name@example.com" disabled>
                    <label for="paypal-email">Paypal email</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="montant" placeholder="Montant">
                        <label for="montant">Montant</label>
                    </div>
                    <span class="input-group-text">$</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button id="request-payment" class="btn btn-info">Demander le paiement</button>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <h5 class="mb-3">Historique des paiements</h5>
        <div class="containter history">

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
    <?php require_once APPROOT . "/views/includes/footerDashboard.php"; ?>