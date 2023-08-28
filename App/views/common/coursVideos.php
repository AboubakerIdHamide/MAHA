<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title><?= SITENAME ?> | <?= $data->nomFormation ?></title>
    <!-- FontAwesome -->
    <link href="<?= CSSROOT ?>/icons/all.min.css" rel="stylesheet" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/bootstrap.min.css" />
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/cours-details-paid.css" />
</head>

<body>
    <!-- formateur info -->
    <section class="media-header">
        <div class="container mt-3">
            <div class="row">
                <div class="col-xl-3">
                    <a href="<?= URLROOT ?>/<?= isset($_SESSION['id_formateur']) ? 'formateur' : 'etudiant' ?>">
                        <img class="img-fluid" src="<?= $data->image ?>" alt="formation image">
                    </a>
                </div>
                <div class="col-xl-7">
                    <div class="group d-flex flex-column justify-content-center">
                        <h3 class="title"><?= $data->nomFormation ?></h3>
                        <p>Formation catégorie <span><?= $data->formationCategorie ?></span></p>
                        <div class="instructor d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <img src="<?= $data->imgFormateur ?>" alt="" class="formateur-img">
                                <div class="instructor-info">
                                    <h5><?= $data->nomFormateur ?> <?= $data->prenomFormateur ?></h5>
                                    <p class="specialite mb-0"><?= $data->formateurCategorie ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 masse-h d-flex flex-row justify-content-between">
                            <p><i class="fa-solid fa-clock"></i> <?= $data->mass_horaire ?></p>
                            <p><i class="fa-solid fa-language"></i> <?= $data->langue ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 align-self-center">
                    <div class="info-plus">
                        <div class="text-center mb-1 apprenants-nbr">
                            <p class="nbr"><?= $data->apprenants ?></p>
                            <p>Apprenants</p>
                        </div>
                        <div class="fomation-niveau text-center mb-1">
                            <div class="level-indicator">
                                <?= $data->niveauIcon ?>
                            </div>
                            <p>Niveau <?= $data->niveau ?></p>
                        </div>
                        <div class="text-center">
                            <p class="nbr formation-likes"><?= $data->jaimes ?></p>
                            <p>J'aime</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end formateur info -->

    <section class="container mt-3">
        <hr />
        <div class="row">
            <div class="col">
                <h4 class="main-video-name">1. <?= $data->videos[0]->nomVideo ?>
                </h4>
                <section id="playerContainer"></section>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <section class="playlist-videos">
                    <h5><?= $data->nomFormation ?></h5>
                    <div class="some-info mb-3">
                        <span class="main-video-duration"><?= $data->videos[0]->duree ?></span>
                    </div>
                    <div class="videos-list">
                        <ul>
                            <?php $cpt = 1 ?>
                            <?php foreach ($data->videos as $video) { ?>
                            <!-- max 50 chars video name or less -->
                            <li
                                class="d-flex justify-content-between mt-1 <?= $video == $data->videos[0] ? "selected" : "" ?>">
                                <div class="d-flex align-items-center"><i
                                        class="fa-solid <?= $video == $data->videos[0] ? "fa-circle-pause" : "fa-circle-play" ?>"></i>&nbsp;&nbsp;&nbsp;<span
                                        data-video-id="<?= $video->id_video ?>"
                                        data-video-desc="<?= $video->description ?>" class="video-name">
                                        <?= $cpt++ . ". " . $video->nomVideo ?></span></div>
                                <div class="d-flex align-items-center">
                                    <span class="video-duration" data-video-url="<?= $video->url ?>"
                                        id="video-<?= $video->id_video ?>"
                                        data-video-comments='<?= json_encode($video->comments) ?>'><?= $video->duree ?></span>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <!-- RESSOURCES -->
    <?php if (isset($data->fichier_attache)) { ?>
    <section class="section-title" id="catalogue">
        <div class="container">
            <div>
                <h2>RESSOURCES</h2>
                <p>LES FICHIERS ATTACHÉS</p>
            </div>
        </div>
    </section>
    <!-- Fin RESSOURCES -->
    <section class="container">
        <div class="row">
            <div class="col mb-2">
                <div class="ressources">
                    <p>Vous pouvez télécharger les fichiers attachés avec cette video en cliquant sur le button
                        au-dessous :</p><a href="#" target="_blank" class="submit-btn" download><i
                            class="fa-sharp fa-solid fa-download"></i>&nbsp;&nbsp;Télécharger</a>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
    <!-- COMMENTAIRES Head -->
    <section class="section-title mb-4 mt-4" id="catalogue">
        <div class="container">
            <div>
                <h2>COMMENTAIRES</h2>
            </div>
        </div>
    </section>
    <!-- Fin COMMENTAIRES Head -->
    <section class="container comments-section mb-5">
        <div class="row">
            <div class="col">
                <div class="my-comments">
                    <?php foreach ($data->videos[0]->comments as $comment) { ?>
                    <div
                        class="d-flex gap-2 mb-2 <?php if ($comment->type_user === "formateur") echo "flex-row-reverse" ?>">
                        <img class="align-self-start" src="<?= $comment->img ?>" alt="my-photo">
                        <div
                            class="d-flex flex-column <?= ($comment->type_user === "formateur") ? "formateur-comment" : "etudiant-comment" ?>">
                            <span class="my-name"><?= $comment->nom . " " . $comment->prenom ?></span>
                            <p><?= $comment->commentaire ?></p>
                            <div class="d-flex justify-content-between">
                                <small><?= $comment->created_at ?></small>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <section class="container mb-5">
        <div class="row">
            <div class="col-lg-10 col-md-10">
                <div class="comment-entry">
                    <textarea class="form-control comment-text" placeholder="commentaire"></textarea>
                    <div class="d-flex justify-content-between">
                        <small class="text-danger comment-error"></small>
                        <small><span class="cpt-caractere">0</span>/500</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 d-lg-block d-md-block d-flex justify-content-center">
                <button data-to-user="<?= $data->id_etudiant ?>" data-type-user="<?= trim($_SESSION['user']->type) ?>"
                    type="submit" class="submit-btn">Envoyer</button>
            </div>
        </div>
    </section>
    <!-- To-up Button -->
    <span class="to-top" href="#"><i class="fa fa-chevron-up"></i></span>
    <!-- To-up Button -->
    <script src="https://cdn.jsdelivr.net/npm/indigo-player@1/lib/indigo-player.js"></script>
    <script>
    const urlRoot = "<?= URLROOT ?>";
    const formationId = <?= $data->id_formation ?>;
    const fromUser = "<?= $data->id_formateur ?>";
    const etudiantImageSrc = "<?= $data->imgFormateur ?>";
    const etudiantFullName = "<?= $data->nomFormateur . " " . $data->prenomFormateur ?>";
    let videoId = <?= $data->videos[0]->id_video ?>;
    const config = {
        sources: [{
            type: "mp4",
            src: "<?= $data->videos[0]->url ?>",
        }, ],
        ui: {
            pip: true, // by default, pip is not enabled in the UI.
        },
    };

    const element = document.getElementById("playerContainer");
    const player = IndigoPlayer.init(element, config);
    </script>
    <script src="<?= URLROOT ?>/Public/jQuery/jquery-3.6.0.min.js"></script>
    <script src="<?= JSROOT ?>/cours-details-paid.js"></script>
</body>

</html>