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

        <!-- Apexchart CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/apexcharts.css" /> 

        <!-- Quil -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/quill.snow.css" /> 

        <!-- Phone Number -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/intlTelInput.min.css" />
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
            <?php require_once APPROOT . "/views/includes/formateur/navbar.php" ?>

            <!-- Header Layout Content -->
            <div class="mdk-header-layout__content">
                <div data-push
                     data-responsive-width="992px"
                     class="mdk-drawer-layout js-mdk-drawer-layout">
                    <div class="mdk-drawer-layout__content page ">
                        <div class="container-fluid page__container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= URLROOT ?>/formateur">Home</a></li>
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
                                           data-toggle="tab">Public Informations</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="#third"
                                           data-toggle="tab">Private Informations</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="#fourth"
                                           data-toggle="tab">Social Informations</a>
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
                                                                <img id="avatar" class="rounded-pill" width="80" src="<?= strpos($formateur->img, 'users') === 0 ? IMAGEROOT.'/'.$formateur->img : $formateur->img ?>" alt="avatar" />
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
                                                               value="<?= $formateur->prenom ?>" />
                                                        </div>
                                                        <div class="col-md-6 mt-3 mt-md-0">
                                                            <input type="text"
                                                               class="form-control"
                                                               name="nom"
                                                               placeholder="Last Name"
                                                               value="<?= $formateur->nom ?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                              <label for="tel"
                                                       class="col-sm-3 col-form-label form-label">Telephone</label>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="input-group">
                                                        <input type="text"
                                                               id="tel"
                                                               class="form-control"
                                                               name="tel"
                                                               placeholder="Enter your phone number"
                                                               value="<?= $formateur->tel ?>"
                                                               />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="paypal-email"
                                                       class="col-sm-3 col-form-label form-label">Paypal Email</label>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="material-icons md-18 text-muted">monetization_on</i>
                                                            </div>
                                                        </div>
                                                        <input type="email"
                                                               id="paypal-email"
                                                               class="form-control"
                                                               name="paypalMail"
                                                               placeholder="Paypal email address"
                                                               value="<?= $formateur->paypalMail ?>"
                                                               />
                                                    </div>
                                                    <small class="form-text text-muted">Please double check your paypal email before you confirm.</small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="code"
                                                       class="col-sm-3 col-form-label form-label">Code</label>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="material-icons md-18 text-muted">vpn_key</i>
                                                            </div>
                                                        </div>
                                                        <input type="text"
                                                           id="code"
                                                           class="form-control"
                                                           readonly
                                                           disabled
                                                           value="<?= $formateur->code ?>"
                                                           name="code"
                                                           />
                                                        <div class="ml-2">
                                                          <button id="btn-copy" type="button" class="btn btn-light"><i class="material-icons">content_copy</i></button>
                                                          <button id="btn-autorenew" type="button" class="btn btn-light"><i class="material-icons">autorenew</i></button>
                                                        </div>
                                                    </div>
                                                    <small class="form-text code-helper text-muted">Give this code to the students you want to join private courses.</small>
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
                                        <form id="edit-public-form" 
                                              class="form-horizontal">
                                            <div id="public-alert"></div>
                                            <div class="form-group row">
                                                <label for="specialite"
                                                       class="col-sm-3 col-form-label form-label">Quel est votre profession?</label>
                                                <div class="col-sm-6 col-md-4">
                                                    <input id="specialite"
                                                           type="text"
                                                           name="speciality"
                                                           class="form-control"
                                                           placeholder="Enter your profession" 
                                                           value="<?= $formateur->specialite ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="categorie"
                                                       class="col-sm-3 col-form-label form-label">Categorie</label>
                                                <div class="col-sm-6 col-md-4">
                                                    <select name="categorie" id="categorie"
                                                            class="custom-control custom-select form-control">
                                                        <?php foreach($categories as $categorie): ?>
                                                        <option <?= $categorie->id_categorie === $formateur->id_categorie ? 'selected' : '' ?> value="<?= $categorie->id_categorie ?>"><?= $categorie->nom ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <h4>Biographie</h4>
                                            <div class="mb-3">
                                                <textarea id="biography" name="biography" class="d-none">
                                                  <?= $formateur->biographie ?>
                                                </textarea>
                                                <div id="editor-container" style="height: 200px">
                                                  <?= $formateur->biographie ?>
                                                </div>
                                            </div>
                                            <h4>Background Image</h4>
                                            <div>
                                              <div>
                                                  <div class="mb-2">
                                                      <img id="background" src="<?= IMAGEROOT ?>/<?= $formateur->background_img ?>" style="height: 200px;object-fit: cover" class="img-fluid rounded" />
                                                  </div>
                                                  <div>
                                                      <div class="custom-file">
                                                          <input type="file"
                                                                name="background" 
                                                                 id="background-formateur"
                                                                 class="custom-file-input">
                                                          <label for="background-formateur"
                                                                 class="custom-file-label">Choose Background</label>
                                                      </div>
                                                  </div>
                                              </div>
                                            </div>
                                            <div class="form-group row mt-3">
                                                <div class="col">
                                                    <button
                                                    id="btn-public"
                                                       class="btn btn-success"> Save changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="third">
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
                                                       value="<?= $formateur->email ?>"
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

                                    <div class="tab-pane" id="fourth">
                                        <div id="social-alert"></div>
                                        <form id="edit-social-form" 
                                              class="form-horizontal">
                                            <div class="form-group"
                                                 role="group"
                                                 >
                                                <div class="form-row">
                                                    <label
                                                           for="linkedin"
                                                           class="col-sm-3 col-form-label form-label"> <i class="fa-brands fa-linkedin"></i> LinkedIn</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <div class="input-group-text">
                                                                https://www.linkedin.com/
                                                              </div>
                                                          </div>
                                                          <input type="text"
                                                               id="linkedin"
                                                               class="form-control"
                                                               placeholder="Profil Name"
                                                               name="linkedin"
                                                               value="<?= $formateur->linkedin_profil ?>" 
                                                               />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"
                                                 role="group"
                                                 >
                                                <div class="form-row">
                                                    <label
                                                           for="facebook"
                                                           class="col-sm-3 col-form-label form-label"><i class="fa-brands fa-facebook"></i> Facebook</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <div class="input-group-text">
                                                                https://www.facebook.com/
                                                              </div>
                                                          </div>
                                                          <input type="text"
                                                               id="facebook"
                                                               class="form-control"
                                                               placeholder="Profil Name"
                                                               name="facebook"
                                                               value="<?= $formateur->facebook_profil ?>"
                                                               />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"
                                                 role="group"
                                                 >
                                                <div class="form-row">
                                                    <label for="twitter"
                                                           class="col-sm-3 col-form-label form-label"><i class="fa-brands fa-twitter"></i> Twitter</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <div class="input-group-text">
                                                                https://www.twitter.com/
                                                              </div>
                                                          </div>
                                                          <input type="text"
                                                               id="twitter"
                                                               class="form-control"
                                                               placeholder="Profil Name"
                                                               name="twitter"
                                                               value="<?= $formateur->twitter_profil ?>"
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
                                                              id="btn-social"
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
                    <?php require_once APPROOT . "/views/includes/formateur/sideNavbar.php" ?>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <!-- jQuery -->
        <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>

        <!-- QuilJS -->
        <script src="<?= JSROOT ?>/plugins/quill.min.js"></script>

        <!-- Bootstrap -->
        <script src="<?= JSROOT ?>/plugins/popper.min.js"></script>

        <!-- Perfect Scrollbar -->
        <script src="<?= JSROOT ?>/plugins/perfect-scrollbar.min.js"></script>

        <!-- MDK -->
        <script src="<?= JSROOT ?>/plugins/dom-factory.js"></script>
        <script src="<?= JSROOT ?>/plugins/material-design-kit.js"></script>

        <!-- Jquery UI -->
        <script src="<?= JSROOT ?>/plugins/jquery-ui.min.js"></script>

        <!-- App JS -->
        <script src="<?= JSROOT ?>/plugins/app.js"></script>

        <!-- Bootstrap -->
        <script src="<?= JSROOT ?>/plugins/bootstrap-4.min.js"></script>

        <!-- Jquery Validator -->
        <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>

        <script src="<?= JSROOT ?>/plugins/intlTelInput.min.js"></script>

        <script src="<?= JSROOT ?>/formateurs/edit-profile.js"></script>
    </body>
</html>