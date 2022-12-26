<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $data->nom_formation ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= URLROOT . "/Public/css/cours-details-paid.css" ?>">
</head>

<body>
  <!-- formateur info -->
  <section class="media-header">
    <div class="container mt-3">
      <div class="row">
        <div class="col-xl-3">
          <a href="<?= URLROOT . "/etudiant/index" ?>">
            <img class="img-fluid" src="<?= $data->image_formation ?>" alt="formation image">
          </a>
        </div>
        <div class="col-xl-7">
          <div class="group d-flex flex-column justify-content-center">
            <h3 class="title"><?= $data->nom_formation ?></h3>
            <p>Formation catégorie <span><?= $data->categorie ?></span></p>
            <div class="instructor d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center gap-2">
                <img src="<?= $data->img_formateur ?>" alt="" class="formateur-img">
                <div class="instructor-info">
                  <h5><?= $data->nom_formateur ?> <?= $data->prenom_formateur ?></h5>
                  <p class="specialite mb-0"><?= $data->specialiteId ?></p>
                </div>
              </div>
              <div class="love-ses-formations d-flex align-items-center gap-2">
                <i class="<?= $data->liked ? "fa-solid" : "fa-regular" ?> fa-heart"></i>
                <a href="#">Voir Profil</a>
              </div>
            </div>
            <div class="mt-3 masse-h d-flex flex-row justify-content-between">
              <p><i class="fa-solid fa-clock"></i> <?= $data->mass_horaire ?></p>
              <p><i class="fa-solid fa-language"></i> <?= $data->id_langue ?></p>
            </div>
          </div>
        </div>
        <div class="col-xl-2 align-self-center">
          <div class="info-plus">
            <div class="text-center mb-1 apprenants-nbr">
              <p class="nbr"><?= $data->apprenants ?></p>
              <p>Apprenants</p>
            </div>
            <div class="fomation-niveau text-center mb-1">
              <div class="level-indicator">
                <?php if ($data->niveau_formation == 1) { ?>
                  <svg width="58" height="30" viewBox="0 0 38 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#E5E5E5" d="M9 4h6v2H9zM23 4h6v2h-6z"></path>
                    <circle cx="5" cy="5" r="5" fill="#8887FF"></circle>
                    <circle fill="#E5E5E5" cx="19" cy="5" r="5"></circle>
                    <circle fill="#E5E5E5" cx="33" cy="5" r="5"></circle>
                  </svg>
                <?php } elseif ($data->niveau_formation == 2) { ?>
                  <svg width="58" height="30" viewBox="0 0 38 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 4h6v2H9z" fill="#8887FF"></path>
                    <path d="M23 4h6v2h-6z" fill="#E5E5E5"></path>
                    <circle cx="5" cy="5" r="5" fill="#8887FF"></circle>
                    <circle cx="19" cy="5" r="5" fill="#8887FF"></circle>
                    <circle fill="#E5E5E5" cx="33" cy="5" r="5"></circle>
                  </svg>
                <?php } elseif ($data->niveau_formation == 3) { ?>
                  <svg width="58" height="30" viewBox="0 0 38 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#8887FF" d="M9 4h6v2H9zM23 4h6v2h-6z"></path>
                    <circle cx="5" cy="5" r="5" fill="#8887FF"></circle>
                    <circle fill="#8887FF" cx="19" cy="5" r="5"></circle>
                    <circle fill="#8887FF" cx="33" cy="5" r="5"></circle>
                  </svg>
                <?php }; ?>
              </div>
              <p>Niveau <?= $data->niveau ?></p>
            </div>
            <div class="text-center">
              <p class="nbr formation-likes"><?= $data->likes ?></p>
              <p>Likes</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end formateur info -->

  <section class="container mt-3">
    <hr />
    <div class="row">
      <div class="col">
        <h4 class="main-video-name"><?= $data->videos[0]->order_video . "." . $data->videos[0]->nom_video ?></h4>
        <section class="main-video ratio ratio-16x9">
          <video id="video" src="<?= $data->videos[0]->url_video ?>" controls controlsList="nodownload"></video>
        </section>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <section class="playlist-videos">
          <h5><?= $data->nom_formation ?></h5>
          <div class="some-info mb-3">
            <span class="main-video-duration"><?= $data->videos[0]->duree_video ?></span>
          </div>
          <div class="videos-list">
            <ul>
              <?php foreach ($data->videos as $video) { ?>
                <!-- max 50 chars video name or less -->
                <li class="d-flex justify-content-between mt-1 <?= $video == $data->videos[0] ? "selected" : "" ?>">
                  <div class="d-flex align-items-center"><i class="fa-solid <?= $video == $data->videos[0] ? "fa-circle-pause" : "fa-circle-play" ?>"></i>&nbsp;&nbsp;&nbsp;<span data-video-id="<?= $video->id_video ?>" data-video-desc="<?= $video->description_video ?>" class="video-name">
                      <?= $video->order_video . "." . $video->nom_video ?></span></div>
                  <div class="d-flex align-items-center">
                    <span class="tooltip-circle-check me-3">
                      <i class="<?= $video->watched ? "fa-solid" : "fa-regular" ?> fa-circle-check" id="watch-<?= $video->id_video ?>"></i>
                    </span>
                    <span class="tooltip-bookmark">
                      <i class="<?= $video->bookmarked ? "fa-solid" : "fa-regular" ?> fa-bookmark"></i></span>&nbsp;&nbsp;&nbsp;
                    <span class="video-duration" data-video-url="<?= $video->url_video ?>" id="video-<?= $video->id_video ?>" data-video-comments='<?= json_encode($video->comments) ?>'><?= $video->duree_video ?></span>
                  </div>
                </li>
              <?php } ?>
            </ul>
          </div>
        </section>
      </div>
    </div>
  </section>
  <!-- RESSOURCES -->
  <?php if (isset($data->ressources)) { ?>
    <section class="section-title" id="catalogue">
      <div class="container">
        <div>
          <h2>RESSOURCES</h2>
          <p>LES FICHIERS ATTACHÉS</p>
        </div>
      </div>
    </section>
    <!-- Fin RESSOURCES -->
    <section class="container">
      <div class="row">
        <div class="col mb-2">
          <div class="ressources">
            <p>Vous pouvez télécharger les fichiers attachés avec cette video en cliquant sur la button au-dessous :</p><a href="#" target="_blank" class="submit-btn" download><i class="fa-sharp fa-solid fa-download"></i>&nbsp;&nbsp;Télécharger</a>
          </div>
        </div>
      </div>
    </section>
  <?php } ?>
  <!-- DESCRIPTION Head -->
  <section class="section-title mt-4" id="catalogue">
    <div class="container">
      <div>
        <h2>DESCRIPTION</h2>
        <p>À propos de cette video</p>
      </div>
    </div>
  </section>
  <!-- Fin DESCRIPTION Head -->
  <section class="container">
    <div class="row">
      <div class="col">
        <p class="desc"><?= $data->videos[0]->description_video ?></p>
      </div>
    </div>
    </div>
  </section>
  <!-- COMMENTAIRES Head -->
  <section class="section-title mb-4 mt-4" id="catalogue">
    <div class="container">
      <div>
        <h2>COMMENTAIRES</h2>
        <!-- <p>LES FICHIERS ATTACHEES</p> -->
      </div>
    </div>
  </section>
  <!-- Fin COMMENTAIRES Head -->
  <section class="container comments-section mb-5">
    <div class="row">
      <!-- <div class="col">
  			No Comments Yet.
  		</div> -->
      <div class="col">
        <div class="my-comments">
          <?php foreach ($data->videos[0]->comments as $comment) { ?>
            <div class="d-flex gap-2 mb-2 <?php if ($comment->type_user === "formateur") echo "flex-row-reverse" ?>">
              <img class="align-self-start" src="<?= $comment->image ?>" alt="my-photo">
              <div class="d-flex flex-column <?php echo ($comment->type_user === "formateur") ? "formateur-comment" : "etudiant-comment" ?>">
                <span class="my-name"><?= $comment->nom . " " . $comment->prenom ?></span>
                <p><?= $comment->commentaire ?></p>
                <div class="d-flex justify-content-between">
                  <small><?= $comment->created_at ?></small>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>
  <section class="container mb-5">
    <div class="row">
      <div class="col-lg-10 col-md-10">
        <div class="comment-entry">
          <textarea class="form-control comment-text" placeholder="commentaire"></textarea>
          <div class="d-flex justify-content-between">
            <small class="text-danger comment-error"></small>
            <small><span class="cpt-caractere">0</span>/500</small>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-2 d-lg-block d-md-block d-flex justify-content-center">
        <button data-type-user="<?= trim($_SESSION['user']['type']) ?>" type="submit" class="submit-btn">Envoyer</button>
      </div>
    </div>
  </section>
  <!-- To-up Button -->
  <span class="to-top" href="#"><i class="fa fa-chevron-up"></i></span>
  <!-- To-up Button -->
  <script>
    const urlRoot = "<?= URLROOT ?>";
    const formationId = <?= $data->id_formation ?>;
    const etudiantId = "<?= $data->id_formateur ?>";
    const etudiantImageSrc = "<?= $data->img_formateur ?>";
    const etudiantFullName = "<?= $data->nom_formateur . " " . $data->prenom_formateur ?>";
    let videoId = <?= $data->videos[0]->id_video ?>;
  </script>
  <script src="<?= URLROOT . "/Public/jQuery/jquery-3.6.0.min.js" ?>"></script>
  <script src="<?= URLROOT . "/Public/js/cours-details-paid.js" ?>"></script>
</body>

</html>