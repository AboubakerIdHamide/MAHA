<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Videos</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= URLROOT . "/Public/css/watchedBookMarkedVideos.css" ?>">
  <link rel="stylesheet" href="<?= URLROOT . "/Public/css/dashBoardNav.css" ?>">
</head>

<body>
  <?php require_once APPROOT . "/views/includes/etudiantHeader.php"; ?>
  <div class="main">
    <ul class="cards">
      <?php foreach ($data["videos"] as $video) { ?>
        <li class="cards_item">
          <div class="card">
            <div class="card_image">
              <video controls src="<?= $video->url_video ?>"></video>
            </div>
            <div class="card_content">
              <h2 class="card_title"><?= $video->nom_video ?></h2>
              <p class="card_text"><?= $video->description_video ?></p>
              <a href="<?= URLROOT . "/etudiant/coursVideos/" . $video->id_formateur . "/" . $video->id_formation ?>" class="btn card_btn"><?= $video->nom_formation ?></a>
            </div>
          </div>
        </li>
      <?php } ?>
    </ul>
  </div>
  <script src="<?= URLROOT . "/Public/js/dashBoardNav.js" ?>"></script>
</body>

</html>