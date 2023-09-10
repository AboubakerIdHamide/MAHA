<?php //print_r2($bookmarks) ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
        <title>Dashboard | <?= SITENAME ?></title>

        <!-- Custom Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,500,700%7CRoboto:400,500%7CRoboto:400,500&display=swap" />

        <!-- Perfect Scrollbar -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/perfect-scrollbar.css" />

        <!-- Material Design Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/icons/material-icons.css" />

        <!-- Preloader -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/spinkit.css" />

        <!-- App CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/app.css" />

        <!-- Nestable CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/nestable.css" />

        <!-- Plyr CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/plyr.min.css" />

        <style>
            /* Video Modal */
            #overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display:none;
            }

            .overlay-content {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, 1000%);
                width: 85%;
                z-index: 9999;
                transition: transform 0.4s ease-in-out;
                padding: 6px;
                background-color: #662d91;
                border-radius: 8px;
            }

            #closeBtn {
                border: none;
                background-color: #662d91;
                width: 2.3rem;
                height: 2.3rem;
                border-radius: 50%;
                position: absolute;
                top: -15px;
                color: #ffffff;
                right: -15px;
                font-size: 1.3rem;
                transition: background-color 0.3s;
            }

            #closeBtn:hover {
                background-color: #f31e1e;
            }
            /* End Modal */
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
                                <li class="breadcrumb-item active">Bookmarks</li>
                            </ol>
                            <div class="media align-items-center mb-headings">
                                <div class="media-body">
                                    <h1 class="h2">Bookmarks</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="nestable" id="nestable-handles-primary">
                                        <ul class="nestable-list">
                                            <?php foreach($bookmarks as $video): ?>
                                            <li class="nestable-item nestable-item-handle">
                                                <div class="nestable-content mx-0">
                                                    <div class="media align-items-center">
                                                        <div class="media-left">
                                                            <img src="<?= IMAGEROOT ?>/<?= $video->thumbnail ?>"
                                                                    alt="thumbnail video"
                                                                    width="100"
                                                                    class="rounded">
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="card-title h6 mb-0">
                                                                <a href="instructor-lesson-add.html"><?= $video->nom ?></a>
                                                            </h5>
                                                            <small class="text-muted"><?= $video->duree ?></small>
                                                        </div>
                                                        <div class="media-right">
                                                            <button data-url="<?= $video->url ?>" class="btn btn-white btn-sm watch-video"><i class="material-icons">visibility</i></button>
                                                            <a href="<?= URLROOT ?>/etudiant/formation/<?= $video->id_formation ?>" class="btn btn-white btn-sm watch-video"><i class="material-icons">ondemand_video</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- require sidebar -->
                    <?php require_once APPROOT . "/views/includes/etudiant/sideNavbar.php" ?>
                </div>
            </div>
        </div>

        <!-- Popup Preview Video -->
        <div class="overlay-content">
            <video style="--plyr-color-main: #662d91;" class="object-fit-cover" id="player" playsinline controls></video>
            <button id="closeBtn" class="d-flex align-items-center justify-content-center"><i class="material-icons">clear</i></button>
        </div>
        <div id="overlay" class="hidden"></div>
        <!-- End Popup -->

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

        <!-- <script src="<?= JSROOT ?>/etudiants/index.js"></script> -->
        <script>
            const URLROOT = 'http://localhost/MAHA';
            const player = new Plyr('#player', {captions: {active: true}});
            
            // Open the overlay when the button is clicked
            $(".watch-video").click(function(event) {
                $("#overlay").fadeIn();
                $(".overlay-content").css({ transform: "translate(-50%, -50%)" });
                $("body").css({
                    overflow : 'hidden'
                });

                $('#player').prop('src', `${URLROOT}/public/videos/${$(this).data('url')}`);
                player.play();
            });

            function hideOverlay() {
                $("#overlay").fadeOut();
                $(".overlay-content").css({ transform: "translate(-50%, 1000%)" });
                $("body").css({
                    overflow : 'auto'
                });
                
                player.pause();
            }

            $("#closeBtn, #overlay").click(hideOverlay);
        </script>
    </body>
</html>