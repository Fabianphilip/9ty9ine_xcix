(function ($) {
 "use strict";

/*----------------------------
 jQuery MeanMenu
------------------------------ */
// jQuery('nav#dropdown').meanmenu();	
jQuery('#dropdown').meanmenu({
	meanScreenWidth: "991",
});
	
/*----------------------------
 wow js active
------------------------------ */
 new WOW().init();

 /*---------------------
 mixItUp
--------------------- */  
  $('.recent-work-content').mixItUp();
  $("li:first-child.filter").addClass("active");

/*---------------------
fancybox
--------------------- */	
	$('.fancybox').fancybox();

/*----------------------------
     counter js active
------------------------------ */
$('.counter').counterUp({
    delay: 10,
    time: 2000
});
 
/*----------------------------
 Click btn search & cart on header 
------------------------------ */
$(".icon-search").on('click', function(){
	$(this).removeAttr('href');
	$('.search-form').toggleClass('active');
	$('.user-menu').removeClass('active');
	$('.mini-cart').removeClass('active');
});
$(".close-icon").on('click', function(){
	$(this).removeAttr('href');
	$('.search-form').removeClass('active');
});

$(".user-icon").on('click', function(){
	$(this).removeAttr('href');
	$('.user-menu').toggleClass('active');
	$('.mini-cart').removeClass('active');
});

$(".icon-cart").on('click', function(){
	$(this).removeAttr('href');
	$('.mini-cart').toggleClass('active');
	$('.user-menu').removeClass('active');
});

/*---------------------
 tooltip
--------------------- */
$('[data-bs-toggle="tooltip"]').tooltip({
	animated: 'fade',
	placement: 'top',
	container: 'body'
}); 

/*---------------------
	 Category menu
--------------------- */
	$('#cate-toggle li.has-sub>a').on('click', function(){
		$(this).removeAttr('href');
		var element = $(this).parent('li');
		if (element.hasClass('open')) {
			element.removeClass('open');
			element.find('li').removeClass('open');
			element.find('ul').slideUp();
		}
		else {
			element.addClass('open');
			element.children('ul').slideDown();
			element.siblings('li').children('ul').slideUp();
			element.siblings('li').removeClass('open');
			element.siblings('li').find('li').removeClass('open');
			element.siblings('li').find('ul').slideUp();
		}
	});
	$('#cate-toggle>ul>li.has-sub>a').append('<span class="holder"></span>');
/*---------------------
 Price Filter
--------------------- */
	var min_price = parseFloat('0');
	var max_price = parseFloat('90');
	var current_min_price = parseFloat($('#price-from').val());
	var current_max_price = parseFloat($('#price-to').val());
	$('#slider-price').slider({
	    range   : true,
	    min     : min_price,
	    max     : max_price,
	    values  : [ current_min_price, current_max_price ],
	    slide   : function (event, ui) {
	        $('#price-from').val(ui.values[0]);
	        $('#price-to').val(ui.values[1]);
	        current_min_price = ui.values[0];
	        current_max_price = ui.values[1];
	    },
	});

 /*---------------------
 top menu stick
--------------------- */

	$(window).scroll(function () {
	//STICK MENU
	  if ($(this).scrollTop() > 10) {
	    $('#sticker').addClass("stick");
	  } 
	  else {
	   	$('#sticker').removeClass("stick");
	  }
	  //TOP BER
	  if ($(this).scrollTop() > 50) {
	    $('.hide-show').addClass("disnone");
	  } 
	  else {
	   	$('.hide-show').removeClass("disnone");
	  };

	 });

	/*-------------------------------------------
    elevateZoom
    -------------------------------------------- */ 
    $("#zoom1").elevateZoom({
        gallery:'gallery_01',
        responsive : true, 
        cursor: 'pointer',
        zoomType: "inner", 
        galleryActiveClass: "active", 
        imageCrossfade: true
    });
    /*-------------------------------------------
    bxSlider
    -------------------------------------------- */ 
    $('.bxslider').bxSlider({
        slideWidth: 100,
        slideMargin:20,
        minSlides: 2,
        maxSlides: 3,
        pager: false,
        speed: 500,
        pause: 3000,
        adaptiveHeight: false
    });


  /*---------------------
	 Input Number Incrementer
	--------------------- */
	  //$(".numbers-row").append('<div class="inc button">+</div><div class="dec button">-</div>');
	  $(".button").on("click", function() {
		var $button = $(this);
		var oldValue = $button.parent().find("input").val();
		if ($button.text() == "+") {
		  var newVal = parseFloat(oldValue) + 1;
		} else {
		   // Don't allow decrementing below zero
		  if (oldValue > 0) {
			var newVal = parseFloat(oldValue) - 1;
			} else {
			newVal = 0;
		  }
		  }
		$button.parent().find("input").val(newVal);

	  });
 

/*----------------------------
 product-carosul
------------------------------ */  
  $(".product-carosul").owlCarousel({
      autoPlay: false, 
	  smartSpeed:2000,
	  dots:false,
      items : 4,
	  margin: 30,
	  /* transitionStyle : "fade", */    /* [This code for animation ] */
	  nav:true,	  
	  navText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
	  responsive:{
        0:{
            items:1
        },
        576:{
            items:2
        },
        768:{
            items: 3
        },
        992:{
            items:4
        },
        1200:{
            items:4
        }
    },
  });

/*----------------------------
 product-carosul
------------------------------ */  
  $(".product-carosul-2").owlCarousel({
	autoPlay: false, 
	smartSpeed:2000,
	dots:false,
	items : 4,
	margin: 30,
	/* transitionStyle : "fade", */    /* [This code for animation ] */
	nav:true,	  
	navText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
	responsive:{
	  0:{
		  items:1
	  },
	  576:{
		  items:2
	  },
	  768:{
		  items: 3
	  }
  },
});

/*----------------------------
 product-carosul
------------------------------ */  
  $(".testomonial-carosul").owlCarousel({
	autoPlay: false, 
	smartSpeed:1000,
	dots: true,
	items : 1,
	/* transitionStyle : "fade", */    /* [This code for animation ] */
	nav:false,
	margin: 30
});
/*----------------------------
 blog-carosul
------------------------------ */  
  $(".blog-carosul").owlCarousel({
	autoPlay: false, 
	smartSpeed:2000,
	dots:false,
	items : 4,
	margin: 30,
	/* transitionStyle : "fade", */    /* [This code for animation ] */
	nav:true,	  
	navText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
	responsive:{
	  0:{
		  items:1
	  },
	  768:{
		  items: 2
	  },
	  992:{
		  items:3
	  },
	  1200:{
		  items:3
	  }
  },
});
/*----------------------------
 blog-carosul
------------------------------ */  
  $(".brand-logo-carosul").owlCarousel({
	autoPlay: false, 
	smartSpeed:2000,
	dots:false,
	margin: 30,
	/* transitionStyle : "fade", */    /* [This code for animation ] */
	nav: false,
	responsive:{
	  0:{
		  items:2
	  },
	  576:{
		  items: 3
	  },
	  768:{
		  items: 4
	  },
	  992:{
		  items:5
	  }
  },
});
/*----------------------------
 popular-category-carosul
------------------------------ */  
  $(".popular-category-carosul").owlCarousel({
	autoPlay: false, 
	smartSpeed:2000,
	dots:false,
	margin: 30,
	/* transitionStyle : "fade", */    /* [This code for animation ] */
	nav: true,
	navText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
	responsive:{
	  0:{
		  items:1
	  },
	  576:{
		  items: 2
	  },
	  768:{
		  items: 2
	  },
	  992:{
		  items:3
	  }
  },
});
/*----------------------------
 popular-category-carosul-2
------------------------------ */  
  $(".popular-category-carosul-2").owlCarousel({
	autoPlay: false, 
	smartSpeed:2000,
	dots:false,
	margin: 30,
	/* transitionStyle : "fade", */    /* [This code for animation ] */
	nav: true,
	navText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
	responsive:{
	  0:{
		  items:1
	  },
	  576:{
		  items: 2
	  },
	  768:{
		  items: 2
	  },
	  992:{
		  items:2
	  }
  },
});

/*----------------------------
Portfolio Carousel
------------------------------ */  
$(".portfolio-related-item-carosul").owlCarousel({
	autoPlay: false, 
	smartSpeed:2000,
	dots:false,
	margin: 30,
	/* transitionStyle : "fade", */    /* [This code for animation ] */
	nav:true,	  
	navText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
	responsive:{
	  0:{
		  items:1
	  },
	  768:{
		  items: 2
	  },
	  992:{
		  items: 3
	  }
  },
});
  
/* --------------------------------------------------------
   payment-accordion
* -------------------------------------------------------*/ 
var checked = $('.payment_radio input:checked');
if (checked) {
	$(checked).siblings('.payment-option-form').slideDown(500);
}
$('.payment_radio input').on('change', function () {
	$('.payment-option-form').slideUp(500);
	$(this).siblings('.payment-option-form').slideToggle(500);
});


/*-------------------------
  showlogin toggle function
--------------------------*/
   $( '#showlogin' ).on('click', function() {
        $( '#checkout-login' ).slideToggle(900);
     }); 
  
/*-------------------------
  showcoupon toggle function
--------------------------*/
   $( '#showcoupon' ).on('click', function() {
        $( '#checkout_coupon' ).slideToggle(900);
     });
   
/*-------------------------
  Create an account toggle function
--------------------------*/
   $( '#cbox' ).on('click', function() {
        $( '#cbox_info' ).slideToggle(900);
     });
   
/*-------------------------
  Create an account toggle function
--------------------------*/
   $( '#ship-box' ).on('click', function() {
        $( '#ship-box-info' ).slideToggle(1000);
     });


	   
/*--------------------------
 scrollUp
---------------------------- */	
	$.scrollUp({
        scrollText: '<i class="fa fa-angle-up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    }); 	   
 
})(jQuery); 