<style>
#spMsg {padding:15px 0 0 0;}
#spMsg  li{font-size:13px; color:#F00; padding:0 5px; line-height:30px; margin-bottom:1px; background:#ffd8db;}
.container_12{width: 76% !important;}
.box-content2{width: 98% !important;}
.box-head{width: 96% !important;}
.success_msg{width: 94%; !important;}
</style>

<?php 
$productID	=	$prows->id;
$branch_id	=	$erows->branch_id;
$drt_id	=	$erows->drt_id;
//$closeBidderAuctionRows=$this->banker_model->getAllCloseAuctionBidder($auctionID);
$eventid='';
$city=$auctionData->city;
$state=$auctionData->state;
$country=$auctionData->countryID;
$other_city=$auctionData->other_city;
?>
<script>
if(typeof jQuery != 'undefined')
{
		$ = jQuery;
}
</script>
<script src="<?php echo base_url()?>js/common.js"></script>
<link href="<?php echo base_url()?>bankeauc/css/common.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/colorbox.css" />
<script src="<?php echo base_url()?>js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<!--<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/superadmin/js/plugins/jquery.validate.min.js"></script>

  <?php //echo $breadcrumb;?>

	 <section class="container_12">
		  <div class="row ">
			<div class="wrapper-full">
			  <div class="dashboard-wrapper">

				<div id="tab-pannel3" class="btmrgn">
		
				  <div class="tab_container3">
					
					
					<!-- #tab1 -->
					<div id="tab6" class="tab_content3">
					  <div class="container">
						
						<div class="secttion-right">
						  <div class="table-wrapper btmrg20">
							<div class="table-heading btmrg">
							  <div class="box-head no_cursor">Corrigendum</div>
							</div>
							<div class="table-section">
					
				  <form method="post" enctype="multipart/form-data" name="createauction" id="createauction" action="/superadmin/corrigendum/saveeventdata">
				  <input type="hidden" name="dartEvent" id="drtEvent" value="<?php if($drt_user == 'drt'){ echo '1'; }else{ echo '0'; };?>" />
				  <input type="hidden" name="corrigendum_backend" id="corrigendum_backend" value="1" />
		<!--show error popup-->		  
		<p style="display:block;"><a class='inline' href="#inline_content"></a></p>
		<div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
                            <ul id="spMsg" style="color:#CC0000;"></ul>
			</div>
		</div>  <?php if(isset($this->session->userdata['flash:old:message'])){?>
						<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
					<?php } ?>
		<!--show error popup -->
					<div class="form box-content2">

						
						<input type="hidden" value="<?php echo $userID;?>" name="first_opener"/>
					  <div class="plain row">
						  <div class="lft_heading">Account<span class="red">*</span></div>

						<div class="rgt_detail">
							
						  <label>
								<input <?php if($auctionData->event_type=='drt' || $drt_user == 'drt') { echo $chk='checked';}else{echo $chk='';}?> class="acounttype radio_icon" name="account" id="rdoEventDRT" type="radio" value="drt">
								DRT
						  </label>
						 <?php if($drt_user != 'drt'){?>
						  <label>
								<input class="acounttype radio_icon" <?php if($auctionData->event_type=='sarfaesi') {echo $chk='checked';}else{echo $chk='';}?> name="account" id="rdoEventSRFAESI" type="radio"  value="sarfaesi">
								SARFAESI
							</label>
                            <label>
								<input class="acounttype radio_icon" <?php if($auctionData->event_type=='others') {echo $chk='checked';}else{echo $chk='';}?> name="account" id="rdoEventOthers" type="radio"  value="others">
								Others
							</label>
							<?php } ?>
									<div class="tooltips">
													<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
													<span>An event can be initiated by DRT , by any bank under SARFAESI act or by any other registered organisation. The <?php echo BRAND_NAME; ?>  platform is made for these events. Please select the option accordingly..</span>
												</div>
						 </div>
					  </div>
					  
					  <div class="row">
							<div class="lft_heading">Property ID <span class="red">*</span></div>
							<div class="rgt_detail">
										<input name="reference_no" id="reference_no" type="text" max="500" value="<?php echo $auctionData->reference_no;?>"  class="input alphanumeric">
										<div class="tooltips">
													<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>This is the unique refrence number by which an event may be identified.e.g. in case of DRT event it may be the R C Number</span>
										</div>	
							</div>
						</div>

					  
					  <div class="row">
							<div class="lft_heading">Event Title <span class="red">*</span></div>
							<div class="rgt_detail">
										<input name="event_title"  max="500" id="event_title" type="text" value="<?php echo $auctionData->event_title;?>"   class="input alphanumeric">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>This will be the title of the event.e.g. Organization name vs Borrower Name or ‘e-Auction Sale notice for…’</span>
										</div>
							</div>
						</div>

					  
					  <div class="row">
							<div class="lft_heading">Name of the Organization <span class="red"> *</span></div>
							<div class="rgt_detail">
										<?php $str = 'disabled="disabled"'; if($drt_user == 'drt'){$str = "";} ?>
										<select name="bank_name" <?php echo $str;?>  id="bank_name"  class="select" onchange="showBranch(this.value,'admin');">
										<?php
											foreach($banks as $bank_record){ ?>
											<option value="<?php echo $bank_record->id; ?>" <?php echo ($bank_record->id==$auctionData->bank_id)?'selected':''; ?>><?php echo $bank_record->name; ?></option>
											<?php }?>
									  </select>
									   <input type="hidden" value="<?php echo $bank_id;?>" id="bank_id" name="bank_id" >
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>For bank users this field will be autofilled and non editable. For DRT user, they may select the name of the Organization whose asset is on auction.</span>
										</div>
							</div>
						</div>
				
					  <div class="row">
							<div class="lft_heading">Asset Category <span class="red"> *</span></div>
							<div class="rgt_detail">
										<select name="category_id" id="category" class="select" onchange="showsubcategry(this.value,'admin');">
										  <option value="">Select Category</option>
												<?php				
													foreach($category as $category_record){ ?>
														<option value="<?php echo $category_record->id; ?>" <?php echo ($category_record->id==$auctionData->category_id)?'selected':''; ?>><?php echo $category_record->name; ?></option>
												<?php }?>
										  </select>										  
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Assets are divided into categories. Please select the category of the asset from the dropdown.</span>
										</div>
							</div>
						</div>
						
				
					  <div class="row">
							<div class="lft_heading">Sub Category <span class="red"> *</span></div>
							<div class="rgt_detail">
							  <select class="select" name="subcategory_id" id="type">
								<option value="">Select</option>
									<?php
										$subcategory=$this->helpdesk_executive_model->GetsubCategorydata($auctionData->category_id,$auctionData->subcategory_id);									
										foreach($subcategory as $subcaterow){?>
											<option value="<?php echo $subcaterow->id; ?>" <?php echo ($subcaterow->id==$auctionData->subcategory_id)?'selected':''; ?>><?php echo $subcaterow->name; ?></option>
										<?php }?>
								</select>
							  <div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Under each category, sub categories are defined. You may choose the most suitable sub category.</span>
										</div>
							</div>
					  </div>
					  
					  <div class="row">
						<div class="lft_heading">Description of the property <span class="red"> *</span></div>
						<div class="rgt_detail">
                                                     <textarea rows="20" style="width: 94%;" maxlength="100000" name="description" id="description" type="text"  class="input"><?php echo $auctionData->product_description;?></textarea>
						  <!-- <input maxlength="8000" name="description" id="description" value="<?php //echo @$prows->product_description; ?>" type="text" class="input">-->
						   <div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Give a brief description of the asset on auction. E.g. In case of immovable asset the description can contain the size of the land/apartment, location and other attributes. In case of movable asset - the condition of machinery/vehicle etc.</span>
										</div>
						   </div>
					  </div>
                                          <div class="row">
							<div class="lft_heading">Country <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select name="country_id" id="country_id">
									<option value="">Select Country</option>
									<?php
									foreach($countries as $country_record){?>
					  <option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id==$country)?'selected':''; ?>><?php echo $country_record->country_name; ?></option>
									<?php }?>
								</select>
                                                             <div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Name of the country where property is located.</span>
										</div>
							</div>					
						</div>
                                             <div class="row">
							<div class="lft_heading">Property State <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select name="state_id" id="state_id">
									<option value="">Select State</option>
									<?php foreach($states as $state_record){ ?>
                                            <option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id==$auctionData->state)?'selected':''; ?>><?php echo $state_record->state_name; ?></option>
									<?php } ?>                               
								</select>
                                                             <div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Name of the state where property is located.</span>
										</div>
							</div>					
						</div>
						
						<div class="row">
							<div class="lft_heading">Property City <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select name="city_id" id="city_id">
								<option value="">Select City</option>
								<?php foreach($cities as $city_record){?>
					                        <option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id == $city)?'selected':''; ?>><?php echo $city_record->city_name; ?></option>
								<?php } ?>
                                <?php /* ?><option value="others" <?php echo (!empty($other_city))?'selected':''; ?> >Others</option>--><?php */ ?>
								</select>
                                                            <div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Name of the city where property is located.</span>
										</div>
                                                          
							</div>					
						</div>
                                            <div class="row" id="text_city_id" max="250" style="display:<?php if(!empty($other_city)){ echo 'block;';?><?php }else{ echo 'none;'; }?>">
                                                    <div class="lft_heading">Other City <span class="red"> *</span></div>
                                                    <div class="rgt_detail">
                                                        <input type="text" value="<?=$other_city;?>" id="othercity" name="other_city">
                                                         <div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Name of the city where property is located.</span>
										</div>
                                                          
                                                    </div>					
                                            </div>
        
				      <div class="row">
							<div class="lft_heading">Borrower Name <span class="red">*</span></div>
							<div class="rgt_detail">
										<input name="borrower_name" max="250" id="borrower_name" value="<?php echo $auctionData->borrower_name;?>" type="text"  class="input alphanumeric">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Name of the borrower.</span>
										</div>
							</div>
						</div>

					  
					  <div class="row">
							<div class="lft_heading">Kind Attention To.(Invoiced to be mailed) <span class="red"> *</span></div>
							<div class="rgt_detail">
										<select name="invoice_mail_to" id="invoice_mail_to"  class="select">
										<option value="">Select</option>
										  
										<?php 
										 $totalUser= count($banksUsersList); 
										  if($totalUser>0)
										  { 
											 foreach($banksUsersList as $urow){
										  ?>
											<option <?php echo ($urow->id==$auctionData->invoice_mail_to)?'selected':''; ?> value="<?php echo $urow->id;?>"><?php echo $urow->email_id;?>, <?php echo $urow->user_id;?>, <?php echo ucfirst($urow->first_name);?>  <?php echo $urow->last_name;?></option>    
										  <?php }
										  
										  } ?>
									  </select>
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Email Id, Login Id and Name of the User to be Invoice Mailing.
												</span>
										</div>
							</div>
						</div>
		
					  
					  <div class="row">
							<div class="lft_heading">To.(Invoice to be Mailed)</div>
							<div class="rgt_detail">
										<select name="invoice_mailed[]" id="invoice_mailed" size="4" multiple class="select-text">  
							  
										   <?php 
										   
										  if($auctionData->invoice_mailed){
											  $tosubArr=explode(',',$auctionData->invoice_mailed);
										  }
										 $totalUser= count($banksUsersList); 
										  if($totalUser>0)
										  { 
											 foreach($banksUsersList as $urow){
												 
												if(in_array($urow->id,$tosubArr)){
													$tosel='selected';	
												}else{
													$tosel='';		
												} 
												 $tosel1 = "";
												 if($urow->id == $auctionData->invoice_mail_to){
													$tosel='disabled="disabled"';	
												}
										  ?>
											<option <?php echo $tosel;?> value="<?php echo $urow->id;?>"><?php echo $urow->email_id;?>, <?php echo $urow->user_id;?>, <?php echo ucfirst($urow->first_name);?>  <?php echo $urow->last_name;?></option>    
										  <?php }
										  
										  } ?>
									  </select>
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Email Id, Login Id and Name of the User to be Invoice Mailing.
												</span>
										</div>
							</div>
						</div>
			
					  <hr>
					 <div class="seprator btmrg20"></div>
					  <div class="row">
							<div class="lft_heading">Reserve Price <span class="red">*</span></div>
							<div class="rgt_detail">
										 <input name="reserve_price" id="reserve_price" type="text" maxlength="13" value="<?php echo $auctionData->reserve_price;?>" class="input numericonly onlynumber">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>It is the base price finalised by the valuer of MCG.</span>
										</div>
							</div>
						</div>
					  
					  <div class="row">
							<div class="lft_heading">EMD Amount <span class="red">*</span></div>
							<div class="rgt_detail">
										<input <?php if($noofparticipate > 0){echo "readonly";}?> name="emd_amt" id="emd_amt" type="text" maxlength="13"  class="input numericonly onlynumber" value="<?php echo $auctionData->emd_amt;?>">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Earnest money deposit asked by the MCG.</span>
										</div>
							</div>
						</div>
					  
					  <div class="row">
							<div class="lft_heading">Tender Fee <span class="red">*</span></div>
							<div class="rgt_detail">
										<input name="tender_fee" id="tender_fee" type="text" maxlength="13" class="input numericonly onlynumber" value="<?php echo $auctionData->tender_fee;?>">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>This the the document fees payble by the bidder for purchasing the tender document. Please put 0 if not applicable.</span>
										</div>
							</div>
						</div>
						
					<div class="plain row">
							<div class="lft_heading">Nodal Bank</div>
							<div class="rgt_detail">
							  <label>Same
							  <input name="nodal_bank" <?php if($auctionData->nodal_bank=='same') {echo $chk='checked';}else{ echo $chk='';}?> class="nodalbank radio_icon" id="nodal_bank" checked type="radio" value="same">
							  </label>
							  <label>Other
							  <input name="nodal_bank" <?php if($auctionData->nodal_bank=='others') {echo $chk='checked';}else{echo $chk='';}?>  class="nodalbank radio_icon" id="nodal_bank1"  type="radio" value="others"></label>
							  <div class="tooltips">
									<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>The Organization name in which the interested bidder will remit the EMD/ tender fee through RTGS/ Challan.</span>
								</div>
					  </div>
					  
					  <div class="row">
							<div class="lft_heading">Nodal Bank Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<?php
									if($auctionData->nodal_bank=='same'){
										$nsele='disabled="disabled"';
										$bank_id1=$auctionData->nodal_bank_name;
									}else if($auctionData->nodal_bank=='others'){
										$nsele='';
										$bank_id1=$auctionData->nodal_bank_name;
									}else{
										$nsele='disabled="disabled"';
										$bank_id1=$bank_id;
									}
									?>
									<select name="nodal_bank_n"   <?php echo $nsele; ?> id="nodal_bank_n"  class="select">
									   <option value="">Select Nodal Bank Name</option>
									   <?php
											foreach($banks as $bank_record){ 
											?>
											<option value="<?php echo $bank_record->id; ?>" <?php echo ($bank_record->id==$auctionData->nodal_bank_name)?'selected':''; ?>><?php echo $bank_record->name; ?></option>
										<?php 
										
										}
										
										?>
									  </select>
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>The Organization name in which the interested bidder will remit the EMD/ tender fee through RTGS/ Challan.</span>
										</div>
										<input type="hidden" value="<?php echo $bank_id1; ?>" name="nodal_bank_name" id="nodal_bank_name">
							</div>
						</div>					
					
					  
					  <div class="row">
							<div class="lft_heading">Nodal Bank account number <span class="red">*</span></div>
							<div class="rgt_detail">
										<input  maxlength="14" name="nodal_bank_account"  id="nodal_bank_account" type="text" value="<?php echo $auctionData->nodal_bank_account;?>" onkeypress="return IsAlphaNumeric(event);" class="input numericonly_1">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span> The account No. in which the interested bidder will remit the EMD/ tender fee through RTGS/ Challan.</span>
										</div>
                                                                               
							</div>
						</div>
		
					  
					  <div class="row">
							<div class="lft_heading">Branch IFSC Code<span class="red">*</span></div>
							<div class="rgt_detail">
                                                            <input name="branch_ifsc_code" max="20" value="<?php echo $auctionData->branch_ifsc_code;?>"  id="branch_ifsc_code" type="text"  class="input alphanumeric2">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>11 digit IFSC code of the branch where the nodal account exists.</span>
										</div>
							</div>
						</div>
						
				  <hr>
					  
					  <div class="row">
							<div class="lft_heading">Press Release Date<span class="red">*</span></div>
							<div class="rgt_detail">
										 <input name="press_release_date" id="press_release_date"  value="<?php echo $auctionData->press_release_date;?>" type="text"  class="input">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>The date of the press release of sale notice in newspapers.</span>
										</div>
							</div>
						</div>
	
					  
					  <div class="row">
							<div class="lft_heading">Date of inspection of asset(From)</div>
							<div class="rgt_detail">
								<input name="inspection_date_from" id="inspection_date_from"  value="<?php echo $auctionData->inspection_date_from;?>" type="text"  class="input">								
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>Date from when interested bidder may visit the property physically.</span>
								</div>
							</div>
						</div>
						
					
					   <div class="row">
							<div class="lft_heading">Date of inspection of asset(To)</div>
							<div class="rgt_detail">
								<input name="inspection_date_to"  value="<?php echo $auctionData->inspection_date_to;?>" id="inspection_date_to" type="text"  class="input">
								<div class="tooltips">
									<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>Date till when interested bidder may visit the property physically.</span>
								</div>
							</div>
						</div>
		
					  <div class="row">
							<div class="lft_heading">Sealed Bid Submission Last Date<span class="red">*</span></div>
							<div class="rgt_detail">
										<input name="bid_last_date"  value="<?php echo $auctionData->bid_last_date;?>" id="bid_last_date" type="text"  class="input">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Date till when the interested bidder may submit the EMD/Required Documents/Quote the initial price</span>
										</div>
							</div>
						</div>
						
						<div class="row">
							<div class="lft_heading">Sealed Bid Opening Date<span class="red">*</span></div>
							<div class="rgt_detail">
										<input name="bid_opening_date"  value="<?php echo $auctionData->bid_opening_date;?>" id="bid_opening_date" type="text"  class="input">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Date of the opening of the recieved sealed bid from bidders. After opening the bank official will verify the EMD and documents submitted by the bidder.</span>
										</div>
							</div>
						</div>
	
					  <div class="row">
							<div class="lft_heading">Auction Start date<span class="red">*</span></div>
							<div class="rgt_detail">
										 <input name="auction_start_date" value="<?php echo $auctionData->auction_start_date;?>" id="auction_start_date" type="text"  class="input">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Date and time from which the auction will be started.</span>
										</div>
							</div>
						</div>
						
						<div class="row">
							<div class="lft_heading">Auction End date<span class="red">*</span></div>
							<div class="rgt_detail">
										 <input name="auction_end_date" value="<?php echo $auctionData->auction_end_date;?>"  id="auction_end_date" type="text"  class="input">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Scheduled date and time to end the auction</span>
										</div>
							</div>
						</div>
						<hr>
						
						<?php if($drt_user == 'drt'){ ?>
							<div class="row">
								<div class="lft_heading">Bank & Branch <span class="red"> *</span></div>
								<div class="rgt_detail">					
									<select name="bank_name1" id="bank_name1"  class="select" onchange="showBranch(this.value,'admin');">
										<?php 
										foreach($banks as $bank_record){ ?>
											<option value="<?php echo $bank_record->id; ?>" <?php echo ($bank_record->id==$auctionData->bank_id)?'selected':''; ?>><?php echo $bank_record->name; ?></option>
										<?php }?>
									</select>
									
									<select name="branch_id" id="bank_branch_name"  class="select">
										<?php //bankbranch
										foreach($bankbranch as $branch){ ?>
											<option value="<?php echo $branch->id; ?>" <?php echo ($branch->id == $auctionData->branch_id)?'selected':''; ?>><?php echo $branch->name; ?></option>
										<?php }?>											
									</select>
									
									<div class="tooltips">
										<img src="<?php base_url();?>/images/help.png" class="tooltip_icon">
										<span>For bank users this field will be auto filled and non editable. For DRT user, they may select the name of the Organization whose asset is on auction.
										</span>
									</div>					
								</div>
							</div>
						<?php } ?>
						
					  <div class="seprator btmrg20"></div>
					  
					  <div class="row">
						<div class="lft_heading">Auction Type<span class="red"> *</span></div>
						<div class="rgt_detail">
							<span><label>Open</label>
							<input name="show_home" checked  <?php if($auctionData->show_home=='1') { echo $chk='checked';}else{echo $chk='';}?>  id="show_home" type="radio" value="1" class="radio_icon">
							</span> 
							<span><label>Limited User</label>
							<input name="show_home" <?php if($auctionData->show_home=='0') { echo $chk='checked';}else{echo $chk='';}?>  id="show_home1" type="radio" value="0" class="radio_icon">
							</span> 
							<!--<div class="tooltips">
								<img src="<?php base_url();?>/images/help.png" class="tooltip_icon">
								<span>During Bid Opening,if you want   Bid Opener(s) to view initial quote price submitted by  different Bidders.</span>
							  </div>-->
						</div>
					</div>    
					 
						
					  <div class="plain row">
						<div class="lft_heading">Show FRQ <span class="red">*</span></div>
						<div class="rgt_detail">
						  <label>Yes
						  

						  <input name="show_frq"  checked <?php if($auctionData->show_frq=='1') { echo $chk='checked';}else{echo $chk='';}?>  id="show_frq" class="radio_icon" type="radio" value="1"></label>
						  <label>No
						  <input name="show_frq"  <?php if($auctionData->show_frq=='0') { echo $chk='checked';}else{echo $chk='';}?>  id="show_frq1" class="radio_icon" type="radio" value="0">
						  </label>
                                                <div class="tooltips">
                                                <img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
                                                <span>During Bid Opening,if you want   Bid Opener(s) to view initial quote price submitted by  different Bidders</span>
						</div>
                                                </div>
                                                
					  </div>
					  
					   <?php if(false) { ?>
					  <div class="plain row">
						<div class="lft_heading">Is DSC Enabled <span class="red">*</span></div>
						<div class="rgt_detail">
                                                     <label>Yes</label>
                                                    <?php if($auctionData->dsc_enabled==1) {?>
                                                    <input name="dsc_enabled"  id="dsc_enabled" checked="checked" type="radio" value="1" class="radio_icon">
                                                  <?php  }else{ ?>
                                                     <input name="dsc_enabled"  id="dsc_enabled" type="radio" value="1" class="radio_icon"> 
                                                 <?php } ?>
                                                    </span> <span>
                                                    <label>No</label>
                                                    <?php if($auctionData->dsc_enabled==0) { ?>
                                                   <input name="dsc_enabled"  checked id="dsc_enabled1" checked="checked" type="radio" value="0" class="radio_icon">
                                                  <?php  }else{ ?>
                                                     <input name="dsc_enabled"   id="dsc_enabled1" type="radio" value="0" class="radio_icon">
                                                 <?php } ?>

                                                   <div class="tooltips">
                                                    <img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
                                                   <span> If you want auction to be public key infrastructure enabled.</span>
						</div>
						  </div>
					  </div>
					  <?php } ?>
                                          <div class="plain row">
						<div class="lft_heading">Auto Bid Cut Off</div>
						<div class="rgt_detail">
						  <label>Yes
						  <input name="auto_bid_cut_off" <?php if($auctionData->auto_bid_cut_off=='1') { echo $chk='checked';}else{echo $chk='';}?>  id="dsc_enabled" class="radio_icon" type="radio" value="1">
						  </label>
						  <label>No
						  <input name="auto_bid_cut_off" checked <?php if($auctionData->auto_bid_cut_off=='0') { echo $chk='checked';}else{echo $chk='';}?>  class="radio_icon" id="dsc_enabled1" type="radio" value="0">
						  </label>
                                                     <div class="tooltips">
                                                      <img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
                                                      <span>Auto bid enables the bidding process to proceed down or up in standard decrements or increments automatically</span>
                                                          
					             </div>
						  </div>
                                         </div>
			   
				           <div class="plain row">
						<div class="lft_heading">Price Bid <span class="red">*</span></div>
						<div class="rgt_detail">
						  <label>Applicable
						  <input name="price_bid"  <?php if($auctionData->price_bid_applicable=='applicable') { echo $chk='checked';}else{echo $chk='';}?> id="price_bid"class="radio_icon"  checked type="radio" value="applicable">
						  </label>
						  <label>Not Applicable
						  <input name="price_bid" <?php if($auctionData->price_bid_applicable=='not_applicable') { echo $chk='checked';}else{echo $chk='';}?> class="radio_icon" id="price_bid1"  type="radio" value="not_applicable">
						  </span>  <span class="help-icon" title="IF you are seeking the initial quote against reserve price then make this option ‘Applicable‘ else ‘Not Applicable‘"></label>
								<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>IF you are seeking the initial quote against reserve price then make this option ‘Applicable‘ else ‘Not Applicable‘</span>
								</div>
                                                  
							</div>
					  </div>
					  
					  
					  <input name="is_closed" value="0"  id="" type="hidden"  class="input">
					  
					  
					  
					  <dl class="plain" id="show_bidder" <?php if($auctionData->is_closed=='1') { echo $bchk='style="display:block;"';}else{echo $bchk='style="display:none;"';}?> >
						<dt class="required">
						  <label>Bidders</label>
						</dt>
						<dd> 
						<?php// print_r($closeBidderAuctionRows);?>
					<select name="bidders_list[]"  id="bidders_list"  class="select-text" multiple>
						   <option value="">Select Bidders</option>
						   <?php
						   
							
								foreach($biddersrow as $bidder_row){ 
								if(count($closeBidderAuctionRows)>0)
								{
									
									if(in_array($bidder_row->id,$closeBidderAuctionRows)){
										$docsel='selected';	
									}else{
										$docsel='';		
									}
								}
								
									
								?>
								<option <?php echo $docsel; ?> value="<?php echo  $bidder_row->id ; ?>" > <?php echo ucfirst($bidder_row->bidder_name); ?> (<?php echo ucfirst($bidder_row->email_id); ?>)</option>
							<?php } ?>
							
					</select>
								
						  <span class="help-icon" title="Close auction Bidders"></span>
						</dd>
					  </dl>
					  
					  <div class="row">
							<div class="lft_heading">Bid Increment value <span class="red">*</span></div>
							<div class="rgt_detail">
                                                                                <input name="bid_inc"  id="bid_inc" type="text" value="<?php if($auctionData->bid_inc!='0.00'){echo $auctionData->bid_inc; }; ?>"  class="input numericonly onlynumber">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>The value by which the bidding will increase at the time of Inter Se Bidding.</span>
										</div>
							</div>
						</div>
						
				  
					  <div class="row">
							<div class="lft_heading">Auto Extension time (In Minutes.)</div>
							<div class="rgt_detail">
										<input name="auto_extension_time" value="<?php if($auctionData->auto_extension_time!='0'){echo $auctionData->auto_extension_time; }; ?>" id="auto_extension_time" maxlength="2" type="text"  class="input numericonly">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Time in minutes by which the auction will get extended if bid is received in last minutes. E.g. Lets say Auction Start Time is 11:00 AM, End Time is 12:00 PM and Auto Extention time is 5 minutes. If a bid is recieved at 11:58 then the end time of the auction will be extended till 12:03 and the process will continue.</span>
										</div>
							</div>
						</div>
							  
					  <div class="row">
							<div class="lft_heading">Auto Extension(s)</div>
							<div class="rgt_detail">
										<input name="auto_extension" value="<?php if($auctionData->no_of_auto_extn!='0'){echo $auctionData->no_of_auto_extn; }; ?>" id="auto_extension" type="text" maxlength="2"  class="input numericonly_1">
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>The number of auto extensions may be restricted by this option. e.g if one wants to have auto extension only 3 times then write ‘3‘ in this field. For indefinite extensions please keep this field blank.</span>
										</div>
							</div>
						</div>
						
					  
					  <div class="row">
							<div class="lft_heading">Upload Related Documents <span class="red">*</span> </div>
							<div class="rgt_detail">
										<input name="related_doc"  id="related_doc" type="file"  class="input">
										<?php
										  if($auctionData->related_doc){?>
										   <input name="old_related_doc"  id="old_related_doc" value="<?php echo $auctionData->related_doc;?>" type="hidden"  class="input">
										   <a style="font-size: 10px;" download href="/public/uploads/event_auction/<?php echo $auctionData->related_doc;?>"> <?php echo $auctionData->related_doc;?></a>
										  <?php }else{ ?>
                                                                                    <input name="old_related_doc"  id="old_related_doc" value="" type="hidden"  class="input">
                                                                                  <?php }?>
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Please upload the related document by using browse button. The documents may be PoS, Sale Notice, T&C. if you have more than one document then please zip all those documents in a single file and then upload here.</span>
										</div>
							</div>
						</div>
						
					 <div class="row">
							<div class="lft_heading">Upload Images<span class="red"></span> </div>
							<div class="rgt_detail">
                                        <input name="image_new"  id="image" type="file"  class="input" accept="jpg,png,gif,jpeg">
										<?php
										  if($auctionData->image){ ?>
											 <input name="old_image"  id="old_image"  value="<?php echo $auctionData->image;?>" type="hidden"  class="input">
											<a style="font-size: 10px;" download href="/public/uploads/event_auction/<?php echo $auctionData->image;?>"><?php echo $auctionData->image?></a>	
										  <?php }else{ ?>
											<input name="old_image"  id="old_image"  value="" type="hidden"  class="input">       
										  <?php }?>
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>You may upload the images of asset under this option.</span>
										</div>
							</div>
						</div>
                                          <div class="row">
                                                <div class="lft_heading"> Check To Upload Special terms and conditions </div>
                                                <div class="rgt_detail">
                                                <input name="supporting_doc_check"  id="supporting_doc_check" type="checkbox" onclick="checksupportingdoc();" class="input">
                                                
                                                </div>
						</div>
                                          <div class="row">
							<div class="lft_heading"> Upload Special terms and conditions documents</div>
							<div class="rgt_detail">
                                                            <input name="supporting_doc"  id="supporting_doc" type="file" disabled="true" class="input">
										<?php  if($auctionData->supporting_doc){ ?>
                                                                                <input name="old_supporting_doc"  id="supporting_doc"  value="<?php echo $auctionData->supporting_doc;?>" type="hidden"  class="input">
                                                                                <a style="font-size: 10px;" download href="/public/uploads/event_auction/<?php echo $auctionData->supporting_doc;?>"><?php echo $auctionData->supporting_doc?></a>	
                                                                                <?php } ?>
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>Please upload  any special documents   related to auction  by using browse button.If you have more than one document then please zip all those documents in a single file and then upload here.</span>
										</div>
                                                                            </div>
                                                                    </div>
						<div class="row">
							<div class="lft_heading">Documents to be submitted<span class="red">*</span> </div>
							<div class="rgt_detail"><select multiple name="doc_to_be_submitted[]" id="doc_to_be_submitted" size="4" class="select-text">
											  <?php
											  if($auctionData->doc_to_be_submitted){
												  $docsubArr=explode(',',$auctionData->doc_to_be_submitted);
											  }
												foreach($document_list as $document){
												if(count($docsubArr)>0)
												{
													if(in_array($document->id,$docsubArr)){
														$docsel='selected';	
													}else{
														$docsel='';		
													}
												}
												?>
												<option <?php echo $docsel; ?> value="<?php echo $document->id; ?>"><?php echo $document->name; ?></option>
											<?php }?>
										  </select>
										<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
												<span>Please select the documents to be submitted by the bidder while sealed bid. You may select multiple options by keeping the CTRL key pressed and then selecting.</span>
										</div>
							</div>
						</div>
						
					 <?php if($drt_user != 'drt'){ ?>
						  <div class="row" id="div_second_opener">
								<div class="lft_heading">Second Opener</div>
								<div class="rgt_detail">
									<select name="second_opener" id="second_opener" class="select" >
									  <option value="">Select Second opener</option>
										 <?php
										 $totalUser= count($banksUsersList);
										  if($totalUser>0)
										  { 
												foreach($banksUsersList as $urow){
													if($auctionData->first_opener!=$urow->id){
														if( $urow->id!=$this->session->userdata['id']){?>                                                                                           
																<option value="<?php echo $urow->id;?>" <?php echo ($urow->id==$auctionData->second_opener)?'selected':''; ?>><?php echo $urow->email_id;?>, <?php echo $urow->user_id;?>, <?php echo ucfirst($urow->first_name);?>  <?php echo $urow->last_name;?></option>    
															<?php 
														} 
													} 
												}
										  
										  } ?>
									  </select>
									<div class="tooltips">
									<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
											<span>This is the higher authority. IF the event is SARFESI then he/she may be the Senior officer from the bank. If the event is DRT he/She may be the DRT recovery officer. The dropdown will contain the name of the user depending upon the account you have chosen from top.</span>
									</div>
								</div>
							</div>
						<?php } ?>
						<div id="div_second_opener" class="row">
							<div class="lft_heading">Status</div>
							<div class="rgt_detail">
										<select class="select" name="status" id="status">											
											<option value="1" <?php if($auctionData->status == 1){ echo 'selected="selected"';}?> >Published</option>
											<option value="3" <?php if($auctionData->status == 3){ echo 'selected="selected"';}?> >Stay</option>
											<option value="4" <?php if($auctionData->status == 4){ echo 'selected="selected"';}?> >Cancel</option>											
											<option value="6" <?php if($auctionData->status == 6){ echo 'selected="selected"';}?> >Completed</option>
											<option value="7" <?php if($auctionData->status == 7){ echo 'selected="selected"';}?> >Conclude</option>											
											<option value="5" <?php if($auctionData->status == 5){ echo 'selected="selected"';}?> >Error</option>
										</select>
							</div>
						</div>
						
						<div class="row">
							<div class="lft_heading">Publish Date</div>
							<div class="rgt_detail">
								<input name="indate" id="indate"  readonly value="<?php echo $auctionData->indate;?>" type="text"  class="input">								
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<!--<span>Date from when interested bidder may visit the property physically.</span>-->
								</div>
							</div>
						</div>
						
						<hr>
					  <div class="seprator btmrg20"></div>
					  
					  
						<div class="button-row row" style="text-align:center;">
						 <a href="/superadmin/corrigendum/" style="font-size:0; padding-right:5px;" class="b_submit button_grey">Back</a>                      
					         
						 <input name="Save" value="Save" onclick="return validateSubmitform('publish');" type="submit" class="b_submit button_grey float-right">						 
						 <!--<a href="/superadmin/corrigendum/searchevent/<?php echo $auctionID;?>?action=reset" style="font-size:0; padding-right:5px;" class="b_submit button_grey">
							 reset
						 </a>-->					 
						 
							
						 <input type="hidden" name="auctionID" id="auctionID" value="<?php echo $auctionID?>">
						 <input type="hidden" name="currdate" id="currdate" value="<?php echo date("Y-m-d H:i") ?>" />
						 <input type="hidden" name="productID" id="productID" value="<?php echo $productID; ?>">

						</div>
						<?php if($corrigendumid > 0){?>
							<?php if($auctionData->first_approver > 0){?>
								<div id="div_second_opener" class="row">
									<div class="lft_heading">First Approve<span class="red">*</span></div>
									<div class="rgt_detail">
										<select class="select" name="first_approve" id="first_approve">
											<option value="">Select</option>
											<?php foreach($approverFirstlist as $app){?>
												<option value="<?php echo $app->id;?>" <?php if($auctionData->first_approver_id == $app->id){ echo 'selected="selected"';}?>><?php echo ucfirst($app->first_name)." ".ucfirst($app->last_name);?></option>
											<?php } ?>
										</select>
										<!--<a href="">Send Mail</a>-->
									</div>
								</div>
							<?php } ?>
							<?php if($auctionData->second_approver > 0){?>
								<div id="div_second_opener" class="row">
									<div class="lft_heading">Second Approve<span class="red">*</span></div>
									<div class="rgt_detail">
										<select class="select" name="second_approve" id="second_approve">
											<option value="">Select</option>
											<?php foreach($approverlist as $app){?>
												<option value="<?php echo $app->id;?>" <?php if($auctionData->second_approver_id == $app->id){ echo 'selected="selected"';}?>><?php echo ucfirst($app->first_name)." ".ucfirst($app->last_name);?></option>
											<?php } ?>
										</select>
										<!--<a href="">Send Mail</a>-->
									</div>
								</div>
							<?php } ?>
							<?php if($auctionData->first_approver > 0 || $auctionData->second_approver > 0){?>
								<div class="row">
									<div class="lft_heading">Upload document for approval<span class="red"></span> </div>
									<div class="rgt_detail">
										<input name="upload_document_approval"  id="upload_document_approval" type="file"  class="input" accept="jpg,png,gif,jpeg">
										<?php if($auctionData->upload_document_approval != ''){?>										 											
											<a download href="public/uploads/event_auction/<?php echo $auctionData->upload_document_approval;?>">Download</a>
										 <?php } ?>
										 
									</div>
								</div>
							<?php } ?>	
							 <input onclick="return previewData();"  name="preview" value="Preview" type="submit" class="b_submit button_grey float-right" style="margin: 0 auto !important;width: 50px;display: block;clear: both;">
							 
					<?php } ?>
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
		  </div>
</section>

<style>
	img {
		height: auto;
		width: auto;
	}
</style>

<script>
function checksupportingdoc(){
        if (!$("#supporting_doc_check").is(':checked')) {
              $("#supporting_doc").attr('disabled',true); 
        }else{
               $("#supporting_doc").attr('disabled',false); 
        }
  }
 function previewData()
 {
	 var first_approve = $("#first_approve");
	 var second_approve = $("#second_approve");
	 
	 var error = false;
	 $('#spMsg').html('');
	 if(typeof first_approve != 'undefined')
	 {
		if(first_approve.val() == '')
		{
			error = true;
			$('#spMsg').append("<li>Please Select First Approver</li>");
		}
	 }
	 
	 if(typeof second_approve != 'undefined')
	 {
		if(second_approve.val() == '')
		{
			error = true;
			$('#spMsg').append("<li>Please Select Second Approver</li>");
		}
	 }
	 
	 if(error)
	 {
		$("#showerror_msg").show();
		$(".inline").colorbox({inline:true, width:"50%"});
		$(".inline").click();
		return false;
		
	 }
	 else
	 {
		return true;
	 }
	 
 }

//jQuery('#category').attr("value",'<?=$auctionData->category;?>');
//jQuery('#category').trigger("change");
setTimeout(function(){ 
    <?php
    if($auctionData->subcategory_id!=0&&$auctionData->subcategory_id!=''){$subcatrid=$auctionData->subcategory_id;}
    ?>
   jQuery('.id_100 option[value="<?=$subcatrid;?>"]').attr('selected','selected');

jQuery('#type').trigger("change");
}, 100);

 
        jQuery('#press_release_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		maxDate: 0,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00',
		yearRange: '1950:<?php echo date('Y')?>'
	});
	
	
  jQuery('#inspection_date_from').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	
	jQuery('#inspection_date_to').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#bid_last_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	  jQuery('#bid_opening_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	  jQuery('#auction_start_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#auction_end_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	
	jQuery('#indate').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',		
		timeFormat: 'HH:mm:00'
	});
	
		jQuery('#nodal_bank_n').change(function(){
		var nodal_bank_n = jQuery(this).val();
		if(nodal_bank_n)
		{
			jQuery('#nodal_bank_name').val(nodal_bank_n);
		}
	});	
	
	jQuery('#category_id').change(function(){
		var category_id = jQuery(this).val();
		if(category_id)
		{
			jQuery('#subcategory_id').load('/superadmin/corrigendum/getsubcategory/'+category_id);
		}
		
	});	
	jQuery('#invoice_mail_to').change(function(){
		/*var invoice_mail_to = jQuery(this).val();
		if(invoice_mail_to)
		{
			jQuery('#invoice_mailed').load('/banker/invoice_mail_to_user/'+invoice_mail_to);
		}*/
		var invoice_mail_to = jQuery(this).val();
		if(invoice_mail_to)
		{
			//jQuery('#invoice_mailed').
			jQuery( "#invoice_mailed option").removeAttr('disabled');
			jQuery( "#invoice_mailed option[value="+invoice_mail_to+"]").attr('disabled','disabled');
		}
		
	});	
	/*
	jQuery('.nodalbank').click(function(){
		var nodalbank = jQuery(this).val();
		if(nodalbank)
		{
			if(nodalbank=='others'){
				jQuery('#nodal_bank_n').prop( "disabled", false );	
			}else{
				var bank_id = jQuery("#bank_id").val();
				jQuery('#nodal_bank_name').val(bank_id);
				jQuery('#nodal_bank_n').prop( "disabled", true );			
			}
		}
		
	});	
	*/
		jQuery('.nodalbank').click(function(){
		var nodalbank = jQuery(this).val();
		var drt_event = jQuery("#drtEvent").val();
		if(nodalbank)
		{
			if(nodalbank=='others'){
				jQuery('#nodal_bank_n').prop( "disabled", false );	
			}else{
				if(drt_event)
				{
					var bank_id = jQuery("#bank_name").val();				
					samebankName = jQuery('#bank_name').html();					
				}
				else
				{
					var bank_id = jQuery("#bank_id").val();				
					samebankName = jQuery('#bank_name').html();
				}				
				jQuery('#nodal_bank_n').val(bank_id);
				jQuery('#nodal_bank_name').val(bank_id);
				jQuery('#nodal_bank_n').prop( "disabled", true );			
			}
		}
		
	});
	
  //tooltip
  jQuery(function($) { 
      // setTimeout(function(){
       //     $('#type').val('<?=$prows->product_subtype_id;?>');
	//    $('#type').trigger("change");
       //     },500);
       $('.alphanumeric1').bind('keypress', function (event) {
    
    var regex=new RegExp("^[,-./a-zA-Z0-9\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
   
  if (!regex.test(key)||key=='^'||key=='@'||key=='='||key=='<'||key=='>'||key=='?'||key==':'||key==' %'||key=='&'||key=='"') {
      //  
      if(!((event.keyCode >= 37 && event.keyCode <= 40&&event.keyCode == 53 && event.keyCode ==55 && event.keyCode ==222))){
        event.preventDefault();
        return false;
    }
   }
    
});
$('.numericonly').keypress(function(event) {
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
    ((event.which < 48 || event.which > 57) &&
      (event.which != 0 && event.which != 8))) {
    event.preventDefault();
  }

  var text = $(this).val();

  if ((text.indexOf('.') != -1) &&
    (text.substring(text.indexOf('.')).length > 2) &&
    (event.which != 0 && event.which != 8) &&
    ($(this)[0].selectionStart >= text.length - 2)) {
    event.preventDefault();
  }
});



$(".numericonly_1").keydown(function (e) { 
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    
 $('.alphanumeric2').bind('keypress', function (event) {
    
    var regex=new RegExp("^[a-zA-Z0-9\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
   
    if (!regex.test(key)||key=='^'||key=='@'||key=='='||key=='<'||key=='>'||key=='?'||key==':'||key==' %'||key=='&'||key=='"') {
      //  
      if(!((event.keyCode >= 37 && event.keyCode <= 40&&event.keyCode == 53 && event.keyCode ==55 && event.keyCode ==222))){
        event.preventDefault();
        return false;
    }
   }
    
});
        //$("#state_id").attr("value","<?=$auctionData->city?>");
        //$("#city_id").attr("value","<?=$auctionData->state?>");
    jQuery('#country_id').change(function(){
		var country_id = jQuery(this).val();
		if(country_id )
		{
			var state_id = jQuery('#state_id').val();
			jQuery('#state_id').load('/superadmin/corrigendum/getStateDropDown/'+country_id+'/'+state_id);
		}
		
	});	
	jQuery('#state_id').change(function(){
		var state_id = jQuery(this).val();
		if(state_id )
		{      $("#city_id").attr('disabled',false);
			var city_id = jQuery('#city_id').val();
			jQuery('#city_id').load('/superadmin/corrigendum/getCityDropDown/'+state_id+'/'+city_id);
		}
                 });  
        jQuery('#city_id').change(function(){
             var city_id = jQuery(this).val();
             if(city_id )
             {
                     var city_id = jQuery('#city_id').val();
                     if(city_id=='others'){
                    ///  $("#city_id").attr('disabled',true);
                      $("#text_city_id").show();  
                     }else{
                      $("#text_city_id").hide();   
                     }
        }     

     }); 
     
     jQuery(".onlynumber").on("keypress",function(evt){
		var keycode = evt.charCode || evt.keyCode;			
		  if (keycode  == 46) {
			return false;
		  }
	 });
        
	jQuery(".onlynumber").on("keyup",function(evt){	
	  var val = jQuery(this).val();
	  if(val.indexOf(".") > -1)
	  {
		val = val.split(".");			  
		jQuery(this).val(val[0]);		  
	  }
		 
	});  
      
    //jQuery('.help-icon').tooltip();
  });
  
	var specialKeys = new Array();
	specialKeys.push(8); //Backspace
	specialKeys.push(9); //Tab
	specialKeys.push(46); //Delete
	specialKeys.push(36); //Home
	specialKeys.push(35); //End
	specialKeys.push(37); //Left
	specialKeys.push(39); //Right
	function IsAlphaNumeric(e) {
		var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
		var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
		document.getElementById("error").style.display = ret ? "none" : "inline";
		return ret;
	}
     
</script>
