<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<div class="container me-5">
    <section class="statistics container mt-4">
        <div class="row">
            <div class="col-6 col-lg">
                <div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
                    <div>
                        <span class="d-block fs-2 nombre">$ <?= $data['balance'] ?></span>
                        <small class="text-muted">Balance</small>
                    </div>
                    <i class="fa-solid fa-dollar-sign fs-1"></i>
                </div>

            </div>
            <div class="col-6 col-lg">
                <div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
                    <div>
                        <span class="d-block fs-2 nombre" id="nbr-formations"><?= $data['countFormations'] ?></span>
                        <small class="text-muted">Formations</small>
                    </div>
                    <i class="fa-solid fa-person-chalkboard fs-1"></i>
                </div>
            </div>
            <div class="col col-lg mt-3 mt-lg-0">
                <div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
                    <div>
                        <span id="nbr-likes" class="d-block fs-2 nombre"><?= $data['countFormateurs'] ?></span>
                        <small class="text-muted">Formateurs</small>
                    </div>
                    <i class="fa-solid fa-chalkboard-user fs-1"></i>
                </div>
            </div>
            <div class="col col-lg mt-3 mt-lg-0">
                <div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
                    <div>
                        <span class="d-block fs-2 nombre " id="nbr-apprenants"><?= $data['countEtudiant'] ?></span>
                        <small class="text-muted">Etudiants</small>
                    </div>
                    <i class="fa-solid fa-graduation-cap fs-1"></i>
                </div>
            </div>
        </div>
    </section>
    <main class="container ps-5 pe-5 me-lg-5 p-md-0 mt-3 bg-color p-lg-3 rounded">
        <div class="row mb-3 pt-5 pt-lg-0">
            <div class="col col-lg mt-3 mt-lg-0">
                <input placeholder="Nom Formateur" type="text" class="form-control" id="chercher">
            </div>
            <div class="col-2">
                <select class="form-select etat">
                    <option value="pending" selected>Pending</option>
                    <option value="accepted">Accepted</option>
                    <option value="declined">Declined</option>
                </select>
            </div>
        </div>
        <hr />
        <section id="requests"></section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="<?php echo URLROOT; ?>/public/jQuery/jquery-3.6.0.min.js"></script>
    <script src="<?php echo URLROOT; ?>/public/js/dashBoardNav.js"></script>
    <script src="<?php echo URLROOT; ?>/public/js/adminDashboard.js"></script>
    </body>

    </html>