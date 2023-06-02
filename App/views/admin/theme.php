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
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-container">
            <div class="field upload-img">
                <label>Logo</label>
                <div class="img-profile-wrapper" style="background-image: url(<?= $data["logo"] ?>);">
                    <input data-error-id="error-logo" type="file" id="logoInp" name="logo" value="<?= $data[1] ?>">
                </div>
                <span class="error" id="error-logo"></span>
            </div>
            <div class="field upload-img">
                <label>Image d'ccueil</label>
                <div class="img-profile-wrapper" style="background-image: url(<?= $data["landingImg"] ?>);" data-img="<?= $data["landingImg"] ?>">
                    <input data-error-id="error-landing-img" type="file" id="landingImgInp" name="landingImg" value="<?= $data[2] ?>">
                </div>
                <span class="error" id="error-landing-img"></span>
            </div>
        </div>
        <button class="appliquer" id="subBtn">Modifier</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
</script>
<script src="<?= URLROOT; ?>/public/jQuery/jquery-3.6.0.min.js"></script>
<script src="<?= URLROOT; ?>/public/js/dashBoardNav.js"></script>
<script src="<?= URLROOT; ?>/public/js/adminFormateurs.js"></script>
<script src="<?= URLROOT; ?>/public/js/theme.js"></script>
</body>

</html>