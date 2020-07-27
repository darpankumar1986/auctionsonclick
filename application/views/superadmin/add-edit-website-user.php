<?php define('AJAXPATH',site_url().'application/views/superadmin/ajax/'); ?>
<script type="text/javascript" src="<?php echo AJAXPATH; ?>check_email_availability.js"></script>

<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/tinymce/jquery.tinymce.js"></script>


<?php 
if($row){

	$id=$row->id; 
	$full_name=$row->full_name; 
	$display_name=$row->display_name; 
	$email_id=$row->email_id;	
	$gender = $row->gender;
	$dob = $row->dob;	
	$country = $row->country;	
	$city=$row->city; 
	$slug=$row->slug; 
	$priority=$row->priority; 
	$status=$row->status; 
	$date_created = $row->date_created; 
	$date_modified = $row->date_modified;
	
}else{	
	$status = 1;
}
?> 
<div class="centercontent">
	<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="website_user" name="add_data_view" accept-charset="utf-8" action="/superadmin/website_user/save">	
			
				<p>
					<label>Full Name<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="full_name" id="full_name" class="longinput" value="<?php echo $full_name?>" />
						<label class="error" style="display:none;">Please enter Full Name</label>
					</span>					
				</p>
				
				<p>
					<label>Display Name<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="display_name" id="display_name" class="longinput" value="<?php echo $display_name?>" />
						<label class="error" style="display:none;">Please enter Display Name</label>
					</span>					
				</p>
				
				<p>
					<label>E-Mail<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="email_id" id="email_id" class="longinput" value="<?php echo $email_id?>"/>						 
						<label class="error" style="display:none;">Please enter E-Mail</label>
					</span>					
				</p>				
				
				<p>
					<label>Gender</label>
					<span class="field">
						<select name="gender" id="gender">
							<option value="">Select Gender</option>							
							<option value='Male' <?php if($gender=='Male' || $gender=='male') echo "selected='selected'"; ?> />Male</option>
							<option value='Female' <?php if($gender=='Female' || $gender=='female') echo "selected='selected'"; ?> />Female</option>
						</select>
					</span>					
				</p>
				
				<p>
					<label>Date of Birth</label>
					<span class="field">
						<input id="dob" name="dob" class="width100" type="text" value="<?php echo $dob?>">
					</span>
				</p>
				
				<p>
					<label>Country</label>
					<span class="field">
						<input type="text" name="country" id="country" class="longinput" value="<?php echo $country?>" />
						<label class="error" style="display:none;">Please enter Country</label>
					</span>					
				</p>
				
				<p>
					<label>City</label>
					<span class="field">
						<input type="text" name="city" id="city" class="longinput" value="<?php echo $city?>" />
						<label class="error" style="display:none;">Please enter City</label>
					</span>					
				</p>
				
				<p>
					<label>Status/Publish</label>
					<span class="field">
					<select name="status">
						<option value="1" <?php if($status==1)echo 'selected';?>>Yes</option>
						<option value="0" <?php if($status==0)echo 'selected';?>>No</option>
					</select>
					</span>
				</p>
				
				<p class="stdformbutton">					
					<input type="submit"  name="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
					<input type="hidden" name="id" value="<?php echo $id?>">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->

<script>
jQuery(document).ready(function(){	
	jQuery("#website_user").validate({		
		rules: {
			full_name: "required",
			display_name: "required",
			
			email_id: {
                required: true,
                email: true,
				remote: {
					url: "/superadmin/website_user/uniqueUser",
					type: "post",
					data: {
						email_id: function() {
							return jQuery( "#email_id" ).val();
						}						
					}
				}
            }
			
		},
		messages: {
			full_name: "Please enter full name",
			display_name: "Please enter display name",
			email_id:{
			    email_id: "Please enter Email Address..!",
				email: "Please enter a valid email address..!",
				remote: jQuery.validator.format("{0} is already in use")
			}
			
		}
	});
	
	jQuery("#dob" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '1910:'
	});
	
});	
</script>


