<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <?php if($subcategory != ""){?>
        <title><?php //echo $catename;?> <?php echo ucfirst($subcategory);?> for Auction in <?php echo ucfirst($cityNameMain);?> Reserve Price: <?php echo $reserve_price; ?>/-</title>
        <meta name="description" content="<?php //echo ucfirst($catename);?> <?php echo ucfirst($subcategory);?> for sale through e-Auction - Reserve Price: <?php echo $reserve_price; ?> ✓<?php echo $branchname; ?> ✓ Auction Start date: <?php echo date("M jS, Y, h:i A",strtotime($auction_start_date)); ?> -Register, Bid & Win NPA Property"/>
        <link rel="canonical" href="<?= base_url(); ?><?php echo ltrim($_SERVER['REQUEST_URI'],"/"); ?>"/>
        <?php }else{ ?>
		<title>Forgot Password</title>			
        <?php } ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="favicon.ico">
		<link href="<?=  base_url();?>bankeauc/assets/css/style.css" rel="stylesheet" type="text/css">
		<link href="<?=  base_url();?>bankeauc/assets/css/responsive.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="<?=  base_url();?>bankeauc/assets/css/slider.css">
		<script src="<?=  base_url();?>bankeauc/assets/js/jquery-2.1.3.min.js"></script>
		<script src="<?=  base_url();?>bankeauc/assets/js/jquery.slicknav.js"></script>		
		<script src="<?=  base_url();?>bankeauc/assets/js/modernizr.min.js"></script>
      
		<script src="<?= base_url(); ?>bankeauc/js/global.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/common.js"></script>
        <!--[if lt IE 9]>
            <script type="text/javascript" 
                src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
            </script>
        <![endif]-->
        <script type="text/javascript">
            var tmonth = new Array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12");
            function GetClock() {
                var d = new Date();
                var nmonth = d.getMonth(), ndate = d.getDate(), nyear = d.getYear();
                if (nyear < 1000)
                    nyear += 1900;

                var nhour = d.getHours(), nmin = d.getMinutes(), nsec = d.getSeconds();
                if (nmin <= 9)
                    nmin = "0" + nmin
                if (nsec <= 9)
                    nsec = "0" + nsec;

                document.getElementById('clockbox').innerHTML = "" + tmonth[nmonth] + "/" + " " + ndate + "/ " + nyear + " " + nhour + ":" + nmin + ":" + nsec + "";
            }

            window.onload = function () {
                GetClock();
                setInterval(GetClock, 1000);
            }
        </script>
		<style>
			.header_right{width: 490px;}
			.bank_logo{padding-top:11px;padding-left:20px;}
			.flogout1{padding: 10px;border: 1px solid red;background-color: #f78d8d;border: 1px solid #f78d8d;font-size: 12px;-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;text-align: center;font-weight:bold;}
			.forgot_password a:hover{text-decoration:underline;}
			.container ul li a:hover{text-decoration:underline;}
		</style>
		
		<?php 
			if($bankIdbyshortname > 0)
			$header_color = $getBankDetails[0]->bank_header_color; 
			{  ?>
			<style>
				header{background:#<?php echo $header_color;?> !important;}
			</style>
		<?php } ?>
	</head>
	<?php
		$userid = $this->session->userdata('id');
	?>
	<?php 
	// START: GET HEADER BANNER
		if($homeHeaderBanner){
			foreach($homeHeaderBanner as $row){};
		}

		if($homeHeaderBanner){
			$headerTitle=$row->title;	
			$headerUrl=$row->content;
			$headerImage=$row->image;
			
		}
	// END: GET HEADER BANNER
	?>
    <body>
        <header><!--============================header==================================-->

				<div class="logo"><img src="<?php echo base_url(); ?>bankeauc/assets/img/logo.png" class="logo-img"></a>
								

	
		
			 
                    <?php if($bankIdbyshortname > 0) { 
							$bankURL = $getBankDetails[0]->thumb_logopath;?>                   
                            <div class="logo lft">
								<img src="<?=  base_url();?><?php echo $bankURL; ?>" class="logo-img">
							</div>
                     <?php }else{ ?>
							<ul class="hide">
								<!--<li class="icon phone1"> +91-123-1212121 / 21 / 22 / 23 / 24</li>
								<li class="icon mobile1"> +91- 9999999999 / 1125 / 1126</li>
								
								<li class="style-1">Sales Enquiries : +91- 7291981129</li>-->
							 </ul>
					  <?php } ?>
                   </header>
                <nav>
				 <ul id="menu">
					<li><a href="<?=base_url();?>Bidding_Process_Flow_for_Bank_E_auction.pdf" target='_blank'>Bidder Manual</a></li>
					<li><a href="<?=base_url();?>jre-7u51-windows-i586.exe">Download</a></li>
					<?php /* ?>
					<?php if($bankIdbyshortname > 0){  ?>                    
					<li><a href="<?=base_url();?>registration/signup?bi=<?php echo $bankIdbyshortname;?>">Registration</a></li>
					<?php } else { ?>
					<li><a href="<?=base_url();?>registration/signup">Registration</a></li>
					<?php } ?>
					<?php */ ?>
					<li><a href="<?=base_url();?>faq.html" target="_blank">FAQs</a></li>
					<li><a href="<?=base_url();?>contactus.html" target="_blank">Contact Us</a></li>
					<?php if ($userid > 0) { ?>
						<li><a href="<?= base_url(); ?>registration/logout">Logout</a></li>
						<?php } else { ?>
						<?php if($bankIdbyshortname > 0) 
						{
						?>
								<li><a href="<?= base_url(); ?><?php echo $bankShortname;?>">Login</a></li>   
								<?php }else{ ?>
								<li><a href="<?= base_url(); ?>registration/login">Login</a></li>   
								<?php } ?>
						<?php } ?>
				 </ul>
      </nav>
      <div style="clear:both"></div>


