<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login Page</title>
        <?php
        if ($_GET['track']) {
            $track = $_GET['track'];
        }
        if ($_GET['auctionID']) {
            $auctionID = $_GET['auctionID'];
        }
        
        ?>
        <?php $this->load->helper('url'); ?>
        <?php define('VIEWBASE', site_url() . 'application/views/admin/'); ?>
        
         <link rel="stylesheet" href="<?php echo site_url(); ?>css/bidderlogin/login.css" type="text/css" />
        
        <?php /* ?><link rel="stylesheet" href="<?php echo VIEWBASE; ?>css/style.default.css" type="text/css" /><?php */ ?>
        <script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery-1.7.min.js"></script>
        <script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.cookie.js"></script>
        <script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.uniform.min.js"></script>

        <script type="text/javascript">
            function checksubmit() {
                chkstatus = 0;
                $(".error").html('');
                if ($("#username").val() == '') {
                    $(".error").append("Please enter user name<br/>");
                    chkstatus = 1;
                }
                if ($("#password").val() == '') {
                    $(".error").append("Please enter password");
                    chkstatus = 1;
                }
                 if (chkstatus == 1) {
                    return false;
                } else {
					var pass = $("#password").val();
					var hash = CryptoJS.SHA256(pass);
					$("#password").val(hash);
                    return true;
                }
            }

        </script>
        <!--[if IE 9]>
            <link rel="stylesheet" media="screen" href="<?php echo VIEWBASE; ?>css/style.ie9.css"/>
        <![endif]-->
        <!--[if IE 8]>
            <link rel="stylesheet" media="screen" href="<?php echo VIEWBASE; ?>css/style.ie8.css"/>
        <![endif]-->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->
        <style>
          /* body{font-family:Arial, Helvetica, sans-serif; font-size:12px; background:#666;}
            .bank_login_bg{width:100%; float:left; margin:15px 0 25px 0;  border-radius:5px; background: #e2e2e2;  }
            .bank_login_heading{width:100%; float:left; background:#454545; font-size:19px; color:#fff; padding:10px 0; border-top-left-radius:3px; border-top-right-radius:3px; text-align:center;}
            .bank_login_field{width:86%!important; margin:10px 0 0 5%!important; border:solid 1px #CCC!important; font-size:12px!important; padding:10px 2%!important; border-radius:3px!important;}
            .bank_login_btn{width:90%; float:left; text-align:right; padding:15px 12px;}
            .center{width:350px; margin:10% auto;}
            .logo{width:100%; text-align:center; padding:10px 0;}
            .error{font-size:12px; font-weight:bold; color:#f00; line-height:30px; padding-left:20px;}
            .btn{width:99px; height:30px; text-align:right; background:url(images/small_login.jpg) no-repeat; border:none; float:right; margin:15px 15px; outline:none; cursor:pointer;  }*/
        </style> 
        <style>
			.flogout1{padding: 20px;border: 1px solid red;background-color: #f78d8d;border: 1px solid #f78d8d;font-size: 12px;
					 -moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;text-align: center;font-weight:bold;}
		</style>
    </head>


<body>
<script src="<?php echo base_url();?>js/core-min.js" type="text/javascript"></script>
	  <script src="<?php echo base_url();?>js/sha256-min.js" type="text/javascript"></script>
	<!------------------header start---------------------->
     <div class="orange_line">&nbsp;</div>
    	<div class="headerplain">
       		 <div class="logo"><img src="<?php echo base_url(); ?>bankeauc/assets/img/logo.png" class="logo-img"></a>
								<div class="logo-text"><?php echo BRAND_NAME; ?></div></div>
          		  <?php 
					if (isset($_GET['bu']) && $_GET['bu']!='') {
						$bankURL = $_GET['bu'];
					
				?>
          		  <a href="<?= base_url(); ?><?php echo $bankURL; ?>" class="login_rgt">Login</a> 
          		  <?php } else { ?>
          		  <a href="<?= base_url(); ?>registration/login" class="login_rgt">Login</a>
          		  <?php } ?>
					   
					  
   			 </div>
   		
 	<!------------------header end---------------------->
    
   
   <!------------------login wrapper start---------------------->
    <div class="login_wrapper">
        <div class="validate error"><?php echo $error_msg; ?></div>
        <div class="lg-body">
                <div id="lg-head">
                    <p>Please login.</p>
                    <div class="separator">&nbsp;</div>
                </div>
                
				<div class="login"><!------------------login start---------------------->
				 <form id="login" action="" onsubmit="return  checksubmit();" method="POST" name="process" >
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
						<ul>
							<li id="usr-field">
								
								<input type="text" name="user_name" title="Login ID" placeholder="Please Enter User name" id="username" class="input" value="<?php if($this->session->userdata('session_found_emailid')) { echo $this->session->userdata('session_found_emailid');} ?>" />
                                <?php /* ?><input type="hidden" name="track" class="" value="<?php echo $track; ?>" />
                                <input type="hidden" name="auctionID" class="" value="<?php echo $auctionID; ?>" /><?php */ ?>
                                
                                
								<span id="usr-field-icon"></span>
							</li>
							<li id="psw-field">
								 <input type="password" name="password" class="input" placeholder="Please Enter Password" id="password" value="<?php echo $_COOKIE['user_pass'] ?>" />
								<span id="psw-field-icon"></span>
							</li>
							<li class="checkbox">
								<!--<input type="checkbox"  value="remember">
								<label for="remember-me" class="checkbox-text">Remember Me</label>-->
							</li>
							<li>
								<button type="submit" class="button" name="submit1" value="LOGIN">Login</button>
							</li>
					   </ul>
				</form>
								<span id="lost-psw"><a href="<?php echo $base_url; ?>forgetpassword">Forgot password</a> </span>
								</br>
								</br>
								<span id="lost-psw" style="float:left;"> <a href="<?php echo $base_url; ?>signup">New Registration</a></span>
			  </div><!------------------login end---------------------->
       </div><!------------------lg-body end---------------------->
  </div> <!------------------login wrapper end---------------------->
</body>

<div style="clear:both"></div>
		<?php if($this->session->flashdata('session_id_found')) { ?>
		<div class="flogout1"> You already have an active session; please open a new browser with new session or force logout in existing session !!<a href='<?php echo base_url(); ?>registration/logout'>Force Logout</a> </div> <?php }else{echo '';} ?>
</html>
