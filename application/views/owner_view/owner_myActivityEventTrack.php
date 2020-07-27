<script type="text/javascript">

	function movetoauction()
	{
		if(confirm('Want to move this event to auction – Yes/ No?')){
			jQuery.colorbox({width:"65%", inline:true,href:'#inline_content3'});
		}
	}
	function open_price_bid1(auctionID)
	{
		if(auctionID){
			jQuery.ajax({
				url: '/owner/open_price_bid1',
				type: 'POST',
				data: {
					auctionID: auctionID
				},
				success: function(data) {
					location.reload();
				}
			});	
		}
	}
	
	function set_opening_price(auctionID, opening_price, currentStatus){
		
		//alert('dfd');return false;
		if(opening_price){
			jQuery.ajax({
				url: '/owner/setopeningprice',
				type: 'POST',
				data: {
					auctionID: auctionID,
					opening_price: opening_price,
					currentStatus: currentStatus
				},
				success: function(data) {
					location.reload();
				}
			});	
		}
	}

	function validateopenerfrm(str){
		
		var flag = true;
		jQuery('#'+str+' .bid_acceptance').each(function(){
			if(!jQuery(this).val()){
				jQuery(this).addClass('error');
				flag = false;
			}else{
				jQuery(this).removeClass('error');
			}
		});
		
		jQuery('#'+str+' .txtComment').each(function(){
			if(!jQuery(this).val()){
				jQuery(this).addClass('error');
				flag = false;
			}else{
				jQuery(this).removeClass('error');
			}
		});
		
		if(flag){
			return true;
		}else{
			return false;
		}	
	}
		
	function concludeEvent(auctionID)
	{
		var checkConfirm = confirm('Are you sure, that want to conclude the event?');
		if(checkConfirm== true)
		{
			jQuery.ajax({
				url: '/owner/concludeEvent',
				type: 'POST',
				data: {auctionID:auctionID},
				success: function(data) {
					location.reload();
					//alert(data);
				}
			});	
			return true;
		}
		else{
			return true;
		}
	}

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

</script>
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
					<a href="/property">Advance Search+</a> 
				</div>
          
				<div id="tab-pannel6" class="btmrgn">
            
				<ul class="tabs6">
					<a href="/owner"><li  rel="tab1">Buy</li></a>
					<a href="/owner/sell"><li class="active" rel="tab2">Sell</li></a>
				</ul>
            
          <div class="tab_container6"> 
              
            <!---- buy tab container start ---->
            <div id="tab1" class="tab_content6" style="display:block">
              <div id="tab-pannel3" class="btmrgn">
                  <ul class="tabs3">
                    <a href="/owner/sell"><li  rel="tab9">My Summary</li></a>
                  <a href="/owner/liveAuction"><li class="active" rel="tab10">My Activity</li></a>
                  <a href="/owner/myMessage"><li rel="tab11">My Message</li></a>
                  <a href="/owner/myProfile"><li rel="tab12">My Profile</li></a>
                </ul>
                <div class="tab_container3 whitebg"> 
                 
                  
                  <!-- Sell > My Activity start -->
                  
                  <div id="tab6" class="tab_content3">
                    <div class="container">
                      <div class="secttion-left">
                        <div class="left-widget">
                          <div id="cssmenu">
                            <?php echo $leftsidebar; ?>
                          </div>
                        </div>
                      </div>
                      <div class="secttion-right">
						<div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <!--<div class="heading4">Live Auction</div>-->
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div class="table-section"> 
						<?php 
							$date = @strtotime(date('Y-m-d H:i:s'));	
							
							$bid_last_date = ($auction_data[0]->bid_last_date)?strtotime($auction_data[0]->bid_last_date):0;
						
							$bid_opening_date = ($auction_data[0]->bid_opening_date)?strtotime($auction_data[0]->bid_opening_date):0;		
							
							$auction_start_date = ($auction_data[0]->auction_start_date)?strtotime($auction_data[0]->auction_start_date):0;
							
							$auction_end_date = ($auction_data[0]->auction_end_date)?strtotime($auction_data[0]->auction_end_date):0;
							
							if($auction_data[0]->status==7 || $auction_data[0]->status==3 || $auction_data[0]->status==4){
								$currentStatus = 7;
							}
							//elseif($auction_data[0]->status!=1){
						elseif($auction_data[0]->status!=1 && $auction_data[0]->status!=6 ){
								$currentStatus = 1;
							}elseif($auction_end_date<$date){
								$currentStatus = 5;
							}elseif($auction_data[0]->stageID>3){
								$currentStatus = $auction_data[0]->stageID;
							}elseif($date<=$bid_last_date){
								$currentStatus = 2;
							}elseif($date>$bid_last_date && $date<$auction_start_date){
								$currentStatus = 3;
							}elseif($date>=$auction_start_date && $date<=$auction_end_date){
								$currentStatus = 4;
							}else{
								$currentStatus = 1;
							}
							$user_id=$this->session->userdata('id');
							
							//echo $auction_data[0]->stageID.'<br />';
							//echo 'auction_start_date :'.$auction_start_date.'<br />';
							//echo 'auction_end_date :'.$auction_end_date.'<br />';
							//echo 'date :'.$date.'<br />';	
						?>
						
          <a href="#inline_content" class="grn-txt float-right b_showevent inline_auctiondetail">Show Auction Details</a>
          
            <div id="tab-pannel5" class="btmrgn">
              <ul class="tabs5">
                <li <?php echo ($currentStatus==1)?'class="active"':'';?> rel="tab51">
					<span class="white-circle">1</span>
					<div class="tabtext">
						<span>Auction Creation</span> 
						<span class="status"><?php if($currentStatus==1)echo 'Current Stage';?></span>
					</div> 
					<div class="arrow-down"></div>
				</li>
                <li <?php echo ($currentStatus==2)?'class="active"':'';?> rel="tab61">
					<span class="white-circle">2</span>
					<div class="tabtext"> 
						<span>Bid Submission</span> 
						<span class="status"><?php if($currentStatus==2)echo 'Current Stage';?></span>
					</div>
					<div class="arrow-down"></div> 
				</li>
                <li <?php echo ($currentStatus==3)?'class="active"':'';?> rel="tab71">
					<span class="white-circle">3</span>
					<div class="tabtext"> 
						<span>Opening - 1st Opener</span> 
						<span class="status"><?php if($currentStatus==3)echo 'Current Stage';?></span>
					</div>
					<div class="arrow-down"></div> 
				</li>
				<li <?php echo ($currentStatus==4)?'class="active"':'';?> rel="tab81">
					<span class="white-circle">4</span>
					<div class="tabtext"> 
						<span>Auction</span> 
						<span class="status"><?php if($currentStatus==4)echo 'Current Stage';?></span>
					</div>
					<div class="arrow-down"></div> 
				</li>
				<li <?php echo ($currentStatus==5)?'class="active"':'';?> rel="tab91">
					<span class="white-circle">5</span>
					<div class="tabtext"> 
						<span>Reports</span> 
						<span class="status"><?php if($currentStatus==5)echo 'Current Stage';?></span>
					</div>
					<div class="arrow-down"></div> 
				</li>
              </ul>
              <div class="tab_container5">
                <div id="tab51" class="tab_content5">
                  <div class="container">
                  
                <!-- <div class="row"> <div class="status-wrapper"><label>Status:</label><div class="completed">completed</div></div></div>-->
                  
                    <div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-eventfee.png"></span>
                      <div class="txt">Percentage Complete</div>
                      <div class="txt2"><?php echo $auction_data[0]->updated_date?></div>
                    </div>
                    <div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-emd-amount.png"></span>
                      <div class="txt">Last Updated</div>
                      <div class="txt2"><?php echo $auction_data[0]->bid_last_date?></div>
                    </div>
                    <!--<div class="circle-category"> <span class="icon-circle"><img src="/images/dash-icon2.png"></span>
                      <div class="txt"></div>
                      <ul>
                    	<li>Pan Card</li>
                        <li>AUCTION BID FORM</li>
                        <li>Annexure 2</li>
                        <li>Passport</li>
                      </ul>
                    </div>-->
					<?php if($currentStatus==1){?>
                    <div class="circle-category-right">
                      <a href="/owner/sellerPostPropety/<?php echo $auction_data[0]->id?>"><input name="Save" value="Edit Auction" type="button" class="b_publish float-right"></a>
                    </div>
					<?php }?>
                  </div>
                </div>
                 <!-- #tab1 -->
                
               <div id="tab61" class="tab_content5">
                  <div class="container"> 
				  <div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-eventfee.png"></span>
                      <div class="txt">Offer Submission Last Date</div>
                      <div class="txt2"><?php echo $auction_data[0]->bid_last_date?></div>
                    </div>
                    <div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-emd-amount.png"></span>
                      <div class="txt">No. of Bids received</div>
                      <div class="txt2"><?php echo ($auction_data[0]->bider_total)?$auction_data[0]->bider_total:'0'?></div>
                    </div>
                  </div>
                </div>
                
                <!-- #tab4 --> 
                <!-- #tab2 -->
                
                <div id="tab71" class="tab_content5">
                  <div class="container">
                 
                    <div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-bid.png"></span>
                      <div class="txt">Name of first Opener</div>
                      <div class="txt2"><?php echo GetTitleById('tbl_user_registration',$auction_data[0]->first_opener,'first_name'); ?></div>
                    </div>
                    <div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-emd-amount.png"></span>
                      <div class="txt">Date & Time of Opening </div>
                      <div class="txt2"><?php echo $auction_data[0]->bid_opening_date?></div>
                    </div>
					<?php if($currentStatus==3){?>
						<div class="circle-category-right">
						  <a href="#inline_content1" class="inline_auctiondetail1"><input name="Save" value=" Click here to Open Bid" type="button" class="b_publish2 float-right"></a>
						</div>
					<?php }else{?>
						<div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-emd-amount.png"></span>
						<div class="txt" style="color:red">Opening time not reached yet</div>
						</div>
					<?php }?>
				</div>
                </div>
                
                <!-- #tab3 -->
				 <!-- #tab5 -->
                <div id="tab81" class="tab_content5">
                  <div class="container">
				 
					<div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-bid.png"></span>
					  <div class="txt">No. of Bidders</div>
					  <div class="txt2"><?php echo $auction_data[0]->bider_total?></div>
					</div>
					<div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-emd-amount.png"></span>
					  <div class="txt">Auction Date & Time </div>
					  <div class="txt2"><?php echo $auction_data[0]->auction_start_date?></div>
					</div>
					<div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-emd-amount.png"></span>
					  <div class="txt">Scheduled End Date & Time</div>
					  <div class="txt2"><?php echo $auction_data[0]->auction_end_date?></div>
					</div>
					<div class="circle-category2"> <span class="icon-circle"><img src="/images/icon-emd-amount.png"></span>
					  <div class="txt">Auto Extension time</div>
					  <div class="txt2"><?php echo $auction_data[0]->auto_extension_time?></div>
					</div>
					<?php if($date>=$auction_start_date && $date<=$auction_end_date){?>
						<div class="circle-category-right">
						  <a href="/owner/sellliveAuctionList/<?php echo $auction_data[0]->id?>"><input name="Save" value=" View Auction" type="button" class="b_publish2 float-right"></a>
						</div>
					<?php }else{?>
						<div class="circle-category2"> <span class="icon-circle"></span>
							<div class="txt" style="color:red">Auction yet to be started.</div>
						</div>
					<?php }?>
				  </div>
                </div>
				 <!-- #tab6 -->
                <div id="tab91" class="tab_content5">
				  <div class="container tpmrg50 btmrg50"> <span class="icon-circle-big"><img src="/images/icon-report.png"></span>
				  <?php if($currentStatus==5){?>
					<div class="congress-txt"> <span class="grn-txt"><a href="/owner/viewReport/<?php echo $auction_data[0]->id?>" class="myviewReport">Report</a></span> Available For Downloads of Auction.</div>
					<?php }else{?>
					 <div class="congress-txt"> Report Will be Available For Downloads After Completion of Auction.</div>
					<?php }?>
				  </div>
                </div>
		      </div>
            </div>
            <div class="note"> <span class="icon-note"></span> Auction Tracker shows at what stage the event is currently. You can also view the completed & next stages and navigate directly from this page. </div>
			
						<!-- -->
			
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
		jQuery(".myviewReport").colorbox({iframe:true, width:"80%", height:"80%"});
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
		<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
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
			  <td align="left" valign="top" class=""  colspan="3"><?php echo $auction_data[0]->property_description?></td>
			 
			  </tr>
			<tr class="even">
			  
			  <td align="left" valign="top" class=""><strong>Property ID</strong></td>
			  <td align="left" valign="top" class=""><?php echo $auction_data[0]->reference_no?></td>
			  <td align="left" valign="top" class=""><strong>Account </strong></td>
			  <td align="left" valign="top" class=""><?php echo $auction_data[0]->account?></td>
			  </tr>
			<tr class="odd">
			 
			  <td align="left" valign="top" class=""><strong>Auction Created by</strong></td>
			 
			  <td align="left" valign="top" class=""><?php echo $auction_data[0]->account?></td>
			  <td align="left" valign="top" class=""><strong>Borrower Name</strong></td>
			  <td align="left" valign="top" class=""><?php echo $auction_data[0]->borrower_name?></td>
			  </tr>
			<tr class="even">
			 
			  <td align="left" valign="top" class=""><strong>Nodal Bank A/c No.</strong></td>
			  <td align="left" valign="top" class=""><a href="#">  
			  <?php echo $auction_data[0]->nodal_bank_account?>
			 </a></td>
			  <td align="left" valign="top" class=""><strong>Category</strong></td>
			  <td align="left" valign="top" class="">
			  <?php echo $auction_data[0]->category_id?>
			  </td>
			  </tr>
			<tr class="odd">
			 
			  <td align="left" valign="top" class=""><strong>Sub Category&nbsp;</strong></td>
			  <td align="left" valign="top" class="">
			  <?php echo $auction_data[0]->subcategory_id?>
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
<!--End  Show event details -->

<!--Bid Open First oPener-->
<div class="row"  style="display:none;">
	<div id="inline_content1">
		<div class="heading4 btmrg20">Bid Opening -First Opener</div>
		<form id="bidopenerfrm1" name="submitdoc" action="/owner/firstOpnerVerification" method="post" enctype="multipart/form-data" onsubmit="return validateopenerfrm('bidopenerfrm1');">
			<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<tr class="odd">
						<td width="10%" align="left" valign="top" class=""><strong>Sl No.</strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Bidder Name </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>View </strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Action </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Comments </strong></td>
					</tr>
					<?php 					
					//echo '<pre>';print_r($auction_data[0]->bider_detail);
					$isAccepted = false;
					if(count($auction_data[0]->bider_detail)){
						foreach($auction_data[0]->bider_detail as $key=>$bider_detail){
						if($isAccepted==false){
							$isAccepted = ($bider_detail->operner1_accepted==1)?true:false;
						}
					?>
						<tr class="even">
							<td width="10%" align="left</td>" valign="top" class=""><?php echo ++$key?></td>
							<td width="15%" align="left" valign="top" class="">
							<?php echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'first_name')?></td>
							<td width="30%" align="left" valign="top" class="" >
							<a class='emd_detail_iframe' href="/owner/emdDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $auction_data[0]->id;?>">Auction fees</a>
							|
							<a class='tenderfee_detail_iframe' href="/owner/docDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $auction_data[0]->id;?>">Docs</a>
							
							</td>
							<td width="15%" align="left" valign="top" class="" >
							<select class="bid_acceptance"  name="bid_acceptance[]">
							<option value="1" <?php if($bider_detail->operner1_accepted==1){ echo 'selected="selected"'; }?>>Accept Bid</option>
							<option value="0" <?php if($bider_detail->operner1_accepted==0 && $bider_detail->operner1_comment!=''){ echo 'selected="selected"'; }?>>Reject Bid</option>
							</select>
							</td>
							<td width="30%" align="left" valign="top" class="" >
							<textarea class="txtComment" style="width:200px;" tabindex="2" cols="20" rows="2" name="txtComment[]"><?php echo $bider_detail->operner1_comment; ?></textarea>
							<input type="hidden" value="<?php echo $bider_detail->id;?>" name="participate_id[]">
							<input type="hidden" value="<?php echo $bider_detail->bidderID;?>" name="bidderID[]">							
							</td>
						</tr>
					<?php 
						}
					}
					else
					{
					?>
					<tr>
						<td colspan="5">No Bidder.</td>
					</tr>
					<?php 
					}
					?>
					
					<?php 
					if($auction_data[0]->open_price_bid!=1)
					{
					?>
						<tr>
							<td colspan="5">
								<input type="hidden" value="<?php echo $auction_data[0]->second_opener?>" name="second_opener">
								
								<input type="hidden" value="<?php echo $auction_data[0]->id?>" name="auctionID">
								
								<?php
								if($isAccepted && ($auction_data[0]->second_opener!=null || $auction_data[0]->second_opener!=0)){
								?>
									<a href="javascript:void(0);" onclick="move_to_second_opener(<?php echo $auction_data[0]->id?>);"><input name="Move To Second Opener" value="Move To Second Opener" type="button" class="b_publish2 float-right"></a>
								<?php 
								}elseif($isAccepted){
								?>
									<a href="javascript:void(0)" onClick="open_price_bid1(<?php echo $auction_data[0]->id?>);" ><input name="Save" value="Open Price Bid" type="button" class="b_publish2 float-right"></a>
								<?php
								}else{
									//Do Nothing
								}
								?>
								
								<?php
								if($isAccepted){
								?>
									<input name="submit" value="Update" type="submit" class="b_submit float-right">
								<?php 
								}else{
								?>
									<input name="submit" value="Save" type="submit" class="b_submit float-right">
								<?php }?>
							</td>
						</tr>
					<?php }?>	
				</tbody>             
			</table>
		</form>		
		<?php 
		//echo 'isAccepted: '.$isAccepted.'<br />';
		//echo 'first_opener: '.$auction_data[0]->first_opener.'<br />';
		//echo 'second_opener: '.$auction_data[0]->second_opener.'<br />';
		if(count($auction_data[0]->bider_detail)>0 && $isAccepted==true && ($auction_data[0]->second_opener==null || $auction_data[0]->second_opener==0) && $auction_data[0]->open_price_bid){?>
			<?php 
				if($auction_data[0]->show_frq==1 && $auction_data[0]->price_bid_applicable=='applicable'){
			?>
			<div class="heading4 btmrg20">Price Bid</div>			
			<?php }?>
			<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php 
					if($auction_data[0]->show_frq==0 && $auction_data[0]->price_bid_applicable=='applicable'){
						$opening_price=0;
						foreach($auction_data[0]->bider_detail as $key=>$bider_detail){
							if($bider_detail->operner1_accepted){
								if($bider_detail->frq_detail[0]->frq>$opening_price){
									$opening_price = $bider_detail->frq_detail[0]->frq;
								}
							}
						}
						
					}
					
					if($auction_data[0]->show_frq==1 && $auction_data[0]->price_bid_applicable=='applicable'){
					?>					
						<tr class="odd">
							<td width="5%" align="left" valign="top" class=""><strong>Sl No.</strong></td>
							<td width="20%" align="left" valign="top" class=""><strong>Bidder Name </strong></td>
							<td width="20%" align="left" valign="top" class=""><strong>Opener Action </strong></td>
							<td width="30%" align="left" valign="top" class=""><strong>Opener Comments </strong></td>
							<td width="25%" align="left" valign="top" class=""><strong>Price </strong></td>
						</tr>
					<?php 
						$opening_price=0;
						//echo "<pre>";
						//print_r($auction_data[0]->bider_detail);
						//echo "</pre>";
						foreach($auction_data[0]->bider_detail as $key=>$bider_detail){
							if($bider_detail->operner1_accepted){
								if($bider_detail->frq_detail[0]->frq>$opening_price){
									$opening_price = $bider_detail->frq_detail[0]->frq;
								}
							}	
					?>
							<tr class="even">
								<td width="10%" align="left" valign="top" class="">
									<?php echo ++$key?>
								</td>
								<td width="15%" align="left" valign="top" class="">
									<?php echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'first_name')?>
								</td>
								<td width="15%" align="left" valign="top" class="">
									<?php echo ($bider_detail->operner1_accepted)?'Accepted':'Rejected'; ?>
								</td>
								<td width="15%" align="left" valign="top" class="">
									<?php echo $bider_detail->operner1_comment; ?>
								</td>
								<td width="15%" align="left" valign="top" class="">
									<?php echo $bider_detail->frq_detail[0]->frq; ?>
								</td>
							</tr>
					<?php 
						}
					}
					?>
					<tr>
						<td colspan="5">
							<a class="inline_auctiondetail4" href="#inline_content3" onclick="movetoauction();"><input name="Save" value="Move To Auction" type="button" class="b_publish2 float-right"></a>
							<a href="javascript:void(0)" onClick="return concludeEvent(<?php echo $auction_data[0]->id?>)" ><input name="Save" value="Conclude Event" type="button" class="b_publish2 float-right"></a>
						</td>
					</tr>
				</tbody>
			</table>
		<?php }?>	
	</div>	
</div>
<!--End Bid Open First oPener-->

<!-- START SET OPENING PRICE -->
<div class="row"  style="display:none;">
	<div id="inline_content3">
		<div class="heading4 btmrg20">
			Set Highest Bid Price as Opening Price
		</div>
		<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
			<tbody role="alert" aria-live="polite" aria-relevant="all">
				<tr>
					<td>
						<?php 
							if($auction_data[0]->show_frq==1 && $auction_data[0]->price_bid_applicable=='applicable'){
								//Do Nothing
							}elseif($auction_data[0]->show_frq==0 && $auction_data[0]->price_bid_applicable=='applicable'){
								//Do Nothing
							}else{
								$opening_price = $auction_data[0]->reserve_price;
							}
						?>						
						<input type="radio" name="opening_price" id="opening_price" checked="checked" />H1(
						Rs. <?php echo $opening_price; ?>) as Opening Price.
						<a href="javascript:void(0);" onclick="set_opening_price(<?php echo $auction_data[0]->id?>, '<?php echo $opening_price; ?>', '<?php echo $currentStatus;?>');"><input name="Save" value="Submit" type="button" class="b_publish2 float-right"></a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>				
</div>
<!-- END OF OPENING PRICE -->

<?php 
//echo $this->session->userdata('open_popup');
if($this->session->userdata('open_popup')==true && $currentStatus==3){?>	
<script>
	jQuery(document).ready(function(){	
		jQuery('.inline_auctiondetail1').trigger('click');
	});
</script>
<?php }?>
<?php if($this->session->userdata('open_popup')==true && $currentStatus==4){?>	
<script>
	jQuery(document).ready(function(){	
		jQuery('.inline_auctiondetail2').trigger('click');
	});
</script>
<?php }
$this->session->set_userdata('open_popup', false);
?>
