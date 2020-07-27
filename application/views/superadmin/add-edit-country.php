<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
	$id=$row->id; 
	$country_name=$row->country_name; 
	$indate=$row->indate; 
	$status=$row->status; 
}
else{
	$status = 1;
	$id = 0;
	extract($_POST);
}
?>



<section class="body_main1">
<div class="centercontent">
	<div class="row">						
			<a href="<?php echo base_url().'superadmin/country/index'?>" class="button_grey"> Country List</a>
	</div>
	
	<div class="box-head">Create Country</div>
	
	<div class="pageheader">
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
	

    <div id="contentwrapper" class="contentwrapper box-content2">
		<div id="validation" class="subcontent">            	
		<form enctype="multipart/form-data" method="post" class="stdform" id="country" name="add_data_view" accept-charset="utf-8" action="/superadmin/country/save/<?php if($id) echo $id?>">	
				
			
				<div class="row">
					<div class="lft_heading">Country Name <span class="red"> *</span></div>
					<div class="rgt_detail">
						<input type="text" maxlength="50" name="country_name" id="country_name" class="longinput" value="<?php echo $country_name?>" />
						<?php if(isset($country_exists)) {?>
						<label class="error" id="cname"><?php echo $country_exists;?> is already in use</label>
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
					<input type="submit"  name="addedit" id="addedit" value="<?php echo ($id)?'Update':'Submit'?>" class="button_grey">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
				</div>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
</section>


<script>

	jQuery("#country").validate({
		rules: {
			
			country_name: {
				required:true,
				alphanumeric:true,
				remote: {
						    url: "/superadmin/country/uniqueCountry",
						    type: "post",
						    data: {
							    name: function() {
								    return jQuery( "#country_name" ).val();
							    },
							    id: function() {
								    return jQuery( "#id" ).val();
							    }
						    }
					    }
			    },
		},
		messages: {
			country_name: {
				required: "Please enter country name",
				remote: jQuery.validator.format("{0} is already in use")
			}
		}
		
		
	});
		jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\\-\s]+$/i.test(value);
    }, "Name must contain only letters, numbers, or dashes.");
	
</script>
