<?php require_once APPROOT."/views/includes/header.php" ?> 
<div class="preloader">
    <div class="spinner-border text-info" style="height: 4rem;width: 4rem" role="status">
</div>
  </div>
<!-- Landing Section -->
<section id="landing" class="landing d-flex align-item-center">
      <div class="container">
          <div class="site-info wow slideInLeft" data-wow-duration="1s">
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
              <div class="rejoignez-nous">
                <div id="circle"></div>
                <a href="<?= URLROOT.'/users/register' ?>">Rejoignez-nous</a>
              </div>
          </div>
          <div class="landing-image wow slideInRight" data-wow-duration="1s">
              <img src="<?php echo URLROOT."/Public"?>/images/online_learning.svg" alt="MAHA">
          </div>
      </div>
</section>
<!-- Fin Landing Section -->

<!-- Section Statistiques -->
<section class="counts">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 text-center wow rollIn" data-wow-duration="2s" data-wow-offset="10">
          <span><?= $data['totalEtudiants'] ?></span>
          <p>Etudiants</p>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 text-center wow rollIn" data-wow-duration="2s" data-wow-offset="10">
          <span><?= $data['totalFormations'] ?></span>
          <p>Formations</p>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 text-center wow rollIn" data-wow-duration="2s" data-wow-offset="10">
          <span><?= $data['totalFormateurs'] ?></span>
          <p>Formateurs</p>
        </div>
      </div>
    </div>
  </section>
  <!-- Fiin  Section Statistiques -->
  <!-- Category Head -->
  <section class="section-title mt-2 wow fadeInLeft" id="catalogue" data-wow-duration="3s" data-wow-offset="100">
    <div class="container">
      <div>
          <h2 class="text-uppercase">catégories</h2>
          <p>Toutes Les catégories</p>
      </div>
    </div> 
  </section>
<!-- Fin Category Head -->

<!-- Section Category -->
<section class="catalogue mt-1 mb-5">
      <div class="container">
        <div class="row">
          <?php foreach ($data['categories'] as $categorie) : ?>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box rounded-2 wow fadeInDown" data-wow-duration="2s" data-wow-offset="10">
              <?= $categorie->icon ?>
              <h3><a href="<?= URLROOT.'/pageFormations/filter/'.$categorie->nom_categorie ?>"><?= $categorie->nom_categorie ?></a></h3>
            </div>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </section>
    <!-- Fin Section Category -->
     <!-- Formation Head -->
    <section class="section-title mt-2 pb-0 wow fadeInLeft" id="popular" data-wow-duration="3s" data-wow-offset="100">
      <div class="container">
        <div>
            <h2>FORMATIONS</h2>
            <p>Les Plus Populaires</p>
        </div>
      </div> 
    </section>
    <!-- Fin Formation Head -->
    <!-- start poplular courses -->
    <section class='poplularCourses'>
        <div class='container'>
            <div class="courses">
              <?php foreach($data['courses'] as $course) : ?>
                <!-- start card -->
                <div class="card_coures wow fadeInRight" data-wow-duration="2s" data-wow-offset="100">
                  <a href='<?php echo URLROOT."/pageFormations/coursDetails/".$course->IdFormation?>' style='display: block; text-decoration: none;'>
                    <!-- img formation -->
                    <div class="img">
                        <img src="<?php echo $course->imgFormation; ?>" alt="photo">
                        <div class="duree">
                            <i class="fa-solid fa-clock" aria-hidden="true"></i>
                            <div class="time"><?php echo $course->duree; ?></div>
                        </div>
                    </div>
                    <!-- informations formation -->
                    <div class="info_formation">
                        <div class="categorie"><?php echo $course->categorie; ?></div>
                        <div class="prix"><?php echo $course->prix; ?></div>
                    </div>
                    <!-- name formation -->
                    <h1><?php echo $course->nomFormation; ?></h1>
                    <!-- description -->
                    <div class="description">
                        <p><?php echo $course->description; ?></p>
                    </div>
                    <div class="footer">
                        <!-- infotrmations formateur -->
                        <a href='<?php echo URLROOT."/profilFormateur/index/".$course->IdFormteur?>' style='display: block; text-decoration: none; z-index: 10;'>
                            <div class="formateur">
                                <div class="img_formateur">
                                    <img src="<?php echo $course->imgFormateur; ?>" alt="photo">
                                </div>
                                <h2><?php echo $course->nomFormateur; ?> <?php echo $course->prenomFormateur; ?></h2>
                            </div>
                        </a>
                        <!-- informations -->
                        <div class="info">
                            <div class="etd"><?php echo $course->numbAcht; ?></div>
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            <div class="likes"><?php echo $course->likes; ?></div>
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                    </div>
                  </a>
                </div>
                <!-- end card -->
              <?php endforeach; ?>
        </div>
      </div>
    </section>
    <!-- end poplular courses -->
<!-- Equipe Head -->
    <section class="section-title mt-2" id="equipe">
      <div class="container wow fadeInLeft" data-wow-duration="3s" data-wow-offset="100">
        <div>
            <h2>EQUIPE</h2>
            <p>RENCONTREZ-NOUS</p>
        </div>
      </div> 
    </section>
    <!-- Fin Equipe Head  -->
<!-- Section equipe -->
<section class="equipe">
  <div class="container" >
    <div class="row">
      <div class="col-lg-3 col-md-6 d-flex align-items-stretch creator wow rotateInUpLeft" data-wow-duration="2s" data-wow-offset="100">
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
      <div class="col-lg-3 col-md-6 d-flex align-items-stretch creator wow rotateInUpLeft" data-wow-duration="2s" data-wow-offset="100">
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
        <div class="col-lg-3 col-md-6 d-flex align-items-stretch creator wow rotateInUpLeft" data-wow-duration="2s" data-wow-offset="100">
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
        <div class="col-lg-3 col-md-6 d-flex align-items-stretch creator wow rotateInUpLeft" data-wow-duration="2s" data-wow-offset="100">
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
  <div class="container wow fadeInLeft" data-wow-duration="3s" data-wow-offset="100">
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
      <div class="col-lg-4 wow slideInLeft" data-wow-duration="2s" data-wow-offset="60">
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
      <div class="col-lg-8 mt-5 mt-lg-0 wow slideInRight" data-wow-duration="2s" data-wow-offset="60">
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
