<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
//print_r($row);die;
if(!empty($row)){
	$id=$row->id; 
	$country=$row->countryID; 
	$state_name=$row->state_name; 
	$status=$row->status; 
}
else{
	$status = 1;
	if(!empty($_POST)) {
		$country=$_POST['country_id']; 
		$state_name=$_POST['name']; 
		$status=$_POST['status']; 
	}
}
?> 



<section class="body_main1">
<div class="centercontent">
	<div class="row">						
			<a href="<?php echo base_url().'superadmin/state/index'?>" class="button_grey"> State List</a>
	</div>
	
	<div class="box-head">Create State</div>
	
	<div class="pageheader">
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
	

    <div id="contentwrapper" class="contentwrapper box-content2">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="state" name="add_data_view" accept-charset="utf-8" action="/superadmin/state/save/<?php if($id) echo $id?>">	
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
			
				<div class="row">
					<div class="lft_heading">Country Name <span class="red"> *</span></div>
					<div class="rgt_detail">
						<select name="country_id" id="country_id">
							<option value="">Select Country</option>
							<?php
							foreach($countries as $country_record){?>
              <option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id==$country)?'selected':''; ?>><?php echo $country_record->country_name; ?></option>
							<?php }?>
						</select>
					</div>					
				</div>
				
				<div class="row">
					<div class="lft_heading">State Name <span class="red"> *</span></div>
					<div class="rgt_detail">
						<input maxlength="50" type="text" name="name" id="name" class="longinput" value="<?php echo $state_name?>" />
						<?php if(isset($state_exists)) {?>
						<label class="error" id="cname"><?php echo $state_exists;?> is already in use</label>
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
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
				</div>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
</section>

<script>
jQuery(document).ready(function(){
	jQuery("#state").validate({
		rules: {
			name: {
				required: true,
				alphanumeric: true,
				remote: {
					url: "/superadmin/state/uniqueState",
					type: "post",
					data: {
						name: function() {
							return jQuery( "#name" ).val();
						},
						country_id: function() {
							return jQuery( "#country_id" ).val();
						},
						id: function() {
							return jQuery( "#id" ).val();
						}
					}
				}
			},		
			country_id: "required"
		},
		messages: {
			name: {
				required: "Please enter state name",
				remote: jQuery.validator.format("{0} is already in use")
			},
			country_id: {
				required: "Please select country"
			}
		}
		
		
	});
		jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\\-\s]+$/i.test(value);
    }, "Name must contain only letters, numbers, or dashes.");
});	
</script>
