<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>	
<section class="body_main1">	
		<div class="row">		
			<a href="<?php echo base_url().'superadmin/rolepage/rolepage'?>" class="button_grey"> Role Page List</a>
		</div>
		<div class="box-head">
			Manage Role-Page
			</div>
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			
			
			<?php
			$rolepage_id = ($this->uri->segment(4)=='' ||  $this->uri->segment(4)=='0')? '0' : $this->uri->segment(4) ;
			
			?>
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form enctype="multipart/form-data" method="post" class="stdform" id="rolepage" name="add_data_view" accept-charset="utf-8" action="/superadmin/rolepage/saverolepage" autocomplete="off">	
					
					<input type="hidden" name="rolepage_id" value="<?php echo $rolepage_id;?>" />
					
						<div class="row">
							<div class="lft_heading">Roles<span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="role_id">
								<option value="">Select Role</option>
								<?php
								
								foreach($roles as $role)
								{
								?>
									<option value="<?php echo $role->role_id;?>" <?php if($role->role_id==$pagerole['role_id']){echo 'selected';}?>><?php echo $role->name;?></option>
								<?php	
								}
								?>
							</select>
							</div>	
						</div>	
						
						<div class="row">
							<div class="lft_heading">Pages<span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="page_id">
								
								
							</select>
							</div>	
						</div>	
					   
						<div class="row">
							<div class="lft_heading">Status<span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="status">
								<option value="1" <?php if($pagerole['status']==1)echo 'selected';?>>Active</option>
								<option value="0" <?php if($pagerole['status']==0)echo 'selected';?>>Inactive</option>
							</select>
							</div>	
						</div>	
						<hr>
						<div class="stdformbutton row" style="text-align:center;">		
						    <a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>			
							<input type="submit"  class="button_grey" name="addedit" id="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
						</div>
						
					</form>
				</div>
			</div><!--contentwrapper-->
		<br clear="all" />
	</div><!-- centercontent -->
</section>


<script>
jQuery(document).ready(function(){
$("#document").validate({
						 
	// Specify the validation rules					
	rules: {
		name:"required",
		jda_role: "required",
	},
	
	// Specify the validation error messages
	messages: {
		name:"This field is mandatory",
		jda_role: "This field is mandatory",
	},					
	submitHandler: function(form) {//return false;						
		if ($(form).valid())
		{		
			form.submit(); 				
		}
		return false;
		
	},
	errorPlacement: function(error, element) {
		if (element.attr("name") == "name" )
			error.appendTo('#name_err');
		if (element.attr("name") == "jda_role" )
			error.appendTo('#jda_role_err');
	},
	onkeyup: false
	/*,
	onfocusout: false,
	onclick: false
	*/

	
	});
});	
</script>
