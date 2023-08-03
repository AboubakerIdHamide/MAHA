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

addToastToBtn("is-send");

// Contact US Form

const contactUsForm = $("#contact-us");

contactUsForm.submit(function (event) {
  event.preventDefault();
  $.ajax({
    url: "http://localhost/maha/user/contactUs",
    type: "POST",
    data: $(this).serialize(),
    success: function (response) {
      $(".toast-body").text(JSON.parse(response));
      $("#is-send").click();
    },
  });
});

const $p_decription_PF = $(".box_grid .description");
if ($p_decription_PF) {
  for (let i = 0; i < $p_decription_PF.length; i++) {
    if ($p_decription_PF[i].textContent.length > 160) {
      const text = $p_decription_PF[i].textContent.slice(0, 80);
      $p_decription_PF[i].textContent = `${text} ...`;
    }
  }
}