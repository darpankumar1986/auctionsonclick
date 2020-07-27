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
	$id=$row->id;		
	$name=$row->name;
	$category_id=explode(',',$row->category_id);	
	$is_display=$row->is_display;
	$priority=$row->priority;
	
	$status=$row->status; 
	$indate = $row->inadate; 
	
	
}else{	
	$status = 0;	
	$id = 0;
}
?> 
<div class="centercontent">
	<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="attribute" name="add_data_view" accept-charset="utf-8" action="/superadmin/attribute_group/save">	
								
				<p>
					<label>Name<font color='red'>*</font></label>
					<span class="field">
						<input maxlength="100" type="text" name="name" id="name" class="longinput" value="<?php echo $name?>" />
						<label class="error" style="display:none;">Please enter Name</label>
					</span>					
				</p>
				
				<p>
					<label>Display<font color='red'>*</font></label>
					<span class="field">
						<select name="is_display" id="is_display">
							<option value="">Select</option>
							<option value="1" <?php echo ($is_display=='1')?'selected':''; ?>>Yes</option>
							<option value="0" <?php echo ($is_display=='0')?'selected':''; ?>>No</option>
						</select>
					</span>					
				</p>
				
				<p>
					<label>Show With<font color='red'>*</font></label>
					<span class="field">
						<select name="category_id[]" id="category_id" multiple>
						<option value="">None</option>
							<?php
							foreach($category as $group_record){?>
              <option value="<?php echo $group_record->id; ?>" <?php echo (in_array($group_record->id,$category_id))?'selected':''; ?>><?php echo $group_record->name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>
				
				<p class="stdformbutton">
					<input type="submit"  name="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->

<script>
jQuery(document).ready(function(){
	jQuery("#attribute").validate({
		rules: {
			name: {
				required: true,
				alphanumeric:true,
			},
			is_display: "required",
			"category_id[]": "required"
		},
		messages: {
			name: {
				required:"Please enter name"	
			},
			is_display: "Please select display",
			"category_id[]": "Please select atleast one category"
		}
	});
	
		jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\\-\s]+$/i.test(value);
    }, "Name must contain only letters, numbers, or dashes.");
	jQuery("#date_published" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '1910:'
	});
	
	jQuery('#country_id').change(function(){
		var country_id = jQuery(this).val();
		if(country_id )
		{
			var state_id = jQuery('#state_id').val();
			jQuery('#state_id').load('/superadmin/bank/getStateDropDown/'+country_id+'/'+state_id);
		}
		
	});	
	jQuery('#state_id').change(function(){
		var state_id = jQuery(this).val();
		if(state_id )
		{
			var city_id = jQuery('#city_id').val();
			jQuery('#city_id').load('/superadmin/bank/getCityDropDown/'+state_id+'/'+city_id);
		}
		
	});


});	

</script>
