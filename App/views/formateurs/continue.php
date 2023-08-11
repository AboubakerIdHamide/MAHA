<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title>Admission | <?= SITENAME ?></title>
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/bootstrap.min.css" />
    <!-- Style -->
    <link rel="stylesheet" href="<?= CSSROOT ?>/formateurs/continue.css" />
    <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/quill.snow.css" /> 
    <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/selectric.css" /> 
    <style>
        #admission_bg {
            background: url(<?= URLROOT ?>/public/images/banner_home.jpg) center center no-repeat fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
</head>

<body id="admission_bg" class="d-flex align-items-center justify-content-center vh-100">
    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div>
    <!-- End Preload -->
    
    <div id="form_container">
        <figure>
            <a href="<?= URLROOT ?>"><img src="<?= LOGO ?>" width="149" height="42" alt="logo maha"></a>
        </figure>
        <div id="wizard_container">
            <div id="top-wizard">
                <div id="progressbar"></div>
            </div>
            <!-- /top-wizard -->
            <form id="wizard-form" method="POST">
                <div id="middle-wizard">
                    <div class="step">
                        <div id="intro">
                            <figure><img src="<?= IMAGEROOT ?>/wizard.svg" alt="addmission icon"></figure>
                            <h1>Commencer l'enseignement</h1>
                            <p>Bonjour <strong><?= $_SESSION['user']->nom ?></strong>, avant de commencer à enseigner sur notre plateforme, vous devez nous fournir des informations supplémentaires sur votre parcours professionnel.</p>
                            <p><strong>Veuillez remplir tous les champs pour continuer.</strong></p>
                        </div>
                    </div>

                    <div class="step">
                        <h3 class="main_question"><strong class="location"></strong>Quelle catégorie vous intéresse pour enseigner?</h3>
                        <div class="form-group">
                            <select name="categorie">
                                <?php foreach ($categories as $categorie): ?>
                                    <option value="<?= $categorie->id_categorie ?>"><?= $categorie->nom ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <!-- /step-->

                    <div class="step">
                       <h3 class="main_question"><strong class="location"></strong>Quelle est votre profession?</h3>
                        <div class="form-group">
                            <input type="text" name="speciality" class="form-control" placeholder="Nom de profession">
                        </div>
                    </div>
                    <!-- /step-->

                    <div class="submit step">
                        <h3 class="main_question"><strong class="location"></strong>Donnez-nous plus d'informations à votre sujet, (par exemple : éducation, expérience...)</h3>
                        <textarea id="biography" name="biography" class="visually-hidden"></textarea>
                        <div id="editor-container"></div>
                    </div>
                    <!-- /step-->
                </div>
                <!-- /middle-wizard -->
                <div id="bottom-wizard">
                    <button type="button" name="backward" class="backward">Avant</button>
                    <button type="button" name="forward" class="forward">Suivant</button>
                    <button type="submit" class="submit">Soumettre</button>
                </div>
                <!-- /bottom-wizard -->
            </form>
        </div>
        <!-- /Wizard container -->
    </div>
    <!-- /Form_container -->

    <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery-ui-1.8.22.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/quill.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.wizard.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.selectric.js"></script>
    <script src="<?= JSROOT ?>/formateurs/continue.js"></script>
    <script>
        $('select').selectric();
    </script>
</body>
</html>