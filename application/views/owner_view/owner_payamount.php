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
				
				<!--
					 <dl>
						<dt class="required">
						  <label>Order Id </label>
						</dt>
						<dd>
						  <input name="order_id" id="order_id" type="text" value="" class="input">
						  </dd>
					</dl>
				-->
					<dl>
						<dt class="required">
						  <label>Amount </label>
						</dt>
						<dd>
						   <input readonly name="amount" id="amount" type="text" value="<?php echo $auction_fees;?>" class="input">
						  </dd>
					</dl>
					
					<div class="seprator btmrg20"></div>
					
					<h4>Billing information:</h4>
					<dl>
						<dt>
						  <label>Billing Name :</label>
						</dt>
						<dd>
						   <input name="billing_name" id="billing_name" value="<?php echo $user_data->first_name;?> <?php echo $user_data->last_name;?>" type="text" class="input">
						   </dd>
					</dl>
					
					<dl>
						<dt >
						  <label>Billing Address :</label>
						</dt>
						<dd>
						   <input name="billing_address" id="billing_address" type="text" value="<?php echo $user_data->address1;?>" class="input">
						  </dd>
					</dl>
					<dl>
						<dt>
						  <label>Billing City :</label>
						</dt>
						<dd> 
						   <input name="billing_city" id="billing_city" type="text" value="<?php echo GetTitleByField('tbl_city','id='.$user_data->city_id,'city_name');?>" class="input">
						  </dd>
					</dl>
						<dl>
						<dt>
						  <label>Billing State	:</label>
						</dt>
						<dd>
						   <input name="billing_state" id="billing_state" type="text" value="<?php echo GetTitleByField('tbl_state','id='.$user_data->state_id,'state_name');?>" class="input">
						  </dd>
					</dl>
							<dl>
						<dt>
						  <label>Billing Zip	:</label>
						</dt>
						<dd>
						   <input name="billing_zip" id="billing_zip" type="text" value="<?php echo $user_data->zip;?>" class="input">
						  </dd>
					</dl>
					
					<dl>
						<dt>
						  <label>Billing Country	:</label>
						</dt>
						<dd>
						   <input name="billing_country" id="billing_country" type="text" value="<?php echo GetTitleByField('tbl_country','id='.$user_data->country_id,'country_name');?>" class="input">
						  </dd>
					</dl>
					<dl>
						<dt>
						  <label>Billing Tel	:</label>
						</dt>
						<dd>
						   <input name="billing_tel" id="billing_tel" type="text" value="<?php echo $user_data->mobile_no;?>" class="input">
						  </dd>
					</dl>
					<dl>
						<dt>
						  <label>Billing Email	:</label>
						</dt>
						<dd>
						   <input name="billing_email" id="billing_email" type="text" value="<?php echo $user_data->email_id;?>" class="input">
						  </dd>
					</dl>
					<div class="seprator btmrg20"></div>
				
					
					  <div class="seprator btmrg20"></div> 
						<div class="button-row">
						<a href="/owner/createAuction/<?php echo $propertyID?>">
						<input name="Back" value="Back" type="button" class="b_submit"> </a>
						
					<input type="hidden" name="auctionID" value="<?php echo $auctionID;?>">
					<input type="hidden" name="productID" value="<?php echo $propertyID;?>">
					<input type="hidden" name="payment_type" value="auction fee">
					<input name="payment" value="Pay Now" type="submit" class="b_submit">
								<!--
								<a href="javascript:void(0);" onclick="return savePropertyAuction(<?php echo $propertyID;?>);"><input name="save" value="Save" type="button" class="b_submit"> </a>
								<a href="javascript:void(0);" onclick="return paynow(<?php echo $propertyID;?>);"><input name="Back" value="Pay Now" type="button" class="b_submit"> </a>
								-->
							</div>

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
