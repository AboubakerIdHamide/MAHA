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

    addToastToBtn("delete-formateur");
    // delete Button Modal
    $(".delete").click(function() {
        const idFormateur = Number($(this).attr("id"));
        const tableRow = $(this).parent().parent();
        const nomFormateur = tableRow.find(".nom-formateur").text().trim();
        const prenomFormateur = tableRow.find(".prenom-formateur").text().trim();
        // Insert Into Modal Delete
        $("#nom-formateur-modal").text(nomFormateur + " " + prenomFormateur);
        // confirm delete formateur
        // remove prev event hander
        $("#delete-formateur").off();
        $("#delete-formateur").click(function() {
            $.ajax({
                url: "http://localhost/maha/admin/removeFormateur/" + idFormateur,
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
        const avatarFormateur = tableRow.find(".avatar-formateur").attr("src");
        const nomFormateur = tableRow.find(".nom-formateur").text().trim();
        const prenomFormateur = tableRow.find(".prenom-formateur").text().trim();
        const emailFormateur = tableRow.find(".email-formateur").text().trim();
        const emailPayFormateur = tableRow.find(".paypal-formateur").text().trim();
        const telephoneFormateur = tableRow.find(".tele-formateur").text().trim();
        const specialiteFormateur = tableRow.find(".specialite-formateur").attr("id");
        const biographieFormateur = tableRow.find(".biographie-formateur").val();

        // fill modal
        $("#avatar-formateur").attr("src", avatarFormateur);
        $("#nom-formateur").val(nomFormateur);
        $("#prenom-formateur").val(prenomFormateur);
        $("#email-formateur").val(emailFormateur);
        $("#email-pay-formateur").val(emailPayFormateur);
        $("#telephone-formateur").val(telephoneFormateur);
        $("#specialite").val(specialiteFormateur);
        $("#biographie-formateur").val(biographieFormateur);
    }

    // ============================= validation ==============================

    function validateNomPrenom() {
        const nomInp = document.getElementById("nom-formateur");
        const prenomInp = document.getElementById("prenom-formateur");

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
        let teleInp = document.getElementById("telephone-formateur")
          , emailRe = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
          , phoneRe = /^((06|07)\d{8})+$/gi
          , emailInp = document.getElementById("email-formateur");

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

    function validateBioPmail() {
        let specInp = document.getElementById("specialite")
          , bioTextarea = document.getElementById("biographie-formateur")
          , emailRe = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
          , pmailInp = document.getElementById("email-pay-formateur");

        if (!pmailInp.value.match(emailRe)) {
            return "L'email de Paypal que vous saisi est invalide";
        }

        if (pmailInp.value == "" || pmailInp.value == null) {
            return "L'é-mail de Paypal est obligatoire";
        }

        if (specInp.value == "aucun" || specInp.value == null) {
            return "Choisissez une spécialité";
        }

        if (bioTextarea.value.length < 130 || bioTextarea.value == null) {
            return "Le résumé doit avoir au moins 130 caractères !";
        }

        if (bioTextarea.value.length > 500) {
            return "La Biography doit comporter au maximum 500 caractères";
        }

        return null;
    }

    // ============================ End Validation ============================
    // insert Modified Data Into the DOOM
    function updateUI(formateur, tableRow) {
        tableRow.find(".nom-formateur").text(formateur.nom_formateur);
        tableRow.find(".prenom-formateur").text(formateur.prenom_formateur);
        tableRow.find(".email-formateur").text(formateur.email_formateur);
        tableRow.find(".paypal-formateur").text(formateur.paypalMail);
        tableRow.find(".tele-formateur").text(formateur.tel_formateur);
        const specialiteNom = $("#specialite").find(`[value="${formateur.specialiteId}"]`).text();
        tableRow.find(".specialite-formateur").text(specialiteNom);
    }

    addToastToBtn("appliquer");
    // Edit Button Modal
    $(".edit").click(function() {
        const idFormateur = Number($(this).attr("id"));
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
                    error = validateBioPmail();
                    if (error !== null) {
                        showFlashMessage(error, "danger");
                    } else {
                        const formateur = {
                            id_formateur: idFormateur,
                            nom_formateur: $("#nom-formateur").val(),
                            prenom_formateur: $("#prenom-formateur").val(),
                            email_formateur: $("#email-formateur").val(),
                            tel_formateur: $("#telephone-formateur").val(),
                            paypalMail: $("#email-pay-formateur").val(),
                            specialiteId: $("#specialite").val(),
                            biography: $("#biographie-formateur").val(),
                        };

                        $.ajax({
                            url: "http://localhost/maha/admin/editFormateur",
                            type: "POST",
                            data: {
                                formateur: JSON.stringify(formateur),
                            },
                            success: function(response) {
                                showFlashMessage(response, "success");
                            },
                        });

                        // update UI
                        updateUI(formateur, tableRow);
                        // Close Modal After Edit
                        $(".close-modal-edit").click();
                    }
                }
            }
        });
    });
});
