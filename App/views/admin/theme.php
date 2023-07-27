<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<style>
    .container {
        padding-top: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    form {
        background-color: #fff;
        width: 400px;
        max-width: 100%;
        height: 250px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding-bottom: 30px;
    }

    label {
        width: 100%;
        padding: 10px;
        padding-left: 20px;
        color: var(--color-one);
    }
</style>
<div class="container">
    <form method="POST" enctype="multipart/form-data">
        <div class="form-container">
            <div class="field upload-img">
                <label>Logo</label>
                <div class="img-profile-wrapper" style="background-image: url(<?= $data["logo"] ?>);">
                    <input data-error-id="error-logo" type="file" id="logoInp" name="logo" value="<?= $data["logo"] ?>">
                </div>
                <span class="error" id="error-logo"></span>
            </div>
            <div class="field upload-img">
                <label>Image d'ccueil</label>
                <div class="img-profile-wrapper" style="background-image: url(<?= $data["landingImg"] ?>);" data-img="<?= $data["landingImg"] ?>">
                    <input data-error-id="error-landing-img" type="file" id="landingImgInp" name="landingImg" value="<?= $data["landingImg"] ?>">
                </div>
                <span class="error" id="error-landing-img"></span>
            </div>
        </div>
        <button class="appliquer" id="subBtn">Modifier</button>
    </form>
</div>
<script src="<?= JSROOT ?>/bootstrap.bundle.min.js"></script>
<script src="<?= URLROOT ?>/public/jQuery/jquery-3.6.0.min.js"></script>
<script src="<?= JSROOT ?>/dashBoardNav.js"></script>
<script src="<?= JSROOT ?>/adminFormateurs.js"></script>
<script src="<?= JSROOT ?>/theme.js"></script>
</body>

</html>