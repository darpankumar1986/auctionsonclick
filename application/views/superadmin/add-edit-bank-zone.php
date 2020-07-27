<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.tagsinput.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo VIEWBASE?>css/plugins/jquery.tagsinput.css">
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script>
	jQuery(document).ready(function(){		
		//Examples of how to assign the Colorbox event to elements
		jQuery(".iframe").colorbox({iframe:true, width:"90%", height:"90%"});
	});
</script>
<?php 
if($row){
	
	//print_r($row);
	$zone_id=$row->zone_id;	
	$zone_name=$row->zone_name;		
	$status=$row->status; 
}else{	
	$status = 1;	
	$zone_id = 0;
}
?> 

<section class="body_main1">	
		<div class="row">						
			<a href="<?php echo base_url().'superadmin/bank_zone'?>" class="button_grey"> Zone List</a>
		</div>
		<div class="box-head">Create Zone</div>
		
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form enctype="multipart/form-data" class="stdform"   method="post"  id="zone" name="add_data_view" accept-charset="utf-8" action="/superadmin/bank_zone/save_zone" autocomplete="off">	
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />						
						
						<div class="row">
							<div class="lft_heading">Zone Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input  maxlength="150" type="text" name="zone_name" id="zone_name" class="longinput html_found" value="<?php echo $zone_name; ?>" />
								<label class="error" style="display:none;">Please enter Zone Name</label>
								<?php if(isset($zone_exists)) {?>
							<label class="error" id="cname"><?php echo $zone_exists;?> is already in use</label>	
							<?php }?>	
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
						
						<div class="stdformbutton row" style="text-align:center;">
							<a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>
							<input type="submit"  class="button_grey" name="addedit" value="<?php echo ($zone_id)?'Update':'Submit'?>">
							<input type="hidden" name="zone_id" id="zone_id" value="<?php echo $zone_id?>">
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
	
	
	jQuery("#zone").validate({
		rules: {
			zone_name: {
				required: true,
				
				remote: {
						url: "/superadmin/bank_zone/uniquezone",
						type: "post",
						data: {
							zone_name: function() {
								return jQuery( "#zone_name" ).val();
								jQuery("lavel").text('');
							},					
							zone_id: function() {
								return jQuery( "#zone_id" ).val();
							}
						}
					}		
			}
		},
		messages: {
			zone_name: {
				required: "Please enter account type name",
				remote: jQuery.validator.format("{0} is already in use")
			}			
		},
		submitHandler: function(form) {//return false;						
			if ($(form).valid())
			{						
				form.submit(); 				
			}
			return false;
			
		},
	onkeyup: false
	});
	
	
	
	
});	

</script>
