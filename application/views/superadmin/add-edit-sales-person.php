<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if(!empty($row)){
	$id=$row->id; 
	$state=$row->state_id; 
	$sales_person_name=$row->sales_person_name; 
	$status=$row->status; 
	$country=GetTitleByField('tbl_state', "id='$state'", 'countryID');
	$email_id=$row->email_id; 
	$mobile_no=$row->mobile_no;
} else {
	$status = 1;
	$id = 0;
	if(!empty($_POST)) {
		$state=$_POST['state_id']; 
		$sales_person_name=$_POST['sales_person_name']; 
		$status=$_POST['status']; 
		$country=GetTitleByField('tbl_state', "id='$state'", 'countryID');
		$email_id=$_POST['email_id'] ;
		$mobile_no=$_POST['mobile_no'];
	}
}
//=1;
?> 
<section class="body_main1">
<div class="centercontent">
	<div class="row">						
			<a href="<?php echo base_url().'superadmin/sales_person/index'?>" class="button_grey"> Sales Person List</a>
	</div>
	
	<div class="box-head">Create Sales Person</div>
	
	<div class="pageheader">
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
	

    <div id="contentwrapper" class="contentwrapper box-content2">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="city" name="add_data_view" accept-charset="utf-8" action="/superadmin/sales_person/save/<?php if($id) echo $id?>" autocomplete="off">		
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				
				<?php /* ?>
				<div class="row">
					<div class="lft_heading">Country Name <span class="red"> *</span></div>
					<div class="rgt_detail">
						<select name="country_id" id="country_id">
							<option value="">Select Country</option>
							<?php
							foreach($countries as $country_record){?>
              <option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id==$country)?'selected':''; ?>><?php echo $country_record->country_name; ?></option>
							<?php }?>
						</select>
					</div>					
				</div><?php */ ?>
				<div class="row">
					<div class="lft_heading">State Name <span class="red"> *</span></div>
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
				<?php /* ?>
				<div class="row">
					<div class="lft_heading">City Name <span class="red"> *</span></div>
					<div class="rgt_detail">
						<select name="city_id" id="city_id">
							<option value="">Select State</option>
							<?php
							foreach($city as $city_record){?>
							<option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id==$city)?'selected':''; ?>><?php echo $city_record->city_name; ?></option>
							<?php }?>
						</select>
					</div>					
				</div><?php */ ?>
				<div class="row">
					<div class="lft_heading">Sales Person Name <span class="red"> *</span></div>
					<div class="rgt_detail">
						<input maxlength="50" type="text" name="sales_person_name" id="sales_person_name" class="longinput html_found" value="<?php echo $sales_person_name?>" />
						<?php /*if(isset($city_exists)) {?>
						<label class="error" id="cname"><?php echo $city_exists;?> is already in use</label>
						<?php }*/ ?>
					</div>					
				</div>
				<div class="row">
					<div class="lft_heading">Email ID<span class="red"> *</span></div>
					<div class="rgt_detail">
						<input maxlength="100" type="text" name="email_id" id="email_id" class="longinput html_found" value="<?php echo $email_id?>" /><!--onblur="checkEmailExist(jQuery(this).val());"-->
						<span id="message"></span>
						<?php if(form_error('email_id')) {?>
						<label for="email_id" generated="true" class="error">Please enter valid email</label>
						<?php echo form_error('email_id');}
						/*if(!empty($email_exists)) {?>
						<label for="email_id" generated="true" class="error"><?php echo $email_exists;?></label>
						<?php } */ ?>
					</div>
				</div>
				<div class="row">
					<div class="lft_heading">Contact No. <span class="red"> *</span></div>
					<div class="rgt_detail">
						<input maxlength="15" type="text" name="mobile_no" id="mobile_no" maxlength="10" onkeypress="return isNumberKey(event);" class="longinput html_found" value="<?php echo $mobile_no?>" />
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
					<input type="submit"  name="addedit" id="addedit" class="button_grey" value="<?php echo ($id)?'Update':'Submit'?>">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
				</div>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
</section>

<script>
jQuery(document).ready(function(){
	jQuery('.html_found').change(function() {
	   if (jQuery(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
		  alert('Invalid html content found');
		  jQuery(this).focus();
		  jQuery(this).val('');
	   }
	});
	jQuery("#city").validate({
		rules: {
				/*name: {
					alphanumeric: true,
					required: true,
					remote: {
						url: "/superadmin/city/uniqueCity",
						type: "post",
						data: {
							name: function() {
								return jQuery( "#name" ).val();
							},
							state_id: function() {
								return jQuery( "#state_id" ).val();
							},
							id: function() {
								return jQuery( "#id" ).val();
							}
						}
					}
				},*/
			//country_id: "required",
			state_id: "required",
			//city_id: "required",
			sales_person_name: "required",
			mobile_no: {
				required: true,
				number: true
			},
			email_id: {
			  required: true,
			  email: true
			}
		},
		messages: {
			
			/*country_id: {
				required: "Please select country"
			},*/
			state_id: {
				required: "Please select state"
			},
			/*city_id: {
				required: "Please select city"
			},*/
			sales_person_name: {
				required: "Please enter sales person name"
			},
			email_id:{
				required:"Please enter email",
				email:"Please enter valid email",
			} ,
			mobile_no:{
				required: "Please enter contact number",
				number: "Please enter valid contact number"
			},
		}
	});
		
			jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\\-\s]+$/i.test(value);
    }, "Name must contain only letters, numbers, or dashes.");
});	
/*
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
	});	*/
</script>
