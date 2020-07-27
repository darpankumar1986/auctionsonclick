<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Login Page</title>
<?php $this->load->helper('url');?>
<?php define('VIEWBASE',site_url().'application/views/superadmin/'); ?>

<link rel="stylesheet" href="<?php echo site_url(); ?>css/bidderlogin/login.css" type="text/css" />

<?php /* ?><link rel="stylesheet" href="<?php echo VIEWBASE; ?>css/style.default.css" type="text/css" /><?php */ ?>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/general.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/index.js"></script>
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
	 
 body{font-family:Arial, Helvetica, sans-serif; font-size:12px; background:#fff;}
 .bank_login_bg{width:100%; float:left; margin:15px 0 25px 0;  border-radius:5px; background: #e2e2e2;  }
 .bank_login_heading{width:100%; float:left; background:#454545; font-size:19px; color:#fff; padding:10px 0; border-top-left-radius:3px; border-top-right-radius:3px; text-align:center;}
 .bank_login_field{width:86%!important; margin:10px 0 0 5%!important; border:solid 1px #CCC!important; font-size:12px!important; padding:10px 2%!important; border-radius:3px!important;}
 .bank_login_btn{width:90%; float:left; text-align:right; padding:15px 12px;}
 .center{width:350px; margin:10% auto;}
 .logo{width:100%; text-align:center; }
 .error{font-size:12px; font-weight:bold; color:#f00; line-height:30px; padding-left:20px;}
 .btn{width:99px; height:30px; text-align:right; background:url(images/small_login.jpg) no-repeat; border:none; float:right; margin:15px 15px; outline:none; cursor:pointer;  }
 </style> 
</head>


<body>

	<!------------------header start---------------------->
     <div class="orange_line">&nbsp;</div>
    	<div class="headerplain">
       		 <div class="logo"><img src="<?php echo base_url();?>assets/front_view/images/<?php echo SITE_LOGO; ?>">
   		</div>
   		
 	<!------------------header end---------------------->
    
   
   <!------------------login wrapper start---------------------->
    <div class="login_wrapper">
        <div class="validate error"><?php echo $msg;?></div>
        <div class="lg-body">
                <div id="lg-head">
                    <p>Please login.</p>
                    <div class="separator">&nbsp;</div>
                </div>
				<div class="login"><!------------------login start---------------------->
					<form id="login" action="<?php echo base_url();?>superadmin/login/process" method="POST" name="process" >
						<ul>
							<li id="usr-field">
								<input type="text" name="user_email" id="username" class="input" value="<?php echo $_COOKIE['user_email']?>" />
								<span id="usr-field-icon"></span></li>
							<li id="psw-field">
								<input type="password" name="user_pass" id="password" class="input" value="<?php echo $_COOKIE['user_pass']?>" />
								<span id="psw-field-icon"></span></li>
							<li>

								<button class="button" onclick="document.process.submit()">LOGIN</button>
							</li>
					   </ul>
					</form>
			  </div><!------------------login end---------------------->
       </div><!------------------lg-body end---------------------->
  </div> <!------------------login wrapper end---------------------->
</body>

<?php /* ?>
<body class="loginpage">		 
	<div class="center">	 
		<div class="logo">
					<img src="<?php echo VIEWBASE; ?>images/logo.png">
		</div>
		<div class="loginbox">
			
			<div class="loginboxinner">
                            <div class="error"><?php echo $msg;?></div>
				<div class="" style="font-size:18px;">Login</div>
				<div class="nousername">
					<div class="loginmsg">The password you entered is incorrect.</div>
				</div><!--nousername-->
				
				<div class="nopassword">
					<div class="loginmsg">The password you entered is incorrect.</div>
					<div class="loginf">
						<div class="thumb"><img alt="" src="<?php echo VIEWBASE; ?>images/thumbs/avatar1.png" /></div>
						<div class="userlogged">
							<h4></h4>
							<a href="index.html">Not <span></span>?</a> 
						</div>
					</div><!--loginf-->
				</div><!--nopassword-->
			   
				<form id="login" action="<?php echo base_url();?>superadmin/login/process" method="POST" name="process" >
					
					<div class="username">
						<div class="usernameinner">
							<input type="text" name="user_email" id="username" class="" value="<?php echo $_COOKIE['user_email']?>" />
						</div>
					</div>
					
					<div class="password">
						<div class="passwordinner">
							<input type="password" name="user_pass" id="password" value="<?php echo $_COOKIE['user_pass']?>" />
						</div>
					</div>
					
					<!--<button onclick="document.process.submit()">Sign In</button>-->
				
				</form>
				
			</div><!--loginboxinner-->
		</div><!--loginbox-->

	</div>
</body>
<?php */ ?>
</html>
