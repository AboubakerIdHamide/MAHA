<?php //print_r2($formations) ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
        <title>Formations | <?= SITENAME ?></title>

        <!-- Custom Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,500,700%7CRoboto:400,500%7CRoboto:400,500&display=swap" />

        <!-- Perfect Scrollbar -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/perfect-scrollbar.css" />

        <!-- Material Design Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/material-icons.css" />

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/fontawesome.css" />

        <!-- Preloader -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/spinkit.css" />

        <!-- App CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/app.css" />

        <!-- Quill Theme -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/quill.css" />

        <!-- Nestable -->
        <link rel="stylesheet"  href="<?= CSSROOT ?>/plugins/nestable.css">

        <!-- SweetAlert -->
        <link rel="stylesheet"  href="<?= CSSROOT ?>/plugins/sweetalert.css">

        <!-- Plyr CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plyr.min.css" /> 

        <!-- Custom Style -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/videos/index.css" />
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
                <div class="mdk-drawer-layout__content page ">

                        <div class="container-fluid page__container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="instructor-dashboard.html">Home</a></li>
                                <li class="breadcrumb-item active">Formations</li>
                            </ol>

                            <div class="d-flex flex-column flex-sm-row flex-wrap mb-headings align-items-start align-items-sm-center">
                                <div class="flex mb-2 mb-sm-0">
                                    <h1 class="h2">Manage Courses</h1>
                                </div>
                                <a href="instructor-quiz-edit.html"
                                   class="btn btn-success">Add course</a>
                            </div>

                            <div class="card card-body border-left-3 border-left-primary navbar-shadow mb-4">
                                <form action="#">
                                    <div class="d-flex flex-wrap2 align-items-center mb-headings">
                                        <div class="dropdown">
                                            <a href="#"
                                               data-toggle="dropdown"
                                               class="btn btn-white"><i class="material-icons mr-sm-2">tune</i> <span class="d-none d-sm-block">Filters</span></a>
                                            <div class="dropdown-menu">
                                                <div class="dropdown-item d-flex flex-column">
                                                    <div class="form-group">
                                                        <label for="custom-select"
                                                               class="form-label">Category</label><br>
                                                        <select id="custom-select"
                                                                class="form-control custom-select"
                                                                style="width: 200px;">
                                                            <option selected>All categories</option>
                                                            <option value="1">Vue.js</option>
                                                            <option value="2">Node.js</option>
                                                            <option value="3">GitHub</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="published01"
                                                               class="form-label">Published</label><br>
                                                        <select id="published01"
                                                                class="form-control custom-select"
                                                                style="width: 200px;">
                                                            <option selected>Published courses</option>
                                                            <option value="1">Draft courses</option>
                                                            <option value="3">All courses</option>
                                                        </select>
                                                    </div>
                                                    <a href="#">Clear filters</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex search-form ml-3 search-form--light">
                                            <input type="text"
                                                   class="form-control"
                                                   placeholder="Search courses"
                                                   id="searchSample02">
                                            <button class="btn"
                                                    type="button"
                                                    role="button"><i class="material-icons">search</i></button>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center"
                                         style="white-space: nowrap;">
                                        <small class="flex text-muted text-uppercase mr-3 mb-2 mb-sm-0">Displaying 4 out of 10 courses</small>
                                        <div class="w-auto ml-sm-auto table d-flex align-items-center mb-0">
                                            <small class="text-muted text-uppercase mr-3 d-none d-sm-block">Sort by</small>
                                            <a href="#"
                                               class="sort desc small text-uppercase">Course</a>
                                            <a href="#"
                                               class="sort small text-uppercase ml-2">Earnings</a>
                                            <a href="#"
                                               class="sort small text-uppercase ml-2">Sales</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="alert alert-light alert-dismissible border-1 border-left-3 border-left-warning"
                                 role="alert">
                                <button type="button"
                                        class="close"
                                        data-dismiss="alert"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="text-black-70">Ohh no! No courses to display. Add some courses.</div>
                            </div>

                            <div class="row">
                                <?php foreach($formations as $formation) : ?>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="d-flex flex-column flex-sm-row">
                                                <a href="<?= URLROOT ?>/courses/<?= $formation->id_formation ?>/videos"
                                                   class="avatar avatar-lg avatar-4by3 mb-3 w-xs-plus-down-100 mr-sm-3">
                                                    <img src="<?= IMAGEROOT ?>/<?= $formation->image ?>"
                                                         alt="Image formation"
                                                         class="avatar-img rounded">
                                                </a>
                                                <div class="flex"
                                                     style="min-width: 200px;">
                                                    <h5 class="card-title text-base m-0"><strong><?= $formation->nomCategorie ?></strong></h5>
                                                    <h4 class="card-title mb-1"><a href="<?= URLROOT ?>/courses/<?= $formation->id_formation ?>/videos"><?= $formation->nomFormation ?></a></h4>
                                                    <p class="text-black-70 text-truncate"><?= $formation->description ?></p>
                                                    <div class="d-flex align-items-end">
                                                        <div class="d-flex flex flex-column mr-3">
                                                            <div class="d-flex align-items-center py-1 border-bottom">
                                                                <small class="text-black-70 mr-2">&dollar; <?= $formation->prix ?></small>
                                                                <small class="text-black-50">34 SALES</small>
                                                            </div>
                                                            <div class="d-flex align-items-center py-1">
                                                                <small class="text-muted mr-2"><?= $formation->nomCategorie ?></small>
                                                                <small class="text-muted"><?= $formation->nomNiveau ?></small>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <a href="#"
                                                               class="btn btn-sm btn-white">Edit</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card__options dropdown right-0 pr-2">
                                            <a href="#"
                                               class="dropdown-toggle text-muted"
                                               data-caret="false"
                                               data-toggle="dropdown">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                   href="#">Edit course</a>
                                                <a class="dropdown-item"
                                                   href="#">Course Insights</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger"
                                                   href="#">Delete course</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach ?>
                            </div>

                            <!-- Pagination -->
                            <ul class="pagination justify-content-center pagination-sm">
                                <li class="page-item disabled">
                                    <a class="page-link"
                                       href="#"
                                       aria-label="Previous">
                                        <span aria-hidden="true"
                                              class="material-icons">chevron_left</span>
                                        <span>Prev</span>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link"
                                       href="#"
                                       aria-label="1">
                                        <span>1</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="#"
                                       aria-label="1">
                                        <span>2</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="#"
                                       aria-label="Next">
                                        <span>Next</span>
                                        <span aria-hidden="true"
                                              class="material-icons">chevron_right</span>
                                    </a>
                                </li>
                            </ul>
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

        <!-- Plyr -->
        <script src="<?= JSROOT ?>/plugins/plyr.min.js"></script>

        <!-- Bootstrap -->
        <script src="<?= JSROOT ?>/plugins/popper.min.js"></script>

        <!-- Perfect Scrollbar -->
        <script src="<?= JSROOT ?>/plugins/perfect-scrollbar.min.js"></script>

        <!-- MDK -->
        <script src="<?= JSROOT ?>/plugins/dom-factory.js"></script>
        <script src="<?= JSROOT ?>/plugins/material-design-kit.js"></script>

        <!-- Jquery UI -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- App JS -->
        <script src="<?= JSROOT ?>/plugins/app.js"></script>

        <!-- Highlight.js -->
        <script src="<?= JSROOT ?>/plugins/hljs.js"></script>

        <!-- Nestable -->
        <script src="<?= JSROOT ?>/plugins/jquery.nestable.js"></script>
        <script src="<?= JSROOT ?>/plugins/nestable.js"></script>

        <!-- Quill -->
        <script src="<?= JSROOT ?>/plugins/quill.min.js"></script>

        <!-- Bootstrap -->
        <script src="<?= JSROOT ?>/plugins/bootstrap-4.min.js"></script>

        <!-- Jquery Validation -->
        <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>

        <!-- SweetAlert -->
        <script src="<?= JSROOT ?>/plugins/sweetalert.min.js"></script>
        
       <!--  <script src="<?= JSROOT ?>/videos/index.js"></script> -->
    </body>
</html>