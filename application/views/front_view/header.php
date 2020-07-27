<!doctype html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <?php if($bankIdbyshortname > 0) { // Bank Homepage
      ?><title><?php echo ucwords($getBankName); ?> Property Auctions, Online Property Auctions of <?php echo ucwords($getBankName); ?></title>
      <meta name="description" content="<?php echo ucwords($getBankName); ?> selling residential, commercial, industrial, agricultural properties, land, plots, house and  flats across the India. View, Bid & Win Non Performing Assets (NPA), DRT Properties."/>
      <link rel="canonical" href="<?=  base_url();?><?php echo ucwords($getBankShortname); ?>"/>
      <?php } else if((!($bankIdbyshortname > 0)) && $bankShortname!=''){ // Normal City Homepage
	  ?><title>Property Auctions <?php echo ucwords($bankShortname); ?> – Online Auctions of Residential Apartment, Flat Houses & Land</title> 
      <meta name="description" content = "<?php echo ucwords($bankShortname); ?> Property Auctions – Get upcoming auction property, flats, land, shop, commercial land in <?php echo ucwords($bankShortname); ?>." />
      <link rel="canonical" href="<?=  base_url();?><?php echo $bankShortname; ?>"/>
      <?php } else {  // Homepage
		?><!--Start: FOR HOMEPAGE ONLY --><title>Auctions, Property Auctions, Forward Auctions</title>
      <meta name="description" content="Find residential and commercial auction properties for sale from the <?php echo BRAND_NAME; ?> . View, Bid & Win Non Performing Assets (NPA), Auction, Foreclosure and Sarfaesi Auction Properties."/>
      <meta name="Owner" content=" "/>
	  <meta name="Copyright" content=""/>
      <meta name="classification" content="Property Search"/>
      <meta name="distribution" content="India"/>
      <meta name="rating" content="General"/>
      <meta name="audience" content="All"/>
	  <!--End: FOR HOMEPAGE ONLY -->
	  <?php } ?>
	<link rel="icon" href="<?php echo base_url();?>favicon.ico">	
	<link href="<?php echo base_url();?>assets/front_view/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/front_view/css/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/front_view/css/flexslider.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/front_view/css/owl.carousel.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/front_view/css/style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/front_view/css/popup.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/front_view/css/custom.css" rel="stylesheet" type="text/css" />
	<!-- FONTS -->
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500italic,700,500,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href="<?php echo base_url();?>assets/front_view/css/font-awesome.min.css" rel="stylesheet">	
	<!-- SCRIPTS -->
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<!--[if IE]><html class="ie" lang="en"> <![endif]-->
	<script src="<?php echo base_url();?>assets/front_view/js/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/jquery.nicescroll.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/superfish.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/jquery.flexslider-min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/owl.carousel.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/velocity.min.js"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/popup.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/front_view/js/myscript.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/core-min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/sha256-min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/validation.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>bankeauc/js/promise.min.js"></script>
	<script src="<?php echo base_url(); ?>bankeauc/js/sweetalert.min.js"></script>
    <script src="<?php echo base_url(); ?>bankeauc/js/sweetalert.core.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bankeauc/css/sweetalert.css">
	
		<?php
			if(isset($_GET['track'])){$track=$_GET['track'];}else{$track='';}
			if(isset($_GET['auctionID'])){$auctionID=$_GET['auctionID'];}else{$auctionID='';}
		?>
		<script type="text/javascript">
         $(document).ready(function(){
             $("select").change(function(){
                 $(this).find("option:selected").each(function(){
                     if($(this).attr("value")=="banker"){
                         $(".box").not(".banker").hide();
                         $(".banker").show();
                         $(".bidderBox").hide();
                         $('#username').val('');
                         
                     }           
                     else{
                         $(".box").hide();
                         $(".bidderBox").show();
                         $('#txtLoginID').val('');
                     }
                 });
             }).change();
         });
		</script>
      <!--[if lt IE 9]>
      <script type="text/javascript" src="assets/js/html5.js"></script>
      <![endif]-->
		<script type="text/javascript">
			$(document).ready(function(){
				$('.error1').css('display','none');
				$("#username").focus();
				$('.keysubmit').keypress(function (e) {
					if (e.which == 13) {
						validateloginform();
						return false;    //<---- Add this line
					}
				});
		
			<?php if($_SERVER['REQUEST_URI']=='/registration/banker_login'){  ?>   
				$("#ddlLogin").prop('value','banker');
			<?php } 
				if($_SERVER['REQUEST_URI']=='/registration/login'){
			?>   
				$("#ddlLogin").prop('value','owner');
			<?php } ?>
			$("#ddlLogin").change(function(){
				$("#username").focus();
				$(this).find("option:selected").each(function(){
				  if($(this).attr("value")=="banker"){
						$(".box").not(".banker").hide();
						$(".banker").show();
						//$(".forgotLink").hide();
					}           
					else{
						$(".box").hide();
						//$(".forgotLink").show();
					}
				});
				}).change();
				
				$("#login_submit_form").submit(function(){	
					var loginType = $(this).find("option:selected").val();				
					var pass = $("#password").val();
					var hash = CryptoJS.SHA256(pass);
					$("#password").val(hash);					
					
					if(loginType =='owner')
					{
						var ckUrl = "<?php echo base_url();?>registration/chk_login";
					}
					else
					{
						var ckUrl = "<?php echo base_url();?>registration/chk_banker_login";
					}
					
					var  formData = "user_name="+$("#username").val();						 
						 formData += "&user_id="+$("#txtLoginID").val();						 
						 formData += "&password="+$("[name=password]").val();			 
						 formData += "&submit1="+$("[name=submit1]").val();	
						 
						 var val =0;
						 $.ajax({
							url: ckUrl, // 
							type:"POST",
							data: formData,
							async: false,
							success:function(response)
							{	
								//alert(response);
								//return false;
								if(response==1)
								{
									$(".error1").css('display','block').html('<div class="flogout1"> You already have an active session;Force logout in existing session !! <a href=<?php echo base_url(); ?>registration/logout style="color:#000;font-weight:bold;">Force Logout</a> </div>');   
									return false;
								}									
								else if(response==2)
								{
									$(".error1").css('display','block').html('Your account is blocked!<br> Please contact administrator to unblock it.');   
									$("#password").val('');
									return false;
								}
								else if(response==3)
								{
									$(".error1").css('display','block').html('Invalid username or password..!');   
									$("#password").val('');
									return false;
								}
								else if(response==4)
								{
									$(".error1").css('display','block').html('Invalid username or password..!<br/>Account will be blocked after 5 failed attempt!');   
									$("#password").val('');
									return false;
								}
								else if(response==5)
								{
									$(".error1").css('display','block').html('Your account has been blocked!<br> Please contact administrator to unblock it.'); 
									$("#password").val('');  
									return false;
								}														
								else{	
									//alert(0);	
									val =1;					
									return true;									
								}
								
							}
							
							
						});
						if(val == 1)
						{
							return true;
						}
						
						return false;
					
				});

		});
		
		$(document).on('click','.cd-close',function(){
			$(".error1").css('display','none').html("");
			$("#username").val("");
			$("#txtLoginID").val("");
			$("#password").val("");
			
		});
		</script>

	<script type="text/javascript">
		function validateloginform(){
			
			 $(".error1").text("");
			 //$("#lblError").removeClass('error');
		   var usertype=$("#ddlLogin").val();
		   var userid=$("#txtLoginID").val();  
		   var username=$("#username").val();  
		   var password=$("#password").val();  
		   if(usertype=='owner')
		   {
			  if(username=='')
			  {
				  $(".error1").css('display','block').text("Please Enter Email ID");
				  //$("#lblError").addClass('error');
			  }
			  else
			  { 
				  if(password=='')
				  {
					  $(".error1").css('display','block').text("Please Enter Password"); 
					  //$("#lblError").addClass('error');
				  }
				  else
				  {
					$(".error1").css('display','none');  
					$("#login_submit_form").trigger("submit");  					
				  }    
			  }
		  } 
		  if(usertype=='banker'){
			  /*
			  if(username==''){
					$(".error1").css('display','block').text("Please Enter Email");
					//$("#lblError").addClass('error');
			  }
			  */
			  if(userid=='')
			  {
					$(".error1").css('display','block').text("Please Enter User ID"); 
					//$("#lblError").addClass('error');
			  }
			  else
			  { 
				  if(password=='')
				  {
					  $(".error1").css('display','block').text("Please Enter Password"); 
					  //$("#lblError").addClass('error');
				  }
				  else
				  {					
						$(".error1").css('display','none');  
						$("#login_submit_form").trigger("submit");  							
						  
				  }    
			  }
		  }
		}
		
	</script>	
	<style>
		.flogout1{padding:0 10px;font-size: 12px;-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;text-align: center;}
		/*.mlb{background: #1776ae !important;padding: 10px 15px !important;color: #ffffff !important;border-radius: 3px;}*/
	</style>
</head>
<!-- HEADER -->
		<header>
			
			<!-- MENU BLOCK -->
			<div class="menu_block">
			
				<!-- CONTAINER -->
				<div class="container clearfix">
					
					<!-- LOGO -->
					<div class="logo <?php echo (!MOBILE_VIEW)?'pull-left':'pull-right'; ?>">
						<a href="<?php echo base_url();?>" ><img src="<?php echo base_url();?>assets/front_view/images/logo.png"></a>
					</div><!-- //LOGO -->
					
					<!-- SEARCH FORM -->
					<!--
					<div id="search-form" class="pull-right">
						<form method="get" action="#">
							<input type="text" name="Search" value="Search" onFocus="if (this.value == 'Search') this.value = '';" onBlur="if (this.value == '') this.value = 'Search';" />
						</form>
					</div>
					-->
					<!-- SEARCH FORM -->
					
					<!-- MENU -->
					<div class="pull-right">
						<nav class="navmenu center">
						<?php 
						 //echo (int)MOBILE_VIEW;
						 if(MOBILE_VIEW)
						 {
						 ?>
						 <ul style="padding:0;">
							 <!--<li><a href="<?php echo base_url();?>home/mobile_notification?id=1"><span class="home-icon">&nbsp;</span>Notification</a></li>-->
							 <li><a href="<?php echo base_url();?>"><span class="home-icon">&nbsp;</span>Home</a></li>
							 <li>
								<a href="<?php echo base_url()?>registration/mobile_lgn"><span class="mlb login-icon">&nbsp;</span>Login</a>
							</li>
						 </ul>
						<?php  }
						else
						{
						?>	
							
						 <ul class="cd-pricing">
                              <li>
                                 <footer class="cd-pricing-footer">
									 
										<a href="#0" class="login_btn1">Login</a>
										
                                 </footer>
                              </li>
                           </ul>
                        <?php
						}
                        ?>
                           <div class="cd-form">
                              <form action="/registration/checklogintype" method="post" id="login_submit_form" autocomplete="off">
                                 <fieldset>
                                    <legend>Login</legend>
                                    <div class="half-width">
                                       <label for="userName">Login As</label>
                                       <select class="select minimal" name="login_as" id="ddlLogin">
                                          <option value="owner">Bidder</option>
                                          <option value="banker">Seller</option>
                                       </select>
                                    </div>
                                    <div class="half-width bidderBox">
                                       <label for="userEmail">Email</label>
                                       <!--<input type="email" id="userEmail" name="userEmail">-->
                                       <input type="text" class="keysubmit" name="user_name" id="username" title="Login ID" value="<?php if($this->session->userdata('session_found_emailid')) { echo $this->session->userdata('session_found_emailid');} ?>">
                                    </div>
                                    <div class="half-width  banker box">
                                       <label for="userid">User ID</label>
                                       <!--<input type="text" id="userid" name="userid">-->
                                        <input id="txtLoginID" class="keysubmit" name="user_id" id="user_id" type="text" title="User ID">
                                    </div>
                                    <div class="half-width">
                                       <label for="userPassword">Password</label>
                                       <!--<input type="password" id="userPassword" name="userPassword">-->
                                        <input type="hidden" name="track" value="<?php echo $track; ?>">
										<input type="hidden" name="auctionID" value="<?php echo $auctionID; ?>">
										<input type="password" class="keysubmit" name="password" title="Password" id="password">
                                    </div>
                                 </fieldset>
                                 <fieldset>
                                    <div>
									   <input type="hidden" value="LOGIN" name="submit1">                                       
                                       <!--<input type="submit" value="Login" onclick="validateloginform();">-->
                                       <a href="javascript:void(0);" class="a_submit" onclick="validateloginform();">Login</a>
                                    </div>
                                   <p style="float:right;margin:10px 0;" class="forgotLink"><a href="<?php echo base_url()?>registration/forgetpassword" class="forgot_pswd" style="color:#1776ae !important;">Forgot Password?</a></p>
                                    <span class="error1"></span>                                    
                                 </fieldset>
                              </form>
                              <a href="#0" class="cd-close"></a>
                           </div>
                           <div class="cd-overlay"></div>
							<ul class="nav navbar-nav navbar-right no-bdr">
                              <li><a href="<?php echo base_url();?>assets/front_view/images/bidder_manual.pdf" target="_blank"><span class="bidder-manual-icon">&nbsp;</span>Bidder Manual</a></li>
                              <?php if(!MOBILE_VIEW){ ?>
								<!--
                              <li><a href="<?php echo base_url();?>bankeauc/DSC_Browser_Plugin/c1-browser-plugin-setup.exe">Download DSC Plugin</a></li>                              -->
                              <?php }?>
                              <li><a href="<?php echo base_url();?>registration/signup"><span class="reg-icon">&nbsp;</span>Registration</a></li>
                              <!--<li><a href="<?php echo base_url();?>home/faqs"><span class="faq-icon">&nbsp;</span>FAQs</a></li>-->
                              <li><a href="<?php echo base_url();?>home/contactus"><span class="contact-icon">&nbsp;</span>Contact us</a></li>
                           </ul>
						</nav>
					</div><!-- //MENU -->
				</div><!-- //MENU BLOCK -->
			</div><!-- //CONTAINER -->
		</header><!-- //HEADER -->

	<?php 
	/*
	
         <ul id="menu1">
			<li><a href="<?php echo base_url();?>home/faqs">FAQs</a></li>
            <!--<li><a href="<?php echo base_url(); ?>images/bidder_user_guide.pdf" target="_blank">Bidder Guide</a></li>
            <li><a href="http://service.jaipurjda.org/eAuction/images/BRD2014.pdf" target="_blank">Business Rule</a></li>-->
            <li><a href="<?php echo base_url();?>home/archiveAuction">Archive Auction(s)</a></li>
            <!--<li><a href="<?php echo base_url(); ?>images/contact_us.pdf" target="_blank">Contact us</a></li>-->
			 <li><a href="<?php echo base_url();?>registration/signup">Registration</a></li> 
         </ul>
      </nav>
      <div style="clear:both"></div>
<?php */?>
