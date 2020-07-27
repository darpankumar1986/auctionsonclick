<script src="/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>
<style>
	footer {
    margin-top: 250px;
}
</style>
<section id="body_wrapper">
	<div class="body_main">
			<div class="container_12">
				<div class="container_12">
					<div id="forgotPassword" class="forget_wrapper">						
						<div class="box-heading">
						   Password Reset Success
						</div>		
						<div class="success_msg">
							<?php echo $this->session->flashdata('msg'); ?>
						</div>
						<div class="success_msg" style="padding-left:15px;color: #000 !important;background-color:#f78d8d; clear:both;width: 98%;">
							<?php echo $this->session->flashdata('error'); ?>
						</div>				
					</div>
			</div>
		</div>
	</div>
</section>
