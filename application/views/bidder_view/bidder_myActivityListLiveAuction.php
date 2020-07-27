<script type="text/javascript" src="/js/jquery.countdown.js"></script>
<section>
  <?php echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div class="container">
          <?php echo $leftPanel?>
				  
 <div id="live_auction_data" class="secttion-right">
		<?php
		//echo "<pre>";
		//	print_r($auctionData);
		//echo $currentdate=date("Y-m-d:h:i:s");
		$totalLiveAuctionData=($auctionData);
		//echo "</pre>";
		if($totalLiveAuctionData!=0)
		{
			
			$currentTime=time();	
		foreach ($auctionData as $adata)
		{	
			$auctionID=$adata->id;
			$auto_bid_cut_off=$adata->auto_bid_cut_off;
		
			$rankData=$this->bidder_model->getBidderAuctionRank($auctionID);
			if($rankData){
				$rankData=$rankData;
			}else{
				$rankData=0;
			}
			$autobidExist=$this->bidder_model->checkAutocutBidderBidValue($auctionID);
			$getAutocutRow=$this->bidder_model->getAutocutBidderBidValue($auctionID);

			$str_auction_end_date=strtotime($adata->auction_end_date);
			$remainDuration=$str_auction_end_date-$currentTime;
			$remainTime=findRemainTime($adata->auction_end_date,$adata->auction_pause_time);
			
			$totalbidding=$this->banker_model->CountAuctionBidingData($auctionID);
			$lastbidArr=$this->banker_model->AuctionLastBidingData($auctionID);
			$auctionLogedbidder=$this->banker_model->AuctionLoggedBidderData($auctionID);
			$gain=$this->banker_model->calculateGainvalue($auctionID);
			
			if(@$lastbidArr->bid_value>0){$lastbid=$lastbidArr->bid_value;}else{$lastbid='0.00';}
			
			
			if($lastbid>0){
			$bidtextval=$adata->bid_inc+$lastbid;	
			}else{
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
			
			
				
			if($lastbid>0){
				$lastbidtextval=$lastbid;		
			}else{
				$lastbidtextval=$adata->opening_price;		
			}
		?>   

 <div class="row">
           
            <div class="toplinks">    <a href="/buyer/view_uploadedfile/<?php echo $adata->id; ?>" class="grn-txt">View Uploaded File </a> <a href="/buyer/view_bid_history/<?php echo $adata->id; ?>" class="grn-txt">Show Event Details</a></div>
              
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
				  
                  <th width="15%" align="left" valign="top">Last Bid</th>
                  <th width="20%" align="left" valign="top">H1 Bid</th>
                  <th width="15%" align="left" valign="top">Rank</th>                 
                </tr>
              </thead>
              
              <tbody>
                 <tr class="even">
				  <?php if($auto_bid_cut_off==1){ ?>
                  <td align="left" valign="middle"><?php if($getAutocutRow->auto_bid){echo $getAutocutRow->auto_bid;}else{echo '0';} ;?></td>
				   <?php } ?>
                  <td align="left" valign="middle"><?php echo $lastbid ?></td>
                  <td align="left" valign="middle"><?php echo $h1price; ?> </td>
                  <td align="left" valign="middle"><div class="rank"><?php echo $rankData;?></div></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="6">
				 
				<input type="hidden" value="<?php echo $adata->bid_inc;?>"  name="bidder_bid_inc_<?php echo $adata->id; ?>" id="bidder_bid_inc_<?php echo $adata->id; ?>" class="input-sort">
				<input type="hidden" value="<?php echo $adata->opening_price;?>"  name="bid_opening_price_<?php echo $adata->id; ?>" id="bid_opening_price_<?php echo $adata->id; ?>" >
				<input type="hidden" value="<?php echo $lastbidtextval;?>" id="lastbidtextval_<?php echo $adata->id; ?>" name="lastbidtextval_<?php echo $adata->id; ?>"> 
				 <input type="hidden" value="<?php echo $bidtextval;?>"  name="manual_bidder_bid_value_<?php echo $adata->id; ?>" id="manual_bidder_bid_value_<?php echo $adata->id; ?>" class="input-sort">
				<?php if($auto_bid_cut_off==1){ ?>
					<div class="float-left">
					<label>Set Auto Bid cut Off</label>
					<input type="text"  class="input-normal" value="<?php echo $bidtextval;?>"  name="bidder_autobid_value_<?php echo $adata->id; ?>" id="bidder_autobid_value_<?php echo $adata->id; ?>">
					</div>
					
				<?php if($getAutocutRow->auto_bid){ ?>
					<input name="Save" value="Submit Auto Bid"  type="button" class="b_submit float-left">
				<?php }else{ ?>
					<input name="Save" onclick="saveAutobidLiveAuctionBid(<?php echo $adata->id; ?>);" value="Submit Auto Bid"  type="button" class="b_submit float-left">
				<?php } ?>
					
				 <?php }?>
				
				<?php if($autobidExist <=0) { ?>
                  <div class="float-left">
                  <label>Bid Amount </label>
                 <div class="input-incre-decre">
				 <input type="text" value="<?php echo $bidtextval;?>"  name="bidder_bid_value_<?php echo $adata->id; ?>" id="bidder_bid_value_<?php echo $adata->id; ?>" class="input-sort">
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
                </tr>
              </tfoot>
            </table>
            </div>
            </div>
		<?php } 
		
} else{ ?>
			<div class="message-box tpmrg20 btmrg20" style="display:block;" >
           <?php /* ?><span class="icon-circle-big"><img src="/images/icon-msg.png"></span><?php */ ?>
           <div class="congress-txt"> You don not have any live auction</div>
			</div>
<?php } ?>			  
			
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<link rel="stylesheet" href="/css/colorbox.css" />
<script src="/js/jquery.colorbox.js"></script>
<script>
	$(".view_uploadedfile").colorbox({iframe:true, width:"50%", height:"50%"});
	$(".view_bid_history").colorbox({iframe:true, width:"50%", height:"50%"});
</script>

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
	$("#live_auction_data").load('/bidder/liveBiddingAuctionsdatatable');
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
