<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<script>
	function getZone(bank_id) {
		jQuery('#zone').load('/superadmin/bank_zone/ajax_zone/'+bank_id);
	}
	function getLho(bank_id) {
		jQuery('#lho').load('/superadmin/bank_lho/ajax_lho/'+bank_id);
	}
	function getRegion(zone_id){
	jQuery('#region').load('/superadmin/bank_region/ajax_region/'+zone_id);
	
	}
	function getBranch(region_id){
		jQuery('#branch').load('/superadmin/bank_branch/ajax_branch/'+region_id);
	}
	function formAccording(user_type){
		if(user_type=='branch')
		{
			jQuery('#forbranchuser1').show();
			jQuery('#forregionuser1').hide();
			jQuery('#forzoneuser1').hide();
			jQuery('#fordrtuser1').hide();
			jQuery('#forsalesuser1').hide();
			jQuery('#user_cat').show();
			jQuery('#userid').show();
		}
		if(user_type=='region')
		{
			jQuery('#forbranchuser1').hide();
			jQuery('#forregionuser1').show();
			jQuery('#forzoneuser1').hide();
			jQuery('#fordrtuser1').hide();
			jQuery('#forsalesuser1').hide();
			jQuery('#user_cat').show();
			jQuery('#userid').show();
		}
		if(user_type=='zone')
		{
			jQuery('#forbranchuser1').hide();
			jQuery('#forregionuser1').hide();
			jQuery('#forzoneuser1').show();
			jQuery('#fordrtuser1').hide();
			jQuery('#forsalesuser1').hide();
			jQuery('#user_cat').show();
			jQuery('#userid').show();
		}
		if(user_type=='drt')
		{
			jQuery('#forbranchuser1').hide();
			jQuery('#forregionuser1').hide();
			jQuery('#forzoneuser1').hide();
			jQuery('#fordrtuser1').show();
			jQuery('#forsalesuser1').hide();
			jQuery('#user_cat').show();
			jQuery('#userid').show();
		}
		if(user_type=='helpdesk_admin')
		{
			jQuery('#forbranchuser1').hide();
			jQuery('#forregionuser1').hide();
			jQuery('#forzoneuser1').hide();
			jQuery('#fordrtuser1').hide();
			jQuery('#forsalesuser1').hide();
			jQuery('#user_cat').hide();
			jQuery('#userid').hide();
		}
		if(user_type=='helpdesk_ex')
		{
			jQuery('#forbranchuser1').hide();
			jQuery('#forregionuser1').hide();
			jQuery('#forzoneuser1').hide();
			jQuery('#fordrtuser1').hide();
			jQuery('#forsalesuser1').hide();
			jQuery('#user_cat').hide();
			jQuery('#userid').hide();
		}
		if(user_type=='sales')
		{
			jQuery('#forbranchuser1').hide();
			jQuery('#forregionuser1').hide();
			jQuery('#forzoneuser1').hide();
			jQuery('#fordrtuser1').hide();
			jQuery('#forsalesuser1').show();
			//jQuery('#user_cat').hide();
			jQuery('#sales_user_type_id').prop('required',true);
			jQuery('#userid').hide();
		}
		
		if(user_type=='sales_coordinator')
		{
			jQuery('#forbranchuser1').hide();
			jQuery('#forregionuser1').hide();
			jQuery('#forzoneuser1').hide();
			jQuery('#fordrtuser1').hide();
			jQuery('#forsalesuser1').show();
			//jQuery('#user_cat').hide();
			jQuery('#sales_user_type_id').prop('required',true);;
			jQuery('#userid').hide();
		}
		
		if(user_type=='account')
		{
			jQuery('#forbranchuser1').hide();
			jQuery('#forregionuser1').hide();
			jQuery('#forzoneuser1').hide();
			jQuery('#fordrtuser1').hide();
			jQuery('#forsalesuser1').hide();
			//jQuery('#user_cat').hide();
			//jQuery('#sales_user_type_id').prop('required',true);;
			jQuery('#userid').hide();
		}
		if(user_type=='mis')
		{
			jQuery('#forbranchuser1').hide();
			jQuery('#forregionuser1').hide();
			jQuery('#forzoneuser1').hide();
			jQuery('#fordrtuser1').hide();
			jQuery('#forsalesuser1').hide();
			//jQuery('#user_cat').hide();
			//jQuery('#sales_user_type_id').prop('required',true);;
			jQuery('#userid').hide();
		}
		if(user_type=='owner' || user_type=='builder' || user_type=='broker' )
		{
		jQuery('#userid').hide();
		}
		
		
	
	}
</script>
<?php 
if($row){
	$id=$row->id; 
	$first_name=$row->first_name; 
	$last_name=$row->last_name; 
	$designation=$row->designation; 
	$mobile_no=$row->mobile_no; 
	$role=$row->role; 
	$email_id=$row->email_id; 
	$user_id=$row->user_id; 
	$bank=$row->bank_id; 
	$c1zone_id=$row->c1zone_id; 
	$zone=$row->zone_id;  
	$lho=$row->lho_id;  
	$region=$row->region_id;  
	$user_type=$row->user_type;
	$user_type_id=$row->user_type_id; 
	$password=$row->password; 
	$role = $row->role;
	$indate=$row->indate; 
	$status=$row->status; 
	$created_by=$row->created_by;

} else {
	$status = 1;
	$id = 0;
	$role = 1;
	extract($_POST);
}
?>
<section class="body_main1">	
		<div class="row">						
			<a href="/superadmin/user/index" class="button_grey">Sales User List</a>
		</div>
		<div class="box-head">Create Sales Coordinator/Executive User</div>
		<div class="centercontent">
			<div class="pageheader">
				
				<span class="pagedesc"><div style="color:red">
				<?php echo $this->session->flashdata('msg'); ?>
				<?php //echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form enctype="multipart/form-data" method="post" class="stdform" id="user" name="add_data_view" accept-charset="utf-8" action="/superadmin/user/save" autocomplete="off">	
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
						<div class="row">
							<div class="lft_heading">User Type <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select name="user_type" id="user_type" 
								onchange="formAccording(jQuery(this).val())">
									<option value="">Select Type</option>
									
									<option value="sales_cordinator" <?php echo ($user_type=='sales_cordinator')?'selected':''; ?>>Sales Coordinator</option>
									<option value="sales" <?php echo ($user_type=='sales')?'selected':''; ?>>Sales Executive</option>
									<?php /* ?>
									<option value="helpdesk_admin" <?php echo ($user_type=='helpdesk_admin')?'selected':''; ?>>Helpdesk Admin</option>
									<option value="helpdesk_ex" <?php echo ($user_type=='helpdesk_ex')?'selected':''; ?>>Helpdesk Executive</option>
									<option value="account" <?php echo ($user_type=='account')?'selected':''; ?>>Account</option>
									<option value="mis" <?php echo ($user_type=='mis')?'selected':''; ?>>MIS</option>
									<option value="owner" <?php echo ($user_type=='owner')?'selected':''; ?>>Owner</option>
									<option value="broker" <?php echo ($user_type=='broker')?'selected':''; ?>>Broker</option>
									<option value="builder" <?php echo ($user_type=='builder')?'selected':''; ?>>Builder</option>
									<?php */ ?>
								</select>
							</div>					
						</div>
						
						<div id="forsalesuser1">
							<div class="row">
								<div class="lft_heading">C1 Zone</div>
								<div class="rgt_detail">
									<select name="c1zone_user_type_id" id="sales_user_type_id">
										<!--<option value="">Select </option>-->
										<?php
										foreach($c1zones as $c1zones_record){?>
                                                                            <option value="<?php echo $c1zones_record->id; ?>" <?php echo ($c1zones_record->id==$c1zone_id)?'selected':''; ?>><?php echo $c1zones_record->name; ?></option>
										<?php }?>
									</select>
								</div>					
							</div>
						
						</div>
						<div id="user_cat row">
							<div class="lft_heading">User Category</div>
							<div class="rgt_detail">
								<select name="role" id="role">
									<!--<option value="">Select </option>-->
									<option value="1" <?php echo (1 == $role)?'selected':''; ?>>Admin</option>
									<!--<option value="0" <?php echo (0 == $role)?'selected':''; ?>>Viewer</option>-->
						
								</select>
							</div>					
						</div>
						
						<div class="row">
							<div class="lft_heading">Email ID<span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="email_id" id="email_id" class="longinput html_found" value="<?php echo $email_id?>" onblur="checkEmailExist(jQuery(this).val());"/>
								<span id="message"></span>
								<?php if(form_error('email_id')) {?>
								<label for="email_id" generated="true" class="error">Please enter valid email</label>
								<?php echo form_error('email_id');}
								if(!empty($email_exists)) {?>
								<label for="email_id" generated="true" class="error"><?php echo $email_exists;?></label>
								<?php }?>
							</div>
						</div>
					
						<?php if($password==''){ ?>
						<div class="row">
							<div class="lft_heading">Password <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="password" name="password" id="password" class=" longinput password html_found" value="<?php echo $password?>" />
							</div>
						</div>
                                                <?php } ?>
						
						<!--<p>
							<label>Confirm Password</label>
							<span class="field">
								<input type="password" name="cpassword" id="cpassword" class="longinput" value="<?php echo $password?>" />
							</span>
						</p>-->
						<div class="row">
							<div class="lft_heading">First Name<span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="75" type="text" name="first_name" id="first_name" class="longinput html_found" value="<?php echo $first_name?>" />
								<?php if(form_error('first_name')) {?>
								<label for="email_id" generated="true" class="error">Please enter first name</label>
								<?php }?>
						
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Last Name<span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="75" type="text" name="last_name" id="last_name" class="longinput html_found" value="<?php echo $last_name?>" />
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Designation<span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="50" type="text" name="designation" id="designation" class="longinput html_found" value="<?php echo $designation?>" />
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Mobile/Phone No. <span class="red"> *</span></div>
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
							<input type="submit"  name="addedit" id="addedit" value="<?php echo ($id)?'Update':'Submit'?>" class="button_grey">
							<input type="hidden" name="id" id="id" value="<?php echo $id?>">
						</div>
						
					</form>
				</div>
			</div><!--contentwrapper-->
			<br clear="all" />
		</div><!-- centercontent -->
</section>
<?php echo "<script> formAccording('$user_type');</script>";	?>

<script>
 function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        console.log(charCode);
        if (charCode != 46 && charCode != 45 && charCode > 31
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
	jQuery("#user").validate({
		rules: {
               role:{
                        required:true
                        },
			user_type: "required",
			name: "required",
			email_id: {
					  required: true,
					  email: true
					},
			password: {
					required: true,
					pwcheck: true,
					minlength: 6
			},
			first_name: "required",
			last_name: "required",
			designation: "required",
			mobile_no: {
					required: true,
					number: true
			}
		},
		messages: {
			name: "Please enter name",
			user_type: "Please select user type",
			email_id:{
				required:"Please enter email",
				email:"Please enter valid email",
			} ,
			password: {
						required: "Please enter password",
						pwcheck: "Must contain at least one lower-case character and one digit!",
						minlength: "Minimum 6 password length"
					},
			first_name: "Please enter first name",
			last_name: "Please enter last name",
			designation: "Please enter designation",
			mobile_no:{
				required: "Please enter mobile number",
				number: "Please enter valid mobile number"
			},
			role: "Please select category",
		}
	});
	jQuery.validator.addMethod("pwcheck", function(value) {
			   return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
				   && /[a-z]/.test(value) // has a lowercase letter
				   && /\d/.test(value) // has a digit
			});
});	
function checkEmailExist(email)
{
	if(email)
	{
		checkEmail(email);
		jQuery.ajax({
			url: '/superadmin/user/checkDuplicateEmail',
			type: 'POST',
			data: 'email='+email+'&id='+'<?php echo @$id;?>',
			success: function(data) {
				//called when successful
				if(data=='0')
				{
					jQuery('#message').html('');
					//jQuery('#user_id').val(email);
					//jQuery('#message').html('<div style="color:green;">OK</div>');
				}
				else
				{
					//jQuery('#email_id').val('');
					jQuery('#message').addClass('error');
					jQuery('#message').html('<div style="color:red;"> Email "'+email+'" already exist.</div>');
				}
				
			}
		});	
		
	}
	else 
	{
		return false;
	}
	
}

function checkEmail(email) {
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(email)) {
		return false;
	}else{
		return false;	
	}
}
</script>
