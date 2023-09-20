<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
        <title>Transactions | <?= SITENAME ?></title>

        <!-- Custom Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,500,700%7CRoboto:400,500%7CRoboto:400,500&display=swap" />

        <!-- Perfect Scrollbar -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/perfect-scrollbar.css" />

        <!-- Material Design Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/icons/material-icons.css" />

        <!-- Font-Awesome Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/icons/all.min.css" />

        <!-- Preloader -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/spinkit.css" />

        <!-- App CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/app.css" />

        <!-- Flatpickr -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/flatpickr-dark.css" />
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
                                <ol class="breadcrumb d-print-none">
                                    <li class="breadcrumb-item"><a href="<?= URLROOT ?>/formateur">Home</a></li>
                                    <li class="breadcrumb-item active">Transactions</li>
                                </ol>
                                <h1 class="h2">Transactions</h1>
                                <div class="card">
                                    <div class="card-header form-inline">
                                        <div class="form-group ml-auto">
                                            <label for="transaction-days"
                                                   class="form-label mr-3">Date</label>
                                            <input id="transaction-days"
                                                   type="text"
                                                   class="form-control"
                                                   placeholder="Select dates"
                                                   data-toggle="flatpickr"
                                                   data-flatpickr-mode="range"
                                                   data-flatpickr-alt-input="false"
                                                   />
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-nowrap m-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>
                                                        <a class="sort-transactions" data-sort="course" style="color: inherit;" href="javascript:void(0)">Course <i class="fa fa-sort mr-1"></i></a>
                                                    </th>
                                                    <th>
                                                        <a class="sort-transactions" data-sort="amount" style="color: inherit;" href="javascript:void(0)">Amount <i class="fa fa-sort mr-1"></i></a>
                                                    </th>
                                                    <th>
                                                        <a class="sort-transactions" data-sort="" style="color: inherit;" href="javascript:void(0)">Date <i class="fa fa-sort mr-1"></i></a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="transactions">
                                                <!-- Transations -->
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <!-- Pagination -->
                                <ul class="pagination justify-content-center pagination-sm" id="pagination">
                                    
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
        
        <!-- Flatpickr -->
        <script src="<?= JSROOT ?>/plugins/flatpickr.min.js"></script>

        <script>const URLROOT = `<?= URLROOT ?>`;</script>
        <script src="<?= JSROOT ?>/formateurs/transactions.js"></script>
    </body>
</html>