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
		  
          <div class="heading4 btmrg20"><a class='inline_auctiondetail green-more float-right green-more' href="#inline_content">Show Auction Details</a></div>
          <div style="text-align:center;" id="spMsg">
		  <?php echo $msg;?>
		  </div>
		  <?php if(isset($this->session->userdata['flash:old:message'])){?>
				<div class="error1"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
			<?php } ?>
            
              <?php //echo $auction_data->price_bid_applicable;?>
             
			  <form method="post" enctype="multipart/form-data" name="postsellerpayment" id="postsellerpayment" action="/owner/ccavRequestHandler">
				<div class="form">
				
				<!--
					 <dl>
						<dt class="required">
						  <label>Order Id </label>
						</dt>
						<dd>
						  <input name="order_id" id="order_id" type="text" value="" class="input">
						  </dd>
					</dl>
				-->
					<dl>
						<dt class="required">
						  <label>Amount </label>
						</dt>
						<dd>
						   <input readonly name="amount" id="amount" type="text" value="<?php echo $participation_fee;?>" class="input">
						  </dd>
					</dl>
					
					<div class="seprator btmrg20"></div>
					
					<h4>Billing information:</h4>
					<dl>
						<dt>
						  <label>Billing Name :</label>
						</dt>
						<dd>
						   <input name="billing_name" id="billing_name" value="<?php echo $user_data->first_name;?> <?php echo $user_data->last_name;?>" type="text" class="input">
						   </dd>
					</dl>
					
					<dl>
						<dt >
						  <label>Billing Address :</label>
						</dt>
						<dd>
						   <input name="billing_address" id="billing_address" type="text" value="<?php echo $user_data->address1;?>" class="input">
						  </dd>
					</dl>
					<dl>
						<dt>
						  <label>Billing City :</label>
						</dt>
						<dd> 
						   <input name="billing_city" id="billing_city" type="text" value="<?php echo GetTitleByField('tbl_city', "id='$user_data->city_id'" ,'city_name');?>" class="input">
						  </dd>
					</dl>
						<dl>
						<dt>
						  <label>Billing State	:</label>
						</dt>
						<dd>
						   <input name="billing_state" id="billing_state" type="text" value="<?php echo GetTitleByField('tbl_state',"id='$user_data->state_id'",'state_name');?>" class="input">
						  </dd>
					</dl>
							<dl>
						<dt>
						  <label>Billing Zip	:</label>
						</dt>
						<dd>
						   <input name="billing_zip" id="billing_zip" type="text" value="<?php echo $user_data->zip;?>" class="input">
						  </dd>
					</dl>
					
					<dl>
						<dt>
						  <label>Billing Country	:</label>
						</dt>
						<dd>
						   <input name="billing_country" id="billing_country" type="text" value="<?php echo GetTitleByField('tbl_country', "id='$user_data->country_id'",'country_name');?>" class="input">
						  </dd>
					</dl>
					<dl>
						<dt>
						  <label>Billing Tel	:</label>
						</dt>
						<dd>
						   <input name="billing_tel" id="billing_tel" type="text" value="<?php echo $user_data->mobile_no;?>" class="input">
						  </dd>
					</dl>
					<dl>
						<dt>
						  <label>Billing Email	:</label>
						</dt>
						<dd>
						   <input name="billing_email" id="billing_email" type="text" value="<?php echo $user_data->email_id;?>" class="input">
						  </dd>
					</dl>
					<div class="seprator btmrg20"></div>
				
					
					  <div class="seprator btmrg20"></div> 
						<div class="button-row">
						<a href="/owner/auction_participate/<?php echo $auctionID;?>">
						<input name="Back" value="Back" type="button" class="b_submit"> </a>
						
					<input type="hidden" name="auctionID" value="<?php echo $auctionID;?>">
					<input type="hidden" name="productID" value="<?php echo $propertyID;?>">
					<input type="hidden" name="payment_type" value="participation fee">
					<input name="payment" value="Pay Now" type="submit" class="b_submit">
								<!--
								<a href="javascript:void(0);" onclick="return savePropertyAuction(<?php echo $propertyID;?>);"><input name="save" value="Save" type="button" class="b_submit"> </a>
								<a href="javascript:void(0);" onclick="return paynow(<?php echo $propertyID;?>);"><input name="Back" value="Pay Now" type="button" class="b_submit"> </a>
								-->
							</div>

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
