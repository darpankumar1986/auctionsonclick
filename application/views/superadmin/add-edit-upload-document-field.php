<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
	$upload_document_field_id = $row->upload_document_field_id; 	
	$upload_document_field_name=$row->upload_document_field_name; 
	$upload_document_field_type =$row->upload_document_field_type;
	$isMandatory =$row->isMandatory;
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
	$upload_document_field_id = 0;
	if(!empty($_POST)) {		
		$upload_document_field_name=$_POST['upload_document_field_name']; 
		$upload_document_field_type=$_POST['upload_document_field_type']; 
		$isMandatory=$_POST['isMandatory']; 
	}
	$status = 1;
}?> 		
<section class="body_main1">	
		<div class="row">		
			<a href="<?php echo base_url().'superadmin/upload_document/index'?>" class="button_grey"> Upload Document Field List</a>
		</div>
		<div class="box-head"><?php echo $heading; ?></div>
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			
			
			
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form method="post" class="stdform" id="category" name="add_data_view" accept-charset="utf-8" action="/superadmin/upload_document/save/<?php if($id) echo $id;?>" autocomplete="off">	
					
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
									
						<div class="row">
							<div class="lft_heading">Upload Document Field Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="upload_document_field_name" id="upload_document_field_name" class="longinput html_found" value="<?php echo $upload_document_field_name?>" />
								
								<?php if(isset($category_exist)) {?>
							<label class="error" id="cname"><?php echo $category_exist;?> is already in use</label>	
							<?php }?>	
							</div>	
											
						</div>
						
						<div class="row">
							<div class="lft_heading">Upload Document Field Type<span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="upload_document_field_type">
								<option value="1" <?php if($upload_document_field_type==1)echo 'selected';?>>Image</option>
								<option value="2" <?php if($upload_document_field_type==2)echo 'selected';?>>Video</option>
							</select>
							</div>	
						</div>	
						<div class="row">
							<div class="lft_heading">Upload Document Field Mandatory<span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="isMandatory">
								<option value="1" <?php if($isMandatory==1)echo 'selected';?>>Yes</option>
								<option value="0" <?php if($isMandatory==0)echo 'selected';?>>No</option>
							</select>
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
							<input type="submit"  class="button_grey" name="addedit" id="addedit" value="<?php echo ($upload_document_field_id)?'Update':'Submit'?>">
							<input type="hidden" name="upload_document_field_id" id="upload_document_field_id" value="<?php echo $upload_document_field_id; ?>">
							
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
			upload_document_field_name: {
				required: true,
				alphanumeric:true,
				remote: {
					url: "/superadmin/upload_document/uniqueUploadDocumentFieldType",
					type: "post",
					data: {
						name: function() {
							return jQuery( "#upload_document_field_name" ).val();
							jQuery("lavel").text('');
						},					
						upload_document_field_id: function() {
							return jQuery( "#upload_document_field_id" ).val();
						}
					}
				}
			}
			
		},
		messages: {			
			upload_document_field_name: {
				required: "Please Enter Upload Document Field Name",
				remote: jQuery.validator.format("{0} is already in use")
			}
		},
		submitHandler: function(form) {//return false;						
		if (jQuery(form).valid())
		{						
			form.submit(); 				
		}
		return false;
		
	},
	onkeyup: false
	});
	
	jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\s]+$/i.test(value);
    }, "Name must contain only letters and numbers.");
});	
</script>
