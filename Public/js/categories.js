$(document).ready(function () {
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

  const $categorie = $("#categorie-form");
  const $sousCategorie = $("#sous-categorie-form");
  const $deleteCategorie = $(".delete");
  const $editCategorie = $(".edit");
  const $showCategorie = $(".show");
  const $acceptEditCategorie = $("#accepter");

  addToastToBtn("ajouter-categorie");
  $categorie.submit(function (event) {
    event.preventDefault();
    $.ajax({
      url: "http://localhost/maha/admin/categories",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        showFlashMessage(response, "success");
      },
    });
  });

  addToastToBtn("ajouter-sous-categorie");
  $sousCategorie.submit(function (event) {
    event.preventDefault();
    $.ajax({
      url: "http://localhost/maha/admin/categories",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        showFlashMessage(response, "success");
      },
    });
  });

  $deleteCategorie.click(function () {
    const categorieID = $(this).attr("id");
    $(this).parent().parent().remove();
    $.ajax({
      url: "http://localhost/maha/admin/categories",
      type: "DELETE",
      data: categorieID,
      success: function (response) {
        console.log(response);
      },
    });
  });

  addToastToBtn("accepter");
  $editCategorie.click(function () {
    $acceptEditCategorie.off();
    const categorieID = $(this).data("idCategorie");

    $(".modal #modifier-cat").val($(this).data("nomCategorie"));
    $acceptEditCategorie.click(function () {
      const NouveauNom = $(".modal #modifier-cat").val();
      $.ajax({
        url: "http://localhost/maha/admin/categories",
        type: "PUT",
        data: JSON.stringify({ categorieID, NouveauNom }),
        success: function (response) {
          $("#fermer").click();
          showFlashMessage(response, "success");
        },
      });
    });
  });

  $showCategorie.click(function () {
    const categorieID = $(this).data("idCategorie");
    $.ajax({
      url: "http://localhost/maha/admin/categories/" + categorieID,
      type: "GET",
      success: function (response) {
        const sousCategories = JSON.parse(response);
        const $modalList = $("#modal-sous-categorie");
        $modalList.html("");
        if (sousCategories.length === 0)
          return $modalList.html(`<div class="alert alert-primary" role="alert">
        Aucune sous categorie
      </div>`);
        for (let sousCat of sousCategories) {
          $modalList.append(
            `<li class="list-group-item d-flex justify-content-between">
              <span>${sousCat.nom}</span>
              <button data-id="${sousCat.id}"  class="btn btn-danger btn-sm delete-sous-cat"><i class="fa-solid fa-trash"></i></button>
            </li>`
          );
        }

        $(".delete-sous-cat").off();
        $(".delete-sous-cat").click(function () {
          $(this).parent().remove();
          $.ajax({
            url: "http://localhost/maha/admin/categories/" + $(this).data("id"),
            type: "DELETE",
            success: function (response) {
              console.log(response);
            },
          });
        });
      },
    });
  });
});
