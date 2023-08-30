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

        <!-- Apexchart CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/apexcharts.css" /> 

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
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                            <h1 class="h2">Dashboard</h1>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center">
                                            <div class="flex">
                                                <h4 class="card-title">Earnings</h4>
                                                <p class="card-subtitle">Last 7 Days</p>
                                            </div>
                                            <a href="<?= URLROOT ?>/formateur/earnings"
                                               class="btn btn-sm btn-primary"><i class="material-icons">trending_up</i></a>
                                        </div>
                                        <div class="card-body py-0">
                                            <div id="salesChart" class="chart">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center">
                                            <div class="flex">
                                                <h4 class="card-title">Transactions</h4>
                                                <p class="card-subtitle">Latest Transactions</p>
                                            </div>
                                            <a href="<?= URLROOT ?>/formateur/transactions"
                                               class="btn btn-sm btn-primary"><i class="material-icons">receipt</i></a>
                                        </div>
                                        <div data-toggle="lists"
                                             data-lists-values='[
                                                "js-lists-values-course", 
                                                "js-lists-values-document",
                                                "js-lists-values-amount",
                                                "js-lists-values-date"
                                              ]'
                                             data-lists-sort-by="js-lists-values-date"
                                             data-lists-sort-desc="true"
                                             class="table-responsive">
                                            <table class="table table-nowrap m-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th colspan="2">
                                                            <a href="javascript:void(0)"
                                                               class="sort"
                                                               data-sort="js-lists-values-course">Course</a>
                                                            <a href="javascript:void(0)"
                                                               class="sort"
                                                               data-sort="js-lists-values-document">Document</a>
                                                            <a href="javascript:void(0)"
                                                               class="sort"
                                                               data-sort="js-lists-values-amount">Amount</a>
                                                            <a href="javascript:void(0)"
                                                               class="sort"
                                                               data-sort="js-lists-values-date">Date</a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list">
                                                    <?php foreach($latestTransactions as $transaction) : ?>
                                                    <tr>
                                                        <td>
                                                            <div class="media align-items-center">
                                                                <a href="<?= URLROOT ?>/courses/edit/<?= $transaction->id_formation ?>"
                                                                   class="avatar avatar-4by3 avatar-sm mr-3">
                                                                    <img src="<?= IMAGEROOT ?>/<?= $transaction->image ?>"
                                                                         alt="course"
                                                                         class="avatar-img rounded">
                                                                </a>
                                                                <div class="media-body">
                                                                    <a class="text-body js-lists-values-course"
                                                                       href="<?= URLROOT ?>/courses/edit/<?= $transaction->id_formation ?>"><strong class="d-block text-truncate" style="width: 220px"><?= $transaction->nom ?></strong></a>
                                                                    <small class="text-muted mr-1">
                                                                        Invoice
                                                                        <span
                                                                           class="js-lists-values-document">#<?= $transaction->id_inscription ?></span> -
                                                                        &dollar;<span class="js-lists-values-amount"><?= $transaction->prix ?></span> USD
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <small class="text-muted text-uppercase js-lists-values-date"><?= $transaction->date_inscription ?></small>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center">
                                            <div class="flex">
                                                <h4 class="card-title">Sales today</h4>
                                                <p class="card-subtitle">by course</p>
                                            </div>
                                            <a class="btn btn-sm btn-primary"
                                               href="<?= URLROOT ?>/formateur/earnings">Earnings</a>
                                        </div>
                                        <ul class="list-group list-group-fit mb-0">
                                            <?php if(count($salesToday) === 0) : ?>
                                                <div class="alert alert-info mb-0 rounded-0 d-flex align-items-center"><i class="material-icons mr-2">info</i> <span>Nothing sold today.</span></div>
                                            <?php endif ?>
                                            <?php foreach($salesToday as $sale): ?>
                                            <li class="list-group-item">
                                                <div class="media align-items-center">
                                                    <div class="media-body">
                                                        <a href="<?= URLROOT ?>/courses/edit/<?= $sale->id_formation ?>"
                                                           class="text-body"><strong><?= $sale->nom ?></strong></a>
                                                    </div>
                                                    <div class="media-right">
                                                        <div class="text-center">
                                                            <span class="badge badge-pill badge-primary"><?= $sale->numberSales ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center">
                                            <div class="flex">
                                                <h4 class="card-title">Comments</h4>
                                                <p class="card-subtitle">Latest comments</p>
                                            </div>
                                            <div class="text-right"
                                                 style="min-width: 80px;">
                                                <a href="#"
                                                   class="btn btn-outline-primary btn-sm"><i class="material-icons">keyboard_arrow_left</i></a>
                                                <a href="#"
                                                   class="btn btn-outline-primary btn-sm"><i class="material-icons">keyboard_arrow_right</i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#"
                                                       class="avatar avatar-sm">
                                                        <img src="<?= IMAGEROOT ?>/users/default.png"
                                                             alt="Guy"
                                                             class="avatar-img rounded-circle">
                                                    </a>
                                                </div>
                                                <div class="media-body d-flex flex-column">
                                                    <div class="d-flex align-items-center">
                                                        <a href="#"
                                                           class="text-body"><strong>Laza Bogdan</strong></a>
                                                        <small class="ml-auto text-muted">27 min ago</small><br>
                                                    </div>
                                                    <span class="text-muted">on <a href="instructor-course-edit.html"
                                                           class="text-black-50"
                                                           style="text-decoration: underline;">Data Visualization With Chart.js</a></span>
                                                    <p class="mt-1 mb-0 text-black-70">How can I load Charts on a page?</p>
                                                </div>
                                            </div>
                                            <div class="media ml-sm-32pt mt-3 border rounded p-3 bg-light">
                                                <div class="media-left">
                                                    <a href="#"
                                                       class="avatar avatar-sm">
                                                        <img src="<?= IMAGEROOT ?>/users/default.png"
                                                             alt="Guy"
                                                             class="avatar-img rounded-circle">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <div class="d-flex align-items-center">
                                                        <a href="#"
                                                           class="text-body"><strong>FrontendMatter</strong></a>
                                                        <small class="ml-auto text-muted">just now</small>
                                                    </div>
                                                    <p class="mt-1 mb-0 text-black-70">Hi Bogdan,<br> Thank you for purchasing our course! <br><br>Please have a look at the charts library documentation <a href="#">here</a> and follow the instructions.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <form action="#"
                                                  id="message-reply">
                                                <div class="input-group input-group-merge">
                                                    <input type="text"
                                                           class="form-control form-control-appended"
                                                           required=""
                                                           placeholder="Quick Reply">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text pr-2">
                                                            <button class="btn btn-flush"
                                                                    type="button"><i class="material-icons">tag_faces</i></button>
                                                        </div>
                                                        <div class="input-group-text pl-0">
                                                            <div class="custom-file custom-file-naked d-flex"
                                                                 style="width: 24px; overflow: hidden;">
                                                                <input type="file"
                                                                       class="custom-file-input"
                                                                       id="customFile">
                                                                <label class="custom-file-label"
                                                                       style="color: inherit;"
                                                                       for="customFile">
                                                                    <i class="material-icons">attach_file</i>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="input-group-text pl-0">
                                                            <button class="btn btn-flush"
                                                                    type="button"><i class="material-icons">send</i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
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

        <script src="<?= JSROOT ?>/plugins/list.min.js"></script>
        <script src="<?= JSROOT ?>/plugins/list.js"></script>

        <!-- Bootstrap -->
        <script src="<?= JSROOT ?>/plugins/bootstrap-4.min.js"></script>
        
        <script src="<?= JSROOT ?>/plugins/apexcharts.min.js"></script>
        <script>
            const data = JSON.parse(`<?= $inscriptions ?>`);
        </script>
        <script src="<?= JSROOT ?>/formateurs/index.js"></script>
    </body>
</html>