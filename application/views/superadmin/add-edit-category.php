<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
	$id=$row->id; 
	$parent_id=$row->parent_id; 
	$name=$row->name; 
	$image=$row->image; 
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
	$id = 0;
	if(!empty($_POST)) {
		$parent_id=$_POST['parent_id']; 
		$name=$_POST['name']; 
	}
}?> 		
<section class="body_main1">	
		<div class="row">		
			<?php 
				if($type == 'main'){
				?>
					<a href="<?php echo base_url().'superadmin/category/main'?>" class="button_grey"> Property Type List</a>
			<?php
				} else {
			?>
					<a href="<?php echo base_url().'superadmin/category/index'?>" class="button_grey"> 
					Sub Category List</a>
			<?php } ?>
		</div>
		<div class="box-head">
			<?php 
				if($type == 'main'){
				?>
					Create Property Type
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
					<form enctype="multipart/form-data" method="post" class="stdform" id="category" name="add_data_view" accept-charset="utf-8" action="/superadmin/category/save/<?php if($id) echo $id;?>" autocomplete="off">	
					
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
					
					<?php 
						if($type == 'main'){
						?>
						<input type="hidden" name="parent_id" id="parent_id" value="0">
						<?php
						} else {
					?>
						<div class="row">
							<div class="lft_heading">Parent<span class="red"> *</span></div>
							<div class="rgt_detail">
								<select name="parent_id" id="parent_id">
									<option value="">Select Parent Category</option>
									<?php
										foreach($category as $cat){
											
											if($parent_id==$cat->id)$selected='selected="selected"';
											else $selected='';
											
											?>
											<option value="<?php echo $cat->id; ?>" <?php echo $selected ?>><?php echo $cat->name; ?></option>
											<?php
										}?>
								</select>
							</div>				
						</div>
						<?php }?>
						<div class="row">
							<div class="lft_heading">Property Type Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="name" id="name" class="longinput html_found" value="<?php echo $name?>" />
								
								<?php if(isset($category_exist)) {?>
							<label class="error" id="cname"><?php echo $category_exist;?> is already in use</label>	
							<?php }?>	
							</div>	
											
						</div>
						
					    <?php /* ?>
						<p>
							<label>Image</label>
								<span class="field">
								<input type="file" name="image">(jpg | png | jpeg | gif )
								<input type="hidden" name="image_old" value="<?php echo $image; ?>">
								<?php if($image){?><br><br><img src="<?php echo base_url(); ?>public/uploads/category/<?php echo $image;?>" height="80" width="80" /><?php }?>
							</span>
						</p>
						<?php */ ?>
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
							<input type="hidden" name="id" id="id" value="<?php echo $id?>">
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
			parent_id: "required",
			name: {
				required: true,
				alphanumeric:true,
				
				remote: {
					url: "/superadmin/category/uniqueCategory",
					type: "post",
					data: {
						name: function() {
							return jQuery( "#name" ).val();
							jQuery("lavel").text('');
						},
						parent_id: function() {
							return jQuery( "#parent_id" ).val();
						},
						id: function() {
							return jQuery( "#id" ).val();
						}
					}
				}
			},
			image: {
				accept: "png|jpg|gif"
			}
		},
		messages: {
			parent_id: "Please select parent category name",
			name: {
				required: "Please enter category name",
				remote: jQuery.validator.format("{0} is already in use")
			},
			image: {
				accept: "Please select a valid image"
			}
		}
	});
	
	jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\\-\s]+$/i.test(value);
    }, "Name must contain only letters, numbers, or dashes.");
});	
</script>
