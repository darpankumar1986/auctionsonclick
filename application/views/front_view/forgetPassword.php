<script src="/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>
<style>
	footer {
    margin-top: 150px;
}
</style>
<section id="body_wrapper">
	<div class="body_main">
			<div class="container_12">
				<div class="container_12">
					<div id="forgotPassword" class="forget_wrapper">
						<form id="formValidateForgot" name="formValidateForgot" action="<?php echo base_url()?>registration/sendrandomlink" method="post" autocomplete="off">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
						<div class="box-heading">
						   Forgot your Password?
						</div>
						<div class="success_msg">
							<?php echo $this->session->flashdata('msg'); ?>
						</div>
						<div class="success_msg" style="padding-left:15px;color: #000 !important;background-color:#f78d8d; clear:both;width: 98%;">
							<?php echo $this->session->flashdata('error'); ?>
						</div>	
						<div class="box-content-details">
						<div class="full">						
							<div class="half-2">
								<div class="row">
									<div class="lft_heading">Enter User ID / Email Address<span class="red"> *</span></div>
									<div class="rgt_detail">
										<input name="forgotemail" maxlength="100" id="forgotemail"  type="text" class="input alphanumericemail" />
										<div class="tooltips">
											<img class="tooltip_icon" src="/images/help.png">
											<span>When you fill in your User ID / Email Address, we will be send instructions on how to reset your password. </span>
										</div>
										 <span id="forgot_email" class="error2"></span>
									</div>
								</div>
							</div>	
						</div>
						<div class="half-2">
							 <div class="row captcha">
								<div class="lft_heading">Validation code </div>
								<div class="rgt_detail">
									<div id="captcha_cont">
										<?php echo $fp_captcha['image']; ?>
									</div>
									<br/><strong>Enter the code above here </strong> <br/>
									<input  maxlength="6" name="fp_captcha" id="fp_captcha" type="text" value=""> 
									<span  class="field-signupform-captcha help-block-error error2"></span>                             
								</div>
							</div>
						</div>
						<div class="full">
						  <div class="half-2">
							 <div class="row">
								<div class="lft_heading">&nbsp;</div>
								<div class="rgt_detail"><input class="login_btn1" type="button" onclick="submitForgotPassword('bidder');" value="Send Email" name=""></div>
							 </div>
						  </div>
					   </div>
						
						</form>
					</div>
			</div>
		</div>
	</div>
</section>
