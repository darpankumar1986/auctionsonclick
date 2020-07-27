<?php 
//echo "<pre>";
//print_r($user_data);
//echo "</pre>";
?>
<link rel="stylesheet" href="<?php echo base_url()?>/css/colorbox.css" />
<script src="<?php echo base_url()?>/js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script src="/js/jquery.colorbox.js"></script>
<script>
	jQuery(document).ready(function(){
		//Examples of how to assign the Colorbox event to elements
		jQuery(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
		//Example of preserving a JavaScript event for inline calls.
		jQuery("#click").click(function(){ 
			jQuery('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
	});
</script>
<section>

<section>
	<?php echo $breadcrumb;?>
	
	
	<div class="row">
		<div class="wrapper-full">
			<div class="dashboard-wrapper">
				<div class="search-row">
					<div class="srch_wrp">
						<input type="text" value="Search" id="search" name="search">
						<span class="ser_icon"></span> 
					</div>
					<a href="#">Advance Search+</a> 
				</div>
			 	<div id="tab-pannel6" class="btmrgn">
					<ul class="tabs6">
						<a href="/owner"><li rel="tab1">Buy</li></a>
						<a href="/owner/sell"><li class="active"  rel="tab2">Sell</li></a>
					</ul>
					<div class="tab_container6"> 
					<!---- buy tab container start ---->
					<div id="tab1" class="tab_content6" style="display:block">
						<div id="tab-pannel3" class="btmrgn">
							<ul class="tabs3">
								<a href="/owner/sell"><li  rel="tab9">My Summary</li></a>
								<a href="/owner/liveAuction"><li class="active" rel="tab10">My Activity</li></a>
								<a href="/owner/myMessage?type=sell"><li rel="tab11">My Message</li></a>
								<a href="/owner/myProfile?type=sell"><li rel="tab12">My Profile</li></a>
							</ul>
							<div class="tab_container3 whitebg"> 
								<!-- Sell > My Activity start -->
						  <div id="tab10" class="tab_content3">
							<div class="container">
							  <div class="secttion-left">
								<div class="left-widget">
								  <div id="cssmenu">
									<?php echo $leftsidebar;?>
								  </div>
								</div>
							  </div>
							<div class="secttion-right">
								<h3 class="btmrg20"><?php echo $heading?></h3>
								<div class="table-wrapper btmrg20">
							<div class="table-section"> 
							<div id="error" style="color:red;">
								<?php if(isset($this->session->userdata['flash:old:message'])){?>
								<div  style="color:red;text-align:center;"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
								<?php } ?>
							</div>					
				<form method="post" enctype="multipart/form-data" name="postsellerpayment" id="postsellerpayment" action="/owner/ccavRequestHandler">
				
				<div class="form">
					<h2><?php echo $msg;?></h2>
				
				</div>
					</form>
							</div>
						  </div>
							 </div>
							</div>
						  </div>
						  <!-- Sell > My Activity end -->                  
						</div>
					  </div>
					</div>
					<!---- Sell tab container end ----> 
				  </div>
				</div>
			</div>
		</div>
	</div>
</section>


<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<script>
	jQuery(document).ready(function(){
	jQuery("#postsellerpayment").validate({
		rules: {
			amount: "required",
			order_id: "required",
			billing_name: "required"
			
		},
		messages: {
			amount:  "Please enter amount",			
			order_id:  "Please enter order id",			
			billing_name:  "Please enter name"			
		}
	});
});

</script>