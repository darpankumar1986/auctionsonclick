<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>bankEauction</title>
<meta name="description" content="bankEauction" />
<meta name="keywords" content="bankEauction" />

<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet" href="<?php echo base_url();?>css/bace.css">
<link rel="stylesheet" href="<?php echo base_url();?>css/admin-style.css">
<!--<link rel="stylesheet" href="<?php echo base_url();?>css/helpdesk-style.css">-->
<link rel="stylesheet" href="<?php echo base_url();?>css/nav.css">
<link rel="stylesheet" href="<?php echo base_url();?>css/banner.css">
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]>
<script type="text/javascript" src="/js/respond.js"></script>
<![endif]-->
<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/common.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
	/*------- tab pannel --------------- */
	$(".tab_content4").hide();
	$(".tab_content4:first").show(); 

	$("ul.tabs4 li").click(function() {
		$("ul.tabs4 li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content4").hide();
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab).fadeIn(); 
	});
	
	
});
</script>
</head>
<script>
	/*
function logoutuser(e) { 
    if (!e) e = window.event;
     $.ajax({url: "<?=  base_url();?>/registration/logout",  success: function(result){}});
    
}
window.onbeforeunload = logoutuser;*/
</script>
<body>
<header>
  <section class="top_header">
    <div class="wrapper-full">
	<div class="tp_call">Call us on: 011-4567 789</div>
       <div class="tp_link">
	  <?php
	 // print_r($this->session->userdata);
	  $userid=$this->session->userdata('id');
	  $full_name =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "first_name");
	  ?>
        <div class="top_header_name"><p>Welcome!</p><span><?php echo ucfirst($full_name);?></span></div>
        <a id="login_dropdown" onclick="showhidedropdown();" href="javascript:"><img src="/images/icon-setting.png"></a>
		<div class="login_dropdown" style=" display:none;">
			<a href="/registration/logout">Logout</a>      
		</div>
	 </div>
    </div>
  </section>
   <section class="header">
    <div class="wrapper-full">
      <div class="logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>bankeauc/assets/img/logo.png"></a></div>
      <div class="menu">
        <ul class="active">
          <li <?php echo ($menu_type=='auction_calender')?$class='class="current-item"':$class='';?>><a target="_blank" href="/auction_calender">Auction Calender</a></li>
          <li <?php echo ($menu_type=='how_it_works')?$class='class="current-item"':$class='';?>><a href="<?php echo base_url(); ?>how-it-works">How it Works</a></li>
          <li <?php echo ($menu_type=='sell')?$class='class="current-item"':$class='';?>><a href="<?php echo base_url(); ?>property/?propertype=sell&act=non_auction">Buy</a></li>
          <!--<li <?php echo ($menu_type=='rent')?$class='class="current-item"':$class='';?>><a href="<?php echo base_url(); ?>property/?propertype=rent&act=non_auction">Rent</a></li>-->
		  <?php
		  if($userid>0){
		  if($user_type=='owner'){?>
				<li <?php echo ($menu_type=='post_property')?$class='class="current-item"':$class='';?>><a href="<?php echo base_url(); ?>owner/sellerPostPropety">Post Property</a></li>          
		  <?php }else if($user_type=='helpdesk_ex') {?>
				<li <?php echo ($menu_type=='post_property')?$class='class="current-item"':$class='';?>><a href="<?php echo base_url(); ?>helpdesk_executive/createLoggedEvents">Post Property</a></li>          
		  <?php }else{ ?>
				<li><a href="#">Post Property</a></li>        
		  <?php } ?>
		  <?php }else{ ?>
		  <li><a href="<?php echo base_url(); ?>registration/login">Post Property</a></li>        
		  <?php } ?>
        </ul>
        <a class="toggle-nav" href="#">&#9776;</a> </div>
    </div>
    <div style="float: right;margin-top: -16px;margin-right: 20px;"><a target="_blank" href=""><img src="<?php echo base_url(); ?>images/bankeauction-logo.jpg"/></a></div>
  </section>
  </section>
</header>
