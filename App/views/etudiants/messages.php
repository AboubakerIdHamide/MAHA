<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
        <title>Messages | <?= SITENAME ?></title>

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

        <style>
            .me {
                flex-direction: row-reverse;
                gap: 8px;
            }

            .me .message__body {
                border-radius: 10px;
                margin-bottom: 0;
                background-color: #3C2A21;
                color: #F1EFEF;
                border-bottom-right-radius: 0;
            }

            .contact {
                gap: 8px;
            }

            .contact .message__body {
                border-radius: 10px;
                margin-bottom: 0;
                background-color: #39444d;
                color: #F1EFEF;
                border-bottom-left-radius: 0;
            }
        </style>    
    </head>

    <body class="app-messages layout-fluid">

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
                <div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
                    <div class="mdk-drawer-layout__content page">
                        <div data-push data-responsive-width="768px" class="mdk-drawer-layout js-mdk-drawer-layout">
                            <div class="mdk-drawer-layout__content">
                                <div class="app-messages__container d-flex flex-column h-100 pb-4">
                                    <?php if($formateur): ?>
                                    <div class="navbar navbar-light bg-white navbar-expand-sm navbar-shadow z-1">
                                        <div class="container-fluid flex-wrap px-sm-0">
                                            <div class="nav py-2">
                                                <div class="nav-item align-items-center mr-3">
                                                    <div class="mr-3">
                                                        <div class="avatar <?= $formateur->is_active ? 'avatar-online' : 'avatar-offline' ?> avatar-sm">
                                                            <a href="<?= URLROOT ?>/user/<?= $formateur->slug ?>"><img src="<?= IMAGEROOT ?>/<?= $formateur->img ?>"
                                                                alt="formateur avatar"
                                                                class="avatar-img rounded-circle" /></a>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column"
                                                        style="max-width: 200px; font-size: 15px">
                                                        <a href="<?= URLROOT ?>/user/<?= $formateur->slug ?>"><strong class="text-body"><?= $formateur->nomFormateur ?> <?= $formateur->prenom ?></strong></a>
                                                        <span class="text-muted text-ellipsis"><?= $formateur->specialite ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <?php if($formateur->is_active): ?>
                                                    <span class="badge bg-success text-white">Online</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary text-white">Offline</span>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif ?>
                                    <?php if($formateur): ?>
                                    <div class="flex pt-4" style="position: relative;" data-perfect-scrollbar>
                                        <div class="container-fluid page__container">
                                            <div class="jumbotron">
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3">
                                                        <div class="avatar avatar-xl">
                                                        <img src="<?= IMAGEROOT ?>/<?= $formateur->img ?>"
                                                            alt="user"
                                                            class="avatar-img rounded-circle avatar">
                                                        </div>
                                                    </div>
                                                    <div class="flex">
                                                        <h4 class="mb-0"><?= $formateur->nomFormateur ?> <?= $formateur->prenom ?></h4>
                                                        <p class="text-muted mb-0"><?= $formateur->specialite ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="d-flex flex-column list-unstyled" id="messages">
                                                <?php foreach($conversations as $conversation) : ?>
                                                    <?php if($conversation->from === session('user')->get()->id_etudiant): ?>
                                                        <li class="message d-inline-flex me">
                                                            <div class="message__body card">
                                                                <div class="card-body px-2 py-1">
                                                                <div><?= $conversation->message ?></div>
                                                                    <div class="text-right">
                                                                        <small class="text-muted" style="font-size: 10px;"><?= $conversation->sent_at ?></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php else: ?>
                                                        <li class="message d-inline-flex contact my-3">
                                                            <div class="message__body card">
                                                                <div class="card-body px-2 py-1"">
                                                                    <span><?= $conversation->message ?></span>
                                                                    <div>
                                                                        <small class="text-muted"><?= $conversation->sent_at ?></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="container-fluid page__container">
                                        <form action="#" id="message-reply">
                                            <div class="input-group input-group-merge">
                                                <input type="text"
                                                    class="form-control form-control-appended"
                                                    autofocus=""
                                                    required=""
                                                    name="message"
                                                    placeholder="Type message" />
                                                <div class="input-group-append">
                                                    <button style="width: 3rem;" class="btn btn-sm btn-primary" type="submit"><i class="material-icons">send</i></button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="sender" value="etudiant" />
                                            <input type="hidden" name="to" value="<?= $formateur->id_formateur ?>" />
                                        </form>
                                    </div>
                                    <?php endif ?>
                                </div>
                            </div>

                            <div class="mdk-drawer js-mdk-drawer"
                                data-align="end"
                                id="messages-drawer">
                                <div class="mdk-drawer__content top-0">
                                    <div class="sidebar sidebar-right sidebar-light bg-white o-hidden">
                                        <div class="d-flex flex-column h-100">
                                            <div class="d-flex flex-column justify-content-center navbar-height">
                                                <div class="px-3 form-group mb-0">
                                                    <div class="input-group input-group-merge input-group-rounded flex-nowrap">
                                                        <input type="text"
                                                            id="filter-formateur"
                                                            class="form-control form-control-prepended"
                                                            placeholder="Filter formateur" />
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <span class="material-icons">filter_list</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex mt-3"
                                                data-perfect-scrollbar>
                                                <div class="sidebar-heading">Formateurs</div>
                                                <ul class="list-group list-group-fit mb-3">
                                                    <?php foreach($myFormateurs as $formateur) : ?>
                                                    <li title="<?= $formateur->nom ?> <?= $formateur->prenom ?>" class="formateur list-group-item px-4 py-3 <?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/maha/etudiant/messages/'.$formateur->slug ? 'bg-light' : '' ?>">
                                                        <a href="<?= URLROOT ?>/etudiant/messages/<?= $formateur->slug  ?>"
                                                        class="d-flex align-items-center position-relative">
                                                            <span class="avatar avatar-sm <?= $formateur->is_active ? 'avatar-online' : 'avatar-offline' ?> mr-3 flex-shrink-0">
                                                                <img src="<?= IMAGEROOT ?>/<?= $formateur->img ?>"
                                                                    alt="Avatar"
                                                                    class="avatar-img rounded-circle">
                                                            </span>
                                                            <span class="flex d-flex flex-column"
                                                                style="max-width: 175px;">
                                                                <strong class="text-body"><?= $formateur->nom ?> <?= $formateur->prenom ?></strong>
                                                                <span class="text-muted text-ellipsis"><?= $formateur->specialite ?></span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <?php endforeach ?>
                                                </ul>
                                            </div>
                                        </div>
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

        <script> const URLROOT = `<?= URLROOT ?>`; </script>
        <script src="<?= JSROOT ?>/etudiants/messages.js"></script>
    </body>
</html>