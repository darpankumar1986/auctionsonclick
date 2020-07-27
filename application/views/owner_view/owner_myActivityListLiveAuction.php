<?php
//echo $getauctionID;
?>
<script type="text/javascript" src="/js/jquery.countdown.js"></script>
<section>
    <?php echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
          
        <div class="search-row">
          <div class="srch_wrp">
            <input type="text" value="Search" id="search" name="search">
            <span class="ser_icon"></span> </div>
          <a href="#">Advance Search+</a> 
        </div>
          
        <div id="tab-pannel6" class="btmrgn">
            
          <ul class="tabs6">
            <a href="/owner"><li class="active" rel="tab1">Buy</li></a>
            <a href="/owner/sell"><li rel="tab2">Sell</li></a>
          </ul>
            
          <div class="tab_container6"> 
              
            <!---- buy tab container start ---->
            <div id="tab1" class="tab_content6" style="display:block">
              <div id="tab-pannel3" class="btmrgn">
                  <ul class="tabs3">
                    <a href="/owner/"><li  rel="tab9">My Summary</li></a>
                  <a href="/owner/liveAuction/"><li class="active" rel="tab10">My Activity</li></a>
                  <a href="/owner/myMessage/"><li rel="tab11">My Message</li></a>
                  <a href="/owner/myProfile/"><li rel="tab12">My Profile</li></a>
                </ul>
                <div class="tab_container3 whitebg"> 
                 
                  
                  <!-- Sell > My Activity start -->
                  
                  <div id="tab6" class="tab_content3">
                    <div class="container">
                      <?php echo $leftsidebar;?>
                      <div class="secttion-right">
						<div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <h3><?php echo $heading?></h3>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
	<?php
	
		//echo "<pre>";
		//print_r($auctionData);
			//echo $currentdate=date("Y-m-d:h:i:s");
		//echo "</pre>";
	?>				
					
               <div id="live_auction_data">
		<?php
		
		$totalLiveAuctionData=($auctionData);
		$userid=$this->session->userdata['id'];
		if($totalLiveAuctionData!=0)
		{
			$currentTime=time();	
		foreach ($auctionData as $adata)
		{	$auctionID=$adata->id;
			$status=$adata->status;
			$is_accept_tc=$adata->is_accept_auct_training;
			if(($adata->first_opener > 0) && ($adata->second_opener<=0))
			{
				$participate_status=GetTitleByField('tbl_auction_participate', "bidderID='".$userid."' AND auctionID='".$auctionID."'", 'operner1_accepted');
				if($participate_status>0){
					$bankerAccepted=1;	
				}else{
					$bankerAccepted=0;		
				}
				
			}else if(($adata->second_opener > 0) && ($adata->first_opener > 0))
			{
				$participate_status=GetTitleByField('tbl_auction_participate', "bidderID='".$userid."' AND auctionID='".$auctionID."'", 'operner2_accepted');
				if($participate_status>0){
					$bankerAccepted=1;	
				}else{
					$bankerAccepted=0;		
				}
			}
			
			$auto_bid_cut_off=$adata->auto_bid_cut_off;
			$max_auto_bid=$this->bidder_model->getMaxAutocutBidderBidValue($auctionID);
			$rankData=$this->bidder_model->getBidderAuctionRank($auctionID);
			if($rankData){
				$rankData=$rankData;
			}else{
				$rankData=0;
			}
			$autobidExist=$this->bidder_model->checkAutocutBidderBidValue($auctionID);
			$lastBidderBidValue=$this->bidder_model->LastBidderBidValue($auctionID);
			$getAutocutRow=$this->bidder_model->getAutocutBidderBidValue($auctionID);

			$str_auction_end_date=strtotime($adata->auction_end_date);
			$remainDuration=$str_auction_end_date-$currentTime;
			$remainTime=findRemainTime($adata->auction_end_date,$adata->auction_pause_time);
			
			$totalbidding=$this->banker_model->CountAuctionBidingData($auctionID);
			$lastbidArr=$this->banker_model->AuctionLastBidingData($auctionID);
			$auctionLogedbidder=$this->banker_model->AuctionLoggedBidderData($auctionID);
			$gain=$this->banker_model->calculateGainvalue($auctionID);
			$firstbidValue=$lastbidArr->bid_value;
			
			if($lastbidArr->bid_value>0)
			{
				$lastbid=$lastbidArr->bid_value;
				$bidtextval=$adata->bid_inc+$lastbid;
				$lastbidtextval=$lastbid;
			}else{
				$lastbid='0.00';
				$lastbidtextval=$adata->opening_price;
				if($adata->opening_price){
					$bidtextval = $adata->opening_price;
				}else{
					$bidtextval = $adata->reserve_price;
				}
				}
			

			if($lastbid>0){
				$h1price=$lastbid;	
			}else{
				if($adata->opening_price){
					$h1price=$adata->opening_price;
				}else{
					$h1price=$adata->reserve_price;
				}
						
			}
			
			//echo "lastbiddd->".$lastbidtextval;
			
			//echo "<br>auto_bid--".$getAutocutRow->auto_bid;
			//echo "<br>h1price-".$h1price;
			//echo "<br>autobidExist===".$autobidExist;
			//echo "<br>max_auto_bid===".$max_auto_bid;
		
// check accept participation		
if($bankerAccepted==1){	?>   
 <div class="row">
           
            <div class="toplinks"> 
			<a onclick="return bidderHoleinfoPopup('owner_uploaded_file','<?php echo $auctionID;?>');" href="javascript:" class="grn-txt">View Uploaded File </a> 
			<a onclick="return bidderHoleinfoPopup('owner_eventDetaillist','<?php echo $auctionID;?>');" href="javascript:" class="grn-txt">Show Auction Details</a></div>
              
          <div class="tablehead-bg"><div class="heading"><span class="icon_time-remaining"></span>Time Remaining</div>
          <div class="time-left">
                 
			<?php if($adata->auction_bidding_activity_status==1){ ?>
			<div class="heading" style="width:365px;">
				Auction Paused!!! : <?php echo $remainTime['days'];?> Days <?php echo $remainTime['hours'];?> : <?php echo $remainTime['minute'];?> : <?php echo $remainTime['second'];?>
			</div>
			<?php }else{ ?>
			<div data-countdown="<?php echo $adata->auction_end_date;?>"></div>
			<?php } ?>
                  </div>
                  
                    
         <div class="refrence-number">Reference No : <span class="grn-txt2"><?php echo $adata->reference_no?></span> </div>
          </div>
           <div class="table-div">  
			<table border="0" cellpadding="2" cellspacing="1" class="timeTable">
              <thead>
               <tr>
			   <?php if($auto_bid_cut_off==1){ ?>
                  <th width="20%" align="left" valign="top">Auto Bid Cut-off</th>
			   <?php } ?>
				  
                  <th width="25%" align="left" valign="top">Last Bid</th>
                  <th width="30%" align="left" valign="top">H1 Bid</th>
                  <th width="25%" align="left" valign="top">Rank</th>                 
                </tr>
              </thead>
              
              <tbody>
                 <tr class="even">
				  <?php if($auto_bid_cut_off==1){ ?>
                  <td align="left" valign="middle"><?php if($getAutocutRow->auto_bid){echo $getAutocutRow->auto_bid;}else{echo '0';} ;?></td>
				   <?php } ?>
                  <td align="left" valign="middle"><?php echo $lastBidderBidValue ?></td>
                  <td align="left" valign="middle"><?php echo $h1price; ?> </td>
                  <td align="left" valign="middle"><div class="rank"><?php echo $rankData;?></div></td>
                </tr>
              </tbody>
              <tfoot>
			  
		<?php if($is_accept_tc==1){ ?>
			  
			  <?php if(($status != 4) && ($status != 3)){ ?>
			  
                <tr>
                  <th colspan="6">
				<input type="hidden" value="<?php echo $max_auto_bid;?>" id="max_auto_bid_<?php echo $adata->id; ?>" name="max_auto_bid_<?php echo $adata->id; ?>">
				<input type="hidden" value="<?php echo $adata->bid_inc;?>"  name="bidder_bid_inc_<?php echo $adata->id; ?>" id="bidder_bid_inc_<?php echo $adata->id; ?>" class="input-sort">
				<input type="hidden" value="<?php echo $adata->opening_price;?>"  name="bid_opening_price_<?php echo $adata->id; ?>" id="bid_opening_price_<?php echo $adata->id; ?>" >
				
				<?php if($firstbidValue<=0){ ?>
				<input type="hidden" value="opening_bid" id="enteredbidtype_<?php echo $adata->id; ?>" name="enteredbidtype_<?php echo $adata->id; ?>"> 
				<?php }else{ ?>
				<input type="hidden" value="chess_bid" id="enteredbidtype_<?php echo $adata->id; ?>" name="enteredbidtype_<?php echo $adata->id; ?>"> 
				<?php } ?>
				
				<input type="hidden" value="<?php echo $lastbidtextval;?>" id="lastbidtextval_<?php echo $adata->id; ?>" name="lastbidtextval_<?php echo $adata->id; ?>"> 
				
				
				
				
				
				 <input type="hidden" value="<?php echo $bidtextval;?>"  name="manual_bidder_bid_value_<?php echo $adata->id; ?>" id="manual_bidder_bid_value_<?php echo $adata->id; ?>" class="input-sort">
				<?php if($auto_bid_cut_off==1){ 
				
				 if($getAutocutRow->auto_bid)
				 {
					 $getAutocutvalue=$getAutocutRow->auto_bid;
				 }else{
					 
					 $getAutocutvalue=$bidtextval;
					 } 
				?>
				
				
				
					<div class="float-left">
					<label>Set Auto Bid Cut Off</label>
					<input type="text" onkeypress="return isNumberKey(event);"  class="input-normal" value="<?php //echo $getAutocutvalue;?>"  name="bidder_autobid_value_<?php echo $adata->id; ?>" id="bidder_autobid_value_<?php echo $adata->id; ?>">
					</div>
					
				<?php if(($getAutocutRow->auto_bid>0)){ ?>
					<input name="Save" value="Submit Auto Bid"  type="button" class="b_submit float-left">
				<?php }else{ ?>
					<input name="Save" onclick="saveAutobidLiveAuctionBid(<?php echo $adata->id; ?>);" value="Submit Auto Bid"  type="button" class="b_submit float-left">
				<?php } ?>
					
				 <?php }?>
				
				<?php if(($autobidExist <=0) || ($getAutocutRow->auto_bid <= $h1price)) { ?>
                  <div class="float-left">
                  <label>Bid Amount </label>
                 <div class="input-incre-decre">
				 
				 
				 <input type="text"  onkeypress="return isNumberKey(event);" value="<?php echo $bidtextval;?>"  name="bidder_bid_value_<?php echo $adata->id; ?>" id="bidder_bid_value_<?php echo $adata->id; ?>" class="input-sort">
				 
				 
                 <div class="float-right">
                 <span class="increment" onclick="increseORdecriseBidValue('increase','<?php echo $adata->id; ?>');"></span>
                 <span class="decrement" onclick="increseORdecriseBidValue('decrease','<?php echo $adata->id; ?>');"></span>
                 </div>
                 </div>
                 </div>
                 <?php if($adata->auction_bidding_activity_status==1){ ?>
                  <input name="Save" value="Submit" type="button" class="b_submit float-left">
				 <?php } else{?>
				  <input name="Save" value="Submit" type="button" onclick="saveLiveAuctionBid(<?php echo $adata->id?>);" class="b_submit float-left">
				<?php } 
				
				} ?>
				 <div style="color:red" id="error_<?php echo $adata->id; ?>"></div>
				  </th>
			  </tr><?php }else{ ?>
			  <tr>
			   <th colspan="6">
			 
			   <?php
			   if($status == '3') { ?>
				 <div style="color:red" id="error_<?php echo $adata->id; ?>"> Auction on stay Mode</div>
			   
			   <?php }
			   else if($status == '4'){
				   ?>
				  <div style="color:red" id="error_<?php echo $adata->id; ?>"> Auction has been chanced</div> 
			  <?php } ?>
			   
			   </th>
			  </tr>
			  
			  <?php } }else{ ?>
			  
			    <tr>
			   <th colspan="6" id="is_accept_tc_upid_<?php echo $auctionID;?>">
			 <input type="checkbox" onclick="is_accept_tc_update(<?php echo $auctionID;?>);" name="is_accept_tc<?php echo $auctionID;?>" id="is_accept_tc<?php echo $auctionID;?>" value="1"><span>I agree that : I have read and accepted the <a href="#" target="_blank"  class="terms">User Agreement and Privacy Policy.</a> I may receive communications from <?php echo BRAND_NAME; ?>  </span>
			   
			   </th>
			  </tr>
			  <?php } ?>
              </tfoot>
            </table>
            </div>
            </div>
			
		<?php }
		}		
		
} else{ ?>
			<div class="message-box tpmrg20 btmrg20" style="display:block;" >
           <span class="icon-circle-big"><img src="/images/icon-msg.png"></span>
           <div class="congress-txt"> You don not have any live auction</div>
			</div>
<?php } ?>			  
			
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
$(document).ready(function(){
	$('[data-countdown]').each(function() {
	var $this = $(this), finalDate = $(this).data('countdown');
	   $this.countdown(finalDate, function(event) {
		 $this.html(event.strftime('<div class="col"><label>Day</label> <div>%D</div></div><div class="colon">:</div> <div class="col"><label>Hour</label> <div>%H</div></div><div class="colon">:</div><div class="col"><label>Minutes</label> <div>%M</div></div><div class="colon">:</div><div class="col"><label>Seconds</label> <div>%S</div></div>'));
	   });
	 });
 });
</script>


<script>

$(document).ready(function(){
	setInterval(function(){
	$("#live_auction_data").load('/owner/buyliveBiddingAuctionsdatatable/<?php echo $getauctionID; ?>');
	$('[data-countdown]').each(function() {
		var $this = $(this), finalDate = $(this).data('countdown');
		$this.countdown(finalDate, function(event) {
		$this.html(event.strftime('<div class="col"><label>Day</label> <div>%D</div></div><div class="colon">:</div> <div class="col"><label>Hour</label> <div>%H</div></div><div class="colon">:</div><div class="col"><label>Minutes</label> <div>%M</div></div><div class="colon">:</div><div class="col"><label>Seconds</label> <div>%S</div></div>'));
	   });
 });
	
	}, 8000);
});
// Timer of auction 

</script>
<div class="bidderHolePopup" style="display:none;">
 <div class="popup" ><img src="/images/icon-close2.png" class="close">
	<div class="popupcontainer"></div>
 </div>
	<div id="popup-overlay"></div>
</div>
