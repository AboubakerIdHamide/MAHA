/*========================================== Header Scripts =========================================*/
// Menu Button
// let menuBtn = document.getElementById("menuBtn"),
//   navBar = document.getElementById("navBarUl");

// menuBtn.addEventListener("click", () => {
//   let PhoneMedia = window.matchMedia("(max-width: 768px)");
//   if (PhoneMedia.matches) {
//     menuBtn.classList.toggle("active");
//     navBar.classList.toggle("hide");
//   }
// });

// function hideNavBar() {
//   let notPhoneMedia = window.matchMedia("(min-width: 768px)");
//   if (notPhoneMedia.matches) {
//     if (navBar.classList.contains("hide")) {
//       navBar.classList.remove("hide");
//       if (menuBtn.classList.contains("active")) {
//         menuBtn.classList.remove("active");
//       }
//     }
//   } else {
//     if (!navBar.classList.contains("hide")) {
//       navBar.classList.add("hide");
//       if (menuBtn.classList.contains("active")) {
//         menuBtn.classList.remove("active");
//       }
//     }
//   }
// }

// Loding Bar
// document.onreadystatechange = () => {
//   let lodBar = document.querySelector(".loding-bar");
//   if (document.readyState == "interactive") {
//     lodBar.style.setProperty("width", `50%`);
//   } else if (document.readyState == "complete") {
//     lodBar.style.setProperty("width", `100%`);
//     setTimeout(() => {
//       lodBar.style.display = "none";
//     }, 1000);
//   }
// };

// Drop Menu
// let dropMenuBtn = document.getElementById("dropMenu"),
//   MenuDropped = document.getElementById("droppedMenu");

// dropMenuBtn.addEventListener("click", () => {
//   MenuDropped.classList.toggle("hide");
// });

// MenuDropped.addEventListener("mouseleave", () => {
//   MenuDropped.classList.add("hide");
// });

// function hideDropMenu(el) {
//   el.classList.add("hide");
// }

// Window Event
// window.onresize = () => {
//   hideNavBar();
// };
// window.onload = () => {
//   hideNavBar();
// };
// window.onscroll = () => {
//   hideNavBar();
//   hideDropMenu(MenuDropped);
// };

// to-tp button

// let $toTop = $(".to-top");

// window.addEventListener("scroll", () => {
//   if (window.pageYOffset > 150) $toTop.addClass("active");
//   else $toTop.removeClass("active");
// });

// $toTop.click(function (e) {
//   e.preventDefault();
//   window.scrollTo(0, 0);
// });

// $(".icon-box").click(function () {
//   window.location = $(this).find("a").attr("href");
//   return false;
// });

// function addToastToBtn(btnId) {
//   const toastTrigger = document.getElementById(btnId);
//   const toastLiveExample = document.getElementById("liveToast");
//   if (toastTrigger) {
//     toastTrigger.addEventListener("click", () => {
//       const toast = new bootstrap.Toast(toastLiveExample);
//       toast.show();
//     });
//   }
// }

// function showFlashMessage(message, colorClass) {
//   const bodyToast = $(".toast-body");
//   if (bodyToast.hasClass("bg-success")) {
//     bodyToast.removeClass("bg-success");
//   } else {
//     bodyToast.removeClass("bg-danger");
//   }
//   bodyToast.addClass("bg-" + colorClass);
//   $("span#message").text(message);
// }

// addToastToBtn("is-send");

const $p_decription_PF = $(".box_grid .description");
if($p_decription_PF){
  for (let i = 0; i < $p_decription_PF.length; i++) {
    if ($p_decription_PF[i].textContent.length > 160) {
      const text = $p_decription_PF[i].textContent.slice(0, 80);
      $p_decription_PF[i].textContent = `${text} ...`;
    }
  }
}

// Search Bar
let searchForm = document.querySelectorAll(".searchForm");

if(searchForm){
  for(let i = 0; i < searchForm.length; i++)
    searchForm[i].onsubmit = (e) => {
      e.preventDefault();	
      const el = e.target;
      const inpRech = el.querySelector("input");
      const valRech = inpRech.value;
      searchCoursesSubmit(valRech);
    };
}

function searchCoursesSubmit(val){
  if (!(val.length < 1 && val.length > 200)) {
    window.location.href = `http://localhost/MAHA/pageFormations/rechercheFormations/${val}`;
  }
}
// Search Bar

// Contact US Form

const contactUsForm = $("#contact-us");

if(contactUsForm){
  contactUsForm.submit(function (event) {
    event.preventDefault();
    $.ajax({
      url: "http://localhost/maha//users/contactUs",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        showFlashMessage(response, "success");
        $("#is-send").click();
      },
    });
  });
}