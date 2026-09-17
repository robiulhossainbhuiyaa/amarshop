
//alert("CUSTOM JS LOADED");
(function ($) {
	
	"use strict";


	 




	 
	// Mobile Menu Toggle
	$('.hero-slider').owlCarousel({

		items:1,

		loop:true,

		autoplay:true,

		autoplayTimeout:4000,

		autoplayHoverPause:true,

		smartSpeed:1200,

		nav:true,

		dots:true,

		navText:[
			'<i class="fa fa-angle-left"></i>',
			'<i class="fa fa-angle-right"></i>'
		]

	});

	// Mobile Menu Toggle

	$('.mobile-toggle').click(function () {

		$('.header-right').toggleClass('active');

		$(this).find('i').toggleClass('fa-bars fa-times');

	});

	//   Search Dropdown

	$('#searchInput').on('focus', function(){

		$('.search-wrapper').addClass('active');

	});

	$(document).on('click', function(e){

		if(!$(e.target).closest('.search-wrapper').length){

			$('.search-wrapper').removeClass('active');

		}

	});
	//  Mobile Category user-btn
	$('.header-cart').click(function(e){

		if($(window).width()<992){

			e.preventDefault();

			$('.cart-dropdown').toggleClass('active');

		}

	});
	//  Mobile Category user-btn

		$('.user-btn').click(function(e){

		if($(window).width()<992){

			e.preventDefault();

			$('.user-account').toggleClass('active');

		}

	});
	//  Mobile Category

	$('.category-btn').click(function(e){

		if($(window).width()<992){

			e.preventDefault();

			$('.category-area').toggleClass('active');

		}

	});

	$('.mega-menu .has-child > a').click(function(e){

		if($(window).width()<992){

			e.preventDefault();

			$(this).parent().toggleClass('active');

		}

	});
	// /* Step 12 – Premium Modern Footer */
	$(window).scroll(function(){

		if($(this).scrollTop()>300){

			$('#backTop').fadeIn();

		}else{

			$('#backTop').fadeOut();

		}

	});

	$('#backTop').click(function(){

		$('html,body').animate({

			scrollTop:0

		},700);

	});

	// <!-- Step 10 – Customer Testimonials & Reviews -->
	$('.owl-testimonial').owlCarousel({

		loop:true,

		margin:30,

		autoplay:true,

		autoplayTimeout:3500,

		smartSpeed:900,

		dots:true,

		nav:false,

		responsive:{

			0:{items:1},

			768:{items:2},

			1200:{items:3}

		}

	});


	// /* Step 8 – Premium Brand Partners Section */
	$('.owl-brands').owlCarousel({

    loop:true,

    margin:20,

    autoplay:true,

    autoplayTimeout:2500,

    smartSpeed:800,

    dots:false,

    nav:false,

    responsive:{

        0:{items:2},

        576:{items:3},

        768:{items:4},

        992:{items:5},

        1200:{items:6}

    }

});
	// /* Step 7 – Trending Products Section */
	$('.owl-trending').owlCarousel({

		loop:true,

		margin:25,

		nav:true,

		dots:false,

		autoplay:true,

		autoplayTimeout:3000,

		smartSpeed:1000,

		responsive:{

			0:{items:1},

			576:{items:2},

			992:{items:3},

			1200:{items:4}

		}

	});

	// <!-- Step 5 – Premium New Arrival Section -->
	$('.owl-new-arrival').owlCarousel({

		loop:true,

		margin:25,

		nav:true,

		dots:false,

		autoplay:true,

		autoplayTimeout:3500,

		smartSpeed:1000,

		responsive:{

			0:{items:1},

			576:{items:2},

			768:{items:3},

			1200:{items:4}

		}

	});


	// /* ========================================== */
	// /* <!-- Step 3 – Flash Sale Section --> */
	const endDate = new Date().getTime() + (5 * 24 * 60 * 60 * 1000);

	setInterval(function(){

		const now = new Date().getTime();

		const distance = endDate - now;

		const days = Math.floor(distance / (1000*60*60*24));

		const hours = Math.floor((distance % (1000*60*60*24)) / (1000*60*60));

		const minutes = Math.floor((distance % (1000*60*60)) / (1000*60));

		const seconds = Math.floor((distance % (1000*60)) / 1000);

		document.getElementById("days").innerHTML = days;
		document.getElementById("hours").innerHTML = hours;
		document.getElementById("minutes").innerHTML = minutes;
		document.getElementById("seconds").innerHTML = seconds;

	},1000);


	$('.owl-men-item').owlCarousel({
		items:5,
		loop:true,
		margin:30,
		nav:true,
		dots:true,

		autoplay:true,
		autoplayTimeout:3000,
		autoplayHoverPause:true,
		smartSpeed:1000,
		//console.log("Autoplay:", autoplay);
		responsive:{
			0:{items:1},
			600:{items:2},
			1000:{items:3}
		}
	});

	setTimeout(function () {
		$('.owl-men-item').trigger('play.owl.autoplay');
	}, 500);
	 

	$('.owl-women-item').owlCarousel({
		items:5,
		loop:true,
		dots: true,
		nav: true,
		margin:30,
		  responsive:{
			  0:{
				  items:1
			  },
			  600:{
				  items:2
			  },
			  1000:{
				  items:3
			  }
		 }
	 })

	$('.owl-kid-item').owlCarousel({
		items:5,
		loop:true,
		dots: true,
		nav: true,
		margin:30,
		  responsive:{
			  0:{
				  items:1
			  },
			  600:{
				  items:2
			  },
			  1000:{
				  items:3
			  }
		 }
	 })

	$(window).scroll(function() {
	  var scroll = $(window).scrollTop();
	  var box = $('#top').height();
	  var header = $('header').height();

	  if (scroll >= box - header) {
	    $("header").addClass("background-header");
	  } else {
	    $("header").removeClass("background-header");
	  }
	});
	

	// Window Resize Mobile Menu Fix
	mobileNav();


	// Scroll animation init
	window.sr = new scrollReveal();
	

	// Menu Dropdown Toggle
	if($('.menu-trigger').length){
		$(".menu-trigger").on('click', function() {	
			$(this).toggleClass('active');
			$('.header-area .nav').slideToggle(200);
		});
	}


	// Menu elevator animation
	$('.scroll-to-section a[href*=\\#]:not([href=\\#])').on('click', function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				var width = $(window).width();
				if(width < 991) {
					$('.menu-trigger').removeClass('active');
					$('.header-area .nav').slideUp(200);	
				}				
				$('html,body').animate({
					scrollTop: (target.offset().top) - 80
				}, 700);
				return false;
			}
		}
	});

	$(document).ready(function () {
	    $(document).on("scroll", onScroll);
	    
	    //smoothscroll
	    $('.scroll-to-section a[href^="#"]').on('click', function (e) {
	        e.preventDefault();
	        $(document).off("scroll");
	        
	        $('.scroll-to-section a').each(function () {
	            $(this).removeClass('active');
	        })
	        $(this).addClass('active');
	      
	        var target = this.hash,
	        menu = target;
	       	var target = $(this.hash);
	        $('html, body').stop().animate({
	            scrollTop: (target.offset().top) - 79
	        }, 500, 'swing', function () {
	            window.location.hash = target;
	            $(document).on("scroll", onScroll);
	        });
	    });
	});

	function onScroll(event){
	    var scrollPos = $(document).scrollTop();
	    $('.nav a').each(function () {
	        var currLink = $(this);
	        var refElement = $(currLink.attr("href"));
	        if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
	            $('.nav ul li a').removeClass("active");
	            currLink.addClass("active");
	        }
	        else{
	            currLink.removeClass("active");
	        }
	    });
	}


	// Page loading animation
	$(window).on('load', function() {
		if($('.cover').length){
			$('.cover').parallax({
				imageSrc: $('.cover').data('image'),
				zIndex: '1'
			});
		}

		$("#preloader").animate({
			'opacity': '0'
		}, 600, function(){
			setTimeout(function(){
				$("#preloader").css("visibility", "hidden").fadeOut();
			}, 300);
		});
	});


	// Window Resize Mobile Menu Fix
	$(window).on('resize', function() {
		mobileNav();
	});


	// Window Resize Mobile Menu Fix
	function mobileNav() {
		var width = $(window).width();
		$('.submenu').on('click', function() {
			if(width < 767) {
				$('.submenu ul').removeClass('active');
				$(this).find('ul').toggleClass('active');
			}
		});
	}


})(window.jQuery);