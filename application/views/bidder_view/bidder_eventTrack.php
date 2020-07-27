<script type="text/javascript">
jQuery(document).ready(function($){
	/*------- tab pannel --------------- */
	$(".tab_content5").hide();
	//$(".tab_content5:first").show(); 
	var activeTab = $("ul.tabs5 li.active").attr("rel");
	$("#"+activeTab).show(); 	
	$("ul.tabs5 li").click(function() {
		$("ul.tabs5 li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content5").hide();
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab).fadeIn(); 
	});
	
	
	});
	function tcAccept(auctionID)
	{
		
		var tcval=jQuery('input[name=chktc]:checked').val();
		if(tcval != 'yes')
		{
			alert('Please accept tems & condition.');
			return false;
		}
		else
		{
			jQuery.ajax({
				url: '/bidder/tcAccepted',
				type: 'POST',
				data: {auctionID:auctionID},
				success: function(data) {
					location=location;
					//alert(data);
					
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
        <div class="container">
          <?php echo $leftPanel;?>
          <div class="secttion-right">
          
         <!-- <input name="Save" value="show event details" type="button" class="b_publish float-right b_showevent">-->
          <a href="#inline_content" class="grn-txt float-right b_showevent inline_auctiondetail">Show event details</a>
          <?php $currentStatus = $this->bidder_model->eventTrackCurrentStage($auction_data[0]->status,$auction_data[0]->bid_last_date,$auction_data[0]->auction_start_date,$auction_data[0]->auction_end_date,$auction_data[0]->second_opener,$auction_data[0]->bidder_participation_detail[0]->id,$auction_data[0]->bidder_participation_detail[0]->status,$auction_data[0]->bidder_participation_detail[0]->operner1_accepted,$auction_data[0]->bidder_participation_detail[0]->operner2_accepted);
		  $user_id=2;
						?>
            <div class="table-section"> <div id="tab-pannel5" class="btmrgn">
              <ul class="tabs5">
                <li <?php echo ($currentStatus=='tc' OR $currentStatus=='participate')?'class="active"':'';?> rel="tab5">
				<span class="white-circle">1</span> 
					<div class="tabtext">
						<span>Participation Stage</span> 
						<span class="status"><?php if($currentStatus=='tc' OR $currentStatus=='participate')echo 'Current Stage';?></span>
					</div>
					<div class="arrow-down"></div>
				</li>
                <li rel="tab6" <?php echo ($currentStatus=='accepted' OR $currentStatus=='openning')?'class="active"':'';?>>
					<span class="white-circle">2</span>
					<div class="tabtext">
						<span>Opening Stage</span>
						<span class="status"><?php if($currentStatus=='accepted' OR $currentStatus=='openning')echo 'Current Stage';?></span>
					</div>
					<div class="arrow-down"></div>
				</li>
                <li rel="tab7" <?php echo ($currentStatus=='liveauction' OR $currentStatus=='auction')?'class="active"':'';?>>
					<span class="white-circle">3</span>
					<div class="tabtext">
						<span>Auction</span>
						<span class="status"><?php if($currentStatus=='liveauction' OR $currentStatus=='auction')echo 'Current Stage';?></span>
					</div>
					<div class="arrow-down"></div>
				</li>
                <li rel="tab8" <?php echo ($currentStatus=='report' OR $currentStatus=='viewreport')?'class="active"':'';?>>
					<span class="white-circle">4</span>
					<div class="tabtext"> 
						<span>Reports</span> 
						<span class="status"><?php if($currentStatus=='report' OR $currentStatus=='viewreport')echo 'Current Stage';?></span>
					</div>
					<div class="arrow-down"></div>
				</li>
              </ul>
			  
              <div class="tab_container5">
                <div id="tab5" class="tab_content5">
                  <div class="container">
                  
                    <div class="circle-category"> <span class="icon-circle"><img src="/images/icon-eventfee.png"></span>
                      <div class="txt">Event Fee </div>
                      <div class="price"><span class="WebRupee">Rs</span><?php echo $auction_data[0]->tender_fee?></div>
                    </div>
                    <div class="circle-category"> <span class="icon-circle"><img src="/images/icon-emd-amount.png"></span>
                      <div class="txt">EMD Amount</div>
                      <div class="price"><span class="WebRupee">Rs</span><?php echo $auction_data[0]->emd_amt?></div>
                    </div>
                    <div class="circle-category"> <span class="icon-circle"><img src="/images/dash-icon2.png"></span>
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
                    	<!--<li>Pan Card</li>
                        <li>AUCTION BID FORM</li>
                        <li>Annexure 2</li>
                        <li>Passport</li>-->
                      </ul>
                    </div>
					<?php if($currentStatus=='participate'){?>
                    <div class="circle-category-right">
                      <a href="/bidder/auction_participate/<?php echo $auction_data[0]->id?>"><input name="Save" value="Participate" type="button" class="b_publish float-right"></a>
                    </div>
					<?php }if($currentStatus=='tc'){?>
                    <!--<div class="circle-category-notice">
                      <div id="ContentPlaceHolder1_divAcptChk" style="padding: 20px; font-size: 12px; padding-top: 0px; padding-bottom: 0px" align="center">
					  
                        <input name="chktc" type="checkbox" id="chktc" value="yes">
                        <span style="line-height: 20px">I agree that : I have read and accepted the <a href="#" class="terms" target="_blank" >User Agreement and Privacy Policy.</a>
                            <br>
                            I may receive communications from Bank Auctions. </span>
                        <span id="ContentPlaceHolder1_Label1"></span><br>
                        <div align="center">
                            <input type="button" name="submit" value="Submit" class="b_submit" onclick="return tcAccept(<?php echo $auction_data[0]->id?>);">
                        </div>
                    </div>
                    </div>-->
					<div class="circle-category-notice">
					<div id="ContentPlaceHolder1_divAcptChk">
						<input name="chktc" type="checkbox" id="chktc" value="yes">
						<span>I agree that : I have read and accepted the <a href="#" class="terms" target="_blank">User Agreement and Privacy Policy.</a> I may receive communications from <?php echo BRAND_NAME; ?> . </span>
						<span id="ContentPlaceHolder1_Label1"></span>
						<div> <input type="button" name="submit" value="Submit" class="b_submit" onclick="return tcAccept(<?php echo $auction_data[0]->id?>);">  </div>
					</div>
					</div>
					<?php }?>
					
                  </div>
                </div>
                
                <!-- #tab1 -->
                <div id="tab6" class="tab_content5">
                  <div class="container tpmrg50">
                 
                  
                   <span class="icon-circle-big"><img src="/images/icon-thumb.png"></span>
                    <div class="congress-txt"><?php if($currentStatus=='accepted'){?> <span class="grn-txt">Congratulation!!</span> You Have Been Qualified For The Auction by Competent Authority.<?php }elseif($currentStatus=='openning'){?> Opening is in Progress.<?php }else{?>Opening is Scheduled at : <?php echo $auction_data[0]->bid_opening_date;}?>
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
					<?php if($currentStatus=='liveauction'){?>
                    <div class="circle-category-right">
                     <a href="/bidder/listLiveAuctions"> <input name="Save" value=" Click here to Enter Auction" type="button" class="b_publish2 float-right"></a>
					  <!-- <span style="line-height: 20px">Please attach your certificate before going for auctions!! </span>
						<div align="center">
						<input id="btnAttachCert" class="button big grey" type="submit" onclick="return AttachCert();" value="Attach Certificate" name="ctl00$ContentPlaceHolder1$btnAttachCert">
						</div>-->
						<!-- <input id="chkRegister3" type="checkbox" name="ctl00$ContentPlaceHolder1$chkRegister3">
							<span style="line-height: 20px">
							I agree that : I have read and accepted the
							<a class="terms" onclick="javascript:fnVwAuctionDeclaration();" href="#">Auction Training</a>[popup]
							</span>
							<span id="ContentPlaceHolder1_Label2"></span>
							<br>
							<div align="center">
							<input id="btnSubmitAuction" class="button big grey" type="submit" onclick="javascript:return ValidateAuction();" value="Submit" name="ctl00$ContentPlaceHolder1$btnSubmitAuction">
							</div>-->
                    </div>
					<?php }?>
                  </div>
                </div>
                
                <!-- #tab3 -->
                
               <div id="tab8" class="tab_content5">
                  <div class="container tpmrg50 btmrg50"> <span class="icon-circle-big"><img src="/images/icon-report.png"></span>
                    <div class="congress-txt"><?php if($currentStatus=='viewreport'){?> <span class="grn-txt">Report</span> Will be Available For Downloads After Completion of Auction.<?php }else{?>
					<span class="grn-txt">Report</span> Will be Available For Downloads After Completion of Auction<?php }?></div>
                  </div>
                </div>
                
                <!-- #tab4 --> 
              </div>
            </div>
               
                <!-- #tab5 --> 
              </div>
            </div>
            <div class="note"> <span class="icon-note"></span> <div class="float-left">Event Tracker shows at what stage the event is currently. You can also view the completed & next stages and navigate directly from this page.  </div></div>
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
			$(document).ready(function(){
				
				$(".inline_auctiondetail").colorbox({inline:true, width:"65%"});
				$(".inline_auctiondetail1").colorbox({inline:true, width:"65%"});
				$(".inline_auctiondetail2").colorbox({inline:true, width:"65%"});
				//$(".emd_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {location.reload(true);}});
				$(".emd_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {$(".inline_auctiondetail1").click();}});
				$(".tenderfee_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {$(".inline_auctiondetail1").click();}});
				$(".doc_detail_iframe").colorbox({iframe:true, width:"42%", height:"40%",onClosed: function () {$(".inline_auctiondetail1").click();}});
			});
</script>
<div class="row"  style="display:none;">
          <div id="inline_content">
		  <div class="heading4 btmrg20">Event Auction Detail</div>
          <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
              <tbody role="alert" aria-live="polite" aria-relevant="all">
                <tr class="odd">
                  <td width="20%" align="left" valign="top" class=""><strong>Event Title</strong></td>
                  <td width="35%" align="left" valign="top" class="" colspan="3"><?php echo $auction_data[0]->event_title?></td>
                </tr>
                <tr class="even">                  
                  <td align="left" valign="top" class=""><strong>Event No. </strong></td>
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
                 
                  <td align="left" valign="top" class=""><strong>Event Created by</strong></td>
				 
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
