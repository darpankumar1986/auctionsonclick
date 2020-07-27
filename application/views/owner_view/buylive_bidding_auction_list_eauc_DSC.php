<link rel="stylesheet" href="http://propertyauctions.com/assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.js"></script>-->
<script src="<?php echo base_url(); ?>bankeauc/js/promise.min.js?rand=1"></script>
<script src="/bankeauc/js/sweetalert.min.js?rand=1"></script>
<link rel="stylesheet" type="text/css" href="/bankeauc/css/sweetalert.css?rand=1">

<style>
	.container_12 {width: 90% !important;}
	iframe body(margin:0px !important;);
	.jc-bs3-row.row{width:29% !important;margin-left: 33.33333333%;}
	table tbody tr:hover { background-color:transparent;}
	table.dataTable tr.even, table.dataTable tr.even:hover { background-color: #f6f6f6;border-bottom: 1px solid #ddd;}
	table.dataTable tr.odd, table.dataTable tr.odd:hover{   background-color: #dbdbdb;    border-bottom: 1px solid #ddd;}
	.panel-msg-cont{background-color:#dcf0f9;font-size:25px;text-align:center;}
	table{border:solid 1px #ccc;}
</style>
<script type="text/javascript"> 
	<?php 
	date_default_timezone_set("Asia/Calcutta");
	$current_timestamp = round(microtime(true) * 1000);?>
	var todayDate = new Date(<?php echo $current_timestamp;?>);
	var d = todayDate;
	d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 + 19800000);
	//var utcTime = new Date(d1.getUTCFullYear(), d1.getUTCMonth(), d1.getUTCDate(), d1.getUTCHours(), d1.getUTCMinutes(), d1.getUTCSeconds());
	//n = utcTime.getTime() + 19800000;
	n= d.getTime();
	//alert(d);

	//var countdown_td = -(parseInt(<?php echo $current_timestamp;?>) - parseInt(n));	 
	var countdown_td = d.getTime() - new Date().getTime() ;
	//alert(new Date().getTime());	
</script>
<script>
	jQuery(document).ready(function($){
		 $(".iframeColorbox").colorbox({iframe:true, innerWidth:800, innerHeight:400});
		$(".check_dsc").colorbox({
			inline:true, 
			width:"50%",
			onClosed: function () {
				$(".dscsecure_checkbox").prop('checked', false);
			}
		});
		currentDateTime();
	});
function currentDateTime(){
var today = new Date();	

month = (today.getMonth()+1) < 10 ? '0'+(today.getMonth()+1) : (today.getMonth()+1);
dt = today.getDate() < 10 ? '0'+today.getDate() : today.getDate();

var date = dt+'-'+month+'-'+today.getFullYear();

minutes = today.getMinutes() < 10 ? '0'+today.getMinutes() : today.getMinutes();
seconds = today.getSeconds() < 10 ? '0'+today.getSeconds() : today.getSeconds();

var time = today.getHours() + ":" + minutes + ":" + seconds;
var dateTime = date+' '+time;
$('#clock').html(dateTime);
}
setInterval(function(){currentDateTime();},1000);

</script>	
<?php
//echo "<pre>";print_r($auctionData);die;
$condition=1;
$totalLiveAuctionData = ($auctionData);
$userid = $this->session->userdata['id'];
if ($totalLiveAuctionData != 0) {
    $currentTime = time();
    foreach ($auctionData as $adata) {		
		
		$plot_area_uom = GetTitleByField('tblmst_uom_type','uom_id='.(int)$adata->height_unit_id,'uom_name');	
		$areaUnit = GetTitleByField('tblmst_uom_type', "uom_id=".(int)$adata->area_unit_id."", 'uom_name');
        $pricePerUnit = GetTitleByField('tblmst_uom_type', "uom_id=".(int)$adata->unit_id_of_price."", 'uom_name');
        $auctionID = $adata->id;
        $status = $adata->status;
        $this->bidder_model->auction_user_live_log_insert($auctionID,$userid);
        $is_accept_tc = $adata->is_accept_auct_training;
        if (($adata->first_opener > 0) && ($adata->second_opener <= 0)) {
			
            $participate_status = GetTitleByField('tbl_auction_participate', "bidderID='" . $userid . "' AND auctionID='" . $auctionID . "'", 'operner2_accepted');
            if ($participate_status > 0) {
                $bankerAccepted = 1;
            } else {
                $bankerAccepted = 0;
            }
        } else if (($adata->second_opener > 0) && ($adata->first_opener > 0)) {
            $participate_status = GetTitleByField('tbl_auction_participate', "bidderID='" . $userid . "' AND auctionID='" . $auctionID . "'", 'operner2_accepted');
            if ($participate_status > 0) {
                $bankerAccepted = 1;
            } else {
                $bankerAccepted = 0;
            }
        }
		
        $auto_bid_cut_off = $adata->auto_bid_cut_off;
        $max_auto_bid = $this->bidder_model->getMaxAutocutBidderBidValue($auctionID);
        $rankData = $this->bidder_model->getBidderAuctionRank($auctionID);
        if ($rankData) {
            $rankData = $rankData;
        } else {
            $rankData = 0;
        }
        $autobidExist = $this->bidder_model->checkAutocutBidderBidValue($auctionID);
        $lastBidderBidValue = $this->bidder_model->LastBidderBidValue($auctionID);
        $getAutocutRow = $this->bidder_model->getAutocutBidderBidValue($auctionID);

        $str_auction_end_date = strtotime($adata->auction_end_date);
        $remainDuration = $str_auction_end_date - $currentTime;
        $remainTime = findRemainTime($adata->auction_end_date, $adata->auction_pause_time);

        $totalbidding = $this->banker_model->CountAuctionBidingData($auctionID);
        $lastbidArr = $this->banker_model->AuctionLastBidingData($auctionID);
        $auctionLogedbidder = $this->banker_model->AuctionLoggedBidderData($auctionID);
        $gain = $this->banker_model->calculateGainvalue($auctionID);
        $firstbidValue = $lastbidArr->bid_value;

        if ($lastbidArr->bid_value > 0) {
            $lastbid = $lastbidArr->bid_value;
            $bidtextval = $adata->bid_inc + $lastbid;
            $lastbidtextval = $lastbid;
        } else {
            $lastbid = '0.00';
            $lastbidtextval = $adata->opening_price;
            if ($adata->opening_price) {
                //$bidtextval = $adata->opening_price;
                $bidtextval = $adata->opening_price+$adata->bid_inc;
            } else {
                //$bidtextval = $adata->reserve_price;
                $bidtextval = $adata->reserve_price+$adata->bid_inc;
            }
        }
      

        if ($lastbid > 0) {
            $h1price = $lastbid;
        } else {
            if ($adata->opening_price) {
                $h1price = $adata->opening_price;
            } else {
                $h1price = $adata->reserve_price;
            }
        }

        if ($bankerAccepted == 1) {
            ?>               
            <div class="box-head custom123 no_cursor">Bidding Hall</div>
            <div style="width:100%; background:#fff;padding-bottom:15px;">
				
				<?php if(time() >= strtotime($adata->auction_end_date) && $adata->auction_bidding_activity_status != 1)
				{
					?>
					<div id="wait_auction" style="width:95%; float:left; border-radius:2px; font-size:12px; color:#000; padding:30px 0 30px 5%;background-color: #fff;">
						<b style="font-size:15px;"> Please Wait <?php echo BIDDER_AUCTION_END_MESSAGE_TIME;?> seconds to view final report!!</b>
					</div>	
					<?php	
				}
				else
				{?>
            <div class="nit_time_remaining"><span style="background-color:#f00;padding:5px;color:#fff;font-size:18px;font-weight:normal;">Time Remaining -</span>  <?php if ($adata->auction_bidding_activity_status == 1) { ?>
                    <div class="heading" style="display:inline-block;">
                        Auction Paused!!! : <?php echo $remainTime['days']; ?> Days <?php echo $remainTime['hours']; ?> hours : <?php echo $remainTime['minute']; ?> Minutes : <?php echo $remainTime['second']; ?> Seconds
                    </div>
                <?php } else { ?>
                    <div data-countdown="<?php echo $adata->auction_end_date; ?>" style="display:inline-block;"></div>
                <?php } ?></div>
             <?php } ?>
				<?php 
					$marqueeMsg = GetTitleByField('tbl_auction_alert', "is_deleted=0 AND status=1 AND alert_type='m' AND auction_id='" . $auctionID . "'", 'message');
					$panelMsg = GetTitleByField('tbl_auction_alert', "is_deleted=0 AND status=1 AND alert_type='p' AND auction_id='" . $auctionID . "'", 'message');
				?>
				
				<div class="marquee-cont" style="<?php echo ($marqueeMsg !='')?'display:block;':'display:none'; ?>">
					<marquee bgcolor="#dcf0f9" scrollamount="20"><span style="color:#000;font-size:25px;padding:5px;"><?php echo $marqueeMsg; ?></span></marquee>
				</div>
				<div class="panel-msg-cont" style="<?php ($panelMsg !='')?'display:block;':'display:none'; ?>">
				<?php echo $panelMsg; ?>
				</div>	
				<span style="font-weight: bold;	font-size:12px;padding-left:5px;">Key links</span>
				<div style="float:right;margin-right:5px;font-size:12px;">
				<!--<a onclick="return bidderHoleinfoPopup('owner_uploaded_file', '<?php echo $auctionID; ?>');" href="javascript:" class="grn-txt">View notice & document </a>--> <a href="/owner/view_uploadedfile/<?php echo $auctionID; ?>"  class="grn-txt iframeColorbox">View notice & document </a><?php if($adata->auto_bid_cut_off==1 && $getAutocutRow->auto_bid <= $h1price) { ?> | <a href="<?php echo base_url()?>owner/buylistLiveAuctionsAutoBid/<?php echo $auctionID; ?>" class="grn-txt">Auto Bid</a><?php } ?> | <!--<a onclick="return bidderHoleinfoPopup('owner_bid_history', '<?php echo $auctionID; ?>','<?php echo $userid; ?>');" href="javascript:" class="grn-txt">Bid history</a>--> <a href="/owner/view_own_bid_history/<?php echo $auctionID; ?>" class="grn-txt iframeColorbox">Bid history</a> <!-- onclick="return bidderHoleinfoPopup('owner_eventDetaillist', '<?php //echo $auctionID; ?>');"-->
				</div>
			</div>
			<?php
				  if($this->session->userdata('response_msg_'.$auctionID))
				  {
					  if($this->session->userdata('response_msg_'.$auctionID) == 'Bid Submitted SuccessFully' || $this->session->userdata('response_msg_'.$auctionID) == 'DSC Verified  SuccessFully')
					  {
						  $successmsg = 'success_msg';
					  }else{
						  $successmsg = 'fail_msg';
					  }
				  }
				 ?>
				<span class="<?php echo $successmsg;?>" id="spMsg<?=$auctionID;?>">
					 <?php  
					if($this->session->userdata('response_msg_'.$auctionID))
					  {
						echo ucwords(strtolower($this->session->userdata('response_msg_'.$auctionID)));
						$this->session->set_userdata('response_msg_'.$auctionID,'');
					  }
					  ?>
				</span> 
				
				<div class="table-section"> 
					<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">							
						<tbody role="alert" aria-live="polite" aria-relevant="all">								
							<tr class="odd">
								<td width="33%">Current date and time: <span style="width:100%;font-size: 11px; font-weight:bold;" id="clock"></span>
								</td>
								<td width="33%">Start date and time: <span style="width:100%;font-size: 11px;font-weight:bold;"><?php echo date('d-m-Y H:i:s',strtotime($adata->auction_start_date));?></span></td>
								<td width="33%">End date and time: <span style="width:100%;font-size: 11px;font-weight:bold;"><?php echo date('d-m-Y H:i:s',strtotime($adata->auction_end_date));?></span>
								</td>
						  </tr>
						  <tr class="odd">
								<td width="33%">Reserve Price: <span style="width:100%;font-size: 11px; font-weight:bold;"><?php echo $adata->reserve_price;?></span>					
								</td>
								<td width="33%">Bid Increment : <span style="width:100%;font-size: 11px;font-weight:bold;"><?php echo $adata->bid_inc;?></span></td>
								<td width="33%">Last Bid Submitted By You : <span style="width:100%;font-size: 11px;font-weight:bold;"><?php echo $lastBidderBidValue ?></span>
								</td>
						  </tr>
						  <tr class="odd">
								<td>H1 bid: <span style="width:100%;font-size: 11px; font-weight:bold;"><?php if($lastbid > 0){	echo $h1price; }?></span>					
								</td>
								<td>Your rank : <?php if($rankData!=0){?><span style="width:100%;font-size: 25px;font-weight:bold;padding:2px 10px;<?php if($rankData==1){echo 'background-color:green';}else{echo 'background-color:red';}?>" class="rank"> <?php if($rankData!=0){ echo $rankData; }  ?></span></td><?php }?>
								<td> &nbsp;
								</td>					
							</tr>   
						</tbody>             
					 </table>					
				</div>
				
			
			<div style="width:100%; float:left; background:#fff;">
				<!--<br>-->
				<div style="background:#fff; padding:2% 0;text-align:left;clear:both;">
					<a style="color:#0717f0;font-size: 14px;" href="<?php echo base_url();?>owner">Back</a> 
					 <?php /*?><input name="Save" value="Back" onclick="window.location.href='/owner/'" type="button" class="button_grey"><?php */?>
					 <span style="float:right;">
					 <?php /*?><input name="Save" value="Refresh" onclick="location.reload(true);"  type="button" class="button_grey"><?php */?>
					 <img src="<?php echo base_url();?>bankeauc/images/refresh.jpg" onclick="location.reload(true);" style="width:80px;cursor:pointer;"/>
					 </span>
				</div>
            <div class="row1">
               <!-- <?php  if ($auto_bid_cut_off == 1) { ?>
                    <div class="one_fourth">Auto Bid Cut Off
                        <span>
                            <?php
                            if ($getAutocutRow->auto_bid) {
                                echo $getAutocutRow->auto_bid;
                            } else {
                                echo '0';
                            };
                            ?>
                        </span>
                    </div>
                <?php } ?>
                <div class="one_fourth">Last Bid<span><?php echo $lastBidderBidValue ?></span>
                </div>
                <div class="one_fourth">
					H1 Bid
					<span>
						<?php if($lastbid > 0){	echo $h1price; }?>
					</span>
				</div>
               <div class="one_fourth" style="padding-bottom:10px;" >Rank
                 <?php if($rankData!=0){ ?>
                <div class="rank"><?php echo $rankData; ?></div>
                 <?php }  ?>
                </div>
                -->
               <?php 
               //echo $is_accept_tc;
               if ($is_accept_tc == 1) 
               { 
				  // echo 'inside';
				   
				   ?>
                    <?php if (($status != 4) && ($status != 3)) { ?>
                        <input type="hidden" value="<?php echo $max_auto_bid; ?>" id="max_auto_bid_<?php echo $adata->id; ?>" name="max_auto_bid_<?php echo $adata->id; ?>">
                        <input type="hidden" value="<?php echo $adata->bid_inc; ?>"  name="bidder_bid_inc_<?php echo $adata->id; ?>" id="bidder_bid_inc_<?php echo $adata->id; ?>" class="input-sort">
                        <input type="hidden" value="<?php echo $adata->opening_price; ?>"  name="bid_opening_price_<?php echo $adata->id; ?>" id="bid_opening_price_<?php echo $adata->id; ?>" >
                        <?php if ($firstbidValue <= 0) { ?>
                            <input type="hidden" value="opening_bid" id="enteredbidtype_<?php echo $adata->id; ?>" name="enteredbidtype_<?php echo $adata->id; ?>"> 
                        <?php } else { ?>
                            <input type="hidden" value="chess_bid" id="enteredbidtype_<?php echo $adata->id; ?>" name="enteredbidtype_<?php echo $adata->id; ?>"> 
                        <?php } ?>
                        <input type="hidden" value="<?php echo $lastbidtextval; ?>" id="lastbidtextval_<?php echo $adata->id; ?>" name="lastbidtextval_<?php echo $adata->id; ?>"> 
                        <input type="hidden" value="<?php echo $bidtextval; ?>"  name="manual_bidder_bid_value_<?php echo $adata->id; ?>" id="manual_bidder_bid_value_<?php echo $adata->id; ?>" class="input-sort">
                          <input type="hidden" value="<?php if($lastbid > 0){ echo $h1price; } else{ echo '';}?>" id="h1val_<?php echo $adata->id; ?>" name="h1val_<?php echo $adata->id; ?>"> 
                        
                       <?php if($adata->dsc_enabled==1 && false){ 
	               $dscverified_status = GetTitleByField('tbl_auction_participate', "bidderID='" . $userid . "' AND auctionID='" . $auctionID . "'", 'dsc_verified_status');
	               $checkuserdata=$this->session->userdata('response_dsc_'.$auctionID);
                        if(isset($checkuserdata) && $checkuserdata=='dscverified'){
                            $dscverified_status_session=1;
                        }else{
                            $dscverified_status_session=0; 
                        }
                       
                      // if($dscverified_status==1 && $dscverified_status_session==1){ 
						   if($dscverified_status==1){
						  ?>       
                      <?php if (($autobidExist <= 0) || ($getAutocutRow->auto_bid <= $h1price)) { ?>
            <div class="half no_rgt_border" style="background:#fff; border:none!important;">
                Bid Amount
                <div class="cut_off"> 
                    <input type="text"  onchange="showText(this);"  onkeypress="return isNumberKey(event);" value="<?php echo $bidtextval; ?>"  name="bidder_bid_value_<?php echo $adata->id; ?>" id="bidder_bid_value_<?php echo $adata->id; ?>" class="input-sort">
                    <div class="float-right inc_dcm_box">
						
                       <span class="increment" onclick="increseORdecriseBidValue('increase', '<?php echo $adata->id; ?>',clicks);"></span>
                       <span class="decrement" onclick="increseORdecriseBidValue('decrease', '<?php echo $adata->id; ?>');"></span>
                    </div>
                    
                </div>
                <span class="amount_in_words" id="price_in_ruppees_<?php echo $adata->id; ?>"></span>
                <script type="text/javascript">
                var button = document.getElementById('changeText');
                var output = document.getElementById('price_in_ruppees_<?php echo $adata->id; ?>');
                var input = document.getElementById('bidder_bid_value_<?php echo $adata->id; ?>');
                input.addEventListener('input', showText);
                // Timer of auction 
             </script>
             <div class="live_bid_cnt_btn">
               <?php if ($adata->auction_bidding_activity_status == 1) { ?>
            <input name="Save" value="Submit" type="button" class="b_submit float-left button_grey">
                <?php } else { ?>
            <input name="Save" value="Submit" type="button" onclick="saveLiveAuctionBid(<?php echo $adata->id ?>);" class="b_submit float-left button_grey">
                    <?php
                }
            }}else{ ?>
              
              <?php  $bidder_added_type = GetTitleByField('tbl_auction_participate', "bidderID='" . $userid . "' AND auctionID='" . $auctionID . "'", 'added_type');?>
              <?php if($bidder_added_type=='bidder' || true){ ?>

			  <a data-auction="<?php echo $auctionID; ?>" href="#form_bg" class="check_dsc button_grey" style="display: none;"">Check DSC</a>
              <input type="checkbox" style="width:20px" class="dscsecure_checkbox" value="<?php echo $auctionID;?>" id="dscsecure_checkbox<?php echo $auctionID; ?>"    ><span>I agree that : I have read and accepted the <?php /* ?><a onclick="return bidderHoleinfoPopup('owner_agreement_privacy_policy', '<?php echo $auctionID; ?>');"  class="terms grn-txt" href="javascript:">User Agreement and Privacy Policy.</a><?php */ ?><a class="terms grn-txt" href="#" target="_blank">User Agreement and Privacy Policy.</a> I may receive communications from <?php echo BRAND_NAME; ?>. </span>       
              <?php }else{ ?>
              <input type="checkbox" style="width:20px" id="dscsecure_checkbox<?php echo $auctionID; ?>" onclick="CheckvalidDSC_helpdesk(<?php echo $auctionID; ?>);"   ><span>I agree that : I have read and accepted the <a href="#" target="_blank"  class="terms grn-txt">User Agreement and Privacy Policy.</a> I may receive communications from <?php echo BRAND_NAME; ?>  </span>       
              <?php } ?>   
            <?php }
             }else{ ?>
				<?php if ((time() <= strtotime($adata->auction_end_date) && $adata->auction_bidding_activity_status != 1)) {
					$auctionNotPriceBasis = array(99);
				//(($autobidExist <= 0) || ($getAutocutRow->auto_bid <= $h1price)) && 	
					?>
					<!--
					  <table>
						  <tr>
							  <td>&nbsp;</td>
						  </tr>
					  </table>-->
					                     
                    <div class="table-section"> 
						<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
							<thead>
								<tr class="odd">
								  <td width="7%" align="left" valign="top" class=""><strong>Sr.No.</strong></td>
								  <td align="left" valign="top" class=""><strong>Property Details</strong></td>
								  <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
								  <td align="left" valign="top" class=""><strong>Plot UOM</strong></td>
								  <td align="left" valign="top" class=""><strong>Carpet Area</strong></td>
								  <td align="left" valign="top" class=""><strong>Carpet UOM</strong></td>
								  <?php if(!in_array($adata->id,$auctionNotPriceBasis) && false) {?><td align="left" valign="top" class=""><strong>Price Basis</strong></td><?php } ?>
								  <td align="left" valign="top" class=""><strong>Rate in Rs.</strong></td>
								  <td width="30%" align="left" valign="top" class=""><strong>Rate in Words</strong></td>
								 <?php if(!in_array($adata->id,$auctionNotPriceBasis) && false) {?><td align="left" valign="top" class=""><strong>Total Value</strong></td><?php } ?>
								  <td align="left" valign="top" class=""><strong>Bid</strong></td>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">								
								<tr class="even">
									<td>1</td>
									  <td><?php echo $adata->PropertyDescription; ?></td>
									  <td><input type="hidden" name="plotareaVal" id="plotareaVal_<?php  echo $adata->id; ?>" value="<?php echo $adata->area; ?>"/><?php echo ($adata->property_height != '')?$adata->property_height:'N/A'; ?></td>
									<td><?php echo ($plot_area_uom!='')?$plot_area_uom:'N/A'; ?></td>
									<td><input type="hidden" name="areaVal" id="areaVal_<?php  echo $adata->id; ?>" value="<?php echo $adata->area; ?>"/><?php echo ($adata->area != '')?$adata->area:'N/A'; ?></td>
									<td><?php echo ($areaUnit != '')?$areaUnit:'N/A'; ?></td>
									 <?php if(!in_array($adata->id,$auctionNotPriceBasis) && false) {?><td><?php echo 'Price per '.$pricePerUnit; ?></td><?php } ?>
									<td> 
										<div class="half no_rgt_border" style="border:none!important;">
										<script>
											var clicks = 0;
										</script>
										<div class="cut_off"> 
											<input type="text" class="dynamic_price_live" onkeypress="return isNumberKey(event);" value="<?php echo $bidtextval; ?>"  name="bidder_bid_value_<?php echo $adata->id; ?>" id="bidder_bid_value_<?php echo $adata->id; ?>" class="input-sort" readonly >
											<div class="float-right inc_dcm_box" <?php
											if($getAutocutRow->auto_bid > $h1price) { echo 'style=display:none;'; } ?>>
											<span class="increment" onclick="increseORdecriseBidValue('increase', '<?php echo $adata->id; ?>','',clicks);"></span>
											<span class="decrement" onclick="increseORdecriseBidValue('decrease', '<?php echo $adata->id; ?>');"></span>
										</div>
											<?php if($getAutocutRow->auto_bid > $h1price) { echo '<div style="float:left;font-size:12px;">'.'Auto Bid: '.$getAutocutRow->auto_bid.'</div>';}?>
										</div>
										<span class="amount_in_words" id="price_in_ruppees_<?php echo $adata->id; ?>"></span>
										<script type="text/javascript">
											//End of numToWords function
											var button = document.getElementById('changeText');
											var output = document.getElementById('price_in_ruppees_<?php echo $adata->id; ?>');
											var input = document.getElementById('bidder_bid_value_<?php echo $adata->id; ?>');
											input.addEventListener('input', showText);                             
											// Timer of auction 
										</script>
									</td>
									<td><span id="riw_<?php echo $auctionID;?>" class="riwClass"></span></td>
									 <?php if(!in_array($adata->id,$auctionNotPriceBasis) && false) {?><td><input type="text" name="total_bid_val_<?php echo $adata->id; ?>"  id="total_bid_val_<?php echo $adata->id; ?>" readonly /></td><?php } ?>
									<td> 
										<div class="live_bid_cnt_btn" >
											<?php if ($adata->auction_bidding_activity_status == 1 && false) { ?>
											<input name="Save" value="Submit" type="button" class="b_submit float-left button_grey" <?php if($getAutocutRow->auto_bid > $h1price) {echo 'disabled'; } ?> >
											<?php } else { ?>
											<input name="Save" value="Submit" type="button" onclick="saveLiveAuctionBid(<?php echo $adata->id ?>);" class="b_submit float-left button_grey" <?php if($getAutocutRow->auto_bid > $h1price) {echo 'disabled'; } ?> >
											<?php
											}
											?>
										</div>
									</td>
							  </tr>
							</tbody>             
						 </table>					
					</div>
					  <?php
					}
                            
                 } ?>
                            
					<div class="bid_error" style="text-align:center;" id="error_<?php echo $adata->id; ?>"></div>
					<br><br>
					<div style="font-size:13px;background-color:#808080;color:#ffffff;padding:5px 5px">						
						<strong>Note ::</strong>
						<br><br>
							You are advised not to wait till last minute or few seconds to submit your bid to avoid complications related to internet connectivity, network problems, system crash down, power failure, etc. Neither department nor <?php echo BRAND_NAME; ?> Auction are responsible for any unforeseen circumstance.
					</div>
			   </div>     
						
							
                        <?php } else { ?>
                            <?php if ($status == '3') { ?>
                                <div  id="error_<?php echo $adata->id; ?>" style="width:95%; float:left; background:#f78d8d; border:solid 1px #F00; border-radius:2px; font-size:12px; color:#000; padding:30px 0 30px 5%;">
                                    Auction on stay Mode.
                                </div>


                            <?php } else if ($status == '4') { ?>
                                <div  id="error_<?php echo $adata->id; ?>" style="width:95%; float:left; background:#f78d8d; border:solid 1px #F00; border-radius:2px; font-size:12px; color:#000; padding:30px 0 30px 5%;">
                                    Auction has been canceled.
                                </div>
                            <?php } ?>
                            <?php
                        }
                    } 
                    
                    
                    
                    else 
                    {
                        ?>

                         <div class="row" style="font_size:12px;">
                            <div  id="is_accept_tc_upid_<?php echo $auctionID; ?>">
                                  <?php if($adata->dsc_enabled==1){ ?>
                                  
                                       
                                    <?php  $bidder_added_type = GetTitleByField('tbl_auction_participate', "bidderID='" . $userid . "' AND auctionID='" . $auctionID . "'", 'added_type');?>
                                    <?php if($bidder_added_type=='bidder' || true){ ?>
									<a data-auction="<?php echo $auctionID; ?>" href="#form_bg" class="check_dsc button_grey" style="display: none;"">Check DSC</a>
                                   <input type="checkbox" style="width:20px" class="dscsecure_checkbox" value="<?php echo $auctionID;?>" id="dscsecure_checkbox<?php echo $auctionID; ?>" ><span>I agree that : I have read and accepted the <a href="#" target="_blank"  class="terms grn-txt">User Agreement and Privacy Policy.</a> I may receive communications from '.BRAND_NAME.'. </span>       
                                   <?php }else{ ?>
                                   <input type="checkbox" style="width:20px" id="dscsecure_checkbox<?php echo $auctionID; ?>" onclick="CheckvalidDSC_helpdesk(<?php echo $auctionID; ?>);"   ><span>I agree that : I have read and accepted the <a href="#" target="_blank"  class="terms grn-txt">User Agreement and Privacy Policy.</a> I may receive communications from <?php echo BRAND_NAME; ?> . </span>
                                  <?php } ?>
                                   <?php }else{ ?>
                                  <input type="checkbox" style="width:20px" onclick="is_accept_tc_update(<?php echo $auctionID; ?>);" name="is_accept_tc<?php echo $auctionID; ?>" id="is_accept_tc<?php echo $auctionID; ?>" value="1"><span>I agree that : I have read and accepted the <a href="#" target="_blank"  class="terms grn-txt">User Agreement and Privacy Policy.</a> I may receive communications from <?php echo BRAND_NAME; ?>. </span>
                                  <?php }?>
                                
                                
                                <!--<input type="checkbox" style="width:20px" onclick="is_accept_tc_update(<?php echo $auctionID; ?>);" name="is_accept_tc<?php echo $auctionID; ?>" id="is_accept_tc<?php echo $auctionID; ?>" value="1"><span>I agree that : I have read and accepted the <a onclick="return bidderHoleinfoPopup('owner_agreement_privacy_policy', '<?php echo $auctionID; ?>');"  class="terms grn-txt" href="javascript:">User Agreement and Privacy Policy.</a> I may receive communications from C1india. </span>-->
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                }
            }
        } else { 
            
            ?>
          <?php 
			/*
			if($this->owner_model->getLoggedInOwner())
			{?>
			<div id="wait_auction" style="width:95%; float:left; border-radius:2px; font-size:12px; color:#000; padding:30px 0 30px 5%;">
				<b style="font-size:15px;"> Please Wait <?php echo BIDDER_AUCTION_END_MESSAGE_TIME; ?> seconds to view final report!!</b>
			</div>
			<?php 
				}
			//echo $this->owner_model->getLoggedInOwner();
			*/ 
			?>
          <div id="no_live_auction" style="width:95%; float:left; background:#f78d8d; display: block;border:solid 1px #F00; border-radius:2px; font-size:12px; color:#000; padding:30px 0 30px 5%;">
            You do not have any live Auction. !!
          </div>
       <script>
        //setTimeout(function(){ $("#wait_auction").css('display','none'); $("#no_live_auction").css('display','block'); }, parseInt(<?php echo BIDDER_AUCTION_END_MESSAGE_TIME; ?>) * 1000);
       </script>
        <?php } ?>
   



<script>
    $(document).ready(function(){
	var days =0;
    $('[data-countdown]').each(function () {
        var $this = $(this), finalDate = $(this).data('countdown');
        
        $this.countdown(finalDate, function (event) {
            days = event.strftime('%D');
            if(days > 0)
            {
				var daysCount = event.strftime('<span class="col"><span style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">%D</span> <label style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">Day</label> ');				
			}
			else
			{
				var daysCount = "";
			}
			
            $this.html(daysCount + event.strftime('<span class="col"><span style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">%H</span></span> <span class="col"><span style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">%M</span></span> <span class="col"><span style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">%S</span></span>'));
        });
    });    
    $("#bidder_bid_value_<?php echo $adata->id; ?>").change();
    });
</script>