<link rel="stylesheet" href="<?php echo base_url(); ?>bankeauc/css/tables.css" type="text/css" media="screen"/>	
<script	src="/bankeauc/DSC_Browser_Plugin/js/resources/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css" />
<script src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>
<script	src="<?php echo base_url(); ?>js/dsc.js"></script>
<div style='display:none'>
	<div id="form_bg" class="form_bg">
		<div class="grid_border">
			<div class="datagrid">
				<table id="certlist" class="display" class="cell-border wid_60">
					<thead >
						<tr>
						<th style="max-width:30%">AliasName</th>
						<th style="max-width:30%">IssuedBy</th>
						<th style="max-width:10%">SerialNo</th>
						<th style="max-width:5%">ExpDate</th>
						<th style="max-width:25%">IssuerDetail</th>
						</tr>
					</thead>
				</table>
				<input id="check_dsc_auctionID" type="hidden" value="" />
				<div class="row-custom"><button id="button" onclick="checkDSC(<?php echo $auction_data[0]->id; ?>);" class="btn">select certificate</button></div>
			</div>
		</div>
	</div>
</div>
<div style='display:none'>
	<div id="form_bg_ac" class="form_bg">
		<div class="grid_border">
			<div class="datagrid">
				<table id="certlist_ac" class="display" class="cell-border wid_60">
					<thead >
						<tr>
						<th style="max-width:30%">AliasName</th>
						<th style="max-width:30%">IssuedBy</th>
						<th style="max-width:10%">SerialNo</th>
						<th style="max-width:5%">ExpDate</th>
						<th style="max-width:25%">IssuerDetail</th>
						</tr>
					</thead>
				</table>
				<input id="check_dsc_auctionID_ac" type="hidden" value="<?php echo $auction_data[0]->id; ?>" />
				<div class="row-custom"><button id="button" onclick="CheckvalidNewDSC();" class="btn">select certificate</button></div>
			</div>
		</div>
	</div>
</div>
<style>
.rfq-loader {
  border: 6px solid #f3f3f3;
  border-radius: 50%;
  border-top: 6px solid #CC3313;
  width: 30px;
  height: 30px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  /*float: right;*/
  display:none;
  margin-left: 240px;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.form_bg{width:98%; float:left; background:#fff; padding:5px 1%; border-radius:5px; }
    .form_bg .datagrid table {width:100%; border:solid 1px #ccc;}
    /*.form_bg table.dataTable thead th {border-right: solid 1px#ccc;  padding:10px 1%; font-size: 12px; }*/    
    .form_bg table.dataTable thead th:last-child {border-right: none;}
    .form_bg .datagrid table tbody td{border-right: solid 1px#ccc;}
    .form_bg .datagrid table tbody td:last-child{border-right: none;}
    .form_bg .datagrid table tbody td {font-size:9px; cursor:pointer; word-wrap:break-word;word-break: break-all; }
    .form_bg .dataTables_info{float:left; font-size:10px;}
    .form_bg .btn{ margin:0 0; border-radius:0; font-size:12px; padding: 3px 10px!important; color:#fff;     background: #0c7e99;}
    .form_bg .selected{background:#cccccc !important;}
    .form_bg .row-custom{width:100%; float:left; background:#fff; padding:0 1%; text-align:center;}
    
    
    .rjct{width:98%; float:left; background:#fff; padding:5px 1%; border-radius:5px; }
    .rjct .datagrid table {width:100%; border:solid 1px #ccc;}
    .rjct .datagrid table tr.even {background-color: white;border-bottom: 1px solid #ddd;}    
    .rjct .datagrid table tbody td{padding: 12px 8px;color: #333;border: 1px solid #ccc;word-wrap: break-word;word-break: break-all;}
    .rjct .datagrid table tbody td:last-child{border-right: none;}
    .rjct .heading4 {
    background: url(../images/grad-overlay-s.png) #393939;
    border-radius: 2px;
    padding: 5px 1%;
    color: #ddd;
    font-size: 14px;
    font-weight: 600;
    text-align: left;
    text-shadow: 0 1px 0 #222;
    width: 98%;
    float: left;
}

.ac-container input:checked ~ article.ac-medium{height: 280px;}
.ac-container input:checked ~ article.ac-small{height: 280px;}
.swal2-container{z-index: 99999 !important;} 
</style>
<?php 
	$bidderid=$this->session->userdata['id'];
	$cert_serial_no = GetTitleByField("tbl_auction_participate", "bidderID='".$bidderid."' and auctionID='".$auction_data[0]->id."'", "cert_serial_no");
	$subjectDN = GetTitleByField("tbl_auction_participate", "bidderID='".$bidderid."' and auctionID='".$auction_data[0]->id."'", "signature");

	$dscverified_status = GetTitleByField('tbl_auction_participate', "bidderID='" . $userid . "' AND auctionID='" . $auctionID . "'", 'dsc_verified_status');
	$checkuserdata=$this->session->userdata('response_dsc_'.$auctionID);
	if(isset($checkuserdata) && $checkuserdata=='dscverified'){
		$dscverified_status_session=1;
	}else{
		$dscverified_status_session=0; 
	}
	
	if($auction_data[0]->dsc_enabled == 1)
	{
		$dsc_enabled =  true;
	}
	else
	{
		$dsc_enabled =  false;
	}
?>

<?php if($dsc_enabled == true){?>
	<script type="text/javascript">
	var certSerialNo = null;
	var SerialNo = null;
	jQuery( document ).ready(function($) {	
		var certtype = 'DS';
		/******** while participating in auction start *********/
		var table =$('#certlist').dataTable( {
		  "ajax": {
			"url": pluginURL+"/certificate/list?certtype="+certtype,
			"type": "POST",
		  },
		  "columns": [
						{ "data": "AliasName" },
						{ "data": "IssuedBy" },
						{ "data": "SerialNo" },
						{ "data": "ExpDate" },
						{ "data": "IssuerDetail" }
					],
				  "bFilter": false,
				  "paging": false,
				  "autoWidth": true
		} );

		//$('#certlist tbody').on( 'click', 'tr', function () {
		$(document).on( 'click', '#certlist tbody tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				table.$('tr.selected').removeClass('selected');
				var row =  $(this).addClass('selected');
				
			  // alert(table.api().cell( row, 0 ).data());
			  if(document.getElementById("selectedCertificate")!=null){
				  window.document.getElementById("selectedCertificate").value=table.api().cell( row, 0 ).data(); 
				  window.document.getElementById("SerialNo").value=table.api().cell( row, 2 ).data(); 
			  }
			  else{
				  certSerialNo=table.api().cell( row, 0 ).data();
				  SerialNo=table.api().cell( row, 2 ).data();
			  }          
			}
		} );
		/******** while participating in auction end ***********/
		
		
		/******** while first time entring into auction hall start*********/
		var table_ac =$('#certlist_ac').dataTable( {
		  "ajax": {
			"url": pluginURL+"/certificate/list?certtype="+certtype,
			"type": "POST",
		  },
		  "columns": [
						{ "data": "AliasName" },
						{ "data": "IssuedBy" },
						{ "data": "SerialNo" },
						{ "data": "ExpDate" },
						{ "data": "IssuerDetail" }
					],
				  "bFilter": false,
				  "paging": false,
				  "autoWidth": true
		} );

		//$('#certlist tbody').on( 'click', 'tr', function () {
		$(document).on( 'click', '#certlist_ac tbody tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				table_ac.$('tr.selected').removeClass('selected');
				var row =  $(this).addClass('selected');
				
			  // alert(table.api().cell( row, 0 ).data());
			  if(document.getElementById("selectedCertificate")!=null){
				  window.document.getElementById("selectedCertificate").value=table.api().cell( row, 0 ).data(); 
				  window.document.getElementById("SerialNo").value=table.api().cell( row, 2 ).data(); 
			  }
			  else{
				  certSerialNo=table.api().cell( row, 0 ).data();
				  SerialNo=table.api().cell( row, 2 ).data();
			  }          
			}
		} );
		
		/******** while first time entring into auction hall end*********/
				
	});
	</script>
<?php } ?>
<style>
table.dataTable thead th {    border-right: solid 1px#ccc;  padding:10px 2%;   font-size: 12px;}
table.dataTable thead th:last-child {border-right: none;}
.datagrid table tbody td{border-right: solid 1px#ccc;}
.datagrid table tbody td:last-child{border-right: none;}
.datagrid table tbody td {font-size:9px; word-wrap:break-word; cursor:pointer;     word-break: break-all; }
.dataTables_info{float:left; font-size:10px;}
.btn{ margin:0 0; border-radius:0; font-size:12px; padding: 3px 10px!important; color:#fff;     background: #0c7e99;}
.selected{background:#cccccc !important;}
.row-custom{width:100%; float:left; background:#fff; padding:0 1%; text-align:center;}
</style>

<script type="text/javascript">
jQuery(document).ready(function ($) {
/*------- tab pannel --------------- */
jQuery(".tab_content5").hide();

var activeTab = jQuery("ul.tabs5 li.active").attr("rel");
jQuery("#" + activeTab).show();
/*
jQuery("ul.tabs5 li").click(function() {
jQuery("ul.tabs5 li").removeClass("active");
jQuery(this).addClass("active");
jQuery(".tab_content5").hide();
var activeTab = jQuery(this).attr("rel"); 
jQuery("#"+activeTab).fadeIn(); 
});*/

$(".check_dsc").colorbox({inline:true, width:"70%"});
$(".check_dsc_ac").colorbox({inline:true, width:"70%"});
});

function tcAccept(auctionID)
{
	//alert(auctionID);
	var tcval = jQuery('input[name=chktc]:checked').val();
	if (tcval != 'yes')
	{
		//alert('Please accept terms & condition.');
		swal('Error','Please accept terms & condition.','error')
		return false;
	}
	else
	{
		<?php if(($auction_data[0]->dsc_enabled=='1') && (!$cert_serial_no)){  ?>
		$('.check_dsc').click();
		<?php  } else {?>
		
		$('.participateBtn').css('display','none');
		$('.rfq-loader').css('display','block');
		
		jQuery.ajax({
			url: '/owner/tcAccepted',
			type: 'POST',
			data: {auctionID: auctionID},
			success: function (data) {
				setTimeout(function(){ 
					//alert('dk');
					//$('.participateBtn').css('display','block');
					$('.rfq-loader').css('display','none');
				}, 2000);
				location = location;
			}
		});
		return true;
		
		<?php  }?>
	}
}

function auctionTrainingAccept(auctionID)
{
	
	var tcval = jQuery('input[name=chkauctionTraining]:checked').val();
	if (tcval != 'yes')
	{
		//alert('Please accept Auction Training.');
		swal('Error','Please accept Auction Training.','error')
		return false;
	}
	else
	{			
		<?php if(($auction_data[0]->dsc_enabled=='1') && (!$dscverified_status)){  ?>			
		$('.check_dsc_ac').click();
		<?php  } else {?>
		
		jQuery.ajax({
			url: '/owner/atAccepted',
			type: 'POST',
			data: {auctionID: auctionID},
			success: function (data) {
				location = location;
			}
		});
		return true;
		
		<?php  }?>
	}
}
</script>
<style>
.show_input_type{display:block !important; }
.show_agreement{float: left; width:auto;}
.font_12{font-size:12px;}
.bank_logo{width:150px; float:right; padding:5px 5px 0 0;}
@media screen and (max-width: 416px) {
.bank_logo{width:100px;}
}
@media screen and (max-width: 350px) {
.bank_logo{width:80px; float:right; padding:1px 1px 0 0;}
}
</style>
<section class="container_12">
<div class="">
<div class="wrapper-full">
<div class="dashboard-wrapper">
<div id="tab-pannel6" class="btmrgn">
<div class="tab_container6"> 
<!---- buy tab container start ---->
<div id="tab1" class="tab_content6" style="display:block">
<div id="tab-pannel3" class="btmrgn">
<div class="tab_container3 whitebg"> 
	<!-- Sell > My Activity start -->
	<div id="tab6" class="tab_content3">
		<div class="container">
			<div class="secttion-right">
				<?php
				$currentStatus = 0;
				$participate = 0;
				$opener = 0;
				$openning = 0;
				$wait_for_auction = 0;

				$date = @strtotime(date('Y-m-d H:i:s'));

				$bid_last_date = ($auction_data[0]->bid_last_date) ? strtotime($auction_data[0]->bid_last_date) : 0;

				$bid_opening_date = ($auction_data[0]->bid_opening_date) ? strtotime($auction_data[0]->bid_opening_date) : 0;

				$auction_start_date = ($auction_data[0]->auction_start_date) ? strtotime($auction_data[0]->auction_start_date) : 0;

				$auction_end_date = ($auction_data[0]->auction_end_date) ? strtotime($auction_data[0]->auction_end_date) : 0;

				if ($auction_data[0]->second_opener) {
					$opner_accepted = $auction_data[0]->bidder_participation_detail[0]->operner2_accepted;
				} else {
					$opner_accepted = $auction_data[0]->bidder_participation_detail[0]->operner1_accepted;
				}
				
				if ($auction_data[0]->bidder_participation_detail[0]->operner2_accepted !=1) //$date <= $bid_last_date 
				{
					
					$currentStatus = 1;
					if ($auction_data[0]->bidder_participation_detail[0]->is_accept_tc == 1) {
						$participate = 1;
					}
				} elseif ($date < $bid_opening_date) {
					$currentStatus = 2;
					$opener = 1;
				} elseif (($auction_start_date - $date) < 60 && ($auction_start_date - $date) > 0) {
					$currentStatus = 3;
					$wait_for_auction = 1;
				} elseif ($date > $bid_opening_date && $date < $auction_start_date) {
					$currentStatus = 2;
					$openning = 1;
				} elseif ($date >= $auction_start_date AND $date <= $auction_end_date) {
					$currentStatus = 3;
				} elseif ($date > $auction_end_date) {
					$currentStatus = 4;
				} else {
					$currentStatus = 0;
					$participate = 0;
					$opener = 0;
					$openning = 0;
					$wait_for_auction = 0;
				}
				?>
				<div style="font-size:25px;font-weight:bold;text-align:center;">Bidder Auction Tracker</div>
				<div class="row" style="text-align:center; cursor:pointer; color:#00F;  font-size:12px;"><a href="#inline_content" class="grn-txt float-right b_showevent inline_auctiondetail">Show Auction details</a></div>


				<div class="table-section"> 

					<div class="container_12">	
						<div class="container_12">						
							<div class="container_12">
								<div class="container_12">
									<!--<div class="error1">Please Submit the Documents.</div>-->
									<section class="ac-container">
										<div>
											<input id="ac-1" name="accordion-1" type="radio" <?php echo ($currentStatus == 1) ? 'checked' : ''; ?>  />
											<label for="ac-1"><span class="size_18">1</span>
												Participation Stage
												<?php if ($currentStatus == 1) { ?>
													<span class="current_stage">Current Stage</span>
												<?php } ?>	
											</label>
											<article class="ac-medium" style="max-height:240px;overflow:auto;">
												<div style="width:auto; float:left;" >
													<p>

														Bank Processing Fee : <span class="WebRupee">Rs. </span><?php echo $auction_data[0]->tender_fee ?>
													</p>
													<p>

														EMD Amount : <span class="WebRupee">Rs. </span><?php echo $auction_data[0]->emd_amt ?>
													</p>
													<?php 
													if($auction_data[0]->dsc_enabled=='1')
													{
														
														if($cert_serial_no !='')
														{
													?>
															<p>
																DSC Attached: S.No.: <strong><?php echo $cert_serial_no; ?></strong>; Subject DN: <strong><?php echo $subjectDN; ?></strong>
															</p>
													<?php 
														}
														else
														{
													?>
															<p>
																DSC Attached: None
															</p>
													<?php															
														}
													}
													
													?>	
													<p>
													Documents Required : 
														<?php
														if($auction_data[0]->doc_to_be_submitted !=0){
															$req_doc = $auction_data[0]->doc_to_be_submitted;
															$req_doc_array = explode(',', $req_doc);
															 foreach ($req_doc_array as $doc_id) {
																echo GetTitleById('tbl_doc_master', $doc_id) . ", ";
															 } 
														}else{
															echo "None";
														}
															
														?>
													</p>
															
														<?php
														if ($currentStatus == 1) {
															if ($participate == '1') {
															$userid=$this->session->userdata['id'];
															$fs=GetTitleByField('tbl_auction_participate', "bidderID='".$userid."' AND auctionID='".$auction_data[0]->id."'", 'final_submit');
															if($fs !=1)
															{
															?>
															<p>
																<a href="/owner/auction_participate/<?php echo $auction_data[0]->id ?>"><input name="Save" value="Participate" type="button" class="button_grey show_input_type float-right"></a>
															</p>
															<?php
															}															
															else
															{
																echo '<p>Participation Verification in process.</p>';
															}
														} else {
															?>
															<p>
																<?php
															echo "Apply And EMD Start Date & Time : ". date('d-m-Y H:i:s',strtotime($auction_data[0]->registration_start_date));
															?>
															</p>
														</div>

														<div class="clear">&nbsp;</div>
														<div style="width:98%; float:left; padding:0 1%;" >
															
															<?php
															/*
															echo strtotime($auction_data[0]->registration_start_date);
															echo "<br>";
															echo strtotime(date("Y-m-d H:i:s"));die;
															*/
															if(strtotime($auction_data[0]->registration_start_date)<= strtotime(date("Y-m-d H:i:s")))
															{
															?>
															<p>
																
															<div id="ContentPlaceHolder1_divAcptChk" class="participateBtn">
																
																
																	<input name="chktc" class="show_input_type show_agreement" type="checkbox" id="chktc" value="yes">
																<span class="font_12">I agree that : I have read and accepted the <a href="<?php echo base_url();?>assets/front_view/images/terms_and_condition_bidding.pdf" target="_blank"   class="terms grn-txt">User Agreement and Privacy Policy.</a>
																<?php /* ?><a href="#inline_content1" class="terms b_showevent inline_auctiondetail">User Agreement and Privacy Policy.</a><?php */ ?>
																 I may receive communications from <?php echo BRAND_NAME; ?> . </span>
																<span id="ContentPlaceHolder1_Label1"></span>
																  <div align="center"> <input type="button" name="submit" value="Submit" class="button_grey show_input_type" onclick="return tcAccept(<?php echo $auction_data[0]->id ?>);">  														
																</div>																 
																
															</div>
															<div align="center" class="rfq-loader"></div><?php if($auction_data[0]->dsc_enabled=='1'){  ?>
																
																<?php if(!$cert_serial_no){ ?>
																<a style="display:none;padding:0 0 !important;" href="#form_bg" class="check_dsc button_grey">Check DSC</a>
																<?php  } } ?>															
															</p>
															<?php
															}
															?>
															
															<?php
														}
													}
													?>
												</div>
											</article>


										</div>


										<div>
											<input id="ac-2" name="accordion-1" type="radio" <?php echo ($currentStatus == 2) ? 'checked' : ''; ?> />
											<label for="ac-2"><span class="size_18">2</span>
												Opening Stage
												<?php if ($currentStatus == 2) { ?>
													<span class="current_stage">Current Stage</span>
												<?php } ?>

											</label>
											<article class="ac-small">
												<p>
													<?php
													if ($currentStatus == '2') {
														if ($opner_accepted == '1') {
															?> 
															<span class="grn-txt">Congratulation!!</span> You Have Been Qualified For The Auction by Competent Authority.
															<?php
														} elseif ($opener == '1') {
															?>
															Bid yet to be open.
															<?php
														} elseif ($openning == '1') {
															?>
															Opening is in Progress.
															<?php
														} else {
															?>
															Opening is Scheduled at : 
															<?php
															echo date('d-m-Y H:i:s',strtotime($auction_data[0]->bid_opening_date));
														}
													} else {
														?>
														Opening is Scheduled at : 
														<?php
														echo date('d-m-Y H:i:s',strtotime($auction_data[0]->bid_opening_date));
													}
													?>
												</p>
											</article>
										</div>


										<div>				
											<input id="ac-3" name="accordion-1" type="radio" <?php echo ($currentStatus == 3) ? 'checked' : ''; ?>  />
											<label for="ac-3"><span class="size_18">3</span>
												Auction
												<?php if ($currentStatus == 3) { ?>
													<span class="current_stage">Current Stage</span>
												<?php } ?>
											</label>
											<article class="ac-small">
												<p> 
													Auction Start Date & Time: <?php echo date('d-m-Y H:i:s',strtotime($auction_data[0]->auction_start_date)); ?>
												</p>
												<p> 
													Auction End Date & Time: <?php echo date('d-m-Y H:i:s',strtotime($auction_data[0]->auction_end_date)); ?>
												</p>
												<?php 
													if($auction_data[0]->dsc_enabled=='1')
													{
														
														if($cert_serial_no !='')
														{
													?>
															<p>
																DSC Attached: S.No.: <strong><?php echo $cert_serial_no; ?></strong>; Subject DN: <strong><?php echo $subjectDN; ?></strong>
															</p>
													<?php 
														}
														else
														{
													?>
															<p>
																DSC Attached: None
															</p>
													<?php															
														}
													}
													
													?>	
													<?php if($auction_data[0]->dsc_enabled=='1'){  ?>
																
													<?php if(!$dscverified_status){ ?>
														<a style="display:none;padding:0 0 !important;" href="#form_bg_ac" class="check_dsc_ac button_grey">Check DSC Auction</a>
													<?php  } } ?>
												<?php /* if($auction_data[0]->dsc_enabled==1){ ?>
												  <p style="color:#000; text-align: center;  padding: 20px 0 0 0;">
												  Please attach Your Certificate before going for Auctions !!
												  </p>
												  <p style=" text-align: center; ">
												  <button class="button_grey" onclick="CheckvalidDSC(<?=$auction_data[0]->id;?>);" value="Attach Certificate">Attach Certificate</button>
												  </p>
												  <applet id="C1SignerWrapper" width="0" height="0" archive="<?=base_url();?>/bankeauc/JavaApplets/C1Sign.jar" code="C1SignerWrapper" name="C1SignerWrapper"></applet>
												  <?php } */ ?>
												<?php
												if ($currentStatus == '3') {
													if ($auction_data[0]->bidder_participation_detail[0]->is_accept_auct_training && $wait_for_auction == '0' && (!$dscverified_status)) {
														?>
														<p>
															<a href="<?php echo base_url();?>owner/buylistLiveAuctions/<?php echo $auction_data[0]->id ?>"> Click here to Enter Auction</a>
														</p>
														<?php
													} elseif ($wait_for_auction == '1' && $auction_data[0]->bidder_participation_detail[0]->is_accept_auct_training == '1') {
														?>
														<div class="circle-category2"> 
															<div class="txt" style="color:red">Please wait for auction to start.</div>
														</div>
														<?php
													} else {
														?>
														<p>
														<div id="ContentPlaceHolder1_divAcptChk">
															<input name="chkauctionTraining" class="show_input_type show_agreement" type="checkbox" id="chkauctionTraining" value="yes">
															<span class="font_12">I agree that : I have read and accepted the 
															<?php /* ?><a onclick="return bidderHoleinfoPopup('owner_agreement_privacy_policy', '<?php echo $auction_data[0]->id; ?>');" class="terms" href="javascript:" >Auction Training</a><?php */ ?>
															<a href="javascript:void(0)" target="_blank" class="terms" >Auction Training</a>
															
															</span>
															<span id="ContentPlaceHolder1_Label1"></span>
															<div align="center"> <input type="button" name="submit" value="Submit" class="button_grey show_input_type" onclick="return auctionTrainingAccept(<?php echo $auction_data[0]->id ?>);">  </div>
														</div>
														</p>
														<?php
													}
												}
												?>
											</article>
										</div>

										<div>				
											<input id="ac-4" name="accordion-1" type="radio"  <?php echo ($currentStatus == 4) ? 'checked' : ''; ?>/>
											<label for="ac-4"><span class="size_18">4</span>
												Reports
												<?php if ($currentStatus == 4) { ?>
													<span class="current_stage">Current Stage</span>
												<?php } ?>
											</label>
											<article class="ac-small">
												<p>
													<?php if ($currentStatus == 'viewreport' || $currentStatus==4) { ?> <span class="grn-txt"><a href="/owner/viewReport/<?php echo $auction_data[0]->id?>" class="myviewReport">Report</a></span> Available For Downloads of Auction.<?php } else { ?>
														<span class="grn-txt">Report</span> Will be Available For Downloads After Completion of Auction<?php } ?>
												</p>
											</article>


										</div>



										<div>				







									</section>

								</div>
							</div>
						</div>
					</div>


					<!-- #tab5 --> 
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
<!-- Show event details -->
<link rel="stylesheet" href="/css/colorbox.css" />
<script src="/js/jquery.colorbox.js"></script>
<script>
jQuery(document).ready(function () {

jQuery(".inline_auctiondetail").colorbox({inline: true, width: "90%"});
jQuery(".inline_auctiondetail1").colorbox({inline: true, width: "65%"});
jQuery(".inline_auctiondetail2").colorbox({inline: true, width: "65%"});
//jQuery(".emd_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {location.reload(true);}});
jQuery(".emd_detail_iframe").colorbox({iframe: true, width: "42%", height: "70%", onClosed: function () {
jQuery(".inline_auctiondetail1").click();
}});
jQuery(".tenderfee_detail_iframe").colorbox({iframe: true, width: "42%", height: "70%", onClosed: function () {
jQuery(".inline_auctiondetail1").click();
}});
jQuery(".doc_detail_iframe").colorbox({iframe: true, width: "42%", height: "40%", onClosed: function () {
jQuery(".inline_auctiondetail1").click();
}});
});
</script>

<div class="row"  style="display:none;">
<div id="inline_content1"  style="overflow:scroll; height:400px;">
<div class="heading4 btmrg20">User Agreement and Privacy Policy</div>
<div class="bank_logo" style="width:98%; float:left; padding:5px 1%;"><!--<img src="<?php echo base_url(); ?>images/andhrabankbiglogo.png" width="120" height="40" style="width:120px;">--></div>
<div style="font-size:12px; background:#E3E3E3; float:left; border:solid 1px #bbb; padding:10px;">
<b>This document is an electronic record in terms of Information Technology Act, 2000 and
rules there under as applicable and the amended provisions pertaining to electronic
records in various statutes as amended by the Information Technology Act, 2000. This
electronic record is generated by a computer system and does not require any physical or
digital signatures.
</b>
<br/><br/>
<b>User Agreement</b>
<br/><br/>
Your use of and its related sites, services and tools} is governed by
the following terms and conditions. If you transact on any <?php echo BRAND_NAME; ?> website other than the
Website, you shall be subject to the policies that are applicable to the <?php echo BRAND_NAME; ?>  sites for
such transaction. This User Agreement for the Website shall come into effect from the time and
date the user accepts the same ("User Agreement").
<br/><br/>
<b>Amendments: </b>   may amend this User Agreement and/or
<?php echo BRAND_NAME; ?>  Rules and Policies at any time by posting a revised version on the Website. If the
revised version of this User Agreement includes a Substantial Change,
 will provide you with 15 days' prior notice of such Substantial
Change/s. You are advised to regularly check for any amendments or updates to the terms and
conditions contained in this User Agreement and in <?php echo BRAND_NAME; ?> Rules and Policies.
<br/><br/>
<b>1 Introduction</b>
<br/><br/>
 is an Online Business to Business (B2B) negotiation (Online
auction) tool which allows a secure B2B business negotiation between Host of the negotiation
Event (“Auctioneer”) and Participants (“Bidders”).
Auctioneer hosts a negotiation event as per the order of Banks or other financial institutions
(“Auction”) and invites its Bidders to participate in the event. Bidder can access the platform and
participate in an Online Negotiation Event (“Auction”) by submitting Bids (“Bids”). These
Events (“Auctions”) can be called for procurement (termed as Reverse Auction) of any Item /
service /contract or for the sale (termed as forward auction) of any Item / service etc.
Procurement Auction are termed as “Reverse Auctions” and Sales Auctions are termed as
“Forward Auctions”
<?php echo BRAND_NAME; ?>  platform is to be used as a negotiation tool to get better market price. Auctioneer
needs to invite bidders of their own and the invitation needs to be sent through <?php echo BRAND_NAME; ?> 
platform. Invited bidders who register on auction portal will be automatically added to the list of
enrolled bidder of respective auctioneer. <?php echo BRAND_NAME; ?>  does not provide or recommend any
bidder online or offline. Easy auction provides utility to add / upload details of bidders also the
subsequent activities and placement of orders / contracts or supply of goods or services and
payment collection is solely the responsibility of the Auctioneer.
<br/><br/>
By registering with   the Auctioneer and Bidders agree to be bound
by the following Terms and Conditions.
<br/><br/>
<b>10 Termination</b>
<br/><br/>
<?php echo BRAND_NAME; ?>  reserves the right to:
<ul style="margin-left:50px">
<li>Terminate these Terms by e-mail at any time without giving reasons </li>
<li> Stop any auction or Bid and ban users from using the website</li>
<li> Modify or withdraw the Website at any time without notice  </li>
<li>To reject any registration or access to the website and to temporarily or indefinitely
suspend any registered user  </li>
<li> To withdraw User names and passwords at any time without notice should we believe
they have been compromised?  </li>
</ul>
<br/><br/>
The Auctioneer may not terminate this agreement whilst fees to <?php echo BRAND_NAME; ?>  remain
outstanding.
<br/><br/>
On termination of these Terms, the Event and access to the Web Site will cease and all
information belonging to the other party will be returned or destroyed.
<br/><br/>
In the event of termination of the service, any unused credits and / or information will be
returned to the Host on request.
<br/><br/>
<b>11 Confidentiality</b>
<br/><br/>
<?php echo BRAND_NAME; ?>  , the Auctioneers and the Bidders agree to keep all information submitted to the
platform or which otherwise is disclosed by either party under this Agreement confidential and
shall not disclose any such information to any third parties without the consent of the owner of
the confidential information save that it can disclose such information to those of its employees,
agents or professional advisers who have a need to know and who are bound to keep the
information confidential.
<br/><br/>
<?php echo BRAND_NAME; ?>  and the auctioneer agree to use the Confidential Information of the other solely in
connection with the performance of the Event and not otherwise or for the benefit of any third
party.
<br/><br/>
Each party will, at its own expense, take all reasonable and appropriate steps to enforce any duty
of confidence owed to it by any party (including employees, agents, sub-contractors and
professional advisors), insofar as such enforcement appears to be necessary for the protection of
the confidentiality of the Confidential Information.
<br/><br/>
The provisions of clause 10 will not apply to the whole or any part of the Confidential
Information which:
<ul style="margin-left:50px">
<li>is lawfully obtained free of any duty of confidentiality otherwise than from a party to this
Agreement.
</li> 
<li>is already in the other party’s possession other than as a result of a breach of this 
clause 10;
</li>
<li> the Party can demonstrate is in the public domain (other than as a result of a breach of
this clause 10);
</li>
<li> is independently developed or acquired by that Party without access to the Confidential
Information;</li>
<li> is disclosed pursuant to a judicial or other governmental order, provided that the Party
required to disclose gives the other Party reasonable notice prior to such disclosure to
allow the disclosing Party a reasonable opportunity to seek a protective order or
equivalent; or
</li>
<li>Is disclosed with prior written consent of the other Party.</li>
</ul>
<br/><br/>
<b> 12 Governing law</b>
<br/><br/>
These Terms and Conditions will be construed in accordance with and governed by the laws of
India and each party agrees to submit to the exclusive jurisdiction of the courts of New Delhi
India.
<br/><br/>
<b>13 Miscellaneous</b>
<br/><br/>
<?php echo BRAND_NAME; ?>  reserves the right to change these terms and conditions at any time. These will be
posted on the website and will come into immediate effect. If the website is used after these
conditions come into effect then the User will be indicating their agreement to be bound by these
new terms and conditions.
</div>







</div>	
</div>	
<div class="row"  style="display:none;">
<!-------------new data----------------->

<div id="inline_content">
<div class="heading4 btmrg20">Auction Detail</div>
<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
<tbody role="alert" aria-live="polite" aria-relevant="all">
         
    <tr class="even">                  
            <td align="left" valign="top" class="" width="25%"><strong>Auction No. </strong></td>
            <td align="left" valign="top" class="" width="25%"><?php echo $auction_data[0]->id?></td>
            <td align="left" valign="top" class="" width="25%" ><strong>Institution</strong></td>
            <td align="left" valign="top" class="" width="25%">
            <?php
                echo GetTitleByField('tblmst_account_type', "account_id='".$auction_data[0]->account_type_id."'" ,'account_name');
            ?>  
            </td>
        </tr>
        
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Property ID </strong></td>
            <td align="left" valign="top" class=""><?php echo $auction_data[0]->reference_no?></td>
            <td align="left" valign="top" class=""><strong>Auction Reference Dispatch Date</strong></td>
            <td align="left" valign="top" class=""><?php echo (($auction_data[0]->dispatch_date != '1970-01-01') && ($auction_data[0]->dispatch_date != '0000-00-00')) ? date('d-m-Y', strtotime($auction_data[0]->dispatch_date)) : 'N/A'; ?></td>
        </tr>
        
        <tr class="even">
            <td align="left" valign="top" class=""><strong>Property Address</strong></td>
            <td align="left" valign="top" class=""><?php echo strtoupper($auction_data[0]->PropertyDescription);?></td>
            <td align="left" valign="top" class=""><strong>Carpet Area</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->area != '')?$auction_data[0]->area:'N/A';?></td>
        </tr>

        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Carpet Area Unit</strong></td>
            <td align="left" valign="top" class="">
            <?php
                $cauom = GetTitleByField('tblmst_uom_type', "uom_id='".$auction_data[0]->area_unit_id."'" ,'uom_name');
                echo ($cauom !='')?$cauom:'N/A';
            ?>  
            </td>
            <td align="left" valign="top" class=""><strong>Category/ Property Type</strong></td>
            <td align="left" valign="top" class="">
            <?php
            echo GetTitleByField('tbl_category', "id='".$auction_data[0]->category_id."'" ,'name');
            ?>
            </td>
        </tr>
         <tr class="even">
            <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->property_height != '')?$auction_data[0]->property_height:'N/A';?></td>
            <td align="left" valign="top" class=""><strong>Plot Area Unit</strong></td>
            <td align="left" valign="top" class="">
            <?php
				$cauom = GetTitleByField('tblmst_uom_type', "uom_id='".$auction_data[0]->height_unit_id."'" ,'uom_name');
                echo ($cauom !='')?$cauom:'N/A';
            ?>  
            </td>
        </tr>
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Corner</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->is_corner_property == 1) ? 'Yes' : 'No'; ?>
            </td>
            <td align="left" valign="top" class=""><strong>Scheme Id</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->scheme_id)? $auction_data[0]->scheme_id: 'N/A';?></td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Scheme Name</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->scheme_name)? $auction_data[0]->scheme_name: 'N/A';?></td> 
            <td align="left" valign="top" class=""><strong>Name of Owner/ Occupier as per MCG record</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->service_no)? $auction_data[0]->service_no: 'N/A';?></td>
        </tr>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Concerned Zone</strong></td>
            <td align="left" valign="top" class="">
            <?php
            echo GetTitleByField('tbl_zone', "zone_id='".$auction_data[0]->zone_id."'" ,'zone_name');
            ?>
            </td> 
            <td align="left" valign="top" class=""><strong>Applicable FAR</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->far)? $auction_data[0]->far: 'N/A';?></td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->property_height)? $auction_data[0]->property_height: 'N/A';?></td>  
            <td align="left" valign="top" class=""><strong>Plot Area Unit</strong></td>
            <td align="left" valign="top" class="">
            <?php
                $height_unit = GetTitleByField('tblmst_height_uom_type', "height_uom_id='".$auction_data[0]->height_unit_id."'" ,'height_uom_name');
                if($height_unit != ''){
                    echo $height_unit;
                }else{
                    echo "N/A";
                }
            ?>
            </td>
        </tr>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Max Coverage Area</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->max_coverage_area)? $auction_data[0]->max_coverage_area: 'N/A';?></td> 
            <td align="left" valign="top" class=""><strong>Reserve Price</strong></td>
            <td align="left" valign="top" class="">
                <?php echo number_format($auction_data[0]->reserve_price, 2); ?>&nbsp;&nbsp;&nbsp;( <?php echo getAmountInWords((int)$auction_data[0]->reserve_price); ?> )
            </td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Reserve Price (Unit)</strong></td>
            <td align="left" valign="top" class=""><?php
                echo GetTitleByField('tblmst_uom_type', "uom_id='".$auction_data[0]->unit_id_of_price."'" ,'uom_name');
            ?> 
            </td>  
            <td align="left" valign="top" class=""><strong>EMD Amount</strong></td>
            <td align="left" valign="top" class="">
                <?php echo number_format($auction_data[0]->emd_amt, 2); ?>  (<?php echo getAmountInWords($auction_data[0]->emd_amt); ?> )
            </td>
        </tr>
        <?php /* ?><tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Administrative Fee</strong></td>
            <td align="left" valign="top" class=""><?php
                echo ADMINISTRATIVE_FEE;
            ?> 
            </td>  
            <td align="left" valign="top" class="">-</td>
            <td align="left" valign="top" class="">-</td>
        </tr><?php */ ?>
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Bank Processing Fee</strong></td>
            <td align="left" valign="top" class=""><?php echo $auction_data[0]->tender_fee;?>
            </td>
            <td align="left" valign="top" class=""><strong>Press Release Date</strong></td>
            <td align="left" valign="top" class="">
            <?php echo date("d-m-Y",strtotime($auction_data[0]->press_release_date));?>
            </td>
        </tr>
        
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Site Visit Start Date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo (($auction_data[0]->inspection_date_from != '1970-01-01') && ($auction_data[0]->inspection_date_from != '0000-00-00 00:00:00')) ? date('d-m-Y', strtotime($auction_data[0]->inspection_date_from)) : 'N/A'; ?>
            </td> 
            <td align="left" valign="top" class=""><strong>Site Visit End Date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo (($auction_data[0]->inspection_date_to != '1970-01-01') && ($auction_data[0]->inspection_date_to != '0000-00-00 00:00:00')) ? date('d-m-Y', strtotime($auction_data[0]->inspection_date_to)) : 'N/A'; ?>
            </td>
        </tr>
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Apply And EMD Start Date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo date("d-m-Y H:i",strtotime($auction_data[0]->registration_start_date));?>
            </td> 
            <td align="left" valign="top" class=""><strong>Apply And EMD End Date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo date("d-m-Y H:i",strtotime($auction_data[0]->bid_last_date));?>
            </td>
        </tr>
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Auction Start date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo date("d-m-Y H:i",strtotime($auction_data[0]->auction_start_date));?>
            </td> 
            <td align="left" valign="top" class=""><strong>Auction End date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo date("d-m-Y H:i",strtotime($auction_data[0]->auction_end_date));?>
            </td> 
        </tr>
        
        <tr class="even">
            
             
            <td align="left" valign="top" class=""><strong>Mode of Bid</strong></td>
            <td align="left" valign="top" class="">
               <?php echo ($auction_data[0]->mode_of_bid == 'online') ? 'Online' : 'Offline'; ?>
            </td>
             
            <td align="left" valign="top" class=""><strong>Is DSC Enabled </strong></td>
            <td align="left" valign="top" class="">
                <?php echo ($auction_data[0]->dsc_enabled == 1) ? "Yes" : "No" ?>
            </td> 
        </tr>
        
        
         <tr class="odd">
           
            <td align="left" valign="top" class=""><strong>Auto Bid Allow</strong></td>
            <td align="left" valign="top" class="">
                <?php echo ($auction_data[0]->allow_auto_bid == 1) ? "Yes" : "No" ?>
            </td>
            
            <td align="left" valign="top" class=""><strong>Bid Increment value</strong></td>
            <td align="left" valign="top" class="">
                <?php echo $auction_data[0]->bid_inc;?>
            </td>  
        </tr>
        
        <tr class="even">
            
             <td align="left" valign="top" class=""><strong>Auto Extension time </strong>(In Minutes.)</td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->auto_extension_time != '0') ? $auction_data[0]->auto_extension_time : "0"; ?>
            </td>
            
            <td align="left" valign="top" class=""><strong>Auto Extension(s)</strong></td>
            <td align="left" valign="top" class="">                
                <?php echo ($auction_data[0]->auto_extension_time >0 && $auction_data[0]->no_of_auto_extn == '0') ? "Unlimited": $auction_data[0]->no_of_auto_extn; ?>
            </td> 
        </tr>
        <tr class="odd">
        
             <td align="left" valign="top" class=""><strong>How to Reach</strong></td>
            <td td align="left" valign="top" class=""><a target="_blank" href="<?php echo base_url().'owner/viewGoogleMap/'. $auction_data[0]->id;?>">View</a></td>
             
             <td align="left" valign="top" class=""><strong>1st Contact Person Details</strong></td>
            <td align="left" valign="top" class=""><?php echo $auction_data[0]->contact_person_details_1;?></td>
            
      </tr>
        </tr>
        
        <tr class="even">
           
            <td align="left" valign="top" class=""><strong>2nd Contact Person Details</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->contact_person_details_2)? $auction_data[0]->contact_person_details_2: 'N/A';?></td>  
            <td align="left" valign="top" class=""><strong>Any Documents Pertinent To The Auction</strong></td>
                 <td align="left" valign="top" class="">

             <?php
             if ($auction_data[0]->doc_to_be_submitted) {
                 $docArr = explode(",", $auction_data[0]->doc_to_be_submitted);
                 if (count($docArr)) {
                 $docnameArr = array();
                 foreach ($docArr as $docID) {
                 $docnameArr[] = GetTitleById('tbl_doc_master', $docID);
                 }
                 }
                 }else{
                     echo "None";
                 }
                 if (count($docnameArr)) {
                 echo implode(', ', $docnameArr);
             }

             ?>

            </td>
        </tr>
        
        <tr class="odd">
           
            
            <td align="left" valign="top" class=""><strong>View Documents</strong></td>
            <td align="left" valign="top" class="">
                <?php if(is_array($uploadedDocs) && count($uploadedDocs)>0){	
		echo '<a target="_blank" href="'.base_url().'owner/viewEventDocuments/' . $uploadedDocs[0]->auction_id . '"  >View</a>';
		} else {
		echo "N/A";
		}
		?>
            </td>
            <td align="left" valign="top" class=""><strong>Remark</strong></td>
            <td align="left" valign="top" class="">
                <?php echo ($auction_data[0]->remark)? $auction_data[0]->remark: 'N/A';?>
                
            </td>
        </tr>
        
        <tr class="even">
         
            <td align="left" valign="top" class=""><strong>Auction Created by</strong></td>
        <td align="left" valign="top" class="">
            <?php
                  /*$sales_executive_id=GetTitleByField('tbl_event_log_sales', "id='".$auction_data[0]->eventID."'" ,'sales_executive_id');				
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'first_name');
                  echo " ";
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'last_name');*/

                  $sales_executive_id=GetTitleByField('tbl_auction', "id='".$auction_data[0]->id."'" ,'first_opener');				
                  echo  ucfirst(GetTitleByField('tbl_user', "id='".$sales_executive_id."'" ,'first_name'));
                  echo " ";
                  echo ucfirst(GetTitleByField('tbl_user', "id='".$sales_executive_id."'" ,'last_name'));
            ?>
          </td>	
          <td align="left" valign="top" class=""><strong>Auction Approved by</strong></td>
          <td align="left" valign="top" class="">
            <?php
                  /*$sales_executive_id=GetTitleByField('tbl_event_log_sales', "id='".$auction_data[0]->eventID."'" ,'sales_executive_id');				
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'first_name');
                  echo " ";
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'last_name');*/

                  $approver_id = GetTitleByField('tbl_auction', "id='".$auction_data[0]->id."'" ,'second_opener');				
                  echo  ucfirst(GetTitleByField('tbl_user', "id='".$approver_id."'" ,'first_name'));
                  echo " ";
                  echo  ucfirst(GetTitleByField('tbl_user', "id='".$approver_id."'" ,'last_name'));
            ?>
          </td>
        </tr>
     
</tbody>

</table>

</div>



</div>
