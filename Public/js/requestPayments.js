$(document).ready(function() {
    function addToastToBtn(btnId) {
        const toastTrigger = document.getElementById(btnId);
        const toastLiveExample = document.getElementById("liveToast");
        if (toastTrigger) {
            toastTrigger.addEventListener("click", ()=>{
                const toast = new bootstrap.Toast(toastLiveExample);
                toast.show();
            }
            );
        }
    }

    function showFlashMessage(message, colorClass) {
        const bodyToast = $(".toast-body");
        if (bodyToast.hasClass("bg-success")) {
            bodyToast.removeClass("bg-success");
        } else {
            bodyToast.removeClass("bg-danger");
        }
        bodyToast.addClass("bg-" + colorClass);
        $("span#message").text(message);
    }

    addToastToBtn("request-payment");
    $("#request-payment").click(function() {
        const montant = $("#montant").val();
        const paypalEmail = $("#paypal-email").val();
        if (montant.length === 0) {
            showFlashMessage("veuillez remplir le champ montant.", "danger");
        } else {
            if (montant.match(/^(?!0\d)\d*(\.\d+)?$/gm)) {
                if (Number(montant) >= 10) {
                    const formateurBalance = $.parseJSON($.ajax({
                        url: "http://localhost/maha/ajax/checkMontant",
                        dataType: "json",
                        async: false,
                    }).responseText);

                    if (montant > Number(formateurBalance)) {
                        showFlashMessage("Montant insuffisant.", "danger");
                        return;
                    }
                    
                    $.ajax({
                        url: "http://localhost/maha/formateurs/requestPayment",
                        data: {
                            data: JSON.stringify({
                                montant: Number(montant),
                                paypalEmail,
                            }),
                        },
                        type: "POST",
                        success: function(response) {
                            showFlashMessage(response, "success");
                        },
                    });
                    insertHistoryIntoDOM();
                } else {
                    showFlashMessage("le Montant Minimun 10$", "danger");
                }
            } else {
                showFlashMessage("Format Incorrect, le montant doit contenaire que des chiffres.", "danger");
            }
        }
    });

    function getHistory() {
        const paymentHistory = $.parseJSON($.ajax({
            url: "http://localhost/maha/formateurs/getPaymentsHistory",
            dataType: "json",
            async: false,
        }).responseText);
        if (typeof paymentHistory !== "object")
            return [];
        return paymentHistory;
    }

    function insertHistoryIntoDOM() {
        const paymentHistory = getHistory();
        function getBadgeColor($state) {
            if ($state === "pending") {
                return "warning";
            } else if ($state === "accepted") {
                return "success";
            }
            return "danger";
        }

        function showCloseBtn(state, idRequest) {
            if (state != "pending") {
                return ('<button id="' + idRequest + '" type="button" class="btn-close removeReq" aria-label="Close"></button>');
            }
            return "";
        }

        if (paymentHistory.length !== 0) {
            $(".history").html("");
            for (let request of paymentHistory) {
                $(".history").html($(".history").html() + `
            <div class="row mb-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>${request.date_request}</span>
                            ${showCloseBtn(request.etat_request, request.id_payment)}
                        </div>
                        <div class="d-flex justify-content-between align-items-center card-body">
                            <span class="card-title">Montant <strong class="badge bg-${getBadgeColor(request.etat_request)} text-dark" style="font-size: 14px;">${request.request_prix} $</strong></span>
                            <span class="badge bg-${getBadgeColor(request.etat_request)} text-dark" style="font-size: 14px;">${request.etat_request}</span>
                        </div>
                    </div>
                </div>
            </div>
          `);
            }

            const btnRemoveReq = $(".removeReq");
            if (btnRemoveReq.length !== 0) {
                btnRemoveReq.click(function() {
                    const idReq = $(this).attr("id");
                    $.ajax({
                        url: "http://localhost/maha/formateurs/deleteRequest/" + idReq,
                        success: function(response) {
                            showFlashMessage(response, "success");
                        },
                    });
                    insertHistoryIntoDOM();
                });
            }
        } else {
            $(".history").html(`
            <div class="row mb-3">
                <div class="col">
                    <p class="alert alert-primary" role="alert">
                        There is no payment history
                    </p>
                </div>
            </div>
        `);
        }
    }

    insertHistoryIntoDOM();
});
