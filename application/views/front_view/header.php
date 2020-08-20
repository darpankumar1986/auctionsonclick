
<?php 
	$controller_name = $this->router->fetch_class(); // class = controller
	$method = $this->router->fetch_method();


    $userid=$this->session->userdata('id');
	$user_type =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "user_type");
	if($user_type == 'owner')
	{
		$full_name =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "first_name");
		$full_name .= ' '.GetTitleByField('tbl_user_registration', "id='".$userid."'", "last_name");
	}
	else
	{
		$full_name .= ' '.GetTitleByField('tbl_user_registration', "id='".$userid."'", "authorized_person");
	}
?>
<!doctype html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      
      <meta name="description" content="<?php echo ucwords($getBankName); ?> selling residential, commercial, industrial, agricultural properties, land, plots, house and  flats across the India. View, Bid & Win Non Performing Assets (NPA), DRT Properties."/>
		<title><?php if($title != ''){echo $title;}else{ echo 'Auction';} ?></title>
      <meta name="description" content="Find residential and commercial auction properties for sale from the <?php echo BRAND_NAME; ?> . View, Bid & Win Non Performing Assets (NPA), Auction, Foreclosure and Sarfaesi Auction Properties."/>
      <meta name="Owner" content=" "/>
	  <meta name="Copyright" content=""/>
      <meta name="classification" content="Property Search"/>
      <meta name="distribution" content="India"/>
      <meta name="rating" content="General"/>
      <meta name="audience" content="All"/>
	 
	<link rel="icon" href="<?php echo base_url();?>favicon.ico?rand=<?php echo CACHE_RANDOM; ?>">	
	<link href="<?php echo base_url(); ?>assets/auctiononclick/css/jquery-ui-1.12.1.css?rand=<?php echo CACHE_RANDOM; ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/front_view/css/flexslider.css?rand=<?php echo CACHE_RANDOM; ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/front_view/css/owl.carousel.css?rand=<?php echo CACHE_RANDOM; ?>" rel="stylesheet">
	<!--<link href="<?php echo base_url();?>assets/front_view/css/style.css?rand=<?php echo CACHE_RANDOM; ?>" rel="stylesheet" type="text/css" />-->
	<link href="<?php echo base_url();?>assets/front_view/css/popup.css?rand=<?php echo CACHE_RANDOM; ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/front_view/css/custom.css?rand=<?php echo CACHE_RANDOM; ?>" rel="stylesheet" type="text/css" />
	<!-- FONTS -->
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500italic,700,500,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href="<?php echo base_url();?>assets/front_view/css/font-awesome.min.css?rand=<?php echo CACHE_RANDOM; ?>" rel="stylesheet">	
	<!-- SCRIPTS -->
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<!--[if IE]><html class="ie" lang="en"> <![endif]-->
	<script src="<?php echo base_url(); ?>assets/auctiononclick/js/jquery-3.2.0.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
	
	<script src="<?php echo base_url();?>assets/front_view/js/jquery.nicescroll.min.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/superfish.min.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/jquery.flexslider-min.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/owl.carousel.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/velocity.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/popup.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/core-min.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/sha256-min.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/validation.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>bankeauc/js/sweetalert.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
	<script src="<?php echo base_url(); ?>bankeauc/js/sweetalert.core.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
	<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
	<!--<script src="<?php echo base_url(); ?>bankeauc/js/promise.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
	<script src="<?php echo base_url(); ?>bankeauc/js/sweetalert.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
    <script src="<?php echo base_url(); ?>bankeauc/js/sweetalert.core.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bankeauc/css/sweetalert.css?rand=<?php echo CACHE_RANDOM; ?>">-->

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bankeauc/css/sweetalert.css?rand=<?php echo CACHE_RANDOM; ?>">
    <link href="<?php echo base_url(); ?>assets/auctiononclick/css/bootstrap.min.css?rand=<?php echo CACHE_RANDOM; ?>" rel="stylesheet">
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css?rand=<?php echo CACHE_RANDOM; ?>">-->
    <link href="<?php echo base_url(); ?>assets/auctiononclick/css/font-awesome.css?rand=<?php echo CACHE_RANDOM; ?>" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/auctiononclick/css/chosen.css?rand=<?php echo CACHE_RANDOM; ?>" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/auctiononclick/css/style.css?rand=<?php echo CACHE_RANDOM; ?>" rel="stylesheet">
	
	
		<?php
			if(isset($_GET['track'])){$track=$_GET['track'];}else{$track='';}
			if(isset($_GET['auctionID'])){$auctionID=$_GET['auctionID'];}else{$auctionID='';}
		?>
      <!--[if lt IE 9]>
      <script type="text/javascript" src="assets/js/html5.js"></script>
      <![endif]-->
		
	<style>
		.flogout1{padding:0 10px;font-size: 12px;-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;text-align: center;}
		/*.mlb{background: #1776ae !important;padding: 10px 15px !important;color: #ffffff !important;border-radius: 3px;}*/
	</style>
</head>
<?php if($method == 'index'){ ?>
	<div class="auction-main">
        <div class="position-fix">
            <div id="main" class="header-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="web-logo">
                                <a href="#"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/Logo.png"></a>
                            </div><!--web-logo-->
                        </div>
						<div class="col-sm-4">
                           <div class="premium_main">
                               <div class="premium_services login">
                                   <ul>
                                       <li><a href="<?php echo base_url();?>home/premiumServices">premium services</a></li>
                                       <li><a href="<?php echo base_url();?>home/advanced_search">Advanced Search</a></li>
                                   </ul>
                               </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="login">
                                <ul>
                                    <li class="customer_info"><div class="dropdown"><button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span><i class="fa fa-headphones"></i></span> Customer Service</button>
                                        <ul class="dropdown-menu arrow_box">
                                            <li>Contact Us</li>
                                            <li>MON-SAT | 9:00AM-7:00PM</li>
                                            <li><a href="mailto:support@auctionsonclick.com"><span><i class="fa fa-envelope"></i></span>support@auctionsonclick.com</a></li>
                                            <li><span><i class="fa fa-mobile big"></i></span>+91- 7291981124 / 1125 / 1126</li>
                                            <li><span><i class="fa fa-phone big"></i></span>+91-124-4302020 / 21 / 22 / 23</li>
                                        </ul>
                                    </div></li>
                                    <?php if($this->session->userdata('id') > 0){ ?>
									 <li class="user_info"><div class="dropdown"><button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span><i class="fa fa-user"></i></span> <?php echo $full_name; ?><span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo base_url();?>owner/myProfileEdit">Modify Profile</a></li>
                                            <li><a href="<?php echo base_url();?>owner/myProfileChangePassword">Change Password</a></li>
                                            <li><a href="<?php echo base_url(); ?>owner/shortlistedAuction">Shortlist</a></li>
											<li><a href="<?php echo base_url(); ?>owner/manageSubscription">Manage Subscription</a></li>
                                            <li><a href="<?php echo base_url(); ?>registration/logout">Logout</a></li>
                                        </ul>
                                        </div></li>
									<?php }else{ ?>
                                    <li class="login_register"><a href="<?php echo base_url(); ?>home/login"><span><i class="fa fa-user"></i></span>Login / Register</a></li>
									<?php } ?>
									
                                    <li><a href="#"><span class="cret-1" onclick="openNav()"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/menu_icon.png"></span></a></li>
                                </ul>
                                <div id="mySidenav" class="sidenav">
                                    <button type="button" class="closebtn" onclick="closeNav()">&times;</button>
                                    <ul class="nav_section">
										<?php if(!($this->session->userdata('id') > 0)){ ?>
	                                        <li class="list_desc"><a href="<?php echo base_url(); ?>home/login"><span><i class="fa fa-user"></i></span> Login / Register</a></li>
										<?php } ?>
                                        <li class="list_desc"><a href="#"><span><i class="fa fa-headphones"></i></span> Customer Service</a></li>
                                        <li><a href="<?php echo base_url();?>home/premiumServices">Premium Services</a></li>
                                        <li><a href="<?php echo base_url();?>home/advanced_search">Advanced Search</a></li>
                                        <li><a href="<?php echo base_url();?>home/top_cities">Top Cities</a></li>
										<li><a href="<?php echo base_url();?>home/top_banks">Top Banks</a></li>
                                        <li><a href="https://bankeauctions.com/" target="_blank">Bankeauctions.com</a></li>
                                        <li><a href="<?php echo base_url();?>about-us">About Us</a></li>
                                        <li><a href="<?php echo base_url();?>faq">FAQ</a></li>
                                        <li><a href="<?php echo base_url();?>contact-us">Contact US</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--container-->
            </div><!--header-top-->
        </div><!--Position-fix-->
<?php }else{ ?>
   <div class="auction-main auction-main-wrapper">
        <div class="position-fix">
            <div id="main" class="header-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="web-logo">
                                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/Logo.png"></a>
                            </div><!--web-logo-->
                        </div>
						<div class="col-sm-4">
                           <div class="premium_main">
                               <div class="premium_services login">
                                    <ul>
                                       <li><a href="<?php echo base_url();?>home/premiumServices">premium services</a></li>
                                       <li><a href="<?php echo base_url();?>home/advanced_search">Advanced Search</a></li>
                                   </ul>
                               </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="login">
                                <ul>
                                    <li class="customer_info"><div class="dropdown"><button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span><i class="fa fa-headphones"></i></span> Customer Service</button>
                                        <ul class="dropdown-menu arrow_box">
                                            <li>Contact Us</li>
                                            <li>MON-SAT | 9:00AM-7:00PM</li>
                                            <li><a href="mailto:support@auctionsonclick.com"><span><i class="fa fa-envelope"></i></span>support@auctionsonclick.com</a></li>
                                            <li><span><i class="fa fa-mobile big"></i></span>+91- 7291981124 / 1125 / 1126</li>
                                            <li><span><i class="fa fa-phone big"></i></span>+91-124-4302020 / 21 / 22 / 23</li>
                                        </ul>
                                    </div></li>
									<?php if($this->session->userdata('id') > 0){ ?>
									 <li class="user_info"><div class="dropdown"><button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span><i class="fa fa-user"></i></span> <?php echo $full_name; ?><span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo base_url();?>owner/myProfileEdit">Modify Profile</a></li>
                                            <li><a href="<?php echo base_url();?>owner/myProfileChangePassword">Change Password</a></li>
                                            <li><a href="<?php echo base_url(); ?>owner/shortlistedAuction">Shortlist</a></li>
											<?php $currentpackage = $this->home_model->getLastPackage($this->session->userdata('id')); ?>
											<?php if($currentpackage->subscription_participate_id > 0){ ?>
												<li><a href="<?php echo base_url(); ?>owner/manageSubscription">Manage Subscription</a></li>
											<?php } ?>
                                            <li><a href="<?php echo base_url(); ?>registration/logout">Logout</a></li>
                                        </ul>
                                        </div></li>
									<?php }else{ ?>
                                    <li><a href="<?php echo base_url(); ?>home/login"><span><i class="fa fa-user"></i></span>Login / Register</a></li>
									<?php } ?>
                                    <li><a href="#"><span class="cret-1" onclick="openNav()"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/menu_icon.png"></span></a></li>
                                </ul>
                                <div id="mySidenav" class="sidenav">
                                    <button type="button" class="closebtn" onclick="closeNav()">&times;</button>
                                    
                                    <ul class="nav_section">
										<?php if(!($this->session->userdata('id') > 0)){ ?>
	                                        <li class="list_desc"><a href="<?php echo base_url(); ?>home/login"><span><i class="fa fa-user"></i></span> Login / Register</a></li>
										<?php } ?>
                                        <li class="list_desc"><a href="#"><span><i class="fa fa-headphones"></i></span> Customer Service</a></li>
                                        <li><a href="<?php echo base_url();?>home/premiumServices">Premium Services</a></li>
                                        <li><a href="<?php echo base_url();?>home/advanced_search">Advanced Search</a></li>
                                        <li><a href="<?php echo base_url();?>home/top_cities">Top Cities</a></li>
										<li><a href="<?php echo base_url();?>home/top_banks">Top Banks</a></li>
                                        <li><a href="https://bankeauctions.com/" target="_blank">Bankeauctions.com</a></li>
                                        <li><a href="<?php echo base_url();?>about-us">About Us</a></li>
                                        <li><a href="<?php echo base_url();?>faq">FAQ</a></li>
                                        <li><a href="<?php echo base_url();?>contact-us">Contact US</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--container-->
            </div><!--header-top-->
        </div><!--Position-fix-->
        
	<?php } ?>