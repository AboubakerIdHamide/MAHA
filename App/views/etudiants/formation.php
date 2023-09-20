<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
        <title><?= $formation->nomFormation ?> | <?= SITENAME ?></title>

        <!-- Custom Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,500,700%7CRoboto:400,500%7CRoboto:400,500&display=swap" />

        <!-- Perfect Scrollbar -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/perfect-scrollbar.css" />

        <!-- Material Design Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/icons/material-icons.css" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/icons/all.min.css" />

        <!-- Preloader -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/spinkit.css" />

        <!-- App CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/app.css" />

        <!-- Plyr CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/plyr.min.css" />
   
        <style>
            .video {
                cursor: pointer;
                transition: .3s background-color;
            }   

            .video:hover {
                background-color: #2196f37d;
            }
        </style>
    </head>

    <body class=" layout-fluid">

        <div class="preloader">
            <div class="sk-chase">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>

            <!-- <div class="sk-bounce">
    <div class="sk-bounce-dot"></div>
    <div class="sk-bounce-dot"></div>
  </div> -->

            <!-- More spinner examples at https://github.com/tobiasahlin/SpinKit/blob/master/examples.html -->
        </div>

        <!-- Header Layout -->
        <div class="mdk-header-layout js-mdk-header-layout">
            <!-- require navbar header -->
            <?php require_once APPROOT . "/views/includes/etudiant/navbar.php" ?>

            <!-- Header Layout Content -->
            <div class="mdk-header-layout__content">
                <div data-push
                     data-responsive-width="992px"
                     class="mdk-drawer-layout js-mdk-drawer-layout">
                    <div class="mdk-drawer-layout__content page">
                        <div class="container-fluid page__container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?= URLROOT ?>/etudiant">Mes cours</a></li>
                                <li class="breadcrumb-item active"><?= $formation->nomFormation ?></li>
                            </ol>
                            <h1 class="h2"><?= $formation->nomFormation ?></h1>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="video-container">
                                            <video id="player" src="<?= VIDEOROOT ?>/<?= $videos[0]->url ?>" style="--plyr-color-main: #2196f3;"  playsinline controls>
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                        <div class="card-body">
                                            <h5 id="video-nom" class="text-center d-block">
                                                <?= $videos[0]->nomVideo ?>
                                            </h5>
                                            <hr />
                                            <div id="video-description" class="text-truncate">
                                                <?= $videos[0]->description ?>
                                            </div>
                                            <a id="btn-read" href="javascript:void(0)">more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Lessons -->
                                    <ul class="card list-group list-group-fit">
                                        <?php $i = 0 ?>
                                        <?php foreach($videos as $video) :  ?>
                                        <li class="video list-group-item <?= $i === 0 ? 'active' : '' ?>" data-video='<?= json_encode($video) ?>'>
                                            <div class="media">
                                                <div class="media-body <?= $i === 0 ? 'text-white' : '' ?>">
                                                    <div class="d-flex align-items-center">
                                                        <?= $i === 0 ? '<i class="material-icons icon">pause_circle_filled</i>' : '<i class="material-icons icon"></i>' ?> 
                                                        <span class="ml-1"><?= ++$i ?>. <?= $video->nomVideo ?></span>
                                                    </div>
                                                </div>
                                                <div class="media-right d-flex align-items-center">
                                                    <span data-id="<?= $video->id_video ?>" class="bookmark"><i class="material-icons mr-2" data-toggle="tooltip" data-placement="top" title="Toggle Bookmark"><?= $video->is_bookmarked ? 'bookmark' : 'bookmark_border' ?></i></span>
                                                    <small><?= $video->duree ?></small>
                                                </div>
                                            </div>
                                        </li>
                                        <?php endforeach ?>
                                    </ul>
                                    <!-- id_formation -->
                                    <input type="hidden" value="<?= $formation->id_formation ?>" id="id_formation" />
                                </div>
                                <div class="col-md-4">
                                    <?php if($formation->fichier_attache): ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?= URLROOT ?>/public/files/<?= $formation->fichier_attache ?>"
                                                download 
                                               class="btn btn-primary btn-block flex-column">
                                                <i class="material-icons">get_app</i> Download Files
                                            </a>
                                        </div>
                                    </div>
                                    <?php endif ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="media align-items-center">
                                                <div class="media-left">
                                                    <img src="<?= IMAGEROOT ?>/<?= $formation->imgFormateur ?>"
                                                         alt="About <?= $formation->nomFormateur ?>"
                                                         width="50"
                                                         class="rounded-circle">
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="card-title"><a href="instructor-profile.html"><?= $formation->nomFormateur ?> <?= $formation->prenomFormateur ?></a></h4>
                                                    <p class="card-subtitle">Instructor</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <button data-toggle="modal" data-target="#ask-formateur-modal" data-video="<?= $videos[0]->id_video ?>" id="ask-formateur" class="btn btn-info btn-block">
                                                <i class="material-icons mr-2">message</i> Ask me
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <ul class="list-group list-group-fit">
                                            <li class="list-group-item">
                                                <div class="media align-items-center">
                                                    <div class="media-left">
                                                        <i class="material-icons text-muted-light">schedule</i>
                                                    </div>
                                                    <div class="media-body">
                                                        <?= $formation->mass_horaire ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="media align-items-center">
                                                    <div class="media-left">
                                                        <i class="material-icons text-muted-light">assessment</i>
                                                    </div>
                                                    <div class="media-body"><?= $formation->nomNiveau ?></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <a href="javascript:void(0)"
                                        id="like" 
                                       class="btn <?= $formation->isLiked ? 'btn-danger' : 'btn-default text-danger' ?> btn-block">
                                        <span id="number-likes"><?= $formation->jaimes ?></span>
                                        <i class="material-icons ml-1">favorite</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- require sidebar -->
                    <?php require_once APPROOT . "/views/includes/etudiant/sideNavbar.php" ?>
                </div>
            </div>
        </div>

        <!-- Ask Formateur Modal -->
        <div class="modal fade" id="ask-formateur-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div id="alert" class="text-center mb-0"></div>
                    <form method="POST" id="ask-form">
                        <div class="modal-body pb-0">
                            <div class="form-group">
                                <input name="nom_video" class="form-control mb-2" id="video-mention" value="@<?= $videos[0]->nomVideo ?>" readonly />
                                <textarea placeholder="Ask your instractor" name="message" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <input type="hidden" name="to" value="<?= $formation->id_formateur ?>" />
                        </div>
                        <div class="modal-footer pt-0">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="close-modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="material-icons mr-2">send</i> Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- // End Ask Formateur Modal -->

        <!-- Scripts -->
        <!-- jQuery -->
        <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>

        <!-- Bootstrap -->
        <script src="<?= JSROOT ?>/plugins/popper.min.js"></script>

        <!-- Perfect Scrollbar -->
        <script src="<?= JSROOT ?>/plugins/perfect-scrollbar.min.js"></script>

        <!-- MDK -->
        <script src="<?= JSROOT ?>/plugins/dom-factory.js"></script>
        <script src="<?= JSROOT ?>/plugins/material-design-kit.js"></script>

        <!-- Bootstrap -->
        <script src="<?= JSROOT ?>/plugins/bootstrap-4.min.js"></script>

        <!-- App JS -->
        <script src="<?= JSROOT ?>/plugins/app.js"></script>

        <!-- Plyr -->
        <script src="<?= JSROOT ?>/plugins/plyr.min.js"></script>

        <!-- Jquery Validator -->
        <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>

        <script>const URLROOT = `<?= URLROOT ?>`;</script>
        <script src="<?= JSROOT ?>/etudiants/formation.js"></script>
    </body>
</html>