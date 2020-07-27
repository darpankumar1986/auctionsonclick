<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<section>
  <div class="breadcrum">
    <div class="wrapper"> <a href="/" class="Home">Home</a>&nbsp;»&nbsp;<span>Login</span> </div>
  </div>
  <div class="row">
    <div class="wrapper">
      <div class="login">
        <div class="left">
          <div class="heading1">User Login</div>
          <div class="login-box">
		  <div style="color:red;text-alight:center;">
		  <?php
		  echo $this->session->flashdata('error_msg');
		  ?>
		  <?php echo ($error_msg)?$error_msg:'';echo ($this->session->flashdata('msg'))?$this->session->flashdata('msg'):'';?>
		  </div>
			<form method="post" action="/registration/login"  id="formValidate">
				<div class="row">
				<input type="hidden" name="login_type" value="1">
				<!-- For bidder/owner-->
				</div>
				<div class="row">
				  <input maxlength="100" name="user_name" placeholder="Email Address*" type="text" class="input" value="<?php echo $_COOKIE['username']?>">
				</div>
				<div class="row">
				  <input maxlength="100" name="password" placeholder="Password*" type="password" class="input" value="<?php echo $_COOKIE['password']?>">
				</div>
				<input type="hidden" name="track" value="<?php echo $track; ?>">
				<input type="hidden" name="auctionID" value="<?php echo $auctionID; ?>">
				<div class="row">
				  <input name="remember_password" type="checkbox" value="">
				  Remember me </div>
				<div class="row term"> <a href="javascript:void(0)" onclick="jQuery('#formValidate').hide();jQuery('#forgotPassword').show();">Forgot Password</a> |  
				<a href="/registration/banker_login" >Login With Bank User</a> 
				</div>
				<div class="row">
				  <input name="submit" value="LOGIN" type="submit" class="b_loginb">
				</div>
				<div class="row term"> <a href="/terms-of-use">Terms of services </a> and <a href="/privacy-policy">Privacy policy</a> </div>
                                <?php if(!empty($redirectData)) {?>
                                <input type='hidden' id='redirect_link' name='redirect_link' value='<?php echo  $_SERVER['HTTP_REFERER']; ?>' />
                                <?php }?>
			</form>
			
			<div class="forget_wrapper" style="display:none" id="forgotPassword">
			<form method="post" action=""  id="formValidateForgot" name="formValidateForgot" >
				<p>Forgot your Password1? </p>
				<p style="color:red;" id="forgot_email"></p>
				<div class="row">
				  <input maxlength="100" name="forgotemail" id="forgotemail" placeholder="Enter Email Address*" type="text" class="input">
				</div>
				 <div class="row">
				 <input name="" value="send email" onclick="submitForgotPassword('bidder');" type="button" class="b_get">
				</div>
			</form>
			</div>
			
          </div>
          <div class="or">OR</div>
          <div class="loginwith"> <a href="javascript:void(0)"  onclick="popup('<?php echo $login_url; ?>')" class="login_fb">Log in with Facebook</a> <a href="javascript:void(0)" class="login_gp" onclick="google_redirect()">Log in with Gmail</a> <!--<a href="javascript:void(0)" class="login_yh">Log in with Yahoo</a>-->
		  </div>
        </div>
        <style>
			 .bank_login_bg{width:260px; float:left; margin:15px 0 25px 20px; border:solid 1px #ccc; border-radius:5px; background: #e2e2e2;  }
			 .bank_login_heading{width:100%; float:left; background:#454545; font-size:19px; color:#fff; padding:10px 0; border-top-left-radius:3px; border-top-right-radius:3px; text-align:center;}
			 .bank_login_field{width:86%!important; margin:10px 0 0 5%!important; border:solid 1px #CCC!important; font-size:12px!important; padding:7px 2%!important; border-radius:3px!important;}
			 .bank_login_btn{width:90%; float:left; text-align:right; padding:15px 12px;}
		</style> 
		<div class="right" style="border-left:solid 1px #ccc;width:299px;">
			  <div class="bank_login_bg">
				  <div class="bank_login_heading">Banker Login</div>
				  <input type="text" placeholder="E-Mail ID" class="bank_login_field">
				  <input type="text" placeholder="User ID" class="bank_login_field">
				  <input type="text" placeholder="Password" class="bank_login_field">
				  <div class="bank_login_btn"><a href="#"><img src="<?php echo base_url(); ?>images/small_login.jpg"></a></div>
			  </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
function google_redirect() {
	window.location = "/registration/login_via_google";
}
function popup(url) {
newwindow=window.open(url,'name','height=700,width=900');
if (window.focus) {newwindow.focus()}
return false;
}
jQuery("#formValidate").validate({
		rules: {
			user_name: "required",
			password: "required"
			
		},
		messages: {
			email: "Please enter email address.",			
			password: "Please enter password."
		}
	});
	jQuery("#formValidateForgot").validate({
		rules: {
			email: "required"
			
		},
		messages: {
			email: "Please enter email address."
		}
	});
</script>
