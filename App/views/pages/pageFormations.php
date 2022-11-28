<?php require_once APPROOT."/views/includes/header.php";?> 
<!-- start page formations -->
<section class="pageFormation">
        <div class="header_page_formation">
            <h2>Les Formations</h2>
            <p>Une erreur, fût-elle vieille de cent mille ans, par cela même qu'elle est vieille, ne constitue pas une vérité ! la foule invariablement suit la routine. C'est au contraire, le petit nombre qui mène le progrès.</p>
        </div>
        <div class="container">
            <div class="filter">
                <div class="main-filter">
                    <i class="fa fa-filter" aria-hidden="true"></i> <span>Filter</span>
                </div>
                <div class="filter-par">
                    <span>Trier par :</span>
                    <select name="trier">
                        <option value="plus-puplaire">Les Plus Populaires</option>
                        <option value="plus-amais">Les Plus Amais</option>
                        <option value="plus-.">Les Plus ...</option>
                        <option value="plus-..">Les Plus ...</option>
                    </select>
                    <select name="lang">
                        <option value="an">Anglais</option>
                        <option value="ar">Arabe</option>
                        <option value="fr">Francais</option>
                    </select>
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
                            <li>Coix 1</li>
                            <li>Coix 2</li>
                            <li>Coix 3</li>
                            <li>Coix 4</li>
                            <li>Coix 5</li>
                            <!-- <li>Coix 6</li>
                            <li>Coix 7</li>
                            <li>Coix 8</li>
                            <li>Coix 9</li>
                            <li>Coix 10</li> -->
                        </ul>
                        <!-- end options 3d -->
                    </li>
                    <li id="architectureBIM"  class="chow-ops">
                        <i class="fa-solid fa-ruler-combined"></i> <span>Architecture & BIM</span> 
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options architecture&BIM -->
                        <ul id="ul-architectureBIM">
                            <li>Coix 1</li>
                            <li>Coix 2</li>
                            <li>Coix 3</li>
                            <li>Coix 4</li>
                            <li>Coix 5</li>
                            <li>Coix 6</li>
                            <li>Coix 7</li>
                            <li>Coix 8</li>
                            <li>Coix 9</li>
                            <li>Coix 10</li>
                        </ul>
                        <!-- end options architecture&BIM -->
                    </li>
                    <li id="audio-MAO"  class="chow-ops">
                        <i class="fa-solid fa-sliders"></i> <span>Audio-MAO</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options audio-MAO -->
                        <ul id="ul-audio-MAO">
                            <li>Coix 1</li>
                            <li>Coix 2</li>
                            <li>Coix 3</li>
                            <li>Coix 4</li>
                            <li>Coix 5</li>
                            <li>Coix 6</li>
                            <li>Coix 7</li>
                            <li>Coix 8</li>
                            <li>Coix 9</li>
                            <li>Coix 10</li>
                        </ul>
                        <!-- end options audio-MAO -->
                    </li>
                    <li id="bureautique"  class="chow-ops">
                        <i class="fa-solid fa-computer-mouse"></i> <span>Bureautique</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options bureautique -->
                        <ul id="ul-bureautique">
                            <li>Coix 1</li>
                            <li>Coix 2</li>
                            <li>Coix 3</li>
                            <li>Coix 4</li>
                            <li>Coix 5</li>
                            <li>Coix 6</li>
                            <li>Coix 7</li>
                            <li>Coix 8</li>
                            <li>Coix 9</li>
                            <li>Coix 10</li>
                        </ul>
                        <!-- end options bureautique -->
                    </li>
                    <li id="businessEfficaciteProfessionnelle"  class="chow-ops">
                        <i class="fa-sharp fa-solid fa-briefcase"></i> <span>Business & Efficacité professionnelle</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options business&EfficacitéProfessionnelle -->
                        <ul id="ul-businessEfficaciteProfessionnelle">
                            <li>Coix 1</li>
                            <li>Coix 2</li>
                            <li>Coix 3</li>
                            <li>Coix 4</li>
                            <li>Coix 5</li>
                            <li>Coix 6</li>
                            <li>Coix 7</li>
                            <li>Coix 8</li>
                            <li>Coix 9</li>
                            <li>Coix 10</li>
                        </ul>
                        <!-- end options business&EfficacitéProfessionnelle -->
                    </li>
                    <li id="code"  class="chow-ops">
                        <i class="fa-sharp fa-solid fa-briefcase"></i> <span>Code</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options code -->
                        <ul id="ul-code">
                            <li>Coix 1</li>
                            <li>Coix 2</li>
                            <li>Coix 3</li>
                            <li>Coix 4</li>
                            <li>Coix 5</li>
                            <li>Coix 6</li>
                            <li>Coix 7</li>
                            <li>Coix 8</li>
                            <li>Coix 9</li>
                            <li>Coix 10</li>
                        </ul>
                        <!-- end options code -->
                    </li>
                    <li id="infographie"  class="chow-ops">
                        <i class="fa-sharp fa-solid fa-pen-nib"></i> <span>Infographie</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                         <!-- start options infographie -->
                         <ul id="ul-infographie">
                            <li>Coix 1</li>
                            <li>Coix 2</li>
                            <li>Coix 3</li>
                            <li>Coix 4</li>
                            <li>Coix 5</li>
                            <li>Coix 6</li>
                            <li>Coix 7</li>
                            <li>Coix 8</li>
                            <li>Coix 9</li>
                            <li>Coix 10</li>
                        </ul>
                        <!-- end options infographie -->
                    </li>
                    <li id="photographie"  class="chow-ops">
                        <i class="fa-solid fa-camera-retro"></i> <span>Photographie</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options photographie -->
                        <ul id="ul-photographie">
                            <li>Coix 1</li>
                            <li>Coix 2</li>
                            <li>Coix 3</li>
                            <li>Coix 4</li>
                            <li>Coix 5</li>
                            <li>Coix 6</li>
                            <li>Coix 7</li>
                            <li>Coix 8</li>
                            <li>Coix 9</li>
                            <li>Coix 10</li>
                        </ul>
                        <!-- end options photographie -->
                    </li>
                    <li id="videoCompositing"  class="chow-ops">
                        <i class="fa-solid fa-video"></i> <span>Vidéo-Compositing</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options videoCompositing -->
                        <ul id="ul-videoCompositing">
                            <li>Coix 1</li>
                            <li>Coix 2</li>
                            <li>Coix 3</li>
                            <li>Coix 4</li>
                            <li>Coix 5</li>
                            <li>Coix 6</li>
                            <li>Coix 7</li>
                            <li>Coix 8</li>
                            <li>Coix 9</li>
                            <li>Coix 10</li>
                        </ul>
                        <!-- end options videoCompositing -->
                    </li>
                    <li id="webmarketing"  class="chow-ops">
                        <i class="fa-solid fa-chart-simple"></i><span>Webmarketing</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options webmarketing -->
                        <ul id="ul-webmarketing">
                            <li>Coix 1</li>
                            <li>Coix 2</li>
                            <li>Coix 3</li>
                            <li>Coix 4</li>
                            <li>Coix 5</li>
                            <li>Coix 6</li>
                            <li>Coix 7</li>
                            <li>Coix 8</li>
                            <li>Coix 9</li>
                            <li>Coix 10</li>
                        </ul>
                        <!-- end options webmarketing -->
                    </li>
                    <li id="reseauxInformatique"  class="chow-ops">
                        <i class="fa-solid fa-network-wired"></i> <span>Réseaux informatique</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options reseauxInformatique -->
                        <ul id="ul-reseauxInformatique">
                            <li>Coix 1</li>
                            <li>Coix 2</li>
                            <li>Coix 3</li>
                            <li>Coix 4</li>
                            <li>Coix 5</li>
                            <li>Coix 6</li>
                            <li>Coix 7</li>
                            <li>Coix 8</li>
                            <li>Coix 9</li>
                            <li>Coix 10</li>
                        </ul>
                        <!-- end options reseauxInformatique -->
                    </li>
                    <li id="management"  class="chow-ops">
                        <i class="fa-solid fa-list-check"></i> <span>Management</span>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </li>
                    <li class="at-ops hide">
                        <!-- start options management -->
                        <ul id="ul-management">
                            <li>Coix 1</li>
                            <li>Coix 2</li>
                            <li>Coix 3</li>
                            <li>Coix 4</li>
                            <li>Coix 5</li>
                            <li>Coix 6</li>
                            <li>Coix 7</li>
                            <li>Coix 8</li>
                            <li>Coix 9</li>
                            <li>Coix 10</li>
                        </ul>
                        <!-- end options management -->
                    </li>
                </ul>
                <!-- end main filter -->
            </div>
            <div class="formations">
            <?php foreach($data['info'] as $info) : ?>
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
            <!-- start footer page formations -->
            <div class="footer_page_formations">
                <div id="pagination"></div>
            </div>
            <!-- start footer page formations -->
        </div>
    </section>
    <!-- end page formations -->
<?php require_once APPROOT."/views/includes/footer.php";?> 