<script type="text/javascript">
	jQuery(document).ready(function($){
		/*------- tab pannel --------------- */
		jQuery(".tab_content5").hide();
		//jQuery(".tab_content5:first").show(); 
		var activeTab = jQuery("ul.tabs5 li.active").attr("rel");
		jQuery("#"+activeTab).show(); 	
		jQuery("ul.tabs5 li").click(function() {
			jQuery("ul.tabs5 li").removeClass("active");
			jQuery(this).addClass("active");
			jQuery(".tab_content5").hide();
			var activeTab = jQuery(this).attr("rel"); 
			jQuery("#"+activeTab).fadeIn(); 
		});
	});
	
	function tcAccept(auctionID)
	{
		//alert(auctionID);
		var tcval=jQuery('input[name=chktc]:checked').val();
		if(tcval != 'yes')
		{
			alert('Please accept tems & condition.');
			return false;
		}
		else
		{
			jQuery.ajax({
				url: '/owner/tcAccepted',
				type: 'POST',
				data: {auctionID:auctionID},
				success: function(data) {
					location=location;
				//	alert(data);
					
				}
			});	
			return true;			
		}		
	}
	
	function auctionTrainingAccept(auctionID)
	{
		//alert(auctionID);
		var tcval=jQuery('input[name=chkauctionTraining]:checked').val();
		if(tcval != 'yes')
		{
			alert('Please accept Auction Training.');
			return false;
		}
		else
		{
			jQuery.ajax({
				url: '/owner/atAccepted',
				type: 'POST',
				data: {auctionID:auctionID},
				success: function(data) {
					location=location;
				//	alert(data);
					
				}
			});	
			return true;
			
		}		
	}
</script>

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
                  <a href="/owner/liveAuction"><li class="active" rel="tab10">My Activity</li></a>
                  <a href="/owner/myMessage"><li rel="tab11">My Message</li></a>
                  <a href="/owner/myProfile"><li rel="tab12">My Profile</li></a>
                </ul>
                <div class="tab_container3 whitebg"> 
                 
                  
                  <!-- Sell > My Activity start -->
                  
                  <div id="tab6" class="tab_content3">
                    <div class="container">
                       <?php echo $leftsidebar;?>
                      <div class="secttion-right">
          
         <!-- <input name="Save" value="show event details" type="button" class="b_publish float-right b_showevent">-->
          <a href="#inline_content" class="grn-txt float-right b_showevent inline_auctiondetail">Show Auction details</a>
        <?php
			$currentStatus = 0;
			$participate = 0;
			$opener = 0;
			$openning = 0;
			$wait_for_auction = 0;
						
			$date = @strtotime(date('Y-m-d H:i:s'));	
			
			$bid_last_date = ($auction_data[0]->bid_last_date)?strtotime($auction_data[0]->bid_last_date):0;
		
			$bid_opening_date = ($auction_data[0]->bid_opening_date)?strtotime($auction_data[0]->bid_opening_date):0;		
			
			$auction_start_date = ($auction_data[0]->auction_start_date)?strtotime($auction_data[0]->auction_start_date):0;
			
			$auction_end_date = ($auction_data[0]->auction_end_date)?strtotime($auction_data[0]->auction_end_date):0;
			
			if($auction_data[0]->second_opener){
				$opner_accepted = $auction_data[0]->bidder_participation_detail[0]->operner2_accepted;
			}else{
				$opner_accepted = $auction_data[0]->bidder_participation_detail[0]->operner1_accepted;
			}
			
			if($date<=$bid_last_date){
				$currentStatus = 1;
				if($auction_data[0]->bidder_participation_detail[0]->is_accept_tc==1){
					$participate = 1;
				}
			}elseif($date<$bid_opening_date){
				$currentStatus = 2;
				$opener = 1;
			}elseif(($auction_start_date-$date)<60 && ($auction_start_date-$date)>0){
				$currentStatus = 3;
				$wait_for_auction = 1;
			}elseif($date>$bid_opening_date && $date<$auction_start_date){
				$currentStatus = 2;
				$openning = 1;
			}elseif($date>=$auction_start_date AND $date<=$auction_end_date){
				$currentStatus = 3;
			}elseif($date>$auction_end_date){
				$currentStatus = 4;
			}else{
				$currentStatus = 0;
				$participate = 0;
				$opener = 0;
				$openning = 0;
				$wait_for_auction = 0;
			}	
			
			//echo 'bid_opening_date: '.$bid_last_date.'<br />';
			//echo 'date: '.$date.'<br />';
			//echo '<PRE>';print_r($auction_data);echo '</PRE>'; 
			
			//echo $auction_data[0]->bidder_participation_detail[0]->is_accept_auct_training;
			
		?>
	        <div class="table-section"> <div id="tab-pannel5" class="btmrgn">
              <ul class="tabs5">
                <li <?php echo ($currentStatus=='1')?'class="active"':'';?> rel="tab5">
				<span class="white-circle">1</span> 
					<div class="tabtext">
						<span>Participation Stage</span> 
						<span class="status"><?php if($currentStatus==1)echo 'Current Stage';?></span>
					</div>
					<div class="arrow-down"></div>
				</li>
                <li rel="tab61" <?php echo ($currentStatus=='2')?'class="active"':'';?>>
					<span class="white-circle">2</span>
					<div class="tabtext">
						<span>Opening Stage</span>
						<span class="status"><?php if($currentStatus=='2')echo 'Current Stage';?></span>
					</div>
					<div class="arrow-down"></div>
				</li>
                <li rel="tab7" <?php echo ($currentStatus=='3')?'class="active"':'';?>>
					<span class="white-circle">3</span>
					<div class="tabtext">
						<span>Auction</span>
						<span class="status"><?php if($currentStatus=='3')echo 'Current Stage';?></span>
					</div>
					<div class="arrow-down"></div>
				</li>
                <li rel="tab8" <?php echo ($currentStatus=='4')?'class="active"':'';?>>
					<span class="white-circle">4</span>
					<div class="tabtext"> 
						<span>Reports</span> 
						<span class="status"><?php if($currentStatus=='4')echo 'Current Stage';?></span>
					</div>
					<div class="arrow-down"></div>
				</li>
              </ul>
			  
              <div class="tab_container5">
				<div id="tab5" class="tab_content5">
					<div class="container">
						<?php /* ?>
						<div class="circle-category"> 
							<span class="icon-circle"><img src="/images/icon-eventfee.png"></span>
							<div class="txt">Auction Fee </div>
							<div class="price"><span class="WebRupee">Rs</span><?php echo $auction_data[0]->tender_fee?></div>
						</div>
						<?php */ ?>
						<!--<div class="circle-category">
							<span class="icon-circle"><img src="/images/icon-emd-amount.png"></span>
							<div class="txt">EMD Amount</div>
							<div class="price"><span class="WebRupee">Rs</span><?php echo $auction_data[0]->emd_amt?></div>
						</div>-->
						<div class="circle-category">
							<span class="icon-circle"><img src="/images/dash-icon2-1.png"></span>
							<div class="txt">Documents Required</div>
							<ul>
								<?php 
								$req_doc=$auction_data[0]->doc_to_be_submitted;
								$req_doc_array=explode(',',$req_doc);
								foreach($req_doc_array as $doc_id)
								{
								?>
								<li><?php echo GetTitleById('tbl_doc_master',$doc_id)?></li>
								<?php }?>
							</ul>
						</div>
						<?php 
						if($currentStatus==1){
							if($participate=='1'){
						?>
								<div class="circle-category-right">
								<a href="/owner/auction_participate/<?php echo $auction_data[0]->id?>"><input name="Save" value="Participate" type="button" class="b_publish float-right"></a>
								</div>
						<?php 
							}
							else
							{ 
						?>
								<div class="circle-category-notice">
									<div id="ContentPlaceHolder1_divAcptChk">
										<input name="chktc" type="checkbox" id="chktc" value="yes">
										<span>I agree that : I have read and accepted the <a href="#" class="terms" target="_blank">User Agreement and Privacy Policy.</a> I may receive communications from <?php echo BRAND_NAME; ?> . </span>
										<span id="ContentPlaceHolder1_Label1"></span>
										<div> <input type="button" name="submit" value="Submit" class="button_grey showbtn" onclick="return tcAccept(<?php echo $auction_data[0]->id?>);">  </div>
									</div>
								</div>
						<?php
							}
						} 
						?>
					</div>
                </div>
                
                <!-- #tab1 -->
                <div id="tab61" class="tab_content5">
					<div class="container tpmrg50">
						<span class="icon-circle-big">
							<img src="/images/icon-thumb.png">
						</span>
						<div class="congress-txt">
							<?php 
							if($currentStatus=='2'){
								if($opner_accepted=='1'){
								?> 
									<span class="grn-txt">Congratulation!!</span> You Have Been Qualified For The Auction by Competent Authority.
								<?php
								}
								elseif($opener=='1')
								{
								?>
									Bid yet to be open.
								<?php 
								}
								elseif($openning=='1')
								{
								?>
									Opening is in Progress.
								<?php 
								}
								else
								{
								?>
									Opening is Scheduled at : 
								<?php 
									echo $auction_data[0]->bid_opening_date;
								}
							}else{
								?>
									Opening is Scheduled at : 
								<?php 
									echo $auction_data[0]->bid_opening_date;
							}	
							?>
						</div>
					</div>
                </div>
                
                <!-- #tab2 -->
				<div id="tab7" class="tab_content5">
					<div class="container">

						<div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-bid.png"></span>
						<div class="txt">Auction Start Date</div>
						<div class="txt2"><?php echo $auction_data[0]->auction_start_date?></div>
						</div>
						<div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-emd-amount.png"></span>
						<div class="txt">Scheduled End Date & Time</div>
						<div class="txt2"><?php echo $auction_data[0]->auction_end_date?></div>
						</div>
						<?php 
						if($currentStatus=='3'){
							if($auction_data[0]->bidder_participation_detail[0]->is_accept_auct_training && $wait_for_auction=='0')
							{
						?>
								<div class="circle-category-right">
									<a href="/owner/buylistLiveAuctions/<?php echo $auction_data[0]->id?>"> <input name="Save" value=" Click here to Enter Auction" type="button" class="b_publish2 float-right"></a>
								</div>
							<?php 
							}
							elseif($wait_for_auction=='1' && $auction_data[0]->bidder_participation_detail[0]->is_accept_auct_training=='1')
							{
							?>
								<div class="circle-category2"> 
									<span class="icon-circle">
									</span>
									<div class="txt" style="color:red">Please wait for auction to start.</div>
								</div>
							<?php
							}
							else
							{
							?>
							<div class="circle-category-notice">
								<div id="ContentPlaceHolder1_divAcptChk">
									<input name="chkauctionTraining" type="checkbox" id="chkauctionTraining" value="yes">
									<span>I agree that : I have read and accepted the <a onclick="return bidderHoleinfoPopup('owner_agreement_privacy_policy','<?php  echo $auction_data[0]->id;?>');" class="terms" href="javascript:" >Auction Training</a></span>
									<span id="ContentPlaceHolder1_Label1"></span>
									<div> <input type="button" name="submit" value="Submit" class="b_submit showbtn" onclick="return auctionTrainingAccept(<?php echo $auction_data[0]->id?>);">  </div>
								</div>
							</div>
						<?php 
							}
						}
						?>
					</div>
				</div>
                
                <!-- #tab3 -->
                
				<div id="tab8" class="tab_content5">
				<?php
				//echo "currentStatus->".$currentStatus;
				?>
					<div class="container tpmrg50 btmrg50"> <span class="icon-circle-big"><img src="/images/icon-report.png"></span>
					<?php if($currentStatus=='viewreport' || $currentStatus==4){?> <div class="congress-txt"> <span class="grn-txt"><a href="/owner/viewReport/<?php echo $auction_data[0]->id?>" class="myviewReport">Report</a></span> Available For Downloads of Auction.</div>
                                            <?php }else{?>
					<div class="congress-txt">
					<span class="grn-txt">Report</span> Will be Available For Downloads After Completion of Auction<?php 
                                          }?>
                                        </div>
					</div>
				</div>
				<!-- #tab4 --> 
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
jQuery(document).ready(function(){
	
	jQuery(".inline_auctiondetail").colorbox({inline:true, width:"65%"});
	jQuery(".inline_auctiondetail1").colorbox({inline:true, width:"65%"});
	jQuery(".inline_auctiondetail2").colorbox({inline:true, width:"65%"});
	//jQuery(".emd_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {location.reload(true);}});
	jQuery(".emd_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {jQuery(".inline_auctiondetail1").click();}});
	jQuery(".tenderfee_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {jQuery(".inline_auctiondetail1").click();}});
	jQuery(".doc_detail_iframe").colorbox({iframe:true, width:"42%", height:"40%",onClosed: function () {jQuery(".inline_auctiondetail1").click();}});
});
</script>
<div class="row"  style="display:none;">
	<div id="inline_content">
		<div class="heading4 btmrg20">Auction Detail</div>
		<table border="1" align="left" cellpadding="2" cellspacing="1=" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
			<tbody role="alert" aria-live="polite" aria-relevant="all">
				<tr class="odd">
					<td width="20%" align="left" valign="top" class=""><strong>Auction Title</strong></td>
					<td width="35%" align="left" valign="top" class="" colspan="3"><?php echo $auction_data[0]->event_title?></td>
				</tr>
				<tr class="even">                  
					<td align="left" valign="top" class=""><strong>Auction No. </strong></td>
					<td align="left" valign="top" class=""  colspan="3"><?php echo $auction_data[0]->id?></td>

				</tr>
				<tr class="odd">

					<td align="left" valign="top" class=""><strong>Property Address</strong></td>
					<td align="left" valign="top" class=""  colspan="3">
					<?php
					echo GetTitleByField('tbl_product', "id='".$auction_data[0]->productID."'" ,'product_description');
					// echo  $this->db->last_query();

					?>

					</td>

				</tr>
				<tr class="even">
					<?php /* ?>
					<td align="left" valign="top" class=""><strong>Property ID</strong></td>
					<td align="left" valign="top" class=""><?php echo $auction_data[0]->reference_no?></td>
					<?php */ ?>
					<td align="left" valign="top" class=""><strong>Account </strong></td>
					<td align="left" valign="top" class=""><?php echo strtoupper($auction_data[0]->event_type);?></td>
				</tr>
				<tr class="odd">

					<td align="left" valign="top" class=""><strong>Auction Created by</strong></td>

					<td align="left" valign="top" class="">
					<?php
					$sales_executive_id=GetTitleByField('tbl_event_log_sales', "id='".$auction_data[0]->eventID."'" ,'sales_executive_id');
					echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'first_name');
					?>				
					</td>
					<?php /* ?>
					<td align="left" valign="top" class=""><strong>Borrower Name</strong></td>
					<td align="left" valign="top" class=""><?php echo $auction_data[0]->borrower_name?></td>
					<?php */ ?>
				</tr>
				<tr class="even">

					<td align="left" valign="top" class=""><strong>Nodal Bank A/c No.</strong></td>
					<td align="left" valign="top" class=""><a href="#">  
					<?php echo $auction_data[0]->nodal_bank_account?>
					</a></td>
					<td align="left" valign="top" class=""><strong>Category</strong></td>
					<td align="left" valign="top" class="">
					<?php 
					echo $participate_status=GetTitleByField('tbl_category', "id='".$auction_data[0]->category_id."'" ,'name');

					?>
					</td>
				</tr>
				<tr class="odd">

					<td align="left" valign="top" class=""><strong>Sub Category&nbsp;</strong></td>
					<td align="left" valign="top" class="">

					<?php 
					echo $participate_status=GetTitleByField('tbl_category', "id='".$auction_data[0]->subcategory_id."'" ,'name');
					?>
					</td>
					<td align="left" valign="top" class=""><strong>Due Date&nbsp;</strong></td>
					<td align="left" valign="top" class=""><?php echo date("d M Y H:i",strtotime($auction_data[0]->auction_end_date));?></td>
				</tr>
				<tr class="even">

					<td align="left" valign="top" class=""><strong>Reserve Price</strong></td>
					<td align="left" valign="top" class="">

					<?php echo $auction_data[0]->reserve_price?>
					</td>
					<td align="left" valign="top" class=""><strong>Auction Start Date&nbsp;</strong></td>
					<td align="left" valign="top" class=""><?php echo date("d M Y H:i",strtotime($auction_data[0]->auction_start_date));?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="bidderHolePopup" style="display:none;">
 <div class="popup" ><img src="/images/icon-close2.png" class="close">
	<div class="popupcontainer"></div>
 </div>
	<div id="popup-overlay"></div>
</div>
