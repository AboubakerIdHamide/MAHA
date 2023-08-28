<?php //print_r2($formations) ?>
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

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/icons/fontawesome.css" />

        <!-- Preloader -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/spinkit.css" />

        <!-- App CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/app.css" />

        <!-- Plyr CSS -->
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
                <div class="mdk-drawer-layout__content page ">
                    <div class="mdk-drawer-layout__content page ">
                        <div class="container-fluid page__container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="instructor-dashboard.html">Home</a></li>
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
                                            <a href="instructor-earnings.html"
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
                                            <a href="instructor-statement.html"
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

                                                    <tr>
                                                        <td>
                                                            <div class="media align-items-center">
                                                                <a href="instructor-course-edit.html"
                                                                   class="avatar avatar-4by3 avatar-sm mr-3">
                                                                    <img src="assets/images/vuejs.png"
                                                                         alt="course"
                                                                         class="avatar-img rounded">
                                                                </a>
                                                                <div class="media-body">
                                                                    <a class="text-body js-lists-values-course"
                                                                       href="instructor-course-edit.html"><strong>Angular Routing In-Depth</strong></a><br>
                                                                    <small class="text-muted mr-1">
                                                                        Invoice
                                                                        <a href="instructor-invoice.html"
                                                                           style="color: inherit;"
                                                                           class="js-lists-values-document">#8734</a> -
                                                                        &dollar;<span class="js-lists-values-amount">89</span> USD
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <small class="text-muted text-uppercase js-lists-values-date">12 Nov 2018</small>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="media align-items-center">
                                                                <a href="instructor-course-edit.html"
                                                                   class="avatar avatar-4by3 avatar-sm mr-3">
                                                                    <img src="assets/images/vuejs.png"
                                                                         alt="course"
                                                                         class="avatar-img rounded">
                                                                </a>
                                                                <div class="media-body">
                                                                    <a class="text-body js-lists-values-course"
                                                                       href="instructor-course-edit.html"><strong>Angular Unit Testing</strong></a><br>
                                                                    <small class="text-muted mr-1">
                                                                        Invoice
                                                                        <a href="instructor-invoice.html"
                                                                           style="color: inherit;"
                                                                           class="js-lists-values-document">#8735</a> -
                                                                        &dollar;<span class="js-lists-values-amount">89</span> USD
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <small class="text-muted text-uppercase js-lists-values-date">13 Nov 2018</small>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="media align-items-center">
                                                                <a href="instructor-course-edit.html"
                                                                   class="avatar avatar-4by3 avatar-sm mr-3">
                                                                    <img src="assets/images/github.png"
                                                                         alt="course"
                                                                         class="avatar-img rounded">
                                                                </a>
                                                                <div class="media-body">
                                                                    <a class="text-body js-lists-values-course"
                                                                       href="instructor-course-edit.html"><strong>Introduction to TypeScript</strong></a><br>
                                                                    <small class="text-muted mr-1">
                                                                        Invoice
                                                                        <a href="instructor-invoice.html"
                                                                           style="color: inherit;"
                                                                           class="js-lists-values-document">#8736</a> -
                                                                        &dollar;<span class="js-lists-values-amount">89</span> USD
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <small class="text-muted text-uppercase js-lists-values-date">14 Nov 2018</small>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="media align-items-center">
                                                                <a href="instructor-course-edit.html"
                                                                   class="avatar avatar-4by3 avatar-sm mr-3">
                                                                    <img src="assets/images/gulp.png"
                                                                         alt="course"
                                                                         class="avatar-img rounded">
                                                                </a>
                                                                <div class="media-body">
                                                                    <a class="text-body js-lists-values-course"
                                                                       href="instructor-course-edit.html"><strong>Learn Angular Fundamentals</strong></a><br>
                                                                    <small class="text-muted mr-1">
                                                                        Invoice
                                                                        <a href="instructor-invoice.html"
                                                                           style="color: inherit;"
                                                                           class="js-lists-values-document">#8737</a> -
                                                                        &dollar;<span class="js-lists-values-amount">89</span> USD
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <small class="text-muted text-uppercase js-lists-values-date">15 Nov 2018</small>
                                                        </td>
                                                    </tr>

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
                                               href="instructor-earnings.html">Earnings</a>
                                        </div>
                                        <ul class="list-group list-group-fit mb-0">
                                            <li class="list-group-item">
                                                <div class="media align-items-center">
                                                    <div class="media-body">
                                                        <a href="instructor-course-edit.html"
                                                           class="text-body"><strong>Basics of HTML</strong></a>
                                                    </div>
                                                    <div class="media-right">
                                                        <div class="text-center">
                                                            <span class="badge badge-pill badge-primary">15</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="media align-items-center">
                                                    <div class="media-body">
                                                        <a href="instructor-course-edit.html"
                                                           class="text-body"><strong>Angular in Steps</strong></a>
                                                    </div>
                                                    <div class="media-right">
                                                        <div class="text-center">
                                                            <span class="badge badge-pill badge-success">50</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="media align-items-center">
                                                    <div class="media-body">
                                                        <a href="instructor-course-edit.html"
                                                           class="text-body"><strong>Bootstrap Foundations</strong></a>
                                                    </div>
                                                    <div class="media-right">
                                                        <div class="text-center">
                                                            <span class="badge badge-pill badge-warning">14</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="media align-items-center">
                                                    <div class="media-body">
                                                        <a href="instructor-course-edit.html"
                                                           class="text-body"><strong>GitHub Basics</strong></a>
                                                    </div>
                                                    <div class="media-right">
                                                        <div class="text-center">
                                                            <span class="badge badge-pill  badge-danger ">14</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
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
                                                        <img src="assets/images/people/110/guy-9.jpg"
                                                             alt="Guy"
                                                             class="avatar-img rounded-circle">
                                                    </a>
                                                </div>
                                                <div class="media-body d-flex flex-column">
                                                    <div class="d-flex align-items-center">
                                                        <a href="instructor-profile.html"
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
                                                        <img src="assets/images/people/110/guy-6.jpg"
                                                             alt="Guy"
                                                             class="avatar-img rounded-circle">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <div class="d-flex align-items-center">
                                                        <a href="instructor-profile.html"
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

        <script>
            // const options = {
            //     // Rounded Bar
            //     barRoundness: 1.2
            // };

            // const data = {
            //     labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            //     datasets: [{
            //         label: "Sales",
            //         data: [25, 20, 30, 22, 17, 10, 18, 26, 28, 26, 20, 32],
            //         barPercentage: 0.5,
            //         barThickness: 20
            //     }]
            // };
              const options = {
                  series: [{
                  data: [400, 430, 448, 470, 540, 580, 690]
                }],
                  chart: {
                    toolbar: {
                      show: false
                    },
                  type: 'bar',
                  height: 350
                },
                plotOptions: {
                  bar: {
                    borderRadius: 4,
                    horizontal: true,
                  }
                },
                dataLabels: {
                  enabled: false
                },
                xaxis: {
                  categories: ["18/08", "19/08", "20/08", "21/08", "22/08", "23/08", "24/08"],
                }
                };
            const chart = new ApexCharts(document.querySelector("#salesChart"), options);
            chart.render();
        </script>
    </body>
</html>