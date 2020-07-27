<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>	
<style>
.radio
{

    opacity: 1!important;
}​

</style>
<section class="body_main1">	
		<div class="row">		
			<a href="<?php echo base_url().'superadmin/rolepage/mainpage'?>" class="button_grey"> Page List</a>
		</div>
		<div class="box-head"><?php echo $heading; ?></div>
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			
			
			<?php
			$page_id = ($this->uri->segment(4)=='' ||  $this->uri->segment(4)=='0')? '0' : $this->uri->segment(4) ;
			?>
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form enctype="multipart/form-data" method="post" class="stdform" id="page" name="add_data_view" accept-charset="utf-8" action="/superadmin/rolepage/savepage" autocomplete="off">	
					
					<input type="hidden" name="page_id" value="<?php echo $page_id;?>" />
					
						<div class="row">
							<div class="lft_heading">Page Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="name" id="name" class="longinput html_found" value="<?php echo $page['name'];?>" />
								<label class="error1" id="name_err"></label>	
							</div>				
						</div>
						
						<div class="row">
							<div class="lft_heading">Link <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="links" id="links" class="longinput html_found" value="<?php echo $page['link'];?>" />
								<label class="error1" id="links_err"></label>	
							</div>			
						</div>
						
						<div class="row">
							<div class="lft_heading">Is Show Menu <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input type="radio" name="is_show_menu" class="longinput html_found radio"  value="1" <?php if($page['is_show_menu'] == 1) { echo "checked";} ?> />Yes
								<input type="radio" name="is_show_menu" class="longinput html_found radio" value="0" <?php if($page['is_show_menu'] == 0) { echo "checked";} ?>/>No
								<label class="error1" id="is_show_menu_err"></label>	
							</div>			
						</div>
						
						<div class="row">
							<div class="lft_heading">Order <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="order" id="order" class="longinput html_found" value="<?php echo $page['order'];?>" />
								<label class="error1" id="order_err"></label>	
							</div>			
						</div>
					   
						<div class="row">
							<div class="lft_heading">Status<span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="status">
								<option value="1" <?php if($page['status']==1)echo 'selected';?>>Active</option>
								<option value="0" <?php if($page['status']==0)echo 'selected';?>>Inactive</option>
							</select>
							</div>	
						</div>	
						<hr>
						<div class="stdformbutton row" style="text-align:center;">		
						    <a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>			
							<input type="submit"  class="button_grey" name="addedit" id="addedit" value="Submit">
						</div>
						
					</form>
				</div>
			</div><!--contentwrapper-->
		<br clear="all" />
	</div><!-- centercontent -->
</section>


<script>
jQuery(document).ready(function(){
jQuery("#page").validate({
						 
	// Specify the validation rules					
	rules: {
		name:"required",
		links: "required",
		is_show_menu: "required",
		order: "required",
	},
	
	// Specify the validation error messages
	messages: {
		name:"This field is mandatory",
		links: "This field is mandatory",
		is_show_menu: "This field is mandatory",
		order: "This field is mandatory",
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
		if (element.attr("name") == "links" )
			error.appendTo('#links_err');
		if (element.attr("name") == "is_show_menu" )
			error.appendTo('#is_show_menu_err');
		if (element.attr("name") == "order" )
			error.appendTo('#order_err');

	},
	onkeyup: false
	/*,
	onfocusout: false,
	onclick: false
	*/

	
	});
});	
</script>
