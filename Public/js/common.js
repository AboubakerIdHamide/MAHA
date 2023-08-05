(function ($) {

	"use strict";
	document.body.style.overflow = "hidden";
	
	$(window).on('load', function () {
		document.body.style.overflow = "auto";
		$('[data-loader="circle-side"]').fadeOut(); // will first fade out the loading animation
		$('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
		$('body').delay(350);
		$('#hero_in h1,#hero_in form').addClass('animated');
		$('.hero_single, #hero_in').addClass('start_bg_zoom');
		$(window).scroll();
	});
	
	// Sticky nav
	$(window).on('scroll', function () {
		if ($(this).scrollTop() > 1) {
			$('.header').addClass("sticky");
		} else {
			$('.header').removeClass("sticky");
		}
	});
	
	// Sticky sidebar
	$('#sidebar').theiaStickySidebar({
		additionalMarginTop: 150
	});

	// sidebar for Course
	$('#sidebar-course').theiaStickySidebar({
		additionalMarginTop: 170
	});
	
	// Mobile Mmenu
	const $menu = $("nav#menu").mmenu({
		"extensions": ["pagedim-black"],
		counters: false,
		keyboardNavigation: {
			enable: true,
			enhance: true
		},
		navbar: {
			title: 'MENU'
		},
		navbars: [{position:'bottom',content: ['<a href="#0">© 2023 Maha</a>']}]}, 
		{
		// configuration
		clone: true,
		classNames: {
			fixedElements: {
				fixed: "menu_2",
				sticky: "sticky"
			}
		}
	});

	const $icon = $("#hamburger");
	const API = $menu.data("mmenu");
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
        
	// Secondary nav scroll
	const $sticky_nav= $('.secondary_nav');
	$sticky_nav.find('a').on('click', function(e) {
		e.preventDefault();
		const target = this.hash;
		const $target = $(target);
		$('html, body').animate({
			'scrollTop': $target.offset().top - 150
		}, 200, 'linear');
	});

	$sticky_nav.find('ul li a').on('click', function () {
		$sticky_nav.find('ul li a.active').removeClass('active');
		$(this).addClass('active');
	});

	// Search overlay
	$(".search-overlay-menu-btn").on("click", function (a) {
		$(".search-overlay-menu").addClass("open"), 
		$('.search-overlay-menu > form > input[type="search"]').focus()}), 
		$(".search-overlay-close").on("click", function (a) {
		$(".search-overlay-menu").removeClass("open")}),
		$(".search-overlay-menu, .search-overlay-menu .search-overlay-close").on("click keyup", function (a) {
		(a.target == this || "search-overlay-close" == a.target.className || 27 == a.keyCode) && $(this).removeClass("open")
	});
	
})(window.jQuery); 