var fixed_menu = true;
window.jQuery = window.$ = jQuery;


/*-----------------------------------------------------------------------------------*/
/*	PRELOADER
/*-----------------------------------------------------------------------------------*/
jQuery(window).load(function () {
	//Preloader
	setTimeout("jQuery('#preloader').animate({'opacity' : '0'},300,function(){jQuery('#preloader').hide()})",0);
	setTimeout("jQuery('.preloader_hide, .selector_open').animate({'opacity' : '1'},500)",0);
	setTimeout("jQuery('footer').animate({'opacity' : '1'},500)",0);

});



/*-----------------------------------------------------------------------------------*/
/*	NICESCROLL
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function() {
	jQuery("body").niceScroll({
		cursorcolor:"#333",
		cursorborder:"0px",
		cursorwidth :"8px",
		zindex:"9999"
	});
});





/*-----------------------------------------------------------------------------------*/
/*	MENU
/*-----------------------------------------------------------------------------------*/
function calculateScroll1() {
	var contentTop      =   [];
	var contentBottom   =   [];
	var winTop      =   $(window).scrollTop();
	var rangeTop    =   200;
	var rangeBottom =   500;
	$('.navmenu').find('.scroll_btn a').each(function(){
		contentTop.push( $( $(this).attr('href') ).offset().top );
		contentBottom.push( $( $(this).attr('href') ).offset().top + $( $(this).attr('href') ).height() );
	})
	$.each( contentTop, function(i){
		if ( winTop > contentTop[i] - rangeTop && winTop < contentBottom[i] - rangeBottom ){
			$('.navmenu li.scroll_btn')
			.removeClass('active')
			.eq(i).addClass('active');			
		}
	})
};

jQuery(document).ready(function() {
	//MobileMenu
	if ($(window).width() < 991){
		jQuery('.menu_block .container').prepend('<a href="javascript:void(0)" class="menu_toggler"><span class="fa fa-align-justify"></span></a>');
		jQuery('header .navmenu').hide();
		jQuery('.menu_toggler, .navmenu ul li a').click(function(){
			// Set the effect type
			var effect = 'slide';

			// Set the options for the effect type chosen
			var options = { direction: 'left' };

			// Set the duration (default: 400 milliseconds)
			var duration = 500;

			//jQuery('header .navmenu').slideToggle({direction: "right"}, 300);
			jQuery('header .navmenu').toggle(effect, options, duration);
			var winHgt = $( window ).height();
			var calHgt = winHgt-80;			
			//jQuery('header .navmenu').css('height',calHgt);
			//alert(winHgt);
		});
	}
	
	
		
	// if single_page
	//if (jQuery("#page").hasClass("single_page")) {			
//	}
//	else {
//		$(window).scroll(function(event) {
//			calculateScroll();
//		});
//		$('.navmenu ul li a, .mobile_menu ul li a, .btn_down').click(function() {  
//			$('html, body').animate({scrollTop: $(this.hash).offset().top - 80}, 1000);
//			return false;
//		});
//	};
});


/* Superfish */
jQuery(document).ready(function() {
	if ($(window).width() >= 768){
		$('.navmenu ul').superfish();
	}
});





	


/*-----------------------------------------------------------------------------------*/
/*	FLEXSLIDER
/*-----------------------------------------------------------------------------------*/
jQuery(window).load(function(){
	//Top Slider
	$('.flexslider.top_slider').flexslider({
		animation: "fade",
		controlNav: true,
		directionNav: true,
		animationLoop: true,
		slideshow: false,
		autoplay:true,
		prevText: "",
		nextText: "",
		sync: "#carousel"
	});
	$('#carousel').flexslider({
		animation: "fade",
		controlNav: false,
		animationLoop: false,
		directionNav: false,
		slideshow: false,
		itemWidth: 100,
		itemMargin: 5,
		asNavFor: '.top_slider'
	});
	
	//homeHeight();
	
	
	jQuery('.flexslider.top_slider .flex-direction-nav').addClass('container');
	
	
	//Vision Slider
	$('.flexslider.portfolio_single_slider').flexslider({
		animation: "fade",
		controlNav: true,
		directionNav: true,
		animationLoop: false,
		slideshow: false,
	});
	
	
});
//
//jQuery(window).resize(function(){
//	homeHeight();
//	
//});
//
//jQuery(document).ready(function(){
//	homeHeight();
//	
//});

//function homeHeight(){
//	var wh = jQuery(window).height() - 80;
//	jQuery('.top_slider, .top_slider .slides li').css('height', wh - 120);
//}









/*-----------------------------------------------------------------------------------*/
/*	OWLCAROUSEL
/*-----------------------------------------------------------------------------------*/
$(document).ready(function() {
	
	//WORKS SLIDER
    var owl = $(".owl-demo.projects_slider");

    owl.owlCarousel({
		navigation: true,
		pagination: false,
		items : 5,
		autoplayTimeout:2000,
		loop:true,
		autoplayHoverPause:true,
		autoplay:true,
		itemsDesktop : [1000,4],
		itemsDesktop : [600,3]
	});
	
	var owl = $(".owl-demo.projects_slider1");

    owl.owlCarousel({
		navigation: true,
		pagination: false,
		items : 5,
		autoplayTimeout:2000,
		loop:true,
		autoplayHoverPause:true,
		autoplay:true,
		itemsDesktop : [1000,4],
		itemsDesktop : [600,3]
	});
	
	
	//TEAM SLIDER
    var owl = $(".owl-demo.team_slider");

    owl.owlCarousel({
		navigation: true,
		pagination: false,
		items : 3,
		itemsDesktop : [600,2]
	});
	
	
	
	jQuery('.owl-controls').addClass('container');
	
	
	//TESTIMONIALS SLIDER
    var owl = $(".owl-demo.testim_slider");

    owl.owlCarousel({
		itemsCustom : [
			[0, 1]
        ],
		navigation: false,
		pagination: true,
		items : 1
	});
	
	
	
	jQuery('.owl-controls').addClass('container');
	
	
});








/*-----------------------------------------------------------------------------------*/
/*	IFRAME TRANSPARENT
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function() {
	$("iframe").each(function(){
		var ifr_source = $(this).attr('src');
		var wmode = "wmode=transparent";
		if(ifr_source.indexOf('?') != -1) {
		var getQString = ifr_source.split('?');
		var oldString = getQString[1];
		var newString = getQString[0];
		$(this).attr('src',newString+'?'+wmode+'&'+oldString);
		}
		else $(this).attr('src',ifr_source+'?'+wmode);
	});
});







/*-----------------------------------------------------------------------------------*/
/*	BLOG MIN HEIGHT
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function() {
	blogHeight();
});

jQuery(window).resize(function(){
	blogHeight();
});

function blogHeight(){
	if ($(window).width() > 991){
		var wh = jQuery(window).height() - 80;
		jQuery('#blog').css('min-height', wh);
	}
	
}




$(document).ready(function() {
    $('#list').click(function(event){event.preventDefault();$('#products .item').addClass('list-group-item');});
    $('#grid').click(function(event){event.preventDefault();$('#products .item').removeClass('list-group-item');$('#products .item').addClass('grid-group-item');});
});
