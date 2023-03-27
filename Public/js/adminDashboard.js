$(document).ready(function() {
    const $selectFilter = $("select.etat");

    function getAllRequestsPayments(state="pending") {
        return $.parseJSON($.ajax({
            url: "http://localhost/maha/admin/getAllRequestsPayments/" + state,
            dataType: "json",
            async: false,
        }).responseText);
    }

    function addEventsForAcceptAndDecline() {
        const $accepterBtn = $(".accepter");
        const $refuserBtn = $(".refuser");

        $accepterBtn.click(function() {
            const id_payment = removeRedBadge($(this));
            $(this).parent().html(`<span class="badge bg-success">Accepted !!!</span>`).fadeIn("slow");
            $.ajax({
                url: "http://localhost/maha/admin/setState",
                method: "POST",
                data: {
                    id_payment,
                    etat_request: "accepted",
                },
                success: function(response) {
                    console.log(response);
                },
            });
        });

        $refuserBtn.click(function() {
            const id_payment = removeRedBadge($(this));
            $(this).parent().html(`<span class="badge bg-danger">Declined !!!</span>`);
            $.ajax({
                url: "http://localhost/maha/admin/setState",
                method: "POST",
                data: {
                    id_payment,
                    etat_request: "declined",
                },
                success: function(response) {
                    console.log(response);
                },
            });
        });
    }

    function renderPending(payments) {
        // clear requests from UI
        $("section#requests").html("");
        for (let request of payments) {
            $("section#requests").html($("section#requests").html() + `
          <div class="row p-0 mb-3">
          <div class="col">
            <div class="card position-relative">
                <span class="position-absolute top-0 start-0 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                <div class="card-header">
                    Request #${request.id_payment} · ${request.date_request}
                </div>
                <div class="card-body">
                    <div class="card-text d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <img style="width: 55px;border: 2px solid #0d6efd" class="img-fluid rounded-circle me-2" src="http://localhost/maha/Public/images/default.jpg" alt="formateur avatar" />
                            <div class="d-flex flex-column">
                                <span style="font-weight: 700;"><span style="text-transform: uppercase;">${request.nom_formateur}</span> ${request.prenom_formateur}</span>
                                <span class="d-flex align-items-center gap-1">
                                    <i class="fa-brands fa-paypal"></i>
                                    <span class="badge rounded-pill text-bg-dark">${request.paypalMail}</span>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex flex-column bg-warning p-2 rounded">
                            <span class="text-center mb-1"><strong>${request.request_prix} $</strong></span>
                            <div>
                                <button id="${request.id_payment}" class="btn btn-success btn-sm accepter">Accepter <i class="fa-solid fa-check"></i></button>
                                <button id="${request.id_payment}" class="btn btn-danger btn-sm refuser">Refuser <i class="fa-sharp fa-solid fa-circle-xmark"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      `);
            // set Events
            addEventsForAcceptAndDecline();
        }
    }

    function renderAcceptedAndDeclined(payments, state) {
        // clear requests from UI
        $("section#requests").html("");
        for (let request of payments) {
            $("section#requests").html($("section#requests").html() + `
          <div class="row p-0 mb-3">
          <div class="col">
            <div class="card">
                <div class="card-header">
                    Request #${request.id_payment} · ${request.date_request}
                </div>
                <div class="card-body">
                    <div class="card-text d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <img style="width: 55px;border: 2px solid #0d6efd" class="img-fluid rounded-circle me-2" src="http://localhost/maha/Public/images/default.jpg" alt="formateur avatar" />
                            <div class="d-flex flex-column">
                                <span style="font-weight: 700;"><span style="text-transform: uppercase;">${request.nom_formateur}</span> ${request.prenom_formateur}</span>
                                <span class="d-flex align-items-center gap-1">
                                    <i class="fa-brands fa-paypal"></i>
                                    <span class="badge rounded-pill text-bg-dark">${request.paypalMail}</span>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex flex-column bg-warning p-2 rounded">
                            <span class="text-center mb-1"><strong>${request.request_prix} $</strong></span>
                            <div>
                              <span class="badge bg-${state === "Declined" ? "danger" : "success"}">${state} !!!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      `);
        }
    }

    $selectFilter.change(function(event) {
        const $etat = $(this).val();
        const arrayFilter = ["pending", "accepted", "declined"];
        if (!arrayFilter.includes($etat))
            return;
        const requestPayments = getAllRequestsPayments($etat);
        if (requestPayments.length === 0) {
            $("section#requests").html(`
        <div class="row p-0">
          <div class="col">
              <p class="alert alert-info" role="alert">No ${$etat} requests</p>
          </div>
        </div>
      `);
        } else {
            if ($etat === "pending")
                renderPending(requestPayments);
            else
                renderAcceptedAndDeclined(requestPayments, $etat.charAt(0).toUpperCase() + $etat.slice(1));
        }
    });

    const removeRedBadge = (div)=>{
        const cardWithRedBadge = div.parent().parent().parent().parent().parent().parent();
        cardWithRedBadge.removeClass("position-relative");
        cardWithRedBadge.find(".position-absolute").fadeOut("slow");
        return div.attr("id");
    }
    ;

    // default render into the DOM (First Time)
    renderPending(getAllRequestsPayments());

    const $chercher = $("input#chercher");
    $chercher.on("keypress keyup", function(event) {
        if ($selectFilter.val() === "pending") {
            const filtredRequests = getAllRequestsPayments().filter((req)=>req.nom_formateur.includes($(this).val().toUpperCase()));
            renderPending(filtredRequests);
        } else {
            const filtredRequests = getAllRequestsPayments($selectFilter.val()).filter((req)=>req.nom_formateur.includes($(this).val().toUpperCase()));

            renderAcceptedAndDeclined(filtredRequests, $selectFilter.val());
        }
    });
});
