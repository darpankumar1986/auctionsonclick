<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
	$uom_id=$row->uom_id; 
	
	$uom_name=$row->uom_name; 
	$status=$row->status; 
	//remove id from slug
	//$slug=$row->slug; 
	/*$slug=explode('-',$row->slug);
	array_pop($slug);
	$slug=implode('-',$slug);
	//remove id from slug 
	$priority=$row->priority;
	$show_home=$row->show_home;
	$menu_item=$row->menu_item;
	$status=$row->status; 
	$meta_title=$row->meta_title; 
	$meta_description=$row->meta_description; 
	$meta_keywords=$row->meta_keywords; 
	$created_by=$row->created_by; 
	$date_created=$row->date_created; 
	$date_modified=$row->date_modified; */
} else {
	$status = 1;
	$uom_id = 0;
	if(!empty($_POST)) {		
		$uom_name=$_POST['uom_name']; 
	}
}?> 		
<section class="body_main1">	
		<div class="row">		
			<a href="<?php echo base_url().'superadmin/uom_type/index'?>" class="button_grey">Carpet UOM Type List</a>
		</div>
		<div class="box-head">Create Carpet UOM Type</div>
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			
			
			
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form method="post" class="stdform" id="category" name="add_data_view" accept-charset="utf-8" action="/superadmin/uom_type/save/<?php if($id) echo $id;?>" autocomplete="off">	
					
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
									
						<div class="row">
							<div class="lft_heading">UOM Type Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="uom_name" id="uom_name" class="longinput html_found" value="<?php echo $uom_name?>" />
								
								<?php if(isset($category_exist)) {?>
							<label class="error" id="cname"><?php echo $category_exist;?> is already in use</label>	
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
						<hr>
						<div class="stdformbutton row" style="text-align:center;">		
						    <a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>			
							<input type="submit"  class="button_grey" name="addedit" id="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
							<input type="hidden" name="uom_id" id="uom_id" value="<?php echo $uom_id?>">
							
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
	
	jQuery("#category").validate({
		rules: {			
			uom_name: {
				required: true,
				alphanumeric:true,
				
				remote: {
					url: "/superadmin/uom_type/uniqueuomType",
					type: "post",
					data: {
						name: function() {
							return jQuery( "#uom_name" ).val();
							jQuery("lavel").text('');
						},					
						uom_id: function() {
							return jQuery( "#uom_id" ).val();
						}
					}
				}
			}
		},
		messages: {			
			uom_name: {
				required: "Please enter uom type name",
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
	
	jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\\-\s\.]+$/i.test(value);
    }, "Name must contain only letters, numbers, or dashes.");
});	
</script>
