<?php
//echo "<pre>";
//print_r($auction_data);
//echo "</pre>";
//echo "latest-".$latest_frq;
//echo "<br>id-".$auction_participateID;
?>
<link rel="stylesheet" href="/css/colorbox.css" />
<script src="/js/jquery.colorbox.js"></script>
<script>
$(document).ready(function(){
	$(".upload_doc_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {location.reload(true);}});
	$(".iframe").colorbox({iframe:true, width:"70%", height:"100%",onClosed: function () {location.reload(true);}});
	$(".iframe_paytenderfee").colorbox({iframe:true, width:"50%", height:"70%",onClosed: function () {location.reload(true);}});
	$(".inline_auctiondetail").colorbox({inline:true, width:"65%",onClosed: function () {location.reload(true);}});
	 
});
  jQuery(function() {
    jQuery('.help-icon').tooltip();
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
						<div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="heading4"><?php echo $heading?></div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
	   
          <div class="heading4 btmrg20"><?php //echo $heading?></div>
          <div class="row"  style="display:none;">
          <div id="inline_content">
		  <div class="heading4 btmrg20">Auction Detail</div>
          <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
              <tbody role="alert" aria-live="polite" aria-relevant="all">
                <tr class="odd">
                  <td width="20%" align="left" valign="top" class=""><strong>Auction No</strong></td>
                  <td width="35%" align="left" valign="top" class="">
				  <?php echo $auction_data->id;?></td>
                  <td width="20%" align="left" valign="top" class=""><strong>Reference No</strong></td>
                  <td width="20%" align="left" valign="top" class=""><?php echo $auction_data->reference_no;?></td>
                </tr>
                <tr class="even">
                  <?php $brows=$this->bank_model->GetRecordByid($auction_data->bank_id);?>
                  <?php $crows=$this->helpdesk_executive_model->GetCategoryRecordById($auction_data->category_id);?>
                  <?php $srows=$this->helpdesk_executive_model->GetCategoryRecordById($auction_data->subcategory_id);?>
                  <td align="left" valign="top" class=""><strong>Organization Name</strong></td>
                  <td align="left" valign="top" class=""><?php echo $brows->name;?></td>
                  <td align="left" valign="top" class=""><strong>Property Type</strong></td>
                  <td align="left" valign="top" class=""><?php echo $crows->name;?> - <?php echo $srows->name;?></td>
                 </tr>
                <tr class="odd">
                  
				  <?php $prows=$this->helpdesk_executive_model->GetProductDetail($auction_data->productID);?>
				  
                  <td align="left" valign="top" class=""><strong>Property Address</strong></td>
                  <td align="left" valign="top" class=""><?php echo $prows->product_description;?></td>
                  <td align="left" valign="top" class=""><strong>Reserve Price</strong></td>
                  <td align="left" valign="top" class=""><?php echo number_format($auction_data->reserve_price,2);?>&nbsp;&nbsp;&nbsp;( <?php echo getAmountInWords($auction_data->reserve_price) ; ?> )</td>
                  </tr>
                <tr class="even">
                  
                  <td align="left" valign="top" class=""><strong>EMD Amount</strong></td>
                  <td align="left" valign="top" class=""><?php echo number_format($auction_data->emd_amt,2); ?>  (<?php echo getAmountInWords($auction_data->emd_amt) ; ?> )</td>
                  <td align="left" valign="top" class=""><strong>Borrower Name</strong></td>
                  <td align="left" valign="top" class=""><?php echo ucfirst($auction_data->borrower_name);?></td>
                  </tr>
                <tr class="odd">
                 
                  <td align="left" valign="top" class=""><strong>Auction Start Date&nbsp;</strong></td>
				 
                  <td align="left" valign="top" class=""><?php echo date("d M Y H:i",strtotime($auction_data->auction_start_date));?> </td>
                  <td align="left" valign="top" class=""><strong>Auction End Date</strong></td>
                  <td align="left" valign="top" class=""><?php echo date("d M Y H:i",strtotime($auction_data->auction_end_date));?></td>
                  </tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>View NIT Document</strong></td>
                  <td align="left" valign="top" class=""><a href="#">  
				  <?php 
				  if($auction_data->related_doc){
					  echo '<a target="_blank" href="/public/uploads/event_auction/'.$auction_data->related_doc.'" download>Download</a>';
				  }else{ echo "Not available";}
				  ?>
				 </a></td>
                  <td align="left" valign="top" class=""><strong>View Image</strong></td>
                  <td align="left" valign="top" class="">
				  <?php 
				  if($auction_data->image){
					  echo '<a target="_blank" href="/public/uploads/event_auction/'.$auction_data->image.'" download>Download</a>';
				  }else{ echo "Not available";}
				  ?>
				  </td>
                  </tr>
                <tr class="odd">
                 
                  <td align="left" valign="top" class=""><strong>Documents Required&nbsp;</strong></td>
                  <td align="left" valign="top" class="">
				  
				  <?php 
				  if($auction_data->doc_to_be_submitted)
				  {
					  $docArr=explode(",",$auction_data->doc_to_be_submitted);
					  if(count($docArr)){
						  $docnameArr=array();
						  foreach($docArr as $docID){
							$docnameArr[]=GetTitleById('tbl_doc_master',$docID);
						  }
					  }
				  }
				  if(count($docnameArr)){
					 echo implode(', ',$docnameArr); 
				  }
				  ?>
				  </td>
                  <td align="left" valign="top" class=""><strong>Offer Submission Last Date&nbsp;</strong></td>
                  <td align="left" valign="top" class=""><?php echo date("d M Y H:i",strtotime($auction_data->bid_last_date));?></td>
                  </tr>
              </tbody>
             
            </table>
            
			</div>
          </div>
          
          <div class="seprator btmrg20"></div>
		  
		  <form name="quote_price_submit" id="quote_price_submit" action="/owner/saveFrqParticipate/" method="post">
		  <div class="success" style="color:red;"><?php 
		  echo $this->session->flashdata('msg');?></div>
          <div class="heading4 btmrg20"><?php// echo $heading;?> <a class='inline_auctiondetail green-more float-right' href="#inline_content" class="green-more float-right">Show Auction Details</a></div>
          <div style="text-align:center;" id="spMsg"></div>
		  <?php if(isset($this->session->userdata['flash:old:message'])){?>
				<div class="error1"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
			<?php } ?>
            <table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable dataTable" aria-describedby="big_table_info">
              <?php //echo $auction_data->price_bid_applicable;?>
              <tbody>
			  <tr class="even">
                  <td align="left" valign="top" class=" sorting_1">2</td>
                  <td align="left" valign="top" class=""><strong>Auction Fees</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $participation_fee;?> -
				  <a class='green_link' href="/owner/auctionparticipatefees/<?php echo $auction_id;?>"> Pay</a></td>
                  <td align="left" valign="top" class=""><?php if($emd_paid){ echo "Paid"; }else{echo "Not Paid";} ?></td>
                </tr>
				
                <tr class="odd">
                  <td align="left" valign="top" class=" sorting_1">3</td>
                  <td align="left" valign="top" class=""><strong>Documents</strong></td>
                  <td align="left" valign="top" class=""><a class='upload_doc_iframe green_link' href="/owner/submitDocument/<?php echo $bidderid;?>/<?php echo $auction_id;?>">Upload Doc</a></td>
                  <td align="left" valign="top" class=""><?php if($documents_paid){ echo "Uploaded"; } else{echo "Not Uploaded";} ?></td>
                </tr>
                <tr class="even">
                  <td align="left" valign="top" class=" sorting_1">4</td>
				  <td align="left" valign="top" class=""><strong>Quote Price</strong></td>
				  <?php if($auction_data->price_bid_applicable=='applicable'){ ?>
				  
                  
                  <td align="left" valign="top" class="">
				  <input value="<?php echo $latest_frq;?>"  name="quote_price" id="quote_price" type="text" class="input"> <?php// echo $latest_frq;?>
                    <span class="help-icon" title="This is the initial quote for the asset against the reserve price. This Amount cannot be lower than the reserve price. You may modify the price any time before the last date/Time of submission of sealed Bid."></span></td>
				  <?php } else{?>
				    <input type='hidden' name="quote_price" value="not_application" id="quote_price">
				    <td align="left" valign="top" class="">Not Applicable</td>
				  <?php } ?>
				   
                  <td align="left" valign="top" class="">&nbsp;</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4"><input name="Save" onclick="return validateParticipate('save');" value="Submit" type="submit" class="b_submit float-right"></th>
                </tr>
              </tfoot>
            </table>
            <div class="button-row tpmrg20">
              <input name="documents_paid" id="documents_paid"  value="<?php if($documents_paid>0){echo $saveval=1;}else{echo $saveval='';}?>" type="hidden">
			  
			  <?php
			  $alaise_name=GetTitleByField('tbl_auction_participate', "auctionID='".$auction_id."' AND bidderID='".$bidderid."'", 'alaise_name');
			  ?>
			  <input type="hidden" value="<?php echo $alaise_name;?>" name="alaise_name" id="alaise_name">
			  <input type="hidden" value="<?php echo $auction_participateID;?>" name="auction_participateID" id="auction_participateID">
			  
			  
			  <input type="hidden" value="<?php echo $auction_participateFRQID;?>" name="auction_participateFRQID" id="auction_participateFRQID">
			  
              <input name="emd_paid" id="emd_paid" value="<?php if($emd_paid>0){echo $saveval=1;}else{echo $saveval='';}?>" type="hidden">
              
			  <input name="auction_id" id="auction_id" type="hidden" value="<?php echo $auction_id;?>">
			 <input name="reserve_price" id="reserve_price" type="hidden" value="<?php echo $auction_data->reserve_price;?>">
			  
			  <a href="/owner/eventTrack/<?php echo $auction_id;?>" class="b_submit float-left">Back</a>
              <input name="fSave" value="Final Submit" onclick="return validateParticipate('final_save');" type="submit" class="b_submit float-right">
            </div>
			</form>
			
			
			
				   
				   
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
