<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Dashboard Owner</title>
<meta name="description" content="bankEauction" />
<meta name="keywords" content="bankEauction" />

<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bace.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin-style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/nav.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/nav-select.css">

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]>
<script type="text/javascript" src="/js/respond.js"></script>
<![endif]-->

<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>js/common.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
	/*------- tab pannel --------------- */
	$(".tab_content3").hide();
	$(".tab_content3:first").show(); 

	$("ul.tabs3 li").click(function() {
		$("ul.tabs3 li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content3").hide();
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab).fadeIn(); 
	});
	
	$(".tab_content7").hide();
	$(".tab_content7:first").show(); 

	$("ul.tabs7 li").click(function() {
		$("ul.tabs7 li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content7").hide();
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab).fadeIn(); 
	});
	
	/*------- tab pannel --------------- */
	$(".tab_content6").hide();
	$(".tab_content6:first").show(); 

	$("ul.tabs6 li").click(function() {
		$("ul.tabs6 li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content6").hide();
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab).fadeIn(); 
	});
	
	/*------- header menu --------------- */
	jQuery(document).ready(function() {
    jQuery('.toggle-nav').click(function(e) {
        jQuery(this).toggleClass('active');
        jQuery('.menu ul').toggleClass('active');
 
        e.preventDefault();
    	});
	});
	
	
	});
</script>
<script src="<?php echo base_url(); ?>js/accordion.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/accordion.css">

<script src="<?php echo base_url(); ?>jquery.min.js"></script>
	<script>
	 // DOM ready
	 $(function() {
	   
      // Create the dropdown base
      $("<select />").appendTo("nav");
      
      // Create default option "Go to..."
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Quick Links"
      }).appendTo("nav select");
      
      // Populate dropdown with menu items
      $("nav a").each(function() {
       var el = $(this);
       $("<option />", {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo("nav select");
      });
      
	   // To make dropdown actually work
	   // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
      $("nav select").change(function() {
        window.location = $(this).find("option:selected").val();
      });
	 
	 });
	</script>

</head>

<body class="db-owner">
<header>
  <section class="top_header">
    <div class="wrapper-full">
      <div class="tp_link">
        <p>Welcome! Larissa Ila</p>
        <a id="login" href="#"><img src="<?php echo base_url(); ?>images/icon-setting.png"></a>
     <!--   <div class="login_dropdown"> <a href="#">My Account</a> <a href="#">Logout</a> </div> -->
      </div>
    </div>
  </section>
  <section class="header">
    <div class="wrapper-full">
      
      
      <div class="logo ftleft"><img src="<?php echo base_url(); ?>images/logo2.png"></div>
      <div class="menu">
        <ul class="active">
          <li><a href="<?=base_url();?>faq.html" target="_blank">FAQs</a></li>
          <li><a href="#">Help Desk</a></li>
          <li><a href="#">Contact Us</a></li>
		  <li><a href="<?=base_url();?>contactus.html" target="_blank">Contact Us</a></li>
          <li><a href="#">About Us</a></li>
        </ul>
        <a class="toggle-nav" href="#">☰</a> </div>
    </div>
  </section>
</header>
