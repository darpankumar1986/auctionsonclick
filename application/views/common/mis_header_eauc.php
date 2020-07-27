<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo JDA_TITLE; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?=  base_url();?>bankeauc/css/common.css" rel="stylesheet" type="text/css">
<link href="<?=  base_url();?>bankeauc/css/common_dk.css" rel="stylesheet" type="text/css">
<link href="<?=  base_url();?>bankeauc/css/responsive.css" rel="stylesheet" type="text/css">

<?php /* ?>
<link rel="stylesheet" href="<?=  base_url();?>bankeauc/css/tables.css">
<?php */ ?>
<link rel="stylesheet" href="<?=  base_url();?>bankeauc/css/jquery-ui.css">

<!--[if lt IE 9]>
    <script type="text/javascript" 
        src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
    </script>
<![endif]-->
<script type="text/javascript" src="<?=  base_url();?>bankeauc/js/sortable.js"></script>
<script src="<?=  base_url();?>bankeauc/js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="<?=  base_url();?>bankeauc/js/global.js" type="text/javascript"></script>
<?php
			$date = new DateTime();
			$current_timestamp = $date->getTimestamp();
		?>

		<script>
		    flag_time1 = true;
			timer1 = '';
			//setInterval(function(){phpJavascriptClock1();},1000);
			
			function phpJavascriptClock1()
			{
				if ( flag_time1 ) {
				timer1 = <?php echo $current_timestamp;?>*1000;
				}
				var d = new Date(timer1);
                               
				months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');
				
				month_array = new Array('January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'Augest', 'September', 'October', 'November', 'December');
				month_array = new Array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
				
				day_array = new Array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
				
				currentYear = d.getFullYear();
				month = d.getMonth();
				var currentMonth = months[month];
				var currentMonth1 = month_array[month];
				var currentDate = d.getDate();
				currentDate = currentDate < 10 ? '0'+currentDate : currentDate;
                                currentDate2 = month < 10 ? '0'+month : month;
                              
				var day = d.getDay();
				current_day = day_array[day];
				var hours = d.getHours();
				var minutes = d.getMinutes();
				var seconds = d.getSeconds();
				
				var ampm = hours >= 12 ? 'PM' : 'AM';
				//hours = hours % 12;
				//hours = hours ? hours : 12; // the hour ’0′ should be ’12′
				minutes = minutes < 10 ? '0'+minutes : minutes;
				seconds = seconds < 10 ? '0'+seconds : seconds;
				var strTime = hours + ':' + minutes+ ':' + seconds;
				timer1 = timer1 + 1000;
                                //2016-03-08 11:15:00
				//document.getElementById("demo").innerHTML= currentMonth+' ' + currentDate+' , ' + currentYear + ' ' + strTime ;
				document.getElementById("clockbox").innerHTML=currentYear+'-'+currentMonth1+'-'+currentDate+' '+strTime;
				//document.getElementById("demo1").innerHTML= currentMonth1+' ' + currentDate+' , ' + currentYear + ' ' + strTime ;
				
				//document.getElementById("demo2").innerHTML= currentDate+':' +(month+1)+':' +currentYear + ' ' + strTime ;
				
				//document.getElementById("demo3").innerHTML= strTime ;
				
				//document.getElementById("demo4").innerHTML= current_day + ' , ' +currentMonth1+' ' + currentDate+' , ' + currentYear + ' ' + strTime ;
				
				
				flag_time1 = false;
			}

		</script>

<style>
.sortable .icon{margin-left:0;}
@media screen and (max-width: 1000px) {
	.logo1{ width:29%;}
	
}
@media screen and (max-width: 530px) {
	.logo1{ width:192px;}
.logo{display:none;}

}
@media screen and (max-width: 360px) {
	.logo1{ width:192px;}
	.logo{display:none;
}}
</style>
</head>
<body>

<!--============================header==================================-->
<header>
		<section class="header_wrapper">
						<div class="header_top">
								<div class="logo"><img src="<?php echo base_url(); ?>bankeauc/assets/img/logo.png" class="logo-img"></a>
								
								<div class="header_right">
										<label for="show-menu" class="show-menu">&nbsp;</label>
										<input type="checkbox" id="show-menu" role="button">
										<ul id="menu">
												<!--<li><a href="">About us</a></li>-->
												<li><a href="<?=base_url();?>faq.html" target="_blank">FAQs</a></li>
												<!--<li><a href="">Help Desk</a></li>-->
												<li><a href="<?=base_url();?>contactus.html" target="_blank">Contact Us</a></li>
												<li><a href="/registration/logout">Logout</a></li>
										</ul>
										<div class="clear">&nbsp;</div>
										<?php /* ?><div class="logo flt_rgt"><img src="<?=  base_url();?>bankeauc/images/logo.png" width="192" height="60" alt="Bank eauctions"></div><?php */ ?>
								</div>
						</div>
		</section>
</header><!--============================header end==================================-->
<?php
	 // print_r($this->session->userdata);
	  $userid=$this->session->userdata('id');
	  $full_name =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "first_name");
	  ?>
						<div class="box-head1 no_border">
								<div class="container_12">
									<h2>Welcome, <?php echo ucfirst($full_name);?></h2>
									<span class="flt_rgt">
												<a href="<?=  base_url();?>mis" style="color:#fff;font-size:12px;">Dashboard</a>
												<select name="ddlLogin" id="ddlLogin" title="Select Link"  onchange="location = this.options[this.selectedIndex].value;">
												<option value="">Select Links</option>
												<option value="<?=  base_url();?>mis/eventLogStatus">Event Log Status</option>
												<option value="<?=  base_url();?>mis/accountSummary">Account Summary</option>
												<option value="<?=  base_url();?>mis/paymentDue">Payment Due</option>
												<option value="<?=  base_url();?>mis/search">Search</option>
												<option value="<?=  base_url();?>mis/targetSheet">Target Sheet</option>
												<option value="<?=  base_url();?>mis/bankWiseAmtOutStanding">Bank Wise Outstanding Amount</option>
												<option value="<?=  base_url();?>mis/executiveWiseAmtOutStanding">Executive Wise Outstanding Amount</option>
												<option value="<?=  base_url();?>mis/timeMgmt/">Time Mgmt</option>
												<option value="<?=  base_url();?>mis/targetCollectionStatus">Target Collection Status</option>
												<option value="<?=  base_url();?>mis/invoiceReport">Invoice Report</option>
												<option value="<?=  base_url();?>mis/completeMISReport">Complete MIS Report</option>
												<option value="<?=  base_url();?>mis/creditNoteList">Credit Note List</option>
												<option value="<?php echo base_url();?>mis/paymentFollowUpList">Payment FollowUp List</option>
										</select>
									</span>
							   </div>
						</div>





<?php /* ?>
<link rel="stylesheet" href="<?php echo base_url();?>css/bace.css">
<link rel="stylesheet" href="<?php echo base_url();?>css/admin-style.css">
<?php */ ?>
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
	$(".tab_content3").hide();
	$(".tab_content3:first").show(); 

	$("ul.tabs3 li").click(function() {
		$("ul.tabs3 li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content3").hide();
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab).fadeIn(); 
	});
	
		/*------- header menu --------------- */
	
    jQuery('.toggle-nav').click(function(e) {
        jQuery(this).toggleClass('active');
        jQuery('.menu ul').toggleClass('active');
 
        e.preventDefault();
    	});
	
	
});
</script>

<?php /* ?>
</head>
<body>
	
<header>
	
  <section class="top_header">
  <div class="tp_call">Call us on: 011-4567 789</div>
    <div class="wrapper-full">
        <div class="tp_link">
	  <?php
	  $userid=$this->session->userdata('id');
	  $full_name =	GetTitleByField('tbl_user', "id='".$userid."'", "first_name");
	  ?>
         <div class="top_header_name"><p>Welcome!</p> <span><?php echo ucfirst($full_name);?></span></div>
        <a id="login_dropdown" onclick="showhidedropdown();" href="javascript:"><img src="/images/icon-setting.png"></a>
		<div class="login_dropdown" style=" display:none;">
			<a href="/registration/logout">Logout</a>      
		</div>
	 </div>
    </div>
  </section>
  <?php */ ?>
  
   <?php /* ?>
   <section class="header">
    <div class="wrapper-full">
      <div class="logo-com">
				  <?php
				  $bank_id=$this->session->userdata('bank_id');
				  $banklogo =	GetTitleByField('tbl_bank', "id='".$bank_id."'", "logopath");
				  if($banklogo){
				  ?>
				  
				  <img src="<?php echo base_url().$banklogo; ?>">
				  <?php } ?>
	  
	  </div>
	 
	  <div class="logo ftright" style="padding:0 0 0 20px;">
	  <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>images/logo2.png"></a>
	  </div>
	  
	  
      <div class="menu">
        <ul class="active">
          <li <?php echo ($menu_type=='auction_calender')?$class='class="current-item"':$class='';?>><a target="_blank" href="/auction-calender">Auction Calender</a></li>
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
        <a class="toggle-nav" href="#">&#9776;</a> 
        </div>
		</div> 
		
				<div style="float: right;margin-right: 20px;"><a target="_blank" href="https://www.c1india.com/"><img src="<?php echo base_url(); ?>images/bankeauction-logo.jpg"/></a></div>
		
  </section>
  
</header><?php */ ?>
