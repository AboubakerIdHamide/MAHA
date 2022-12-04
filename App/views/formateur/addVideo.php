<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="<?= URLROOT."/Public/css/addVideo.css"?>">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/dashBoardNav.css">
    <title>Ajouter Video</title>
</head>
    <?php require_once APPROOT . "/views/includes/dashboardHeader.php"; ?>
    <div class="container">
        <form action="" enctype="multipart/form-data" method="post" id="form">
            <input type="hidden" name="JsonVideos" id="jsonVideos">
            <div class="prog" id="prog_bar"></div>
            <div class="main-form-heading">
                <h1 class="logo"><a href="<?=URLROOT?>/pages/index">M<span>A</span>H<span>A</span></a></h1>
            </div>

            <div class="field-container">
                <div class="field-section-slyder" id="fieldSectionSlyder">
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
                                <label for="videos">Telecharger des videos :</label>
                                <div class="uploded-videos" id="uplodedVideosContainer">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-buttons">
                <button class="prev" id="prev">Annuler</button>
                <button class="next" id="next">Telecharger</button>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="https://unpkg.com/pcloud-sdk-js@latest/dist/pcloudsdk.js"></script>
    <script>let theFolderId =<?= $data["folders"]["videosId"]?>;</script>
    <script src="<?= URLROOT."/Public/js/addVideo.js"?>"></script>
    <script src="<?php echo URLROOT;?>/public/js/dashBoardNav.js"></script>
</body>
</html>