<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= URLROOT . '/public' ?>/images/favicon.ico">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Style -->
    <link rel="stylesheet" href="<?= URLROOT . "/Public/css/addFormation.css" ?>">
    <title><?= SITENAME ?></title>
</head>

<body>
    <?php require_once APPROOT . "/views/includes/dashBoardNav.php"; ?>
    <div class="container">
        <form action="" enctype="multipart/form-data" method="post" id="form">
            <input type="hidden" name="JsonVideos" id="jsonVideos">
            <div class="prog" id="prog_bar"></div>
            <div class="main-form-heading">
                <h1 class="logo"><a href="formateurs/dashboard">M<span>A</span>H<span>A</span></a></h1>
            </div>

            <div class="field-container">
                <div class="field-section-slyder" id="fieldSectionSlyder">
                    <div class="field-section">
                        <div class="field-box">
                            <div class="input-field">
                                <label for="nom">Nom De Formation :</label>
                                <input type="text" id="nom" name="nom" value="<?= $data["nom_formation"] ?>">
                                <span class="error" id="error_nom"><?= $data["error"] ?></span>
                            </div>
                            <div class="input-field">
                                <label for="prix">Prix De Formation En $:</label>
                                <input type="number" id="prix" name="prix" value="<?= $data["prix_formation"] ?>">
                                <span class="error" id="error_prix"></span>
                            </div>
                        </div>
                        <div class="field-box">
                            <div class="input-field">
                                <label for="niveau">Niveau De Formation :</label>
                                <select name="niveau" id="niveau">
                                    <option value="">Aucun</option>
                                    <?php foreach ($data["levels"] as $level) {
                                        echo '<option value="' . $level->id_niveau . '">' . $level->nom_niveau . '</option>';
                                    } ?>
                                </select>
                                <span class="error" id="error_niveau"><?php $data["error"] ?></span>
                            </div>
                            <div class="input-field">
                                <label for="categorie">Catégorie De Formation :</label>
                                <select name="categorie" id="categorie">
                                    <option value="">Aucun</option>
                                    <?php foreach ($data["allcategories"] as $cat) {
                                        echo '<option value="' . $cat->id_categorie . '">' . $cat->nom_categorie . '</option>';
                                    } ?>
                                </select>
                                <span class="error" id="error_categorie"><?php $data["error"] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="field-section">
                        <div class="field-box">
                            <div class="input-field">
                                <div class="image-uploader">
                                    <input type="file" id="image" name="image">
                                </div>
                                <span class="error" id="error_image"></span>
                            </div>
                        </div>
                        <div class="field-box">
                            <div class="input-field">
                                <label for="description">Description De Formation :</label>
                                <div class="textarea-container">
                                    <textarea name="description" id="description" placeholder="..."><?= $data["description"] ?></textarea>
                                    <div class="length-textarea" id="txtLen">0/700</div>
                                </div>
                                <span class="error" id="error_description"></span>
                            </div>
                        </div>
                    </div>
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
                                <label for="videos">Télécharger des videos :</label>
                                <div class="uploded-videos" id="uplodedVideosContainer">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-buttons">
                <button class="prev not-allowed" id="prev">Précédent</button>
                <button class="next" id="next">Suivant</button>
            </div>
        </form>
    </div>
    <script src="<?= URLROOT . "/Public/js/addFormation.js" ?>"></script>
    <script src="<?= URLROOT; ?>/public/js/dashBoardNav.js"></script>
</body>

</html>