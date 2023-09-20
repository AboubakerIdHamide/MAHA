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
        <link rel="stylesheet" href="<?= CSSROOT ?>/icons/material-icons.css" />

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/icons/fontawesome.css" />

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
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/plyr.min.css" /> 

        <!-- Custom Style -->
        <style>
            label.sort {
                cursor: pointer;
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
            <?php require_once APPROOT . "/views/includes/formateur/navbar.php" ?>

            <!-- Header Layout Content -->
            <div class="mdk-header-layout__content">
                <div class="mdk-drawer-layout__content page ">

                        <div class="container-fluid page__container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= URLROOT ?>/formateur">Home</a></li>
                                <li class="breadcrumb-item active">Formations</li>
                            </ol>

                            <div class="d-flex flex-column flex-sm-row flex-wrap mb-headings align-items-start align-items-sm-center">
                                <div class="flex mb-2 mb-sm-0">
                                    <h1 class="h2">Manage Courses</h1>
                                </div>
                                <a href="<?= URLROOT ?>/courses/add"
                                   class="btn btn-success">Add course</a>
                            </div>

                            <div class="card card-body border-left-3 border-left-primary navbar-shadow mb-4">
                                <form method="GET" id="filter-form">
                                    <div class="d-flex flex-wrap2 align-items-center mb-headings">
                                        <div class="dropdown">
                                            <a href="javascript:void(0)"
                                               data-toggle="dropdown"
                                               class="btn btn-white"><i class="material-icons mr-sm-2">tune</i> <span class="d-none d-sm-block">Filters</span></a>
                                            <div class="dropdown-menu">
                                                <div class="dropdown-item d-flex flex-column">
                                                    <div class="form-group">
                                                        <label for="custom-select"
                                                               class="form-label">Category</label><br>
                                                        <select name="categorie" id="categories"
                                                                class="form-control custom-select"
                                                                style="width: 200px;">
                                                            <option value="all" selected>All categories</option>
                                                            <?php foreach($categories as $categorie) : ?>
                                                            <option <?= isset($_GET['categorie']) && $_GET['categorie'] === $categorie->nom ? 'selected' : '' ?> value="<?= $categorie->nom ?>"><?= $categorie->nom ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                    <button type="button" id="clearFilters" class="btn btn-link btn-sm">Clear filters</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex search-form ml-3 search-form--light">
                                            <input type="text"
                                                    name="q"
                                                    value="<?= $_GET["q"] ?? '' ?>" 
                                                   class="form-control"
                                                   placeholder="Search courses"
                                                   />
                                            <button class="btn"
                                                    type="submit"
                                                    ><i class="material-icons">search</i></button>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center"
                                         style="white-space: nowrap;">
                                        <small id="display" class="flex text-muted text-uppercase mr-3 mb-2 mb-sm-0"></small>
                                        <div class="w-auto ml-sm-auto table d-flex align-items-center mb-0">
                                            <small class="text-muted text-uppercase mr-3 d-none d-sm-block">Sort by</small>
                                            <label class="mb-0 sort small text-uppercase" for="sort-nom">Course</label>
                                            <input type="radio" value="nom" name="sort" id="sort-nom" class="d-none" />
                                            <label class="mb-0 sort small text-uppercase ml-2" for="sort-sales">Sales</label>
                                            <input type="radio" value="sales" name="sort" id="sort-sales" class="d-none" />
                                            <label class="mb-0 sort small text-uppercase ml-2" for="sort-likes">Likes</label>
                                            <input type="radio" value="likes" name="sort" id="sort-likes" class="d-none" />
                                            <label class="mb-0 sort small text-uppercase ml-2" for="sort-newest">Newest</label>
                                            <input type="radio" value="newest" name="sort" id="sort-newest" class="d-none" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="alert"></div>
                            <div class="row" id="courses">
                                <!-- COURSES -->
                            </div>

                            <!-- Pagination -->
                            <ul class="pagination justify-content-center pagination-sm" id="pagination"></ul>
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

        <!-- Bootstrap -->
        <script src="<?= JSROOT ?>/plugins/bootstrap-4.min.js"></script>

        <!-- App JS -->
        <script src="<?= JSROOT ?>/plugins/app.js"></script>

        <!-- Highlight.js -->
        <script src="<?= JSROOT ?>/plugins/hljs.js"></script>

        <!-- Nestable -->
        <script src="<?= JSROOT ?>/plugins/jquery.nestable.js"></script>
        <script src="<?= JSROOT ?>/plugins/nestable.js"></script>

        <!-- Quill -->
        <script src="<?= JSROOT ?>/plugins/quill.min.js"></script>

        <!-- Jquery Validation -->
        <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>

        <!-- SweetAlert -->
        <script src="<?= JSROOT ?>/plugins/sweetalert.min.js"></script>
        
        <script>const URLROOT = `<?= URLROOT ?>`;</script>
        <script src="<?= JSROOT ?>/formateurs/courses/index.js"></script>
    </body>
</html>