$(function(){
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

  // WoW - animation on scroll
  var wow = new WOW(
    {
   boxClass:     'wow',      // animated element css class (default is wow)
   animateClass: 'animated', // animation css class (default is animated)
   offset:       0,          // distance to the element when triggering the animation (default is 0)
   mobile:       true,       // trigger animations on mobile devices (default is true)
   live:         true,       // act on asynchronously loaded content (default is true)
   callback:     function(box) {
     // the callback is fired every time an animation is started
     // the argument that is passed in is the DOM node being animated
   },
   scrollContainer: null // optional scroll container selector, otherwise use window
    }
  );
  wow.init();

  $('#reccomended').owlCarousel({
   center: true,
   items: 2,
   loop: true,
   margin: 0,
   responsive: {
     0: {
       items: 1
     },
     767: {
       items: 2
     },
     1000: {
       items: 3
     },
     1400: {
       items: 4
     }
   }
  });

  $('#reccomended .item').click(function(){
    console.log($(this).data('url'))
    window.location.href = $(this).data('url');
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
});