<script type="text/javascript" src="/js/jquery.countdown.js"></script>
<!--
<span id="future_date"><span>
<script>
ShowRemainTimer('future_date');
</script>-->
<section>
  <?php echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div class="search-row">
          <div class="srch_wrp">
            <input type="text" value="Search" id="search" name="search">
            <span class="ser_icon"></span> </div>
          <a href="#">Advance Search+</a> </div>
        <div id="tab-pannel3" class="btmrgn">
         
          <div class="tab_container3">
            
            
            <!-- #tab1 -->
            <div id="tab6" class="tab_content3">
              <div class="container">
                <?php echo $leftPanel?>
                <div class="secttion-right">
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <h3>Live Auction</h3>
                      
                    </div>	
   <div id="live_auction_data" class="table-section">
   <!--
	<link rel="stylesheet" href="/css/colorbox.css" />
    <script src="/js/jquery.colorbox.js"></script>-->
		<?php
		//echo "<pre>";
		//print_r($auctionData);
		$totalLiveAuctionData=$auctionData;
		//echo "</pre>";
		if($totalLiveAuctionData!=0){
			
		$currentTime=time();	
		foreach ($auctionData as $adata){	
		$str_auction_end_date=strtotime($adata->auction_end_date);
		$remainDuration=$str_auction_end_date-$currentTime;
		$remainTime=findRemainTime($adata->auction_end_date,$adata->auction_pause_time);
		$auctionID=$adata->id;
		$totalbidding=$this->banker_model->CountAuctionBidingData($auctionID);
		$lastbidArr=$this->banker_model->AuctionLastBidingData($auctionID);
		$auctionLogedbidder=$this->banker_model->AuctionLoggedBidderData($auctionID);
		$gain=$this->banker_model->calculateGainvalue($auctionID);
		
		
		
		?>
		<div id="live_auction_section_<?php echo $auctionID;?>" class="row btmrg50">
          <div class="toplinks"> 
		  <a href="/buyer/view_uploadedfile/<?php echo $auctionID;?>" id="view_uploadedfile_<?php echo $auctionID;?>" class="view_uploadedfile1 grn-txt">View Uploaded File </a>
		  <a href="/buyer/view_bid_history/<?php echo $auctionID;?>" id="view_bid_history_<?php echo $auctionID;?>"  class="view_bid_history1 grn-txt">View Bid History</a></div>
          <div class="tablehead-bg">
          <div class="heading"><span class="icon_time-remaining"></span>Time Remaining</div>
          
		    <div id="auction_bidding_timming_<?php echo $auctionID;?>" class="time-left">
			
			<?php if($adata->auction_bidding_activity_status==1){ ?>
			<div class="heading" style="width:365px;">
				Auction Paused!!! : <?php echo $remainTime['days'];?> Days <?php echo $remainTime['hours'];?> : <?php echo $remainTime['minute'];?> : <?php echo $remainTime['second'];?>
			</div>
			<?php }else{ ?>
			<div data-countdown="<?php echo $adata->auction_end_date;?>"></div>
			<?php } ?>
			
			
            </div>
			
          <div class="time-left" style="display:none;">
                  <div class="row">
                     Auction Closed !!                   
                  </div>
               
          </div>
                  
              <div class="refrence-number">Reference No : <span class="grn-txt2"><?php echo $adata->reference_no?></span> </div>
          </div>  
			<table border="0" cellpadding="2" cellspacing="1" class="timeTable">
              <thead>
              <tr>
                  <th width="6%" align="left" valign="top">Quantity</th>
                  <th width="12%" align="left" valign="top">Bid Increment</th>
                  <th width="12%" align="left" valign="top">Opening Price</th>
                  <th width="12%" align="left" valign="top">Auction Currency</th>
                 <th width="15%" align="left" valign="top">End Time</th>
                 <th width="8%" align="left" valign="top">Bid Count</th>
                 <th width="11%" align="left" valign="top">Logged User</th>
                 <th width="12%" align="left" valign="top">Last Bid</th>
                 <th width="8%" align="left" valign="top">Gain</th>
                </tr>
              </thead>
              
              <tbody>
                <tr class="even">
                  <td align="left" valign="middle">1</td>
                  <td align="left" valign="middle"><?php echo $adata->bid_inc;?></td>
                  <td align="left" valign="middle"><?php echo $adata->opening_price;?> </td>
                  <td align="left" valign="middle">INR</td>
                  <td align="left" valign="middle"><?php echo date("jS M-Y H:i:s",strtotime($adata->auction_end_date));?> </td>
                  <td align="left" valign="middle"><?php echo $totalbidding; ?></td>
                  <td align="left" valign="middle"><?php echo $auctionLogedbidder; ?> </td>
                  <td align="left" valign="middle"><?php if(@$lastbidArr->bid_value>0){ echo @$lastbid=$lastbidArr->bid_value;}else{ echo @$lastbid='0.00';}?> </td>
                  <td align="left" valign="middle"><div class="increase"><?php echo $gain; ?>%</div>  <!--<div class="decrease">1</div>--></td>
                </tr>
               
              </tbody>
           <tfoot>
                <tr>
                 <th colspan="9">
			<?php if($adata->auction_bidding_activity_status==1){ ?>
           <input name="Save" id="resume"  value="Resume Auction" onclick="updateAuctionStatus('resume','<?php echo $adata->id;?>');" type="button" class="b_submit float-left">
				 <?php } else{ ?>
		  <input name="Save" id="pause" value="Pause Auction" onclick="updateAuctionStatus('pause','<?php echo $adata->id;?>');" type="button" class="b_submit float-left">
		 <?php } ?>				 
				 </th>
                </tr>
             </tfoot>
            </table>
            </div>

			
		<?php } } else{ ?>
		
			<div class="message-box tpmrg20 btmrg20" style="display:block;" >
           <?php /* ?><span class="icon-circle-big"><img src="/images/icon-msg.png"></span><?php */ ?>
           <div class="congress-txt"> You don't have any live auction</div>
			</div>
			<?php } ?>	

<script>
/*			
 $(".view_uploadedfile1").colorbox({iframe:true, width:"50%", height:"50%"});
 $(".view_bid_history1").colorbox({iframe:true, width:"50%", height:"50%"});
 */
</script>			
	</div>
	
	
	
                  </div>
                </div>
              </div>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script>
	//$(".ajax").colorbox();

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
	$("#live_auction_data").load('/owner/liveBiddingAuctionsdatatable');
	$('[data-countdown]').each(function() {
		var $this = $(this), finalDate = $(this).data('countdown');
		$this.countdown(finalDate, function(event) {
		$this.html(event.strftime('<div class="col"><label>Day</label> <div>%D</div></div><div class="colon">:</div> <div class="col"><label>Hour</label> <div>%H</div></div><div class="colon">:</div><div class="col"><label>Minutes</label> <div>%M</div></div><div class="colon">:</div><div class="col"><label>Seconds</label> <div>%S</div></div>'));
	   });
 });
	
	}, 5000);
});
// Timer of auction 

</script>
