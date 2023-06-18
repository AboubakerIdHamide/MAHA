<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= URLROOT . '/public' ?>/images/favicon.ico">
    <title>MAHA | Demande de Payment</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/bootstrap.min.css" />
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/dashBoardNav.css">
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/dashboard-formateur.css" />
    <link rel="stylesheet" href="<?= URLROOT ?>/public/css/videos.css" />
    <link rel="stylesheet" href="<?= URLROOT ?>/public/css/notifications.css" />
</head>

<body>
    <!-- Header -->
    <header>
        <span id="overlay"></span>
        <div class="logo" data-user-name="<?= $_SESSION['user']['prenom'] ?>">
            <img src="<?= $_SESSION['user']['avatar'] ?>" alt="avatar">
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
                <li id="statistics"><a href="<?= URLROOT . '/formateurs/subscriptionCode' ?>"><i class="fa-solid fa-lock"></i><span> Code</span></a></li>
                <li id="disconnect"><a href="<?= URLROOT . '/users/logout' ?>"><i class="fas fa-sign-out-alt"></i><span>Déconnexion</span></a></li>
            </ul>
        </nav>
    </header>
    <!-- end Header -->
    <div class="container mt-3">
        <h5 class="mb-3 ms-4">Code D'abonnement Privé</h5>
        <form action="" method="POST" class="ms-4">
            <div class="form-group">
                <label for="code-formateur">Changer le code d'abonnement</label>
                <div class="d-flex gap-3 mt-1">
                    <input type="text" id="code-formateur" value="<?= isset($data['code_formateur']) ? $data['code_formateur'] : $_SESSION['user']['code_formateur'] ?>" disabled class="form-control">
                    <button type="button" class="btn btn-primary" id="copy-btn">
                        <i class="fa-solid fa-copy"></i>
                    </button>
                    <button class="btn btn-primary">
                        <i class="fa-solid fa-refresh"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const copyBtn=document.getElementById("copy-btn");
        const inputCode=document.getElementById("code-formateur");
        copyBtn.addEventListener('click', ()=>{
            navigator.clipboard.writeText(inputCode.value);
            copyBtn.innerHTML=`<i class="fa-solid fa-check"></i>`;
            setTimeout(()=>{
                copyBtn.innerHTML=`<i class="fa-solid fa-copy"></i>`;
            }, 5000)
        })
    </script>


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