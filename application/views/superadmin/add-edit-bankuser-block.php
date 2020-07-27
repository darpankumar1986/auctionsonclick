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
			<a href="<?php echo base_url().'superadmin/user/bankuserblock'?>" class="button_grey">Blocked Banker List</a>
		</div>
		<div class="box-head">Block/Unblock Banker</div>
		<div class="centercontent">
			<div class="pageheader">
				<?php /* ?><h1 class="pagetitle"><?php echo $heading; ?></h1><?php */ ?>
				<span class="pagedesc"><div style="color:red">
				<?php echo $this->session->flashdata('msg'); ?>
				<?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form enctype="multipart/form-data" method="post" class="stdform" id="user" name="add_data_view" accept-charset="utf-8" action="/superadmin/user/saveBankuser_block">
						
						<div class="row">
							<div class="lft_heading">Comment (To be mailed)<span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="150" type="text" name="comment" id="comment" maxlength="10" class="longinput" value="" />
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
	jQuery("#user").validate({
		rules: {
               role:{
                        required:true
                        },
			user_type: "required",
			comment: "required",
			name: "required",
			email_id: {
					  required: true,
					  email: true
					},
			password: "required",
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
			comment: "Please provide comment",
			email_id:{
				required:"Please enter email",
				email:"Please enter vailid email",
			} ,
			password: "Please enter password",
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
</script>
