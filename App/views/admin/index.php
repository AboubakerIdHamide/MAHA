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
        <div class="row mb-3">
            <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                <label for="date" class="form-label">Choisissiez Periode</label>
                <select id="date" class="form-select">
                    <option value="today" selected>Aujourd'hui</option>
                    <option value="yesterday">Hier</option>
                    <option value="week">Derniere Semaine</option>
                    <option value="month">Dernier Mois</option>
                    <option value="3months">Dernier 3 Mois</option>
                    <option value="year">Derniere Annee</option>
                </select>
            </div>
            <div class="col-12 col-lg-6">
                <div class="d-flex justify-content-between">
                    <div class="start">
                        <label for="debut" class="form-label">Début</label>
                        <input class="form-control" id="debut" type="date" />
                    </div>
                    <div class="end">
                        <label for="fin" class="form-label">Fin</label>
                        <input class="form-control" id="fin" type="date" />
                    </div>
                    <button id="chercher" class="btn btn-primary align-self-end">Rechercher</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
               <div id="chart-1">
                    
                </div>
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