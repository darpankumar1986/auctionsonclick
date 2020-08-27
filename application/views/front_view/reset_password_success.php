<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>
<style>
	footer {
    margin-top: 250px;
}
</style>

<div class="container-fluid container_margin">
            <div class="row">
                <div class="col-sm-12">
                   <div class="login_page">
                      <div class="login_inner_page">
                       <ul class="nav nav-tabs">
                           <li class="active"><a data-toggle="tab" href="#PasswordResetSuccess">Password Reset Success</a></li>
                       </ul>
				
                       <div class="tab-content">
							
                           <div id="Login" class="tab-pane fade in active">
		
								

								   <div class="success_msg error1" style="padding-left:15px;color: #000 !important;background-color:#f78d8d; clear:both;width: 100%;clear: both; margin-bottom: 20px;">
										<?php echo $this->session->flashdata('error'); ?>
									</div>
									<div class="success_msg" style="width: 100%;">
										<?php echo $this->session->flashdata('msg'); ?>
									</div>
                           </div>
                       </div>
                       </div>
                    </div><!--login_page-->
                </div>
            </div><!--row-->

        </div><!--container-fluid-->
		<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>