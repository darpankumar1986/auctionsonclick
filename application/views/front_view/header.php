<?php 
	$controller_name = $this->router->fetch_class(); // class = controller
	$method = $this->router->fetch_method();


    $userid=$this->session->userdata('id');
    $full_name =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "first_name");
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
	<link href="<?php echo base_url(); ?>assets/auctiononclick/css/jquery-ui.css?rand=<?php echo CACHE_RANDOM; ?>" rel="stylesheet" type="text/css" />
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
	<!--<script src="<?php echo base_url(); ?>bankeauc/js/promise.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
	<script src="<?php echo base_url(); ?>bankeauc/js/sweetalert.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
    <script src="<?php echo base_url(); ?>bankeauc/js/sweetalert.core.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bankeauc/css/sweetalert.css?rand=<?php echo CACHE_RANDOM; ?>">-->

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <div class="col-sm-3">
                            <div class="web-logo">
                                <a href="#"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/Logo.png"></a>
                            </div><!--web-logo-->
                        </div>
                        <div class="col-sm-9">
                            <div class="alert_notification">
                                <ul>
                                    <li><a href="<?php echo base_url(); ?>owner/shortlistedAuction"><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/star_icon.png"></span>Shortlist</a></li>
                                    <li><a href="#"><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/alarm_icon.png"></span>Set Alerts</a></li>
                                </ul>
                            </div>
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
                                            <li><a href="#">Change Password</a></li>
                                            <li><a href="<?php echo base_url(); ?>owner/shortlistedAuction">Shortlist</a></li>
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
                                    <ul class="notification_alert">
                                        <li><a class="first_list" href="#"><i class="fa fa-bell-o"></i>Set Alerts</a></li>
                                        <li><a class="first_list" href="<?php echo base_url(); ?>owner/shortlistedAuction"><i class="fa fa-star"></i>Shortlist</a></li>
                                    </ul>
                                    <ul class="nav_section">
                                        <li class="list_desc"><a href="<?php echo base_url(); ?>home/login"><span><i class="fa fa-user"></i></span> Login / Register</a></li>
                                        <li class="list_desc"><a href="#"><span><i class="fa fa-headphones"></i></span> Customer Service</a></li>
                                        <li><a href="<?php echo base_url();?>home/premiumServices">Premium Services</a></li>
                                        <li><a href="#">Top Cities</a></li>
                                        <li><a href="#">Bankeauctions.com</a></li>
                                        <li><a href="#">About Us</a></li>
                                        <li><a href="#">FAQ</a></li>
                                        <li><a href="#">Contact US</a></li>
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
                        <div class="col-sm-3">
                            <div class="web-logo">
                                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/Logo.png"></a>
                            </div><!--web-logo-->
                        </div>
                        <div class="col-sm-5">
                            <div class="form-wrap">
                                <form class="form_desc">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Select
                                            <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<?php $parentCat = $this->home_model->getAllCategory(0,true); ?>
											<?php foreach($parentCat as $key => $parCat){ ?>
												<li class="dropdown-header">
													<input type="radio" id="test<?php echo $key; ?>" class="s_parent_id" s-data-parent-id="<?php echo $parCat->id;?>" name="parentCat" value="<?php echo $parCat->id;?>" <?php echo ($parCat->id == $_GET['assetsTypeId'])?'checked="checked"':''; ?> />
													<label for="test<?php echo $key; ?>">All <?php echo $parCat->name; ?></label>
												</li>
												<?php $Cats = $this->home_model->getAllCategory($parCat->id); ?>
												<?php foreach($Cats as $cat){ ?>
		                                             <li><label class="checkbox-inline"><input type="checkbox" s-data-parent="<?php echo $parCat->id;?>" name="s_sub_id" value="<?php echo $cat->id;?>" <?php echo (in_array($cat->id,$_GET['sc']))?'checked="checked"':''; ?> /><?php echo $cat->name; ?></label></li>
												<?php } ?>
											<?php } ?>
                                        </ul>
                                    </div>
                                    <div class="input-group">
                                        <input type="text" id="txt-search" class="form-control" placeholder="Type City" value="<?php echo $_GET['search'];?>">
                                        <div class="input-group-btn search_btn">
                                            <button class="btn btn-default" type="button" onclick="goForSearch(this)">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
									<div class="error" id="error_txt" style="display: block;height: 20px;padding-right: 30px;color: rgb(251 189 189);    background-color: transparent;    margin-top: 42px;    margin-left: 148px;;"></div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-4">
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
                                            <li><a href="#">Change Password</a></li>
                                            <li><a href="<?php echo base_url(); ?>owner/shortlistedAuction">Shortlist</a></li>
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
                                    <ul class="notification_alert">
                                        <li><a class="first_list" href="#"><i class="fa fa-bell-o"></i>Set Alerts</a></li>
                                        <li><a class="first_list" href="<?php echo base_url(); ?>owner/shortlistedAuction"><i class="fa fa-star"></i>Shortlist</a></li>
                                    </ul>
                                    <ul class="nav_section">
                                        <li class="list_desc"><a href="<?php echo base_url(); ?>home/login"><span><i class="fa fa-user"></i></span> Login / Register</a></li>
                                        <li class="list_desc"><a href="#"><span><i class="fa fa-headphones"></i></span> Customer Service</a></li>
                                        <li><a href="<?php echo base_url();?>home/premiumServices">Premium Services</a></li>
                                        <li><a href="#">Top Cities</a></li>
                                        <li><a href="#">Bankeauctions.com</a></li>
                                        <li><a href="#">About Us</a></li>
                                        <li><a href="#">FAQ</a></li>
                                        <li><a href="#">Contact US</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--container-->
            </div><!--header-top-->
        </div><!--Position-fix-->
        
	<?php } ?>