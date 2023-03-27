<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<div class="container me-5">
    <section class="statistics container mt-4">
        <div class="row">
            <div class="col-6 col-lg">
                <div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
                    <div>
                        <span class="d-block fs-2 nombre">$ <?= $data['balance'] ?></span>
                        <small class="text-white">Balance</small>
                    </div>
                    <i class="fa-solid fa-dollar-sign fs-1"></i>
                </div>

            </div>
            <div class="col-6 col-lg">
                <div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
                    <div>
                        <span class="d-block fs-2 nombre" id="nbr-formations"><?= $data['countFormations'] ?></span>
                        <small class="text-white">Formations</small>
                    </div>
                    <i class="fa-solid fa-person-chalkboard fs-1"></i>
                </div>
            </div>
            <div class="col col-lg mt-3 mt-lg-0">
                <div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
                    <div>
                        <span id="nbr-likes" class="d-block fs-2 nombre"><?= $data['countFormateurs'] ?></span>
                        <small class="text-white">Formateurs</small>
                    </div>
                    <i class="fa-solid fa-chalkboard-user fs-1"></i>
                </div>
            </div>
            <div class="col col-lg mt-3 mt-lg-0">
                <div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
                    <div>
                        <span class="d-block fs-2 nombre " id="nbr-apprenants"><?= $data['countEtudiant'] ?></span>
                        <small class="text-white">Etudiants</small>
                    </div>
                    <i class="fa-solid fa-graduation-cap fs-1"></i>
                </div>
            </div>
        </div>
    </section>
    <section class="container mt-3">
        <input type="text" class="form-control my-3" id="formateur" placeholder="le nom de formateur">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div id="chart-1">
                    <div class="before-search d-flex justify-content-center align-items-center">
                        <span>veuillez rechercher le formateur</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div id="chart-2"></div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="<?php echo URLROOT; ?>/public/jQuery/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo URLROOT; ?>/public/js/dashBoardNav.js"></script>
    <script src="<?php echo URLROOT; ?>/public/js/adminDashboard.js"></script>
    <script src="<?= URLROOT ?>/public/js/chart.js"></script>
    </body>

    </html>