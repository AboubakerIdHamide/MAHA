<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title><?= SITENAME ?> | Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/bootstrap.min.css" />
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/dashBoardNav.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/dashboard-formateur.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/videos.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/dashboard-admin.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/theme.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/fixNavBar.css" />
</head>

<body>
    <!-- Header -->
    <header>
        <span id="overlay"></span>
        <div class="logo" user-name="<?= $_SESSION['admin']->prenom ?>">
            <img src="<?= $_SESSION['admin']->img ?>" alt="avatar">
        </div>
        <nav>
            <div class="menu-i">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <ul class="hide-menu">
                <li id="addnews"><a href="<?= URLROOT . '/admin/dashboard' ?>"><i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a></li>
                <li><a href="<?= URLROOT . '/admin/formateurs' ?>"><i class="fa-solid fa-chalkboard-user"></i><span>Formateurs</span></a></li>
                <li><a href="<?= URLROOT . '/admin/formations' ?>"><i class="fa-solid fa-person-chalkboard"></i><span>Formations</span></a></li>
                <li><a href="<?= URLROOT . '/admin/etudiants' ?>"><i class="fa-solid fa-graduation-cap"></i><span>Etudiants</span></a></li>
                <li><a href="<?= URLROOT . '/admin/categories' ?>"><i class="fa-solid fa-list"></i><span>Categories</span></a></li>
                <li><a href="<?= URLROOT . '/admin/langues' ?>"><i class="fa-solid fa-language"></i><span>Langues</span></a></li>
                <li id="settings"><a href="<?= URLROOT . '/admin/settings' ?>"><i class="fas fa-user-gear"></i><span>Paramètre</span></a></li>
                <li id="paiment"><a href="<?= URLROOT . '/admin/requestPayment' ?>"><i class=" far fa-credit-card"></i><span>Paiement</span></a></li>
                <li id="theme">
                    <a href="<?= URLROOT . '/admin/changeTheme' ?>">
                        <i class="fa-solid fa-palette"></i>
                        <span>Thème</span>
                    </a>
                </li>
                <li id="smtp">
                    <a href="<?= URLROOT . '/admin/smtp' ?>">
                        <i class="fa-solid fa-envelope"></i>
                        <span>SMTP</span>
                    </a>
                </li>
                <li id="disconnect">
                    <a href="<?= URLROOT . '/admin/logout' ?>">
                        <i class="fas fa-sign-out-alt"></i><span>Déconnexion</span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <!-- end Header -->