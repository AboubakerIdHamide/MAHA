<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title><?= SITENAME ?> | Paramètre</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- BootStrap -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/bootstrap.quartz.min.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/dashBoardNav.css" />
    <style>
    body,
    label {
        font-family: Inter;
    }

    .avatar {
        background-color: #3d393e;
    }
    </style>
</head>

<body>
    <?php require_once APPROOT . "/views/includes/etudiantHeader.php"; ?>
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
                            <img id="" src="<?= $data['img'] ?>" alt="user image" class="rounded-pill w-50 h-50">
                            <div class="mt-2">
                                <input id="avatar" class="d-none" type="file" accept=".jpg, .jpeg, .png">
                                <label class="btn btn-warning" for="avatar">
                                    <i class="fa-solid fa-image"></i> Changer Avatar
                                </label>
                                <small id="error-img-avatar" class="error text-danger"></small>
                            </div>
                        </div>
                        <h5 class="mt-2 nom-prenom" id='nom-prenom-aff'><?= $data['nom'] ?> <?= $data['prenom'] ?></h5>
                        <span class="type-account badge rounded-pill text-bg-info"><i
                                class="fa-solid fa-person-chalkboard"></i> Etudiant</span>
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
                                    <input type="text" class="form-control" aria-label="nom"
                                        aria-describedby="addon-wrapping" value="<?= $data['nom'] ?>" disabled id="nom">
                                    <span class="input-group-text" id="nom-icon"><i
                                            class="fa-solid fa-pen-to-square"></i></span>
                                </div>
                                <small id="error-nom" class="error text-danger"><?= $data['nom_err'] ?></small>
                            </div>
                            <div class="col mt-3 mt-md-0">
                                <label for="prenom" class="form-label">Prénom</label>
                                <div class="input-group flex-nowrap">
                                    <input value="<?= $data['prenom'] ?>" type="text" class="form-control"
                                        aria-label="prenom" aria-describedby="addon-wrapping" id="prenom" disabled>
                                    <span class="input-group-text" id="prenom-icon"><i
                                            class="fa-solid fa-pen-to-square"></i></span>
                                </div>
                                <small id="error-prenom" class="error text-danger"><?= $data['prenom_err'] ?></small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group flex-nowrap">
                                    <input type="email" class="form-control" id="email" value="<?= $data['email'] ?>"
                                        disabled>
                                </div>
                                <small class="error text-danger" id="error-email"></small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="tele" class="form-label">Numéro Téléphone</label>
                                <div class="input-group flex-nowrap">
                                    <input value="<?= $data['tel'] ?>" type="text" class="form-control"
                                        aria-label="Numero Telephone" aria-describedby="addon-wrapping" id="tele"
                                        disabled>
                                    <span class="input-group-text" id="phone-icon"><i
                                            class="fa-solid fa-pen-to-square"></i></span>
                                </div>
                                <small class="error text-danger" id="error-tele"><?= $data['tel_err'] ?></small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="mdp-c" class="form-label">Mot de passe actuel</label>
                                <div class="input-group flex-nowrap">
                                    <input type="password" class="form-control" placeholder="****************"
                                        aria-label="password" aria-describedby="addon-wrapping" id="mdp-c"
                                        class="mdp-c">
                                    <span class="input-group-text border border-start-0 eye-icon" id="eye-icon"><i
                                            class="fa-solid fa-eye-slash"></i></span>
                                </div>
                                <small class="text-danger error" id="error-mdp-c"></small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="mdp" class="form-label">Nouveau Mot de passe</label>
                                <div class="input-group flex-nowrap">
                                    <input type="password" class="form-control" placeholder="****************"
                                        aria-label="password" aria-describedby="addon-wrapping" id="mdp">
                                    <span class="input-group-text border border-start-0 eye-icon" id="eye-icon"><i
                                            class="fa-solid fa-eye-slash"></i></span>
                                </div>
                                <small class="text-danger error" id="error-mdp"></small>
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
    <script src="<?= JSROOT ?>/bootstrap.bundle.min.js"></script>
    <script src="<?= URLROOT ?>/public/jQuery/jquery-3.6.0.min.js"></script>
    <script src="<?= JSROOT ?>/dashBoardNav.js"></script>
    <script src="<?= JSROOT ?>/profil-settings-etudiant.js"></script>
</body>

</html>