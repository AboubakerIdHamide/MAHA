<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= URLROOT . '/public' ?>/images/favicon.ico">
    <title><?= SITENAME ?></title>
    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Style -->
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/register.css">
</head>

<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="register-type">
                <h3>S'inscrire <sup>Avec</sup></h3>
                <button type="button" id="maha-register" class="maha"><i class="fa fa-user-plus"></i>MAHA</button>
                <button type="button" id="facebook-register" class="facebook"><i class="fa-brands fa-facebook"></i>
                    Facebook</button>
                <button type="button" id="google-register" class="google"><i class="fa-brands fa-google-plus-g"></i>
                    Google</button>
                <small class="connection-error"></small>
            </div>
            <div class="maha-fields hide">
                <div class="main-form-heading">
                    <h1 class="logo">
                        <a href="<?= URLROOT . "/pages/index"; ?>">
                            <img src="<?= URLROOT . '/Public/images/MAHA.png' ?>" alt="">
                        </a>
                    </h1>
                    <div class="form-progress">
                        <span class="fill-prog" id="fillSpan"></span>

                        <div class="steps">
                            <div>1</div>
                            <div>2</div>
                            <div>3</div>
                            <div>4</div>
                        </div>
                    </div>

                    <span class="last-step hide">Dérniere étape !</span>
                </div>
                <div class="inputs-boxs-container">
                    <input type="hidden" id="register-img" name="registerImg">
                    <div class="inputs-boxs-container-slider" id="inputsSlider">
                        <div class="input-box">
                            <div class="field">
                                <label for="nom">Nom :</label>
                                <input type="text" id="nom" name="nom" value="<?= $data[0]["nom"] ?>">
                                <span class="error" id="error-nom"><?= $data[0]["nom_err"] ?></span>
                            </div>
                            <div class="field">
                                <label for="prenom">Prenom :</label>
                                <input type="text" id="prenom" name="prenom" value="<?= $data[0]["prenom"] ?>">
                                <span class="error" id="error-prenom"><?= $data[0]["prenom_err"] ?></span>
                            </div>
                        </div>

                        <div class="input-box">
                            <div class="field">
                                <label for="email">E-mail :</label>
                                <input type="email" id="email" name="email" value="<?= $data[0]["email"] ?>">
                                <span class="error" id="error-email"><?= $data[0]["email_err"] ?></span>
                            </div>
                            <div class="field">
                                <label for="tele">N.Telephone :</label>
                                <input type="text" id="tele" name="tele" value="<?= $data[0]["tel"] ?>">
                                <span class="error" id="error-tele"><?= $data[0]["tel_err"] ?></span>
                            </div>
                        </div>

                        <div class="input-box">
                            <div class="field">
                                <label for="mdp">Mot De Passe :</label>
                                <input type="password" id="mdp" name="mdp" value="<?= $data[0]["mdp"] ?>">
                                <span class="error" id="error-mdp"><?= $data[0]["mdp_err"] ?></span>
                            </div>
                            <div class="field">
                                <label for="vmdp">Vérifier Mot De Passe :</label>
                                <div class="masquer-mdb">
                                    <input type="password" id="vmdp" name="vmdp" value="<?= $data[0]["vmdp"] ?>">
                                    <i class="fa fa-eye" id="showPassIcon"></i>
                                </div>
                                <span class="error" id="error-vmdp"><?= $data[0]["vmdp_err"] ?></span>
                            </div>
                        </div>

                        <div class="input-box">
                            <div class="field upload-img">
                                <div class="img-profile-wrapper">
                                    <input type="file" id="photoInp" name="photo">
                                </div>
                                <span class="error" id="error-photo"><?= $data[0]["img_err"] ?></span>
                            </div>
                            <div class="field for-radio">
                                <input type="radio" id="formateur" name="type" value="formateur">
                                <label for="formateur">Formateur</label>
                                <input type="radio" id="etudiant" name="type" value="etudiant" checked>
                                <label for="etudiant">Etudiant</label>
                            </div>
                        </div>


                        <div class="input-box" id="lastSection">
                            <div class="alert-regiter-msg" id="lastSectionEtudiant">
                                Vous avez terminé l'opération d'inscription
                                merci de valider
                            </div>
                            <div class="input-box hide" id="lastSectionFormateur">
                                <div class="field">
                                    <label for="pmail">Email Paypal :</label>
                                    <input type="email" id="pmail" name="pmail" value="<?= $data[0]["pmail"] ?>">
                                    <span class="error" id="error-pmail"><?= $data[0]["pmail_err"] ?></span>
                                </div>
                                <div class="field">
                                    <label spec="bio">Spécialité :</label>
                                    <select name="specialite" id="spec">
                                        <option value="aucun">Aucun</option>
                                        <?php
                                        foreach ($data[1] as $cat) {
                                            echo '<option value="' . $cat->id_categorie . '">' . $cat->nom_categorie . '</option>';
                                        } ?>
                                    </select>
                                    <span class="error" id="error-spec"><?= $data[0]["spec_err"] ?></span>
                                </div>
                                <div class="field">
                                    <label for="bio">Biography :</label>
                                    <textarea name="biography" id="bio"><?= $data[0]["bio"] ?></textarea>
                                    <span class="error" id="error-bio"><?= $data[0]["bio_err"] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-buttons">
                    <button class="prev not-allowed" id="prev">Précédent</button>
                    <button class="next" id="next">Suivant</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="<?= URLROOT . "/Public/"; ?>js/register.js"></script>
</body>

</html>