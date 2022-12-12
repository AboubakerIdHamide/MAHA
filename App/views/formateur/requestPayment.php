<?php require_once APPROOT . "/views/includes/dashBoardNav.php"; ?>
<div class="container mt-3">
    <h5 class="mb-3">Request Payment</h5>
    <div class="row">
        <div class="col">
            <div class="form-floating mb-3">
                <input value="<?= $_SESSION['user']['paypalMail'] ?>" type="email" class="form-control" id="paypal-email" placeholder="name@example.com" disabled>
                <label for="paypal-email">Paypal email</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="montant" placeholder="Montant">
                    <label for="montant">Montant</label>
                </div>
                <span class="input-group-text">$</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button id="request-payment" class="btn btn-info">Demander le paiement</button>
        </div>
    </div>
</div>
<div class="container mt-3">
    <h5 class="mb-3">Payments History</h5>
    <div class="containter history">

    </div>
</div>


<!-- toast start -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body rounded d-flex justify-content-between">
            <span id="message" class="text-white"></span>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<!-- toast end -->
<?php require_once APPROOT . "/views/includes/footerDashboard.php"; ?>