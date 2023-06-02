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
});
