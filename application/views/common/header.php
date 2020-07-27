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
<link rel="stylesheet" href="/css/bace.css">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/nav.css">
<link rel="stylesheet" href="/css/banner.css">
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]>
<script type="text/javascript" src="/js/respond.js"></script>
<![endif]-->

</head>

<body>
<header>
  <section class="top_header">
    <div class="wrapper">
      <div class="tp_call">Call us on: 011-4567 789</div>
      <div class="tp_link"> 
	   <?php
	 // print_r($this->session->userdata);
	  $userid=$this->session->userdata('id');
	  $user_type=$this->session->userdata('user_type');
	  $full_name =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "first_name");
	  if($userid>0){
	  ?>	  
	  <div class="top_header_name"><p>Welcome!</p> <span><?php echo ucfirst($full_name);?></span></div>
	  <a href="/registration/logout">Logout</a> 
	  
	  <?php } else{ ?>
	  <a id="login" href="/registration/login" class="right-bor">Log In </a> 
	  <!--<a href="/registration/signup">Register  New User</a> -->
	  <?php }?>
	  
	  </div>
    </div>
  </section>
  <section class="header">
    <div class="wrapper">
     <a href="/"> <div class="logo"><img src="/images/logo.png"></div></a>
      <nav class="menu">
        <ul class="active">
          <li><a href="/auction-calender" target="_blank">Auction Calander</a></li>
          <li><a href="<?php echo base_url(); ?>how-it-works">How it Works</a></li>
          <li><a href="/property/?propertype=sell&act=non_auction">Buy</a></li>
          <!--<li><a href="/property/?propertype=rent&act=non_auction">Rent</a></li>-->
		  <?php
		  if($userid>0){
		  if($user_type=='owner'){?>
				<li><a href="/owner/sellerPostPropety">Post Property</a></li>          
		  <?php }else if($user_type=='helpdesk_ex') {?>
				<li><a href="/helpdesk_executive/createLoggedEvents">Post Property</a></li>          
		  <?php }else{ ?>
				<li><a href="#">Post Property</a></li>        
		  <?php } ?>
		  <?php }else{ ?>
		  <li><a href="/registration/login">Post Property</a></li>        
		  <?php } ?>
        </ul>
        <a class="toggle-nav" href="#">&#9776;</a> </nav>
    </div>
    <div style="float: right;margin-top: -16px;margin-right: 20px;"><a target="_blank" href=""><img src="<?php echo base_url(); ?>images/bankeauction-logo.jpg"/></a></div>
  </section>
</header>
