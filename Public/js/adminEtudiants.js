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

    addToastToBtn("delete-etudiant");
    // delete Button Modal
    $(".delete").click(function() {
        const idEtudiant = $(this).attr("id");
        const tableRow = $(this).parent().parent();
        const nomEtudiant = tableRow.find(".nom-etudiant").text().trim();
        const prenomEtudiant = tableRow.find(".prenom-etudiant").text().trim();
        // Insert Into Modal Delete
        $("#nom-etudiant-modal").text(nomEtudiant + " " + prenomEtudiant);
        // confirm delete Etudiant
        // remove prev event hander
        $("#delete-etudiant").off();
        $("#delete-etudiant").click(function() {
            $.ajax({
                url: "http://localhost/maha/admin/removeEtudiant/" + idEtudiant,
                success: function(response) {
                    showFlashMessage(response, "success");
                },
            });
            // remove From UI
            tableRow.remove();
            // Close Modal After Delete
            $(".close-modal-delete").click();
        });
    });

    // fill edit Modal
    function fillEditModal(tableRow) {
        const avatarEtudiant = tableRow.find(".avatar-etudiant").attr("src");
        const nomEtudiant = tableRow.find(".nom-etudiant").text().trim();
        const prenomEtudiant = tableRow.find(".prenom-etudiant").text().trim();
        const emailEtudiant = tableRow.find(".email-etudiant").text().trim();
        const telephoneEtudiant = tableRow.find(".tele-etudiant").text().trim();

        // fill modal
        $("#avatar-etudiant").attr("src", avatarEtudiant);
        $("#nom-etudiant").val(nomEtudiant);
        $("#prenom-etudiant").val(prenomEtudiant);
        $("#email-etudiant").val(emailEtudiant);
        $("#telephone-etudiant").val(telephoneEtudiant);
    }

    // ============================= validation ==============================

    function validateNomPrenom() {
        const nomInp = document.getElementById("nom-etudiant");
        const prenomInp = document.getElementById("prenom-etudiant");

        if (nomInp.value == "" || nomInp.value.length < 3 || nomInp.value == null) {
            return "Le nom doit comporter au moins 3 caractères";
        }

        if (prenomInp.value == "" || prenomInp.value.length < 3 || prenomInp.value == null) {
            return "Le prenom doit comporter au moins 3 caractères";
        }

        if (nomInp.value.length > 30) {
            return "Le nom doit comporter au maximum 30 caractères";
        }

        if (prenomInp.value.length > 30) {
            return "Le prenom doit comporter au maximum 30 caractères";
        }

        return null;
    }

    function validateEmailTele() {
        let teleInp = document.getElementById("telephone-etudiant")
          , emailRe = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
          , phoneRe = /^((06|07)\d{8})+$/gi
          , emailInp = document.getElementById("email-etudiant");

        if (!emailInp.value.match(emailRe)) {
            return "L'email que vous saisi est invalide";
        }
        if (!teleInp.value.match(phoneRe) || teleInp.value.length != 10) {
            return "Le numéro de telephone que vous saisi est invalide";
        }

        if (emailInp.value == "" || emailInp.value == null) {
            return "L'é-mail est obligatoire";
        }

        if (teleInp.value == "" || teleInp.value == null) {
            return "Le numéro de telephone est obligatoire";
        }

        return null;
    }

    // ============================ End Validation ============================
    // insert Modified Data Into the DOOM
    function updateUI(etudiant, tableRow) {
        tableRow.find(".nom-etudiant").text(etudiant.nom_etudiant);
        tableRow.find(".prenom-etudiant").text(etudiant.prenom_etudiant);
        tableRow.find(".email-etudiant").text(etudiant.email_etudiant);
        tableRow.find(".tele-etudiant").text(etudiant.tel_etudiant);
    }

    addToastToBtn("appliquer");
    // Edit Button Modal
    $(".edit").click(function() {
        const idEtudiant = $(this).attr("id");
        const tableRow = $(this).parent().parent();
        fillEditModal(tableRow);
        // remove Event Handler
        $("#appliquer").off();
        $("#appliquer").click(function() {
            // Validate Data
            let error = validateNomPrenom();
            if (error !== null) {
                showFlashMessage(error, "danger");
            } else {
                error = validateEmailTele();
                if (error !== null) {
                    showFlashMessage(error, "danger");
                } else {
                    const etudiant = {
                        id_etudiant: idEtudiant,
                        nom_etudiant: $("#nom-etudiant").val(),
                        prenom_etudiant: $("#prenom-etudiant").val(),
                        email_etudiant: $("#email-etudiant").val(),
                        tel_etudiant: $("#telephone-etudiant").val(),
                    };

                    $.ajax({
                        url: "http://localhost/maha/admin/editEtudiant",
                        type: "POST",
                        data: {
                            etudiant: JSON.stringify(etudiant),
                        },
                        success: function(response) {
                            showFlashMessage(response, "success");
                        },
                    });

                    // update UI
                    updateUI(etudiant, tableRow);
                    // Close Modal After Edit
                    $(".close-modal-edit").click();
                }
            }
        });
    });

    function insertInscriptionIntoModal(formations) {
        // clear modal body
        $("#showModal").find(".modal-body").text("");
        for (let formation of formations) {
            $("#showModal").find(".modal-body").html($("#showModal").find(".modal-body").html() + `
        <div class="card mb-3">
            <div class="card-header">
                <span class='h6'>${formation.nom_formation}</span>
                <span class='text-muted'> - ${formation.date_inscription}</span>
            </div>
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex gap-1 align-items-center" style="font-weight: 500;">
                    <img style="width: 60px;" class="img-fluid rounded-circle avatar-formateur" src="${formation.img_formateur}" alt="formateur avatar">
                    <div class="d-flex flex-column">
                        <span>${formation.nom_formateur}</span>
                        <span>${formation.prenom_formateur}</span>
                    </div>
                </div>
                <div>
                  <button id="${formation.id_inscription}" data-prenom-etudiant="${formation.prenom_etudiant}" data-nom-etudiant="${formation.nom_etudiant}" data-nom-formation="${formation.nom_formation}" type="button" class="btn btn-danger deleteInscription" data-bs-toggle="modal" data-bs-target="#deleteModal">supprimer inscription</button>
                  <a href="http://localhost/maha/pageFormations/coursDetails/${formation.id_formation}" class="btn btn-dark">Voir Formation</a>
                </div> 
            </div>
        </div>
        `);
        }
    }

    //   show button Modal
    $(".show").click(function() {
        const idEtudiant = $(this).attr("id");
        const formations = $.parseJSON($.ajax({
            url: "http://localhost/maha/admin/getFormationsOfStudent/" + idEtudiant,
            dataType: "json",
            async: false,
        }).responseText);

        const tableRow = $(this).parent().parent();
        let nbrInscriptions = Number(tableRow.find(".nbr-inscriptions").text().trim());

        insertInscriptionIntoModal(formations);
        $(".deleteInscription").click(function() {
            const nomFormation = $(this).data("nomFormation");
            const nomEtudiant = $(this).data("nomEtudiant");
            const prenomEtudiant = $(this).data("prenomEtudiant");
            const idInscription = Number($(this).attr("id"));
            $("#nom-etudiant-modal").html(`<div>
          <span class="text-dark">L'inscription de l'étudiant</span> ${nomEtudiant} ${prenomEtudiant} <span class="text-dark">dans la formation</span> ${nomFormation}
        </div>`);

            // confirm delete Etudiant
            // remove prev event hander
            $("#delete-etudiant").off();
            $("#delete-etudiant").click(function() {
                $.ajax({
                    url: "http://localhost/maha/admin/removeInscription/" + idInscription,
                    success: function(response) {
                        // showFlashMessage(response, "success");
                        console.log(response);
                    },
                });
                // remove From UI
                nbrInscriptions--;
                if (nbrInscriptions === 0) {
                    tableRow.find(".show").remove();
                }
                tableRow.find(".nbr-inscriptions").text(nbrInscriptions);

                // Close Modal After Delete
                $(".close-modal-delete").click();
            });
        });
    });
});
