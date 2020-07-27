<link rel="stylesheet" href="http://propertyauctions.com/assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<style>
	.jc-bs3-row.row{width:29% !important;margin-left: 33.33333333%;}
	table tbody tr:hover { background-color:transparent;}
	table.dataTable tr.even, table.dataTable tr.even:hover { background-color: #f6f6f6;border-bottom: 1px solid #ddd;}
	table.dataTable tr.odd, table.dataTable tr.odd:hover{   background-color: #dbdbdb;    border-bottom: 1px solid #ddd;}
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

<script src="/js/jquery.min.js"></script>

<script type="text/javascript" src="/js/jquery.countdown.js"></script>

<?php
		//echo "<pre>";
		//print_r($auctionData);
		$totalLiveAuctionData=($auctionData);
		//echo "</pre>";
		if($totalLiveAuctionData!=0){
			
		$currentTime=time();	
		foreach ($auctionData as $adata){
		$status=$adata->status;			
		$str_auction_end_date=strtotime($adata->auction_end_date);
		$remainDuration=$str_auction_end_date-$currentTime;

		$remainTime=findRemainTime($adata->auction_end_date,$adata->auction_pause_time);
		$auctionID=$adata->id;
		$totalbidding=$this->banker_model->CountAuctionBidingData($auctionID);
		$CountAuctionFinalSubmitData=$this->banker_model->CountAuctionFinalSubmitData($auctionID);
		$lastbidArr=$this->banker_model->AuctionLastBidingData($auctionID);
		//$auctionLogedbidder=$this->banker_model->AuctionLoggedBidderData($auctionID);
		$auctionLogedbidder=$this->banker_model->getLoggedInBidder($auctionID);
		$gain=$this->banker_model->calculateGainvalue($auctionID);
	         if($CountAuctionFinalSubmitData > 0)
		{
		?>
	
		<div id="live_auction_section_<?php echo $auctionID;?>" class=" btmrg50">
         <div class="toplinks"> 
		  </div>
		  <div class="refrence-number nit_number font_18">Property ID: <span class="grn-txt2"><?php echo $adata->reference_no?></span> </div>
          <div class="tablehead-bg">
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
				<div class="nit_time_remaining white_bg">
					<div class="heading"><span class="icon_time-remaining"></span>
						<span style="background-color:#f00;padding:5px;color:#fff;font-size:18px;font-weight:normal;width:auto;">Time Remaining -</span>

						<div id="auction_bidding_timming_<?php echo $auctionID;?>" class="time-left" style="display:inline-block;">
							<?php if($adata->auction_bidding_activity_status==1){ ?>
								<div class="heading">Auction Paused!!! : <?php echo $remainTime['days'];?> Days <?php echo $remainTime['hours'];?> Hours : <?php echo $remainTime['minute'];?> Minutes: <?php echo $remainTime['second'];?> Seconds

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
					</div>
				</div>
				  <?php } ?>
                  <div class="view_half1 white_bg"><a onclick="return bidderHoleinfoPopup('bidder_detail','<?php echo $auctionID;?>');" href="javascript:" id="view_bid_history_<?php echo $auctionID;?>"  class="view_bid_history1 grn-txt">View Bid History</a></div>
							<div class="view_half1  txt_rgt"><a onclick="return bidderHoleinfoPopup('uploaded_file','<?php echo $auctionID;?>');" href="javascript:" id="view_uploadedfile_<?php echo $auctionID;?>" class="view_uploadedfile1 grn-txt">View Uploaded File </a></div>
              
          </div>  
				
            
            
					<div class="row1">
						
				
						<div class="bid_outer">
							<div class="table-section"> 
								<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">							
									<tbody role="alert" aria-live="polite" aria-relevant="all">								
										<tr class="even">
											<td width="33%">Current date and time: <span style="width:100%;font-size: 11px; font-weight:bold;" id="clock"></span>
											</td>
											<td width="33%">Start date and time: <span style="width:100%;font-size: 11px;font-weight:bold;"><?php echo date('d-m-Y H:i:s',strtotime($adata->auction_start_date));?></span></td>
											<td width="33%">End date and time: <span style="width:100%;font-size: 11px;font-weight:bold;"><?php echo date('d-m-Y H:i:s',strtotime($adata->auction_end_date));?></span>
											</td>
									  </tr>
									</tbody>             
								 </table>					
							</div>
							<div class="bid_heading min_hgt">
								<ul>
									<li>Quantity</li>
									<li>Bid Increment</li>
									<li>Reserve Price</li>
									<li>Auction Currency</li>
									<li>End Time</li>
									<?php if($this->session->userdata('role_id')!=4) {?><li>Number of logged bidders</li><?php }?>
									<li>Number of Auto Extensions</li>
								</ul>
							</div>
						
							<div class="bid_heading min_hgt">
								<ul>	
									<li> 1</li>
									<li> <?php echo $adata->bid_inc;?></li>
									<li> <?php echo $adata->opening_price;?></li>
									<li> INR</li>
									<li> <strong><?php echo date("jS M-Y H:i:s",strtotime($adata->auction_end_date));?></strong></li>
										<?php if($this->session->userdata('role_id')!=4) {?><li> <?=$auctionLogedbidder; ?></li><?php }?>
									 <li> <?php echo ($adata->added_autoextension_time > 0)?$adata->added_autoextension_time:'0';?></li>
								</ul>
							</div>
							
							<div class="bid_heading no_left_padding min_hgt gap_width">
								<ul>
									<li class="font_14">Bid Count</li>
									<li class="font_20">Last Bid</li>
									<li class="font_20 no_btm_bdr">Gains</li>
								</ul>
							</div>
							
							<div class="no_lft_bdr bid_heading no_left_padding  min_hgt gap_width">
								<ul>
									<li class="font_14"> <?php echo $totalbidding; ?></li>
									<li class="font_20"> <?php if(@$lastbidArr->bid_value>0){ echo @$lastbid=$lastbidArr->bid_value;}else{ echo @$lastbid='0.00';}?></li>
									<li class="font_20 no_btm_bdr"><span class="increase"><?php echo $gain; ?>%</span></li>
								</ul>
							</div>
						</div>
						<?php if($this->session->userdata('role_id')!=4) { ?>
						<div class="row" align="center">
							<?php if(($status != 4) && ($status != 3) && !(time() >= strtotime($adata->auction_end_date) ) || $adata->auction_bidding_activity_status == 1){ ?>
									<tr>
									 <th colspan="9">
										<?php if($adata->auction_bidding_activity_status==1){ ?>
											<input name="Save" id="resume"  value="Resume Auction" onclick="updateAuctionStatus('resume','<?php echo $adata->id;?>');" type="button" class="b_submit float-left button_grey ">
										<?php } else{ ?>
											<input name="Save" id="pause" value="Pause Auction" onclick="updateAuctionStatus('pause','<?php echo $adata->id;?>');" type="button" class="b_submit float-left button_grey">
										<?php } ?>				 
									 </th>
									</tr>
								
								<?php }else{ ?>
									  <tr>
									   <th colspan="6">
									 
									   <?php
									   if($status == '3') { ?>
										 <div style="color:red" id="error_<?php echo $adata->id; ?>"> Auction on stay Mode</div>
									   
									   <?php }
									   else if($status == '4'){
										   ?>
										  <div style="color:red" id="error_<?php echo $adata->id; ?>"> Auction has been cancelled</div> 
									  <?php } ?>
									   
									   </th>
									  </tr>
							  <?php } ?>
								
						</div>
						<?php }?>
				</div>
            
            </div>
				<div style="width:100%; float:left; height:20px;">&nbsp;</div>


	<script>
	
         setInterval(function(){
            var a = new Date();
            var b = new Date(<?=$str_auction_end_date*1000;?>);
            var difference = (b - a) / 1000;
           if(difference > '0' && (difference<='7'||difference<='5'||difference<='2')){
             /// alert("Refresh  event Triggered at"+ difference);  
               window.location.reload();
            }
         }, 1000);
          </script>
                <?php }
                 else
                    { ?>
						<div class="message-box tpmrg20 btmrg20" style="width:95%; float:left; background:#f78d8d; border:solid 1px #F00; border-radius:2px; font-size:12px; color:#000; padding:30px 0 30px 5%;" >
							<div class="congress-txt no_live_auction"> You don't have any bidder in this auction</div>
						</div>
					<?php 
					} 
                }
                
                 ?> <div style="background:#fff; padding: 1%; text-align: right;">
              <input name="refresh" value="Refresh" onclick="location.reload();"  type="button" class="button_grey">     
              <input name="Save" value="Back" onclick="window.location.href='<?=base_url();?>buyer/'"  type="button" class="button_grey">
            </div>   <?php } else{ ?>
			<div class="message-box tpmrg20 btmrg20" style="width:95%; float:left; background:#f78d8d; border:solid 1px #F00; border-radius:2px; font-size:12px; color:#000; padding:30px 0 30px 5%;" >
                          <div class="congress-txt no_live_auction"> You don't have any live auction</div>
			</div>
			<div style="background:#fff; padding: 1%; text-align: right;">
				<input name="refresh" value="Refresh" onclick="location.reload();"  type="button" class="button_grey">
				<input name="Save" value="Back" onclick="window.location.href='<?=base_url();?>buyer/'"  type="button" class="button_grey">
            </div>
			<?php } ?>
<script>
$(document).ready(function(){   
	var days =0;
	$('[data-countdown]').each(function() {
	var $this = $(this), finalDate = $(this).data('countdown');
	   $this.countdown(finalDate, function(event) {
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
	   }).on('finish.countdown', function(){ //alert('tet');
					var rand = Math.random() * 100000000000;
					location.href = '?rand='+rand;
				});
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
