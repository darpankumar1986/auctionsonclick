<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Admin :: <?php echo isset($heading)?$heading:"Dashboard"; ?></title>
<?php $this->load->helper('url');?>
<?php define('VIEWBASE',site_url().'application/views/admin/'); ?>

<!--<link rel="stylesheet" href="<?php echo VIEWBASE; ?>css/style.default.css" type="text/css" />-->
<link href="<?php echo VIEWBASE; ?>css/dt_common.css" rel="stylesheet" type="text/css">
<link href="<?php echo VIEWBASE; ?>css/dt_responsive.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo VIEWBASE; ?>css/dt_tables.css">
<script type="text/javascript" src="<?php echo base_url(); ?>bankeauc/js/sortable.js"></script>
<script src="<?php echo base_url(); ?>bankeauc/js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>bankeauc/js/global.js" type="text/javascript"></script>



<link rel="stylesheet" href="<?php echo base_url(); ?>css/nav.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/banner.css">

<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>js/common.js"></script>


<body>
<header>
<!--============================header==================================-->

		<section class="header_wrapper">
						<div class="header_top">
								<div class="logo"><a href="<?php echo base_url().'admin/home'?>"><img src="<?php echo VIEWBASE; ?>images/logo.png" width="192" height="60" alt="Bank eauctions"></a></div>
								<div class="header_right">
										<ul>
												<!--<li><a href="">About us</a></li>-->
												<li><a href="<?=base_url();?>faq.html" target="_blank">FAQs</a></li>
												<!--<li><a href="">Help Desk</a></li>-->
												<li><a href="<?=base_url();?>contactus.html" target="_blank">Contact Us</a></li>
												<li><a href="<?php echo base_url().'admin/logout'?>">Logout</a></li>
												
										</ul>
										
								</div>
						</div>
						<!--============================login end==================================-->
				</section>
</header>
<div class="box-head1 no_border">
	<div class="container_12">
		<h2>Welcome, <?php echo ucfirst($this->session->userdata('aname')); ?></h2>
		<span class="flt_rgt">
			<a href="<?php echo base_url().'admin/home'?>"><h2>Dashboard</h2></a>
		</span>
	</div>
</div>
