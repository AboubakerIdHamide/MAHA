<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title><?= SITENAME ?> | Paramètre</title>
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
        <div class="logo" data-user-name="<?= session('user')->get()->prenom ?>">
            <img src="<?= strpos(session('user')->get()->img, 'users') === 0 ? IMAGEROOT.'/'.session('user')->get()->img : session('user')->get()->img ?>" alt="avatar formateur">
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
                            <?php if ($nbrNotifications->totalNew != 0) : ?>
                                <span style="font-size: 9px;" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger nbr-notifications">
                                    <?= $nbrNotifications->totalNew ?>
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
    <!-- profil Head -->
    <section class="section-title mt-4">
        <div class="container">
            <div>
                <h4>Aperçu</h4>
                <p>Profil de l'utilisateur</p>
            </div>
        </div>
    </section>
    <!-- Fin profil Head -->
    <section class="container mb-5">

        <p class="success-msg"></p>
        <div class="row profil-row d-flex justify-content-center align-items-center">
            <div class="col-lg-5 profil">
                <div class="avatar card p-2 border-0">
                    <div class="text-center">
                        <div class="avatar-container">
                            <img id="avatar-profil" src="<?= strpos($img, 'users') === 0 ? IMAGEROOT.'/'.$img : $img ?>" alt="image formateur">
                            <div class="mt-2">
                                <input id="avatar" class="d-none" type="file" accept=".jpg, .jpeg, .png">
                                <label class="btn btn-warning" for="avatar">
                                    <i class="fa-solid fa-image"></i> Changer Avatar
                                </label>
                                <small id="error-img-avatar" class="error text-danger"></small>
                            </div>
                        </div>
                        <h5 class="mt-2 nom-prenom" id='nom-prenom-aff'><?= $nom ?>
                            <?= $prenom ?></h5>
                        <p class="speciality-display" id='cat-aff'><?= $categorie ?></p>
                        <span class="type-account badge rounded-pill text-bg-info"><i class="fa-solid fa-person-chalkboard"></i> Formateur</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 mt-4 mt-lg-0">
                <div class="avatar card">
                    <div class="card-header py-3">
                        Informations de compte
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <label for="nom" class="form-label">Nom</label>
                                <div class="input-group flex-nowrap">
                                    <input type="text" class="form-control" aria-label="nom" aria-describedby="addon-wrapping" value="<?= $nom ?>" disabled id="nom">
                                    <span class="input-group-text" id="nom-icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                </div>
                                <small id="error-nom" class="error text-danger"><?= $nom_err ?></small>
                            </div>
                            <div class="col mt-3 mt-md-0">
                                <label for="prenom" class="form-label">Prénom</label>
                                <div class="input-group flex-nowrap">
                                    <input value="<?= $prenom ?>" type="text" class="form-control" aria-label="prenom" aria-describedby="addon-wrapping" id="prenom" disabled>
                                    <span class="input-group-text" id="prenom-icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                </div>
                                <small id="error-prenom" class="error text-danger"><?= $prenom_err ?></small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group flex-nowrap">
                                    <input type="email" class="form-control" id="email" value="<?= $email ?>" disabled>
                                </div>
                                <small class="error text-danger" id="error-email"></small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="tele" class="form-label">Numéro Téléphone</label>
                                <div class="input-group flex-nowrap">
                                    <input value="<?= $tel ?>" type="text" class="form-control" aria-label="Numero Telephone" aria-describedby="addon-wrapping" id="tele" disabled>
                                    <span class="input-group-text" id="phone-icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                </div>
                                <small class="error text-danger" id="error-tele"><?= $tel_err ?></small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="mdp-c" class="form-label">Mot de passe actuel</label>
                                <div class="input-group flex-nowrap">
                                    <input type="password" class="form-control" placeholder="****************" aria-label="password" aria-describedby="addon-wrapping" id="mdp-c" class="mdp-c">
                                    <span class="input-group-text border border-start-0 eye-icon" id="eye-icon"><i class="fa-solid fa-eye-slash"></i></span>
                                </div>
                                <small class="text-danger error" id="error-mdp-c"></small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="mdp" class="form-label">Nouveau Mot de passe</label>
                                <div class="input-group flex-nowrap">
                                    <input type="password" class="form-control" placeholder="****************" aria-label="password" aria-describedby="addon-wrapping" id="mdp">
                                    <span class="input-group-text border border-start-0 eye-icon" id="eye-icon"><i class="fa-solid fa-eye-slash"></i></span>
                                </div>
                                <small class="text-danger error" id="error-mdp"></small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="speciality" class="form-label">Spécialité</label>
                                <select id="spec" class="form-select" aria-label="Default select example">
                                    <?php
                                    foreach ($data["categories"] as $categorie) {
                                        if ($categorie->id_categorie == $specId) {
                                            echo '<option selected value="' . $categorie->id_categorie . '">' . $categorie->nom . '</option>';
                                        } else {
                                            echo '<option value="' . $categorie->id_categorie . '">' . $categorie->nom . '</option>';
                                        }
                                    } ?>
                                </select>
                                <small class="error text-danger" id="error-spec"><?= $specId_err ?></small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="bio" class="form-label d-flex justify-content-between bio-icon" id="bio-icon">Biographie<i class="fa-solid fa-pen-to-square"></i></label>
                                <textarea id="bio" class="form-control" rows="3" disabled><?= $bio ?></textarea>
                                <small id="error-bio" class="error text-danger"><?= $bio_err ?></small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <div class="d-grid gap-2 d-md-block">
                                    <button id="update-info" class="btn btn-info">Mise à jour</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require_once APPROOT . "/views/includes/footerDashboard.php"; ?>