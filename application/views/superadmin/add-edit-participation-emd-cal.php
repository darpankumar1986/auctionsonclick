<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
	$participation_emd_id = $row->participation_emd_id; 	
	$min_range=$row->min_range; 
	$participation_fee =$row->participation_fee;
	$emd_fee =$row->emd_fee;
	$status=$row->status; 
	
} else {	
	$participation_emd_id = 0;
	if(!empty($_POST)) {		
		$min_range=$_POST['min_range']; 
		$participation_fee=$_POST['participation_fee']; 
		$emd_fee =$_POST['emd_fee']; 
	}
	$status = 1;
}?> 		
<section class="body_main1">	
		<div class="row">		
			<a href="<?php echo base_url().'superadmin/participation_emd_cal/index'?>" class="button_grey"> Participation Emd Fee List</a>
		</div>
		<div class="box-head"><?php echo $heading; ?></div>
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form method="post" class="stdform" id="category" name="add_data_view" accept-charset="utf-8" action="/superadmin/participation_emd_cal/save/<?php if($participation_emd_id) echo $participation_emd_id;?>" autocomplete="off">	
					
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
									
						<div class="row">
							<div class="lft_heading">Property Minimum Range Value <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="min_range" id="min_range" class="longinput html_found numericonly_1" value="<?php echo $min_range?>" />
								
								<?php if(isset($category_exist)) {?>
							<label class="error" id="cname"><?php echo $category_exist;?> is already in use</label>	
							<?php }?>	
							</div>												
						</div>
						
						<div class="row">
							<div class="lft_heading">Form Fee <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="participation_fee" id="participation_fee" class="longinput html_found numericonly_1" value="<?php echo $participation_fee?>" />
								
								<?php if(isset($category_exist)) {?>
							<label class="error" id="pfee_err"><?php echo $category_exist;?> is already in use</label>	
							<?php }?>	
							</div>												
						</div>
							
						<div class="row">
							<div class="lft_heading">EMD Fee <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="emd_fee" id="emd_fee" class="longinput html_found numericonly_1" value="<?php echo $emd_fee?>" />
								
								<?php if(isset($category_exist)) {?>
							<label class="error" id="efee_err"><?php echo $category_exist;?> is already in use</label>	
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
							<input type="submit"  class="button_grey" name="addedit" id="addedit" value="<?php echo ($participation_emd_id)?'Update':'Submit'?>">
							<input type="hidden" name="participation_emd_id" id="participation_emd_id" value="<?php echo $participation_emd_id; ?>">
							
						</div>
						
					</form>
				</div>
			</div><!--contentwrapper-->
		<br clear="all" />
	</div><!-- centercontent -->
</section>


<script>
jQuery(document).ready(function(){

jQuery(".numericonly_1").keydown(function (e) { 
        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	
jQuery('.html_found').change(function() {
	   if (jQuery(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
		  alert('Invalid html content found');
		  jQuery(this).focus();
		  jQuery(this).val('');
	   }
	});
	
	jQuery("#category").validate({
		rules: {			
			min_range: {
				required: true,
				numberonly:true,
				remote: {
					url: "/superadmin/participation_emd_cal/unique_min_range",
					type: "post",
					data: {
						min_range: function() {
							return jQuery( "#min_range" ).val();
							jQuery("lavel").text('');
						},					
						participation_emd_id: function() {
							return jQuery( "#participation_emd_id" ).val();
						}
					}
				}
			},
			participation_fee: {
				required: true
			},
			emd_fee: {
				required: true
			}
			
		},
		messages: {			
			min_range: {
				required: "This field is mandatory",
				remote: jQuery.validator.format("{0} is already in use")
			},
			participation_fee: {
				required: "This field is mandatory"
			},
			emd_fee: {
				required: "This field is mandatory"
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
	
	jQuery.validator.addMethod("numberonly", function(value, element) {
        return this.optional(element) || /^[0-9]+$/i.test(value);
    }, "Only numbers allowed.");
});	
</script>
