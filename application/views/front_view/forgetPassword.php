<script src="<?php echo base_url(); ?>js/jquery.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<style>
.error2
{
	color: #e83c3c;
	font-size: 13px;
	margin-left: 14px;
	display: block;
}
</style>
	<div class="container-fluid container_margin">
            <div class="row">
                <div class="col-sm-12">
                   <div class="login_page">
                      <div class="login_inner_page">
                       <ul class="nav nav-tabs">
                           <li class="active"><a data-toggle="tab" href="#Forgotyourpassword">Forgot your Password?</a></li>
                       </ul>
				
                       <div class="tab-content">
							
                           <div id="Login" class="tab-pane fade in active">
								
							   <form class="custom_form" action="<?php echo base_url()?>registration/sendrandomlink" method="post" id="formValidateForgot" name="formValidateForgot" autocomplete="off">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />										
                                   <div class="floating-form">
                                       <div class="floating-label">
											<input name="forgotemail" maxlength="100" id="forgotemail"  type="text" class="floating-input input alphanumericemail" placeholder=" "/>                             			   
                                           <label class="custom_label">Email ID</label>
										   <span id="forgot_email" class="error2"></span>
                                       </div>
                                       <div class="floating-label">											 
										   <input class="floating-input floating-float" maxlength="6" name="fp_captcha" id="fp_captcha" type="text" value="" placeholder=" ">
										  
                                           <label class="custom_label">Enter the code here</label>
										   <div id="captcha_cont" style="float:right;">
												<?php echo $fp_captcha['image']; ?>
											</div>
                                 		   <span  class="field-signupform-captcha help-block-error error2"></span>      
                                       </div>
                                   </div>
                                  
                                   <button type="button" class="btn btn-default login_btn" name="" onclick="submitForgotPassword('bidder');" style="margin-top: -8px;">Send Email</button>

								   <div class="success_msg error1" style="padding-left:15px;color: #000 !important;background-color:#f78d8d; clear:both;width: 100%;clear: both; margin-bottom: 20px;">
										<?php echo $this->session->flashdata('error'); ?>
									</div>
									<div class="success_msg" style="width: 100%;">
										<?php echo $this->session->flashdata('msg'); ?>
									</div>
							   </form>
                           </div>
                       </div>
                       </div>
                    </div><!--login_page-->
                </div>
            </div><!--row-->

        </div><!--container-fluid-->
		<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>