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
		  <?php echo ($error_msg)?$error_msg:'';?>
		  <?php echo ($sucess_msg)?$sucess_msg:'';?>
			
			
			<div class="forget_wrapper" id="forgotPassword">
				<form method="post" action="/registration/forgot_password_instanciate"  id="formValidateForgot" >
					<p>Forgot your Password? </p>
					<p style="font-size:14px;">Enter your Email Address here to receive a link to change password.</p>
					
					 <div class="row">
					  <input maxlength="100" name="email" placeholder="Enter Email Address*" type="text" class="input">
					</div>
					 <div class="row">
					  <input name="" value="send email" type="submit" class="b_get">
					</div>
				</form>
			</div>
			
          </div>
          <div class="or">OR</div>
          <div class="loginwith"> <a href="javascript:void(0)"  onclick="popup('<?php echo $login_url; ?>')" class="login_fb">Log in with Facebook</a> <a href="javascript:void(0)" class="login_gp" onclick="google_redirect()">Log in with Gmail</a> <a href="javascript:void(0)" class="login_yh">Log in with Yahoo</a> </div>
        </div>
        <div class="right">
          <div class="heading-bg"><img src="/images/login_user.png">New at Bank eAuctions?</div>
          <div class="content">
            <div class="row text-center">
              <input name="" value="sign up" type="button" class="b_get" onclick="location='/registration/signup'">
            </div>
            <div class="heading1">Why Join Bank eAuctions?</div>
            <ul>
              <li>Dummy content goes here. rem ipsum dolor sit amet, consectetur adipiscing elit. Duis porttitor.</li>
              <li>Dummy content goes here. rem ipsum dolor sit amet, consectetur adipiscing elit. Duis porttitor.</li>
              <li>Dummy content goes here. rem ipsum dolor sit amet, consectetur adipiscing elit. Duis porttitor.</li>
            </ul>
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
			email: "required",
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
