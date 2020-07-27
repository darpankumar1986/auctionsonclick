<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
	$caste_category_id=$row->caste_category_id; 
	$name=$row->caste_category_name; 	
	$status=$row->status; 	
} else {
	$status = 1;
	$caste_category_id = 0;
	if(!empty($_POST)) {		
		$name=$_POST['caste_category_name']; 
	}
}?> 		
<section class="body_main1">	
		<div class="row">		
			<?php 
				if($type == 'main'){
				?>
					<a href="<?php echo base_url().'superadmin/caste_category/main'?>" class="button_grey">Category List</a>
			<?php
				} else {
			?>
					<a href="<?php echo base_url().'superadmin/caste_category/index'?>" class="button_grey"> 
					Sub Category List</a>
			<?php } ?>
		</div>
		<div class="box-head">
			<?php 
				if($type == 'main'){
				?>
					Category List
			<?php
				} else {
			?>
					
					Create Sub Category
			<?php } ?>
			</div>
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			
			
			
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form enctype="multipart/form-data" method="post" class="stdform" id="category" name="add_data_view" accept-charset="utf-8" action="/superadmin/caste_category/save/<?php if($caste_category_id) echo $caste_category_id;?>" autocomplete="off">	
					
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
								
						<div class="row">
							<div class="lft_heading">Category Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="caste_category_name" id="caste_category_name" class="longinput html_found" value="<?php echo $name?>" />
								
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
							<input type="submit"  class="button_grey" name="addedit" id="addedit" value="<?php echo ($caste_category_id)?'Update':'Submit'?>">
							<input type="hidden" name="caste_category_id" id="caste_category_id" value="<?php echo $caste_category_id?>">
							<input type="hidden" name="menu_item" id="menu_item" value="<?php echo $menu_item?>">							
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
			caste_category_name: {
				required: true,
				alphanumeric:true,
				
				remote: {
					url: "/superadmin/caste_category/uniqueCategory",
					type: "post",
					data: {
						name: function() {
							return jQuery( "#caste_category_name" ).val();
							jQuery("lavel").text('');
						},						
						caste_category_id: function() {
							return jQuery( "#caste_category_id" ).val();
						}
					}
				}
			}
		},
		messages: {			
			name: {
				required: "Please enter category name",
				remote: jQuery.validator.format("{0} is already in use")
			}
		}
	});
	
	jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\\-\s]+$/i.test(value);
    }, "Name must contain only letters, numbers, or dashes.");
});	
</script>
