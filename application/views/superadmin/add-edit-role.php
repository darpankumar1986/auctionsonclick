<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
	$id=$row->id; 
	$name=$row->name; 
	$section=$row->section; 
	$section_value=$row->section_value; 
	$indate=$row->indate; 
	$status=$row->status; 
}
else{
	$status = 1;
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
			<form enctype="multipart/form-data" method="post" class="stdform" id="roleform" name="add_data_view" accept-charset="utf-8" action="/superadmin/role/save">	
				
				<p>
					<label>Name<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="name" id="name" class="longinput" value="<?php echo $name?>" />
					</span>					
				</p>
				
				<p>
					<label>Section<font color='red'>*</font></label>
					<span class="field">
						<select name="section" id="section" 
						>
							<option value="">Select</option>
							<option value="branch" <?php echo ($section=='branch')?'selected':''; ?>>Branch</option>
							<option value="region" <?php echo ($section=='region')?'selected':''; ?>>Region</option>
							<option value="zone" <?php echo ($section=='zone')?'selected':''; ?>>Zone</option>
							<option value="drt" <?php echo ($section=='drt')?'selected':''; ?>>DRT</option>
							<option value="helpdesk" <?php echo ($section=='helpdesk')?'selected':''; ?>>Helpdesk</option>
						</select>
					</span>					
				</p>
				<p>
					<label>User Type<font color='red'>*</font></label>
					<span class="field">
						<select name="section_value" id="section_value" >
							<option value="">Select</option>
							<option value="user" <?php echo ($section_value=='user')?'selected':''; ?>>user</option>
							<option value="view" <?php echo ($section_value=='view')?'selected':''; ?>>view</option>
							
						</select>
					</span>					
				</p>
				<p>
					<label>Status</label>
					<span class="field">
					<select name="status">
						<option value="1" <?php if($status==1)echo 'selected';?>>Active</option>
						<option value="0" <?php if($status==0)echo 'selected';?>>Inactive</option>
					</select>
					</span>
				</p>	
				
				<p class="stdformbutton">					
					<input type="submit"  name="addedit" id="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->

<script>
jQuery(document).ready(function(){
	jQuery("#roleform").validate({
		rules: {
			name: "required",
			section: "required",
			section_value: "required"
		},
		messages: {
			name:  "Please enter name"			
		}
	});
});	
</script>
