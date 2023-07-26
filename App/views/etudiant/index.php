<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= URLROOT . '/public' ?>/images/favicon.ico">
    <title><?= SITENAME ?> | Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- BootStrap -->
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/bootstrap.quartz.min.css" ?>">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/dashBoardNav.css" ?>">
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/etudiantFormation.css" ?>">

</head>

<body>
    <?php require_once APPROOT . "/views/includes/etudiantHeader.php"; ?>

    <section class="pageFormation">
        <div class="container">
            <div class="mt-2 text-success">
                <?php flash('joined') ?>
            </div>
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary mt-3">Rejoindre
                un Cours Privé</button>
            <?php if (count($data["inscriptions"]) === 0) : ?>
                <div class="alert alert-danger mt-3">vous êtes inscrit a aucune formation !</div>
            <?php endif ?>
            <div class="formations">
                <?php foreach ($data["inscriptions"] as $formation) : ?>
                    <a class="card_coures" href="<?= URLROOT . "/etudiants/coursVideos/" . $formation->id_formateur . "/" . $formation->id_formation ?>">
                        <!-- img formation -->
                        <div class="img">
                            <img src="<?= $formation->image ?>" alt="photo">
                            <div class="duree">
                                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                                <div class="time"><?= $formation->mass_horaire ?></div>
                            </div>
                        </div>
                        <!-- informations formation -->
                        <div class="info_formation">
                            <div class="categorie"><?= $formation->nomCategorie ?></div>
                            <div class="prix"><?= $formation->prix ?></div>
                        </div>
                        <!-- name formation -->
                        <h1><?= $formation->nomFormation ?></h1>
                        <!-- description -->
                        <div class="description">
                            <p><?= strlen($formation->description) > 120 ? substr($formation->description, 0, 120) . "..." : $formation->description ?>
                            </p>
                        </div>
                        <div class="footer">
                            <!-- infotrmation formateur -->
                            <div class="formateur">
                                <div class="img_formateur">
                                    <img src="<?= $formation->imgFormateur ?>" alt="photo">
                                </div>
                                <h2><?= $formation->nomFormateur ?> <?= $formation->prenomFormateur ?></h2>
                            </div>
                            <!-- informations -->
                            <div class="info">
                                <div class="etd formation-likes"><?= $formation->jaimes ?></div>
                                <i class="<?= $formation->liked ? "fa-solid" : "fa-regular" ?> fa-heart" aria-hidden="true" data-formation-id="<?= $formation->id_formation ?>" data-etudiant-id="<?= $formation->id_etudiant ?>"></i>
                                <div class="likes"><?= $formation->apprenants ?></div>
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                        </div>
                    </a>
                <?php endforeach ?>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-floating">
                        <input type="text" class="form-control code-formation" id="code" placeholder="veuillez entrer Code de la Formation" required>
                        <label for="code">Code de la Formation</label>
                        <small class="text-danger" id="code-error" style="font-weight: 500;font-size:12px"></small>
                    </div>
                </div>
                <div class="p-2 d-flex justify-content-end gap-3">
                    <button type="button" class="btn btn-primary" id="join">Rejoindre</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const urlRoot = "<?= URLROOT ?>";
    </script>
    <script src="<?= URLROOT . "/Public/jQuery/jquery-3.6.0.min.js" ?>"></script>
    <script src="<?= URLROOT . "/Public/js/dashBoardNav.js" ?>"></script>
    <script src="<?= URLROOT . "/Public/js/etudiantFormations.js" ?>"></script>
    <script src="<?= URLROOT ?>/public/js/bootstrap.bundle.min.js"></script>
</body>

</html>