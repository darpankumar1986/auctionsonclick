<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
	$id=$row->id; 
	$name=$row->name; 
	$email=$row->email; 
	$password=$row->password; 
	$role = $row->role;
	$indate=$row->indate; 
	$status=$row->status; 
	$created_by=$row->created_by; 
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
			<form enctype="multipart/form-data" method="post" id="category" class="stdform"  name="category"   accept-charset="utf-8" action="/admin/admin/save">	
				
				<p>
					<label>Name<font color='red'>*</font></label>
					<span class="field">
						<input maxlength="100" type="text" name="name" id="name" class="longinput" value="<?php echo $name?>" />
					</span>					
				</p>
				
				<p>
					<label>Email<font color='red'>*</font></label>
					<span class="field">
						<input maxlength="100" type="text" name="email" id="email" class="longinput" value="<?php echo $email?>" />
					</span>
				</p>
				
				<p>
					<label>Password<font color='red'>*</font></label>
					<span class="field">
						<input maxlength="100" type="password" name="password" id="password" class="longinput" value="<?php echo $password?>" />
					</span>
				</p>
				
				<p>
					<label>Role<font color='red'>*</font></label>
					<span class="field">
						<select name="role" id="role">
							<option value="">Select Role</option>
							<?php foreach($roles as $role1){?>
              <option value="<?php echo $role1->id; ?>" <?php echo ($role1->id == $role)?'selected':''; ?>><?php echo $role1->name; ?></option>
							<?php }?>
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
	
	jQuery("#category").validate({
		rules: {
				name: "required",
			email: {
				required: true,
				email: true
			},
			password: "required",
			role: "required"
		},
		messages: {
			
			name: {
				required: "Please enter name",
			},
			email: {
				required: "Please enter email",
				email: "Please enter valid email"
			},
			password: {
				required: "Please enter password"
			},
			role:{
				required:"Please select role"
			}
		}
	});
});	
</script>