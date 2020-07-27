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
	$bank=$row->bank_id; 
	$first_name=$row->first_name; 
	$last_name=$row->last_name; 
	$designation=$row->designation; 
	$mobile_no=$row->mobile_no; 
	$role=$row->role; 
	$email_id=$row->email_id; 
	$user_id=$row->user_id;	
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
			<a href="<?php echo base_url().'superadmin/user/bankeradmin'?>" class="button_grey">Organization Admin List</a>
		</div>
		<div class="box-head">Create Organization Admin</div>
		<div class="centercontent">
			<div class="pageheader">
				<?php /* ?><h1 class="pagetitle"><?php echo $heading; ?></h1><?php */ ?>
				<span class="pagedesc"><div style="color:red">
				<?php echo $this->session->flashdata('msg'); ?>
				<?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form enctype="multipart/form-data" method="post" class="stdform" id="user" name="add_data_view" accept-charset="utf-8" action="/superadmin/user/saveBankadmin" autocomplete="off">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
						<div id="forbranchuser1">
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
						</div>
						<div class="row">
							<div class="lft_heading">First Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="75" type="text" name="first_name" id="first_name" class="longinput html_found" value="<?php echo $first_name?>" />
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Last Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="75" type="text" name="last_name" id="last_name" class="longinput" value="<?php echo $last_name?>" />
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Designation <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input type="text" maxlength="50" name="designation" id="designation" class="longinput html_found" value="<?php echo $designation?>" />
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Mobile /Phone No. <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="15" type="text" name="mobile_no" id="mobile_no" maxlength="10" onkeypress="return isNumberKey(event);" class="longinput html_found" value="<?php echo $mobile_no?>" />
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">E-Mail ID <span class="red"> *</span></div>
							<div class="rgt_detail">
								<!--<input type="text" name="email_id" id="email_id" class="longinput" value="<?php echo $email_id?>" onblur="checkEmailExist(jQuery(this).val());"/>-->
								<input maxlength="100" type="text" name="email_id" id="email_id" class="longinput html_found" value="<?php echo $email_id?>"/>
								
							</div>
						</div>
						<?php /* ?>
						<div class="row" id="userid">
							<div class="lft_heading">User ID <span class="red"> *</span> </div>
							<div class="rgt_detail">
								<input  maxlength="100" type="text" name="user_id" id="user_id" placeholder="Userid will be auto generate" class="longinput" value="<?php echo $user_id?>" <?php if(!$id){ echo "disabled"; }else{ echo ''; }; ?>/>
							</div>
						</div>
						<?php */ ?>
						
						<div class="row" id="userid">
							<div class="lft_heading">User ID <span class="red"> *</span> </div>
							<div class="rgt_detail">
								<input  maxlength="100" type="text" name="user_id" id="user_id" placeholder="" class="longinput alphanumeric1 html_found" value="<?php echo $user_id?>" onblur="checkUserIdExist(jQuery(this).val());"/>
								<span id="message"></span>
							</div>
						</div>
						
						
						<?php if($password==''){ ?>
						<div class="row">
							<div class="lft_heading">Password <span class="red"> *</span></div>
							<div class="rgt_detail">
						            <input maxlength="100" type="password" name="password" id="password" class=" longinput password" value="<?php echo $password?>" />
							</div>
						</div>
                                                <?php } ?>
						<?php if($password==''){?>
						<div class="row">
							<div class="lft_heading">Confirm Password<span class="red"> *</span></div>
							<div class="rgt_detail">
								<input type="password" name="cpassword" id="cpassword" class="longinput" value="" class="longinput password html_found"/>
							</div>
						</div>
						<?php } ?>
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
    
    function checkUserIdExist(userId)
{
	if(userId)
	{
		jQuery.ajax({
			url: '/superadmin/user/checkduplicateuseridexistsadmin',
			type: 'POST',
			data: 'user_id='+userId,
			success: function(data) {
				//called when successful
				if(data=='0')
				{
					jQuery('#message').removeClass('error');
					jQuery('#user_id').val(userId);
					//jQuery('#message').html('<div style="color:green;">OK</div>');
				}
				else
				{
					
					jQuery('#user_id').val('');
					jQuery('#message').addClass('error');
					jQuery('#message').html('<div style="color:red;">User ID "'+userId+'" already exist.</div>');
				}
				
			}
		});	
		
	}
	else 
	{
		return false;
	}
	
}

jQuery(document).ready(function(){
	jQuery('.html_found').change(function() {
	   if (jQuery(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
		  alert('Invalid html content found');
		  jQuery(this).focus();
		  jQuery(this).val('');
	   }
	});
	/*
    $("#user_id").on("keydown", function(e) {
		display("e.currentTarget.readOnly: " + e.currentTarget.readOnly);
	})*/;
	jQuery("#user").validate({
		rules: {
               role:{
                       required:true
                    },
			branch_bank: "required",
			name: "required",
			user_id: "required",
			email_id: {
					  required: true,
					  email: true
					},
			password: "required",
			first_name: "required",
			last_name: "required",
			designation: "required",
			<?php if($password == ''){?>
			cpassword: {
				  equalTo: "#password"
				},
			
			<?php } ?>
			mobile_no: {
					required: true,
					number: true
			}
		},
		messages: {
			name: "Please enter name",
			branch_bank: "Please select bank",
			email_id:{
				required:"Please enter email",
				email:"Please enter vailid email",
			} ,
			password: "Please enter password",
			user_id: "Please enter User id",
			first_name: "Please enter first name",
			last_name: "Please enter last name",
			designation: "Please enter designation",
			mobile_no:{
				required: "Please enter mobile number",
				number: "Please enter valid mobile number"
			},
		}
	});
});
function checkEmailExist(email)
{
	if(email)
	{
		jQuery.ajax({
			url: '/superadmin/user/checkDuplicateEmail',
			type: 'POST',
			data: 'email='+email,
			success: function(data) {
				//called when successful
				if(data=='0')
				{
					jQuery('#message').removeClass('error');
					jQuery('#user_id').val(email);
					//jQuery('#message').html('<div style="color:green;">OK</div>');
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

jQuery(document).ready(function(){
     jQuery('.alphanumeric1').bind('keypress', function (event) 
     {
		 
		 if (event.keyCode == 32) { 
		   event.preventDefault();
		   return false; // return false to prevent space from being added
		 }	
	});
  });
</script>
