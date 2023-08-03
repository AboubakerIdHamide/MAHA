(function ($) {
  "use strict";

  $(window).on("load", function () {
    $('[data-loader="circle-side"]').fadeOut(); // will first fade out the loading animation
    $("#preloader").delay(350).fadeOut("slow"); // will fade out the white DIV that covers the website.
    $("body").delay(350);
    $("#hero_in h1,#hero_in form").addClass("animated");
    $(".hero_single, #hero_in").addClass("start_bg_zoom");
    $(window).scroll();
  });

  // Sticky nav
  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 1) {
      $(".header").addClass("sticky");
    } else {
      $(".header").removeClass("sticky");
    }
  });

  // Mobile Mmenu
  var $menu = $("nav#menu").mmenu(
    {
      extensions: ["pagedim-black"],
      counters: false,
      keyboardNavigation: {
        enable: true,
        enhance: true,
      },
      navbar: {
        title: "MENU",
      },
      navbars: [
        { position: "bottom", content: ['<a href="#0">© 2023 MAHA</a>'] },
      ],
    },
    {
      // configuration
      clone: true,
      classNames: {
        fixedElements: {
          fixed: "menu_2",
          sticky: "sticky",
        },
      },
    }
  );
  var $icon = $("#hamburger");
  var API = $menu.data("mmenu");
  $icon.on("click", function () {
    API.open();
  });
  API.bind("open:finish", function () {
    setTimeout(function () {
      $icon.addClass("is-active");
    }, 100);
  });
  API.bind("close:finish", function () {
    setTimeout(function () {
      $icon.removeClass("is-active");
    }, 100);
  });

  /* Search overlay */
  $(".search-overlay-menu-btn").on("click", function (a) {
    $(".search-overlay-menu").addClass("open"), 
    $('.search-overlay-menu > form > input[type="search"]').focus()}), 
    $(".search-overlay-close").on("click", function (a) {
    $(".search-overlay-menu").removeClass("open")}),
    $(".search-overlay-menu, .search-overlay-menu .search-overlay-close").on("click keyup", function (a) {
    (a.target == this || "search-overlay-close" == a.target.className || 27 == a.keyCode) && $(this).removeClass("open")
  });

})(window.jQuery);
