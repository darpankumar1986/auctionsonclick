<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/common.js"></script>
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
	function fieldDisplayHide(type)
	{
			if(type=='text')
			{
				jQuery('.actionBar').hide();
				jQuery('#for_text_field_length').show();
				jQuery('#for_text_placeholder').show();
				jQuery('#for_text_type').show();
				
			}
			else if(type=='textarea')
			{
				jQuery('.actionBar').hide();
				jQuery('#for_text_field_length').hide();
				jQuery('#for_text_placeholder').hide();
				jQuery('#for_text_type').hide();
			}
			else
			{
				jQuery('.actionBar').show();
				jQuery('#for_text_field_length').hide();
				jQuery('#for_text_placeholder').hide();
				jQuery('#for_text_type').hide();
				
			}
	}
</script>
<?php 
if($row){
	$id=$row->id;	
	$group_id=$row->group_id;	
	$icon=$row->icon;	
	$is_show_on_strip=$row->is_show_on_strip;	
	$name=$row->name;	
	$type=$row->type;	
	$element=$row->element;	
	$elements=explode(',',$element);
	$is_mandatory=$row->is_mandatory;
	$is_mandatory_auction=$row->is_mandatory_auction;
	$field_length=$row->field_length;
	$data_type=$row->data_type;
	$placeholder=$row->placeholder;
	$validation_message=$row->validation_message;
	$is_auction=$row->is_auction;
	$is_bank=$row->is_bank;
	$is_sell=$row->is_sell;
	$status=$row->status; 
	$indate = $row->inadate; 
	$priority = $row->priority; 
	
	
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
			<form enctype="multipart/form-data" method="post" class="stdform" id="attribute" name="add_data_view" accept-charset="utf-8" action="/superadmin/attribute/save">	
				
				<p>
					<label>Attribute Group<font color='red'>*</font></label>
					<span class="field">
						<select name="group_id" id="group_id">
							<option value="">Select</option>
							<?php
							foreach($groups as $group_record){?>
              <option value="<?php echo $group_record->id; ?>" <?php echo ($group_record->id==$group_id)?'selected':''; ?>><?php echo $group_record->name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>				
				<p>
					<label>Name<font color='red'>*</font></label>
					<span class="field">
						<input maxlength="100" type="text" name="name" id="name" class="longinput" value="<?php echo $name?>" />
						<label class="error" style="display:none;">Please enter Name</label>
					</span>					
				</p>				
				
				<p>
					<label>Type<font color='red'>*</font></label>
					<span class="field">
						<select name="type" id="type" onchange="fieldDisplayHide(jQuery(this).val());">
							<option value="">-- Select --</option>
							<option value="text" <?php echo ($type=='text')?'selected':''; ?>>Textbox</option>
							<option value="textarea" <?php echo ($type=='textarea')?'selected':''; ?>>Textarea</option>
							<option value="selectbox" <?php echo ($type=='selectbox')?'selected':''; ?>>selectbox</option>
							<option value="checkbox" <?php echo ($type=='checkbox')?'selected':''; ?>>Checkbox</option>
							<option value="radio" <?php echo ($type=='radio')?'selected':''; ?>>Radio</option>
						</select>
					</span>					
				</p>
				<p>
					<label>Icon</label>
					<span class="field">
						<input type="file" onchange="adminImageValidate('icon','50','kb');" name="icon" id="icon" class="longinput" />
						<?php if($icon!=''){ ?>
						<img style="background-color:gray;" src="/public/uploads/attribute/<?php echo $icon ;?>" width="50" >
						<input type="hidden" name="icon_old" value="<?php echo $icon ;?>">
						<?php } ?>
						<label for="icon" id="iconerrID" class="error" style="display:none;">Image size is greater than 50 kb</label>
					</span>					
				</p>
				<p>
				
				
				<label>Show On Strip</label>
					<span class="field">
						<select name="is_show_on_strip" id="is_show_on_strip">
							<option <?php echo ($is_show_on_strip=='0')?'selected':''; ?> value="0">No</option>
							<option value="1" <?php echo ($is_show_on_strip=='1')?'selected':''; ?> value="1" >Yes</option>
						</select>
					</span>					
				</p>
				<p>
					<label>Priority</label>
					<span class="field">
						<input onkeypress="return isNumberKey(event);" maxlength="2" type="text" name="priority" id="priority" class="longinput" value="<?php echo $priority?>" />
						<label class="error" style="display:none;"></label>
					</span>					
				</p>
				<div class="actionBar" style="display:none">
				
				<?php if($id){foreach($elements as $element){?>
				<div class="step_max" >
				<p>
					<label>Element</label>
					<span class="field">
						<input type="text" name="element[]" id="element_1" class="longinput" value="<?php echo $element?>" />
						<label class="error" style="display:none;">Please enter element</label>
					</span>					
				</p>
				</div>
				<?php }}else{?>
				<div class="step_max" >
				<p>
					<label>Element</label>
					<span class="field">
						<input type="text" name="element[]" id="element_1" class="longinput" value="<?php echo $element?>" />
						<label class="error" style="display:none;">Please enter element</label>
					</span>					
				</p>
				</div>
				<?php }?>
				
				
					<a class="buttonNext addMore" href="#" id="AddMoreFileBox">Click To Add</a>
					
				</div>
				
				
				<p>
					<h4>For Validation</h4>
									
				</p>
				
				<p>
					<label>Is Mandatory</label>
					<span class="field">
						<select name="is_mandatory" id="is_mandatory">
							<option value="">Select</option>
							<option value="1" <?php echo ($is_mandatory=='1')?'selected':''; ?>>Yes</option>
							<option value="0" <?php echo ($is_mandatory=='0')?'selected':''; ?>>No</option>
						</select>
					</span>					
				</p>
				<p>
					<label>Mandatory For Auction</label>
					<span class="field">
						<select name="is_mandatory_auction" id="is_mandatory_auction">
							<option value="">Select</option>
							<option value="1" <?php echo ($is_mandatory_auction=='1')?'selected':''; ?>>Yes</option>
							<option value="0" <?php echo ($is_mandatory_auction=='0')?'selected':''; ?>>No</option>
						</select>
					</span>					
				</p>
				<p id="for_text_field_length"  style="display:none">
					<label>Field Length</label>
					<span class="field">
						<input type="text" name="field_length" id="field_length" class="longinput" value="<?php echo $field_length?>" />
						<label class="error" style="display:none;">Please enter Field Length</label>
					</span>					
				</p>
				
				<p id="for_text_type" style="display:none">
					<label>Data Type</label>
					<span class="field">
						<select name="data_type" id="data_type">
							<option value="">Select</option>
							<option value="numeric" <?php echo ($data_type=='numeric')?'selected':''; ?>>Numeric</option>
							<option value="alphanumeric" <?php echo ($data_type=='alphanumeric')?'selected':''; ?>>Alphanumeric</option>
						</select>
					</span>					
				</p>
				<p id="for_text_placeholder" style="display:none">
					<label>Placeholder</label>
					<span class="field">
						<input maxlength="50" type="text" name="placeholder" id="placeholder" class="longinput" value="<?php echo $placeholder?>" />
						<label class="error" style="display:none;">Please enter url</label>
					
				<p>
					<label>Validation Message</label>
					<span class="field">
						<input maxlength="200" type="text" name="validation_message" id="validation_message" class="longinput" value="<?php echo $validation_message?>" />
					</span>					
				</p>
				<p>
					<h4>Show With</h4>
									
				</p>
				<p>
					<label>Auction/Non-Auction</label>
					<span class="field">
						<select name="is_auction" id="is_auction">
							<option value="both" <?php echo ($is_auction=='both')?'selected':''; ?>>Both</option>
							<option value="auction" <?php echo ($is_auction=='auction')?'selected':''; ?>>auction</option>
							<option value="non-auction" <?php echo ($is_auction=='non-auction')?'selected':''; ?>>Non Auction</option>							
						</select>
					</span>					
				</p>
				<p>
					<label>Bank/Non-Bank</label>
					<span class="field">
						<select name="is_bank" id="is_bank">
							<option value="both" <?php echo ($is_bank=='both')?'selected':''; ?>>Both</option>
							<option value="bank" <?php echo ($is_bank=='bank')?'selected':''; ?>>Bank</option>
							<option value="non-bank" <?php echo ($is_bank=='non-bank')?'selected':''; ?>>Non-Bank</option>
							
						</select>
					</span>					
				</p>
				<p>
					<label>Sell/Rent</label>
					<span class="field">
						<select name="is_sell" id="is_sell">
							<option value="both" <?php echo ($is_sell=='both')?'selected':''; ?>>Both</option>
							<option value="sell" <?php echo ($is_sell=='sell')?'selected':''; ?>>Sell</option>
							<option value="rent" <?php echo ($is_sell=='rent')?'selected':''; ?>>Rent</option>
							
						</select>
					</span>					
				</p>
				<p class="stdformbutton">
					<input type="submit"  name="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					<input type="hidden" name="optcount" id="optcount" value="1">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
<?php if($id){?>
<script>fieldDisplayHide('<?php echo trim($type)?>')</script>
<?php }?>
<script>
jQuery(document).ready(function(){
	jQuery("#attribute").validate({
		rules: {
			name: {
				required: true,
				alphanumeric:true,
			},
			//icon: "required",
			group_id: "required",
			type: "required"
		},
		messages: {
			name: {
				required:"Please enter name"	
			},
			group_id: "Please select group",
			type: "Please select field type"
			
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


	jQuery('.addMore').click(function(){
		var currentCount =  jQuery('.step_max').length;
		if(jQuery('#element_'+currentCount).val() != ''){
			var newCount = currentCount+1;
			var lastRepeatingGroup = jQuery('.step_max').last();
			var newSection = lastRepeatingGroup.clone();
			newSection.insertAfter(lastRepeatingGroup);
			newSection.find("input").each(function (index, input) {
				input.id = input.id.replace("_" + currentCount, "_" + newCount);
				input.name = input.name.replace("_" + currentCount, "_" + newCount);
				input.value='';
			});
			newSection.find("select").each(function (index, input) {
				input.id = input.id.replace("_" + currentCount, "_" + newCount);
				input.name = input.name.replace("_" + currentCount, "_" + newCount);
			});
			jQuery('#optcount').val(newCount);
			return false;
		}
		else {alert('Current Element is empty.');}

	});
	
	
	
	
});	



function adminImageValidate(field_name,sizelimit,limittype) {
	var file_size = jQuery('#'+field_name)[0].files[0].size;
	//alert(file_size);
	if(limittype!=''){
		slimit=1024*sizelimit;	
	}else{
		slimit=(1024*1024)*parseInt(sizelimit);	
	}
	
	if(file_size>slimit){
		//$("#file_error").html("File size is greater than 2MB");
		jQuery("#"+field_name).val('');
		//jQuery("<div class='error error'"+field_name+"' style='color:red;'>Images size is greater then "+sizelimit+"kb.</div>" ).insertAfter("#"+field_name);
		jQuery("#iconerrID").show();
		return false;
	}else{
		jQuery( ".error"+field_name).remove();
		jQuery("#iconerrID").hide();
		return true;
	} 
}


</script>
