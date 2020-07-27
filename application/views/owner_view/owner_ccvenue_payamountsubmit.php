<?php 
$productid	=	$prows->id;
$bank_id	=	$erows->bank_id;
$branch_id	=	$erows->branch_id;
$drt_id	=	$erows->drt_id;
$closeBidderAuctionRows=$this->banker_model->getAllCloseAuctionBidder($auctionID);
//echo "<pre>";
//print_r($prows);
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
				
			 	<div id="tab-pannel6" class="btmrgn">
				
					<div class="tab_container6"> 
					<!---- buy tab container start ---->
					<div id="tab1" class="tab_content6" style="display:block">
						<div id="tab-pannel3" class="btmrgn">
						
							<div class="tab_container3 whitebg"> 
								<!-- Sell > My Activity start -->
						  <div id="tab10" class="tab_content3">
							<div class="container">
							
							<div class="secttion-right">
								<h3 class="btmrg20"><?php echo $heading?></h3>
								<div class="table-wrapper btmrg20">
							<div class="table-section"> 
										
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
//echo "<input type=hidden name=command value=$command>";
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>

<script language='javascript'>document.redirect.submit();</script>
				
				
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



<script>
	/*
	function paynow(productID)
	{
		jQuery.ajax({
			url: '/owner/payment/',
			type: 'POST',
			data: {
				productID: productID
			},
			success: function(data) {
				window.location.href = '/owner/paymentsuccess/'+productID;
			}
		});
	}
	function savePropertyAuction(productID)
	{
		jQuery.ajax({
			url: '/owner/savePropertyAuction/',
			type: 'POST',
			data: {
				productID: productID
			},
			success: function(data) {
				
				window.location.href = '/owner/paymentsuccess/'+productID;
			}
		});
	}
	
	*/
	
	
	//tooltip
	jQuery(function() {
		jQuery('.help-icon').tooltip();
	});
</script>