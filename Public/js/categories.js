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
});
