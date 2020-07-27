<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>	
<section class="body_main1">	
		<div class="row">		
			<a href="<?php echo base_url().'superadmin/rolepage/main'?>" class="button_grey"> Role List</a>
		</div>
		<div class="box-head"><?php echo $heading; ?></div>
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			
			
			<?php
			$role_id = ($this->uri->segment(4)=='' ||  $this->uri->segment(4)=='0')? '0' : $this->uri->segment(4) ;
			?>
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form enctype="multipart/form-data" method="post" class="stdform" id="role" name="add_data_view" accept-charset="utf-8" action="/superadmin/rolepage/save" autocomplete="off">	
					
					<input type="hidden" name="role_id" value="<?php echo $role_id;?>" />
					
						<div class="row">
							<div class="lft_heading">Role Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="name" id="name" class="longinput html_found" value="<?php echo $role['name'];?>" />
								<label class="error1" id="name_err"></label>	
							
							</div>	
											
						</div>
						
						<div class="row">
							<div class="lft_heading"><?php echo BRAND_NAME; ?>  Role <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="jdarole" id="jdarole" class="longinput html_found" value="<?php echo $role['jda_role'];?>" />
								<label class="error1" id="jdarole_err"></label>	
							
							</div>	
											
						</div>
					   
						<div class="row">
							<div class="lft_heading">Status<span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="status">
								<option value="1" <?php if($role['status']==1)echo 'selected';?>>Active</option>
								<option value="0" <?php if($role['status']==0)echo 'selected';?>>Inactive</option>
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
jQuery("#role").validate({
						 
	// Specify the validation rules					
	rules: {
		name:"required",
		jdarole: "required"
	},
	
	// Specify the validation error messages
	messages: {
		name:"This field is mandatory",
		jdarole: "This field is mandatory"
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
		if (element.attr("name") == "jdarole" )
			error.appendTo('#jdarole_err');
	},
	onkeyup: false
	/*,
	onfocusout: false,
	onclick: false
	*/

	
	});
});	
</script>
