<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<script>
	function getZone(bank_id){
	jQuery('#zone').load('/superadmin/bank_zone/ajax_zone/'+bank_id);
	
	}
	function getRegion(zone_id){
	jQuery('#region').load('/superadmin/bank_region/ajax_region/'+zone_id);
	
	}
	function getBranch(region_id){
	jQuery('#branch').load('/superadmin/bank_branch/ajax_branch/'+region_id);
	
	}
	function hideForIndivisual(register_as)
	{
		if(register_as=='Individual')
		{
			jQuery('#fororganisation').hide();
		}
		else
		{
			jQuery('#fororganisation').show();
		}
			
	}
	function changePanForm(){      
        if(jQuery("input[name=document_type]:checked").val()=='pan')
		{
			jQuery('#forpan').show();
			jQuery('#forform16').hide();
		}
		else
		{
			jQuery('#forpan').hide();
			jQuery('#forform16').show();
		}
    }
</script>
<?php 
if($row){
	$id=$row->id; 
	$register_as=$row->register_as; 
	$first_name=$row->first_name; 
	$last_name=$row->last_name; 
	$designation=$row->designation; 
	$mobile_no=$row->mobile_no; 
	$father_name=$row->father_name; 
	$email_id=$row->email_id; 
	$user_id=$row->user_id; 
	$address1=$row->address1;
	$address2=$row->address2; 
	$country=$row->country_id; 
	$state=$row->state_id; 
	$city=$row->city_id; 
	$zip=$row->zip; 
	$document_type=$row->document_type; 
	$document_no=$row->document_no; 
	$organisation_name=$row->organisation_name; 
	$authorized_person=$row->authorized_person; 
	$password=$row->password; 
	$fax = $row->fax;
	$indate=$row->indate; 
	$status=$row->status; 
	$created_by=$row->created_by;

}
else{
	$status = 1;
	$id = 0;
}
?> 
<div class="centercontent">
	<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="b2c" name="add_data_view" accept-charset="utf-8" action="/superadmin/user/save">
				<input name="user_type" type="hidden" value="b2c"/>
				
				<p>
					<label>Register As<font color='red'>*</font></label>
					<span class="field">
						<select name="register_as" id="register_as" onchange="hideForIndivisual(jQuery(this).val())">
							<option value="">Select Role</option>
							<option value="Organization" <?php echo ($register_as=='Organization')?'selected':''; ?>>Organization</option>
							<option value="Individual" <?php echo ($register_as=='Individual')?'selected':''; ?>>Individual</option>
						</select>
					</span>					
				</p>
				
				<p>
					<label>Email<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="email_id" id="email_id" class="longinput" value="<?php echo $email_id?>" onblur="jQuery('#user_id').val(jQuery(this).val())" />
					</span>
				</p>
				<p>
					<label>User ID<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="user_id" id="user_id" class="longinput" value="<?php echo $user_id?>" readonly />
					</span>
				</p>
				
				<p>
					<label>Password<font color='red'>*</font></label>
					<span class="field">
						<input type="password" name="password" id="password" class="longinput password" value="<?php echo $password?>" />
					</span>
				</p>
				
				<!--<p>
					<label>Confirm Password<font color='red'>*</font></label>
					<span class="field">
						<input type="password" name="cpassword" id="cpassword" class="longinput" value="<?php echo $password?>" />
					</span>
				</p>-->
				<p>
					<label>First Name<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="first_name" id="first_name" class="longinput" value="<?php echo $first_name?>" />
					</span>					
				</p>
				<p>
					<label>Last Name<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="last_name" id="last_name" class="longinput" value="<?php echo $last_name?>" />
					</span>					
				</p>
				<p>
					<label>Father's/Husband's Name<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="father_name" id="father_name" class="longinput" value="<?php echo $last_name?>" />
					</span>					
				</p>
				<p>
					<label>Address 1<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="address1" id="address1" class="longinput" value="<?php echo $last_name?>" />
					</span>					
				</p>
				<p>
					<label>Address 2</label>
					<span class="field">
						<input type="text" name="address2" id="address2" class="longinput" value="<?php echo $last_name?>" />
					</span>					
				</p>
				<p>
					<label>Country<font color='red'>*</font></label>
					<span class="field">
						<select name="country_id" id="country_id">
							<option value="">Select country</option>
							<?php
							foreach($countries as $country_record){?>
              <option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id==$country)?'selected':''; ?>><?php echo $country_record->country_name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>
				<p>
					<label>State<font color='red'>*</font></label>
					<span class="field">
						<select name="state_id" id="state_id">
							<option value="">Select state</option>
							<?php
							foreach($states as $state_record){?>
              <option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id==$state)?'selected':''; ?>><?php echo $state_record->state_name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>
				
				<p>
					<label>City<font color='red'>*</font></label>
					<span class="field">
						<select name="city_id" id="city_id">
							<option value="">Select city</option>
							<?php
							foreach($cities as $city_record){?>
              <option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id==$city)?'selected':''; ?>><?php echo $city_record->city_name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>
				<p>
					<label>Pin/Zip<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="zip" id="zip" class="longinput" value="<?php echo $zip?>" />
					</span>					
				</p>
				<p>
					<label>PAN/FORM-16 Details<font color='red'>*</font></label>
					<span class="field">
						PAN No<input type="radio" name="document_type"  class="longinput" value="pan" onclick="changePanForm()" <?php echo ($document_type=='pan')?'checked':''?> onclick=""/>
						FORM-16 <input type="radio" name="document_type"  class="longinput" value="form16" onclick="changePanForm()" <?php echo ($document_type=='form16')?'checked':''?> />
					</span>					
				</p>
				<p id="forpan" style="display:none">
					<label>PAN No.</label>
					<span class="field">
						<input type="text" name="document_pan" id="document_pan" class="longinput" value="<?php echo $document_no?>" />
					</span>					
				</p>
				<p id="forform16" style="display:none">
					<label>Upload FORM-16</label>
					<span class="field">
						<input type="file" name="document_form16" id="document_form"/>
						<input type="hidden" name="document_form16_old"  value="<?php echo $document_no?>" />
					</span>					
				</p>
				<div id="fororganisation">
				<p>
					<label>Organization Name</label>
					<span class="field">
						<input type="text" name="organisation_name" id="organisation_name" class="longinput" value="<?php echo $organisation_name?>" />
					</span>					
				</p>
				<p>
					<label>Authorized Person</label>
					<span class="field">
						<input type="text" name="authorized_person" id="authorized_person" class="longinput" value="<?php echo $authorized_person?>" />
					</span>					
				</p>
				
				<p>
					<label>Designation</label>
					<span class="field">
						<input type="text" name="designation" id="designation" class="longinput" value="<?php echo $designation?>" />
					</span>					
				</p>
				</div>
				<p>
					<label>Mobile No<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="mobile_no" id="mobile_no" class="longinput" value="<?php echo $mobile_no?>" />
					</span>					
				</p>
				<p>
					<label>Fax</label>
					<span class="field">
						<input type="text" name="fax" id="fax" class="longinput" value="<?php echo $fax?>" />
					</span>					
				</p>
				<p>
					<label>Status</label>
					<span class="field">
					<select name="status">
						<option value="1" <?php if($status==1)echo 'selected';?>>Active</option>
						<option value="0" <?php if($status==0)echo 'selected';?>>Inactive</option>
					</select>
					</span>
				</p>	
				
				<p class="stdformbutton">					
					<input type="submit"  name="addedit" id="addedit" value="Submit">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
<?php echo "<script> hideForIndivisual('$register_as');</script>";	?>
<script>
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
jQuery(document).ready(function(){
	jQuery("#b2c").validate({
		rules: {
			email_id: "required",
			password: "required",
			register_as: "required",
			user_id: "required",
			first_name: "required",
			last_name: "required",
			father_name: "required",
			address1: "required",
			country_id: "required",
			city_id: "required",
			zip: "required",
			mobile_no: "required",
			state_id: "required"
		},
		messages: {
			name: "Please enter name"
		}
	});
});	
</script>
