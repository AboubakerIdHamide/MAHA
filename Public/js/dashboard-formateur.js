$(document).ready(function () {
  let courses = [];
  let coursesSelected = [];
  const render = (q = "") => {
    courses = $.parseJSON(
      $.ajax({
        url: "http://localhost/maha/ajax/getMyFormations/" + q,
        dataType: "json",
        async: false,
      }).responseText
    );
    
    const $tbody = $("tbody");
    $tbody.html("");

    let cptLikes = 0,
      cptApprenants = 0;
    for (let course of courses) {
      let tr = `
			<tr>
				<td class="text-center"><input value=${
          course.id_formation
        } type="checkbox" class="form-check-input fs-5 select"></td>
				<td><p class="titre">${course.nom}</p></td>
				<td class="text-center" style="font-weight: 600;">${course.jaimes}</td>
				<td><p class="desc">${course.description}</p></td>
				<td class="text-center" style="font-weight: 600;">${course.apprenants}</td>
				<td class="text-center">${
          course.fichier_attache === null
            ? "Aucun Fichier"
            : `<a href='http://localhost/maha/public/${course.fichier_attache}' class="btn btn-success btn-sm" download><i class="fa-solid fa-download"></i> Telecharger</a>`
        }</td>
				<td class="text-center">${course.date_creation}</td>
				<td class="text-center"><a href="http://localhost/maha/formation/videos/${
          course.id_formation
        }" class="btn btn-warning btn-sm">Leçons</a></td>
				<td class="text-center"><strong>${course.prix} $</strong></td>
			</tr>
			`;
      cptLikes += Number(course.jaimes);
      cptApprenants += Number(course.apprenants);
      $tbody.html($tbody.html() + tr);
    }

    $("#nbr-formations").text(courses.length);
    // set count likes and Apprenants
    $("#nbr-likes").text(cptLikes);
    $("#nbr-apprenants").text(cptApprenants);

    $(".form-check-input").change(function (event) {
      const value = $(this).val();
      if (event.target.checked) {
        coursesSelected.push(value);
        event.target.parentElement.parentElement.style.backgroundColor =
          "#dee2e6";
      } else if (coursesSelected.includes(value)) {
        coursesSelected.splice(coursesSelected.indexOf(value), 1);
        event.target.parentElement.parentElement.style.backgroundColor = "#fff";
      }

      if (coursesSelected.length !== 0) {
        $("button#delete").removeAttr("disabled");
        if (coursesSelected.length === 1)
          $("button#edit").removeAttr("disabled");
        else $("button#edit").attr("disabled", "disabled");
        $("small#count-label").show();

        $("small#count-selected").text(coursesSelected.length);
      } else {
        $("button#delete").attr("disabled", "disabled");
        $("button#edit").attr("disabled", "disabled");
        $("small#count-label").hide();
        $("small#count-selected").text("");
      }
    });
  };
  // render received the data into the DOM
  render();
  const $deleteBtn = $("button#deleteCours");
  $deleteBtn.click(function (event) {
    courses = courses.filter((course) => {
      if (!coursesSelected.includes(course.id_formation)) return course;
    });

    $.ajax({
      url: "http://localhost/maha/ajax/deleteFormation",
      method: "POST",
      data: {
        formations: coursesSelected,
      },
      success: function (response) {
        location.reload();
      },
    });

    // clear selected courses
    coursesSelected = [];

    // apres la suppression
    render();

    $("button.fermer").click();
    $("small#count-selected").text("");
    $("small#count-label").hide();
    $("button#delete").attr("disabled", "disabled");
    $("button#edit").attr("disabled", "disabled");
  });

  // ================================ Modal ==========================

  // Remplir le Modal
  const $editBtn = $("button#edit");
  $editBtn.click(function (event) {
    const $modalTitle = $("input#title");
    const $modalDescription = $("#description");
    const $modalMiniature = $("#miniature");
    const $ressource = $("#ressource");
    const $modalPrix = $("#prix");
    const $modalSpec = $("#categorie");
    const $modalNiveau = $("#niveau");
    const $modalLangue = $("#langue");
    const $modalIdFormation = $("#id");
    const $miniatureUploader = $("#miniature-uploader");
    const $visibility = $("#visibility");

    const currentCours = courses.filter(
      (cours) => cours.id_formation == coursesSelected[0]
    )[0];

    $modalTitle.val(currentCours.nom);
    $modalDescription.val(currentCours.description);
    $modalMiniature.attr(
      "src",
      "http://localhost/maha/public/" + currentCours.image
    );
    $modalPrix.val(currentCours.prix);
    $modalSpec.val(currentCours.id_categorie);
    $modalNiveau.val(currentCours.id_niveau);
    $modalLangue.val(currentCours.id_langue);
    $modalIdFormation.val(currentCours.id_formation);
    $ressource.attr("data-id-formation", currentCours.id_formation);
    $miniatureUploader.attr("data-id-formation", currentCours.id_formation);
    $visibility.html(`
      <option value="public" ${currentCours.etat== 'public' ? 'selected' : ''}>Public</option>
      <option value="private"  ${currentCours.etat== 'private' ? 'selected' : ''}>Privé</option>
    `);
  });

  function removeTags(str) {
    if (str === null || str === "") return "";
    else str = str.toString();

    // Regular expression to identify HTML tags in
    // the input string. Replacing the identified
    // HTML tag with a null string.
    return str.replace(/(<([^>]+)>)/gi, "");
  }

  // Validation inputs
  function ValidationInputs({ title, description, prix }) {
    const cours = courses.filter((cours) => cours.id_formation == coursesSelected[0])[0];
    const titre = removeTags(title.val());
    const desc = removeTags(description.val());
    const price = prix.val();

    // title
    if (titre.length > 0) {
      if (titre.length < 25 && titre.length >= 5) {
        cours.titre = titre;
        $(".error-title").text();
      } else {
        if (titre.length < 5)
          $(".error-title").text("5 caractères au minimum !!!");
        else $(".error-title").text("25 caractères au maximum !!!");
        return false;
      }
    } else {
      $(".error-title").text("Ce champ est obligatioire !!!");
      return false;
    }

    // description
    if (desc.length > 0) {
      if (desc.length < 700 && desc.length >= 10) {
        cours.description = desc;
        $(".error-desc").text("");
      } else {
        if (desc.length < 10)
          $(".error-desc").text("10 caractères au minimum !!!");
        else $(".error-desc").text("700 caractères au maximum !!!");
        return false;
      }
    } else {
      $(".error-desc").text("Ce champ est obligatoire !!!");
      return false;
    }

    // Prix
    if (price.length > 0) {
      if (price.match(/^(?!0\d)\d*(\.\d+)?$/gm)) {
        cours.prix = Number(price);
        $(".error-prix").text("");
      } else {
        $(".error-prix").text("Nombre incorrect !!!");
        return false;
      }
    } else {
      $(".error-prix").text("Ce champs est obligatioire !!!");
      return false;
    }

    return true;
  }

  // Effectue le changement
  const $appliquerBtn = $("button#appliquer");
  $appliquerBtn.click(function (event) {
    const cours = {
      title: $("#title"),
      description: $("#description"),
      prix: $("#prix"),
    };

    if (!ValidationInputs(cours)) event.preventDefault();
  });

  // button chercher
  const $chercheBtn = $("#chercher");
  $chercheBtn.click(function (event) {
    render($("input[name='q']").val());
  });

  $codeFormateurBtn=$("#copy-code-btn");
  $codeFormateurBtn.on('click', ()=>{
    navigator.clipboard.writeText($codeFormateurBtn.attr('data-code-formateur'));
    $codeFormateurBtn.html(`Copié <i class="fa-solid fa-check"></i>`);
    setTimeout(()=>{
      $codeFormateurBtn.html(`Code privé <i class="fa-solid fa-copy"></i>`);
    }, 5000)
  })

});

function addToastToBtn(btnId) {
  const toastTrigger = document.getElementById(btnId);
  const toastLiveExample = document.getElementById("liveToast");
  if (toastTrigger) {
    toastTrigger.addEventListener("click", () => {
      const toast = new bootstrap.Toast(toastLiveExample);
      toast.show();
    });
  }
}
// Add Toast to input hidden
addToastToBtn("verifier");

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

// ====================  Update Files (Ressources)  ================
const handleRessourse = (files) => {
  const fileType = files[0].type;

  if (fileType != "application/x-zip-compressed" && fileType != "application/zip") {
    $(".error-ressources").text("error only zip file !!!");
    event.preventDefault();
    return;
  }
  const formData = new FormData();
  const fileData = files[0];
  formData.append("file", fileData);
  $.ajax({
    url:
      "http://localhost/maha/formation/updateFormation/" +
      event.target.dataset.idFormation,
    type: "POST",
    contentType: false,
    processData: false,
    data: formData,
    success: function (response) {
      showFlashMessage(JSON.parse(response), "success");
      $("#verifier").click();
    },
  });

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

  const formData = new FormData();
  const fileData = files[0];
  formData.append("file", fileData);
  $.ajax({
    url:
      "http://localhost/maha/formation/updateFormation/" +
      event.target.dataset.idFormation,
    type: "POST",
    contentType: false,
    processData: false,
    data: formData,
    success: function (response) {
      showFlashMessage(JSON.parse(response), "success");
      $("#verifier").click();
    },
  });

  $(".error-ressources").text("");

  const x = URL.createObjectURL(event.target.files[0]);
  $("#miniature").attr("src", x);
};
