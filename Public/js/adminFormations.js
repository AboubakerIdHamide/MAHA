$(document).ready(function () {
  // ============================= Delete ======================================
  function addToastToBtn(btnClass) {
    const toastTrigger = document.getElementsByClassName(btnClass)[0];
    const toastLiveExample = document.getElementById("liveToast");
    if (toastTrigger) {
      toastTrigger.addEventListener("click", () => {
        const toast = new bootstrap.Toast(toastLiveExample);
        toast.show();
      });
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

  addToastToBtn("apply");
  addToastToBtn("delete-formation");

  const $deleteBtn = $("input.delete");

  // remove formation from the UI
  const removeFormation = (idFormation) => {
    // remove Formation in The UI
    $(".formation-" + idFormation).remove();
    // Ajax Call to remove Formation in The DB.
    $.ajax({
      url: "http://localhost/maha/admin/removeFormation/" + idFormation,
      success: function (response) {
        showFlashMessage(response, "success");
      },
    });

    // close the modal
    $("button.close-modal-delete").click();
  };
  $deleteBtn.click(function () {
    // remove event handler
    $("button#delete-formation").off();
    const $idFormation = Number($(this).attr("id"));
    const $titleFormation = $(this)
      .parent()
      .parent()
      .parent()
      .find(".card-title")
      .text();
    // set name in the modal
    $(".nom-formation-modal").text($titleFormation);
    // set event handler for confirm delete
    $("button#delete-formation").click(function () {
      removeFormation($idFormation);
    });
  });

  // ============================ Modifier ==============================
  const $editBtn = $("input.edit");

  function removeTags(str) {
    if (str === null || str === "") return "";
    else str = str.toString();

    // Regular expression to identify HTML tags in
    // the input string. Replacing the identified
    // HTML tag with a null string.
    return str.replace(/(<([^>]+)>)/gi, "");
  }

  const fillEditModal = (formation) => {
    const formationInfo = [
      formation.find(".title").text().trim(),
      formation.find(".description").text().trim(),
      formation.find(".miniature").attr("src"),
      formation.find(".prix").text().trim(),
      formation.find(".categorie").attr("id"),
      formation.find(".langue").attr("id"),
      formation.find(".niveau").attr("id"),
    ];

    const inputsModal = [
      $("input#title"),
      $("#description"),
      $("#miniature"),
      $("#prix"),
      $("#categorie"),
      $("#langue"),
      $("#niveau"),
    ];

    let i = 0;
    for (let input of inputsModal) {
      if (i === 2) {
        input.attr("src", formationInfo[i]);
        i++;
        continue;
      }
      input.val(formationInfo[i]);
      i++;
    }
  };
  // idFormation and Formation Global
  let idFormation;
  let formation;
  $editBtn.click(function () {
    idFormation = Number($(this).attr("id"));
    formation = $(this).parent().parent().parent();

    fillEditModal(formation);
  });

  // Validation inputs
  function ValidationInputs({ title, description, prix }) {
    const titre = removeTags(title.val());
    const desc = removeTags(description.val());
    const price = prix.val();

    // title
    if (titre.length > 0) {
      if (titre.length < 25 && titre.length >= 5) {
        $(".error-title").text("");
      } else {
        if (titre.length < 5) $(".error-title").text("5 caractères au minimum");
        else $(".error-title").text("25 caractères au maximum");
        return false;
      }
    } else {
      $(".error-title").text("Veuillez remplir ce champ");
      return false;
    }

    // description
    if (desc.length > 0) {
      if (desc.length < 500 && desc.length >= 10) {
        $(".error-desc").text("");
      } else {
        if (desc.length < 10) $(".error-desc").text("10 caractères au minimum");
        else $(".error-desc").text("500 caractères au maximum");
        return false;
      }
    } else {
      $(".error-desc").text("Veuillez remplir ce champ");
      return false;
    }

    // Prix
    if (price.length > 0) {
      if (price.match(/^(?!0\d)\d*(\.\d+)?$/gm)) {
        $(".error-prix").text("");
      } else {
        $(".error-prix").text("Nombre incorrect !!!");
        return false;
      }
    } else {
      $(".error-prix").text("Veuillez remplir ce champ !!!");
      return false;
    }

    return true;
  }

  // Effectue le changement
  const $appliquerBtn = $("button#appliquer");
  $appliquerBtn.click(function (event) {
    const modalInputs = {
      title: $("#title"),
      description: $("#description"),
      prix: $("#prix"),
    };

    if (ValidationInputs(modalInputs)) {
      const formationValues = {
        id_formation: idFormation,
        // idFormation global Variable
        titre: $("input#title").val(),
        description: $("#description").val(),
        prix: $("#prix").val(),
        categorie: $("#categorie").val(),
        langue: $("#langue").val(),
        niveauFormation: $("#niveau").val(),
      };
      // Update UI
      // formation global Variable
      formation.find(".title").text(formationValues.titre);
      formation.find(".description").text(formationValues.description);
      formation.find(".prix").text(formationValues.prix);
      formation
        .find(".categorie")
        .attr("id", formationValues.categorie)
        .text(
          $("#categorie").find(`[value="${formationValues.categorie}"]`).text()
        );
      formation
        .find(".langue")
        .attr("id", formationValues.langue)
        .text($("#langue").find(`[value="${formationValues.langue}"]`).text());
      formation
        .find(".niveau")
        .attr("id", formationValues.niveauFormation)
        .text(
          $("#niveau")
            .find(`[value="${formationValues.niveauFormation}"]`)
            .text()
        );

      // Update Database
      $.ajax({
        url: "http://localhost/maha/admin/editFormation",
        method: "POST",
        data: {
          formation: JSON.stringify(formationValues),
        },
        success: function (response) {
          showFlashMessage(response, "success");
        },
      });

      // close the modal
      $("button.close-modal-edit").click();
    }
  });

  // ========================== Videos ============================
  const getVideoOfFormation = (btnRef, course) => {
    const videos = $.parseJSON(
      $.ajax({
        url: "http://localhost/maha/admin/videos/" + course,
        dataType: "json",
        async: false,
      }).responseText
    );

    return videos;
  };
  // Stop the video when the modal closed
  $("#videosModal").on("hidden.bs.modal", function () {
    $("#videosModal video").attr("src", $("#videosModal video").attr("src"));
  });

  const insertVideosIntoDOM = (videos) => {
    $(".accordion").html("");
    if (typeof videos !== "object") {
      $(".accordion")
        .html(`<div class="alert alert-danger" role="alert">${videos}</div>
      `);
      $("#videosModal").find(".modal-title").html("Videos");
      return null;
    }
    $("#videosModal")
      .find(".modal-title")
      .html(
        "Videos - <span class='text-muted'>" +
          videos[0].nom_formation +
          "</span>"
      );
    for (let video of videos) {
      $(".accordion").html(
        $(".accordion").html() +
          `
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading-${video.id_video}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-${video.id_video}" aria-expanded="false" aria-controls="flush-collapse-${video.id_video}" id="${video.id_video}">
                  ${video.nom_video} <span class="badge bg-secondary ms-2">${video.duree_video}</span>
                </button>
            </h2>
            <div id="flush-collapse-${video.id_video}" class="accordion-collapse collapse" aria-labelledby="flush-heading-${video.id_video}" data-bs-parent="#accordionFlushExample">
            </div>
          </div>
        `
      );
    }

    $("button.accordion-button").click(function () {
      const accordionItem = $(this).parent().parent();
      const accordion = $(this).parent().next();
      const video = videos.filter((v) => v.id_video === $(this).attr("id"))[0];
      // clear all collapse
      $(".accordion-collapse").text("");
      // insert Accordion
      accordion.html(`
      <div class="accordion-body">
        <div>
          <label class="form-label" for="mp4-video" style="font-weight: 600;">Aperçu</label>
          <video class="ratio ratio-16x9 rounded" src="${video.url_video}" controls></video>
        </div>
        <div class="my-3">
          <label for="title" class="form-label" style="font-weight: 600;">Titre</label>
          <input type="text" class="form-control" id="title" value="${video.nom_video}">
          <small class="error-title text-danger"></small>
        </div>
        <div>
          <label for="description" class="form-label" style="font-weight: 600;">Description</label>
          <textarea class="form-control" id="description" rows="3">${video.description_video}</textarea>
          <small class="error-desc text-danger"></small>
        </div>
        <div class="container mt-3">
          <div class="row">
            <div class="col">
              <button id="${video.id_video}" class="btn btn-info w-100 edit-video" type="button">Appliquer Les Modifications</button>
            </div>
            <div class="col">
              <button id="${video.id_video}" class="btn btn-danger w-100 delete-video" type="button">Supprimer</button>
            </div>
          </div>
        </div>
      </div>
      `);
      // get Desc and Title To Compare them before Ajax Call
      const videoTitle = video.nom_video;
      const videoDescription = video.description_video;
      // remove event handler
      $(".delete-video").off();
      $(".edit-video").off();
      const $editVideo = $(".edit-video");
      addToastToBtn("edit-video");
      const $deleteVideo = $(".delete-video");
      addToastToBtn("delete-video");

      $deleteVideo.click(function () {
        // remove from UI
        accordionItem.fadeOut("slow");
        // remove from DataBase
        $.ajax({
          url: "http://localhost/maha/admin/removeVideo/" + $(this).attr("id"),
          success: function (response) {
            showFlashMessage(response, "success");
          },
        });
      });
      $editVideo.click(function () {
        // controll data
        const desc = {
          inputValue: removeTags($("#description").val()),
          label: "desc",
          maxCara: 600,
          regExp: /[]/,
        };

        const title = {
          inputValue: $("#title").val(),
          label: "title",
          maxCara: 50,
          regExp: /^[a-zA-Z0-9_ ]+$/,
        };

        const isInputValid = ({ inputValue, label, maxCara, regExp }) => {
          if (inputValue.length > maxCara) {
            showFlashMessage(`${maxCara} caractères au maximum`, "danger");
            return false;
          }

          if (inputValue.length === 0) {
            showFlashMessage("veuillez remplir ce champ.", "danger");
            return false;
          }

          if (inputValue.length < 6) {
            showFlashMessage("5 caractères au minimum", "danger");
            return false;
          }

          if (label === "title" && !inputValue.match(regExp)) {
            showFlashMessage(
              "Le titre ne doit pas contient des caractères speciaux.",
              "danger"
            );
            return false;
          }

          return true;
        };
        if (
          videoTitle !== title.inputValue ||
          videoDescription !== desc.inputValue
        ) {
          if (videoTitle !== title.inputValue) {
            if (videoDescription !== desc.inputValue) {
              if (isInputValid(title) && isInputValid(desc)) {
                $.ajax({
                  url: "http://localhost/maha/admin/editVideo",
                  method: "POST",
                  data: {
                    id_video: $(this).attr("id"),
                    description: desc.inputValue,
                    titre: title.inputValue,
                  },
                  success: function (response) {
                    showFlashMessage(response, "success");
                  },
                });
              }
            } else {
              if (isInputValid(title)) {
                $.ajax({
                  url: "http://localhost/maha/admin/editVideo",
                  method: "POST",
                  data: {
                    id_video: $(this).attr("id"),
                    titre: title.inputValue,
                  },
                  success: function (response) {
                    showFlashMessage(response, "success");
                  },
                });
              }
            }
          } else {
            if (isInputValid(desc)) {
              $.ajax({
                url: "http://localhost/maha/admin/editVideo",
                method: "POST",
                data: {
                  id_video: $(this).attr("id"),
                  description: desc.inputValue,
                },
                success: function (response) {
                  showFlashMessage(response, "success");
                },
              });
            }
          }
        }
      });
    });
  };
  const $videosBtn = $("button.voir");
  $videosBtn.click(function () {
    const $id = Number($(this).attr("id"));
    const videos = getVideoOfFormation($(this), $id);
    insertVideosIntoDOM(videos);
  });
});
// end ready

// ====================  Update Files (Ressources)  ================
const handleRessourse = (files) => {
  const fileType = event.target.files[0].type;

  if (fileType !== "application/zip") {
    $(".error-ressources").text("error only zip file !!!");
    e.preventDefault();
    return;
  }

  $(".error-ressources").text("");
};
// ====================  Update Miniature  ================
const handleMiniature = (files) => {
  const allowedExt = ["image/jpeg", "image/png", "image/jpg"];
  const fileType = event.target.files[0].type;

  if (!allowedExt.includes(fileType)) {
    $(".error-miniature").text("error only image (jpg, png, jpeg) file !!!");
    e.preventDefault();
    return;
  }

  $(".error-ressources").text("");

  const x = URL.createObjectURL(event.target.files[0]);
  $("#miniature").attr("src", x);
};
