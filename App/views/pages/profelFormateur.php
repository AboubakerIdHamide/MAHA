<?php require_once APPROOT."/views/includes/header.php";?> 


<section class="profelFormateur">
    <div class="container">
        <div class="infos">
            <div class="main-info"> 
                <h2>Formateur</h2>
                <div class="name"><?php echo $data['infoFormateur']->nomFormateur; ?> <?php echo $data['infoFormateur']->prenomFormateur; ?></div>
                <div class="speciel"><?php echo $data['infoFormateur']->categorie; ?></div>
                <div class="nb-cours">
                    <span>Nombre des cours : </span>
                    <span class="val-nb-cours"><?php echo $data['numFormations']->numFormations; ?></span>
                </div>
                <div class="nb-achter">
                    <span>Nombre des achtes :</span>
                    <span class="val-nb-achter">50</span>
                </div>
            </div>
            <div class="autre-info">
                <div class="img">
                    <img src="<?php echo $data['infoFormateur']->img; ?>" alt="Photo-Profel">
                </div>
                <div class="linkes">
                    <div>
                        <i class="fa-solid fa-link"></i>
                        <a href="#">Site Web</a>
                    </div>
                    <div>
                        <i class="fa-brands fa-twitter"></i>
                        <a href="#">Twitter</a>
                    </div>
                    <div>
                        <i class="fa-brands fa-linkedin"></i>
                        <a href="#">Linkedin</a>
                    </div>
                    <div>
                        <i class="fa-brands fa-facebook-f"></i>
                        <a href="#">Facbook</a>
                    </div>
                </div>
            </div>
            <div class="description">
                    <h2>Informations personnelles</h2>
                    <p><?php echo $data['infoFormateur']->biography; ?></p>
            </div>
        </div>
        <div class="coures">
        <h2>Mes cours</h2>
        <div class="formations">
            <?php foreach($data['courses'] as $info) : ?>
                <!-- start card -->
                <div class="card_coures">
                    <!-- img formation -->
                    <div class="img">
                        <img src="<?php echo $info->imgFormation; ?>" alt="photo">
                        <div class="duree">
                            <i class="fa-solid fa-clock" aria-hidden="true"></i>
                            <div class="time"><?php echo $info->duree; ?></div>
                        </div>
                    </div>
                    <!-- informations formation -->
                    <div class="info_formation">
                        <div class="categorie"><?php echo $info->categorie; ?></div>
                        <div class="prix"><?php echo $info->prix; ?></div>
                    </div>
                    <!-- name formation -->
                    <h1><?php echo $info->nomFormation; ?></h1>
                    <!-- description -->
                    <div class="description">
                        <p><?php echo $info->description; ?></p>
                    </div>
                    <div class="footer">
                        <!-- infotrmation formateur -->
                        <div class="formateur" onClick='<?php echo URLROOT."/profelFormateur/index/$info->IdFormteur"?>'>
                            <div class="img_formateur">
                                <img src="<?php echo $info->imgFormateur; ?>" alt="photo">
                            </div>
                            <h2><?php echo $info->nomFormateur; ?> <?php echo $info->prenomFormateur; ?></h2>
                        </div>
                        <!-- informations -->
                        <div class="info">
                            <div class="etd">30</div>
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            <div class="likes"><?php echo $info->likes; ?></div>
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            <?php endforeach; ?>
        </div>
        </div>
    </div>
</section>
<!-- end page profel formateur -->
<?php require_once APPROOT."/views/includes/footer.php";?> 