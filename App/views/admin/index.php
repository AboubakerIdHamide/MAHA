<?php require_once APPROOT . "/views/includes/navbarAdmin.php"; ?>
<div class="container me-5">
    <section class="statistics container mt-4">
        <div class="row">
            <div class="col-6 col-lg">
                <div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
                    <div>
                        <span class="d-block fs-2 nombre">$ <?= $_SESSION['admin']['balance'] ?></span>
                        <small class="text-muted">Balance</small>
                    </div>
                    <i class="fa-solid fa-dollar-sign fs-1"></i>
                </div>

            </div>
            <div class="col-6 col-lg">
                <div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
                    <div>
                        <span class="d-block fs-2 nombre" id="nbr-formations">0</span>
                        <small class="text-muted">Formations</small>
                    </div>
                    <i class="fa-solid fa-person-chalkboard fs-1"></i>
                </div>
            </div>
            <div class="col col-lg mt-3 mt-lg-0">
                <div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
                    <div>
                        <span id="nbr-likes" class="d-block fs-2 nombre">0</span>
                        <small class="text-muted">Formateurs</small>
                    </div>
                    <i class="fa-solid fa-chalkboard-user fs-1"></i>
                </div>
            </div>
            <div class="col col-lg mt-3 mt-lg-0">
                <div class="widgetbox d-flex align-items-center gap-4 p-3 justify-content-between rounded">
                    <div>
                        <span class="d-block fs-2 nombre " id="nbr-apprenants">0</span>
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
                <div class="d-flex gap-3">
                    <input placeholder="Nom Formateur" type="text" class="form-control" name="q">
                    <button id="chercher" class="btn btn-primary" style="white-space: nowrap;">Chercher <i class="fa-sharp fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </div>
        <div class="row p-0">
            <div class="col">
                <div class="card position-relative">
                    <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                    <div class="card-header">
                        Request #1 · 28/10/2020
                    </div>
                    <div class="card-body">
                        <div class="card-text d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <img style="width: 55px;border: 2px solid #0d6efd" class="img-fluid rounded-circle me-2" src="<?= URLROOT . "/Public/images/default.jpg" ?>" alt="formateur avatar" />
                                <div class="d-flex flex-column">
                                    <span style="font-weight: 700;"><span style="text-transform: uppercase;">abdelmoumen</span> Mustafa</span>
                                    <span class="d-flex align-items-center gap-1">
                                        <i class="fa-brands fa-paypal"></i>
                                        <span class="badge rounded-pill text-bg-dark">xavi.2012barca@gmail.com</span>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="text-center mb-1"><strong>100 $</strong></span>
                                <div>
                                    <button class="btn btn-success btn-sm">Accepter</button>
                                    <button class="btn btn-danger btn-sm">Refuser</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
    <?php require_once APPROOT . "/views/includes/footerAdmin.php"; ?>