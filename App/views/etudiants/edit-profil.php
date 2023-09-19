<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
        <title>Edit profil | <?= SITENAME ?></title>

        <!-- Custom Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,500,700%7CRoboto:400,500%7CRoboto:400,500&display=swap" />

        <!-- Perfect Scrollbar -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/perfect-scrollbar.css" />

        <!-- Material Design Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/icons/material-icons.css" />

        <!-- FontAwesome Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/icons/all.min.css" />

        <!-- Preloader -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/spinkit.css" />

        <!-- App CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/app.css" />

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
                    <div class="mdk-drawer-layout__content page ">
                        <div class="container-fluid page__container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= URLROOT ?>/etudiant">Home</a></li>
                                <li class="breadcrumb-item active">Edit Account</li>
                            </ol>
                            <h1 class="h2">Edit Account</h1>
                            <?php flash("emailChanged") ?>
                            <div class="card">
                                <ul class="nav nav-tabs nav-tabs-card">
                                    <li class="nav-item">
                                        <a class="nav-link active"
                                           href="#first"
                                           data-toggle="tab">Account</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="#second"
                                           data-toggle="tab">Private Informations</a>
                                    </li>
                                </ul>
                                <div class="tab-content card-body">
                                    <div class="tab-pane active" id="first">
                                        <div id="account-alert"></div>
                                        <form id="edit-account-form" 
                                              class="form-horizontal">
                                            <div class="form-group row">
                                                <label for="avatar-field"
                                                       class="col-sm-3 col-form-label form-label">Avatar</label>
                                                <div class="col-sm-9">
                                                    <div class="media align-items-center">
                                                        <div class="media-left">
                                                            <div>
                                                                <img class="rounded-pill avatar" width="80" src="<?= strpos($etudiant->img, 'users') === 0 ? IMAGEROOT.'/'.$etudiant->img : $etudiant->img ?>" alt="avatar" />
                                                            </div>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="custom-file"
                                                                 style="width: auto;">
                                                                <input type="file"
                                                                       id="avatar-field"
                                                                       name="image" 
                                                                       class="custom-file-input">
                                                                <label for="avatar-field"
                                                                       class="custom-file-label">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label
                                                       class="col-sm-3 col-form-label form-label">Full Name</label>
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input id="name"
                                                               type="text"
                                                               class="form-control"
                                                               name="prenom"
                                                               placeholder="First Name"
                                                               value="<?= $etudiant->prenom ?>" />
                                                        </div>
                                                        <div class="col-md-6 mt-3 mt-md-0">
                                                            <input type="text"
                                                               class="form-control"
                                                               name="nom"
                                                               placeholder="Last Name"
                                                               value="<?= $etudiant->nom ?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <div class="col-sm-8 offset-sm-3">
                                                    <div class="media align-items-center">
                                                        <div class="media-left">
                                                            <button
                                                                id="btn-account"
                                                               class="btn btn-success">Save Changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="second">
                                        <div id="emailChange-alert"></div>
                                      <div class="form-group row">
                                        <label for="email"
                                               class="col-sm-3 col-form-label form-label">Email</label>
                                        <div class="col-sm-6 col-md-6">
                                            <form id="change-email">
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="material-icons md-18 text-muted">mail</i>
                                                    </div>
                                                </div>
                                                <input type="email"
                                                       id="email"
                                                       name="email"
                                                       class="form-control"
                                                       placeholder="Email Address"
                                                       value="<?= $etudiant->email ?>"
                                                       />
                                                <button id="send-email" class="btn btn-primary ml-2"><i class="material-icons">send</i></button>
                                              </div>
                                            </form>
                                            <small class="form-text text-muted">Note that if you change your email, you will have to confirm it again.</small>
                                        </div>
                                      </div>
                                      <form id="edit-private-form" 
                                          class="form-horizontal">
                                          <div id="private-alert"></div>
                                        <h4>Change Password</h4>
                                        <div class="form-group" role="group">
                                            <div class="form-row">
                                                <label
                                                       for="cmdp"
                                                       class="col-sm-3 col-form-label form-label">Current password</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <div class="input-group-text">
                                                              <i class="material-icons md-18 text-muted">lock</i>
                                                          </div>
                                                      </div>
                                                      <input type="password"
                                                           id="cmdp"
                                                           class="form-control"
                                                           placeholder="Current password"
                                                           name="cmdp"
                                                           value=""
                                                           />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" role="group">
                                            <div class="form-row">
                                                <label
                                                       for="mdp"
                                                       class="col-sm-3 col-form-label form-label">New password</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <div class="input-group-text">
                                                              <i class="material-icons md-18 text-muted">lock</i>
                                                          </div>
                                                      </div>
                                                      <input type="password"
                                                           id="mdp"
                                                           class="form-control"
                                                           placeholder="New password"
                                                           name="mdp"
                                                           value=""
                                                           />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" role="group">
                                            <div class="form-row">
                                                <label for="vmdp"
                                                       class="col-sm-3 col-form-label form-label">Confirm password</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <div class="input-group-text">
                                                              <i class="material-icons md-18 text-muted">lock</i>
                                                          </div>
                                                      </div>
                                                      <input type="password"
                                                           id="vmdp"
                                                           class="form-control"
                                                           placeholder="Confirm password"
                                                           name="vmdp" 
                                                           value=""
                                                           />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-8 offset-sm-3">
                                                <div class="media align-items-center">
                                                    <div class="media-left">
                                                        <button
                                                          id="btn-private"
                                                           class="btn btn-success">Save Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </form>
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

        <!-- Jquery Validator -->
        <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>

        <script> const URLROOT = `<?= URLROOT ?>`; </script>
        <script src="<?= JSROOT ?>/etudiants/edit-profile.js"></script>
    </body>
</html>