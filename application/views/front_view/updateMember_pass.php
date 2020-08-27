<script src="<?php echo base_url(); ?>js/jquery.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
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
                           <li class="active"><a data-toggle="tab" href="#ResetPassword">Reset Password</a></li>
                       </ul>
				
                       <div class="tab-content">
							
                           <div id="Login" class="tab-pane fade in active">
								
							   <form class="custom_form" id="resetPassword" name="resetPassword" action="<?php echo base_url()?>registration/updateMemberPassword" method="post" autocomplete="off">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />										
                                   <div class="floating-form">
                                       <div class="floating-label">
											<input type="hidden" name="randomNum" value="<?php echo $_GET['c'];?>" />										
											<input type="password" name="newpassword" id = "newpassword" placeholder=" " class="input floating-input" tabindex="1" value=""/>
                                           <label class="custom_label">New Password</label>
										   <span id="newpassword_err" class="field-signupform-password error2"></span>
                                       </div>
									   <div class="floating-label">
											<input type="password" name="re_password" id = "re_password" placeholder=" " class="input floating-input" tabindex="2" value=""/>
                                           <label class="custom_label">Confirm Password</label>
										   <span id="re_password_err" class="field-signupform-cpassword error2"></span>
                                       </div>
                                       
                                   </div>
                                  
                                   <button type="button" class="btn btn-default login_btn" name="" onclick="submitResetPassword('bidder');" style="margin-top: -8px;">Save</button>

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