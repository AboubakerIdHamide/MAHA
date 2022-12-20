<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/dashBoardNav.css" ?>">
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/etudiantFormation.css" ?>">
    <!-- BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <?php require_once APPROOT . "/views/includes/etudiantHeader.php"; ?>
    <section class="pageFormation">
        <div class="container">
            <div class="formations">
                <?php foreach ($data as $item) { ?>
                    <a class="card_coures" href="<?= URLROOT . "/etudiants/coursVideos/" . $item->id_formateur . "/" . $item->id_formation ?>">
                        <!-- img formation -->
                        <div class="img">
                            <img src="<?= $item->image_formation ?>" alt="photo">
                            <div class="duree">
                                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                                <div class="time"><?= $item->mass_horaire ?></div>
                            </div>
                        </div>
                        <!-- informations formation -->
                        <div class="info_formation">
                            <div class="categorie"><?= $item->categorie ?></div>
                            <div class="prix"><?= $item->prix_formation ?></div>
                        </div>
                        <!-- name formation -->
                        <h1><?= $item->nom_formation ?></h1>
                        <!-- description -->
                        <div class="description">
                            <p><?= strlen($item->description) > 120 ? substr($item->description, 0, 120) . "..." : $item->description ?></p>
                        </div>
                        <div class="footer">
                            <!-- infotrmation formateur -->
                            <div class="formateur">
                                <div class="img_formateur">
                                    <img src="<?= $item->img_formateur ?>" alt="photo">
                                </div>
                                <h2><?= $item->nom_formateur ?> <?= $item->prenom_formateur ?></h2>
                            </div>
                            <!-- informations -->
                            <div class="info">
                                <div class="etd formation-likes"><?= $item->likes ?></div>
                                <i class="<?= $item->liked ? "fa-solid" : "fa-regular" ?> fa-heart" aria-hidden="true" data-formation-id="<?= $item->id_formation ?>" data-etudiant-id="<?= $item->id_etudiant ?>"></i>
                                <div class="likes"><?= $item->apprenants ?></div>
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </section>
    <script>
        const urlRoot = "<?= URLROOT ?>";
    </script>
    <script src="<?= URLROOT . "/Public/jQuery/jquery-3.6.0.min.js" ?>"></script>
    <script src="<?= URLROOT . "/Public/js/dashBoardNav.js" ?>"></script>
    <script src="<?= URLROOT . "/Public/js/etudiantFormations.js" ?>"></script>
</body>

</html>