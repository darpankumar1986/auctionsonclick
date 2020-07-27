<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.tagsinput.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo VIEWBASE?>css/plugins/jquery.tagsinput.css">
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script>
	jQuery(document).ready(function(){		
		//Examples of how to assign the Colorbox event to elements
		jQuery(".iframe").colorbox({iframe:true, width:"90%", height:"90%"});
	});
	function getZone(bank_id){
		//cat_id = jQuery('#zone').val();
		jQuery('#zone').load('/superadmin/bank_zone/ajax_zone/'+bank_id);
		
		}
</script>
<?php 
if($row){
	$id=$row->id;	
	$name=$row->name;	
	$BankId=$row->bank_id;
	$lho  =  $row->lho_id;
	$ZoneId=$row->zone_id;
	$address1 = $row->address1;
	$address2 = $row->address2;	
	$street=$row->street;
	$country=$row->country;
	$state=$row->state;
	$city=$row->city;
	$zip=$row->zip;
	$phone=$row->phone;
	$fax=$row->fax; 
	$status=$row->status; 
	$indate = $row->indate; 
	
	
}else{	
	$status = 0;	
	$id = 0;
}
?> 
<section class="body_main1">	
	<div class="row">						
			<a href="<?php echo base_url().'superadmin/bank_region'?>" class="button_grey"> Region List</a>
		</div>
		<div class="box-head">Create Region</div>
	<div class="centercontent">
		<div class="pageheader">
			<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
		</div><!--pageheader-->
		<div id="contentwrapper" class="contentwrapper box-content2">
			<div id="validation" class="subcontent">            	
				<form enctype="multipart/form-data" method="post" class="stdform" id="branch" name="add_data_view" accept-charset="utf-8" action="/superadmin/bank_region/save_region" autocomplete="off">	
					
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />	
					<div class="row">
						<div class="lft_heading"> Organization Name <span class="red"> *</span></div>
						<div class="rgt_detail">
							<select name="bank" id="bank" onchange="getZone(jQuery(this).val())">
								<option value="">Select Organization</option>
								<?php
								foreach($banks as $bank_record){?>
				  <option value="<?php echo $bank_record->id; ?>" <?php echo ($bank_record->id==$BankId)?'selected':''; ?>><?php echo $bank_record->name; ?></option>
								<?php }?>
							</select>
						</div>					
					</div>
					<?php /* ?>
					<p>
						<label>LHO<font color='red'></font></label>
						<span class="field">
							<select name="lho_id" id="lho_id">
								<option value="">Select LHO</option>
								<?php
								foreach($lhoarr as $lho_record){?>
				  <option value="<?php echo $lho_record->id; ?>" <?php echo ($lho_record->id==$lho)?'selected':''; ?>><?php echo $lho_record->name; ?></option>
								<?php }?>
							</select>
						</span>					
					</p>
					<?php */ ?>
					<div class="row">
						<div class="lft_heading">Zone Name <span class="red"> *</span></div>
						<div class="rgt_detail">
							<select name="zone" id="zone" onchange="getRegion(jQuery(this).val())">
								<option value="" >Select Zone</option>
								<?php
								foreach($zones as $bzone_record){?>
				  <option value="<?php echo $bzone_record->id; ?>" <?php echo ($bzone_record->id==$ZoneId)?'selected':''; ?>><?php echo $bzone_record->zone_name; ?></option>
								<?php }?>
							</select>
						</div>					
					</div>
					<div class="row">
						<div class="lft_heading">Region Name <span class="red"> *</span></div>
						<div class="rgt_detail">
							<input maxlength="150" type="text" name="name" id="name" class="longinput html_found" value="<?php echo $name?>" />
							<label class="error" style="display:none;">Please enter Name</label>
						</div>					
					</div>
					<div class="row">
						<div class="lft_heading">Address 1 <span class="red"> *</span></div>
						<div class="rgt_detail">
							<textarea maxlength="200" class="html_found" name="address1" id="address1" rows="5" cols="60" ><?php echo $address1?></textarea>
							<label class="error" style="display:none;">Please enter Address</label>
						</div>					
					</div>
					<div class="row">
						<div class="lft_heading">Address 2 </div>
						<div class="rgt_detail">
							<textarea maxlength="200" name="address2" class="html_found" id="address2" rows="5" cols="60" ><?php echo $address2?></textarea>
							<label class="error" style="display:none;">Please enter Address</label>
						</span>					
					</div>
					<div class="row">
						<div class="lft_heading">Street </div>
						<div class="rgt_detail">
							<textarea name="street" maxlength="100" class="html_found" id="street" rows="5" cols="60" ><?php echo $street?></textarea>
							<label class="error" style="display:none;">Please enter street</label>
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
						</div>					
					</div>
					<div class="row">
						<div class="lft_heading">State <span class="red"> *</span></div>
						<div class="rgt_detail">
							<select name="state_id" id="state_id">
								<option value="">Select State</option>
								<?php
								foreach($states as $state_record){?>
				  <option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id==$state)?'selected':''; ?>><?php echo $state_record->state_name; ?></option>
								<?php }?>
							</select>
						</div>					
					</div>
					
					<div class="row">
						<div class="lft_heading">City <span class="red"> *</span></div>
						<div class="rgt_detail">
							<select name="city_id" id="city_id">
								<option value="">Select City</option>
								<?php
								foreach($cities as $city_record){?>
				  <option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id==$city)?'selected':''; ?>><?php echo $city_record->city_name; ?></option>
								<?php }?>
							</select>
						</div>					
					</div>
					<div class="row">
						<div class="lft_heading">Zip Code <span class="red"> *</span></div>
						<div class="rgt_detail">
							<input type="text" maxlength="6" onkeypress="return isNumberKey(event);" name="zip" id="zip" class="longinput html_found" value="<?php echo $zip?>" />
							<label class="error" style="display:none;">Please enter zip</label>
						</div>					
					</div>
					<div class="row">
						<div class="lft_heading">Phone Number <span class="red"> *</span></div>
						<div class="rgt_detail">
							<input type="text" maxlength="15" onkeypress="return isNumberKey(event);" name="phone" id="phone" class="longinput html_found" value="<?php echo $phone?>" />
							<label class="error" style="display:none;">Please enter phone</label>
						</div>					
					</div>
					<div class="row">
						<div class="lft_heading">Fax Number </div>
						<div class="rgt_detail">
							<input type="text" maxlength="15" name="fax" id="fax" onkeypress="return isNumberKey(event);" class="longinput" value="<?php echo $fax?>" />
							<label class="error" style="display:none;">Please enter fax</label>
						</div>					
					</div>
					<div class="row">
							<div class="lft_heading">Status<span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="status">
								<option value="1" <?php if($status==1)echo 'selected';?>>Active</option>
								<option value="0" <?php if($status==0)echo 'selected';?>>Inactive</option>
							</select>
							</div>	
						</div>	
					
					<hr>
					<div class="stdformbutton row" style="text-align:center;">
						 <a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>
						<input type="submit" class="button_grey"  name="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
						<input type="hidden" name="id" id="id" value="<?php echo $id?>">
						<input type="hidden" name="bank_id" id="bank_id" value="<?php echo $bank_id?>">
					</div>
					
				</form>
			</div>
		</div><!--contentwrapper-->
		<br clear="all" />
	</div><!-- centercontent -->
</section>
<script>
	 function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        console.log(charCode);
        if ( charCode != 45 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
jQuery(document).ready(function(){
	jQuery('.html_found').change(function() {
	   if (jQuery(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
		  alert('Invalid html content found');
		  jQuery(this).focus();
		  jQuery(this).val('');
	   }
	});
	jQuery("#branch").validate({
		rules: {
			name: {
				required: true,
				alphanumeric:true,
			},
			bank: "required",
			zone: "required",
			address1: "required",
			country_id: "required",
			state_id: "required",
			city_id: "required",
			fax: "number",
			zip: {
				required: true,
				number: true
				},
			phone: {
				required: true,
				number: true
				}
			
		},
		messages: {
			name: {
				required:"Please enter name"	
			},
			bank: "Please select bank",
			zone: "Please select zone",
			address1: "Please enter address",
			country_id: "Please select country ",
			state_id: "Please select state",
			fax: "Please enter number only",
			city_id: "Please select city",
			zip: {
				required: "Please enter zip code",
				number: "Please enter valid zip number"
				},
			phone: {
				required: "Please enter phone number",
				number: "Please enter valid phone number"
				}
		}
	});
	
	jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\\-\s]+$/i.test(value);
    }, "Name must contain only letters, numbers, or dashes.");
	
	jQuery("#date_published" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '1910:'
	});
	
	jQuery('#country_id').change(function(){
		var country_id = jQuery(this).val();
		if(country_id )
		{
			var state_id = jQuery('#state_id').val();
			jQuery('#state_id').load('/superadmin/bank/getStateDropDown/'+country_id+'/'+state_id);
		}
		
	});	
	jQuery('#state_id').change(function(){
		var state_id = jQuery(this).val();
		if(state_id )
		{
			var city_id = jQuery('#city_id').val();
			jQuery('#city_id').load('/superadmin/bank/getCityDropDown/'+state_id+'/'+city_id);
		}
		
	});
	
	jQuery('#bank').change(function(){
		var bank_id = jQuery(this).val();		
		var lho_id = jQuery('#lho_id').val();
		jQuery('#lho_id').load('/superadmin/bank/getLhoDropDown/'+bank_id+'/'+lho_id);	
		
	});
	
	
	
	
});	

</script>
