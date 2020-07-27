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
<?php echo $executive_breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div class="container">
          <?php echo $executive_leftsidebar;?>
		  <div class="secttion-right">
          <div class="heading4 btmrg20"><?php //echo $heading?></div>
          <div class="row"  style="display:none;">
          <div id="inline_content">
		  <div class="heading4 btmrg20">Event Auction Detail</div>
          <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
              <tbody role="alert" aria-live="polite" aria-relevant="all">
                <tr class="odd">
                  <td width="20%" align="left" valign="top" class=""><strong>Event No</strong></td>
                  <td width="35%" align="left" valign="top" class=""><?php echo $auction_data->eventID;?> (Auction No-<?php echo $auction_data->id;?>)</td>
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
					  echo '<a download href="/public/uploads/event_auction/'.$auction_data->related_doc.'">'.$auction_data->related_doc.'</a>';
				  }else{ echo "Not available";}
				  ?>
				 </a></td>
                  <td align="left" valign="top" class=""><strong>View Image</strong></td>
                  <td align="left" valign="top" class="">
				  <?php 
				  if($auction_data->image){
					  echo '<a download href="/public/uploads/event_auction/'.$auction_data->image.'">'.$auction_data->image.'</a>';
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
		  
		  <form name="quote_price_submit" id="quote_price_submit" action="/bidder/saveFrqParticipate/" method="post">
          <div class="heading4 btmrg20"><?php echo $heading;?> <a class='inline_auctiondetail green-more float-right' href="#inline_content" class="green-more float-right">Show Event Details</a></div>
          <div style="text-align:center;" id="spMsg"></div>
		  <?php if(isset($this->session->userdata['flash:old:message'])){?>
				<div  style="color:red;text-align:center;"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
			<?php } ?>
            <table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable dataTable" aria-describedby="big_table_info">
              <?php //echo $auction_data->price_bid_applicable;?>
              <tbody>
			 
			  
                <tr class="odd">
                  <td width="5%" align="left" valign="top" class=" sorting_1">1</td>
                  <td width="30%" align="left" valign="top" class=""><strong>Event/Tender Fee</strong></td>
					<?php 
					if($auction_data->price_bid_applicable=='not_applicable')
					{ ?>
						<td width="35%" align="left" valign="top" class="">Not Applicable</td>
						<td width="30%" align="left" valign="top" class="">Not Applicable</td>	
					<?php } else if($auction_data->price_bid_applicable=='applicable'){ ?>
					<td width="35%" align="left" valign="top" class="">
						<a class='iframe_paytenderfee' href="/helpdesk_executive/paytenderfee/<?php echo $bidderid;?>/<?php echo $auction_id;?>">Pay/Update</a>
					</td>
					<td width="30%" align="left" valign="top" class=""><?php if($tender_paid){ echo "Paid";} else{echo "Not Paid";} ?></td>	
					<?php } ?>
                </tr>
                <tr class="even">
                  <td align="left" valign="top" class=" sorting_1">2</td>
                  <td align="left" valign="top" class=""><strong>EMD Amount</strong></td>
                  <td align="left" valign="top" class=""><a class='iframe' href="/helpdesk_executive/payEmd/<?php echo $bidderid;?>/<?php echo $auction_id;?>">Pay/Update</a></td>
                  <td align="left" valign="top" class=""><?php if($emd_paid){ echo "Paid"; }else{echo "Not Paid";} ?></td>
                </tr>
                <tr class="odd">
                  <td align="left" valign="top" class=" sorting_1">3</td>
                  <td align="left" valign="top" class=""><strong>Documents</strong></td>
                  <td align="left" valign="top" class=""><a class='upload_doc_iframe' href="/helpdesk_executive/submitDocument/<?php echo $bidderid;?>/<?php echo $auction_id;?>">Upload Doc</a></td>
                  <td align="left" valign="top" class=""><?php if($documents_paid){ echo "Uploaded"; } else{echo "Not Uploaded";} ?></td>
                </tr>
                <tr class="even">
                  <td align="left" valign="top" class=" sorting_1">4</td>
				  <td align="left" valign="top" class=""><strong>Quote Price</strong></td>
				  <?php if($auction_data->show_frq==1){ ?>
				  
                  
                  <td align="left" valign="top" class="">
				  <input value="<?php echo $latest_frq;?>"  name="quote_price" id="quote_price" type="text" class="input"> <?php echo $latest_frq;?>
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
              <input name="tender_paid" id="tender_paid"  value="<?php if($tender_paid>0){echo $saveval=1;}else{echo $saveval='';}?>" type="hidden">
			  <input name="auction_id" id="auction_id" type="hidden" value="<?php echo $auction_id;?>">
			 <input name="reserve_price" id="reserve_price" type="hidden" value="<?php echo $auction_data->reserve_price;?>">
			  
			  <a href="/bidder/eventTrack/<?php echo $auction_id;?>"><input name="back" value="Back" type="button" class="b_submit float-left"></a>
              <input name="fSave" value="Final Submit" onclick="return validateParticipate('final_save');" type="submit" class="b_submit float-right">
            </div>
			</form>
          </div>
        </div>
	
		
      </div>
    </div>
  </div>
</section>
