<style>
.grn-txt{text-align: center; outline:none; border:0;
    cursor: pointer; width:100%; text-decoration:none; float:left;
    color: #00F;
    font-size: 12px;}
	a {    font-size: 12px; text-decoration:none;}
	#spMsg {padding:15px 0 0 0;}
#spMsg  li{font-size:13px; color:#F00; padding:5px 5px; margin-bottom:1px; 

background:#ffd8db;}
</style>

<?php 

$productid	=	$prows->id;
$bank_id	=	$this->session->userdata['bank_id'];
$branch_id	=	$erows->branch_id;
$drt_id	=	$erows->drt_id;
$eventid='';

 //print_r($corrigendumRemarks);	

$reference_no			=	$auctionData->reference_no;
$currentdatatime		=	time();
$press_release_date		=	strtotime($auctionData->press_release_date); 
$inspection_date_from	=	strtotime($auctionData->inspection_date_from);
$inspection_date_to		=	strtotime($auctionData->inspection_date_to);
$bid_opening_date		=	strtotime($auctionData->registration_start_date);
$bid_last_date			=	strtotime($auctionData->bid_last_date);
$auction_end_date		=	strtotime($auctionData->auction_end_date);
$auction_start_date		=	strtotime($auctionData->auction_start_date);


//echo "<pre>";
// print_r($auctionData);
//echo "</pre>";
//echo "</pre>";
?>
<link rel="stylesheet" href="<?php echo base_url()?>/css/colorbox.css" />
<script src="<?php echo base_url()?>/js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<section class="body_main1">
  <?php //echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div id="tab-pannel3" class="btmrgn">
          <div class="tab_container3">
            
            <a href="/buyer/eventDetailPopup/<?php echo $auctionID;?>" class="grn-txt float-right b_showevent corrigendum_detail_iframe">Show Auction Details</a>
            <!-- #tab1 -->
            <div id="tab6" class="tab_content3">
              <div class="container">
                <?php //echo $leftPanel?>
                <div class="secttion-right">
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head no_cursor">Corrigendum (<?php echo $reference_no; ?>)</div>
					  <div  class="success_msg"><?php 
					  echo $this->session->flashdata('message');
					  ?></div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div class="table-section">
						<!--///--->
						
					
		  <form method="post" enctype="multipart/form-data" name="createauction" id="createauction" action="/buyer/createCorrigendum/<?php echo $auctionID;?>" autocomplete="off">
		   <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
<!--show error popup-->		  
<p style="display:none;"><a class='inline' href="#inline_content"></a></p>
<div style='display:none'>
	<div id='inline_content' style='padding:10px; background:#fff;'>
		<ul id="spMsg"></ul>
	</div>
</div> 
<!--show error popup -->
            <div class="form box-content2">
						<div class="row">
							<div class="lft_heading">Remarks <span class="red"> *</span></div>
							<div class="rgt_detail">
										<textarea name="remarks" id="remarks"  class="textarea html_found"></textarea>
										<div class="tooltips">
											<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
											<span>Remarks for this corrigendum.</span>
										</div>
							</div>
						</div>
				<?php /* ?>		
              <dl>
                <dt class="required">
                  <label>Remarks</label>
                </dt>
                <dd>
                  <textarea name="remarks" id="remarks"  class="textarea"></textarea>
				  <span class="help-icon" title="Remarks for this corrigendum."></span>
                </dd>
              </dl>
              <?php */ ?> 
				<div class="row">
							<div class="lft_heading">Property Address</div>
							<div class="rgt_detail">
										 <textarea name="product_description" id="product_description" class="textarea html_found"><?php echo trim($auctionData->PropertyDescription); ?></textarea>
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Property Address for this corrigendum</span>
										</div>
							</div>
						</div>
              <dl>
				  <?php /* ?>		
                <dt>
                  <label>Property Address</label>
                </dt>
                <dd>
			    <textarea name="product_description" id="product_description" class="textarea"><?php 
				  echo GetTitleByField('tbl_product','id='.$auctionData->productID,'product_description');
				  ?>
				  </textarea>
				
				  <span class="help-icon" title="Property Address for this corrigendum"></span>
                </dd>
              </dl>
              <?php */ ?> 
              <hr>
              <div class="seprator btmrg20"></div>
              
              <div class="row">
							<div class="lft_heading">Press Release Date<span class="red">*</span></div>
							<div class="rgt_detail">
										 <input disabled name="press_release_date" id="press_release_date" value="<?php echo $auctionData->press_release_date;?>"  type="text"  class="input">
										 <input name="press_release_date1" id="press_release_date1"  value="<?php echo $auctionData->press_release_date;?>" type="hidden"  >
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>The date of the press release of sale notice in news papers.</span>
										</div>
							</div>
						</div>
				<?php /* ?>		
              <dl>
                <dt>
                  <label>Press Release Date</label>
                </dt>
                <dd>
				
                  <input disabled name="press_release_date" id="press_release_date" value="<?php echo $auctionData->press_release_date;?>"  type="text"  class="input">
				  
				  <input name="press_release_date1" id="press_release_date1"  value="<?php echo $auctionData->press_release_date;?>" type="hidden"  >
				  <span class="help-icon" title="The date of the press release of sale notice in news papers."></span>
                </dd>
              </dl>
              
              <dl>
                <dt>
                  <label>Date of inspection of asset(From)</label>
                </dt>
                <dd>
				<?php
				if($inspection_date_from < $currentdatatime){
					$dis='disabled';
					?>
					
				<?php }else{
					$dis='';
				} ?>
				<input <?php echo $dis;?> name="inspection_date_from" id="inspection_date_from"  type="text"  class="input" value="<?php echo $auctionData->inspection_date_from;?>">
                  <input name="inspection_date_from1" id="inspection_date_from1"  value="<?php echo $auctionData->inspection_date_from;?>" type="hidden"  class="input">
				  
                  <span class="help-icon" title="Date from when interested bidder may visit the property physically."></span> </dd>
              </dl>
              <?php */ ?>
              <div class="row">
							<div class="lft_heading">Site Visit Start Date</div>
							<div class="rgt_detail">
								<?php
									if($inspection_date_from < $currentdatatime){
										$dis='disabled';
										?>
										
									<?php }else{
										$dis='';
									} ?>
										  <input <?php echo $dis;?> name="inspection_date_from" id="inspection_date_from"  type="text"  class="input" value="<?php echo $auctionData->inspection_date_from;?>">
										<input name="inspection_date_from1" id="inspection_date_from1"  value="<?php echo $auctionData->inspection_date_from;?>" type="hidden"  class="input">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Date from when interested bidder may visit the property physically.</span>
										</div>
							</div>
						</div>
						<div class="row">
							<div class="lft_heading">Site Visit End Date</div>
							<div class="rgt_detail">
									<?php
										if($inspection_date_to < $currentdatatime){
											$dis='disabled';
											//$id= 'inspection_date_to_disabled';
										}else{
											$dis='';
											//$id= 'inspection_date_to';
										}
										?>
										  <input <?php echo $dis;?> name="inspection_date_to"   id="inspection_date_to" value="<?php echo $auctionData->inspection_date_to;?>" type="text"  class="input">
										<input name="inspection_date_to1"  value="<?php echo $auctionData->inspection_date_to;?>" id="inspection_date_to1" type="hidden"  class="input">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Date till which any interested bidder may visit the property physically.</span>
										</div>
							</div>
						</div>
			<?php /* ?>	
              <dl>
                <dt>
                  <label>Date of inspection of asset (To)</label>
                </dt>
                <dd>
				<?php
				if($inspection_date_to < $currentdatatime){
					$dis='disabled';
					//$id= 'inspection_date_to_disabled';
				}else{
					$dis='';
					//$id= 'inspection_date_to';
				}
				?>
				
                  <input <?php echo $dis;?> name="inspection_date_to"   id="inspection_date_to" value="<?php echo $auctionData->inspection_date_to;?>" type="text"  class="input">
				  
				  
                  <input name="inspection_date_to1"  value="<?php echo $auctionData->inspection_date_to;?>" id="inspection_date_to1" type="hidden"  class="input">
                  
                  <span class="help-icon" title="Date till which any interested bidder may visit the property physically."></span> </dd>
              </dl>
              <dl>
                <dt >
                  <label>Sealed Bid Submission Last Date</label>
                </dt>
                <dd>
				<?php
				if($bid_last_date < $currentdatatime){
					$dis='disabled';
					//$id= 'bid_last_date_disabled';
				}else{
					$dis='';
					//$id= 'bid_last_date';
				}
				?>
				
                  <input <?php echo $dis;?> name="bid_last_date" value="<?php echo $auctionData->bid_last_date;?>"   id="bid_last_date" type="text"  class="input">
                  <input name="bid_last_date1"  value="<?php echo $auctionData->bid_last_date;?>" id="bid_last_date1" type="hidden"  class="input">
                 
                  <span class="help-icon" title="Date till when the interested bidder may submit the EMD/Required Documents/Quote the initial price"></span> </dd>
              </dl>
              <?php */ ?>
              
						
						<div class="row">
							<div class="lft_heading">Apply and EMD Start Date<span class="red">*</span></div>
							<div class="rgt_detail">
									<?php
									if($bid_opening_date < $currentdatatime){
										$dis='disabled';
										//$id='bid_opening_date_disabled';
										}else{
										$dis='';
										//$id='bid_opening_date';
										
										}
									?>
										<input <?php echo $dis; ?> value="<?php echo $auctionData->registration_start_date;?>" name="bid_opening_date"   id="bid_opening_date" type="text"  class="input">
										<input name="bid_opening_date1"  value="<?php echo $auctionData->registration_start_date;?>" id="bid_opening_date1" type="hidden"  class="input">
										<div class="tooltips">
											<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Date of the opening of the recieved sealed bid from bidders. After opening the bank official will verify the EMD and documents submitted by the bidder.</span>
										</div>
							</div>
						</div>
						
						<div class="row">
							<div class="lft_heading">Apply and EMD End Date<span class="red">*</span></div>
							<div class="rgt_detail">
									<?php
										if($bid_last_date < $currentdatatime){
											$dis='disabled';
											//$id= 'bid_last_date_disabled';
										}else{
											$dis='';
											//$id= 'bid_last_date';
										}
										?>
										<input <?php echo $dis;?> name="bid_last_date" value="<?php echo $auctionData->bid_last_date;?>"   id="bid_last_date" type="text"  class="input">
										<input name="bid_last_date1"  value="<?php echo $auctionData->bid_last_date;?>" id="bid_last_date1" type="hidden"  class="input">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Date till when the interested bidder may submit the EMD/Required Documents/Quote the initial price</span>
										</div>
							</div>
						</div>
						<div class="row">
							<div class="lft_heading">Auction Start date<span class="red">*</span></div>
							<div class="rgt_detail">
										<?php
										if($auction_start_date < $currentdatatime ){
											$dis='disabled';
											//$id='auction_start_date_disabled';
										}else{
											$dis='';
											//$id='auction_start_date';
										}
										?>
										 <input <?php echo $dis; ?> name="auction_start_date"  id="auction_start_date" value="<?php echo $auctionData->auction_start_date;?>" type="text"  class="input">
										<input name="auction_start_date1" value="<?php echo $auctionData->auction_start_date;?>" id="auction_start_date1" type="hidden"  class="input">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Date and time from which the auction will be started.</span>
										</div>
							</div>
						</div>
						
				<?php /* ?>		
              <dl>
                <dt >
                  <label>Sealed Bid Opening Date</label>
                </dt>
                <dd>
				<?php
				if($bid_opening_date < $currentdatatime){
					$dis='disabled';
					//$id='bid_opening_date_disabled';
					}else{
					$dis='';
					//$id='bid_opening_date';
					
					}
				?>
				
                  <input <?php echo $dis; ?> value="<?php echo $auctionData->bid_opening_date;?>" name="bid_opening_date"   id="bid_opening_date" type="text"  class="input">
                 <input name="bid_opening_date1"  value="<?php echo $auctionData->bid_opening_date;?>" id="bid_opening_date1" type="hidden"  class="input">
                 
                  <span class="help-icon" title="Date of the opening of the recieved sealed bid from bidders. After opening the bank official will verify the EMD and documents submitted by the bidder."></span> </dd>
              </dl>
              <dl>
                <dt>
                  <label>Auction Start date</label>
                </dt>
                <dd>
				<?php
				if($auction_start_date < $currentdatatime ){
					$dis='disabled';
					//$id='auction_start_date_disabled';
				}else{
					$dis='';
					//$id='auction_start_date';
				}
				?>
				
				
                  <input <?php echo $dis; ?> name="auction_start_date"  id="auction_start_date" value="<?php echo $auctionData->auction_start_date;?>" type="text"  class="input">
                  <input name="auction_start_date1" value="<?php echo $auctionData->auction_start_date;?>" id="auction_start_date1" type="hidden"  class="input">
                 
                  <span class="help-icon" title="Date and time from which the auction will be started."></span> </dd>
              </dl>
              <?php */ ?>
              
              <div class="row">
							<div class="lft_heading">Auction End date<span class="red">*</span></div>
							<div class="rgt_detail">
									<?php
										if($auction_end_date < $currentdatatime ){
											$dis='disabled';
											//$id='auction_end_date_disabled';
										}else{
											$dis='';
											//$id='auction_end_date';
										}
										?>
										<input <?php echo $dis; ?>  value="<?php echo $auctionData->auction_end_date;?>" name="auction_end_date"  id="auction_end_date" type="text"  class="input">
									<input name="auction_end_date1" value="<?php echo $auctionData->auction_end_date;?>"  id="auction_end_date1" type="hidden"  class="input">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Scheduled date and time to end the auction</span>
										</div>
							</div>
						</div>
						<!--<div class="row">
                                                <div class="lft_heading"> Check To Upload Special terms and conditions </div>
                                                <div class="rgt_detail">
													<input name="supporting_doc_check"  id="supporting_doc_check" type="checkbox" onclick="checksupportingdoc();" class="input">
													<div class="tooltips">
														<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
														<span>You may upload the images of asset under this option.</span>
													</div>
                                                </div>
						</div>
                        <div class="row">
							<div class="lft_heading"> Upload Special terms and conditions documents</div>
							<div class="rgt_detail">
                                         <input name="supporting_doc1"  id="supporting_doc" type="file" disabled="true" class="input">
												<?php  if($auctionData->supporting_doc){ ?>
														<input name="old_supporting_doc"  id="supporting_doc"  value="<?php echo $auctionData->supporting_doc;?>" type="hidden"  class="input">
														<a target="_blank" href="/public/uploads/event_auction/<?php echo $auctionData->supporting_doc;?>"><?php echo $auctionData->supporting_doc?></a>	
												<?php } ?>
										<div class="tooltips">
											<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
											<span>You may upload the images of special terms and conditions.</span>
										</div>
								</div>
						</div>
				<?php /* ?>		
              <dl>
                <dt>
                  <label>Auction End date</label>
                </dt>
                <dd>
				<?php
				if($auction_end_date < $currentdatatime ){
					$dis='disabled';
					//$id='auction_end_date_disabled';
				}else{
					$dis='';
					//$id='auction_end_date';
				}
				?>
                  <input <?php echo $dis; ?>  value="<?php echo $auctionData->auction_end_date;?>" name="auction_end_date"  id="auction_end_date" type="text"  class="input">
                  <input name="auction_end_date1" value="<?php echo $auctionData->auction_end_date;?>"  id="auction_end_date1" type="hidden"  class="input">
                  
                  <span class="help-icon" title="Scheduled date and time to end the auction"></span> </dd>
              </dl>
              <?php */ ?>
              <hr>
              <div class="seprator btmrg20"></div>
              
              
              <div class="row">
					<div class="lft_heading">Upload Related Documents <span class="red">*</span> </div>
					<div class="rgt_detail">
								<input name="related_doc"  id="related_doc" type="file"  class="input">
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>You may upload the images of asset under this option.</span>
								</div>
								 <?php
								  if($auctionData->related_doc){?>
								   <input name="old_related_doc"  id="old_related_doc" value="<?php echo $auctionData->related_doc;?>" type="hidden"  class="input">
								   <a download target="_blank" href="/public/uploads/event_auction/<?php echo $auctionData->related_doc;?>"> <?php echo $auctionData->related_doc;?></a>
								  <?php } ?>
								
					</div>
				</div>
						
						
						
				<div class="row">
					<div class="lft_heading">Upload Image <span class="red">*</span> </div>
					<div class="rgt_detail">
								<input name="image"  id="image" type="file"  class="input">
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>Please select the documents to be submitted by the bidder while sealed bid. You may select multiple options by keeping the CTRL key pressed and then selecting.</span>
								</div>
								<?php
								  if($auctionData->image){ ?>
									 <input name="old_image"  id="old_image"  value="<?php echo $auctionData->image;?>" type="hidden"  class="input">
									<a download href="/public/uploads/event_auction/<?php echo $auctionData->image;?>"><?php echo $auctionData->image?></a>	
								  <?php } ?>
								
					</div>
				</div>
				<?php /* ?>		
              <dl>
                <dt>
                  <label>Upload Related Documents</label>
                </dt>
                <dd>
                  <input name="related_doc"  id="related_doc" type="file"  class="input">
				  <?php
				  if($auctionData->related_doc){?>
				   <input name="old_related_doc"  id="old_related_doc" value="<?php echo $auctionData->related_doc;?>" type="hidden"  class="input">
				   <a download href="/public/uploads/event_auction/<?php echo $auctionData->related_doc;?>"> <?php echo $auctionData->related_doc;?></a>
				  <?php } ?>
                  <span class="help-icon" title="You may upload the images of asset under this option."></span> </dd>
              </dl>
              <dl>
                <dt>
                  <label>Upload Image</label>
                </dt>
                <dd>
                  <input name="image"  id="image" type="file"  class="input">
                  <span class="help-icon" title="Please select the documents to be submitted by the bidder while sealed bid. You may select multiple options by keeping the CTRL key pressed and then selecting."></span>
				<?php
				  if($auctionData->image){ ?>
					 <input name="old_image"  id="old_image"  value="<?php echo $auctionData->image;?>" type="hidden"  class="input">
					<a download href="/public/uploads/event_auction/<?php echo $auctionData->image;?>"><?php echo $auctionData->image?></a>	
				  <?php } ?>
				  

				  </dd>
              </dl>
              <?php */ ?>
              
              <div class="row" id="div_second_opener">
							<div class="lft_heading">Second Opener</div>
							<div class="rgt_detail">
										<select name="second_opener" id="second_opener" class="select" >
										  <option value="">Select Second opener</option>
											 <?php
											 /*$totalUser= count($banksUsersList);
											  if($totalUser>0)
											  { 
												foreach($banksUsersList as $urow){ ?>
												<option value="<?php echo $urow->id;?>" <?php echo ($urow->id==$auctionData->second_opener)?'selected':''; ?>><?php echo $urow->email_id;?>, <?php echo $urow->user_id;?>, <?php echo ucfirst($urow->first_name);?>  <?php echo $urow->last_name;?></option>    
										  <?php }
											  
											  } */?>
										  </select>
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>This is the higher authority. IF the event is SARFAECI then he/she may be the Senior officer from the bank. If the event is DRT he/She may be the DRT recovery officer. The dropdown will contain the name of the user depending upon the account you have chosen from top.</span>
										</div>
							</div>
						</div>
					<?php /* ?>	
              <dl id="div_second_opener" >
                <dt>
                  <label>Second Opener</label>
                </dt>
                <dd>
                  <select name="second_opener" id="second_opener" class="select" >
				  <option value="">Select Second opener</option>
                     <?php
					 $totalUser= count($banksUsersList);
					  if($totalUser>0)
					  { 
					    foreach($banksUsersList as $urow){ ?>
						<option value="<?php echo $urow->id;?>" <?php echo ($urow->id==$auctionData->second_opener)?'selected':''; ?>><?php echo $urow->email_id;?>, <?php echo $urow->user_id;?>, <?php echo ucfirst($urow->first_name);?>  <?php echo $urow->last_name;?></option>    
				  <?php }
					  
					  } ?>
                  </select>
                  <span class="help-icon" title=""></span> </dd>
              </dl>
              <?php */ ?>
              
              <div class="row" id="div_second_opener">
							<div class="lft_heading">Status</div>
							<div class="rgt_detail">
										<select  id="status" name="status" class="select">
											<option value="">Select</option>
											<option value="3">Stay</option>
											<option value="4">Cancel</option>

										</select>
							</div>
						</div>
              <?php /* ?>
              <dl id="div_second_opener" >
                <dt>
                  <label>Status</label>
                </dt>
                <dd>
                  <select  id="status" name="status" class="select">
						<option value="">Select</option>
						<option value="3">Stay</option>
						<option value="4">Cancel</option>

					</select>
                  <span class="help-icon" title=""></span> </dd>
              </dl>
              <?php */ ?>-->
              
              
              <div class="seprator btmrg20"></div>
			  <div class="button-row row" style="text-align:center;">
				 <a href="/buyer/" class="b_publish button_grey">Back </a>
					&nbsp;&nbsp;
					<input name="submit" onclick="return corivalidateSubmitform();"  value="Submit" type="submit" class="b_publish button_grey"> 
					
			 <input type="hidden" name="auctionID" id="auctionID" value="<?php echo $auctionID?>">
			 <input type="hidden" name="corrigendumID" id="corrigendumID" value="<?php echo $corrigendumID?>">
			<input type="hidden" name="currdate" id="currdate" value="<?php echo date("Y/m/d H:i:s") ?>" />

				</div>

			 
            </div>
			</form>
						
						<!--///--->
						
					
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
    function checksupportingdoc(){
        if (!$("#supporting_doc_check").is(':checked')) {
              $("#supporting_doc").attr('disabled',true); 
        }else{
               $("#supporting_doc").attr('disabled',false); 
        }
  }

$(".corrigendum_detail_iframe").colorbox({iframe:true, width:"65%", height:"70%"});

jQuery('.html_found1').change(function() {
	   if ($(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
		  alert('Invalid html content found');
		  $(this).focus();
		  $(this).val('');
	   }
	});
	
	
	jQuery('#supporting_doc').change(function () {
			var getValue = this.value;
			var ext1 = getValue.split('.');
			var arr = ext1.length;
			var indexValuee = arr-1;
			if(typeof ext1[indexValuee] == "undefined")
			{
				alert('This is not an allowed file type.');
				this.value = '';
			}
			//var ext = this.value.match(/\.(.+)$/)[1];
			switch (ext1[indexValuee]) {
				case 'png':case 'jpg':case 'gif':case 'jpeg':case 'pdf':case 'xls':case 'doc':case 'docx':case 'zip':
				$('#supporting_doc').attr('disabled', false);
				break;
				default:
					alert('This is not an allowed file type.');
					this.value = '';
			}
	});
	jQuery('#related_doc').change(function () {
			var getValue = this.value;
			var ext1 = getValue.split('.');
			var arr = ext1.length;
			var indexValuee = arr-1;
			if(typeof ext1[indexValuee] == "undefined")
			{
				alert('This is not an allowed file type.');
				this.value = '';
			}
			//var ext = this.value.match(/\.(.+)$/)[1];
			switch (ext1[indexValuee]) {
				case 'png':case 'jpg':case 'gif':case 'jpeg':case 'pdf':case 'xls':case 'doc':case 'docx':case 'zip':
				$('#related_doc').attr('disabled', false);
				break;
				default:
					alert('This is not an allowed file type.');
					this.value = '';
			}
	});
	jQuery('#image').change(function () {
			var getValue = this.value;
			var ext1 = getValue.split('.');
			var arr = ext1.length;
			var indexValuee = arr-1;
			if(typeof ext1[indexValuee] == "undefined")
			{
				alert('This is not an allowed file type.');
				this.value = '';
			}
			//var ext = this.value.match(/\.(.+)$/)[1];
			switch (ext1[indexValuee]) {
				case 'png':case 'jpg':case 'gif':case 'jpeg':case 'pdf':case 'xls':case 'doc':case 'docx':case 'zip':
				$('#image').attr('disabled', false);
				break;
				default:
					alert('This is not an allowed file type.');
					this.value = '';
			}
	});
	
  jQuery('#press_release_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		maxDate: 0,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	
  jQuery('#inspection_date_from').datetimepicker({
		controlType: 'select',
		oneLine: true,
		minDate: 0,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	
	jQuery('#inspection_date_to').datetimepicker({
		controlType: 'select',
		oneLine: true,
		minDate: 0,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#bid_last_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		minDate: 0,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	  jQuery('#bid_opening_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		minDate: 0,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	  jQuery('#auction_start_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		minDate: 0,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#auction_end_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		minDate: 0,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
		
  //tooltip
  jQuery(function() {
    jQuery('.help-icon').tooltip();
  });
</script>
