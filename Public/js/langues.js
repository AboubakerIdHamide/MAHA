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

  const $deleteLangue = $(".delete");
  const $formLangue = $("#langue-form");

  addToastToBtn("ajouter-langue");
  $formLangue.submit(function (event) {
    event.preventDefault();

    $.ajax({
      url: "http://localhost/maha/admin/langues",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        showFlashMessage(JSON.parse(response), "success");
        $("#langue").val("");
      },
    });
  });

  $deleteLangue.click(function () {
    const rowLangue = $(this).parent();
    $.ajax({
      url: "http://localhost/maha/admin/langues/" + $(this).data("idLangue"),
      type: "DELETE",
      success: function (response) {
        rowLangue.remove();
      },
    });
  });
});
