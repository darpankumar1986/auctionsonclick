<style>
#spMsg {padding:15px 0 0 0;}
#spMsg  li{font-size:13px; color:#F00; padding:0 5px; line-height:30px; margin-bottom:1px; background:#ffd8db;}
.errDiv{color:#ff0000;font-size:12px;width: 50%;}
.tooltips {
    z-index: 0;
}

.swal2-container{z-index: 9999 !important;}
</style>

<?php

$productID	=	$prows->id;
$drt_user = $this->session->userdata('user_type');
if($drt_user != 'drt')
{
	$bank_id	=	$this->session->userdata['bank_id'];
}

$drt_id	=	$erows->drt_id;

$eventid='';
$city=$auctionData->city;
$state=$auctionData->state;
$country=$auctionData->countryID;
$other_city=$auctionData->other_city;

?>
<!--<script  type="text/javascript" src="<?php echo base_url(); ?>js/texteditor/ckeditor.js"></script> -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBULmzbAb2RGK6kViBw6cgjbyecvfNKIDQ"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url()?>css/colorbox.css" />
<script src="<?php echo base_url()?>js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">

<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>


<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>


  <?php //echo $breadcrumb;?>

	 <section class="body_main1">
		  <div class="row ">
			<div class="wrapper-full">
			  <div class="dashboard-wrapper">
			   <?php /* ?>
				<div class="search-row">
				  <div class="srch_wrp">
					<input type="text" value="Search" id="search" name="search">
					<span class="ser_icon"></span> </div>
				  <a href="#">Advance Search+</a> </div>
				  <?php */ ?>
				<div id="tab-pannel3" class="btmrgn">
				  <div class="tab_container3">
					
					
					<!-- #tab1 -->
					<div id="tab6" class="tab_content3">
					  <div class="container">
						<?php echo $leftPanel?>
						<div class="secttion-right">
						  <div class="table-wrapper btmrg20">
							<div class="table-heading btmrg">
							  <div class="box-head no_cursor">Create Auction</div>
							</div>
							<div class="table-section">
				<?php 
					$formAction = '/admin/home/saveeventdata/'.$auctionID;
				?>	
				  <form method="post" enctype="multipart/form-data" name="createauction" id="createauction" action="<?php echo $formAction; ?>">
				  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				  <input type="hidden" name="dartEvent" id="drtEvent" value="<?php if($drt_user == 'drt'){ echo '1'; }else{ echo '0'; };?>" />
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
						<input type="hidden" value="<?php if($utype =='approver') echo $userID;?>" name="second_opener"/> <!--Added by aziz -->
					  <div class="plain row">
						  <div class="lft_heading">Bank Name<span class="red">*</span></div>

						<div class="rgt_detail">
							<select name="bank_id" id="bank_id"  class="select">
								<option value="">---Select---</option>
								<?php 
								foreach($banks as $bank_record){ ?>
									<option value="<?php echo $bank_record->id; ?>" <?php echo ($bank_record->id==$auctionData->bank_id)?'selected':''; ?>><?php echo $bank_record->name; ?></option>
								<?php }?>
							</select>
						<!--	
						  <select name="account"  id="account"  class="select">
							<option value="">---Select---</option>
							<?php
							/*	foreach($accountType as $account_record){ ?>
								<option value="<?php echo $account_record->account_id; ?>" <?php echo ($account_record->account_id==$auctionData->account_type_id)?'selected':''; ?>><?php echo $account_record->account_name; ?></option>
								<?php }
								 */?>
						  </select>	-->
						  
									<div class="tooltips">
									<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>The <?php echo BRAND_NAME; ?>  platform is made for these events. Please select the option accordingly.</span>
								</div>
						 </div>
					  </div>
					  
					  <div class="row">
								<div class="lft_heading">Branch <span class="red"> *</span></div>
								<div class="rgt_detail">					
									<select name="branch_id" id="branch_id"  class="select">
										<option value="">---Select---</option>
										<?php //bankbranch
										foreach($bankbranch as $branch){ ?>
											<option value="<?php echo $branch->id; ?>" <?php echo ($branch->id== $auctionData->branch_id)?'selected':''; ?>><?php echo $branch->name; ?></option>
										<?php }?>											
									</select>
									
									<div class="tooltips">
										<img src="<?php base_url();?>/images/help.png" class="tooltip_icon">
										<span>Please select branch.
										</span>
									</div>					
								</div>
							</div>
					  
					   <div class="row">
						<div class="lft_heading">Auction Type <span class="red">*</span></div>
						<div class="rgt_detail">
						  <select class="select" name="event_type" id="event_type">
							<option value="sarfaesi" <?php echo ($auctionData->event_type=='sarfaesi' || $auctionData->event_type=='')?'selected="selected"':''; ?> >Sarfaesi Auction</option>
							<option value="liquidation" <?php echo ($auctionData->event_type=='liquidation')?'selected="selected"':''; ?> >Liquidation Auction</option>
							<option value="government" <?php echo ($auctionData->event_type=='government')?'selected="selected"':''; ?> >Government Auction</option>
							<option value="drt" <?php echo ($auctionData->event_type=='drt')?'selected="selected"':''; ?> >DRT Auction</option>
							<option value="NPA Asset Sale" <?php echo ($auctionData->event_type=='NPA Asset Sale')?'selected="selected"':''; ?> >NPA Asset Sale Auction</option>
							<option value="Performing Asset Sale" <?php echo ($auctionData->event_type=='Performing Asset Sale')?'selected="selected"':''; ?> >Performing Asset Sale Auction</option>
							<option value="SFC" <?php echo ($auctionData->event_type=='SFC')?'selected="selected"':''; ?> >SFC Auction</option>
							<option value="other" <?php echo ($auctionData->event_type=='other')?'selected="selected"':''; ?> >Other Auction</option>			
							</select>

						  <div class="tooltips">
							<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
							<span>You may choose the most suitable Auction Type.</span>
							</div>
						</div>
					  </div>

					  <div class="row">
						<div class="lft_heading">Assets Category <span class="red">*</span></div>
						<div class="rgt_detail">
						  <select class="select" name="category_id" id="category_id">
							<option value="">---Select---</option>
							<?php
							foreach($category as $category_record){ ?>
							<option value="<?php echo $category_record->id; ?>" <?php echo ($category_record->id==$auctionData->category_id)?'selected="selected"':''; ?>><?php echo $category_record->name; ?></option>
							<?php }?>
							</select>

						  <div class="tooltips">
							<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
							<span>You may choose the most suitable Auction Category.</span>
							</div>
						</div>
					  </div>
					  
					  <div class="row" id="subCategoryType" <?php //if($auctionData->category_id==1 || $auctionData->category_id==2){ echo 'style="display:block;"';} else{echo 'style="display:none;"';}?>>
							<div class="lft_heading">Assets Type <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select name="sub_category_id" id="sub_category_id" class="select">
								  <option value="">---Select---</option>
										<?php
										foreach($sub_category as $subcat_record){ ?>
										<option value="<?php echo $subcat_record->id; ?>" <?php echo ($subcat_record->id==$auctionData->subcategory_id)?'selected="selected"':''; ?>><?php echo $subcat_record->name; ?></option>
										<?php }?>
								  </select>
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>Assets are divided into categories. Please select the sub category of the asset from the dropdown.</span>
								</div>
							</div>
						</div>
					  <div class="row">
							<div class="lft_heading">Contact Details <span class="red">*</span></div>
							<div class="rgt_detail">							
							<textarea id="contact_person_details_1" name="contact_person_details_1" ><?php echo $auctionData->contact_person_details_1; ?></textarea>
							<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>Contact Person Details</span>
							</div>
							</div>
						</div>	
					  <div class="row">
						<div class="lft_heading">Description <span class="red"> *</span></div>
						<div class="rgt_detail">
							 <textarea maxlength="100" name="description" id="description" type="text"  class="input html_found"><?php echo $auctionData->PropertyDescription;?></textarea>
						  <!-- <input maxlength="8000" name="description" id="description" value="<?php //echo @$prows->product_description; ?>" type="text" class="input">-->
						   <div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>Give a brief description of the asset on auction. E.g. In case of immovable asset the description can contain the size of the land/apartment, location and other attributes. In case of movable asset - the condition of machinery/vehicle etc.</span>
							</div>
						   </div>
					  </div> 
					  <div class="row">
						<div class="lft_heading">Asset Details <span class="red"> *</span></div>
						<div class="rgt_detail">
							<textarea name="asset_details" id="asset_details" type="text"  class="input html_found" rows="8" style="width:400px;"><?php echo $auctionData->asset_details;?></textarea>
							<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>Asset Details</span>
							</div>	
						</div>
					</div>
					  <div class="row">
							<div class="lft_heading">Borrower Name</div>
							<div class="rgt_detail">
								<input name="borrower_name" id="borrower_name" type="text" value="<?php echo $auctionData->borrower_name;?>"  class="input html_found">
								<div class="tooltips">
									<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>Please enter borrower name</span>
								</div>	
							</div>
						</div>
					 <div class="row">
							<div class="lft_heading">Location <span class="red">*</span></div>
							<div class="rgt_detail">
								<input name="reference_no" id="reference_no" type="text" value="<?php echo $auctionData->reference_no; echo isset($_POST['reference_no']) ? $_POST['reference_no'] : ''?>"  class="input alphanumeric html_found">
								<div class="tooltips">
									<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>Please enter location</span>
								</div>	
							</div>
						</div>					  
					  <!--
					  <div class="row">
							<div class="lft_heading">Auction Title <span class="red">*</span></div>
							<div class="rgt_detail">
								<input name="event_title"  max="500" id="event_title" type="text" value="<?php //echo $auctionData->event_title;?>"   class="input alphanumeric html_found">
								<div class="tooltips">
									<img src="<?php //echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>This will be the title of the event.e.g. Organization name vs Borrower Name or ‘e-Auction Sale notice for…’</span>
								</div>
							</div>
						</div> -->
					<!--<div class="row">
                                            <div class="lft_heading">Auction Reference Dispatch Date </div>
                                            <div class="rgt_detail">
                                                <input name="dispatch_date" id="dispatch_date"  value="<?php echo (($auctionData->dispatch_date != '1970-01-01 05:30:00') && ($auctionData->dispatch_date != '0000-00-00') && ($auctionData->dispatch_date != '')) ? date('d-m-Y', strtotime($auctionData->dispatch_date)): '';?>" type="text"  class="input" >
                                                <div class="tooltips">
                                                    <img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
                                                    <span>The date of the press release of sale notice in newspapers.</span>
                                                </div>
                                            </div>
                                        </div>-->
					
					<!--  <div class="row">
							<div class="lft_heading">Name of the Organization <span class="red"> *</span></div>
							<div class="rgt_detail">
								<?php $str = 'disabled="disabled"'; if($drt_user == 'drt'){$str = "";} ?>
								<select name="bank_name" <?php echo $str;?>  id="bank_name"  class="select" onchange="showBranch(this.value,'bank');">
								 
								
							  </select>
							   <input type="hidden" value="1" id="bank_id" name="bank_id" >
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>For bank users this field will be autofilled and non editable. For DRT user, they may select the name of the bank whose asset is on auction.</span>
								</div>
							</div>
						</div>
					 -->
					 
					  <div class="row">
							<div class="lft_heading">Country <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select name="country" id="country" class="select">
									<option value="">---Select---</option>
									<?php foreach ($countries as $country_record) { ?>
										<option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id == $auctionData->countryID) ? 'selected' : ''; ?>><?php echo $country_record->country_name; ?></option>
									<?php } ?>
								</select>
								<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>To submit  country name of the bidder. </span>
								</div>
								 
							</div>
						</div>
						<div class="row">
							<div class="lft_heading">State <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select  name="state" id="state" class="select">
									<option value="">---Select---</option>
									<?php foreach ($states as $state_record) { ?>
										<option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id == $auctionData->state) ? 'selected' : ''; ?>><?php echo $state_record->state_name; ?></option>
									<?php } ?>
								</select>
								 <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>To submit  state name of the bidder. </span>
								</div>
								
							</div>
						</div>
						<div class="row">
							<div class="lft_heading">City <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select name="city" id="city" class="select">
									<option value="" selected>---Select---</option>
								<?php foreach ($cities as $city_record) { ?>
										<option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id == $auctionData->city) ? 'selected' : ''; ?>><?php echo $city_record->city_name; ?></option>
									<?php } ?>
								</select>
								 <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>To submit  city  name of the bidder. </span>
								</div>
								
							</div>
						</div>
				 <!-- <div class="row">
						<div class="lft_heading">Plot Area </div>
						<div class="rgt_detail">
							<input name="property_height" id="property_height" type="text"  value="<?php echo $auctionData->property_height;?>"  class="">
							<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span></span>
							</div>	
						</div>
						</div>-->
						
					<!--<div class="row">
						<div class="lft_heading">Plot Area Unit </div>
						<div class="rgt_detail">
						  <select class="select" name="height_unit_id" id="height_unit_id">
							<option value="">Select</option>
								<?php									/*
								foreach($uomType as $ut){?>
									<option value="<?php echo $ut->uom_id; ?>" <?php echo ($ut->uom_id==$auctionData->height_unit_id)?'selected':''; ?>><?php echo $ut->uom_name; ?></option>
									<?php }
                                                                 */       
                                                                ?>
								
								<?php			
														
								foreach($heightUomType as $hut){?>
									<option value="<?php echo $hut->height_uom_id; ?>" <?php echo ($hut->height_uom_id==$auctionData->height_unit_id)?'selected':''; ?>><?php echo $hut->height_uom_name; ?></option>
									<?php } ?>
							</select>
						  <div class="tooltips">
							<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
							<span>Under each category, sub categories are defined. You may choose the most suitable sub category.</span>
							</div>
						</div>
					  </div>-->
						
					  
					   <!-- <div class="row">
							<div class="lft_heading">Carpet Area</div>
							<div class="rgt_detail">
								<input name="area" id="area" type="text" maxlength="13" value="<?php echo $auctionData->area;?>"  class="numericonly">
								<div class="tooltips">
									<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>This is the unique refrence number by which an event may be identified.</span>
								</div>	
								<div class="errDiv"><?php echo $this->session->userdata['flash:old:prarea'];?></div>
							</div>
						</div>-->
						
					 <!-- <div class="row">
						<div class="lft_heading">Carpet Area Unit</div>
						<div class="rgt_detail">
							<select class="select" name="area_unit_id" id="area_unit_id" onchange="setUnit();">
							<option value="">Select</option>
							<?php									
								foreach($uomType as $ut){?>
									
									<option value="<?php echo $ut->uom_id; ?>" <?php if($ut->uom_id==$auctionData->area_unit_id){ echo 'selected';} ?>><?php echo $ut->uom_name; ?></option>
										
							 <?php }?>
							</select>
						  <div class="tooltips">
							<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
							<span>Under each category, sub categories are defined. You may choose the most suitable sub category.</span>
							</div>
						</div>
					  </div>-->
					  
					   
					  <!--
					  <div class="row">
							<div class="lft_heading">Corner </div>
							<div class="rgt_detail">
								<input name="is_corner_property" id="is_corner_property" type="checkbox" value="1" <?php if($auctionData->is_corner_property==1) { echo 'checked';}else{echo '';}?> class="">
								<div class="tooltips">
									<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span> Please checked it if property is corner type.</span>
								</div>	
							</div>
						</div>-->
					<!-- <div class="row">
						<div class="lft_heading">Remark</div>
						<div class="rgt_detail">
							<textarea name="remark" id="remark" maxlength="500"><?php echo $auctionData->remark;?></textarea>
							<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>Please provide remarks if any.</span>
							</div>	
						</div>
					 </div>	-->				  
					  <hr>
					<!-- <div class="seprator btmrg20"></div>
                                         
                                         <div class="row">
						<div class="lft_heading">Scheme Id </div>
						<div class="rgt_detail">
							<input name="scheme_id" id="scheme_id" type="text" maxlength="20"  value="<?php echo $auctionData->scheme_id;?>">
							<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>This is the unique refrence number by which an event may be identified.</span>
							</div>	
						</div>
					</div>-->
                     <!--                    
					 
					
					<div class="row">
						<div class="lft_heading">Concerned Zone <span class="red"> *</span></div>
						<div class="rgt_detail">
						  <select class="select" name="zone_id" id="zone_id">
							<option value="">Select</option>
								<?php									
								foreach($zoneArr as $za){?>
									<option value="<?php echo $za->zone_id; ?>" <?php echo ($za->zone_id==$auctionData->zone_id)?'selected':''; ?>><?php echo $za->zone_name; ?></option>
									<?php }?>
							</select>
						  <div class="tooltips">
							<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
							<span>Select zone.</span>
							</div>
						</div>
					  </div>
					  
					  
					  
					  <div class="row">
						<div class="lft_heading">Max Coverage Area </div>
						<div class="rgt_detail">
							<input name="max_coverage_area" id="max_coverage_area" type="text"  value="<?php echo $auctionData->max_coverage_area;?>"  class="input alphanumeric html_found">
							<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>This is the unique refrence number by which an event may be identified.e.g. in case of DRT event it may be the R C Number</span>
							</div>	
						</div>
						</div>	-->
						
					  <div class="row">
							<div class="lft_heading">Reserve Price <span class="red">*</span></div>
							<div class="rgt_detail">
								 <input name="reserve_price" id="reserve_price" type="text" maxlength="13" value="<?php echo $auctionData->reserve_price;?>" class="input numericonly onlynumber">
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>It is the base price finalised by the valuer of MCG.</span>
								</div>
							  <div class="errDiv"><?php echo $this->session->userdata['flash:old:bsp'];?></div>
							</div>
						</div>
                       <!--                  
					   <div class="row">
						<div class="lft_heading">Reserve Price (Unit) <span class="red"> *</span></div>
						<div class="rgt_detail">
						<select class="select" name="unit_id_of_price" id="unit_id_of_price">
                                                        
							<option value="">Select</option>
                                                            <?php									
                                                            foreach($uomType as $ut){?>
								<option value="<?php echo $ut->uom_id; ?>" <?php echo ($ut->uom_id==$auctionData->unit_id_of_price)?'selected':''; ?>><?php echo $ut->uom_name; ?></option>
							<?php }?>
						</select>
						  <div class="tooltips">
							<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
							<span>Under each category, sub categories are defined. You may choose the most suitable sub category.</span>
							</div>
						</div>
					  </div>-->
					  
                                         
					  <div class="row">
							<div class="lft_heading">EMD Amount <span class="red">*</span></div>
							<div class="rgt_detail">
								<input name="emd_amt" id="emd_amt" type="text" maxlength="13"  class="input numericonly onlynumber" value="<?php echo $auctionData->emd_amt;?>">
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>Earnest money deposit.</span>
								</div>
																		
								<div id="emdWords" style="width:262px;margin-top: 3px;"></div>
								<div class="errDiv"><?php echo $this->session->userdata['flash:old:emda'];?></div>
										
										
							</div>
						</div>
					  
					  <!--<div class="row">
							<div class="lft_heading">Bank Processing Fee</div>
								<div class="rgt_detail">
									<input name="tender_fee" id="tender_fee" type="text" maxlength="13" class="input numericonly onlynumber numericonly_1" value="<?php echo ($auctionData->tender_fee != '')? $auctionData->tender_fee : BANK_PROCESSING_FEE;?>" readonly>
									<div class="tooltips">
									<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>This is bank processing fee payble by the bidder.</span>
								</div>
								<div class="errDiv"><?php echo $this->session->userdata['flash:old:parf'];?></div>
							</div>
						</div>-->
						
					<!--	
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
									<span>The bank name in which the interested bidder will remit the EMD/ tender fee through RTGS/ Challan.</span>
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
											<option value="<?php echo $bank_record->id; ?>" <?php echo ($bank_record->id==$bank_id1)?'selected':''; ?>><?php echo $bank_record->name; ?></option>
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
								<input  maxlength="20" name="nodal_bank_account"  id="nodal_bank_account" type="text" value="<?php echo $auctionData->nodal_bank_account;?>" onkeypress="return IsAlphaNumeric(event);" class="input alphanumeric2 html_found">
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
					  -->
					 <!-- 
					  <div class="row">
							<div class="lft_heading">Press Release Date<span class="red">*</span></div>
							<div class="rgt_detail">
								 <input name="press_release_date" id="press_release_date"  value="<?php echo (($auctionData->press_release_date != '1970-01-01 05:30:00') && ($auctionData->press_release_date != '' )) ? date('d-m-Y', strtotime($auctionData->press_release_date)): '';?>" type="text"  class="input" readonly >
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>The date of the press release of sale notice in newspapers.</span>
								</div>
								<div class="errDiv"><?php echo $this->session->userdata['flash:old:prd'];?></div>
							</div>
							
						</div>-->
                  <!--                       
				  <div class="row">
						<div class="lft_heading">Site Visit Start Date</div>
						<div class="rgt_detail">
							  <input <?php if(false && $auctionData->bid_last_date != '' && $auctionData->bid_last_date != '0000-00-00 00:00:00' && $auctionData->status != '2')echo 'disabled';?> name="inspection_date_from" id="inspection_date_from"  value="<?php echo (($auctionData->inspection_date_from != '1970-01-01 05:30:00') && ($auctionData->inspection_date_from != '') && ($auctionData->inspection_date_from != '0000-00-00 00:00:00')) ? date('d-m-Y H:i:s', strtotime($auctionData->inspection_date_from)): ''; ?>" type="text"  class="input" >
							   <?php if(false && $auctionData->bid_last_date != ''  && $auctionData->bid_last_date != '0000-00-00 00:00:00' && $auctionData->status != '2'){?>
									<input name="inspection_date_from"  value="<?php echo date('d-m-Y H:i:s', strtotime($auctionData->inspection_date_from)); ?>"  type="hidden">
								<?php } ?>
							<div class="tooltips">
							<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>Date from when interested bidder may visit the property physically.</span>
							</div> 
							<div class="errDiv"><?php echo $this->session->userdata['flash:old:svsd'];?></div>
						</div>
						
					</div>-->
                                            
						<!--
					   <div class="row">
							<div class="lft_heading">Site Visit End Date</div>
							<div class="rgt_detail">
								<input <?php if( false && $auctionData->bid_last_date != ''  && $auctionData->bid_last_date != '0000-00-00 00:00:00' && $auctionData->status != '2')echo 'disabled';?> name="inspection_date_to"  value="<?php echo (($auctionData->inspection_date_to != '1970-01-01 05:30:00') && ($auctionData->inspection_date_to != '') && ($auctionData->inspection_date_to != '0000-00-00 00:00:00')) ? date('d-m-Y H:i:s', strtotime($auctionData->inspection_date_to)): ''; ?>" id="inspection_date_to" type="text"  class="input">
								 <?php if(false && $auctionData->bid_last_date != ''  && $auctionData->bid_last_date != '0000-00-00 00:00:00' && $auctionData->status != '2'){?>
									<input name="inspection_date_to"  value="<?php echo date('d-m-Y H:i:s', strtotime($auctionData->inspection_date_to)); ?>"  type="hidden">
								<?php } ?>
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>Date till when interested bidder may visit the property physically.</span>
								</div>
								<div class="errDiv"><?php echo $this->session->userdata['flash:old:sved'];?></div>
							</div>
							
						</div>-->
						
						<!--
						<div class="row">
							<div class="lft_heading">Apply And EMD Start Date<span class="red">*</span></div>
							<div class="rgt_detail">
							 <input name="registration_start_date" value="<?php echo (($auctionData->registration_start_date != '1970-01-01 05:30:00') && ($auctionData->registration_start_date != '')) ? date('d-m-Y H:i:s', strtotime($auctionData->registration_start_date)):'';?>" id="registration_start_date" type="text"  class="input" readonly >
							<div class="tooltips">
							<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
							<span>Date and time from which the Registration will be started.</span>
							</div>
							<div class="errDiv"><?php echo $this->session->userdata['flash:old:aesd'];?></div>
							</div>
							
						</div>-->
                                              
						<!--
						<div class="row">
							<div class="lft_heading">Registration End date<span class="red">*</span></div>
							<div class="rgt_detail">
							 <input name="registration_end_date" value="<?php echo ($auctionData->registration_end_date != '1970-01-01 05:30:00') ? $auctionData->registration_end_date:'';?>"  id="registration_end_date" type="text"  class="input">
							<div class="tooltips">
							<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>Scheduled date and time to end the Registration</span>
							</div>
						</div>
						</div>	-->
						
						<div class="row">
							<div class="lft_heading">EMD Submission Last Date<span class="red">*</span></div>
							<div class="rgt_detail">
								<input name="bid_last_date"  value="<?php echo (($auctionData->bid_last_date != '1970-01-01 05:30:00') && ($auctionData->bid_last_date != '')) ? date('d-m-Y H:i:s', strtotime($auctionData->bid_last_date)): '';?>" id="bid_last_date" type="text"  class="input" readonly >
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>Date till when the interested bidder may submit the EMD/Required Documents/Quote the initial price</span>
								</div>
								<div class="errDiv"><?php echo $this->session->userdata['flash:old:aeed'];?></div>
							</div>
							
						</div>
						<!--	
						<div class="row">
							<div class="lft_heading">Shortlisting Start Date<span class="red">*</span></div>
							<div class="rgt_detail">
								<input name="bid_opening_date"  value="<?php //echo (($auctionData->bid_opening_date != '1970-01-01 05:30:00') && ($auctionData->bid_opening_date != '')) ? date('d-m-Y H:i:s', strtotime($auctionData->bid_opening_date)): '';?>" id="bid_opening_date" type="text"  class="input">
								<div class="tooltips">
								<img src="<?php //echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>Date of the opening of the recieved sealed bid from bidders. After opening the bank official will verify the EMD and documents submitted by the bidder.</span>
								</div>
							</div>
						</div>
						-->
					  <div class="row">
							<div class="lft_heading">Auction Start date<span class="red">*</span></div>
							<div class="rgt_detail">
							 <input name="auction_start_date" value="<?php echo (($auctionData->auction_start_date != '1970-01-01 05:30:00') && ($auctionData->auction_start_date != '')) ? date('d-m-Y H:i:s', strtotime($auctionData->auction_start_date)): '';?>" id="auction_start_date" type="text"  class="input" readonly >
							<div class="tooltips">
							<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>Date and time from which the auction will be started.</span>
							</div>
							<div class="errDiv"><?php echo $this->session->userdata['flash:old:asdt'];?></div>
							</div>
							
						</div>
						
						<div class="row">
							<div class="lft_heading">Auction End date<span class="red">*</span></div>
							<div class="rgt_detail">
								<input name="auction_end_date" value="<?php echo (($auctionData->auction_end_date != '1970-01-01 05:30:00') && $auctionData->auction_end_date != '') ? date('d-m-Y H:i:s', strtotime($auctionData->auction_end_date)): '';?>"  id="auction_end_date" type="text"  class="input" readonly>
							<div class="tooltips">
							<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>Scheduled date and time to end the auction</span>
							</div>
							<div class="errDiv"><?php echo $this->session->userdata['flash:old:aedt'];?></div>
						</div>
						
						</div>
						<!--
						<div class="row">
							<div class="lft_heading">Mode of Bid<span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="mode_of_bid">
								<option value="online" <?php if($auctionData->mode_of_bid=='online')echo 'selected';?>>Online</option>
								<option value="offline" <?php if($auctionData->mode_of_bid=='offline')echo 'selected';?>>Offline</option>
							</select>
							</div>	
						</div>	-->
						
						<hr>
						
					  <div class="seprator btmrg20"></div>
					 
						
					  <div class="plain row" style="display:none;">
						<div class="lft_heading">Show FRQ <span class="red">*</span></div>
						<div class="rgt_detail">
						  <label>Yes
						  

						  <input name="show_frq"  checked <?php if($auctionData->show_frq=='1') { echo $chk='checked';}else{echo $chk='';}?>  id="show_frq" class="radio_icon" type="radio" value="1"></label>
						  <label>No
						  <input name="show_frq"  <?php if($auctionData->show_frq=='0' || true) { echo $chk='checked';}else{echo $chk='';}?>  id="show_frq1" class="radio_icon" type="radio" value="0">
						  </label>
							<div class="tooltips">
							<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
							<span>During Bid Opening,if you want   Bid Opener(s) to view initial quote price submitted by  different Bidders</span>
						</div>
						</div>
                                                
					  </div>
					  
					  <!--
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
					  </div>-->
					  <!--<div class="plain row">
						<div class="lft_heading">Auto Bid Allow</div>
						<div class="rgt_detail">
						  <label>Yes
						  <input name="auto_bid_cut_off"  id="dsc_enabled" class="radio_icon" type="radio" value="1">
						  </label>
						  <label>No
						  <input name="auto_bid_cut_off" class="radio_icon" id="dsc_enabled1" type="radio" value="0" checked='checked'>
						  </label>
								 <div class="tooltips">
									  <img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									  <span>Auto bid enables the bidding process to proceed down or up in standard decrements or increments automatically</span>
                                                          
					             </div>
						  </div>
						 </div>-->
			                 
				           <div class="plain row" style="display:none;">
						<div class="lft_heading">Price Bid <span class="red">*</span></div>
						<div class="rgt_detail">
						  <label>Applicable
						  <input name="price_bid"  <?php if($auctionData->price_bid_applicable=='applicable') { echo $chk='checked';}else{echo $chk='';}?> id="price_bid"class="radio_icon"  checked type="radio" value="applicable">
						  </label>
						  <label>Not Applicable
						  <input name="price_bid" <?php if($auctionData->price_bid_applicable=='not_applicable' || true) { echo $chk='checked';}else{echo $chk='';}?> class="radio_icon" id="price_bid1"  type="radio" value="not_applicable">
						  </span>  <span class="help-icon" title="IF you are seeking the initial quote against reserve price then make this option ‘Applicable‘ else ‘Not Applicable‘"></label>
								<div class="tooltips">
										<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>IF you are seeking the initial quote against reserve price then make this option ‘Applicable‘ else ‘Not Applicable‘</span>
								</div>
                                                  
							</div>
					  </div>
					  
					  
					  <input name="is_closed" value="0"  id="" type="hidden"  class="input">
					  
					  
					  
					 
					  <!--
					  <div class="row">
							<div class="lft_heading">Bid Increment value <span class="red">*</span></div>
							<div class="rgt_detail">
								<input name="bid_inc"  id="bid_inc" type="text" value="<?php if($auctionData->bid_inc!='0.00'){echo $auctionData->bid_inc; }; ?>"  class="input numericonly onlynumber numericonly_1">
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>The value by which the bidding will increase at the time of Inter Se Bidding.</span>
								</div>
                                                                <div class="errDiv"><?php echo $this->session->userdata['flash:old:bicv'];?></div>
							</div>
						</div>-->
					  <!--
					  <div class="row">
							<div class="lft_heading">Auto Extension time (In Minutes.)<span class="red"> *</span></div>
							<div class="rgt_detail">
								<input name="auto_extension_time" value="<?php echo $auctionData->auto_extension_time; ?>" id="auto_extension_time" maxlength="2" type="text"  class="input numericonly">
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>Time in minutes by which the auction will get extended if bid is received in last minutes. E.g. Lets say Auction Start Time is 11:00 AM, End Time is 12:00 PM and Auto Extention time is 5 minutes. If a bid is recieved at 11:58 then the end time of the auction will be extended till 12:03 and the process will continue.</span>
								</div>
								<div class="errDiv"><?php echo $this->session->userdata['flash:old:aetm'];?></div>
							</div>
						</div>
						
					  
					  <div class="row">
							<div class="lft_heading">Auto Extension(s)</div>
							<div class="rgt_detail">
								<input name="auto_extension" value="<?php echo $auctionData->no_of_auto_extn; ?>" id="auto_extension" type="text" maxlength="2"  class="input numericonly_1">
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>The number of auto extensions may be restricted by this option. e.g if one wants to have auto extension only 3 times then write ‘3‘ in this field. For indefinite extensions please keep this field blank.</span>
								</div>
							</div>
						</div>
						-->
						
						<div class="row">
							<div class="lft_heading">Property Latitude</div>
							<div class="rgt_detail">
                            <input name="latitude"  id="latitude" type="text" value="<?php if($auctionData->latitude!=''){echo $auctionData->latitude; }; ?>"  >
							<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
									<span>Property Latitude</span>
							</div>
							</div>
						</div>
						
						<div class="row">
							<div class="lft_heading">Property Longitude</div>
							<div class="rgt_detail">
                            <input name="longitude"  id="longitude" type="text" value="<?php if($auctionData->longitude!=''){echo $auctionData->longitude; }; ?>" >
								<div class="tooltips">
									<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>Property Longitude</span>
										<input class="button_grey" id="btnShow" type="button" value="Get Location">
								</div>
							</div>							
						</div>
						
						
					<!--	
					<div class="row">
							<div class="lft_heading">2nd Contact Person Details</div>
							<div class="rgt_detail">
							<textarea id="contact_person_details_2" name="contact_person_details_2" ><?php echo $auctionData->contact_person_details_2; ?></textarea>
							<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>The number of auto extensions may be restricted by this option. e.g if one wants to have auto extension only 3 times then write ‘3‘ in this field. For indefinite extensions please keep this field blank.</span>
							</div>
							</div>
						</div>
					-->	
					<div class="row">
						<div class="lft_heading">E-Auction Provider</div>
						<div class="rgt_detail">
							<input name="service_no" id="service_no" type="text"  value="<?php echo $auctionData->service_no;?>"  class="input html_found">
							<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>E-Auction Provider</span>
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="lft_heading">E-Auction Website </div>
						<div class="rgt_detail">
							<input name="far" id="far" type="text"  value="<?php echo $auctionData->far;?>"  class="input html_found">
							<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>E-Auction Website</span>
							</div>	
						</div>
					</div>
<?php 
    if(is_array($upload_document_field) && count($upload_document_field)>0 )
        { 
            foreach($upload_document_field as $key => $udf)
                {
                    $var = true;	
            ?>
        <div class="row">
        <div class="lft_heading"><?php echo $udf->upload_document_field_name; ?> <?php if($udf->isMandatory == 1){ ?><span class="red">*</span><?php } ?> </div>	
        <?php $fieldName = strtolower(str_replace(' ','_',$udf->upload_document_field_name)); ?>							
        <div class="rgt_detail">
        <input name="<?php echo $fieldName; ?>"  id="<?php echo $fieldName; ?>" type="file"  class="<?php if($udf->upload_document_field_type == 1){ echo 'imageType'; } else { echo 'videoType'; } ?> input <?php if($udf->isMandatory == 1){ echo 'fileRq';}?>">
    <?php
    foreach($uploadedDocs as $ud)
        {

        if($ud->upload_document_field_id == $udf->upload_document_field_id){ 
            $var = false;
        ?>
        <input name="old_<?php echo $fieldName?>"  id="old_<?php echo $fieldName?>"  value="<?php echo $ud->file_path;?>" type="hidden"  class="input">
        <?php if($udf->upload_document_field_type == 1 && $ud->upload_document_field_name != 'Upload Sale Notice '){ ?>
           <a href="/public/uploads/event_auction/<?php echo $ud->file_path;?>" target="_blank">View</a>	
           <?php }else if($ud->upload_document_field_name != 'Upload Sale Notice '){?>
                <a href="/public/uploads/event_auction/<?php echo $ud->file_path;?>" target="_blank">View</a>	
            <?php }else{?>
				<a href="<?php echo $ud->file_path;?>" target="_blank">View</a>
			<?php } ?>
        <?php } ?>
       <?php }?>

        <?php if($var){ ?>
        <input name="old_<?php echo $fieldName?>"  id="old_<?php echo $fieldName?>"  value="" type="hidden"  class="input old">
        <?php }?>

        <div class="tooltips">
        <img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
         <span>You may <?php echo strtolower($udf->upload_document_field_name); ?> of asset under this option.</span>
    </div>
    </div>
    </div> 
<?php 

    } 								
 }
?>	
						<?php 

						 //random key for property images
						 $pirandomkey = rand(100000,999999);
						?>	
						<fieldset Name="Property Photographs" class="customFields" style="border:1px solid #999999;width:80%;margin-left:64px">
							<legend style="color: #0da3e2;">Property Photographs</legend>
							<div class="row">
								<div class="lft_heading">Upload Property Photographs </div>
								<div class="rgt_detail">								
									<input type="file" name="upload_property_photo[<?php echo $pirandomkey; ?>]" class="upload_property_photo" value="" />
									<div class="tooltips">
										<img src="<?php echo base_url(); ?>images/help.png" class="tooltip_icon">
										<span>Upload Property Photographs</span>
									</div>																	
								</div>
							</div>	
							<div class="row">
								<div class="lft_heading">Photographs Caption </div>
								<div class="rgt_detail" style="position: relative;">																
									<textarea name="photo_caption[<?php echo $pirandomkey; ?>]" type="text"  class="input"></textarea>									
									<div class="tooltips">
										<img src="<?php echo base_url(); ?>images/help.png" class="tooltip_icon">
										<span>Photographs Caption</span>
									</div>																
									<a href="javascript:void(0);" class="addMem" style="position: absolute;top:-14px;margin-left:15px"><image src="<?php echo base_url()?>bankeauc/images/add_new.png" alt="Add" title="Add New Row" width="17px" height="17px" style="display: inline-block !important; width:17px !important;" /></a>
								</div>
								<?php 
								foreach($uploadedDocs as $upd)
								{
									if($upd->upload_document_field_id==0 && $upd->status==1)
									{
										$viewPropertyPhoto = true;
									}
								}
								if($viewPropertyPhoto)
								{
								?>
									<div class="row" style="text-align:center; cursor:pointer; color:#00F;  font-size:12px;"><a href="#inline_content_photos" class="grn-txt float-right b_showevent inline_auctiondetail" style="text-decoration:none;">View Property Photos</a></div>
								<?php 
								} ?>
							</div>
						</fieldset>
						<!--<div class="row">
							<div class="lft_heading">Sales Person Details</div>
							<div class="rgt_detail">
								<div id="sales_person"><?php echo $sales_person_detail; ?></div>	 
							</div>
						</div>-->
						<!--					
						<div class="row">
							<div class="lft_heading">Any Documents Pertinent To The Auction<span class="red">*</span> </div>
                                                        <div  class="rgt_detail"><select name="doc_to_be_submitted[]" id="doc_to_be_submitted" size="4" class="select-text" multiple="multiple">
											<option  value="0" <?php if($auctionData->doc_to_be_submitted == 0) { echo 'selected' ;} ?> id="select_none_id">None</option>
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
						</div>-->
						<?php if($this->session->userdata('role_id')==1) 
						{ ?>
						<div class="row">
							<div class="lft_heading">Number of Copies </div>
							<div class="rgt_detail">
								<input name="copy_count" value="" id="copy_count" maxlength="3" type="text"  class="input numericonly" <?php if($auctionData->approvalStatus !=null) {}else{echo 'disabled="disabled"';}?> >
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>images/help.png" class="tooltip_icon">
										<span>Mulitiple copies of the auction can be created after saving a draft of the auction. If you don't want to create copies, please keep this field blank.</span>
								 <input name="create_copy" value="Create Copies" onclick="return validateSubmitform('copy');" type="submit" class="b_submit button_grey float-right" style="margin-top:-7px;" <?php if($auctionData->approvalStatus !=null) {}else{echo 'disabled="disabled"';}?>> <!---->								 
								</div>								
							</div>
						</div>						
						<?php } ?>
						<script>
							/*jQuery('#doc_to_be_submitted').change(function(){
									if(jQuery("#doc_to_be_submitted option:selected").val() == 0){
										('option:selected', jQuery("#doc_to_be_submitted")).removeAttr("multiple");
									}else {
										('option:selected',jQuery("#doc_to_be_submitted")).attr("multiple", "multiple");
									}
								});*/
                                                                
                                                                jQuery('#doc_to_be_submitted').change(function(){
									if(jQuery("#doc_to_be_submitted option:selected").val() == 0){
										jQuery("#doc_to_be_submitted").prop("multiple", "");
                                                                                
									}else {
										jQuery("#doc_to_be_submitted").prop("multiple", "multiple");
                                                                                //jQuery("#doc_to_be_submitted").multiselect("refresh");
									}
								});
                                              </script>  
						
										
					  <?php 
                                        
                                          
                                          
					  /*
					  if($drt_user != 'drt' ||)
						{
						?>
					  <div class="row" id="div_second_opener">
							<div class="lft_heading">Auction Approvers <span class="red">*</span></div>
							<div class="rgt_detail">
								<select name="second_opener" id="second_opener" class="select" >
								  <option value="">Select Approvers</option>
								  <?php if(is_array($approverArr) && count($approverArr)>0) { 
									  foreach($approverArr as $approver) {
								  ?>
									  <option value="<?php echo $approver->id; ?>" <?php if($approver->id == $auctionData->second_opener){echo 'selected';}?>><?php echo $approver->email_id; ?></option>
								  <?php } }?>
									 <?php
									 /*
									 $totalUser= count($banksUsersSecondOpener);
									  if($totalUser>0)
									  { 
										foreach($banksUsersSecondOpener as $urow){
											if($auctionData->first_opener!=$urow->id){
												 if( $urow->id!=$this->session->userdata['id']){
																					 ?>
																				   
										<option value="<?php echo $urow->id;?>" <?php echo ($urow->id==$auctionData->second_opener)?'selected':''; ?>><?php echo $urow->email_id;?>, <?php echo $urow->user_id;?>, <?php echo ucfirst($urow->first_name);?>  <?php echo $urow->last_name;?></option>    
																						<?php } } }
									  
									  }
									  */  /*?>
								  </select>
								<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
										<span>This is the higher authority. IF the event is SARFESI then he/she may be the Senior officer from the bank. If the event is DRT he/She may be the DRT recovery officer. The dropdown will contain the name of the user depending upon the account you have chosen from top.</span>
								</div>
							</div>
						</div>
						<?php 
						}
						*/
						 ?>
						
						<!--
                        <div class="row">
						<div class="lft_heading">Remark</div>
						<div class="rgt_detail">
							<textarea name="remark" id="remark" maxlength="500"><?php echo $auctionData->remark;?></textarea>
							<div class="tooltips">
								<img src="<?php echo base_url(); ?>/images/help.png" class="tooltip_icon">
								<span>Please provide remarks if any.</span>
							</div>	
						</div>
					 </div>-->
                                          
						<hr>
					  <div class="seprator btmrg20"></div>
					  
					  
						<div class="button-row row" style="text-align:center;">
						 <a href="/admin/home/savedEvents/" style="font-size:0; padding-right:5px;" class="b_submit button_grey">Cancel</a>
			             <!----> 						
						<input name="Save" value="Save As Draft" onclick="return validateSubmitform('save');" type="submit" class="b_submit button_grey float-right">						
						<input name="Publish" value="Publish"  onclick="return validateSubmitform('send4Approval');" type="submit" class="b_submit button_grey float-right">
						<input type="hidden" name="auctionID" id="auctionID" value="<?php echo $auctionID?>">
						<input type="hidden" name="currdate" id="currdate" value="<?php echo date("d/m/Y H:i:00"); ?>" />
						<input type="hidden" name="productID" id="productID" value="<?php echo $productID; ?>">

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
		  </div>
		  
		  <div class="row"  style="display:none;">
 <div id="inline_content_photos">
	 <?php        
		if(count($uploadedDocs)>0)
		{
	?>  
  <div class="heading4 btmrg20">Property Photographs</div>
  <table border="1" align="left" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
    <tbody role="alert">		      
        
        <tr class="odd">
            <th width="10%"><strong>Sr. No.</strong></th>
            <th width="25%"><strong>Photographs</strong></th>            
            <th width="60%"><strong>Photographs Caption</strong></th>
            <th width="5%"><strong>Action</strong></th>
        </tr>
       <?php
			$uSN=1;
			foreach($uploadedDocs as $ud)
			{
				
				if($ud->upload_document_field_id==0 && $ud->status==1)
				{
					$viewPropertyPhoto = true;
				
					?>
					<tr class="odd">
						<td align="left" style="vertical-align:top;"><?php echo $uSN; ?></td>
						<td align="left" style="vertical-align:top;"><img style="width:100px;" src="<?php echo base_url(); ?>public/uploads/event_auction/<?php echo $ud->file_path; ?>"/></td>            
						<td align="left" style="vertical-align:top;"><?php echo $ud->photo_caption; ?></td>
						<td align="left" style="vertical-align:top;"><image src="<?php echo base_url()?>bankeauc/images/delete.png"  style="cursor:pointer; display:inline-block; width:17px;"alt="Delete" title="Delete" onclick="removePorpertyPhotoData(<?php echo $ud->auction_document_id;?>)"/> <a href="javascript:void(0);" class="addMem"></td>
					</tr>
					<?php
					$uSN++;
				}	
			}
			
		
        ?> 
    
    </tbody>	 
	</table>
	
	</div>
	<?php
	}
        ?> 
  </div>
</section>
<div id="dialog" style="display: none">
<div id="dvMap" style="height: 380px; width: 580px;">

<script>

 jQuery(".inline_auctiondetail").colorbox({inline:true, width:"65%"});
/*	
function checksupportingdoc(){
        if (!jQuery("#supporting_doc_check").is(':checked')) {
              jQuery("#supporting_doc").attr('disabled',true); 
        }else{
               jQuery("#supporting_doc").attr('disabled',false); 
        }
  }
*/
/*
jQuery('#category').attr("value",'<?=$auctionData->category_id;?>');
//jQuery('#category').trigger("change");
setTimeout(function(){ 
    <?php
    if($auctionData->subcategory_id!=0&&$auctionData->subcategory_id!=''){$subcatrid=$auctionData->subcategory_id;}
    ?>
   jQuery('.id_100 option[value="<?=$subcatrid;?>"]').attr('selected','selected');

jQuery('#type').trigger("change");
}, 100);
*/

jQuery("#auto_extension, #auto_extension_time").on('blur',function(){
	if(jQuery("#auto_extension").val()== '0')
	{
		jQuery("#auto_extension_time").val(0);
	}
});

	jQuery('#dispatch_date').datepicker({
		controlType: 'select',
		oneLine: true,
		//minDate: 0,
                maxDate: 0,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd-mm-yy',
		yearRange: '1950:<?php echo date('Y')+1; ?>'
	});
	
 
    jQuery('#press_release_date').datepicker({
		controlType: 'select',
		oneLine: true,
		maxDate: 0,
		//stepMinute: 15,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd-mm-yy',
		//timeFormat: 'HH:mm:00',
		yearRange: '1950:<?php echo date('Y')+1; ?>'
	});
	
	
  jQuery('#inspection_date_from').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		minDate: 0,
		//stepMinute: 15,
		dateFormat: 'dd-mm-yy',
		yearRange: '1950:<?php echo date('Y')+1; ?>',
		timeFormat: 'HH:mm:00'
	});
	
	jQuery('#inspection_date_to').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		minDate: 0,
		stepMinute: 15,
		dateFormat: 'dd-mm-yy',
		yearRange: '1950:<?php echo date('Y')+1; ?>',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#bid_last_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
        //minDate: 0,
		//stepMinute: 15,
		changeYear: true,
		dateFormat: 'dd-mm-yy',
		yearRange: '<?php echo date('Y'); ?>:<?php echo date('Y')+1; ?>',
		timeFormat: 'HH:mm:00'
	});
	  jQuery('#bid_opening_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
        minDate: 0,
		//stepMinute: 15,
		changeYear: true,
		dateFormat: 'dd-mm-yy',
		yearRange: '1950:<?php echo date('Y')+1; ?>',
		timeFormat: 'HH:mm:00'
	});
		
	jQuery('#registration_start_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
        minDate: 0,
		//stepMinute: 15,
		dateFormat: 'dd-mm-yy',
		yearRange: '1950:<?php echo date('Y')+1; ?>',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#registration_end_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
        //minDate: 0,
		//stepMinute: 15,
		dateFormat: 'dd-mm-yy',
		yearRange: '<?php echo date('Y'); ?>:<?php echo date('Y')+1; ?>',
		timeFormat: 'HH:mm:00'
	});
	
	jQuery('#auction_start_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
                //minDate: 0,
                
                //useCurrent: false,
               showClear: true,
                //step: 15,
                //stepping: 15,
                //stepMinute: 0,
                //minute_interval : 15,
		//stepMinute: 15,
                //interval: 15,
                // minuteStepping: 15,
                //minuteInterval: 15,
                
                
		dateFormat: 'dd-mm-yy',
		yearRange: '<?php echo date('Y'); ?>:<?php echo date('Y')+1; ?>',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#auction_end_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
        //minDate: 0,
		//stepMinute: 15,
		changeYear: true,
		dateFormat: 'dd-mm-yy',
		yearRange: '<?php echo date('Y'); ?>:<?php echo date('Y')+1; ?>',
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

			//jQuery('#subCategoryType').css('display','block');
			jQuery('#sub_category_id').load('/admin/home/showsubcatdata/' + category_id);

		}
		
	});	
	jQuery('#invoice_mail_to').change(function(){
		var invoice_mail_to = jQuery(this).val();
		if(invoice_mail_to)
		{
			//jQuery('#invoice_mailed').
			jQuery( "#invoice_mailed option").removeAttr('disabled');
			jQuery( "#invoice_mailed option[value="+invoice_mail_to+"]").attr('disabled','disabled');
		}
		
	});	
	
	jQuery('.html_found').change(function() {
	   if (jQuery(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
		  sweetAlert('Oops!', 'Invalid html content found', 'error');
		  //alert('Invalid html content found');
		  jQuery(this).focus();
		  jQuery(this).val('');
	   }
	});
/*
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
	*/
	
  //tooltip
  jQuery(function() { 
       jQuery('.alphanumeric1').bind('keypress', function (event) {
    
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

jQuery('.latlong').keypress(function(event){
	
	var reg = new RegExp("^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!reg.test(key)) {  
		if(!((event.keyCode >= 37 && event.keyCode <= 40&&event.keyCode == 53 && event.keyCode ==55 && event.keyCode ==222))){
        event.preventDefault();
        return false;
	}
   }
});
jQuery('.numericonly').keypress(function(event) {
  if ((event.which != 46 || jQuery(this).val().indexOf('.') != -1) &&
    ((event.which < 48 || event.which > 57) &&
      (event.which != 0 && event.which != 8))) {
    event.preventDefault();
  }

  var text = jQuery(this).val();

  if ((text.indexOf('.') != -1) &&
    (text.substring(text.indexOf('.')).length > 2) &&
    (event.which != 0 && event.which != 8) &&
    (jQuery(this)[0].selectionStart >= text.length - 2)) {
    event.preventDefault();
  }
});



jQuery(".numericonly_1").keydown(function (e) { 
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
    
    
 jQuery('.alphanumeric2').bind('keypress', function (event) {
    
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
//jQuery("#state").attr("value","<?php echo $auctionData->state; ?>");
//jQuery("#city").attr("value","<?php echo $auctionData->city; ?>");
//jQuery("#bank_id").attr("value","<?php echo $auctionData->bank_id; ?>");
//jQuery("#category_id").attr("value","<?php echo $auctionData->category_id; ?>");

   jQuery('#country').change(function () {
		var country_id = jQuery(this).val();
		if (country_id)
		{
			var state_id = jQuery('#state_id').val();
			jQuery('#state').load('/admin/home/getStateDropDown/' + country_id + '/' + state_id);
		}

	});

	jQuery('#state').change(function () {
		var state_id = jQuery(this).val();
		if (state_id)
		{
			var city_id = jQuery('#city_id').val();
			jQuery('#city').load('/admin/home/getCityDropDown/' + state_id + '/' + city_id);
			//jQuery('#sales_person').load('/admin/home/getSalesPerson/' + state_id);
		}

	});
	
	jQuery('#bank_id').change(function () {
		var bank_id = jQuery(this).val();
		if(bank_id)
		{
			jQuery('#branch_id').load('/admin/home/showbranchdata/' + bank_id);
		}
	
    });

	/*jQuery('#category_id').change(function(){
		var category_id = jQuery(this).val();
		if(category_id == 1 || category_id == 2)
		{
			jQuery('#subCategoryType').css('display','block');
			jQuery('#sub_category_id').load('/admin/home/showsubcatdata/' + category_id);
		}

		if(category_id == 3) //3- Others
		{
			jQuery('#subCategoryType').css('display','none');
		}


	});*/
	
<?php if(is_array($upload_document_field) && count($upload_document_field)>0 )
{ 
	foreach($upload_document_field as $udf)
	{
		$fieldName = strtolower(str_replace(' ','_',$udf->upload_document_field_name));
		if($udf->upload_document_field_type == 2) // video type
		{
			?>
			jQuery('#<?php echo $fieldName;?>').change(function () {
				var getValue = this.value;
				var ext1 = getValue.split('.');
				var arr = ext1.length;
				var indexValuee = arr-1;
				if(getValue !=''){
					if(typeof ext1[indexValuee] == "undefined")
					{
						sweetAlert('Oops!', 'This is not an allowed video file type.', 'error');
						this.value = '';
					}
					
							var file_size = jQuery("#<?php echo $fieldName;?>")[0].files[0].size;
						   
						slimit=(1024*1024)*parseInt(10);
						if(file_size>slimit){
							sweetAlert('Oops!', 'Please Upload file less than 10MB', 'error');
							this.value = '';
						   }   
							  
					   
					//var ext = this.value.match(/\.(.+)$/)[1];
					switch (ext1[indexValuee]) {
						case 'webm':case 'mkv':case 'flv':case 'avi':case '3gp':case 'mp4':case 'wmv':
						jQuery('#<?php echo $fieldName;?>').attr('disabled', false);
						break;
						default:
							sweetAlert('Oops!', 'This is not an allowed video file type.', 'error');
							//alert('This is not an allowed video file type.');
							this.value = '';
					}
				}
			});
		<?php 
		}
		else
		{ ?>
		
			jQuery('#<?php echo $fieldName;?>').change(function () {
					var getValue = this.value;
					var ext1 = getValue.split('.');
					var arr = ext1.length;
					var indexValuee = arr-1;
					if(typeof ext1[indexValuee] == "undefined")
					{
						sweetAlert('Oops!', 'This is not an allowed file type. Only jpg, pdf and zip file are allowed.', 'error');
						this.value = '';
					}
					if(getValue !=''){
						var file_size = jQuery("#<?php echo $fieldName;?>")[0].files[0].size;
					   
					slimit=(1024*1024)*parseInt(5);
					if(file_size>slimit){
						sweetAlert('Oops!', 'Please Upload file less than 5MB', 'error');
						this.value = '';
					   }   
						   
				   }
					//var ext = this.value.match(/\.(.+)$/)[1];
					switch (ext1[indexValuee]) {
						//case 'png':case 'jpg':case 'gif':case 'jpeg':case 'pdf':case 'xls':case 'doc':case 'docx':case 'zip':
                                                case 'jpg':case 'pdf':case 'zip':case 'jpeg':case 'png':
						jQuery('#<?php echo $fieldName;?>').attr('disabled', false);
						break;
						default:
							sweetAlert('Oops!', 'This is not an allowed file type. Only jpg, pdf and zip file are allowed.', 'error');
                            //alert('This is not an allowed file type.Only jpg and pdf file are allowed.');
							this.value = '';
					}
			});
	<?php
		}
	}
}
?>	

	jQuery(document).on('change','.upload_property_photo',function () {	
			var getValue = this.value;
			var ext1 = getValue.split('.');
			var arr = ext1.length;
			var indexValuee = arr-1;
			if(typeof ext1[indexValuee] == "undefined")
			{
				sweetAlert('Oops!', 'This is not an allowed file type. Only jpg, jpeg, png file are allowed.', 'error');
				//alert('This is not an allowed file type.');
				this.value = '';
			}
			var ext = this.value.match(/\.(.+)$/)[1];
			ext = ext.toLowerCase();
			switch (ext1[indexValuee]) {
				case 'png':case 'jpg':case 'gif':case 'jpeg':
				jQuery('#image').attr('disabled', false);
				break;
				default:
					sweetAlert('Oops!', 'This is not an allowed file type. Only jpg, jpeg, png file are allowed.', 'error');
					//alert('This is not an allowed file type.');
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
				sweetAlert('Oops!', 'This is not an allowed file type.', 'error');
				this.value = '';
			}
			//var ext = this.value.match(/\.(.+)$/)[1];
			switch (ext1[indexValuee]) {			
				case 'png':case 'jpg':case 'gif':case 'jpeg':
				jQuery('#image').attr('disabled', false);
				break;
				default:
					sweetAlert('Oops!', 'This is not an allowed file type.', 'error');
					//alert('This is not an allowed file type.');
					this.value = '';
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
      
      
    jQuery(".numericonly_1").keydown(function (e) { 
        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
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
		var timeobj = document.getElementById("error");
				if(timeobj !== undefined && timeobj !==  null)
				{
						document.getElementById("error").style.display = ret ? "none" : "inline";
				}
		return ret;
	}
jQuery(document).ready(function($){
	//initSample();
	//initSample1();
	/*
	jQuery('#area').blur(function(){
		//jQuery('#emd_amt').val('');
		//jQuery('#tender_fee').val('');
		//var vrand = Math.random() * 10000000000000000;
		var	areaVal = jQuery(this).val();
		areaVal = areaVal.trim();
		var	bspVal = jQuery('#reserve_price').val();
		bspVal = bspVal.trim();
				
		if(areaVal !='' && bspVal !='')
		{
			//cal_pfee_emdfee(areaVal,bspVal);
		}
		
	});
	*/
	/*
	jQuery('#reserve_price').blur(function(){	
		
		
		//jQuery('#emd_amt').val('');
		//jQuery('#tender_fee').val('');
		//var vrand = Math.random() * 10000000000000000;
							
		var	bspVal = jQuery(this).val();
		bspVal = bspVal.trim();
		
		
		var	areaVal = jQuery('#area').val();
		areaVal = areaVal.trim();
		//alert(areaVal+' | '+bspVal);
		if(areaVal !='' && bspVal !='')
		{						
			//cal_pfee_emdfee(areaVal,bspVal);
		}
		
	});
	*/
	/*
	jQuery("#emd_amt").blur(function(){
		var emdVal = jQuery(this).val().trim();
		if(emdVal !='' && emdVal>0)
		{
			var inwords = numToWords(emdVal);
			jQuery('#emdWords').html(inwords);   
		}
	});
	*/
	jQuery(".addMem").click(function(){		
		var addMoreImgRandomKey = Math.floor(Math.random() * 1000000);
		
		jQuery(".customFields").append('<div class="cust-field-cont"><div class="row"><div class="lft_heading">Upload Property Photographs </div><div class="rgt_detail"><input type="file" name="upload_property_photo['+addMoreImgRandomKey+']" class="upload_property_photo" value="" /><div class="tooltips"><img src="<?php echo base_url(); ?>images/help.png" class="tooltip_icon"><span>Upload Property Photographs</span></div></div></div><div class="row"><div class="lft_heading">Photographs Caption </div><div class="rgt_detail" style="position: relative;"><textarea name="photo_caption['+addMoreImgRandomKey+']" type="text"  class="input"><?php echo $photo_caption; ?></textarea><div class="tooltips"><img src="<?php echo base_url(); ?>images/help.png" class="tooltip_icon"><span>Photographs Caption</span></div><a href="javascript:void(0);" class="remCF" style="position: absolute;top:-14px;margin-left:20px"><image src="<?php echo base_url()?>bankeauc/images/delete.png" alt="Delete" title="Delete this row" style="display: inline-block !important; width:17px !important;"/></a></div></div></div>');
		addRemoveSrNo();
	});
	
	jQuery(".customFields").on('click','.remCF',function(){
        jQuery(this).parent().parent().parent('.cust-field-cont').remove();
        jQuery('.addCF').css('display','');
        addRemoveSrNo();
    });
    
    jQuery(".customFields").on('keypress','input',function(){
        jQuery(this).parent().find('.error').html('');
        
    });
	
});

function addRemoveSrNo()
{
	jQuery(".customFields tr").each(function(i){
		if(i>0)
		{
			jQuery(this).find('td').eq(0).html(i);
		}
	});
}

function cal_pfee_emdfee(areaVal,bspVal)
{
	$.ajax({
			url: "<?php echo base_url();?>buyer/get_part_emd_val", // 
			type:"post",
			//contentType: "application/json",
			data:{"areaVal": areaVal, "bspVal": bspVal},
			async: false,
			success:function(response)
			{
				var obj = $.parseJSON(response);
				jQuery('#emd_amt').val(obj.emdFee);
				jQuery('#tender_fee').val(obj.pFee);
				var inwords = numToWords(obj.emdFee);
				jQuery('#emdWords').html(inwords);   
			}
		});	
}
</script>


<script type="text/javascript">
jQuery(function () {
var map;
    jQuery("#btnShow").click(function () {
		var latitude = jQuery("#latitude").val();
		var longitude = jQuery("#longitude").val();
		
		if(!(parseFloat(latitude) > 0))
		{
			latitude = 	28.457523;
			longitude = 77.026344;
		}
		
        jQuery("#dialog").dialog({
            modal: true,
            title: "Google Map",
            width: 600,
            hright: 450,
            buttons: {
                Close: function () {
                    jQuery(this).dialog('close');
                }
            },
            open: function () {
                var mapOptions = {
                    center: new google.maps.LatLng(latitude,longitude),
                    zoom: 10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                map = new google.maps.Map(jQuery("#dvMap")[0], mapOptions);
                google.maps.event.addListener(map, 'click', function (e) {
                //alert("Latitude: " + e.latLng.lat() + "\r\nLongitude: " + e.latLng.lng());
                jQuery("#latitude").val(e.latLng.lat());
                 jQuery("#longitude").val(e.latLng.lng());
                 jQuery(".ui-button").click();
           	 });
            }
        });
    });
});

function removePorpertyPhotoData(auction_document_id) {
	swal({
	  title: 'Are you sure?',
	  text: "You won't be able to revert this!",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, delete it!',
	  cancelButtonText: 'No, cancel!'
	}).then(function () {
		$.ajax({
			url: "/admin/home/removePorpertyPhotoData",
			type: "post",
			data: "auction_document_id=" + auction_document_id,
			success: function (results) {
				window.location.reload(true);
			}
		});
	}, function (dismiss) {
		  // dismiss can be 'cancel', 'overlay',
		  // 'close', and 'timer'
		  if (dismiss === 'cancel') {
			swal('Cancelled','Property Photo not deleted','error')
		  }
		});
}

</script>
<script>
//Function used for: "Area Unit" and "BSP Unit of Price" shouls be same                                                                                                
function setUnit(){ 
    //$val = jQuery('#area_unit_id').val();
    //$text = jQuery('#area_unit_id option:selected').html();
    //jQuery("#unit_id_of_price").html("<option value="+$val+">"+$text+"</option>");
}

jQuery('#area, #bid_inc').bind("cut copy paste",function(e) {
     e.preventDefault();
 });
 
 function validateSubmitform(btn) {
    jQuery('#spMsg').html("");
    flag = '';
    //body = CKEDITOR.instances.contact_person_details_1.getData().trim();
    if (btn == "save")
    {
        if (jQuery('#bank_id').val() == '') {
            jQuery('#spMsg').append("<li>Please Select Bank </li>");
            flag = 1;
        }
		if (jQuery('#branch_id').val() == '') {
            jQuery('#spMsg').append("<li>Please Select Branch </li>");
            flag = 1;
        }
        if (jQuery('#category_id').val() == '') {
            jQuery('#spMsg').append("<li>Please Select Assets Category </li>");
            flag = 1;
        }
		
        if (jQuery('#description').val().trim() == '') {
            jQuery('#spMsg').append("<li>please Enter description </li>");
            flag = 1;
        }
		if (jQuery('#asset_details').val().trim() == '') {
            jQuery('#spMsg').append("<li>please Enter Asset Details </li>");
            flag = 1;
        }
		if (jQuery('#reference_no').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter Location </li>");
            flag = 1;
        }
		if (jQuery('#country').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Select Country </li>");
            flag = 1;
        }
		if (jQuery('#state').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter State </li>");
            flag = 1;
        }
		if (jQuery('#city').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter City </li>");
            flag = 1;
        }
		/*
        if (isNaN(jQuery('#bid_inc').val().trim()) == true) {
            jQuery('#spMsg').append("<li>Please Enter Valid Bid Increment value</li>");
            flag = 1;
        }*/
		/*
        if (body == '')
        {
            jQuery('#spMsg').append("<li>Please Enter 1st Contact Person Details  </li>");
            flag = 1;
        }*/

        /*
		if (jQuery('#latitude').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter Latitude </li>");
            flag = 1;
        }
        if (jQuery('#longitude').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter Longitude </li>");
            flag = 1;
        }
		*/

        /*
         if(jQuery('#image').val()!='')
         {
         var ud = jQuery('#image');
         lg = ud[0].files.length;
         var f = ud[0].files;		
         var fTypeErr = false;
         var fSizeErr = false;
         for (var i = 0; i < lg; i++) { 
         var ext = f[i].name.split('.').pop().toLowerCase();
         if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
         {
         flag=1; 
         fTypeErr = true;
         }
         else
         {
         var file_size = f[i].size;
         slimit=(1024*1024)*parseInt(5);
         if(file_size>slimit)
         {
         flag=1; 
         fSizeErr = true;
         }
         }
         }					
         if(fTypeErr)
         {
         jQuery("#spMsg").append("<li>Please Upload Valid Image( Acceptable format are gif,png,jpg,jpeg)</li>");
         }
         if(fSizeErr)
         {
         jQuery("#spMsg").append("<li>Please Upload Image files less than 5MB</li>");
         }
         }*/



        returnFlag = ValidateDate(btn);
        if (flag == 1 || returnFlag == 1) {

            //if(returnFlag==1){
            //alert("-------"+flag);
            jQuery("#showerror_msg").show();
            jQuery(".inline").colorbox({inline: true, width: "50%"});
            jQuery(".inline").click();
            return false;
            // }
        } else {
            return true;
        }
    } else
    {
        //alert(body);
        if (jQuery('#bank_id').val() == '') {
            jQuery('#spMsg').append("<li>Please Select Bank </li>");
            flag = 1;
        }
		if (jQuery('#branch_id').val() == '') {
            jQuery('#spMsg').append("<li>Please Select Branch </li>");
            flag = 1;
        }
        if (jQuery('#category_id').val() == '') {
            jQuery('#spMsg').append("<li>Please Select Assets Category </li>");
            flag = 1;
        }
		if ((jQuery('#category_id').val() == 1 || jQuery('#category_id').val() ==2) && jQuery('#sub_category_id').val() == '') {
            jQuery('#spMsg').append("<li>Please Select Assets Type </li>");
            flag = 1;
        }

		if (jQuery('#contact_person_details_1').val() == '') {
            jQuery('#spMsg').append("<li>Please Enter Contact Details </li>");
            flag = 1;
        }
		
        if (jQuery('#description').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter Description </li>");
            flag = 1;
        }
		if (jQuery('#asset_details').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter Asset Details </li>");
            flag = 1;
        }
		if (jQuery('#reference_no').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter Location </li>");
            flag = 1;
        }
		if (jQuery('#country').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Select Country </li>");
            flag = 1;
        }
		if (jQuery('#state').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter State </li>");
            flag = 1;
        }
		if (jQuery('#city').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter City </li>");
            flag = 1;
        }
		 /*
        if (jQuery('#area').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter Property Area </li>");
            flag = 1;
        }
       
        if (isNaN(jQuery('#area').val().trim()) == true) {
            jQuery('#spMsg').append("<li>Please Enter Valid Property Area </li>");
            flag = 1;
        }
        
        if (jQuery('#area_unit_id').val() == '') {
            jQuery('#spMsg').append("<li>Please Select Area Unit </li>");
            flag = 1;
        }
        */

        if (jQuery('#category_id').val() == 1 && jQuery('#category').val() == '') {
            jQuery('#spMsg').append("<li>Please Select Sub Type </li>");
            flag = 1;
        }
		
		if (jQuery('#category_id').val() == 2 && jQuery('#vehicle_type').val() == '') {
            jQuery('#spMsg').append("<li>Please Select Vehicle Type </li>");
            flag = 1;
        }

		

        /*
        if (jQuery('#zone_id').val() == '') {
            jQuery('#spMsg').append("<li>Please Select Concerned Zone</li>");
            flag = 1;
        }*/
        /*   
         if (jQuery('#height_unit_id').val() == '') {
         jQuery('#spMsg').append("<li>Please Select Height Unit</li>");
         flag = 1;
         } */

        if (jQuery('#reserve_price').val() == '') {
            jQuery('#spMsg').append("<li>Please Enter Reserve Price </li>");
            flag = 1;
        }
        if ((jQuery('#reserve_price').val() == 0) && (jQuery('#reserve_price').val() != '')) {
            jQuery('#spMsg').append("<li>Reserve Price can not be zero</li>");
            flag = 1;
        }
        if (isNaN(jQuery('#reserve_price').val().trim()) == true) {
            jQuery('#spMsg').append("<li>Please Enter Valid Reserve Price</li>");
            flag = 1;
        }

        if (jQuery('#emd_amt').val() == '') {
            jQuery('#spMsg').append("<li>Please Enter Emd Amount</li>");
            flag = 1;
        }
        if ((jQuery('#emd_amt').val() == 0) && (jQuery('#emd_amt').val() != '')) {
            jQuery('#spMsg').append("<li>Emd Amount can not be zero</li>");
            flag = 1;
        }
        
        if (isNaN(jQuery('#emd_amt').val().trim()) == true) {
            jQuery('#spMsg').append("<li>Please Enter Valid Emd Amount </li>");
            flag = 1;
        }
        
        /*
        if (jQuery('#tender_fee').val() == '') {
            jQuery('#spMsg').append("<li>Please Enter Bank Processing Fee</li>");
            flag = 1;
        }
        */
        /*
        if (isNaN(jQuery('#tender_fee').val().trim()) == true) {
            jQuery('#spMsg').append("<li>Please Enter Valid Participation Fee </li>");
            flag = 1;
        }
        */
        /* 
         if(jQuery('#second_opener').val()==''){
         jQuery('#spMsg').append("<li>Please Select Auction Approver</li>");
         flag = 1;
         } 
         */

        /*
         if( (jQuery('#emd_amt').val() != '') &&  (jQuery('#reserve_price').val() != '')){	
         if (parseFloat(jQuery('#reserve_price').val()) <= parseFloat(jQuery('#emd_amt').val())) {
         jQuery('#spMsg').append("<li>Reserve Price should be greater than EMD Amount<li/>");
         flag = 1;
         }
         }
         */
		/*
        if (jQuery('#unit_id_of_price').val() == '') {
            jQuery('#spMsg').append("<li>Please Select Reserve Price (Unit) </li>");
            flag = 1;
        }
        */

		/*
        if (jQuery('#press_release_date').val() == '') {
            jQuery('#spMsg').append("<li>Please Enter Press Release Date</li>");
            flag = 1;
        }
        */
        /*
        if (jQuery('#inspection_date_to').val() == '') {
            jQuery('#spMsg').append("<li>Please Enter Site Visit End Date</li>");
            flag = 1;
        }
        */
        /*
         if (jQuery('#registration_start_date').val() == '') {
         jQuery('#spMsg').append("<li>Please Enter Apply And EMD Start Date</li>");
         flag = 1;
         }
        */
        if (jQuery('#bid_last_date').val() == '') {
            jQuery('#spMsg').append("<li>Please Enter EMD Submission Last Date</li>");
            flag = 1;
        }

		/*
        if (jQuery('#bid_opening_date').val() == '') {
            jQuery('#spMsg').append("<li>Please Enter Shortlisting Start Date</li>");
            flag = 1;
        }
		*/
			
        if (jQuery('#auction_start_date').val() == '') {
            jQuery('#spMsg').append("<li>Please Enter Auction Start date</li>");
            flag = 1;
        }

		
        if (jQuery('#auction_end_date').val() == '') {
            jQuery('#spMsg').append("<li>Please Enter Auction End date</li>");
            flag = 1;
        }
        
		/*
        if (jQuery('#bid_inc').val() == '') {
            jQuery('#spMsg').append("<li>Please Enter Bid Increment value</li>");
            flag = 1;
        }
        
         if ((jQuery('#auto_extension').val() > 0 && (jQuery("#auto_extension_time").val() <=0 || jQuery("#auto_extension_time").val()=='')) || jQuery('#auto_extension').val() =='' && (jQuery("#auto_extension_time").val() <=0 || jQuery("#auto_extension_time").val()=='')) {
            jQuery('#spMsg').append("<li>Please Enter Valid Auto Extension Time</li>");
            flag = 1;
        }       
        if (isNaN(jQuery('#bid_inc').val().trim()) == true) {
            jQuery('#spMsg').append("<li>Please Enter Valid Bid Increment value</li>");
            flag = 1;
        }
        
        if (body == '')
        {
            jQuery('#spMsg').append("<li>Please Enter 1st Contact Person Details  </li>");
            flag = 1;
        }
        */
		/*
        if (jQuery('#latitude').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter Latitude </li>");
            flag = 1;
        }
        if (jQuery('#longitude').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter Longitude </li>");
            flag = 1;
        }
		*/

        jQuery('.fileRq').each(function () {
            var fieldId = jQuery(this).attr('id');

            if (jQuery('#old_' + fieldId).val() == '')
            {
                if (jQuery(this).val() == '')
                {
                    fieldId = fieldId.replace(/\_+/g, ' ');
                    jQuery('#spMsg').append("<li>Please " + fieldId + "</li>");
                    flag = 1;
                }
            }
        });

/*
        if (jQuery('#approverComments').size() > 0 && jQuery('#approverComments').val().trim() == '') {
            jQuery('#spMsg').append("<li>Please Enter Approver comments </li>");
            flag = 1;
        }
*/



        /*if (jQuery('#old_related_doc').val() == '' && jQuery('#related_doc').val() == '' ) {
         jQuery('#spMsg').append("<li>Please Upload Related Document</li>");
         flag = 1;
         }
         */


        //if (jQuery('#old_image').val() == '' && jQuery('#image').val() == '') { 
        /*if (jQuery('#old_image').val() == '' && jQuery('#image').val() == '') { 
         jQuery('#spMsg').append("<li>Please Upload Image</li>");
         flag = 1;
         }*/
        /*
         if(jQuery('#image').val()!=''){
         var ext = jQuery('#image').val().split('.').pop().toLowerCase();
         if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
         flag=1; 
         jQuery("#spMsg").append("<li>Please Upload Valid Image( Acceptable format are gif,png,jpg,jpeg)</li>");
         }else{
         var file_size = jQuery('#image')[0].files[0].size;
         slimit=(1024*1024)*parseInt(5);
         if(file_size>slimit){
         flag=1; 
         jQuery("#spMsg").append("<li>Please Upload Image less than 5MB</li>");
         }     
         
         }
         }
         */

/*
        var options = jQuery('#doc_to_be_submitted > option:selected');
        if (options.length == 0) {
            jQuery('#spMsg').append("<li>Please Select Documents to be submitted by Bidder </li>");
            flag = 1;
        }
        */


        if (flag != 1) {
            returnFlag = ValidateDate(btn);
            if (returnFlag == 1) {
                jQuery("#showerror_msg").show();
                jQuery(".inline").colorbox({inline: true, width: "50%"});
                jQuery(".inline").click();
                return false;
            } else {
                //return false;	
                return true;
            }

        } else {
            jQuery("#showerror_msg").show();
            jQuery(".inline").colorbox({inline: true, width: "50%"});
            jQuery(".inline").click();
            return false;
        }
    }

    return false;
    // return flag;
}

function setDateFormate(dateTime) {
    var arr1 = dateTime.split(' ');
    var arr2 = arr1[0].split('/');
    var dateTime = arr2[2] + '/' + arr2[1] + '/' + arr2[0] + ' ' + arr1[1];
    return dateTime;
}

function ValidateDate(btn) {


    var pressReleasedate = "", inspecDateFrom = "", inspectionDateTo = "";
    var EMDStartDate = "", EMDEndDate = "", ShortListingDate = "";
    var auctionStartDate="", auctionEndDate = "";
    var flag = '';
    
    var currdate = jQuery('#currdate').val();
    //var currentDate = 
    var currdatetime = new Date(setDateFormate(currdate));

    //pressReleasedate    = jQuery('#press_release_date').val();
    //inspecDateFrom      = jQuery('#inspection_date_from').val();
    //inspectionDateTo    = jQuery('#inspection_date_to').val();
    //EMDStartDate        = jQuery("#registration_start_date").val();
    //ShortListingDate    = jQuery('#bid_opening_date').val();
	EMDEndDate          = jQuery('#bid_last_date').val();
    auctionStartDate    = jQuery('#auction_start_date').val();
    auctionEndDate      = jQuery('#auction_end_date').val();
	
	/*
    pressReleasedate    = new Date(setDateFormate(pressReleasedate.replace(/-/g, '/')));
    if(inspecDateFrom != ''){
        inspecDateFrom      = new Date(setDateFormate(inspecDateFrom.replace(/-/g, '/')));
    }
    if(inspectionDateTo != ''){
        inspectionDateTo    = new Date(setDateFormate(inspectionDateTo.replace(/-/g, '/')));
    }
    */
    EMDStartDate        = new Date(setDateFormate(EMDStartDate.replace(/-/g, '/')));
    EMDEndDate          = new Date(setDateFormate(EMDEndDate.replace(/-/g, '/')));
    //ShortListingDate    = new Date(setDateFormate(ShortListingDate.replace(/-/g, '/')));
    auctionStartDate    = new Date(setDateFormate(auctionStartDate.replace(/-/g, '/')));
    auctionEndDate      = new Date(setDateFormate(auctionEndDate.replace(/-/g, '/')));
	
	/*
    var is_corrigendum_backend = 0;
    if (typeof jQuery('corrigendum_backend') != 'undefined')
    {
        var is_corrigendum_backend = jQuery('#corrigendum_backend').val();
    }
	*/
	/*
    if (pressReleasedate != '') {
        if (pressReleasedate >= currdatetime && is_corrigendum_backend != 1) {
            jQuery('#spMsg').append("<li>Press Release Date or time should be less than current date or time !! <li/>");
            flag = 1;
        }
        
    }
	*/
	/*
    if (inspecDateFrom != '' && jQuery('#inspection_date_from').val() != '0000-00-00 00:00:00') {
        if (pressReleasedate >= inspecDateFrom) {
            jQuery('#spMsg').append("<li> Site Visit Start Date time should be greater than Press release date !! <li/>");
            flag = 1;
        }
    }

    if (inspectionDateTo != '' && jQuery('#inspection_date_to').val() != '0000-00-00 00:00:00' && inspecDateFrom != '' && jQuery('#inspection_date_from').val() != '0000-00-00 00:00:00') {
        
        if (inspectionDateTo <= inspecDateFrom) {
            jQuery('#spMsg').append("<li> Site Visit End Date time should be greater than  Site Visit Start Date time !! <li/>");
            flag = 1;
        }
        
        
       if (inspectionDateTo >= auctionEndDate) {
            jQuery('#spMsg').append("<li> Site Visit End Date time should be less than Auction End date or time !! <li/>");
            flag = 1;
        }
        
    }
    */
	/*
    if (EMDStartDate != '' && jQuery("#registration_start_date").val() != '0000-00-00 00:00:00') {
       
        if (EMDStartDate <= pressReleasedate) {
            jQuery('#spMsg').append("<li> Apply And EMD Start Date time should be greater than Press Release Date time !! <li/>");
            flag = 1;
        }
    }
    
    if (EMDEndDate != '' && jQuery("#bid_last_date").val() != '0000-00-00 00:00:00') {
        if (EMDEndDate <= EMDStartDate) {
            jQuery('#spMsg').append("<li> EMD Submission Last Date time should be greater than Apply And EMD Start Date time !! <li/>");
            flag = 1;
        }
        
        
         
    }*/
    /*
    if (ShortListingDate != '' && jQuery("#bid_opening_date").val() != '0000-00-00 00:00:00') {
        if (ShortListingDate <= EMDEndDate) {
            jQuery('#spMsg').append("<li> Shortlisting Start Date time should be greater than EMD Submission Last Date time !! <li/>");
            flag = 1;
        }
    }
    */
    /*
    if (auctionStartDate != '' && jQuery("#auction_start_date").val() != '0000-00-00 00:00:00') {
        if (auctionStartDate <= ShortListingDate) {
            jQuery('#spMsg').append("<li> Auction Start Date time should be greater than Shortlisting Start Date time !! <li/>");
            flag = 1;
        }
    }
    */
    /*
    if (auctionStartDate != '' && jQuery("#auction_start_date").val() != '0000-00-00 00:00:00') {
        if (auctionStartDate <= EMDStartDate) {
            jQuery('#spMsg').append("<li> Auction Start Date time should be greater than Apply And EMD Start Date time !! <li/>");
            flag = 1;
        }
    }
	*/
    
   if (auctionEndDate != '' && jQuery("#auction_end_date").val() != '0000-00-00 00:00:00') {
        if (auctionEndDate <= auctionStartDate) {
            jQuery('#spMsg').append("<li> Auction End Date time should be greater than Auction Start Date time !! <li/>");
            flag = 1;
        }
        if (auctionEndDate <= EMDEndDate) {
            jQuery('#spMsg').append("<li> Auction End Date time should be greater than EMD Submission Last Date time !! <li/>");
            flag = 1;
        }
    }
   
    return flag;
}
</script>
