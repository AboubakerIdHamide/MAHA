<?php require_once APPROOT."/views/includes/header.php";?> 
<!-- Landing Section -->
<section id="landing" class="landing">
      <div class="container">
          <div class="site-info">
              <img src="<?php echo URLROOT."/Public"?>/images/congruts.png" alt="MAHA-ANIMATION-IMG" class="animation-img">
              <h2 class="title">
                  <span>M</span>
                  <span>A</span>
                  <span>H</span>
                  <span>A</span>
              </h2>
              <p class="short-description">
                  MAHA Est Un Site Internet De Formation En Ligne Qui Contient Des Cours Et Des Vidéos d'apprentissage
                  Dans Plusieur Domains Tels Que Le  Web Development, E-commerce, Digital Marketing ...
              </p>
              <a href="#" class="voir-plus">Voir Plus</a>
          </div>
          <div class="landing-image">
              <img src="<?php echo URLROOT."/Public"?>/images/landing.jpg" alt="MAHA">
          </div>
      </div>
</section>
<!-- Fin Landing Section -->

<!-- Section Statistiques -->
<section class="counts">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 text-center">
          <span>1232</span>
          <p>Etudiants</p>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 text-center">
          <span>64</span>
          <p>Formations</p>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 text-center">
          <span>15</span>
          <p>Formateurs</p>
        </div>
      </div>
    </div>
  </section>
  <!-- Fiin  Section Statistiques -->
  <!-- Category Head -->
  <section class="section-title mt-2" id="catalogue">
    <div class="container">
      <div>
          <h2>CATALOGUE</h2>
          <p>Toutes Les Formations</p>
      </div>
    </div> 
  </section>
<!-- Fin Category Head -->

<!-- Section Category -->
<section class="catalogue mt-1 mb-5">
      <div class="container">

        <div class="row">
          <div class="col-lg-3 col-md-4">
            <div class="icon-box">
              <i class="fa-brands fa-unity"></i>
              <h3><a href="1">3D</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
            <div class="icon-box">
              <i class="fa-solid fa-ruler-combined"></i>
              <h3><a href="2">Architecture & BIM</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
            <div class="icon-box">
              <i class="fa-solid fa-sliders"></i>
              <h3><a href="3">Audio-MAO</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4 mt-lg-0">
            <div class="icon-box">
              <i class="fa-solid fa-computer-mouse"></i>
              <h3><a href="4">Bureautique</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="fa-sharp fa-solid fa-briefcase"></i>
              <h3><a href="5">Business & Efficacité professionnelle</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="fa-solid fa-code"></i>
              <h3><a href="6">Code</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="fa-sharp fa-solid fa-pen-nib"></i>
              <h3><a href="7">Infographie</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="fa-solid fa-camera-retro"></i>
              <h3><a href="8">Photographie</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="fa-solid fa-video"></i>
              <h3><a href="9">Vidéo-Compositing</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="fa-solid fa-chart-simple"></i>
              <h3><a href="10">Webmarketing</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="fa-solid fa-network-wired"></i>
              <h3><a href="11">Réseaux informatique</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="fa-solid fa-list-check"></i>
              <h3><a href="12">Management</a></h3>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Fin Section Category -->
     <!-- Formation Head -->
    <section class="section-title mt-2 pb-0" id="popular">
      <div class="container">
        <div>
            <h2>FORMATIONS</h2>
            <p>Les Plus Populaires</p>
        </div>
      </div> 
    </section>
    <!-- Fin Formation Head -->
    <!-- start poplular courses -->
    <div class="poplularCourses">
        <div class="slide-container swiper container">
            <!-- container courses -->
            <div class="slide-content">
            <div class="card-wrapper swiper-wrapper courses">
              <?php foreach($data['info'] as $info) : ?>
                <!-- start card -->
                <div class="card swiper-slide card_coures">
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
        <div class="swiper-button-next swiper-navBtn"></div>
        <div class="swiper-button-prev swiper-navBtn"></div>
        <div class="swiper-pagination"></div>
    </div>
    <!-- end poplular courses -->
     <!-- Equipe Head -->
    <section class="section-title mt-2" id="equipe">
      <div class="container">
        <div>
            <h2>EQUIPE</h2>
            <p>RENCONTREZ-NOUS</p>
        </div>
      </div> 
    </section>
    <!-- Fin Equipe Head  -->
<!-- Section equipe -->
<section class="equipe">
  <div class="container-fluid" >
    <div class="row">
      <div class="col-lg-3 col-md-6 d-flex align-items-stretch creator">
          <div class="member p-3 mt-3">
            <div class="text-center">
              <h2>M</h2>
              <img src="<?php echo URLROOT."/Public"?>/images/membre.jpg" class="member-img" alt="">
              <h5>ABDELMOUMEN MUSTAFA</h5>
              <small><em>web developer</em></small>
            </div>
            <div class="member-content">
              <p>
                Magni qui quod omnis unde et eos fuga et exercitationem. Odio veritatis perspiciatis quaerat qui aut aut aut.
              </p>
              <div class="social d-flex justify-content-center gap-4">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-github"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
              </div>
            </div>
          </div>
      </div>
      <div class="col-lg-3 col-md-6 d-flex align-items-stretch creator">
          <div class="member p-3 mt-3">
            <div class="text-center">
              <h2><span>A</span></h2>
              <img src="<?php echo URLROOT."/Public"?>/images/membre.jpg" class="member-img" alt="">
              <h5>ID HAMIDE ABOUBAKER</h5>
              <small><em>web developer</em></small>
            </div>
            <div class="member-content">
              <p>
                Magni qui quod omnis unde et eos fuga et exercitationem. Odio veritatis perspiciatis quaerat qui aut aut aut.
              </p>
              <div class="social d-flex justify-content-center gap-4">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-github"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
              </div>
            </div>
          </div>
      </div>
        <div class="col-lg-3 col-md-6 d-flex align-items-stretch creator">
          <div class="member p-3 mt-3">
            <div class="text-center">
              <h2>H</h2>
              <img src="<?php echo URLROOT."/Public"?>/images/membre.jpg" class="member-img" alt="">
              <h5>TASDIHT HICHAM</h5>
              <small><em>web developer</em></small>
            </div>
            <div class="member-content">
              <p>
                Magni qui quod omnis unde et eos fuga et exercitationem. Odio veritatis perspiciatis quaerat qui aut aut aut.
              </p>
              <div class="social d-flex justify-content-center gap-4">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-github"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
              </div>
            </div>
          </div>
      </div>
        <div class="col-lg-3 col-md-6 d-flex align-items-stretch creator">
          <div class="member p-3 mt-3">
            <div class="text-center">
              <h2><span>A</span></h2>
              <img src="<?php echo URLROOT."/Public"?>/images/membre.jpg" class="member-img" alt="">
              <h5>BOUDAL AHMED</h5>
              <small><em>web developer</em></small>
            </div>
            <div class="member-content">
              <p>
                Magni qui quod omnis unde et eos fuga et exercitationem. Odio veritatis perspiciatis quaerat qui aut aut aut.
              </p>
              <div class="social d-flex justify-content-center gap-4">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-github"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</section>
<!-- Fin Equipe -->
<!-- Contact Head -->
<section class="section-title mt-2" id="contact">
  <div class="container">
    <div>
        <h2>Contactez-Nous</h2>
    </div>
  </div> 
</section>
<!-- Fin contact Head  -->
<!-- Contact Section -->
<section class="contact">
  <div class="container" >
    <div class="row">
      <div class="col-lg-4">
        <div class="info">
          <div class="address">
            <i class="fa-solid fa-location-dot"></i>
            <h4>Localisation:</h4>
            <p>Boulevard de Mohammedia, QI Azli 40150</p>
          </div>

          <div class="email">
            <i class="fa-solid fa-envelope"></i>
            <h4>Email:</h4>
            <p>info@maha.com</p>
          </div>

          <div class="phone">
            <i class="fa-solid fa-phone"></i>
            <h4>Appel:</h4>
            <p>(+212) 524 34 50 57</p>
          </div>

        </div>

      </div>

      <!-- Form -->
      <div class="col-lg-8 mt-5 mt-lg-0">
        <form action="forms/contact.php" method="post">
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="name" class="form-control" id="name" placeholder="Votre Nom" required="">
            </div>
            <div class="col-md-6 mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Votre Email" required="">
            </div>
          </div>
          <div class="mt-3">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Sujet" required="">
          </div>
          <div class="mt-3">
            <textarea class="form-control" name="message" rows="5" placeholder="Message" required="" style="height: 138px;resize: none;"></textarea>
          </div>
          <div class="text-center my-3">
            <button type="submit" class="submit-btn">Envoyer</button>
          </div>
        </form>

      </div>
      <!-- Fin Form -->
    </div>

  </div>
</section>
<!-- Fin Contact Section -->
<?php require_once APPROOT."/views/includes/footer.php";?> 
