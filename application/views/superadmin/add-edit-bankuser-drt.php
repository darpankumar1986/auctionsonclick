<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<script>
	function getZone(bank_id){
	jQuery('#zone').load('/superadmin/bank_zone/ajax_zone/'+bank_id);
	
	}
	function getLho(bank_id){
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
	$zone=$row->zone_id;  
	$lho=$row->lho_id;  
	$region=$row->region_id;  
	$user_type=$row->user_type;
	$user_type_id=$row->user_type_id; 
	$password=$row->password; 
	$indate=$row->indate; 
	$status=$row->status; 
	$created_by=$row->created_by;

}
else{
	$status = 1;
	$id = 0;
}
?> 
<section class="body_main1">
		<div class="row">						
			<a href="<?php echo base_url().'superadmin/user/bankerdrt'?>" class="button_grey">DRT User List</a>
		</div>
		<div class="box-head">Create DRT User</div>
		<div class="centercontent">
			<div class="pageheader">
				<?php /* ?><h1 class="pagetitle"><?php echo $heading; ?></h1><?php */ ?>
				<span class="pagedesc"><div style="color:red">
				<?php echo $this->session->flashdata('msg'); ?>
				<?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form enctype="multipart/form-data" method="post" class="stdform" id="user" name="add_data_view" accept-charset="utf-8" action="/superadmin/user/saveBankuserdrt" autocomplete="off">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
						<div class="row">
							<div class="lft_heading">User Type</div>
							<div class="rgt_detail">
								<select name="user_type" id="user_type" 
								onchange="formAccording(jQuery(this).val())">
									<!--<option value="">Select Type</option>-->
									<option value="drt" <?php echo ($user_type=='drt')?'selected':''; ?>>DRT</option>
									
									<?php /* ?>
									<option value="branch" <?php echo ($user_type=='branch')?'selected':''; ?>>Bank Branch</option>
									<option value="region" <?php echo ($user_type=='region')?'selected':''; ?>>Bank Region</option>
									
									<option value="zone" <?php echo ($user_type=='zone')?'selected':''; ?>>Bank Zone</option>
									<?php */ ?>
								</select>
							</div>					
						</div>
						<?php /* ?>
						<div id="forbranchuser1" style="display:none">
								<div class="row">
									<div class="lft_heading">Name of the Organization <span class="red"> *</span></div>
									<div class="rgt_detail">
										<select name="branch_bank" id="bank" onchange="getZone(jQuery(this).val());if(jQuery(this).val()=='30'){jQuery('#lhoforsbi').show();getLho(jQuery(this).val());}else{jQuery('#lhoforsbi').hide();}">
											<option value="">Select Organization</option>
											<?php
											foreach($banks as $bank_record){?>
							  <option value="<?php echo $bank_record->id; ?>" <?php echo ($bank_record->id==$bank)?'selected':''; ?>><?php echo $bank_record->name; ?></option>
											<?php }?>
										</select>
									</div>					
								</div>
								<div class="row" id="lhoforsbi" <?php if($bank != 30){?>style="display:none" <?php }?>>
									<div class="lft_heading">LHO</div>
									<div class="rgt_detail">
										<select name="bank_lho" id="lho" >
											<option value="">Select LHO</option>
											<?php
											foreach($lho as $lho_record){?>
							  <option value="<?php echo $lho_record->id; ?>" <?php echo ($lho_record->id==$lho)?'selected':''; ?>><?php echo $lho_record->name; ?></option>
											<?php }?>
										</select>
									</div>					
								</div>
						
								<div class="row">
									<div class="lft_heading">Zone <span class="red"> *</span></div>
									<div class="rgt_detail">
										<select name="branch_zone" id="zone" onchange="getRegion(jQuery(this).val())">
											<option value="" >Select Zone</option>
											<?php
											foreach($zones as $bzone_record){?>
							  <option value="<?php echo $bzone_record->id; ?>" <?php echo ($bzone_record->id==$zone)?'selected':''; ?>><?php echo $bzone_record->name; ?></option>
											<?php }?>
										</select>
									</div>					
								</div>
								<div class="row">
									<div class="lft_heading">Region <span class="red"> *</span></div>
									<div class="rgt_detail">
										<select name="branch_region" id="region" onchange="getBranch(jQuery(this).val())">
											<option value="">Select Region</option>
											<?php
											foreach($regions as $region_record){?>
							  <option value="<?php echo $region_record->id; ?>" <?php echo ($region_record->id==$region)?'selected':''; ?>><?php echo $region_record->name; ?></option>
											<?php }?>
										</select>
									</div>					
								</div>
								<div class="row">
									<div class="lft_heading">Branch<span class="red"> *</span></div>
									<div class="rgt_detail">
										<select name="branch_user_type_id" id="branch">
											<option value="">Select Bank Branch</option>
											<?php
											foreach($branchs as $branch_record){?>
							  <option value="<?php echo $branch_record->id; ?>" <?php echo ($branch_record->id==$user_type_id)?'selected':''; ?>><?php echo $branch_record->name; ?></option>
											<?php }?>
										</select>
									</div>					
								</div>
						</div>
						
						
						<div id="forregionuser1" style="display:none">
								<div class="row">
									<div class="lft_heading">Name of the Organization <span class="red"> *</span></div>
									<div class="rgt_detail">
										<select name="region_bank" id="bank" onchange="getZone(jQuery(this).val())">
											<option value="">Select Organization</option>
											<?php
											foreach($banks as $bank_record){?>
							  <option value="<?php echo $bank_record->id; ?>" <?php echo ($bank_record->id==$bank)?'selected':''; ?>><?php echo $bank_record->name; ?></option>
											<?php }?>
										</select>
									</div>					
								</div>
								<div class="row" id="lhoforsbi" <?php if($bank != 30){?>style="display:none" <?php }?>>
									<div class="lft_heading">LHO</div>
									<div class="rgt_detail">
										<select name="bank_lho" id="lho" >
											<option value="">Select LHO</option>
											<?php
											foreach($lho as $lho_record){?>
							  <option value="<?php echo $lho_record->id; ?>" <?php echo ($lho_record->id==$lho)?'selected':''; ?>><?php echo $lho_record->name; ?></option>
											<?php }?>
										</select>
									</div>					
								</div>
								<div class="row">
									<div class="lft_heading">Zone <span class="red"> *</span></div>
									<div class="rgt_detail">
										<select name="region_zone" id="zone" onchange="getRegion(jQuery(this).val())">
											<option value="" >Select Zone</option>
											<?php
											foreach($zones as $bzone_record){?>
							  <option value="<?php echo $bzone_record->id; ?>" <?php echo ($bzone_record->id==$zone)?'selected':''; ?>><?php echo $bzone_record->name; ?></option>
											<?php }?>
										</select>
									</div>					
								</div>
								<div class="row">
									<div class="lft_heading">Region <span class="red"> *</span></div>
									<div class="rgt_detail">
										<select name="region_user_type_id" id="region" >
											<option value="">Select Region</option>
											<?php
											foreach($regions as $region_record){?>
							  <option value="<?php echo $region_record->id; ?>" <?php echo ($region_record->id==$user_type_id)?'selected':''; ?>><?php echo $region_record->name; ?></option>
											<?php }?>
										</select>
									</div>					
								</div>
						</div>
						<div id="forzoneuser1" style="display:none">
							<div class="row">
								<div class="lft_heading">Name of the Organization <span class="red"> *</span></div>
								<div class="rgt_detail">
									<select name="zone_bank" id="bank" onchange="getZone(jQuery(this).val())">
										<option value="">Select Organization</option>
										<?php
										foreach($banks as $bank_record){?>
						  <option value="<?php echo $bank_record->id; ?>" <?php echo ($bank_record->id==$bank)?'selected':''; ?>><?php echo $bank_record->name; ?></option>
										<?php }?>
									</select>
								</div>					
							</div>
							<div class="row" id="lhoforsbi" <?php if($bank != 30){?>style="display:none" <?php }?>>
									<div class="lft_heading">LHO</div>
									<div class="rgt_detail">
										<select name="bank_lho" id="lho" >
											<option value="">Select LHO</option>
											<?php
											foreach($lho as $lho_record){?>
							  <option value="<?php echo $lho_record->id; ?>" <?php echo ($lho_record->id==$lho)?'selected':''; ?>><?php echo $lho_record->name; ?></option>
											<?php }?>
										</select>
									</div>					
								</div>
							<div class="row">
								<div class="lft_heading">Zone <span class="red"> *</span></div>
								<div class="rgt_detail">
									<select name="zone_user_type_id" id="zone" >
										<option value="" >Select Zone</option>
										<?php
										foreach($zones as $bzone_record){?>
						  <option value="<?php echo $bzone_record->id; ?>" <?php echo ($bzone_record->id==$user_type_id)?'selected':''; ?>><?php echo $bzone_record->name; ?></option>
										<?php }?>
									</select>
								</div>					
							</div>
						</div>
						
						<?php */ ?>
						
						<div id="fordrtuser1">
									<div class="row">
										<div class="lft_heading">DRT<span class="red"> *</span></div>
										<div class="rgt_detail">
											<select name="drt_user_type_id" id="drt">
												<option value="">Select DRT</option>
												<?php
												foreach($drts as $drts_record){?>
								  <option value="<?php echo $drts_record->id; ?>" <?php echo ($drts_record->id==$user_type_id)?'selected':''; ?>><?php echo $drts_record->name; ?></option>
												<?php }?>
											</select>
										</div>					
									</div>
									<div class="row" id="lhoforsbi" <?php if($bank != 30){?>style="display:none" <?php }?>>
									<div class="lft_heading">LHO</div>
									<div class="rgt_detail">
										<select name="bank_lho" id="lho" >
											<option value="">Select LHO</option>
											<?php
											foreach($lho as $lho_record){?>
							  <option value="<?php echo $lho_record->id; ?>" <?php echo ($lho_record->id==$lho)?'selected':''; ?>><?php echo $lho_record->name; ?></option>
											<?php }?>
										</select>
									</div>					
								</div>
									
						</div>
									<div id="forsalesuser1" style="display:none">
									<div class="row">
										<label>C1 Zone<font color='red'>*</font></label>
										<div class="rgt_detail">
											<select name="c1zone_user_type_id" id="sales_user_type_id">
												<option value="">Select </option>
												<?php
												foreach($c1zones as $c1zones_record){?>
								  <option value="<?php echo $c1zones_record->id; ?>" <?php echo ($c1zones_record->id==$user_type_id)?'selected':''; ?>><?php echo $c1zones_record->name; ?></option>
												<?php }?>
											</select>
										</div>					
									</div>
						</div>
						
						
						
						
						<div class="row" id="user_cat">
							<div class="lft_heading">User Category</div>
							<div class="rgt_detail">
								<select name="role" id="role">
									
									<option value="1" <?php echo ('1' == $role)?'selected':''; ?>>User</option>
									<!--<option value="0" <?php echo ('0' == $role)?'selected':''; ?>>Viewer</option>-->
									
								</select>
							</div>					
						</div>
						
						<div class="row">
							<div class="lft_heading">E-Mail ID <span class="red"> *</span></div>
							<div class="rgt_detail">
								<!--<input type="text" name="email_id" id="email_id" class="longinput" value="<?php echo $email_id?>" onblur="checkEmailExist(jQuery(this).val());"/>-->
								<input maxlength="100" type="text" name="email_id" id="email_id" class="longinput html_found" value="<?php echo $email_id?>"/>
								<span id="message"></span>
							</div>
						</div>
						<?php /* ?>
						<div class="row" id="userid">
							<div class="lft_heading">User ID <span class="red"> *</span> </div>
							<div class="rgt_detail">
								<input  maxlength="100" type="text" name="user_id" id="user_id" placeholder="Userid will be auto generate" class="longinput" value="<?php echo $user_id?>" <?php if(!$id){ echo "readonly"; }else{ echo ''; }; ?>/>
							</div>
						</div>
						<?php */ ?>
						<?php if($password==''){?>
						<div class="row">
							<div class="lft_heading">Password <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="password" name="password" id="password" class=" longinput password html_found" value="<?php echo $password?>" />
							</div>
						</div>
                                                <?php }?>
						
						<?php if($password==''){?>
						<div class="row">
							<div class="lft_heading">Confirm Password<span class="red"> *</span></div>
							<div class="rgt_detail">
								<input type="password" name="cpassword" id="cpassword" class="longinput" value="" class="longinput password html_found"/>
							</div>
						</div>
						<?php } ?>
						<div class="row">
							<div class="lft_heading">First Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="75" type="text" name="first_name" id="first_name" class="longinput html_found" value="<?php echo $first_name?>" />
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Last Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="75" type="text" name="last_name" id="last_name" class="longinput html_found" value="<?php echo $last_name?>" />
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Designation <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input type="text" maxlength="50" name="designation" id="designation" class="longinput html_found" value="<?php echo $designation?>" />
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Mobile Number/Phone No. <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="15" type="text" name="mobile_no" id="mobile_no" maxlength="10" onkeypress="return isNumberKey(event);" class="longinput html_found" value="<?php echo $mobile_no?>" />
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Status <span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="status">
								<option value="1" <?php if($status==1)echo 'selected';?>>Active</option>
								<option value="0" <?php if($status==0)echo 'selected';?>>Inactive</option>
							</select>
							</div>
						</div>	
						
						<div class="stdformbutton row" style="text-align:center;">
							<a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>			
							<input type="submit" class="button_grey" name="addedit" id="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
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
                        
            drt_user_type_id: "required",
			user_type: "required",
			name: "required",
			email_id: {
					  required: true,
					  email: true,
					  remote: {
						    url: "/superadmin/user/uniquecheckDuplicateEmailDRT",
						    type: "get",
						    data: {
							    email_id: function() {
									
								    return jQuery( "#email_id" ).val();
							    },
							    id: function() {
								    return jQuery( "#id" ).val();
							    }
						    }
					    }
					},
			password: {
					required: true,
					pwcheck: true,
					minlength: 6
			},
			<?php if($password == ''){?>
			cpassword: {
				  equalTo: "#password"
				},
			
			<?php } ?>
			first_name: "required",
			last_name: "required",
			designation: "required",
			mobile_no: {
					required: true,
					number: true
			}
		},
		messages: {
			drt_user_type_id: "Please select DRT",
			name: "Please enter name",
			user_type: "Please select user type",
			email_id:{
				required:"Please enter email",
				email:"Please enter vailid email",
				remote: jQuery.validator.format("'{0}' is already in use"),
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
	
	jQuery.validator.addMethod("pwcheck", function(value){
		return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
		   && /[a-z]/.test(value) // has a lowercase letter
		   && /\d/.test(value) // has a digit
	});
});
function checkEmailExist(email)
{
	if(email)
	{
		jQuery.ajax({
			url: '/superadmin/user/checkDuplicateEmailDRT',
			type: 'POST',
			data: 'email='+email,
			success: function(data) {
				//called when successful
				if(data=='0')
				{
					jQuery('#message').removeClass('error');
					jQuery('#user_id').val(email);
					jQuery('#message').html('<div style="color:green;">OK</div>');
				}
				else
				{
					
					jQuery('#email_id').val('');
					jQuery('#message').addClass('error');
					jQuery('#message').html('<div style="color:red;">EmailID "'+email+'" already exist.</div>');
				}
				
			}
		});	
		
	}
	else 
	{
		return false;
	}
	
}
</script>
