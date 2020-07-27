<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
	$id=$row->id; 
	$name=$row->name;
$designation=$row->designation;	
	$image=$row->image; 
	$slug=$row->slug; 
	$status=$row->status; 
	$created_by=$row->created_by; 
	$date_created=$row->date_created; 
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
			<form enctype="multipart/form-data" method="post" class="stdform" id="author" name="add_data_view" accept-charset="utf-8" action="/superadmin/author/save">	
				
				<p>
					<label>Name<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="name" id="name" class="longinput" value="<?php echo $name?>" />
					</span>					
				</p>
				<p>
					<label>Designation<font color='red'></font></label>
					<span class="field">
						<input type="text" name="designation" id="designation" class="longinput" value="<?php echo $designation?>" />
					</span>					
				</p>
				<p>
					<label>Image</label>
						<span class="field">
						<input type="file" name="image">(jpg | png | jpeg | gif )
						<input type="hidden" name="image_old" value="<?php echo $image; ?>">
						<?php if($image){?><br><br><img src="<?php echo base_url(); ?>public/uploads/author/<?php echo $image;?>" height="80" width="80" /><?php }?>
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
					<input type="submit"  name="addedit" id="addedit" value="Submit">
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
			name: required,
			image: {
				accept: "png|jp?g|gif"
			},
			priority: {
				number: true
			}
		},
		messages: {
			name: {
				required: "Please enter name",
			},
			image: {
				accept: "Please select a valid image"
			}
		}
	});
});	
</script>
