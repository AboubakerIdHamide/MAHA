<?php require_once APPROOT."/views/includes/header.php";?> 
    <!-- start page formations -->
    <section class="pageFormation">
        <div class="container">
            <div class="filter">
                <div class="bF-res">
                    <div class="main-filter">
                        <i class="fa fa-filter" aria-hidden="true"></i> <span>Filter</span>
                    </div>
                    <div class='resultat'>
                        <p>Resultats :</p>
                        <h2><?php echo $data['numbFormations'] ?></h2>
                    </div>
                </div>
                <div class="filter-par" style='height: 105px;'>
                    <span>Trier par :</span>
                    <div class="flt-par">            
                        <div class="dropdown m-2">
                            <a class="btn btn-secondary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Les Plus
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="<?php echo URLROOT . "/pageFormations/plusPopilairesFormations" ?>">Les Plus Populaires</a>
                                <a class="dropdown-item" href="<?php echo URLROOT . "/pageFormations/plusFormationsAmais" ?>">Les Plus Amais</a>
                                <a class="dropdown-item" href="<?php echo URLROOT . "/pageFormations/plusFormationsAchter" ?>">Les Plus Achter</a>
                            </div>
                        </div>               
                        <div class="dropdown m-2">
                            <a class="btn btn-secondary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Langages
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <?php foreach ($data['langages'] as $lang) {
                                    echo '<a class="dropdown-item" href="' . URLROOT . '/pageFormations/formationsByLangage/' . $lang->id_langue . '">' . $lang->nom_langue . '</a>';
                                } ?>
                            </div>
                        </div>
                        <div class="dropdown m-2">
                            <a class="btn btn-secondary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Niveaux
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <?php foreach ($data['nivaux'] as $niv) {
                                    echo '<a class="dropdown-item" href="' . URLROOT . '/pageFormations/formationsByNivau/' . $niv->id_niveau . '">' . $niv->nom_niveau . '</a>';
                                } ?>
                            </div>
                        </div>       
                        <div class="dropdown m-2">
                            <a class="btn btn-secondary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Durée
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <form action="<?php echo URLROOT . "/pageFormations/formationsByDuree/" ?>" method="GET">
                                    <div class="m-3">
                                        <label class="form-label" for="minH">Min heure :</label>
                                        <input type="number" name="minH" class="form-control">
                                    </div>
                                    <div class="m-3">
                                        <label class="form-label" for="maxH">Max heure :</label>
                                        <input type="number" name="maxH" class="form-control">
                                    </div>
                                    <div class="m-3 text-end">
                                        <input type="submit" value="Filter" class="btn btn-primary">
                                    </div>
                                </form>
                                <!--<a class="dropdown-item" href="<?php // echo URLROOT . "/pageFormations/formationsByDuree/0/1" ?>">Mois 1h</a>
                                <a class="dropdown-item" href="<?php // echo URLROOT . "/pageFormations/formationsByDuree/1/2" ?>">1h - 2h</a>
                                <a class="dropdown-item" href="<?php // echo URLROOT . "/pageFormations/formationsByDuree/2/5" ?>">2h - 5h</a>
                                <a class="dropdown-item" href="<?php // echo URLROOT . "/pageFormations/formationsByDuree/5/10" ?>">5h - 10h</a>
                                <a class="dropdown-item" href="<?php // echo URLROOT . "/pageFormations/formationsByDuree/10/20" ?>">10h - 20h</a>
                                <a class="dropdown-item" href="<?php // echo URLROOT . "/pageFormations/formationsByDuree/20/24" ?>">20h - 24h</a>-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- start main filter -->
                <ul class="ops hide">
                    <li id="3d" class="chow-ops">
                        <i class="fa-brands fa-unity"></i> <span>3D</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options 3d -->
                        <ul id="ul-3d">
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/3d/choix 1" ?>' style='display: block; text-decoration: none;'>Coix 1</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/3d/choix 2" ?>' style='display: block; text-decoration: none;'>Coix 2</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/3d/choix 3" ?>' style='display: block; text-decoration: none;'>Coix 3</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/3d/choix 4" ?>' style='display: block; text-decoration: none;'>Coix 4</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/3d/choix 5" ?>' style='display: block; text-decoration: none;'>Coix 5</a></li>
                        </ul>
                        <!-- end options 3d -->
                    </li>
                    <li id="architectureBIM" class="chow-ops">
                        <i class="fa-solid fa-ruler-combined"></i> <span>Architecture & BIM</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options architecture&BIM -->
                        <ul id="ul-architectureBIM">
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Architecture & BIM/choix 1" ?>' style='display: block; text-decoration: none;'>Coix 1</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Architecture & BIM/choix 2" ?>' style='display: block; text-decoration: none;'>Coix 2</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Architecture & BIM/choix 3" ?>' style='display: block; text-decoration: none;'>Coix 3</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Architecture & BIM/choix 4" ?>' style='display: block; text-decoration: none;'>Coix 4</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Architecture & BIM/choix 5" ?>' style='display: block; text-decoration: none;'>Coix 5</a></li>
                        </ul>
                        <!-- end options architecture&BIM -->
                    </li>
                    <li id="audio-MAO" class="chow-ops">
                        <i class="fa-solid fa-sliders"></i> <span>Audio-MAO</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options audio-MAO -->
                        <ul id="ul-audio-MAO">
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Audio-MAO/choix 1" ?>' style='display: block; text-decoration: none;'>Coix 1</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Audio-MAO/choix 2" ?>' style='display: block; text-decoration: none;'>Coix 2</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Audio-MAO/choix 3" ?>' style='display: block; text-decoration: none;'>Coix 3</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Audio-MAO/choix 4" ?>' style='display: block; text-decoration: none;'>Coix 4</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Audio-MAO/choix 5" ?>' style='display: block; text-decoration: none;'>Coix 5</a></li>
                        </ul>
                        <!-- end options audio-MAO -->
                    </li>
                    <li id="bureautique" class="chow-ops">
                        <i class="fa-solid fa-computer-mouse"></i> <span>Bureautique</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options bureautique -->
                        <ul id="ul-bureautique">
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Bureautique/choix 1" ?>' style='display: block; text-decoration: none;'>Coix 1</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Bureautique/choix 2" ?>' style='display: block; text-decoration: none;'>Coix 2</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Bureautique/choix 3" ?>' style='display: block; text-decoration: none;'>Coix 3</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Bureautique/choix 4" ?>' style='display: block; text-decoration: none;'>Coix 4</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Bureautique/choix 5" ?>' style='display: block; text-decoration: none;'>Coix 5</a></li>
                        </ul>
                        <!-- end options bureautique -->
                    </li>
                    <li id="businessEfficaciteProfessionnelle" class="chow-ops">
                        <i class="fa-sharp fa-solid fa-briefcase"></i> <span>Business & Efficacité professionnelle</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options business&EfficacitéProfessionnelle -->
                        <ul id="ul-businessEfficaciteProfessionnelle">
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Business & Efficacité professionnelle/choix 1" ?>' style='display: block; text-decoration: none;'>Coix 1</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Business & Efficacité professionnelle/choix 2" ?>' style='display: block; text-decoration: none;'>Coix 2</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Business & Efficacité professionnelle/choix 3" ?>' style='display: block; text-decoration: none;'>Coix 3</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Business & Efficacité professionnelle/choix 4" ?>' style='display: block; text-decoration: none;'>Coix 4</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Business & Efficacité professionnelle/choix 5" ?>' style='display: block; text-decoration: none;'>Coix 5</a></li>
                        </ul>
                        <!-- end options business&EfficacitéProfessionnelle -->
                    </li>
                    <li id="code" class="chow-ops">
                        <i class="fa-sharp fa-solid fa-briefcase"></i> <span>Code</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options code -->
                        <ul id="ul-code">
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Code/choix 1" ?>' style='display: block; text-decoration: none;'>Coix 1</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Code/choix 2" ?>' style='display: block; text-decoration: none;'>Coix 2</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Code/choix 3" ?>' style='display: block; text-decoration: none;'>Coix 3</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Code/choix 4" ?>' style='display: block; text-decoration: none;'>Coix 4</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Code/choix 5" ?>' style='display: block; text-decoration: none;'>Coix 5</a></li>
                        </ul>
                        <!-- end options code -->
                    </li>
                    <li id="infographie" class="chow-ops">
                        <i class="fa-sharp fa-solid fa-pen-nib"></i> <span>Infographie</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options infographie -->
                        <ul id="ul-infographie">
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Infographie/choix 1" ?>' style='display: block; text-decoration: none;'>Coix 1</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Infographie/choix 2" ?>' style='display: block; text-decoration: none;'>Coix 2</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Infographie/choix 3" ?>' style='display: block; text-decoration: none;'>Coix 3</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Infographie/choix 4" ?>' style='display: block; text-decoration: none;'>Coix 4</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Infographie/choix 5" ?>' style='display: block; text-decoration: none;'>Coix 5</a></li>
                        </ul>
                        <!-- end options infographie -->
                    </li>
                    <li id="photographie" class="chow-ops">
                        <i class="fa-solid fa-camera-retro"></i> <span>Photographie</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options photographie -->
                        <ul id="ul-photographie">
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Photographie/choix 1" ?>' style='display: block; text-decoration: none;'>Coix 1</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Photographie/choix 2" ?>' style='display: block; text-decoration: none;'>Coix 2</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Photographie/choix 3" ?>' style='display: block; text-decoration: none;'>Coix 3</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Photographie/choix 4" ?>' style='display: block; text-decoration: none;'>Coix 4</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Photographie/choix 5" ?>' style='display: block; text-decoration: none;'>Coix 5</a></li>
                        </ul>
                        <!-- end options photographie -->
                    </li>
                    <li id="videoCompositing" class="chow-ops">
                        <i class="fa-solid fa-video"></i> <span>Vidéo-Compositing</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options videoCompositing -->
                        <ul id="ul-videoCompositing">
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Vidéo-Compositing/choix 1" ?>' style='display: block; text-decoration: none;'>Coix 1</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Vidéo-Compositing/choix 2" ?>' style='display: block; text-decoration: none;'>Coix 2</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Vidéo-Compositing/choix 3" ?>' style='display: block; text-decoration: none;'>Coix 3</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Vidéo-Compositing/choix 4" ?>' style='display: block; text-decoration: none;'>Coix 4</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Vidéo-Compositing/choix 5" ?>' style='display: block; text-decoration: none;'>Coix 5</a></li>
                        </ul>
                        <!-- end options videoCompositing -->
                    </li>
                    <li id="webmarketing" class="chow-ops">
                        <i class="fa-solid fa-chart-simple"></i><span>Webmarketing</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options webmarketing -->
                        <ul id="ul-webmarketing">
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Webmarketing/choix 1" ?>' style='display: block; text-decoration: none;'>Coix 1</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Webmarketing/choix 2" ?>' style='display: block; text-decoration: none;'>Coix 2</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Webmarketing/choix 3" ?>' style='display: block; text-decoration: none;'>Coix 3</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Webmarketing/choix 4" ?>' style='display: block; text-decoration: none;'>Coix 4</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Webmarketing/choix 5" ?>' style='display: block; text-decoration: none;'>Coix 5</a></li>
                        </ul>
                        <!-- end options webmarketing -->
                    </li>
                    <li id="reseauxInformatique" class="chow-ops">
                        <i class="fa-solid fa-network-wired"></i> <span>Réseaux informatique</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options reseauxInformatique -->
                        <ul id="ul-reseauxInformatique">
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Réseaux informatique/choix 1" ?>' style='display: block; text-decoration: none;'>Coix 1</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Réseaux informatique/choix 2" ?>' style='display: block; text-decoration: none;'>Coix 2</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Réseaux informatique/choix 3" ?>' style='display: block; text-decoration: none;'>Coix 3</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Réseaux informatique/choix 4" ?>' style='display: block; text-decoration: none;'>Coix 4</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/Réseaux informatique/choix 5" ?>' style='display: block; text-decoration: none;'>Coix 5</a></li>
                        </ul>
                        <!-- end options reseauxInformatique -->
                    </li>
                    <li id="management" class="chow-ops">
                        <i class="fa-solid fa-list-check"></i> <span>Management</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options management -->
                        <ul id="ul-management">
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/management/choix 1" ?>' style='display: block; text-decoration: none;'>Coix 1</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/management/choix 2" ?>' style='display: block; text-decoration: none;'>Coix 2</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/management/choix 3" ?>' style='display: block; text-decoration: none;'>Coix 3</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/management/choix 4" ?>' style='display: block; text-decoration: none;'>Coix 4</a></li>
                            <li><a href='<?php echo URLROOT . "/pageFormations/filter/management/choix 5" ?>' style='display: block; text-decoration: none;'>Coix 5</a></li>
                        </ul>
                        <!-- end options management -->
                    </li>
                </ul>
                <!-- end main filter -->
            </div>
            <?php if ($data['numbFormations'] == 0) : ?>

                <h2 class='aucunF d-flex justify-content-center'><?php echo $data['info'] ?></h2>

            <?php else : ?>
                <div class="formations">
                    <?php foreach ($data['info'] as $info) : ?>
                        <!-- start card -->
                        <div class="card_coures">
                            <a href='<?php echo URLROOT . "/pageFormations/coursDetails/" . $info->IdFormation ?>' style='display: block; text-decoration: none;'>
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
                                    <!-- infotrmations formateur -->
                                    <a href='<?php echo URLROOT . "/profilFormateur/index/" . $info->IdFormteur ?>' style='display: block; text-decoration: none; z-index: 10;'>
                                        <div class="formateur">
                                            <div class="img_formateur">
                                                <img src="<?php echo $info->imgFormateur; ?>" alt="photo">
                                            </div>
                                            <h2><?php echo $info->nomFormateur; ?> <?php echo $info->prenomFormateur; ?></h2>
                                        </div>
                                    </a>
                                    <!-- informations -->
                                    <div class="info">
                                        <div class="etd"><?php echo $info->numbAcht; ?></div>
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                        <div class="likes"><?php echo $info->likes; ?></div>
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- end card -->
                    <?php endforeach; ?>
                </div>
                <!-- start pagenition -->
                <div class='footer_page_formations'>
                    <ul class="pagination d-flex justify-content-center">
                        <li style='font-size: 22px;' class='page-item'><a class='page-link' href="?pageno=1">First</a></li>
                        <li style='font-size: 22px;' class="page-item <?php if (intval($data['pageno']) <= 1) {
                                                                            echo 'disabled';
                                                                        } ?>">
                            <a class='page-link' href="<?php if (intval($data['pageno']) <= 1) {
                                                            echo '#';
                                                        } else {
                                                            echo "?pageno=" . (intval($data['pageno']) - 1);
                                                        } ?>">Prev</a>
                        </li>
                        <li style='font-size: 22px;' class="page-item  <?php if (intval($data['pageno']) >= intval($data['totalPages'])) {
                                                                            echo 'disabled';
                                                                        } ?>">
                            <a class='page-link' href="<?php if (intval($data['pageno']) >= intval($data['totalPages'])) {
                                                            echo '#';
                                                        } else {
                                                            echo "?pageno=" . (intval($data['pageno']) + 1);
                                                        } ?>">Next</a>
                        </li>
                        <li style='font-size: 22px;' class='page-item'><a class='page-link' href="?pageno=<?php echo intval($data['totalPages']); ?>">Last</a></li>
                    </ul>
                </div>
                <!-- end pagenition -->
            <?php endif; ?>
        </div>
    </section>
    <!-- end page formations -->
    <!-- Footer -->
    <footer class="mt-5" id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 footer-contact">
                        <h1 class="logo"><a href="#">M<span>A</span>H<span>A</span></a></h1>
                        <p>
                            Boulevard de Mohammedia <br>
                            QI Azli 40150<br>
                            Maroc <br><br>
                            <strong>Phone:</strong> (+212) 524 34 50 57<br>
                            <strong>Email:</strong> info@maha.com<br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container d-md-flex py-4">
            <div class="me-md-auto text-center text-md-start">
                <div class="copyright">
                    © Copyright <strong><span>MAHA</span></strong>. All Rights Reserved
                </div>
            </div>
        </div>
    </footer>
    <!-- Fin Footer -->
    <!-- To-up Button -->
    <span class="to-top" href="#"><i class="fa fa-chevron-up"></i></span>
    <!-- To-up Button -->
    <script src="<?php echo URLROOT; ?>/public/jQuery/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="<?php echo URLROOT; ?>/public/js/pageFormations.js"></script>
    <script src="<?php echo URLROOT; ?>/public/js/main.js"></script>
</body>

</html>