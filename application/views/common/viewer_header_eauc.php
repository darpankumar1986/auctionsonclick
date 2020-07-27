<?php
	$userid = $this->session->userdata('id');
	$this->db->select('user_sess_val');
	$this->db->where('id',$userid);
	$query=$this->db->get('tbl_user');
	$row=$query->result();
	
	if(!empty($row))
	{
		$session_id = $this->session->userdata('session_id_user');                    
		if($row[0]->user_sess_val !=  $session_id)
		{
			header('Location:'.  base_url().'registration/logout');
			exit();
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo JDA_TITLE; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?=  base_url();?>bankeauc/css/common.css" rel="stylesheet" type="text/css">
<link href="<?=  base_url();?>bankeauc/css/responsive.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?=  base_url();?>bankeauc/css/jquery-ui.css">
<!--[if lt IE 9]>
    <script type="text/javascript" 
        src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
    </script>
<![endif]-->
<script type="text/javascript" src="<?=  base_url();?>bankeauc/js/sortable.js"></script>
<script src="<?=  base_url();?>bankeauc/js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="<?=  base_url();?>bankeauc/js/global.js" type="text/javascript"></script>
	<script type="text/javascript">
	var tmonth=new Array("1","2","3","4","5","6","7","8","9","10","11","12");
	function GetClock()
	{
		var d=new Date();
		var nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear();
		if(nyear<1000) nyear+=1900;

		var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds();
		if(nmin<=9) nmin="0"+nmin
		if(nsec<=9) nsec="0"+nsec;
		document.getElementById('clockbox').innerHTML=""+tmonth[nmonth]+"/"+" "+ndate+"/ "+nyear+" "+nhour+":"+nmin+":"+nsec+"";
	}
	</script>
	<style>
	.sortable .icon{margin-left:0;}
		@media screen and (max-width: 1000px) 
		{
			.logo1{ width:29%;}
		}
		@media screen and (max-width: 530px) 
		{
			.logo1{ width:250px;}
			.logo{display:none;}
			.header_right ul {background:#4e8e2d;}
		}
		@media screen and (max-width: 360px) 
		{
			.logo1{ width:250px;}
			.logo{display:none;}
		}
	</style>
	<script type="text/javascript">
			function noBack()
			 {
				 window.history.forward()
			 }
			noBack();
			window.onload = noBack;
			window.onpageshow = function(evt) { if (evt.persisted) noBack() }
			window.onunload = function() { void (0) }
	</script>
</head>
<body>
<?php  
	$bank_id=$this->session->userdata('bank_id');
	$bank_header_color = GetTitleByField('tbl_bank', "id='".$bank_id."'", "bank_header_color");
?>
<!--============================header==================================-->
<header>
	<section class="header_wrapper">
		<div class="header_top">
			<div class="logo"><img src="<?php echo base_url(); ?>bankeauc/assets/img/logo.png" class="logo-img"></a>
								
			<div class="header_right">
				<label for="show-menu" class="show-menu">&nbsp;</label>
				<input type="checkbox" id="show-menu" role="button">
				<ul id="menu">
						<li><a href="<?=base_url();?>faq.html" target="_blank">FAQs</a></li>
						<!--<li><a href="<?=base_url();?>bankviewer/myProfileChangePassword">Change Password</a></li>-->
						<li><a href="<?=base_url();?>contactus.html" target="_blank">Contact Us</a></li>
						<li><a href="/registration/logout">Logout</a></li>
				</ul>
				<div class="clear">&nbsp;</div>
				<div class="logo flt_rgt"><img src="<?=  base_url();?>bankeauc/images/logo.png" width="192" height="60" alt="Bank eauctions"></div>
			</div>
		</div>
	</section>
</header><!--============================header end==================================-->
<?php
	$userid=$this->session->userdata('id');
	$first_name = GetTitleByField('tbl_user', "id='".$userid."'", "first_name");
	$last_name = GetTitleByField('tbl_user', "id='".$userid."'", "last_name");
	$full_name = $first_name." ".$last_name;
?>
		<div class="box-head1 no_border">
				<div class="container_12">
					<h2>Welcome, <?php echo ucfirst($full_name);?></h2>
					<span class="flt_rgt">
						<a href="<?=  base_url();?>bankviewer/myActivity" style="color:#fff;font-size:12px;">Dashboard</a>
						<select name="ddlLogin" id="ddlLogin" title="Select Link"  onchange="location = this.options[this.selectedIndex].value;">
							<option value="">Select Links</option>
							<option value="<?=  base_url();?>bankviewer/liveAuctions">Live Auctions</option>
							<option value="<?=  base_url();?>bankviewer/listLiveAuctions">List Live Auctions</option>
						</select>
					</span>
			   </div>
		</div>
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
	<link rel="stylesheet" href="<?php echo base_url();?>css/colorbox.css" />
	<script src="<?php echo base_url();?>js/jquery.colorbox.js"></script>
	<script src="<?php echo base_url();?>js/banker.js"></script>
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
	<script src="<?php echo base_url();?>js/jquery.validate.min.js"></script>


