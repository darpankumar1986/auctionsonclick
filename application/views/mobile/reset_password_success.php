<style>
	footer {
    margin-top: 150px;
	}

@media screen and (max-width: 530px) {
.body_main{width:97%; margin:0 auto !important; float:none;}
.login_btn1 {    width: 90% !important;}
.half-2{background:#fff;}
.box-content-details select, .box-content-details input{border-top:none;border-left:none;border-right:none;font-size:14px;border-radius:0px;}
.box-content-details select:focus, .box-content-details input:focus{border-top:none;border-left:none;border-right:none;border-bottom: 1px solid #1776ae;}
.captcha img{width: 150px !important;}
/*.login_btn1{background: #f24b1e !important;
padding: 10px 15px !important;
color: #ffffff !important; width:auto !important;}*/
a, input, select, textarea {    vertical-align: baseline;}
    
</style>
<link href="<?= base_url(); ?>assets/front_view/css/custom.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>bankeauc/css/responsive.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>
<section id="body_wrapper">
	<div class="body_main">
			<div class="">
				<div class="">
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
