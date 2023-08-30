<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
        <title>Formateur | <?= SITENAME ?></title>

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

        <!-- ApexChart CSS -->
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
                                    <li class="breadcrumb-item"><a href="<?= URLROOT ?>/formateur">Home</a></li>
                                    <li class="breadcrumb-item active">Earnings</li>
                                </ol>
                                <h1 class="h2">Earnings</h1>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex form-inline">
                                            <div class="form-group mr-12pt">
                                                <select id="select-year" class="custom-select">
                                                    <?php for($i = date('Y'); $i >= date('Y') - 5;$i--): ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                    <?php endfor ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="chart-legend m-0 justify-content-start"
                                                     id="earningsChartLegend"></div>
                                            </div>
                                        </div>
                                        <div id="earningChart" class="chart"></div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Total <span class="text-primary" id="total-revenue"></span></h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap m-0">
                                            <thead class="thead-light">
                                                <tr class="text-uppercase small">
                                                    <th>
                                                        Course
                                                    </th>
                                                    <th class="text-center"
                                                        style="width:130px">
                                                        Fees
                                                    </th>
                                                    <th class="text-center"
                                                        style="width:130px">
                                                        Revenue
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody id="sales">
                                                <!-- Sales -->
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

        <!-- Jquery UI -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- App JS -->
        <script src="<?= JSROOT ?>/plugins/app.js"></script>

        <!-- Bootstrap -->
        <script src="<?= JSROOT ?>/plugins/bootstrap-4.min.js"></script>
        
        <script src="<?= JSROOT ?>/plugins/apexcharts.min.js"></script>
        <script src="<?= JSROOT ?>/formateurs/earnings.js"></script>
    </body>
</html>